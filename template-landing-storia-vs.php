<?php
/**
 * Template Name: Landing — Storia VS (Marco & Luca)
 *
 * Parallel-comparison storytelling landing: at each of three chapters the
 * page shows Marco's experience with Regolia side-by-side with Luca's
 * "a voce" / informal setup. Mirrors the opening slogan of
 * template-landing-conto-nero.php but reorganised, shortened and with a
 * lighter tone (no courtroom drama). Ends with the shared ledger/compare
 * block and the waitlist form.
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main-content" class="rg-story-main">

<!-- ═══════════════════════════════════════
     OPENING — same slogan as conto-nero
     ═══════════════════════════════════════ -->
<section class="rg-story__opening">
    <div class="rg-container rg-story__container">
        <span class="rg-badge rg-badge--light">Due storie, un confronto</span>
        <h1 class="rg-story__headline">
            Il lavoro in nero costa <em>meno</em>.<br>
            Finché non costa <em>troppo</em>.
        </h1>
        <p class="rg-story__lede">
            Marco ha scelto <strong>Regolia</strong>.<br>
            Luca ha fatto <strong>&ldquo;come al solito&rdquo;</strong>.<br>
            Stesso punto di partenza, stesse ore, stessa paga.
            Due finali molto diversi.
        </p>
        <a href="#capitolo-1" class="rg-btn rg-btn--ghost rg-btn--lg rg-story__opening-cta">
            Guarda come va &darr;
        </a>
    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 1 — GIORNO 1 — LA SCELTA
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter" id="capitolo-1">
    <div class="rg-storia-vs__container">

        <div class="rg-storia-vs__chapter-header">
            <span class="rg-storia-vs__chapter-tag">Capitolo 1</span>
            <span class="rg-storia-vs__chapter-time">Giorno 1</span>
            <h2 class="rg-storia-vs__chapter-title">La scelta</h2>
        </div>

        <div class="rg-storia-vs__split">

            <div class="rg-storia-vs__side rg-storia-vs__side--marco">
                <span class="rg-storia-vs__side-label">Marco · con Regolia</span>
                <figure class="rg-storia-vs__side-scene">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/marco-01-scelta.webp' ) ); ?>"
                         alt=""
                         width="960"
                         height="540"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="rg-storia-vs__side-text">
                    <p>
                        Anna comincia martedì. Marco apre Regolia dal cellulare,
                        inserisce le ore, sceglie il contratto CCNL. Tutto firmato
                        in dieci minuti, senza mettere piede in uno studio.
                    </p>
                    <p>
                        Da quel momento: buste paga, contributi INPS, TFR,
                        assistenza. <strong>Pensiamo a tutto noi.</strong>
                    </p>
                </div>
                <span class="rg-storia-vs__side-pill">
                    Costo: <strong>€30/mese</strong> · tutto incluso
                </span>
            </div>

            <div class="rg-storia-vs__side rg-storia-vs__side--luca">
                <span class="rg-storia-vs__side-label">Luca · come al solito</span>
                <figure class="rg-storia-vs__side-scene">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/luca-01-scelta.webp' ) ); ?>"
                         alt=""
                         width="960"
                         height="540"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="rg-storia-vs__side-text">
                    <p>
                        Anche Luca comincia martedì con Anna. Stesse ore,
                        stessa paga oraria. Si accordano a parole:
                        pagamento in contanti ogni venerdì, niente contratto.
                    </p>
                    <p>
                        Lo fanno in tanti. Per Luca i €30 al mese di Regolia
                        possono restare in tasca: niente di cui preoccuparsi.
                    </p>
                </div>
                <span class="rg-storia-vs__side-pill">
                    Costo: <strong>€0</strong> · risparmiati (per ora)
                </span>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 2 — MESE 6 — UN IMPREVISTO
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter rg-story__chapter--alt" id="capitolo-2">
    <div class="rg-storia-vs__container">

        <div class="rg-storia-vs__chapter-header">
            <span class="rg-storia-vs__chapter-tag">Capitolo 2</span>
            <span class="rg-storia-vs__chapter-time">Mese 6</span>
            <h2 class="rg-storia-vs__chapter-title">Un imprevisto</h2>
        </div>

        <div class="rg-storia-vs__split">

            <div class="rg-storia-vs__side rg-storia-vs__side--marco">
                <span class="rg-storia-vs__side-label">Marco · con Regolia</span>
                <figure class="rg-storia-vs__side-scene">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/marco-02-imprevisto.webp' ) ); ?>"
                         alt=""
                         width="960"
                         height="540"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="rg-storia-vs__side-text">
                    <p>
                        Anna si scotta cucinando. Niente di grave: una visita,
                        un paio di giorni fermi. Marco apre l'app, segnala
                        l'evento, e&hellip; basta.
                    </p>
                    <p>
                        <strong>La copertura INAIL</strong> attiva dal giorno uno
                        fa il suo lavoro. Marco non anticipa un euro.
                    </p>
                </div>
                <span class="rg-storia-vs__side-pill">
                    Di tasca sua: <strong>€0</strong>
                </span>
            </div>

            <div class="rg-storia-vs__side rg-storia-vs__side--luca">
                <span class="rg-storia-vs__side-label">Luca · come al solito</span>
                <figure class="rg-storia-vs__side-scene">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/luca-02-imprevisto.webp' ) ); ?>"
                         alt=""
                         width="960"
                         height="540"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="rg-storia-vs__side-text">
                    <p>
                        Stesso imprevisto in casa di Luca. Stessa visita,
                        stessi giorni fermi. Ma senza contratto <strong>niente
                        INAIL</strong>, e le spese le tira fuori lui <strong>per legge</strong>: visita,
                        farmaci, i giorni non lavorati.
                    </p>
                    <p>
                        Non è una tragedia. È una sorpresa che non aveva
                        messo in conto.
                    </p>
                </div>
                <span class="rg-storia-vs__side-pill">
                    Di tasca sua: <strong>~€650</strong>
                </span>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 3 — ANNO 2 — IL BILANCIO
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter" id="capitolo-3">
    <div class="rg-storia-vs__container">

        <div class="rg-storia-vs__chapter-header">
            <span class="rg-storia-vs__chapter-tag">Capitolo 3</span>
            <span class="rg-storia-vs__chapter-time">Anno 2</span>
            <h2 class="rg-storia-vs__chapter-title">Il bilancio</h2>
        </div>

        <div class="rg-storia-vs__split">

            <div class="rg-storia-vs__side rg-storia-vs__side--marco">
                <span class="rg-storia-vs__side-label">Marco · con Regolia</span>
                <figure class="rg-storia-vs__side-scene">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/marco-03-bilancio.webp' ) ); ?>"
                         alt=""
                         width="960"
                         height="540"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="rg-storia-vs__side-text">
                    <p>
                        Sono passati due anni. Arriva la <strong>CU</strong>,
                        pronta per il 730. Marco scarica le detrazioni,
                        controlla la dashboard e va a fare colazione.
                    </p>
                    <p>
                        <em>&ldquo;Mi ero quasi dimenticato di avere una
                        colf&rdquo;</em>, dice a un amico. E lo pensa davvero:
                        tutto funziona da solo.
                    </p>
                </div>
                <span class="rg-storia-vs__side-pill">
                    Sempre <strong>€30/mese</strong> · + detrazioni
                </span>
            </div>

            <div class="rg-storia-vs__side rg-storia-vs__side--luca">
                <span class="rg-storia-vs__side-label">Luca · come al solito</span>
                <figure class="rg-storia-vs__side-scene">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/luca-03-bilancio.webp' ) ); ?>"
                         alt=""
                         width="960"
                         height="540"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="rg-storia-vs__side-text">
                    <p>
                        Due anni dopo, a Luca arrivano un paio di sorprese
                        in più: una richiesta di arretrati e una verifica
                        INPS. Tutto sommato, parliamo di oltre €12.000.
                    </p>
                    <p>
                        Niente detrazioni nel 730. E un pensiero in più
                        ogni volta che apre la cassetta della posta.
                    </p>
                </div>
                <span class="rg-storia-vs__side-pill">
                    A fine storia: <strong>oltre €12.000</strong> · in un colpo
                </span>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     IL CONTO — BIG COMPARE (good first)
     ═══════════════════════════════════════ -->
<section class="rg-story__ledger" id="il-conto">
    <div class="rg-container rg-story__container">

        <div class="rg-story__ledger-header">
            <span class="rg-badge rg-badge--light">Il conto a fine storia</span>
            <h2 class="rg-story__ledger-title">Stesse ore. Stesso stipendio. Vita diversa.</h2>
        </div>

        <div class="rg-story__compare">

            <div class="rg-story__compare-card rg-story__compare-card--good">
                <span class="rg-story__compare-label">La via di Marco</span>
                <span class="rg-story__compare-number">€&nbsp;30<small>/mese</small></span>
                <ul class="rg-story__compare-list">
                    <li>Contratto CCNL firmato digitalmente</li>
                    <li>INPS versati nei termini, ogni trimestre</li>
                    <li>TFR accantonato, CU annuale pronta per il 730</li>
                    <li>Copertura INAIL attiva dal giorno uno</li>
                </ul>
                <p class="rg-story__compare-foot">
                    Sempre €30, ogni mese. Serenità inclusa.
                </p>
            </div>

            <div class="rg-story__compare-vs" aria-hidden="true">vs</div>

            <div class="rg-story__compare-card rg-story__compare-card--bad">
                <span class="rg-story__compare-label">La via di Luca</span>
                <span class="rg-story__compare-number">€&nbsp;12.500</span>
                <ul class="rg-story__compare-list">
                    <li>Imprevisto a carico suo</li>
                    <li>Arretrati e contributi non versati</li>
                    <li>Nessuna detrazione nel 730</li>
                </ul>
                <p class="rg-story__compare-foot">
                    In due anni. Più lo stress, che non si mette a bilancio.
                </p>
            </div>

        </div>

        <p class="rg-story__ledger-kicker">
            Stesso stipendio, stesse ore, <strong>vita diversa</strong>.
        </p>
        <div class="rg-story__ledger-cta">
            <button
                type="button"
                class="rg-btn rg-btn--primary rg-btn--lg js-focus-email-input"
                data-target-input="#rg-waitlist-email"
            >
                Scegli Regolia
            </button>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     FINALE
     ═══════════════════════════════════════ -->
<section class="rg-story__finale" id="waitlist">
    <div class="rg-container rg-story__container">
        <h2 class="rg-story__finale-title">
            Comincia oggi.<br>
            Dormi <em>sereno</em> da domani.
        </h2>
        <p class="rg-story__finale-sub">
            Inserisci la tua email e ti guidiamo passo passo. Contratto,
            buste paga, contributi, assistenza — pensiamo a tutto noi.
        </p>
        <form class="rg-waitlist__form rg-story__finale-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="regolia_waitlist">
            <?php wp_nonce_field( 'regolia_waitlist_nonce', 'rg_nonce' ); ?>
            <div class="rg-waitlist__fields">
                <input
                    type="email"
                    id="rg-waitlist-email"
                    name="email"
                    class="rg-input"
                    placeholder="La tua email"
                    required
                    autocomplete="email"
                >
                <button type="submit" class="rg-btn rg-btn--primary rg-btn--lg">
                    Scegli Regolia &rarr;
                </button>
            </div>
            <p class="rg-waitlist__note">
                Nessun addebito fino all'attivazione del servizio.
            </p>
        </form>
    </div>
</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var buttons = Array.prototype.slice.call(document.querySelectorAll('.js-focus-email-input'));
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            var selector = button.getAttribute('data-target-input');
            var input = selector ? document.querySelector(selector) : null;
            if (!input) return;
            input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            window.setTimeout(function () {
                input.focus({ preventScroll: true });
            }, 220);
        });
    });
});
</script>

<?php get_footer(); ?>
