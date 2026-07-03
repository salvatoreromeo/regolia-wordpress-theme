#!/usr/bin/env bash
# Testa la connettività verso il server di produzione Regolia (Hetzner).
#
# Uso:
#   ./tools/check-prod-connection.sh                      # HTTP + porta 22 + versioni
#   ./tools/check-prod-connection.sh -i ~/projects/ssh/ssh-key   # + test di UNA chiave SSH
#   ./tools/check-prod-connection.sh -p                   # + login a password (interattivo)
#   ./tools/check-prod-connection.sh -u admin -i <chiave> # utente diverso da root
set -u

HOST="178.104.215.167"
USER="root"
KEY=""
TRY_PASSWORD=0

while getopts "u:i:ph" opt; do
  case "$opt" in
    u) USER="$OPTARG" ;;
    i) KEY="$OPTARG" ;;
    p) TRY_PASSWORD=1 ;;
    h) grep '^#' "$0" | sed -n '2,8p'; exit 0 ;;
    *) exit 1 ;;
  esac
done

green() { printf '\033[32m%s\033[0m\n' "$*"; }
red()   { printf '\033[31m%s\033[0m\n' "$*"; }
info()  { printf '\033[36m%s\033[0m\n' "$*"; }

info "═══ Regolia prod check — ${USER}@${HOST} ═══"

# ── 1. Sito HTTP + versioni ──
printf '%-45s' "HTTP (sito WordPress):"
code=$(curl -s -o /dev/null -w '%{http_code}' --max-time 8 "http://${HOST}/" || true)
[ "$code" = "200" ] && green "OK (200)" || red "FAIL (${code:-timeout})"

printf '%-45s' "Versione tema in prod:"
ver=$(curl -s --max-time 8 "http://${HOST}/wp-content/themes/regolia-wordpress-theme/style.css" | grep -m1 '^Version:' | awk '{print $2}')
[ -n "${ver:-}" ] && green "$ver" || red "non rilevata"

printf '%-45s' "Ultima release GitHub (usata dall'updater):"
rel=$(curl -s --max-time 8 https://api.github.com/repos/salvatoreromeo/regolia-wordpress-theme/releases/latest | grep -m1 '"tag_name"' | cut -d'"' -f4)
[ -n "${rel:-}" ] && green "$rel" || red "non rilevata"

# ── 2. Porta SSH ──
printf '%-45s' "Porta 22 raggiungibile:"
if command -v nc >/dev/null && nc -z -w 5 "$HOST" 22 2>/dev/null; then
  green "OK"
else
  red "chiusa/timeout"
fi

# ── 3. Chiave SSH indicata con -i ──
if [ -n "$KEY" ]; then
  info "── Test chiave: $KEY ──"
  if [ ! -f "$KEY" ]; then
    red "File non trovato."
  else
    tmp=$(mktemp); cp "$KEY" "$tmp"; chmod 600 "$tmp"   # evita l'errore 'permissions too open'
    printf '%-45s' "  autenticazione a chiave:"
    if ssh -o BatchMode=yes -o ConnectTimeout=6 -o IdentitiesOnly=yes \
           -o StrictHostKeyChecking=accept-new -i "$tmp" \
           "${USER}@${HOST}" 'echo ok' >/dev/null 2>&1; then
      green "ACCESSO OK ✔"
      echo "  Info server:"
      ssh -o BatchMode=yes -o IdentitiesOnly=yes -i "$tmp" "${USER}@${HOST}" \
          'echo "    hostname: $(hostname)"; echo "    wp-cli:   $(command -v wp || echo assente)"; echo "    docroot:  $(dirname $(find /var/www -name wp-config.php 2>/dev/null | head -1) 2>/dev/null)"'
    else
      red "rifiutata"
    fi
    rm -f "$tmp"
  fi
fi

# ── 4. Login a password (solo con -p) ──
if [ "$TRY_PASSWORD" = "1" ]; then
  info "── Login a password (inserisci la password al prompt) ──"
  echo "  Password iniziale nell'email Hetzner 'Server regolia created' (2026-04-21)."
  ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no \
      -o ConnectTimeout=8 "${USER}@${HOST}" \
      'echo LOGIN_OK; hostname; command -v wp || echo "wp-cli assente"' \
    && echo "  Per autorizzare la tua chiave: ssh-copy-id ${USER}@${HOST}"
fi

info "═══ Fine ═══"
