<?php
/**
 * Regolia Theme — header.php
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Vai al contenuto', 'regolia' ); ?></a>

<header class="site-header" id="site-header" role="banner">
	<div class="container">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php bloginfo( 'name' ); ?> — Home">
			Regolia
		</a>

		<nav class="primary-nav" id="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Menu principale', 'regolia' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => '',
				'container'      => false,
				'fallback_cb'    => '__return_false',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			] );
			?>
		</nav>

		<a href="#waitlist" class="header-cta btn btn-primary">
			<?php esc_html_e( 'Inizia gratis', 'regolia' ); ?>
		</a>

		<button
			class="menu-toggle"
			id="menu-toggle"
			aria-expanded="false"
			aria-controls="primary-nav"
			aria-label="<?php esc_attr_e( 'Apri menu', 'regolia' ); ?>"
		>
			<span></span>
			<span></span>
			<span></span>
		</button>

	</div>
</header>
