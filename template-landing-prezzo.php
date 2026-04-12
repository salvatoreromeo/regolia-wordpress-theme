<?php
/**
 * Template Name: Landing — Prezzo (Tutto incluso a €30)
 *
 * Price-transparent angle. Answers the objection "quanto costa prima
 * di iscrivermi" up-front. Hero leads with the price block, benefits
 * are framed around included items and the absence of surprises.
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main-content">

<section class="rg-hero rg-hero--illustration">
    <div class="rg-container rg-hero__inner">

        <div class="rg-hero__copy">
            <span class="rg-badge">Prezzo fisso</span>
            <h1 class="rg-hero__title">
                Nessuna sorpresa.<br>
                Nessun costo nascosto.<br>
                <em>Tutto in regola.</em>
            </h1>
            <p class="rg-hero__sub">
                <strong>€30 al mese</strong> per dipendente.
                Buste paga, contributi INPS, TFR, Certificazione Unica
                annuale, assistenza dedicata. Punto.
            </p>
            <div class="rg-hero__actions">
                <a href="#prezzi" class="rg-btn rg-btn--primary rg-btn--lg">
                    Calcola il tuo costo
                </a>
                <a href="#incluso" class="rg-btn rg-btn--ghost rg-btn--lg">
                    Cosa è incluso
                </a>
            </div>
            <p class="rg-hero__note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21a9 9 0 100-18 9 9 0 000 18z"/><path d="M8 11h5"/><path d="M8 14h4"/></svg>
                Nessun addebito fino all'attivazione del servizio.
            </p>
        </div>

        <div class="rg-hero__visual rg-hero__visual--illustration" aria-hidden="true">
            <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/pagamenti-integrati.webp' ) ); ?>"
                 alt=""
                 width="520"
                 height="520"
                 loading="eager"
                 decoding="async"
                 class="rg-hero__illustration">
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     COSA È INCLUSO — 4 cards (prezzo)
     ═══════════════════════════════════════ -->
<section class="rg-features" id="incluso">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Trasparenza</span>
            <h2 class="rg-section-title">Tutto dentro, nulla fuori</h2>
            <p class="rg-section-sub">
                Ogni cosa che serve a tenere un rapporto in regola è
                già compresa nei €30 al mese. Nessuna sorpresa a fine anno.
            </p>
        </div>
        <div class="rg-features__grid rg-features__grid--4">

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/cedolini-automatici.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Tutto incluso</h3>
                <p class="rg-feature-card__desc">Buste paga, INPS, TFR, CU. Nessun pacchetto premium da aggiungere.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/pagamenti-integrati.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Prezzo fisso</h3>
                <p class="rg-feature-card__desc">€30/mese. Stesso importo da gennaio a dicembre, nessuna variazione stagionale.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/supporto-esperto.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Costo orario chiaro</h3>
                <p class="rg-feature-card__desc">Prima di iscriverti vedi il costo orario totale del tuo dipendente, contributi inclusi.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/gestione-ferie.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Flessibilità</h3>
                <p class="rg-feature-card__desc">Disdici quando vuoi, senza vincoli. Paghi solo i mesi in cui il rapporto è attivo.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     TESTIMONIAL PREZZO
     ═══════════════════════════════════════ -->
<section class="rg-quote">
    <div class="rg-container">
        <blockquote class="rg-quote__box">
            <p class="rg-quote__text">&ldquo;Sapere esattamente quanto spendo ogni mese cambia tutto.&rdquo;</p>
            <p class="rg-quote__sub">
                Nessuna telefonata al commercialista per scoprire l'ultimo
                costo aggiuntivo. Un importo, un servizio, una tranquillità.
            </p>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg">
                Scopri quanto costa davvero
            </a>
        </blockquote>
    </div>
</section>

<?php get_template_part( 'parts/landing-common-footer' ); ?>

</main>

<?php get_footer(); ?>
