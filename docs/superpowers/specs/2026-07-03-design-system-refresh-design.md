# Design System Refresh — Regolia (brand board luglio 2026)

**Data:** 2026-07-03
**Stato:** approvato a voce, in attesa di review scritta
**Sorgenti:** `regolia_brand_board_final.png` + `regolia_palette.css` (pacchetto `regolia_logo_assets_HD`)

## Obiettivo

Allineare il tema WordPress alla nuova brand identity (brand board "Alternativa evoluta 2"):
palette verde/mint più chiara e viva, tipografia Nunito, gradiente brand per i momenti
di marca. Due deliverable:

1. **Token CSS aggiornati** in `assets/css/main.css` (+ enqueue font in `functions.php`)
   — il sito si riveste senza toccare markup né regole.
2. **Documento di riferimento** `design-system-regolia.md` nella root del repo
   (stesso pattern di `prompt-copy-regolia.md`).

Decisioni prese con l'utente:
- Deliverable: token CSS **e** documento.
- Tipografia: **Nunito ovunque** (display + body); Playfair Display e DM Sans rimossi.
- Palette: **5 ancore ufficiali + stop derivati** per superfici scure/hover.
- Guida illustrazioni in CLAUDE.md aggiornata ai nuovi colori; illustrazioni esistenti
  **non** rigenerate.
- Approccio CSS: **remap dei token esistenti** (i nomi `--clr-*` restano, cambiano i
  valori; i nomi ufficiali `--regolia-*` entrano come layer di ancoraggio).

## 1. Palette

### Ancore ufficiali (da `regolia_palette.css`)

| Token | Hex | Ruolo |
|---|---|---|
| `--regolia-green-900` | `#0F6B4F` | Primario: bottoni, link, outline, testi brand |
| `--regolia-green-600` | `#47C599` | Accento vivo: icone, hover chiari, evidenziazioni |
| `--regolia-mint-400` | `#9DE2C2` | Fill decorativi, pill, tag |
| `--regolia-mint-200` | `#CDEFDE` | Fill leggeri, bordi, divisori |
| `--regolia-mint-50` | `#E9F7F0` | Sfondi sezione, hero |

### Stop derivati (stessa tonalità del green-900, non presenti nella palette ufficiale)

| Token | Hex | Ruolo |
|---|---|---|
| `--regolia-green-950` | `#0B4A38` | Superfici scure (footer, sezione "il conto"), testi display |
| `--regolia-green-800` | `#0D5C44` | Hover dei bottoni primari |
| `--regolia-green-700` | `#2BA87D` | Intermedio dove il 600 non ha abbastanza contrasto |

### Remap dei token esistenti

| Token esistente | Valore attuale | Nuovo valore |
|---|---|---|
| `--clr-brand-900` | `#0A4F3A` | `#0B4A38` (green-950) |
| `--clr-brand-800` | `#0B5C44` | `#0D5C44` (green-800) |
| `--clr-brand-700` | `#0D6B4F` | `#0F6B4F` (green-900) |
| `--clr-brand-500` | `#1A9E73` | `#2BA87D` (green-700) |
| `--clr-brand-300` | `#4EC9A0` | `#47C599` (green-600) |
| `--clr-brand-100` | `#D0F0E0` | `#CDEFDE` (mint-200) |
| `--clr-brand-50`  | `#E8F5EE` | `#E9F7F0` (mint-50) |
| `--clr-mint`      | `#C5F5DC` | `#9DE2C2` (mint-400) |
| `--clr-mint-light`| `#EAFFF4` | `#E9F7F0` (mint-50) |

Invarianti:
- **Grigi caldi** (`--clr-warm-*`): invariati — la palette ufficiale non ha neutri.
- **Semantici** (`--clr-danger`, `--clr-amber`, `--clr-info`, `--clr-white`): invariati;
  l'ambra resta l'accento occasionale delle illustrazioni.
- **Ombre**: base colore da `rgba(10,79,58,…)` a `rgba(15,107,79,…)` a parità di alpha.

### Gradiente brand

Nuovo token `--grad-brand: linear-gradient(135deg, #47C599, #9DE2C2)`.
Riservato ai "momenti brand" (chip logo, icona app, eventuali hero decorativi),
come nella board. Non si usa su superfici di testo né sulle illustrazioni.

## 2. Tipografia

- `--font-display: 'Nunito', system-ui, -apple-system, sans-serif` — titoli in
  ExtraBold/Black (800/900).
- `--font-body: 'Nunito', system-ui, -apple-system, sans-serif` — testo in 400/600/700.
- `functions.php`: unico enqueue `Nunito:wght@400;600;700;800;900` (sostituisce
  DM Sans + Playfair Display).
- Scala tipografica, line-height e spaziature: **invariati** — cambia il carattere,
  non la gerarchia.
- Nota di naming: la board indica "Nunito Rounded"; su Google Fonts la famiglia si
  chiama **Nunito** ed è già la variante arrotondata. Va annotato nel documento.

## 3. Altri token

- Spacing: invariato.
- Radius: invariato (la scala attuale è già coerente con la board).

## 4. Documento `design-system-regolia.md` (root del repo)

Contenuti:
1. **Concetto brand** — semplificazione, rimozione del superfluo, chiarezza e controllo;
   tagline della board ("Regolia semplifica la gestione del lavoro rimuovendo gli
   ostacoli burocratici, offrendo chiarezza, controllo e tempo per ciò che conta davvero").
2. **Logo e usi** — icona, icona app (canvas bianco arrotondato), logo orizzontale,
   chip su fondo scuro (`green-950`) e chiaro; file di riferimento in
   `assets/images/logo/` e nel pacchetto HD.
3. **Palette** — ancore, derivati, ruoli, mapping token CSS.
4. **Tipografia** — Nunito, pesi, scala.
5. **Token** — spacing, radius, shadow, gradiente.
6. **Componenti chiave** — bottoni (primario/ghost), badge, pill, card: colori e stati
   con i nuovi token.
7. **Illustrazioni** — regole aggiornate (outline `#0F6B4F`, fill `#9DE2C2`/`#CDEFDE`/
   `#E9F7F0`, ambra `#E6A817` come unico accento, flat, no gradienti).

## 5. CLAUDE.md

La sezione "Stile illustrazioni (brand)" aggiorna i colori:
- outline: `#0D6B4F` → `#0F6B4F`
- fill: `#C5F5DC`/`#EAFFF4` → `#9DE2C2`/`#CDEFDE` (+ `#E9F7F0` come fondo chiarissimo)
- il prompt Gemini riutilizzabile aggiorna gli stessi hex
- si aggiunge il rimando a `design-system-regolia.md`

Le ~20 illustrazioni esistenti restano come sono (differenza cromatica minima).

## 6. Verifica

Sul WordPress locale (docker, `localhost:8090`):
- screenshot di home (landing storia-vs), Perché Regolia, Servizi, Come funziona;
- controlli mirati: resa di Nunito su titoli display, contrasto testo/sfondo nelle
  sezioni scure (footer, "il conto") con `green-950`, bottoni primari e hover,
  pill/badge con i nuovi mint;
- nessun riferimento residuo a Playfair/DM Sans (`grep` su CSS e PHP).

## 7. Release

Workflow obbligatorio da CLAUDE.md: bump a **v1.8.0** in `style.css`, commit, push,
tag annotato `v1.8.0`, push del tag.

## Fuori scope

- Rigenerazione delle illustrazioni esistenti.
- Refactor semantico del layer CSS (naming surface/text/accent).
- Favicon/site icon da pacchetto HD (gestibile a parte se richiesto).
- Cambi di layout, spaziature o componenti.
