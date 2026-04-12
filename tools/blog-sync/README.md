# blog-sync

Portable blog content pipeline for the Regolia WordPress site, based on the
WordPress REST API.

- **`export.mjs`** — pulls all published posts from a WP site, converts the
  HTML body to Markdown, and writes one `<slug>.md` per post (+ the featured
  image) into `./content/`. YAML frontmatter carries title, slug, date,
  excerpt, categories, tags and `featured_image`.
- **`import.mjs`** — reads `./content/*.md`, uploads each featured image via
  `/wp/v2/media`, creates/fetches categories & tags, and creates the post as
  `draft`. Idempotent: existing slugs are skipped unless you pass `--force`.

The content directory is intended to be committed to the repo, so a seed of
the blog travels with the theme and can be (re)imported into any environment.

## Setup

```bash
cd tools/blog-sync
npm install
```

Node ≥ 18 is required (uses native `fetch` + `FormData`).

## Export (from WordPress → Markdown)

No authentication needed for public posts.

```bash
WP_URL=http://localhost:8090 npm run export
# or
WP_URL=http://localhost:8090 node export.mjs --out ./content
WP_URL=http://localhost:8090 node export.mjs --include-drafts
```

Writes into `./content/`:

```
content/
├── come-assumere-una-colf-nel-2026-guida-completa.md
├── come-assumere-una-colf-nel-2026-guida-completa.jpg
├── cassa-colf-cose-e-perche-conviene.md
├── cassa-colf-cose-e-perche-conviene.jpg
└── …
```

Each Markdown file looks like:

```markdown
---
title: "Cassa Colf: cos'è e perché conviene"
slug: cassa-colf-cose-e-perche-conviene
date: 2026-04-11T11:27:31Z
status: publish
excerpt: "La Cassa Colf è l'ente bilaterale…"
categories:
  - Normativa
tags: []
featured_image: cassa-colf-cose-e-perche-conviene.jpg
---

## Cos'è la Cassa Colf

La Cassa Colf è…
```

## Import (Markdown → WordPress, as drafts)

The import requires a WordPress **Application Password**. Create one from
`Users → Profile → Application Passwords` on the target site and copy it.

```bash
WP_URL=https://regolia.it \
WP_USER=admin \
WP_APP_PASSWORD="xxxx xxxx xxxx xxxx xxxx xxxx" \
  npm run import
```

Flags:

- `--dir ./content` — override the source directory
- `--force` — update existing posts (matched by slug) instead of skipping.
  Status is preserved (does **not** flip published → draft).
- `--dry-run` — parse and log actions without touching the remote site

Posts are created as `status: draft` so a human can review before publishing.

### What the importer does per post

1. `GET /wp/v2/posts?slug=<slug>&status=any&context=edit` — skip if exists
   (unless `--force`).
2. Reads the frontmatter image and uploads it via `POST /wp/v2/media`
   (`Content-Type` + `Content-Disposition: attachment; filename=…`).
3. Ensures all frontmatter categories and tags exist (creates any missing).
4. Converts the Markdown body to HTML via `marked`.
5. `POST /wp/v2/posts` with title, slug, excerpt, content, `featured_media`,
   `categories`, `tags`, `status=draft`.

## Regenerating the seed

The `content/` directory is committed with an initial seed exported from the
local dev site. To refresh it with the latest content from any environment:

```bash
WP_URL=<source> npm run export
git diff content/      # review
git add content/ && git commit -m "Refresh blog seed"
```

## Typical workflows

### First-time seed on a new production site

```bash
cd tools/blog-sync
npm install

# 1. Generate an Application Password on the target site:
#    Users → Your Profile → Application Passwords → Add New

# 2. (optional) dry-run to see what would happen
WP_URL=https://regolia.it \
WP_USER=salvatore \
WP_APP_PASSWORD="xxxx xxxx xxxx xxxx xxxx xxxx" \
  npm run import -- --dry-run

# 3. Actual import — all posts land as drafts
WP_URL=https://regolia.it \
WP_USER=salvatore \
WP_APP_PASSWORD="xxxx xxxx xxxx xxxx xxxx xxxx" \
  npm run import

# 4. In WP admin, review each draft, then Publish.
```

### Refreshing `content/` from the live dev site

```bash
WP_URL=http://localhost:8090 npm run export
git diff content/           # inspect what changed
git add content/
git commit -m "Refresh blog seed"
git push
```

### Pushing local edits from `content/` back into the dev site

```bash
WP_URL=http://localhost:8090 \
WP_USER=admin \
WP_APP_PASSWORD="xxxx xxxx" \
  npm run import -- --force
```

The `--force` flag updates existing posts matched by slug (title, content,
excerpt, featured image) while **preserving their current status** — a
published post stays published, a draft stays a draft.

## Environment variables

| Variable | Required by | Purpose |
|---|---|---|
| `WP_URL` | export + import | Base URL of the target WordPress site (no trailing slash) |
| `WP_USER` | import | WP username that owns the Application Password |
| `WP_APP_PASSWORD` | import | Application Password (`Users → Profile → Application Passwords`) |

Export does not require auth if the source posts are public. Use
`--include-drafts` together with `WP_USER`/`WP_APP_PASSWORD` to pull drafts
too.

## CLI flags

### `export.mjs`

| Flag | Default | Description |
|---|---|---|
| `--out <dir>` | `./content` | Output directory for `.md` + images |
| `--include-drafts` | off | Also pull posts with status other than `publish` |
| `-h`, `--help` | — | Print usage |

### `import.mjs`

| Flag | Default | Description |
|---|---|---|
| `--dir <dir>` | `./content` | Source directory containing the `.md` files |
| `--force` | off | Update posts matched by slug (preserves status) |
| `--dry-run` | off | Log planned actions without hitting the remote site |
| `-h`, `--help` | — | Print usage |

## File layout

```
tools/blog-sync/
├── package.json
├── README.md        ← this file
├── export.mjs       ← pull from WP → Markdown
├── import.mjs       ← push Markdown → WP as drafts
├── lib/
│   ├── wp-api.mjs   ← minimal REST client (Basic auth)
│   ├── html-to-md.mjs
│   └── md-to-html.mjs
└── content/         ← committed seed (17 posts + cover images)
    ├── <slug>.md
    └── <slug>.jpg
```

The `content/` directory is committed with a cleaned-up seed: duplicate
posts that existed in the dev database have been consolidated (newest
content wins, slugs normalised) and the default "Hello world" post was
removed.

## How it works

### Export (`export.mjs`)

1. `GET /wp-json/wp/v2/posts?per_page=100&_embed=1` — pulls everything in one
   call. `_embed=1` returns `wp:featuredmedia` and `wp:term` inline, so we
   don't need extra requests for images or taxonomies.
2. For each post:
   - Title and excerpt are decoded (HTML entities → UTF-8).
   - Body HTML is converted to Markdown via `turndown`.
   - Categories and tags are resolved from `_embedded['wp:term']` by name.
   - The featured image is downloaded from `source_url`.
3. A Markdown file is written with YAML frontmatter via `gray-matter`.

### Import (`import.mjs`)

1. Parse every `.md` under `content/` with `gray-matter`.
2. `GET /wp/v2/posts?slug=<slug>&status=any&context=edit` — skip if exists
   (unless `--force` is passed). `context=edit` requires auth; that's how we
   can see drafts too.
3. Read the frontmatter cover image and upload it via
   `POST /wp/v2/media` with `Content-Type` + `Content-Disposition`.
4. For each frontmatter `categories` / `tags` entry: look it up by name via
   `/wp/v2/categories` and `/wp/v2/tags`, creating any that don't exist.
5. Convert the Markdown body to HTML via `marked` (GFM).
6. `POST /wp/v2/posts` with `title`, `slug`, `excerpt`, `content`,
   `featured_media`, `categories`, `tags`, `status: draft`.

With `--force`, step 6 becomes `POST /wp/v2/posts/<id>` and the `status`
field is omitted so the existing status is preserved.

## Notes

- Export resolves categories and tags via `_embedded['wp:term']`, so only a
  single request (`?_embed=1`) is needed per batch.
- HTML → Markdown uses `turndown`; Markdown → HTML uses `marked` with GFM.
- The importer does **not** delete anything. To remove a post it must be
  handled manually in WP admin.
- Node ≥ 18 is required for native `fetch` / `FormData`. No third-party
  HTTP client is bundled.
