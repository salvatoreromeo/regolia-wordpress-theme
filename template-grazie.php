<?php
/**
 * Template Name: Grazie — Waitlist
 *
 * Pagina di atterraggio dopo l'iscrizione alla waitlist. L'handler
 * `regolia_handle_waitlist()` (functions.php) reindirizza qui dopo una
 * conferma valida. Il contenuto è nel template: la pagina WP può avere
 * corpo vuoto (come la home con la landing).
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main-content" class="rg-story-main">
    <section class="rg-story__opening rg-grazie">
        <div class="rg-container rg-story__container">

            <span class="rg-badge">Iscrizione confermata</span>

            <div class="rg-grazie__check" aria-hidden="true">
                <svg width="72" height="72" viewBox="0 0 24 24" fill="none"
                     stroke="#0F6B4F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M8 12.5l2.5 2.5L16 9.5"></path>
                </svg>
            </div>

            <h1 class="rg-story__headline">
                Grazie! Ci sei.<br>
                Ti scriviamo <em>subito</em>.
            </h1>

            <p class="rg-story__lede">
                Abbiamo registrato la tua email. Regolia è già attiva in tutta
                Italia: ti arriva subito un messaggio con il <strong>link per
                scaricare l'app</strong> e iniziare a mettere tutto in regola.
            </p>

            <p class="rg-grazie__note">
                Controlla anche lo spam: la nostra email arriva da un indirizzo
                che potresti non avere ancora in rubrica.
            </p>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
               class="rg-btn rg-btn--primary rg-btn--lg">
                Torna alla home
            </a>

        </div>
    </section>
</main>

<?php get_footer(); ?>
