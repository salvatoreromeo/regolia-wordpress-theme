#!/usr/bin/env node
// Import Markdown posts (from ./content) into a WordPress site as DRAFTS.
//
// Requires Application Password (Users → Profile → Application Passwords).
//
// Usage:
//   WP_URL=https://regolia.it WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" node import.mjs
//   WP_URL=... WP_USER=... WP_APP_PASSWORD=... node import.mjs --force
//
// By default posts with an existing slug are skipped. Use --force to replace
// (content, title, excerpt, featured image) without changing post status.

import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import matter from 'gray-matter';

import { createClient } from './lib/wp-api.mjs';
import { markdownToHtml } from './lib/md-to-html.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

function parseArgs(argv) {
  const args = { dir: './content', force: false, dryRun: false };
  for (let i = 2; i < argv.length; i++) {
    const a = argv[i];
    if (a === '--dir') args.dir = argv[++i];
    else if (a === '--force') args.force = true;
    else if (a === '--dry-run') args.dryRun = true;
    else if (a === '--help' || a === '-h') args.help = true;
  }
  return args;
}

function mimeFromExt(filename) {
  const ext = path.extname(filename).toLowerCase().replace('.', '');
  return {
    jpg: 'image/jpeg',
    jpeg: 'image/jpeg',
    png: 'image/png',
    webp: 'image/webp',
    gif: 'image/gif',
  }[ext] || 'application/octet-stream';
}

async function ensureTerms(client, names, kind) {
  if (!names || !names.length) return [];
  const existing = kind === 'category'
    ? await client.listCategories()
    : await client.listTags();
  const byName = new Map(existing.map((t) => [t.name.toLowerCase(), t.id]));
  const ids = [];
  for (const name of names) {
    const key = name.toLowerCase();
    if (byName.has(key)) {
      ids.push(byName.get(key));
    } else {
      const created = kind === 'category'
        ? await client.createCategory(name)
        : await client.createTag(name);
      ids.push(created.id);
      byName.set(key, created.id);
      console.log(`    + created ${kind}: ${name} (#${created.id})`);
    }
  }
  return ids;
}

async function main() {
  const args = parseArgs(process.argv);
  if (args.help) {
    console.log('Usage: WP_URL=<url> WP_USER=<user> WP_APP_PASSWORD=<pwd> node import.mjs [--dir ./content] [--force] [--dry-run]');
    process.exit(0);
  }

  const baseUrl = process.env.WP_URL;
  const user = process.env.WP_USER;
  const password = process.env.WP_APP_PASSWORD;
  if (!baseUrl || !user || !password) {
    console.error('Missing WP_URL, WP_USER or WP_APP_PASSWORD env var.');
    process.exit(1);
  }

  const contentDir = path.resolve(__dirname, args.dir);
  const entries = await fs.readdir(contentDir);
  const mdFiles = entries.filter((f) => f.endsWith('.md')).sort();
  if (!mdFiles.length) {
    console.error(`No .md files in ${contentDir}`);
    process.exit(1);
  }

  const client = createClient({ baseUrl, user, password });

  console.log(`→ Importing ${mdFiles.length} posts into ${baseUrl}${args.dryRun ? ' (dry run)' : ''}`);

  let created = 0;
  let updated = 0;
  let skipped = 0;

  for (const file of mdFiles) {
    const raw = await fs.readFile(path.join(contentDir, file), 'utf8');
    const parsed = matter(raw);
    const fm = parsed.data || {};
    const slug = fm.slug || path.basename(file, '.md');
    const title = fm.title || slug;

    const existing = await client.findPostBySlug(slug);
    if (existing && !args.force) {
      console.log(`  • ${slug} — exists (#${existing.id}), skipping`);
      skipped++;
      continue;
    }

    const contentHtml = markdownToHtml(parsed.content);

    let featuredMediaId = null;
    if (fm.featured_image) {
      const imgPath = path.join(contentDir, fm.featured_image);
      try {
        const buf = await fs.readFile(imgPath);
        if (!args.dryRun) {
          const media = await client.uploadMedia({
            filename: fm.featured_image,
            contentType: mimeFromExt(fm.featured_image),
            data: buf,
            title: `${title} — cover`,
            altText: title,
          });
          featuredMediaId = media.id;
          console.log(`    ↑ uploaded cover (attach #${featuredMediaId})`);
        }
      } catch (e) {
        console.warn(`    ⚠ cover upload failed for ${slug}: ${e.message}`);
      }
    }

    const categoryIds = args.dryRun ? [] : await ensureTerms(client, fm.categories, 'category');
    const tagIds = args.dryRun ? [] : await ensureTerms(client, fm.tags, 'tag');

    const payload = {
      title,
      slug,
      content: contentHtml,
      excerpt: fm.excerpt || '',
      status: 'draft',
    };
    if (featuredMediaId) payload.featured_media = featuredMediaId;
    if (categoryIds.length) payload.categories = categoryIds;
    if (tagIds.length) payload.tags = tagIds;

    if (args.dryRun) {
      console.log(`  • ${slug} — would ${existing ? 'update' : 'create'}`);
      continue;
    }

    if (existing && args.force) {
      // Preserve existing status instead of forcing draft
      delete payload.status;
      await client.updatePost(existing.id, payload);
      console.log(`  ↻ ${slug} — updated (#${existing.id})`);
      updated++;
    } else {
      const post = await client.createPost(payload);
      console.log(`  + ${slug} — created draft (#${post.id})`);
      created++;
    }
  }

  console.log(`\nDone. created=${created} updated=${updated} skipped=${skipped}`);
}

main().catch((e) => {
  console.error(`Error: ${e.message}`);
  if (e.data) console.error(JSON.stringify(e.data, null, 2));
  process.exit(1);
});
