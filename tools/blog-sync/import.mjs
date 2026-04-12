#!/usr/bin/env node
// Import Markdown content (posts and/or pages) into a WordPress site as DRAFTS.
//
// Requires a WordPress Application Password (Users → Profile → Application
// Passwords) on the target site.
//
// Usage:
//   WP_URL=https://regolia.it WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" node import.mjs
//   ... node import.mjs --type pages
//   ... node import.mjs --type all --force
//   ... node import.mjs --dry-run
//
// By default items with an existing slug are skipped. Use --force to replace
// (title, content, excerpt, featured image) without changing status.

import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import matter from 'gray-matter';

import { createClient, SUPPORTED_TYPES } from './lib/wp-api.mjs';
import { markdownToHtml } from './lib/md-to-html.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

function parseArgs(argv) {
  const args = { dir: './content', force: false, dryRun: false, types: ['posts'] };
  for (let i = 2; i < argv.length; i++) {
    const a = argv[i];
    if (a === '--dir') args.dir = argv[++i];
    else if (a === '--force') args.force = true;
    else if (a === '--dry-run') args.dryRun = true;
    else if (a === '--type') {
      const v = argv[++i];
      if (v === 'all') args.types = [...SUPPORTED_TYPES];
      else args.types = [v];
    }
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

async function resolveParent(client, parentSlug) {
  if (!parentSlug) return null;
  const parent = await client.findItemBySlug('pages', parentSlug);
  return parent ? parent.id : null;
}

async function importType({ client, type, dir, force, dryRun }) {
  let entries;
  try {
    entries = await fs.readdir(dir);
  } catch {
    console.log(`\n→ ${type}: ${dir} not found, skipping`);
    return { created: 0, updated: 0, skipped: 0 };
  }
  const mdFiles = entries.filter((f) => f.endsWith('.md')).sort();
  if (!mdFiles.length) {
    console.log(`\n→ ${type}: no .md files in ${dir}`);
    return { created: 0, updated: 0, skipped: 0 };
  }

  console.log(`\n→ Importing ${mdFiles.length} ${type} from ${dir}${dryRun ? ' (dry run)' : ''}`);

  let created = 0;
  let updated = 0;
  let skipped = 0;

  for (const file of mdFiles) {
    const raw = await fs.readFile(path.join(dir, file), 'utf8');
    const parsed = matter(raw);
    const fm = parsed.data || {};
    const slug = fm.slug || path.basename(file, '.md');
    const title = fm.title || slug;

    const existing = await client.findItemBySlug(type, slug);
    if (existing && !force) {
      console.log(`  • ${slug} — exists (#${existing.id}), skipping`);
      skipped++;
      continue;
    }

    const contentHtml = markdownToHtml(parsed.content);

    let featuredMediaId = null;
    if (fm.featured_image) {
      const imgPath = path.join(dir, fm.featured_image);
      try {
        const buf = await fs.readFile(imgPath);
        if (!dryRun) {
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

    const payload = {
      title,
      slug,
      content: contentHtml,
      excerpt: fm.excerpt || '',
      status: 'draft',
    };
    if (featuredMediaId) payload.featured_media = featuredMediaId;

    if (type === 'posts') {
      const categoryIds = dryRun ? [] : await ensureTerms(client, fm.categories, 'category');
      const tagIds = dryRun ? [] : await ensureTerms(client, fm.tags, 'tag');
      if (categoryIds.length) payload.categories = categoryIds;
      if (tagIds.length) payload.tags = tagIds;
    }

    if (type === 'pages') {
      if (fm.template) payload.template = fm.template;
      if (typeof fm.menu_order === 'number') payload.menu_order = fm.menu_order;
      if (fm.parent_slug && !dryRun) {
        const parentId = await resolveParent(client, fm.parent_slug);
        if (parentId) payload.parent = parentId;
        else console.warn(`    ⚠ parent page not found: ${fm.parent_slug}`);
      }
    }

    if (dryRun) {
      console.log(`  • ${slug} — would ${existing ? 'update' : 'create'}`);
      continue;
    }

    if (existing && force) {
      // Preserve existing status instead of forcing draft
      delete payload.status;
      await client.updateItem(type, existing.id, payload);
      console.log(`  ↻ ${slug} — updated (#${existing.id})`);
      updated++;
    } else {
      const item = await client.createItem(type, payload);
      console.log(`  + ${slug} — created draft (#${item.id})`);
      created++;
    }
  }

  return { created, updated, skipped };
}

async function main() {
  const args = parseArgs(process.argv);
  if (args.help) {
    console.log('Usage: WP_URL=<url> WP_USER=<user> WP_APP_PASSWORD=<pwd> node import.mjs [--type posts|pages|all] [--dir ./content] [--force] [--dry-run]');
    process.exit(0);
  }

  const baseUrl = process.env.WP_URL;
  const user = process.env.WP_USER;
  const password = process.env.WP_APP_PASSWORD;
  if (!baseUrl || !user || !password) {
    console.error('Missing WP_URL, WP_USER or WP_APP_PASSWORD env var.');
    process.exit(1);
  }

  const baseDir = path.resolve(__dirname, args.dir);
  const client = createClient({ baseUrl, user, password });

  console.log(`Importing into ${baseUrl} (types: ${args.types.join(', ')}${args.dryRun ? ', dry run' : ''})`);

  let total = { created: 0, updated: 0, skipped: 0 };

  for (const type of args.types) {
    const typeDir = path.join(baseDir, type);
    const result = await importType({
      client,
      type,
      dir: typeDir,
      force: args.force,
      dryRun: args.dryRun,
    });
    total.created += result.created;
    total.updated += result.updated;
    total.skipped += result.skipped;
  }

  console.log(`\nAll done. created=${total.created} updated=${total.updated} skipped=${total.skipped}`);
}

main().catch((e) => {
  console.error(`Error: ${e.message}`);
  if (e.data) console.error(JSON.stringify(e.data, null, 2));
  process.exit(1);
});
