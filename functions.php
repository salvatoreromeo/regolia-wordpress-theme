<?php
/**
 * Regolia Theme — functions.php
 */

defined( 'ABSPATH' ) || exit;

define( 'REGOLIA_VERSION', wp_get_theme()->get( 'Version' ) ?: '1.0.0' );
define( 'REGOLIA_DIR', get_template_directory() );
define( 'REGOLIA_URI', get_template_directory_uri() );

/* ════════════════════════════════════════
   THEME SETUP
   ════════════════════════════════════════ */
add_action( 'after_setup_theme', function (): void {
	load_theme_textdomain( 'regolia', REGOLIA_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'style', 'script',
	] );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );

	add_image_size( 'regolia-card',  760, 428, true );
	add_image_size( 'regolia-hero', 1440, 640, true );
	add_image_size( 'regolia-thumb', 480, 270, true );

	register_nav_menus( [
		'primary' => __( 'Menu Principale', 'regolia' ),
		'footer'  => __( 'Menu Footer',     'regolia' ),
	] );
} );

/* ── Content width ── */
add_action( 'after_setup_theme', function (): void {
	$GLOBALS['content_width'] = 1160;
}, 0 );

/* ════════════════════════════════════════
   ENQUEUE SCRIPTS & STYLES
   ════════════════════════════════════════ */
add_action( 'wp_enqueue_scripts', function (): void {
	$ver = REGOLIA_VERSION;
	$uri = REGOLIA_URI;

	wp_enqueue_style(
		'regolia-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'regolia-main',
		$uri . '/assets/css/main.css',
		[ 'regolia-fonts' ],
		$ver
	);

	wp_enqueue_script(
		'regolia-main',
		$uri . '/assets/js/main.js',
		[],
		$ver,
		[ 'strategy' => 'defer', 'in_footer' => true ]
	);
} );

/* ════════════════════════════════════════
   WIDGETS
   ════════════════════════════════════════ */
add_action( 'widgets_init', function (): void {
	register_sidebar( [
		'name'          => __( 'Sidebar', 'regolia' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
} );

/* ════════════════════════════════════════
   GITHUB UPDATER
   ════════════════════════════════════════ */
require_once REGOLIA_DIR . '/github-updater.php';
new Regolia_GitHub_Updater();

/* ════════════════════════════════════════
   HELPER FUNCTIONS
   ════════════════════════════════════════ */

/**
 * Returns inline SVG icon.
 *
 * @param string $icon  Icon key.
 * @param int    $size  Width/height in px.
 * @param string $color Stroke color.
 */
function regolia_icon( string $icon, int $size = 22, string $color = 'currentColor' ): string {
	$icons = [
		'shield'   => ['M12 3l8 4v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V7z'],
		'heart'    => ['M12 21C6 16 3 12.5 3 9a4.5 4.5 0 019-1 4.5 4.5 0 019 1c0 3.5-3 7-9 12z'],
		'euro'     => ['M12 21a9 9 0 100-18 9 9 0 000 18z','M15 8.5a4.5 4.5 0 00-4-.5c-2 .8-3 3-2.5 5s2.5 3.5 4.5 3 3-2','M8 11h5','M8 14h4'],
		'star'     => ['M12 3l2.5 6.5H21l-5.3 4 2 6.5L12 16l-5.7 4 2-6.5L3 9.5h6.5z'],
		'leaf'     => ['M12 21c-4-4-8-8-8-13 0-4 4-6 8-6s8 2 8 6c0 5-4 9-8 13z'],
		'check'    => ['M5 12l5 5L19 7'],
		'arrow'    => ['M9 5l7 7-7 7'],
		'calendar' => ['M3 7a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2z','M3 11h18','M8 3v4','M16 3v4'],
		'clock'    => ['M12 21a9 9 0 100-18 9 9 0 000 18z','M12 7v5l3 3'],
		'user'     => ['M12 12a4 4 0 100-8 4 4 0 000 8z','M4 21c0-3.3 3.6-6 8-6s8 2.7 8 6'],
		'send'     => ['M3 12l18-9-9 18-2-7z'],
		'home'     => ['M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1z'],
	];

	if ( ! isset( $icons[ $icon ] ) ) {
		return '';
	}

	$out = sprintf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="%2$s" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">',
		$size,
		esc_attr( $color )
	);
	foreach ( $icons[ $icon ] as $d ) {
		$out .= '<path d="' . esc_attr( $d ) . '"/>';
	}
	$out .= '</svg>';

	return $out;
}
