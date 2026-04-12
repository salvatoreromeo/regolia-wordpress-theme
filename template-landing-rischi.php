<?php
/**
 * Template Name: Landing — Rischi (Una vertenza. Una sanzione. Un infortunio.)
 *
 * PAS problem-first angle. Amplifies the specific costs of an irregular
 * domestic work relationship (vertenze, maxi-sanzioni INPS, responsabilità
 * civile per infortuni, detrazione persa) before offering Regolia as the
 * comprehensive mitigation. Measured in tone — names the risk, states the
 * mitigation. Never alarmistic.
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
            <span class="rg-badge">Rischi</span>
            <h1 class="rg-hero__title">
                Una vertenza.<br>
                Una sanzione.<br>
                <em>Tutto in regola.</em>
            </h1>
            <p class="rg-hero__sub">
                Senza un rapporto regolare, il lavoro domestico lascia
                tre falle aperte: vertenze, sanzioni INPS, responsabilità
                civile per gli infortuni. Regolia le chiude tutte, prima
                che ti raggiungano.
            </p>
            <div class="rg-hero__actions">
                <a href="#prezzi" class="rg-btn rg-btn--primary rg-btn--lg">
                    Metti in regola adesso
                </a>
                <a href="#falle" class="rg-btn rg-btn--ghost rg-btn--lg">
                    Vedi i rischi
                </a>
            </div>
            <p class="rg-hero__note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V7z"/><path d="M12 8v5"/><path d="M12 16h0"/></svg>
                Prima la lettera dell'INPS, poi è tardi.
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
     LE FALLE — 4 cards (rischi concreti)
     ═══════════════════════════════════════ -->
<section class="rg-features" id="falle">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Quattro falle, una soluzione</span>
            <h2 class="rg-section-title">I rischi che non vedi</h2>
            <p class="rg-section-sub">
                Finché tutto fila liscio, nulla sembra urgente.
                Poi arriva una lettera o una telefonata e il conto
                è salato. Ecco cosa blinda Regolia.
            </p>
        </div>
        <div class="rg-features__grid rg-features__grid--4">

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/contratti-digitali.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">La vertenza</h3>
                <p class="rg-feature-card__desc">Il lavoratore può chiedere retribuzioni e contributi arretrati fino a 5 anni dopo il rapporto. Regolia blinda tutto dal primo giorno con contratto CCNL firmato e log completo.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/compliance-inps.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">La sanzione INPS</h3>
                <p class="rg-feature-card__desc">In caso di ispezione, il costo di un lavoratore non in regola supera facilmente i €1.800 tra contributi omessi e maxi-sanzione. Regolia calcola e versa nei termini, ogni trimestre.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/supporto-esperto.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">L'infortunio domestico</h3>
                <p class="rg-feature-card__desc">Se cade mentre lavora in casa tua, il codice civile ti considera responsabile. Regolia attiva la copertura INAIL obbligatoria che ti mette al riparo.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/cedolini-automatici.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">La detrazione persa</h3>
                <p class="rg-feature-card__desc">Fino a €1.549 deducibili ogni anno dai contributi versati. Senza un rapporto regolare, zero detrazione. Con Regolia il dato è già nel tuo 730.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     TESTIMONIAL — amplificazione PAS
     ═══════════════════════════════════════ -->
<section class="rg-quote">
    <div class="rg-container">
        <blockquote class="rg-quote__box">
            <p class="rg-quote__text">&ldquo;Non volevo pensarci. Poi è arrivata la lettera INPS.&rdquo;</p>
            <p class="rg-quote__sub">
                Bastano dieci minuti per chiudere ogni falla. Poi pensiamo
                a tutto noi — contratto, contributi, buste paga, firme.
            </p>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg">
                Blinda il rapporto
            </a>
        </blockquote>
    </div>
</section>

<?php get_template_part( 'parts/landing-common-footer' ); ?>

</main>

<?php get_footer(); ?>
