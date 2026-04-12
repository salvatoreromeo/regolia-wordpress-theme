<?php
/**
 * Template Name: Landing — Compliance (Zero vertenze)
 *
 * Compliance-first angle for employers who fear the legal side more than
 * the operational side: INPS deadlines, CCNL minimums, dismissal
 * procedures, audit trail. Leans on eIDAS, timestamping, log
 * completeness — "enterprise compliance applied to domestic work".
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
            <span class="rg-badge">Conformità</span>
            <h1 class="rg-hero__title">
                Zero vertenze.<br>
                Zero sanzioni.<br>
                <em>Tutto in regola.</em>
            </h1>
            <p class="rg-hero__sub">
                CCNL aggiornato, contributi INPS versati entro i termini,
                firma digitale con log elettronico, livello B eIDAS.
                Regolia gestisce la compliance — tu gestisci la tua casa.
            </p>
            <div class="rg-hero__actions">
                <a href="#prezzi" class="rg-btn rg-btn--primary rg-btn--lg">
                    Attiva subito
                </a>
                <a href="#conformita" class="rg-btn rg-btn--ghost rg-btn--lg">
                    Vedi le garanzie
                </a>
            </div>
            <p class="rg-hero__note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V7z"/><path d="M5 12l5 5L19 7"/></svg>
                Audit trail completo: timestamp, dispositivo, IP.
            </p>
        </div>

        <div class="rg-hero__visual rg-hero__visual--illustration" aria-hidden="true">
            <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/compliance-inps.webp' ) ); ?>"
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
     GARANZIE DI CONFORMITÀ — 4 cards
     ═══════════════════════════════════════ -->
<section class="rg-features" id="conformita">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Garanzie</span>
            <h2 class="rg-section-title">Conformità, passo per passo</h2>
            <p class="rg-section-sub">
                Ogni obbligo normativo è gestito da Regolia. La responsabilità
                resta tua solo dove la legge lo richiede.
            </p>
        </div>
        <div class="rg-features__grid rg-features__grid--4">

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/contratti-digitali.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">CCNL conforme</h3>
                <p class="rg-feature-card__desc">Contratto sempre allineato al CCNL Lavoro Domestico. Alert se la retribuzione scende sotto il minimo.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/compliance-inps.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">INPS automatico</h3>
                <p class="rg-feature-card__desc">Contributi calcolati e versati entro la scadenza trimestrale. Zero dimenticanze.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/supporto-esperto.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Firma eIDAS</h3>
                <p class="rg-feature-card__desc">Firma digitale OTP con valore legale. Recapito elettronico livello B eIDAS, validità europea.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/gestione-ferie.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Log completo</h3>
                <p class="rg-feature-card__desc">Timestamp, userID, dispositivo, IP e marca temporale per ogni operazione. Tracciabilità totale.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     TESTIMONIAL COMPLIANCE
     ═══════════════════════════════════════ -->
<section class="rg-quote">
    <div class="rg-container">
        <blockquote class="rg-quote__box">
            <p class="rg-quote__text">&ldquo;In caso di controllo, ho tutto pronto in PDF. Questo vale ogni centesimo.&rdquo;</p>
            <p class="rg-quote__sub">
                Contratto, cedolini, F24, CU, storico versamenti. Regolia
                li conserva e li rende esportabili in qualsiasi momento.
            </p>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg">
                Conferma e attiva Regolia
            </a>
        </blockquote>
    </div>
</section>

<?php get_template_part( 'parts/landing-common-footer' ); ?>

</main>

<?php get_footer(); ?>
