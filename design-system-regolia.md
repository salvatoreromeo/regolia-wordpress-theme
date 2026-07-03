# Design System — Regolia

> Riferimento ufficiale per interfaccia, brand e illustrazioni del sito Regolia.
> Derivato dalla brand board "Alternativa evoluta 2" (luglio 2026) e da
> `regolia_palette.css` del pacchetto `regolia_logo_assets_HD`.
> I token CSS vivono in `assets/css/main.css` (`:root`).

---

## 1. Concetto brand

Tre idee guida, nell'ordine della board:

1. **Semplificazione** — ogni schermata e ogni testo tolgono lavoro all'utente, non ne aggiungono.
2. **Rimozione del superfluo** — meno elementi, più aria: se un componente non serve, si elimina.
3. **Chiarezza e controllo** — costi, documenti e passaggi sempre visibili e comprensibili.

**Tagline di riferimento:**
> Regolia semplifica la gestione del lavoro rimuovendo gli ostacoli burocratici,
> offrendo chiarezza, controllo e tempo per ciò che conta davvero.

## 2. Logo e usi

Il marchio è una forma organica "goccia" in gradiente verde con un punto satellite,
affiancata dal wordmark **Regolia** in Nunito (verde scuro).

| Variante | Uso | File |
|---|---|---|
| Icona isolata | Header/footer del sito (40px), avatar, marker | `assets/images/logo/regolia-logo-square.png` (160px) · master: `regolia_icon_transparent_1024.png` |
| Logo orizzontale (icona + wordmark) | Presentazioni, documenti, partner | `assets/images/logo/regolia-logo.png` (1007×281) · retina: `@2x`/`@4x` nel pacchetto HD |
| Icona app | Favicon, PWA, social avatar | `regolia_app_icon_square_{32,64,180,192,512,1024}.png` nel pacchetto HD |

**Regole:**
- Su fondo chiaro: icona + wordmark `green-900`.
- Su fondo scuro: chip `green-950` con wordmark bianco (come nella board), oppure icona sola.
- L'icona porta il **gradiente brand** (`--grad-brand`); è l'unico elemento dell'interfaccia,
  insieme a eventuali chip brand, autorizzato a usarlo.
- Non ridisegnare, ruotare, ricolorare o bordare il marchio; niente ombre sul logo.
- Il wordmark nel sito è testo HTML (`.site-logo__text`), non immagine: resta selezionabile e nitido.

## 3. Palette

### Ancore ufficiali

| Token | Hex | Ruolo |
|---|---|---|
| `--regolia-green-900` | `#0F6B4F` | **Primario**: bottoni, link, outline, testi brand |
| `--regolia-green-600` | `#47C599` | Accento vivo: icone, hover chiari, evidenziazioni |
| `--regolia-mint-400` | `#9DE2C2` | Fill decorativi, pill, tag |
| `--regolia-mint-200` | `#CDEFDE` | Fill leggeri, bordi, divisori |
| `--regolia-mint-50` | `#E9F7F0` | Sfondi sezione, hero |

### Stop derivati (fuori palette ufficiale, stessa tonalità del green-900)

| Token | Hex | Ruolo |
|---|---|---|
| `--regolia-green-950` | `#0B4A38` | Superfici scure (footer, sezioni dark), testi display |
| `--regolia-green-800` | `#0D5C44` | Hover dei bottoni primari |
| `--regolia-green-700` | `#2BA87D` | Intermedio dove il 600 non ha abbastanza contrasto |

### Gradiente brand

```css
--grad-brand: linear-gradient(135deg, #47C599, #9DE2C2);
```

Riservato ai momenti di marca (icona, chip logo, icona app). Mai su superfici di
testo, mai nelle illustrazioni.

### Mapping dei token storici

I componenti usano ancora i nomi `--clr-*`; sono alias delle ancore:

| Token storico | Ancora |
|---|---|
| `--clr-brand-900` | `--regolia-green-950` |
| `--clr-brand-800` | `--regolia-green-800` |
| `--clr-brand-700` | `--regolia-green-900` |
| `--clr-brand-500` | `--regolia-green-700` |
| `--clr-brand-300` | `--regolia-green-600` |
| `--clr-brand-100` | `--regolia-mint-200` |
| `--clr-brand-50` | `--regolia-mint-50` |
| `--clr-mint` | `--regolia-mint-400` |
| `--clr-mint-light` | `--regolia-mint-50` |

### Neutri e semantici (invariati)

- Grigi caldi `--clr-warm-50…900` (`#FAFBFA` → `#1A1D1B`): testi correnti, bordi, sfondi neutri.
- `--clr-danger #D94F4F` (errori, azioni distruttive) · `--clr-amber #E6A817` (warning,
  accento illustrazioni) · `--clr-info #3B82C4` (note informative) · `--clr-white #FFFFFF`.

## 4. Tipografia

Una sola famiglia: **Nunito** (Google Fonts). La board indica "Nunito Rounded":
su Google Fonts la famiglia si chiama semplicemente *Nunito* ed è già la variante
arrotondata — non cercare una "Nunito Rounded" separata.

| Token | Valore | Pesi |
|---|---|---|
| `--font-display` | `'Nunito', system-ui, -apple-system, sans-serif` | 800 (ExtraBold), 900 (Black) per i titoli |
| `--font-body` | `'Nunito', system-ui, -apple-system, sans-serif` | 400 testo, 600 enfasi, 700 label/CTA |

Enqueue (in `functions.php`):
`https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap`

La scala tipografica (dimensioni, line-height) non è cambiata rispetto al tema
precedente: cambia il carattere, non la gerarchia.

## 5. Altri token

- **Spacing**: scala `--space-1…24` (0.25rem → 6rem), invariata.
- **Radius**: `--radius-sm…2xl` (0.5rem → 1.5rem) + `--radius-full`; generosa e già
  coerente con le forme arrotondate della board.
- **Shadows** (colorate sul verde primario `rgba(15,107,79,…)`):
  - `--shadow-card` — card e superfici a riposo
  - `--shadow-md` — hover, elementi sollevati
  - `--shadow-hero` — momenti hero
- **Transition**: `--transition: 150ms ease`.

## 6. Componenti chiave

| Componente | Ricetta |
|---|---|
| Bottone primario | fondo `green-900`, testo bianco, hover `green-800`, radius pieno |
| Bottone ghost | bordo + testo `green-900`, fondo trasparente, hover fondo `mint-50` |
| Badge / tag | fondo `mint-200`, testo `green-900` |
| Pill (dati/prezzi) | fondo `mint-50` o `green-950` (variante dark), testo coordinato |
| Card | fondo bianco, `--shadow-card`, radius `lg/xl`, bordo opzionale `mint-200` |
| Sezioni scure | fondo `green-950`, testi bianco/`mint-200`, numeri d'accento `mint-400` |
| Check/icone inline SVG | stroke `#0F6B4F` |

## 7. Illustrazioni

Flat 2D line illustration, palette monocromatica verde (vedi anche CLAUDE.md, che
resta la guida operativa per la generazione):

- **Outline**: deep green `#0F6B4F`, tratto uniforme medio-sottile (~2-3px a 800px),
  cap e join arrotondati.
- **Fill piatti** (1-2 aree per oggetto, il resto solo contorno): mint `#9DE2C2`,
  light mint `#CDEFDE`; fondo chiarissimo `#E9F7F0` se serve un campo.
- **Accento caldo**: ambra `#E6A817`, massimo uno per immagine.
- Niente neri, grigi neutri, gradienti, ombre o 3D. Le illustrazioni **non** usano
  `--grad-brand`.
- Composizione centrata, 1:1, padding ~15%; sfondo trasparente; output WebP RGBA
  800×800 (`cwebp -q 85 -alpha_q 95`).
- Le illustrazioni prodotte prima di luglio 2026 usano la palette precedente
  (outline `#0D6B4F`, mint `#C5F5DC`): differenza minima, non vanno rigenerate.

## 8. Do / Don't

- ✅ Usa i token, mai hex sparsi nei componenti (eccezione: SVG inline `#0F6B4F`).
- ✅ Le sezioni si alternano bianco / `mint-50`; il dark (`green-950`) è raro e intenzionale.
- ✅ L'ambra è un accento: mai come colore strutturale dell'interfaccia.
- ❌ Non introdurre nuovi verdi fuori da ancore + derivati.
- ❌ Non usare il gradiente su testi, bottoni o illustrazioni.
- ❌ Non reintrodurre serif o seconde famiglie tipografiche.
