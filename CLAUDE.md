# Regolia WordPress Theme — Guide per Claude

## Stile illustrazioni (brand)

Lo stile visivo del brand Regolia è ispirato alle reference in `assets/design images/`, ma **semplificato**: meno gradienti, meno riempimenti, più aria.

**Regole:**
- **Tecnica:** flat 2D line illustration (niente 3D, niente clay, niente plasticine).
- **Palette (monocromatica verde):**
  - outline / stroke principale: deep green `#0D6B4F`
  - fill piatti: mint `#C5F5DC`, light mint `#EAFFF4`
  - accenti caldi occasionali (uno per immagine max): ambra `#E6A817`
  - niente neri, niente grigi neutri — solo verdi + off-white
- **Stroke:** medium-thin, ~2-3px a 800px, uniforme, con lineCaps e lineJoins arrotondati.
- **Fill:** al massimo 1-2 aree piatte per oggetto; la maggior parte del soggetto è solo contorno. NO gradienti, NO shading, NO ombreggiature.
- **Composizione:** soggetto centrato, 1:1 quadrato, padding generoso (~15% per lato).
- **Background:** sempre trasparente (alpha). In fase di generazione si può chiedere "on a pure white background" e poi rimuovere il background con `rembg` (script già configurato).
- **Soggetti:** persone, oggetti domestici, dispositivi (telefono, laptop), piante, carte/documenti — lo stesso vocabolario delle reference ma più minimal.
- **Niente testo** nell'immagine (no labels, no numeri, no UI mockata leggibile).
- **Formato output:** WebP RGBA, 800×800, `cwebp -q 85 -alpha_q 95`.

**Prompt base Gemini riutilizzabile** (adatta solo il soggetto):
> `Flat 2D line illustration in a minimalist vector style. {SOGGETTO}. Monochromatic green palette: outlines in deep green #0D6B4F, soft mint #C5F5DC fills on a few selected shapes, most of the drawing is outline only. Rounded stroke caps, medium-thin uniform line weight, no shading, no gradients, no 3D effect, no plasticine. Centered composition with generous padding, 1:1 square. Clean white background. No text, no letters, no numbers. Simple, airy, friendly, premium fintech illustration style.`

Pipeline di generazione consigliata:
1. Gemini → "Crea immagine" → prompt con white background
2. Download PNG originale
3. `python3` + `rembg` (model `isnet-general-use`) per rimuovere il background
4. `cwebp -q 85 -alpha_q 95 -mt` per output finale
5. Salva in `assets/images/<sezione>/<nome>.webp`

## Release workflow (OBBLIGATORIO)

Ogni volta che il tema viene aggiornato, dopo aver applicato le modifiche al codice:

1. **Bump della versione** in `style.css` (header `Version:`) — segui semver.
2. **Commit** delle modifiche con messaggio descrittivo.
3. **Push** su `main` (`git push origin main`).
4. **Tag annotato** con la nuova versione: `git tag -a v<x.y.z> -m "<note>"`.
5. **Push del tag**: `git push origin v<x.y.z>`.

Il GitHub Updater del tema usa i tag per rilevare nuove versioni, quindi senza tag il sito in produzione non riceve l'aggiornamento. Non saltare nessuno di questi step.
