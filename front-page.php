<?php
defined('ABSPATH') || exit;
get_header();
?>

<!-- ═══════════════════════════════════════
     HERO
     ═══════════════════════════════════════ -->
<main id="main-content">
<section class="rg-hero">
    <div class="rg-container rg-hero__inner">

        <!-- Copy -->
        <div class="rg-hero__copy">
            <span class="rg-badge">Nuovo</span>
            <h1 class="rg-hero__title">
                Gestisci i tuoi<br>
                <em>collaboratori domestici</em><br>
                senza stress.
            </h1>
            <p class="rg-hero__sub">
                Colf, badanti, baby sitter, dog sitter&thinsp;—&thinsp;Regolia
                si occupa di buste paga, contratti e adempimenti INPS
                al posto tuo.
            </p>
            <div class="rg-hero__actions">
                <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg">
                    Inizia gratis &rarr;
                </a>
                <a href="#come-funziona" class="rg-btn rg-btn--ghost rg-btn--lg">
                    Come funziona
                </a>
            </div>
            <p class="rg-hero__note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V7z"/></svg>
                Nessuna carta di credito richiesta
            </p>
        </div>

        <!-- Phone mockup -->
        <div class="rg-hero__visual" aria-hidden="true">
            <div class="rg-phone">
                <div class="rg-phone__notch"></div>
                <div class="rg-phone__screen">

                    <!-- Status bar -->
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

                    <!-- Dashboard card -->
                    <div class="rg-phone__content">
                        <p class="rg-phone__greeting">Ciao, Marco 👋</p>
                        <div class="rg-dash-hero">
                            <div class="rg-dash-hero__badge">Aprile 2025</div>
                            <p class="rg-dash-hero__label">Prossima busta paga</p>
                            <p class="rg-dash-hero__amount">€ 1.284<span>,50</span></p>
                            <div class="rg-dash-hero__stats">
                                <div class="rg-dash-stat">
                                    <p class="rg-dash-stat__val">28 apr</p>
                                    <p class="rg-dash-stat__key">Scadenza</p>
                                </div>
                                <div class="rg-dash-stat">
                                    <p class="rg-dash-stat__val">1</p>
                                    <p class="rg-dash-stat__key">Dipendente</p>
                                </div>
                                <div class="rg-dash-stat">
                                    <p class="rg-dash-stat__val">OK</p>
                                    <p class="rg-dash-stat__key">INPS</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks preview -->
                        <p class="rg-phone__section-title">Da fare</p>
                        <div class="rg-task-item rg-task-item--done">
                            <svg class="rg-task-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg>
                            <span>Contratto firmato</span>
                        </div>
                        <div class="rg-task-item rg-task-item--done">
                            <svg class="rg-task-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg>
                            <span>Comunicazione INPS</span>
                        </div>
                        <div class="rg-task-item rg-task-item--pending">
                            <svg class="rg-task-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                            <span>Approva cedolino aprile</span>
                        </div>

                        <!-- Tab bar -->
                        <div class="rg-phone__tabbar">
                            <div class="rg-tab rg-tab--active">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1z"/></svg>
                                <span>Home</span>
                            </div>
                            <div class="rg-tab">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M3 10h18"/></svg>
                                <span>Paga</span>
                            </div>
                            <div class="rg-tab">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h8l5 5v13a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z"/><path d="M14 3v5h5"/></svg>
                                <span>Documenti</span>
                            </div>
                            <div class="rg-tab">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12a4 4 0 100-8 4 4 0 000 8z"/><path d="M4 21c0-3.3 3.6-6 8-6s8 2.7 8 6"/></svg>
                                <span>Profilo</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="rg-phone__home-indicator"></div>
            </div>

            <!-- Floating badges -->
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
     LOGHI / SOCIAL PROOF
     ═══════════════════════════════════════ -->
<section class="rg-trust">
    <div class="rg-container">
        <p class="rg-trust__label">Già scelto da famiglie in tutta Italia</p>
        <div class="rg-trust__stats">
            <div class="rg-trust__stat">
                <strong>2.400+</strong>
                <span>famiglie attive</span>
            </div>
            <div class="rg-trust__sep" aria-hidden="true"></div>
            <div class="rg-trust__stat">
                <strong>4.9 ★</strong>
                <span>valutazione media</span>
            </div>
            <div class="rg-trust__sep" aria-hidden="true"></div>
            <div class="rg-trust__stat">
                <strong>0 errori</strong>
                <span>INPS in 3 anni</span>
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
     FEATURES
     ═══════════════════════════════════════ -->
<section class="rg-features" id="funzionalita">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Tutto incluso</span>
            <h2 class="rg-section-title">Tutto quello che ti serve,<br>in un'unica app</h2>
        </div>

        <div class="rg-features__grid">

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/cedolini-automatici.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Cedolini automatici</h3>
                <p class="rg-feature-card__desc">Calcolo automatico ogni mese, con straordinari, ferie e TFR già inclusi.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/compliance-inps.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Compliance INPS / INAIL</h3>
                <p class="rg-feature-card__desc">Comunicazioni obbligatorie inviate in automatico. Zero sanzioni garantite.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/contratti-digitali.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Contratti digitali</h3>
                <p class="rg-feature-card__desc">Genera, firma e archivia contratti CCNL in pochi secondi, dal telefono.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/pagamenti-integrati.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Pagamenti integrati</h3>
                <p class="rg-feature-card__desc">Bonifico diretto al dipendente con un tap. Tracciabilità completa.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/supporto-esperto.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Supporto esperto</h3>
                <p class="rg-feature-card__desc">Chat con consulenti del lavoro specializzati in collaboratori domestici.</p>
            </div>

            <div class="rg-feature-card">
                <div class="rg-feature-card__icon">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/features/gestione-ferie.webp' ) ); ?>" alt="" width="128" height="128" loading="lazy" decoding="async">
                </div>
                <h3 class="rg-feature-card__title">Gestione ferie e assenze</h3>
                <p class="rg-feature-card__desc">Calendario condiviso, approvazioni e conteggio automatico dei giorni.</p>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     TESTIMONIAL
     ═══════════════════════════════════════ -->
<section class="rg-testimonials">
    <div class="rg-container">
        <div class="rg-section-header">
            <h2 class="rg-section-title">Le famiglie ci adorano</h2>
        </div>

        <div class="rg-testimonials__grid">

            <blockquote class="rg-testimonial">
                <p>"Finalmente non devo più chiamare il CAF ogni mese. Tutto automatico, tutto chiaro."</p>
                <footer>
                    <strong>Giulia M.</strong>
                    <span>Milano &middot; colf da 3 anni</span>
                </footer>
            </blockquote>

            <blockquote class="rg-testimonial">
                <p>"Ho assunto la badante di mia madre in 20 minuti. Il contratto, l'INPS, tutto. Incredibile."</p>
                <footer>
                    <strong>Marco T.</strong>
                    <span>Roma &middot; badante live-in</span>
                </footer>
            </blockquote>

            <blockquote class="rg-testimonial">
                <p>"Zero stress. Ricevo una notifica quando approvare il cedolino e pago con un tap."</p>
                <footer>
                    <strong>Sara B.</strong>
                    <span>Torino &middot; baby sitter part-time</span>
                </footer>
            </blockquote>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     PREZZI
     ═══════════════════════════════════════ -->
<section class="rg-pricing" id="prezzi">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Prezzi</span>
            <h2 class="rg-section-title">Semplice e trasparente</h2>
            <p class="rg-section-sub">Un unico piano, tutto incluso. Nessuna sorpresa.</p>
        </div>

        <div class="rg-pricing__card">
            <div class="rg-pricing__header">
                <p class="rg-pricing__name">Piano completo</p>
                <div class="rg-pricing__price">
                    <span class="rg-pricing__amount">€ 19</span>
                    <span class="rg-pricing__period">/mese per dipendente</span>
                </div>
            </div>
            <ul class="rg-pricing__features">
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Cedolini automatici illimitati</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Comunicazioni INPS/INAIL incluse</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Contratti CCNL digitali</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Pagamenti integrati</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Supporto consulenti del lavoro</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Archiviazione documenti illimitata</li>
            </ul>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg rg-btn--full">
                Inizia con 30 giorni gratis
            </a>
            <p class="rg-pricing__note">Primo mese gratuito, poi € 19/mese. Disdici quando vuoi.</p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     WAITLIST / CTA FINALE
     ═══════════════════════════════════════ -->
<section class="rg-waitlist" id="waitlist">
    <div class="rg-container">
        <div class="rg-waitlist__inner">
            <span class="rg-badge rg-badge--light">Lista d'attesa</span>
            <h2 class="rg-waitlist__title">Sii tra i primi a provarlo</h2>
            <p class="rg-waitlist__sub">
                Regolia è in beta. Lascia la tua email e ti avvisiamo non appena
                sarà disponibile nella tua area.
            </p>
            <?php
            // Se esiste un form Contact Form 7 o simile, usarlo; altrimenti form nativo
            if (function_exists('wpcf7_get_contact_form_by_title')) {
                echo do_shortcode('[contact-form-7 id="" title="Waitlist"]');
            } else {
            ?>
            <form class="rg-waitlist__form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="regolia_waitlist">
                <?php wp_nonce_field('regolia_waitlist_nonce', 'rg_nonce'); ?>
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
                        Iscrivimi &rarr;
                    </button>
                </div>
                <p class="rg-waitlist__privacy">
                    Nessuno spam. Puoi cancellare in qualsiasi momento.
                    Leggi la <a href="<?php echo esc_url(get_privacy_policy_url()); ?>">Privacy Policy</a>.
                </p>
            </form>
            <?php } ?>
        </div>
    </div>
</section>
</main>

<?php get_footer(); ?>
