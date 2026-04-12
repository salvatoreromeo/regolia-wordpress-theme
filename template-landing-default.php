<?php
/**
 * Template Name: Landing — Default (Nessun rischio)
 *
 * Faithful web port of the landing-regolia mobile mockup. Uses the PAS
 * structure with the negative-negative-positive hero and the four
 * "Perché regolarizzare" benefit cards from the product.
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main-content">

<!-- ═══════════════════════════════════════
     HERO
     ═══════════════════════════════════════ -->
<section class="rg-hero">
    <div class="rg-container rg-hero__inner">

        <div class="rg-hero__copy">
            <span class="rg-badge">Beta</span>
            <h1 class="rg-hero__title">
                Nessun rischio.<br>
                Nessuno sforzo.<br>
                <em>Tutto in regola.</em>
            </h1>
            <p class="rg-hero__sub">
                Il servizio online per la gestione semplice, corretta e
                senza pensieri di colf, badanti, baby sitter e dog sitter.
            </p>
            <div class="rg-hero__actions">
                <a href="#prezzi" class="rg-btn rg-btn--primary rg-btn--lg">
                    Scopri quanto costa
                </a>
                <a href="#come-funziona" class="rg-btn rg-btn--ghost rg-btn--lg">
                    Come funziona
                </a>
            </div>
            <p class="rg-hero__note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V7z"/></svg>
                Nessun addebito fino all'attivazione del servizio
            </p>
        </div>

        <div class="rg-hero__visual" aria-hidden="true">
            <div class="rg-phone">
                <div class="rg-phone__notch"></div>
                <div class="rg-phone__screen">
                    <div class="rg-phone__status">
                        <span>9:41</span>
                        <svg width="40" height="12" viewBox="0 0 40 12" fill="none">
                            <rect x="0" y="3" width="4" height="9" rx="1" fill="currentColor"/>
                            <rect x="6" y="1" width="4" height="11" rx="1" fill="currentColor"/>
                            <rect x="12" y="0" width="4" height="12" rx="1" fill="currentColor"/>
                            <rect x="20" y="1" width="18" height="10" rx="2" stroke="currentColor" stroke-width="1.2" fill="none"/>
                            <rect x="22" y="3" width="12" height="6" rx="1" fill="#0D6B4F"/>
                        </svg>
                    </div>
                    <div class="rg-phone__content">
                        <p class="rg-phone__greeting">Ciao, Marco 👋</p>
                        <div class="rg-dash-hero">
                            <div class="rg-dash-hero__badge">Aprile 2026</div>
                            <p class="rg-dash-hero__label">Prossima busta paga</p>
                            <p class="rg-dash-hero__amount">€ 1.284<span>,50</span></p>
                            <div class="rg-dash-hero__stats">
                                <div class="rg-dash-stat"><p class="rg-dash-stat__val">28 apr</p><p class="rg-dash-stat__key">Scadenza</p></div>
                                <div class="rg-dash-stat"><p class="rg-dash-stat__val">1</p><p class="rg-dash-stat__key">Dipendente</p></div>
                                <div class="rg-dash-stat"><p class="rg-dash-stat__val">OK</p><p class="rg-dash-stat__key">INPS</p></div>
                            </div>
                        </div>
                        <p class="rg-phone__section-title">Da fare</p>
                        <div class="rg-task-item rg-task-item--done"><svg class="rg-task-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg><span>Contratto firmato</span></div>
                        <div class="rg-task-item rg-task-item--done"><svg class="rg-task-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg><span>Comunicazione INPS</span></div>
                        <div class="rg-task-item rg-task-item--pending"><svg class="rg-task-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg><span>Approva cedolino aprile</span></div>
                    </div>
                </div>
                <div class="rg-phone__home-indicator"></div>
            </div>
            <div class="rg-float rg-float--top">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V7z"/></svg>
                100% conforme INPS
            </div>
            <div class="rg-float rg-float--bottom">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg>
                Cedolino approvato
            </div>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════
     PERCHÉ REGOLARIZZARE (4 benefit cards)
     ═══════════════════════════════════════ -->
<section class="rg-features" id="perche-regolarizzare">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Tranquillità</span>
            <h2 class="rg-section-title">Perché regolarizzare</h2>
            <p class="rg-section-sub">Quattro buoni motivi per farlo oggi.</p>
        </div>
        <div class="rg-features__grid rg-features__grid--4">

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/compliance-inps.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Nessun rischio</h3>
                <p class="rg-feature-card__desc">Zero vertenze e sanzioni dagli enti preposti.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/supporto-esperto.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Nessuna responsabilità</h3>
                <p class="rg-feature-card__desc">Protezione in caso di infortunio domestico.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/cedolini-automatici.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Benefici fiscali</h3>
                <p class="rg-feature-card__desc">Detrazioni sui contributi versati a fine anno.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/gestione-ferie.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Attrattiva</h3>
                <p class="rg-feature-card__desc">I dipendenti preferiscono lavorare in regola.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     COME FUNZIONA
     ═══════════════════════════════════════ -->
<section class="rg-how" id="come-funziona">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Semplicissimo</span>
            <h2 class="rg-section-title">Tre passi e sei a posto</h2>
            <p class="rg-section-sub">Dalla registrazione al primo cedolino in meno di 10 minuti.</p>
        </div>

        <div class="rg-steps">
            <div class="rg-step">
                <div class="rg-step__num">1</div>
                <div class="rg-step__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/steps/step-1-aggiungi.webp' ) ); ?>" alt="" width="160" height="160" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-step__title">Aggiungi il dipendente</h3>
                <p class="rg-step__desc">Inserisci nome, tipo di contratto e ore settimanali. Pensiamo noi al resto.</p>
            </div>

            <div class="rg-step__connector" aria-hidden="true"></div>

            <div class="rg-step">
                <div class="rg-step__num">2</div>
                <div class="rg-step__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/steps/step-2-firma.webp' ) ); ?>" alt="" width="160" height="160" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-step__title">Firma il contratto</h3>
                <p class="rg-step__desc">Contratto CCNL precompilato, firma digitale in-app. Valido legalmente.</p>
            </div>

            <div class="rg-step__connector" aria-hidden="true"></div>

            <div class="rg-step">
                <div class="rg-step__num">3</div>
                <div class="rg-step__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/steps/step-3-paga.webp' ) ); ?>" alt="" width="160" height="160" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-step__title">Paga con un tap</h3>
                <p class="rg-step__desc">Cedolino calcolato automaticamente. Approvi e paghi direttamente dall'app.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     TESTIMONIAL — "Ora il gioco vale la candela"
     ═══════════════════════════════════════ -->
<section class="rg-quote">
    <div class="rg-container">
        <blockquote class="rg-quote__box">
            <p class="rg-quote__text">&ldquo;Ora il gioco vale la candela.&rdquo;</p>
            <p class="rg-quote__sub">
                Con Regolia regolarizzi al 100% senza doverti occupare
                della gestione. Poi pensiamo a tutto noi.
            </p>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg">
                Lascia fare a Regolia
            </a>
        </blockquote>
    </div>
</section>

<?php get_template_part( 'parts/landing-common-footer' ); ?>

</main>

<?php get_footer(); ?>
