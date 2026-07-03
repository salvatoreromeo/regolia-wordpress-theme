# Deploy — Aggiornare il sito Regolia in produzione

> Produzione: **http://178.104.215.167/** (Debian + Apache 2.4, PHP 8.3, WordPress).
> L'host è raggiungibile anche via SSH (già in `~/.ssh/known_hosts`).
> Ultima verifica di questo documento: 2026-07-03.

Il sito ha **due canali di aggiornamento indipendenti**. Un deploy completo
di solito li richiede entrambi:

| Cosa | Dove vive | Come si aggiorna |
|---|---|---|
| Tema (template, CSS, JS, immagini, testi della landing) | questo repo | GitHub Updater integrato nel tema |
| Contenuti pagine (Perché Regolia, Servizi, Come funziona, Contatti, blog) | database WP di prod | `tools/blog-sync/import.mjs` via REST |
| Menu, pubblicazione pagine, site icon | database WP di prod | a mano in WP admin |

---

## 1. Aggiornare il TEMA

### 1a. Release dal repo (macchina locale)

Come da CLAUDE.md (workflow obbligatorio):

```bash
# 1. bump Version: in style.css (semver)
# 2. commit + push
git push origin main
# 3. tag annotato + push
git tag -a vX.Y.Z -m "note di release"
git push origin vX.Y.Z
```

### 1b. Creare la GitHub Release — PASSO CRITICO, NON SALTARE

⚠️ **Il solo tag NON basta.** `github-updater.php` interroga
`GET /repos/salvatoreromeo/regolia-wordpress-theme/releases/latest`, che
restituisce solo le **Release GitHub** vere e proprie, non i tag.

```bash
gh release create vX.Y.Z --title "vX.Y.Z" --notes "changelog breve"
```

(oppure da web: GitHub → Releases → "Draft a new release" → scegli il tag.)

> **Storia vera:** fino al 2026-07-03 l'unica release esistente era la
> v1.0.0: i tag v1.1.0 → v1.8.2 erano stati pushati senza release, quindi
> l'updater non ha mai proposto aggiornamenti e prod è rimasta alla v1.6.0.

### 1c. Applicare l'aggiornamento su prod

Da WP admin (`http://178.104.215.167/wp-admin/`):

1. **Bacheca → Aggiornamenti** → "Verifica di nuovo" (l'updater cache-a la
   risposta GitHub per 1 ora in un transient; questo forza il refresh).
2. **Aspetto → Temi** → Regolia mostra "È disponibile una nuova versione" →
   Aggiorna.

In alternativa via SSH, se sul server è disponibile wp-cli:

```bash
ssh <utente>@178.104.215.167
wp transient delete --all --path=<path-wp>   # o solo il transient regolia_gh_release_*
wp theme update regolia-wordpress-theme --path=<path-wp>
```

### 1d. Verifica

```bash
curl -s http://178.104.215.167/wp-content/themes/regolia-wordpress-theme/style.css | grep Version
```

Deve mostrare la versione appena rilasciata. Il browser scarica la CSS nuova
automaticamente (l'enqueue usa `?ver=<versione tema>` come cache-buster).

Note tecniche sull'updater (`github-updater.php`):
- repo **pubblico** → `GITHUB_THEME_TOKEN` in `wp-config.php` non è necessario
  (serve solo se il repo diventasse privato);
- lo zip scaricato è lo zipball del tag; `fix_folder_name()` rinomina la
  cartella `salvatoreromeo-regolia-...` nello slug corretto;
- la risposta GitHub è cache-ata 1 ora (transient `regolia_gh_release_<md5>`).

---

## 2. Aggiornare i CONTENUTI delle pagine

I testi di Perché Regolia / Servizi / Come funziona / Contatti vivono nel
database di prod. I sorgenti sono i markdown in `tools/blog-sync/content/pages/`.

Serve una **Application Password** di un utente admin di prod
(WP admin → Utenti → Profilo → Application Passwords → Add New).

```bash
cd tools/blog-sync
npm install          # solo la prima volta

WP_URL=http://178.104.215.167 \
WP_USER=<utente-admin> \
WP_APP_PASSWORD="xxxx xxxx xxxx xxxx xxxx xxxx" \
  node import.mjs --type pages --interactive
```

- `--interactive` chiede conferma per ogni pagina già esistente
  (`y/n/a/o/q`); `--force` aggiorna tutto senza chiedere; `--dry-run` simula.
- Le pagine **esistenti** (match per slug) vengono aggiornate preservando lo
  stato publish/draft. Le pagine **nuove** (slug mai visto) vengono create
  come **bozza**: vanno pubblicate a mano.
- L'importer **non cancella mai** nulla: le rimozioni si fanno in WP admin.

Dettagli completi del tool: `tools/blog-sync/README.md`.

---

## 3. Passi manuali in WP admin (quando servono)

- **Pubblicare** le pagine nuove create come bozza dall'import.
- **Eliminare/reindirizzare** pagine sostituite (es. `chi-siamo` è stata
  sostituita da `perche-regolia` a luglio 2026: l'import non la rimuove).
- **Menu** (Aspetto → Menu): le voci puntano a pagine per ID, vanno
  aggiornate a mano se cambia slug/titolo di una pagina.
- **Site icon / favicon**: Aspetto → Personalizza → Identità del sito
  (usare `regolia_app_icon_square_512.png` dal pacchetto logo HD).

---

## 4. Checklist deploy completo (esempio: portare prod da v1.6.0 a v1.8.2)

1. [ ] `gh auth login` (se necessario) e `gh release create v1.8.2 --title "v1.8.2" --notes "Testi update-202607, nuovo logo, design system brand board"`
2. [ ] WP admin prod → Aggiornamenti → Verifica di nuovo → aggiorna tema Regolia
3. [ ] `curl … style.css | grep Version` → `1.8.2`
4. [ ] Import pagine: `node import.mjs --type pages --interactive` verso prod
5. [ ] Pubblicare `perche-regolia`; eliminare la vecchia `chi-siamo`
6. [ ] Aggiornare la voce di menu "Chi siamo" → "Perché Regolia"
7. [ ] Controllo visivo: home (landing Marco/Luca, sezione "il conto", footer), Perché Regolia, Servizi, Come funziona; hard refresh se serve
8. [ ] Site icon aggiornata con la nuova icona (se non già fatto)

---

## Troubleshooting

| Sintomo | Causa probabile | Rimedio |
|---|---|---|
| "Nessun aggiornamento disponibile" ma il tag esiste | Manca la **GitHub Release** (vedi 1b) o transient cache-ato | Creare la release; Bacheca → Aggiornamenti → Verifica di nuovo |
| Colori/CSS vecchi dopo l'update | Cache browser sulla CSS con stesso `?ver=` | Verificare che la Version del tema sia stata bumpata; hard refresh |
| Dopo l'update il tema "sparisce" o si duplica | Rinomina cartella fallita durante l'unzip | Controllare via (S)FTP che la cartella sia `regolia-wordpress-theme/`; vedi `fix_folder_name()` |
| Import pagine: 401 | Application Password errata/scaduta o utente senza privilegi | Rigenerare la Application Password da WP admin |
| Pagina importata non visibile sul sito | Creata come bozza (slug nuovo) | Pubblicarla da WP admin |
