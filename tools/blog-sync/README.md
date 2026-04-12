# blog-sync

Portable content pipeline for the Regolia WordPress site, based on the
WordPress REST API. Works for **blog posts** and **pages** — including page
templates, which makes it the distribution channel for the four landing
templates shipped with the theme.

- **`export.mjs`** — pulls posts and/or pages from a WP site, converts the
  HTML body to Markdown, and writes one `<slug>.md` per item (+ the featured
  image) into `./content/<type>/`. YAML frontmatter carries title, slug,
  date, excerpt, `featured_image`, plus per-type fields:
  - **posts**: `categories`, `tags`
  - **pages**: `template`, `menu_order`, `parent_slug`
- **`import.mjs`** — reads `./content/<type>/*.md`, uploads each featured
  image via `/wp/v2/media`, resolves categories/tags/parents, and creates
  the item as `draft`. Idempotent: existing slugs are skipped unless you
  pass `--force`.

The `content/` directory is intended to be committed to the repo, so a seed
of the blog **and** of the pages (including the landing templates) travels
with the theme and can be (re)imported into any environment.

## Setup

```bash
cd tools/blog-sync
npm install
```

Node ≥ 18 is required (uses native `fetch` + `FormData`).

## Export (from WordPress → Markdown)

No authentication needed for public items.

```bash
# Posts only (default)
WP_URL=http://localhost:8090 npm run export

# Pages only
WP_URL=http://localhost:8090 node export.mjs --type pages

# Both in one run
WP_URL=http://localhost:8090 node export.mjs --type all

# Include drafts (requires auth)
WP_URL=http://localhost:8090 WP_USER=admin WP_APP_PASSWORD="xxxx" \
  node export.mjs --type all --include-drafts
```

Writes into `./content/<type>/`:

```
content/
├── posts/
│   ├── cassa-colf-cose-e-perche-conviene.md
│   ├── cassa-colf-cose-e-perche-conviene.jpg
│   ├── come-assumere-una-colf-nel-2026-guida-completa.md
│   ├── come-assumere-una-colf-nel-2026-guida-completa.jpg
│   └── …
└── pages/
    ├── home.md
    ├── landing-famiglia.md
    ├── landing-prezzo.md
    ├── landing-compliance.md
    ├── chi-siamo.md
    └── …
```

Post Markdown file:

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

Page Markdown file (note `template`):

```markdown
---
title: Home
slug: home
date: 2026-04-12T10:02:57Z
status: publish
template: template-landing-default.php
---

(Empty body — the content comes from the page template file.)
```

Pages can also carry `menu_order` and `parent_slug` in their frontmatter;
on import, `parent_slug` is resolved to the current parent page ID on the
target site.

## Import (Markdown → WordPress, as drafts)

The import requires a WordPress **Application Password**. Create one from
`Users → Profile → Application Passwords` on the target site and copy it.

```bash
# Import posts (default)
WP_URL=https://regolia.it \
WP_USER=admin \
WP_APP_PASSWORD="xxxx xxxx xxxx xxxx xxxx xxxx" \
  npm run import

# Import pages
WP_URL=https://regolia.it WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" \
  node import.mjs --type pages

# Import both types in one run
WP_URL=https://regolia.it WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" \
  node import.mjs --type all
```

Flags:

- `--type posts|pages|all` — which subdirectory of `./content/` to import (default: `posts`)
- `--dir ./content` — override the base content directory
- `--force` — update existing items (matched by slug) instead of skipping.
  Status is preserved (does **not** flip published → draft).
- `--interactive` / `-i` — prompt per conflict instead of silently skipping.
  On each existing slug the importer asks:
  `[y]es / [n]o / [a]ll / n[o]ne / [q]uit`
  - `y` update this one
  - `n` skip this one
  - `a` update this and every following conflict (unlocks force mode)
  - `o` skip this and every following conflict
  - `q` stop the import immediately
- `--dry-run` — parse and log actions without touching the remote site

Items are created as `status: draft` so a human can review before publishing.

> **Note:** `--interactive` requires a real TTY. Don't pipe answers via
> `printf | node import.mjs` — Node's readline closes early on piped
> stdin. Run it from a terminal and type the answers.

### What the importer does per item

1. `GET /wp/v2/<type>?slug=<slug>&status=any&context=edit` — skip if exists
   (unless `--force`).
2. Reads the frontmatter image and uploads it via `POST /wp/v2/media`
   (`Content-Type` + `Content-Disposition: attachment; filename=…`).
3. For posts: ensures all frontmatter categories and tags exist
   (creates any missing).
4. For pages: resolves `parent_slug` → parent ID on the target site and
   passes `template` + `menu_order` through unchanged.
5. Converts the Markdown body to HTML via `marked`.
6. `POST /wp/v2/<type>` with title, slug, excerpt, content, `featured_media`,
   taxonomy/hierarchy fields, `status=draft`.

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

Three strategies depending on how much control you want:

```bash
# 1. Surgical: prompt per conflict (recommended for mixed updates)
WP_URL=http://localhost:8090 WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" \
  npm run import -- --interactive

# 2. Blind bulk update: replace every matching slug
WP_URL=http://localhost:8090 WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" \
  npm run import -- --force

# 3. Create-only: skip any existing slug silently
WP_URL=http://localhost:8090 WP_USER=admin WP_APP_PASSWORD="xxxx xxxx" \
  npm run import
```

`--force` and the interactive `a` (all) answer update existing items matched
by slug (title, content, excerpt, featured image) while **preserving their
current status** — a published item stays published, a draft stays a draft.

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
├── export.mjs       ← pull from WP → Markdown (posts + pages)
├── import.mjs       ← push Markdown → WP as drafts (posts + pages)
├── lib/
│   ├── wp-api.mjs   ← minimal REST client (Basic auth, generic item API)
│   ├── html-to-md.mjs
│   └── md-to-html.mjs
└── content/         ← committed seed
    ├── posts/       ← 17 blog post markdowns + cover images
    │   ├── <slug>.md
    │   └── <slug>.jpg
    └── pages/       ← home + utility pages + 3 alternative landings
        ├── home.md
        ├── landing-famiglia.md
        ├── landing-prezzo.md
        ├── landing-compliance.md
        ├── blog.md
        ├── chi-siamo.md
        ├── servizi.md
        ├── come-funziona.md
        └── contatti.md
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
