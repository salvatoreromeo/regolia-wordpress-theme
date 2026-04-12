<?php
/**
 * Template Name: Landing — Il conto del nero (storytelling)
 *
 * Narrative, timeline-based landing unlike the hero+4-card layout shared
 * by the other templates. Tells the story of Luca and Anna across four
 * chronological chapters (Giorno 1, Mese 6, Anno 1, Anno 2), with a
 * cumulative running cost counter that grows at each chapter. Ends with
 * a large number comparison (total cost of the informal route vs the
 * €30/mese of Regolia) and a final CTA.
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main-content" class="rg-story-main">

<!-- ═══════════════════════════════════════
     OPENING
     ═══════════════════════════════════════ -->
<section class="rg-story__opening">
    <div class="rg-container rg-story__container">
        <span class="rg-badge rg-badge--light">Una storia vera</span>
        <h1 class="rg-story__headline">
            Il lavoro in nero costa <em>meno</em>.<br>
            Finché non costa <em>troppo</em>.
        </h1>
        <p class="rg-story__lede">
            Luca assume Anna come colf, in modo informale.
            Nei due anni seguenti succedono <strong>quattro cose</strong> che
            nessuno aveva previsto. Il contatore parte da zero.
        </p>
        <div class="rg-story__counter rg-story__counter--start">
            <span class="rg-story__counter-label">Conto corrente del rapporto</span>
            <span class="rg-story__counter-value">€&nbsp;0</span>
        </div>
        <a href="#capitolo-1" class="rg-btn rg-btn--ghost rg-btn--lg">
            Comincia a contare &darr;
        </a>
    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 1 — GIORNO 1
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter" id="capitolo-1">
    <div class="rg-container rg-story__container rg-story__chapter-inner">

        <div class="rg-story__chapter-meta">
            <span class="rg-story__chapter-tag">Capitolo 1</span>
            <span class="rg-story__chapter-time">Giorno 1</span>
            <h2 class="rg-story__chapter-title">La scelta</h2>
        </div>

        <div class="rg-story__chapter-body">
            <figure class="rg-story__scene">
                <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/01-scelta.webp' ) ); ?>"
                     alt=""
                     width="960"
                     height="540"
                     loading="lazy"
                     decoding="async">
            </figure>
            <div class="rg-story__chapter-text">
                <p>
                    Luca ha bisogno di una mano per la casa. Anna è puntuale,
                    cordiale, bravissima. Si accordano per 20 ore a settimana,
                    €8 l'ora, pagamento in contanti ogni venerdì.
                </p>
                <p class="rg-story__quote">
                    &ldquo;Ma sì, facciamo senza contratto. A chi vuoi che
                    interessi?&rdquo;
                </p>
                <p class="rg-story__note">
                    Luca risparmia sul costo del servizio Regolia.
                    <strong>€30 al mese &times; 24 mesi = €720</strong>.
                    È l'unico numero positivo di questa storia.
                </p>
            </div>
        </div>

        <div class="rg-story__counter">
            <span class="rg-story__counter-label">Totale dopo il capitolo 1</span>
            <span class="rg-story__counter-value">&minus;&nbsp;€&nbsp;720 <small>risparmiati</small></span>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 2 — MESE 6
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter rg-story__chapter--alt" id="capitolo-2">
    <div class="rg-container rg-story__container rg-story__chapter-inner rg-story__chapter-inner--reverse">

        <div class="rg-story__chapter-meta">
            <span class="rg-story__chapter-tag">Capitolo 2</span>
            <span class="rg-story__chapter-time">Mese 6</span>
            <h2 class="rg-story__chapter-title">La caduta</h2>
        </div>

        <div class="rg-story__chapter-body">
            <figure class="rg-story__scene">
                <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/02-caduta.webp' ) ); ?>"
                     alt=""
                     width="960"
                     height="540"
                     loading="lazy"
                     decoding="async">
            </figure>
            <div class="rg-story__chapter-text">
                <p>
                    Anna scivola mentre pulisce le scale. Contusione alla
                    spalla, tre settimane di riposo. Va al pronto soccorso.
                    Quando il medico chiede dove ha lavorato, risponde:
                    <em>«In casa di un privato, senza contratto.»</em>
                </p>
                <p>
                    Il codice civile è chiaro: il datore è responsabile per
                    gli infortuni occorsi al lavoratore in sua casa. Senza
                    copertura INAIL, Luca paga di tasca sua: visite, farmaci,
                    le tre settimane non lavorate. E ringrazia che sia
                    finita così.
                </p>
                <p class="rg-story__note">
                    Costo stimato di questo capitolo:
                    <strong>€2.800</strong>.
                </p>
            </div>
        </div>

        <div class="rg-story__counter">
            <span class="rg-story__counter-label">Totale dopo il capitolo 2</span>
            <span class="rg-story__counter-value">€&nbsp;2.080</span>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 3 — ANNO 1
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter" id="capitolo-3">
    <div class="rg-container rg-story__container rg-story__chapter-inner">

        <div class="rg-story__chapter-meta">
            <span class="rg-story__chapter-tag">Capitolo 3</span>
            <span class="rg-story__chapter-time">Anno 1</span>
            <h2 class="rg-story__chapter-title">La lettera</h2>
        </div>

        <div class="rg-story__chapter-body">
            <figure class="rg-story__scene">
                <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/03-lettera.webp' ) ); ?>"
                     alt=""
                     width="960"
                     height="540"
                     loading="lazy"
                     decoding="async">
            </figure>
            <div class="rg-story__chapter-text">
                <p>
                    Arriva una raccomandata. Ispezione INPS. Un'ispezione
                    a campione nel suo quartiere, niente di personale.
                    Ma il controllo fa il suo lavoro: verbale, contestazione
                    di rapporto irregolare, recupero dei contributi omessi
                    per dodici mesi.
                </p>
                <p>
                    Più la maxi-sanzione amministrativa prevista dalla legge
                    per lavoro &ldquo;in nero&rdquo;. Non è la fine del
                    mondo, ma fa male.
                </p>
                <p class="rg-story__note">
                    Contributi arretrati + sanzione:
                    <strong>€3.200</strong>.
                </p>
            </div>
        </div>

        <div class="rg-story__counter">
            <span class="rg-story__counter-label">Totale dopo il capitolo 3</span>
            <span class="rg-story__counter-value">€&nbsp;5.280</span>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     CAPITOLO 4 — ANNO 2
     ═══════════════════════════════════════ -->
<section class="rg-story__chapter rg-story__chapter--alt" id="capitolo-4">
    <div class="rg-container rg-story__container rg-story__chapter-inner rg-story__chapter-inner--reverse">

        <div class="rg-story__chapter-meta">
            <span class="rg-story__chapter-tag">Capitolo 4</span>
            <span class="rg-story__chapter-time">Anno 2</span>
            <h2 class="rg-story__chapter-title">La vertenza</h2>
        </div>

        <div class="rg-story__chapter-body">
            <figure class="rg-story__scene">
                <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/storytelling/04-vertenza.webp' ) ); ?>"
                     alt=""
                     width="960"
                     height="540"
                     loading="lazy"
                     decoding="async">
            </figure>
            <div class="rg-story__chapter-text">
                <p>
                    Qualche mese dopo, Luca e Anna si separano per un motivo
                    banale. Anna si rivolge al sindacato. Chiede i suoi
                    arretrati. <strong>Ha ragione per legge</strong>.
                </p>
                <p>
                    Retribuzioni dovute ma mai regolarizzate, TFR mai
                    accantonato, differenze sui minimi CCNL, indennità di
                    preavviso. Un giudice del lavoro ci mette poche udienze
                    per deciderlo.
                </p>
                <p class="rg-story__note">
                    Somma liquidata: <strong>€7.220</strong>.
                </p>
            </div>
        </div>

        <div class="rg-story__counter">
            <span class="rg-story__counter-label">Totale dopo il capitolo 4</span>
            <span class="rg-story__counter-value">€&nbsp;12.500</span>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     IL CONTO — BIG COMPARE
     ═══════════════════════════════════════ -->
<section class="rg-story__ledger">
    <div class="rg-container rg-story__container">

        <div class="rg-story__ledger-header">
            <span class="rg-badge rg-badge--light">Il conto</span>
            <h2 class="rg-story__ledger-title">Il prezzo del &ldquo;tanto non succede&rdquo;</h2>
        </div>

        <div class="rg-story__compare">

            <div class="rg-story__compare-card rg-story__compare-card--bad">
                <span class="rg-story__compare-label">La via di Luca</span>
                <span class="rg-story__compare-number">€&nbsp;12.500</span>
                <ul class="rg-story__compare-list">
                    <li>Infortunio a carico suo</li>
                    <li>Contributi omessi + sanzione INPS</li>
                    <li>Vertenza con TFR e arretrati</li>
                </ul>
                <p class="rg-story__compare-foot">
                    In due anni. In un solo colpo, a fine vertenza.
                </p>
            </div>

            <div class="rg-story__compare-vs" aria-hidden="true">vs</div>

            <div class="rg-story__compare-card rg-story__compare-card--good">
                <span class="rg-story__compare-label">La via di Regolia</span>
                <span class="rg-story__compare-number">€&nbsp;720</span>
                <ul class="rg-story__compare-list">
                    <li>Contratto CCNL firmato digitalmente</li>
                    <li>INPS versati entro i termini, ogni trimestre</li>
                    <li>TFR accantonato, CU annuale</li>
                    <li>Copertura INAIL attiva dal giorno uno</li>
                </ul>
                <p class="rg-story__compare-foot">
                    €30 al mese per due anni. Punto.
                </p>
            </div>

        </div>

        <p class="rg-story__ledger-kicker">
            Luca ha &ldquo;risparmiato&rdquo; €720 di Regolia.
            Gli è costato <strong>17 volte tanto</strong>.
        </p>

    </div>
</section>

<!-- ═══════════════════════════════════════
     CTA FINALE
     ═══════════════════════════════════════ -->
<section class="rg-story__finale" id="waitlist">
    <div class="rg-container rg-story__container">
        <h2 class="rg-story__finale-title">
            Oggi è il giorno 1<br>
            <em>del tuo</em> rapporto.
        </h2>
        <p class="rg-story__finale-sub">
            A partire da domani, pensiamo a tutto noi. Contratto, buste paga,
            contributi, assistenza. Tu non devi fare nulla di più che assumere
            chi ti piace.
        </p>
        <form class="rg-waitlist__form rg-story__finale-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="regolia_waitlist">
            <?php wp_nonce_field( 'regolia_waitlist_nonce', 'rg_nonce' ); ?>
            <div class="rg-waitlist__fields">
                <input
                    type="email"
                    name="email"
                    class="rg-input"
                    placeholder="La tua email"
                    required
                    autocomplete="email"
                >
                <button type="submit" class="rg-btn rg-btn--primary rg-btn--lg">
                    Non essere Luca &rarr;
                </button>
            </div>
            <p class="rg-waitlist__note">
                Nessun addebito fino all'attivazione del servizio.
            </p>
        </form>
    </div>
</section>

</main>

<?php get_footer(); ?>
