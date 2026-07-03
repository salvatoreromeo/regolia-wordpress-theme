# Deploy — Aggiornare il sito Regolia in produzione

> Produzione: **http://178.104.215.167/** (server Hetzner "regolia", Debian).
> Ultima verifica di questo documento: 2026-07-03 (deploy v1.6.0 → v1.8.2 riuscito).

## Infrastruttura prod (importante)

Il sito **NON** è un'installazione WordPress nativa: gira in **Docker**.
`php`/`wp-cli` non sono nel PATH dell'host. Container in esecuzione:

| Container | Immagine | Ruolo |
|---|---|---|
| `regolia-wordpress-wordpress-1` | wordpress:latest | il sito WP (porta 80) |
| `regolia-wordpress-db-1` | mariadb | DB del sito |
| `regolia-prod-app` | regolia-app | l'app Regolia vera e propria (porta 5000) — **non toccare** |
| `regolia-prod-db` | postgres:17 | DB dell'app — **non toccare** |

- Docroot WP nel volume: `/var/lib/docker/volumes/regolia-wordpress_wp_data/_data`
- Compose del sito: `/regolia-wordpress/docker-compose.yml`
- Accesso: `ssh -i ~/projects/ssh/github_regolia/id_ssh root@178.104.215.167`
  (chiave già installata in `authorized_keys`).

### wp-cli via container (pattern riutilizzabile)

wordpress:latest non include wp-cli. Si usa un container `wordpress:cli`
effimero, con **due accortezze scoperte sul campo**:

1. **`--user 33:33`** — i file del volume sono di www-data UID **33** (Debian),
   ma `wordpress:cli` gira di default come UID **82** (Alpine): senza `--user 33:33`
   gli update dei file falliscono con "Could not create directory".
2. **Credenziali DB da env-file**, mai in chiaro nel comando (le legge dal
   container in esecuzione).
3. **Niente `-i`** in `docker run` dentro un heredoc SSH: consuma lo stdin
   dello script e tronca i comandi successivi.

```bash
ssh -i ~/projects/ssh/github_regolia/id_ssh root@178.104.215.167 'bash -s' <<'REMOTE'
WC=regolia-wordpress-wordpress-1; NET=regolia-wordpress_default
ENVF=$(mktemp); docker inspect "$WC" --format '{{range .Config.Env}}{{println .}}{{end}}' | grep '^WORDPRESS_DB' > "$ENVF"
wpcli() { docker run --rm --user 33:33 --volumes-from "$WC" --network "$NET" --env-file "$ENVF" wordpress:cli sh -c "$1" 2>/dev/null; }
wpcli 'wp theme list'
rm -f "$ENVF"
REMOTE
```

Test rapido di connettività/ambiente: `./tools/check-prod-connection.sh -i ~/projects/ssh/github_regolia/id_ssh`.

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

### 1c. Applicare l'aggiornamento su prod (via wp-cli in Docker)

```bash
ssh -i ~/projects/ssh/github_regolia/id_ssh root@178.104.215.167 'bash -s' <<'REMOTE'
set -e
WC=regolia-wordpress-wordpress-1; NET=regolia-wordpress_default
THEMES=/var/lib/docker/volumes/regolia-wordpress_wp_data/_data/wp-content/themes
ENVF=$(mktemp); docker inspect "$WC" --format '{{range .Config.Env}}{{println .}}{{end}}' | grep '^WORDPRESS_DB' > "$ENVF"
wpcli() { docker run --rm --user 33:33 --volumes-from "$WC" --network "$NET" --env-file "$ENVF" wordpress:cli sh -c "$1" 2>/dev/null; }
tar czf /root/regolia-theme-backup-$(date +%Y%m%d-%H%M%S).tgz -C "$THEMES" regolia-wordpress-theme   # backup
wpcli 'wp transient delete --all'                       # forza il ricontrollo dell'updater
wpcli 'wp theme update regolia-wordpress-theme'         # scarica la GitHub Release e installa
wpcli 'wp theme get regolia-wordpress-theme --field=version'
rm -f "$ENVF"
REMOTE
```

In alternativa dal pannello: WP admin → Bacheca → Aggiornamenti → "Verifica di
nuovo" → Aspetto → Temi → Regolia → Aggiorna. (Il fix dei permessi di
`wp-content/upgrade` non serve più: dopo il primo update via UID 33 la cartella
resta scrivibile.)

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

### Metodo A — via wp-cli in Docker (usato per il deploy 2026-07-03)

Non richiede Application Password: si convertono i markdown in HTML in locale e
si applicano via wp-cli. Le pagine hanno solo figure inline (URL asset del
tema), nessuna immagine in evidenza da caricare.

1. Genera l'HTML in locale (usa la stessa conversione di blog-sync):

```bash
cd tools/blog-sync
export OUT=/tmp/deploy-pages && mkdir -p "$OUT"
node --input-type=module <<'JS'
import fs from 'node:fs'; import path from 'node:path'; import matter from 'gray-matter';
import { markdownToHtml } from './lib/md-to-html.mjs';
const OUT = process.env.OUT;
for (const slug of ['perche-regolia','servizi','come-funziona']) {
  const { data: fm, content } = matter(fs.readFileSync(`content/pages/${slug}.md`,'utf8'));
  fs.writeFileSync(path.join(OUT, slug+'.html'), markdownToHtml(content));
  fs.writeFileSync(path.join(OUT, slug+'.title'), fm.title||'');
  fs.writeFileSync(path.join(OUT, slug+'.excerpt'), (fm.excerpt||'').trim());
}
JS
tar czf - -C "$OUT" . | ssh -i ~/projects/ssh/github_regolia/id_ssh root@178.104.215.167 \
  'rm -rf /root/deploy-pages && mkdir -p /root/deploy-pages && tar xzf - -C /root/deploy-pages'
```

2. Applica sul server (monta `/root/deploy-pages` nel container cli a `/pages`;
   passa titoli/excerpt con `$(cat …)` per evitare problemi di quoting):

```bash
ssh -i ~/projects/ssh/github_regolia/id_ssh root@178.104.215.167 'bash -s' <<'REMOTE'
set -e
WC=regolia-wordpress-wordpress-1; NET=regolia-wordpress_default
ENVF=$(mktemp); docker inspect "$WC" --format '{{range .Config.Env}}{{println .}}{{end}}' | grep '^WORDPRESS_DB' > "$ENVF"
wpcli() { docker run --rm --user 33:33 -v /root/deploy-pages:/pages:ro --volumes-from "$WC" --network "$NET" --env-file "$ENVF" wordpress:cli sh -c "$1" 2>/dev/null; }
# ID pagine: servizi=8, come-funziona=9, chi-siamo=7 (verifica con: wpcli 'wp post list --post_type=page --fields=ID,post_name')
wpcli 'wp post update 8 /pages/servizi.html --post_title="$(cat /pages/servizi.title)" --post_excerpt="$(cat /pages/servizi.excerpt)"'
wpcli 'wp post update 9 /pages/come-funziona.html --post_title="$(cat /pages/come-funziona.title)" --post_excerpt="$(cat /pages/come-funziona.excerpt)"'
rm -f "$ENVF"
REMOTE
```

⚠️ **Niente `-i` nel `docker run`** dentro l'heredoc (consuma lo stdin e tronca).

### Metodo B — via REST (blog-sync import)

Richiede una **Application Password** admin (WP admin → Utenti → Profilo).

```bash
cd tools/blog-sync && npm install
WP_URL=http://178.104.215.167 WP_USER=<admin> WP_APP_PASSWORD="xxxx …" \
  node import.mjs --type pages --interactive
```

- Pagine esistenti (per slug) → aggiornate, stato preservato; slug nuovi → bozza.
- **Non** importa `home`/`blog`/`contatti` se non vuoi toccarle: usa `--dir` su
  una cartella filtrata, oppure il Metodo A (selettivo per ID).
- ⚠️ Esiste un seed `landing-storia-vs.md` che creerebbe una bozza superflua:
  escludilo o cancellala dopo.

Dettagli completi: `tools/blog-sync/README.md`.

---

## 3. Pubblicazione, chi-siamo→bozza, menu (via wp-cli)

Esempio reale usato il 2026-07-03 (crea `perche-regolia` pubblicata, manda
`chi-siamo` in bozza, ripunta la voce di menu). ID prod: chi-siamo=7,
perche-regolia=18, menu "Principale"=term 2, voce "Chi siamo"=db_id 11.

```bash
ssh -i ~/projects/ssh/github_regolia/id_ssh root@178.104.215.167 'bash -s' <<'REMOTE'
set -e
WC=regolia-wordpress-wordpress-1; NET=regolia-wordpress_default
ENVF=$(mktemp); docker inspect "$WC" --format '{{range .Config.Env}}{{println .}}{{end}}' | grep '^WORDPRESS_DB' > "$ENVF"
wpcli() { docker run --rm --user 33:33 -v /root/deploy-pages:/pages:ro --volumes-from "$WC" --network "$NET" --env-file "$ENVF" wordpress:cli sh -c "$1" 2>/dev/null; }
# crea/pubblica perche-regolia (se non esiste)
wpcli 'wp post create /pages/perche-regolia.html --post_type=page --post_status=publish --post_name=perche-regolia --post_title="$(cat /pages/perche-regolia.title)" --post_excerpt="$(cat /pages/perche-regolia.excerpt)" --porcelain'
wpcli 'wp post update 7 --post_status=draft'      # chi-siamo -> bozza
# ripunta la voce di menu (wp-cli 7.x: 'wp menu item update' NON accetta type/id posizionali → usare postmeta)
wpcli 'wp post meta update 11 _menu_item_object_id 18'
wpcli 'wp post update 11 --post_title="Perché Regolia"'
rm -f "$ENVF"
REMOTE
```

Nota wp-cli 7.x: `wp menu item update <id> post <objid>` dà "Too many
positional arguments" → aggiornare `_menu_item_object_id` via `wp post meta`.

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
| `wp theme update` scarica la versione *precedente* / "Theme already updated" a versione vecchia | `releases/latest` lato GitHub ha un lag di qualche minuto dopo `create`, e il transient `regolia_gh_release_*` resta cache-ato 1h | Attendere che `curl .../releases/latest` mostri il nuovo tag, poi `wp transient delete --all` e ritentare. In alternativa **deploy diretto dei file** (bypassa l'updater): `git archive --prefix=regolia-wordpress-theme/ vX.Y.Z \| gzip \| ssh … 'cat > /root/t.tgz'` poi sul server `tar xzf /root/t.tgz -C <themes-dir> && chown -R 33:33 <themes-dir>/regolia-wordpress-theme`. ⚠️ non pipare il tarball e un heredoc sulla stessa connessione ssh (conflitto di stdin): caricare il file prima, estrarlo in un secondo comando |
| Pagina con page-template del tema mostra corpo vuoto | Il file `template-*.php` non è ancora su prod (tema non aggiornato) o manca il meta `_wp_page_template` | Aggiornare il tema prima; poi `wp post meta update <id> _wp_page_template template-<x>.php` |
| Colori/CSS vecchi dopo l'update | Cache browser sulla CSS con stesso `?ver=` | Verificare che la Version del tema sia stata bumpata; hard refresh |
| Dopo l'update il tema "sparisce" o si duplica | Rinomina cartella fallita durante l'unzip | Controllare via (S)FTP che la cartella sia `regolia-wordpress-theme/`; vedi `fix_folder_name()` |
| Import pagine: 401 | Application Password errata/scaduta o utente senza privilegi | Rigenerare la Application Password da WP admin |
| Pagina importata non visibile sul sito | Creata come bozza (slug nuovo) | Pubblicarla da WP admin |
