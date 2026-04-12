<?php
/**
 * Shared footer sections for every landing template:
 * trust bar + pricing block + waitlist form.
 *
 * Used by `template-landing-*.php`. Customisations per template should
 * happen before including this partial, not inside it.
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
?>

<!-- ═══════════════════════════════════════
     TRUST BAR
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
     PREZZI
     ═══════════════════════════════════════ -->
<section class="rg-pricing" id="prezzi">
    <div class="rg-container">
        <div class="rg-section-header">
            <span class="rg-badge">Prezzi</span>
            <h2 class="rg-section-title">Un piano, tutto incluso.</h2>
            <p class="rg-section-sub">Nessuna sorpresa. Nessun costo nascosto.</p>
        </div>

        <div class="rg-pricing__card">
            <div class="rg-pricing__header">
                <p class="rg-pricing__name">Regolia</p>
                <div class="rg-pricing__price">
                    <span class="rg-pricing__amount">€ 30</span>
                    <span class="rg-pricing__period">/mese per dipendente</span>
                </div>
            </div>
            <ul class="rg-pricing__features">
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Buste paga mensili automatiche</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Contributi INPS calcolati e versati</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> TFR accantonato e liquidato</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Certificazione Unica annuale</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Contratto CCNL con firma digitale</li>
                <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L19 7"/></svg> Assistenza dedicata in chat</li>
            </ul>
            <a href="#waitlist" class="rg-btn rg-btn--primary rg-btn--lg rg-btn--full">
                Scopri quanto costa
            </a>
            <p class="rg-pricing__note">Prezzo fisso. Nessun addebito fino all'attivazione del servizio.</p>
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
                Regolia è in beta. Lascia la tua email e ti avvisiamo
                non appena sarà disponibile nella tua area.
            </p>
            <?php
            if ( function_exists( 'wpcf7_get_contact_form_by_title' ) ) {
                echo do_shortcode( '[contact-form-7 id="" title="Waitlist"]' );
            } else {
            ?>
            <form class="rg-waitlist__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
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
                        Iscrivimi &rarr;
                    </button>
                </div>
                <p class="rg-waitlist__note">
                    Non condivideremo la tua email con terzi.
                    <?php if ( get_privacy_policy_url() ) : ?>
                    Leggi la <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a>.
                    <?php endif; ?>
                </p>
            </form>
            <?php } ?>
        </div>
    </div>
</section>
