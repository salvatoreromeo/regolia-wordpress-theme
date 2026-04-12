<?php
/**
 * Regolia Theme — footer.php
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
?>

<footer class="site-footer" role="contentinfo">
	<div class="container">

		<div class="footer-grid">
			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php bloginfo( 'name' ); ?> — Home">
					Regolia
				</a>
				<p><?php esc_html_e( 'La soluzione online per gestire colf, badanti, baby sitter e dog sitter — semplice, corretta e senza pensieri.', 'regolia' ); ?></p>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Servizio', 'regolia' ); ?></h4>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => '__return_false',
					'items_wrap'     => '<ul>%3$s</ul>',
				] );
				?>
				<?php if ( ! has_nav_menu( 'footer' ) ) : ?>
				<ul>
					<li><a href="#"><?php esc_html_e( 'Come funziona', 'regolia' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'Prezzi', 'regolia' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'Figure professionali', 'regolia' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'FAQ', 'regolia' ); ?></a></li>
				</ul>
				<?php endif; ?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Legale', 'regolia' ); ?></h4>
				<ul>
					<?php if ( get_privacy_policy_url() ) : ?>
					<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'regolia' ); ?></a></li>
					<?php endif; ?>
					<li><a href="#"><?php esc_html_e( 'Termini di Servizio', 'regolia' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'Cookie Policy', 'regolia' ); ?></a></li>
				</ul>
			</div>
		</div>

		<?php
		$regolia_switcher = function_exists( 'regolia_render_landing_switcher' ) ? regolia_render_landing_switcher() : '';
		if ( $regolia_switcher ) :
		?>
		<div class="footer-switcher">
			<?php echo $regolia_switcher; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Regolia. <?php esc_html_e( 'Tutti i diritti riservati.', 'regolia' ); ?></p>
			<p><?php esc_html_e( 'P.IVA e CF disponibili su richiesta.', 'regolia' ); ?></p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
