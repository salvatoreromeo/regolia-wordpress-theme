#!/usr/bin/env node
// Export posts and/or pages from a WordPress site into Markdown + images.
//
// Usage:
//   WP_URL=http://localhost:8090 node export.mjs                 # posts (default)
//   WP_URL=http://localhost:8090 node export.mjs --type pages    # pages
//   WP_URL=http://localhost:8090 node export.mjs --type all      # both
//   WP_URL=http://localhost:8090 node export.mjs --include-drafts
//
// Content is written to `./content/<type>/` where <type> is `posts` or `pages`.

import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import matter from 'gray-matter';

import { createClient, SUPPORTED_TYPES } from './lib/wp-api.mjs';
import { htmlToMarkdown } from './lib/html-to-md.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

function parseArgs(argv) {
  const args = { out: './content', includeDrafts: false, types: ['posts'] };
  for (let i = 2; i < argv.length; i++) {
    const a = argv[i];
    if (a === '--out') args.out = argv[++i];
    else if (a === '--include-drafts') args.includeDrafts = true;
    else if (a === '--type') {
      const v = argv[++i];
      if (v === 'all') args.types = [...SUPPORTED_TYPES];
      else args.types = [v];
    }
    else if (a === '--help' || a === '-h') args.help = true;
  }
  return args;
}

function cleanFilename(slug) {
  return slug.replace(/[^a-z0-9-]/gi, '').toLowerCase();
}

function extFromMime(mime) {
  if (!mime) return 'bin';
  if (mime.includes('jpeg')) return 'jpg';
  if (mime.includes('png')) return 'png';
  if (mime.includes('webp')) return 'webp';
  if (mime.includes('gif')) return 'gif';
  return mime.split('/')[1] || 'bin';
}

function decodeEntities(s) {
  if (!s) return s;
  return s
    .replace(/&#8217;/g, '’')
    .replace(/&#8220;/g, '“')
    .replace(/&#8221;/g, '”')
    .replace(/&#8230;/g, '…')
    .replace(/&hellip;/g, '…')
    .replace(/&amp;/g, '&')
    .replace(/&nbsp;/g, ' ')
    .trim();
}

async function exportType({ client, type, outDir, includeDrafts }) {
  console.log(`\n→ Fetching ${type} …`);
  const items = await client.getItems(type, { perPage: 100, embed: true });
  const visible = includeDrafts ? items : items.filter((p) => p.status === 'publish');
  console.log(`  ${visible.length} ${type} to export (of ${items.length} total)`);

  // Build slug map for pages so we can resolve parent IDs → parent slugs
  const slugById = new Map();
  if (type === 'pages') {
    for (const p of items) slugById.set(p.id, p.slug);
  }

  let count = 0;
  for (const post of visible) {
    const slug = post.slug || `item-${post.id}`;
    const title = decodeEntities(post.title?.rendered || slug);
    const excerptHtml = post.excerpt?.rendered || '';
    const excerpt = decodeEntities(excerptHtml.replace(/<[^>]+>/g, ''));
    const contentHtml = post.content?.rendered || '';
    const bodyMd = htmlToMarkdown(contentHtml);

    // Categories and tags (posts only)
    const embeddedTerms = post._embedded?.['wp:term'] || [];
    const flatTerms = embeddedTerms.flat();
    const categories = flatTerms
      .filter((t) => t.taxonomy === 'category')
      .map((t) => decodeEntities(t.name));
    const tags = flatTerms
      .filter((t) => t.taxonomy === 'post_tag')
      .map((t) => decodeEntities(t.name));

    // Featured image
    let featuredImageFile = null;
    const media = post._embedded?.['wp:featuredmedia']?.[0];
    if (media && media.source_url) {
      try {
        const res = await fetch(media.source_url);
        if (res.ok) {
          const buf = Buffer.from(await res.arrayBuffer());
          const mime = res.headers.get('content-type') || media.mime_type;
          const ext = extFromMime(mime);
          const filename = `${cleanFilename(slug)}.${ext}`;
          await fs.writeFile(path.join(outDir, filename), buf);
          featuredImageFile = filename;
        } else {
          console.warn(`  ⚠ ${slug}: featured image ${res.status}`);
        }
      } catch (e) {
        console.warn(`  ⚠ ${slug}: failed to download image — ${e.message}`);
      }
    }

    const frontmatter = {
      title,
      slug,
      date: post.date_gmt ? `${post.date_gmt}Z` : undefined,
      status: post.status,
      excerpt: excerpt || undefined,
      featured_image: featuredImageFile || undefined,
    };

    if (type === 'posts') {
      if (categories.length) frontmatter.categories = categories;
      if (tags.length) frontmatter.tags = tags;
    }

    if (type === 'pages') {
      if (post.template) frontmatter.template = post.template;
      if (post.menu_order) frontmatter.menu_order = post.menu_order;
      if (post.parent) {
        const parentSlug = slugById.get(post.parent);
        if (parentSlug) frontmatter.parent_slug = parentSlug;
      }
    }

    // Remove undefined keys before serialization
    for (const k of Object.keys(frontmatter)) {
      if (frontmatter[k] === undefined) delete frontmatter[k];
    }

    const mdPath = path.join(outDir, `${cleanFilename(slug)}.md`);
    const serialized = matter.stringify(bodyMd, frontmatter);
    await fs.writeFile(mdPath, serialized);
    count++;
    console.log(`  ✓ ${slug}${featuredImageFile ? ' + image' : ''}`);
  }

  console.log(`  Done. ${count} ${type} exported to ${outDir}`);
  return count;
}

async function main() {
  const args = parseArgs(process.argv);
  if (args.help) {
    console.log('Usage: WP_URL=<url> node export.mjs [--type posts|pages|all] [--out ./content] [--include-drafts]');
    process.exit(0);
  }

  const baseUrl = process.env.WP_URL;
  if (!baseUrl) {
    console.error('Missing WP_URL env var (e.g. WP_URL=http://localhost:8090)');
    process.exit(1);
  }

  const baseOut = path.resolve(__dirname, args.out);
  const client = createClient({
    baseUrl,
    user: process.env.WP_USER,
    password: process.env.WP_APP_PASSWORD,
  });

  console.log(`Exporting from ${baseUrl} (types: ${args.types.join(', ')})`);

  let total = 0;
  for (const type of args.types) {
    const typeDir = path.join(baseOut, type);
    await fs.mkdir(typeDir, { recursive: true });
    total += await exportType({
      client,
      type,
      outDir: typeDir,
      includeDrafts: args.includeDrafts,
    });
  }

  console.log(`\nAll done. ${total} items total.`);
}

main().catch((e) => {
  console.error(`Error: ${e.message}`);
  if (e.data) console.error(JSON.stringify(e.data, null, 2));
  process.exit(1);
});
