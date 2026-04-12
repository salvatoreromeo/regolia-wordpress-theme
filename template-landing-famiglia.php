<?php
/**
 * Template Name: Landing — Famiglia (Loro al sicuro)
 *
 * Emotional angle. Speaks to the employer-as-caregiver: the adult child
 * arranging help for an elderly parent, the parent hiring a baby sitter.
 * Leans on the "senza pensieri" / "pensiamo a tutto noi" copy.
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
            <span class="rg-badge">Per la tua famiglia</span>
            <h1 class="rg-hero__title">
                Nessuna ansia.<br>
                Nessuna corsa.<br>
                <em>Tutto in regola.</em>
            </h1>
            <p class="rg-hero__sub">
                Chi si prende cura della tua famiglia merita un rapporto
                regolare. E tu puoi dormire sereno — a tutto il resto
                pensiamo noi.
            </p>
            <div class="rg-hero__actions">
                <a href="#prezzi" class="rg-btn rg-btn--primary rg-btn--lg">
                    Scopri quanto costa
                </a>
                <a href="#serenita" class="rg-btn rg-btn--ghost rg-btn--lg">
                    Perché farlo adesso
                </a>
            </div>
            <p class="rg-hero__note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21C6 16 3 12.5 3 9a4.5 4.5 0 019-1 4.5 4.5 0 019 1c0 3.5-3 7-9 12z"/></svg>
                Colf, badanti, baby sitter, dog sitter — tutte le figure.
            </p>
        </div>

        <div class="rg-hero__visual rg-hero__visual--illustration" aria-hidden="true">
            <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/supporto-esperto.webp' ) ); ?>"
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
     PERCHÉ FARLO ADESSO — 4 cards (famiglia)
     ═══════════════════════════════════════ -->
<section class="rg-features" id="serenita">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Serenità</span>
            <h2 class="rg-section-title">Perché farlo adesso</h2>
            <p class="rg-section-sub">
                Non è solo burocrazia. È la tranquillità di sapere che
                chi entra in casa tua è al suo posto.
            </p>
        </div>
        <div class="rg-features__grid rg-features__grid--4">

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/compliance-inps.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Serenità</h3>
                <p class="rg-feature-card__desc">Sai che chi si occupa dei tuoi cari è in regola. Niente telefonate dall'INPS, niente vertenze.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/gestione-ferie.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Continuità</h3>
                <p class="rg-feature-card__desc">Un rapporto stabile. Il tuo collaboratore ha motivo di restare, tu non ricominci da capo.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/contratti-digitali.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Chiarezza</h3>
                <p class="rg-feature-card__desc">Contratto scritto, ore definite, compiti chiari. Nessuna ambiguità che rovina i rapporti.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/cedolini-automatici.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Riconoscenza</h3>
                <p class="rg-feature-card__desc">Chi ti aiuta ogni giorno merita rispetto. Un cedolino puntuale è il modo più concreto di dirlo.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     TESTIMONIAL FAMIGLIA
     ═══════════════════════════════════════ -->
<section class="rg-quote">
    <div class="rg-container">
        <blockquote class="rg-quote__box">
            <p class="rg-quote__text">&ldquo;Ho messo in regola la badante di mia madre. Dormo di nuovo.&rdquo;</p>
            <p class="rg-quote__sub">
                Tu decidi chi ti aiuta. A contratto, contributi, buste
                paga e assistenza, da quel momento pensiamo a tutto noi.
            </p>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg">
                Metti tutto in regola
            </a>
        </blockquote>
    </div>
</section>

<?php get_template_part( 'parts/landing-common-footer' ); ?>

</main>

<?php get_footer(); ?>
