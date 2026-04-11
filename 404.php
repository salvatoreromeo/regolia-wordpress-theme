<?php
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" class="rg-main">
    <div class="rg-container">
        <div class="rg-404">
            <div class="rg-404__icon" aria-hidden="true">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#0D6B4F" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3L2 21h20z"/>
                    <path d="M12 10v4"/>
                    <path d="M12 17v.01"/>
                </svg>
            </div>
            <h1 class="rg-404__code">404</h1>
            <h2 class="rg-404__title"><?php esc_html_e('Pagina non trovata', 'regolia'); ?></h2>
            <p class="rg-404__desc">
                <?php esc_html_e('La pagina che stai cercando non esiste o è stata spostata.', 'regolia'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="rg-btn rg-btn--primary rg-btn--lg">
                &larr; <?php esc_html_e('Torna alla home', 'regolia'); ?>
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
