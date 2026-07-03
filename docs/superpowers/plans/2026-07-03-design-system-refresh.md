# Design System Refresh Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Allineare il tema WordPress Regolia alla brand board luglio 2026: nuova palette verde/mint, Nunito ovunque, gradiente brand, documento di riferimento e guida illustrazioni aggiornata.

**Architecture:** Remap dei valori dei token CSS esistenti (`--clr-*`) sulle 5 ancore ufficiali `--regolia-*` + 3 stop derivati, definiti come layer di ancoraggio in `:root`. Nessuna modifica alle ~2000 righe di regole né al markup, salvo pochi hex hardcoded (SVG inline, rgba nelle ombre).

**Tech Stack:** CSS custom properties, WordPress theme (PHP), Google Fonts, docker compose per la verifica locale.

**Spec:** `docs/superpowers/specs/2026-07-03-design-system-refresh-design.md`

## Global Constraints

- Ancore ufficiali: `#0F6B4F` (green-900), `#47C599` (green-600), `#9DE2C2` (mint-400), `#CDEFDE` (mint-200), `#E9F7F0` (mint-50).
- Derivati: `#0B4A38` (green-950), `#0D5C44` (green-800), `#2BA87D` (green-700).
- Font unico: `Nunito` (Google Fonts), pesi 400;600;700;800;900.
- Grigi caldi e semantici (danger/amber/info/white) invariati.
- Spacing e radius invariati.
- Nessuna rigenerazione delle illustrazioni esistenti.
- Non c'è test suite: la verifica è grep + visuale sul WP locale (localhost:8090).
- Release finale obbligatoria: bump `style.css` a 1.8.0, commit, push, tag `v1.8.0`, push tag.

---

### Task 1: Layer token in `assets/css/main.css`

**Files:**
- Modify: `assets/css/main.css:7-38` (blocco `:root`: colori + font)
- Modify: `assets/css/main.css:63-65` (shadow token)

**Interfaces:**
- Produces: variabili `--regolia-green-950|900|800|700|600`, `--regolia-mint-400|200|50`, `--grad-brand`; i token `--clr-*` esistenti mantengono i nomi con i nuovi valori. Task 4 (documento) cita questi nomi.

- [ ] **Step 1: Sostituire il blocco brand greens (righe 8-17)**

Da:
```css
  /* Brand greens */
  --clr-brand-900: #0A4F3A;
  --clr-brand-800: #0B5C44;
  --clr-brand-700: #0D6B4F;
  --clr-brand-500: #1A9E73;
  --clr-brand-300: #4EC9A0;
  --clr-brand-100: #D0F0E0;
  --clr-brand-50:  #E8F5EE;
  --clr-mint:      #C5F5DC;
  --clr-mint-light:#EAFFF4;
```

A:
```css
  /* Palette ufficiale Regolia (brand board 2026-07) — ancore */
  --regolia-green-900: #0F6B4F;
  --regolia-green-600: #47C599;
  --regolia-mint-400:  #9DE2C2;
  --regolia-mint-200:  #CDEFDE;
  --regolia-mint-50:   #E9F7F0;
  /* Stop derivati (stessa tonalità del green-900) */
  --regolia-green-950: #0B4A38;
  --regolia-green-800: #0D5C44;
  --regolia-green-700: #2BA87D;
  /* Gradiente brand — solo momenti di marca (chip logo, icona app) */
  --grad-brand: linear-gradient(135deg, #47C599, #9DE2C2);

  /* Brand greens (token storici rimappati sulle ancore) */
  --clr-brand-900: var(--regolia-green-950);
  --clr-brand-800: var(--regolia-green-800);
  --clr-brand-700: var(--regolia-green-900);
  --clr-brand-500: var(--regolia-green-700);
  --clr-brand-300: var(--regolia-green-600);
  --clr-brand-100: var(--regolia-mint-200);
  --clr-brand-50:  var(--regolia-mint-50);
  --clr-mint:      var(--regolia-mint-400);
  --clr-mint-light:var(--regolia-mint-50);
```

- [ ] **Step 2: Sostituire i font token (righe 37-38)**

Da:
```css
  --font-display: 'Playfair Display', Georgia, serif;
  --font-body:    'DM Sans', system-ui, -apple-system, sans-serif;
```

A:
```css
  --font-display: 'Nunito', system-ui, -apple-system, sans-serif;
  --font-body:    'Nunito', system-ui, -apple-system, sans-serif;
```

- [ ] **Step 3: Aggiornare le shadow token (righe 63-65)**

Da:
```css
  --shadow-card: 0 1px 3px rgba(10,79,58,.06), 0 4px 12px rgba(10,79,58,.04);
  --shadow-md:   0 4px 16px rgba(10,79,58,.10);
  --shadow-hero: 0 8px 40px rgba(10,79,58,.12), 0 2px 8px rgba(0,0,0,.04);
```

A:
```css
  --shadow-card: 0 1px 3px rgba(15,107,79,.06), 0 4px 12px rgba(15,107,79,.04);
  --shadow-md:   0 4px 16px rgba(15,107,79,.10);
  --shadow-hero: 0 8px 40px rgba(15,107,79,.12), 0 2px 8px rgba(0,0,0,.04);
```

- [ ] **Step 4: Verifica**

Run: `grep -n "Playfair\|DM Sans\|#0A4F3A\|#C5F5DC" assets/css/main.css`
Expected: nessun risultato.

- [ ] **Step 5: Commit**

```bash
git add assets/css/main.css
git commit -m "Design system: remap token su palette brand board + Nunito + grad-brand"
```

### Task 2: Hex hardcoded fuori dai token

**Files:**
- Modify: `assets/css/main.css:154` (`rgba(10,79,58,.08)` → `rgba(15,107,79,.08)`)
- Modify: `assets/css/main.css:1085` (`rgba(10, 79, 58, 0.62)` → `rgba(15, 107, 79, 0.62)`)
- Modify: `assets/css/main.css:1088` (`rgba(10, 79, 58, 0.74)` → `rgba(15, 107, 79, 0.74)`)
- Modify: `assets/css/main.css:1221` (`rgba(10, 79, 58, 0.06)` → `rgba(15, 107, 79, 0.06)`)
- Modify: `parts/landing-common-footer.php:60-65` (6 SVG `stroke="#0D6B4F"` → `stroke="#0F6B4F"`)
- Modify: `404.php:10` (SVG `stroke="#0D6B4F"` → `stroke="#0F6B4F"`)

**Interfaces:**
- Consumes: nulla. Produces: nulla (sostituzioni puntuali).

- [ ] **Step 1: Sostituire i 4 rgba in main.css e i 7 stroke SVG nei PHP** (replace-all sui pattern esatti sopra)

- [ ] **Step 2: Verifica**

Run: `grep -rn "0D6B4F\|rgba(10,79,58\|rgba(10, 79, 58" --include="*.php" --include="*.css" . | grep -v node_modules | grep -v update-202607 | grep -v docs/`
Expected: nessun risultato.

- [ ] **Step 3: Commit**

```bash
git add assets/css/main.css parts/landing-common-footer.php 404.php
git commit -m "Design system: allinea hex hardcoded (SVG inline, rgba ombre) al nuovo verde"
```

### Task 3: Enqueue font in `functions.php`

**Files:**
- Modify: `functions.php:54`

- [ ] **Step 1: Sostituire l'URL Google Fonts**

Da:
```php
		'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap',
```

A:
```php
		'https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap',
```

- [ ] **Step 2: Verifica**

Run: `docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/regolia-wordpress-theme/functions.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
git add functions.php
git commit -m "Design system: Nunito come unica famiglia Google Fonts"
```

### Task 4: Documento `design-system-regolia.md`

**Files:**
- Create: `design-system-regolia.md` (root del repo)

**Interfaces:**
- Consumes: nomi token del Task 1.

- [ ] **Step 1: Scrivere il documento** con le sezioni previste dalla spec §4: concetto brand + tagline; logo e usi (icona, icona app, orizzontale, chip su `green-950`/chiaro, path `assets/images/logo/`); palette (tabella ancore + derivati + mapping `--clr-*`); tipografia (Nunito, pesi, nota "Nunito Rounded"→Nunito); token (spacing/radius invariati, shadow, `--grad-brand`); componenti chiave (bottone primario `green-900`/hover `green-800`, ghost, badge su `mint-200`, pill, card con `--shadow-card`); illustrazioni (outline `#0F6B4F`, fill `#9DE2C2`/`#CDEFDE`/`#E9F7F0`, ambra `#E6A817` unico accento, flat, no gradienti).

- [ ] **Step 2: Commit**

```bash
git add design-system-regolia.md
git commit -m "Aggiungi design-system-regolia.md (brand board 2026-07)"
```

### Task 5: Guida illustrazioni in `CLAUDE.md`

**Files:**
- Modify: `CLAUDE.md` (sezione "Stile illustrazioni (brand)")

- [ ] **Step 1: Aggiornare gli hex**
  - `outline / stroke principale: deep green \`#0D6B4F\`` → `\`#0F6B4F\``
  - `fill piatti: mint \`#C5F5DC\`, light mint \`#EAFFF4\`` → `fill piatti: mint \`#9DE2C2\`, light mint \`#CDEFDE\` (fondo chiarissimo \`#E9F7F0\`)`
  - Nel prompt Gemini: `outlines in deep green #0D6B4F, soft mint #C5F5DC fills` → `outlines in deep green #0F6B4F, soft mint #9DE2C2 fills`
  - Aggiungere in testa alla sezione il rimando: `Riferimento completo: \`design-system-regolia.md\`.`

- [ ] **Step 2: Commit**

```bash
git add CLAUDE.md
git commit -m "CLAUDE.md: guida illustrazioni sulla nuova palette + rimando al design system"
```

### Task 6: Verifica visuale sul WP locale

**Files:** nessuno.

- [ ] **Step 1: Grep di regressione**

Run: `grep -rn "Playfair\|DM Sans" --include="*.php" --include="*.css" . | grep -v node_modules | grep -v update-202607 | grep -v docs/`
Expected: nessun risultato.

- [ ] **Step 2: Screenshot** di `http://localhost:8090/` (full page), `/perche-regolia/`, `/servizi/`, `/come-funziona/` via chrome-devtools. Controllare: titoli in Nunito (niente serif), footer e sezione "il conto" su `#0B4A38`, bottoni primari `#0F6B4F`, pill/badge sui nuovi mint, nessun testo illeggibile.

### Task 7: Release v1.8.0

**Files:**
- Modify: `style.css:7` (`Version: 1.7.0` → `Version: 1.8.0`)

- [ ] **Step 1: Bump versione, commit, push, tag**

```bash
git add style.css
git commit -m "Bump v1.8.0 — design system refresh (palette brand board + Nunito)"
git push origin main
git tag -a v1.8.0 -m "Design system refresh: palette brand board 2026-07, Nunito, grad-brand, design-system-regolia.md"
git push origin v1.8.0
```

- [ ] **Step 2: Verifica**

Run: `git tag -l v1.8.0 && git status`
Expected: tag presente, working tree pulito.
