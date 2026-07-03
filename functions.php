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
		'https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap',
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
   SMTP (invio email)
   ════════════════════════════════════════ */

/*
 * Configura PHPMailer per usare un server SMTP, se le costanti sono definite in
 * wp-config.php. Le CREDENZIALI NON stanno nel tema (repo pubblico): qui c'è
 * solo il codice che le legge. Definire in wp-config.php di ogni ambiente:
 *
 *   define( 'REGOLIA_SMTP_HOST', 'smtp.mx.cloudflare.net' );
 *   define( 'REGOLIA_SMTP_PORT', 465 );
 *   define( 'REGOLIA_SMTP_SECURE', 'ssl' );   // implicit TLS (SMTPS) su 465
 *   define( 'REGOLIA_SMTP_USER', 'api_token' );
 *   define( 'REGOLIA_SMTP_PASS', '…token…' );
 *   define( 'REGOLIA_SMTP_FROM', 'noreply@regolia.it' );
 *   define( 'REGOLIA_SMTP_FROM_NAME', 'Regolia' );
 */
add_action( 'phpmailer_init', function ( $phpmailer ): void {
	if ( ! defined( 'REGOLIA_SMTP_HOST' ) || ! REGOLIA_SMTP_HOST ) {
		return;
	}
	$phpmailer->isSMTP();
	$phpmailer->Host       = REGOLIA_SMTP_HOST;
	$phpmailer->Port       = defined( 'REGOLIA_SMTP_PORT' ) ? (int) REGOLIA_SMTP_PORT : 465;
	$phpmailer->SMTPSecure = defined( 'REGOLIA_SMTP_SECURE' ) ? REGOLIA_SMTP_SECURE : 'ssl';
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Username   = defined( 'REGOLIA_SMTP_USER' ) ? REGOLIA_SMTP_USER : '';
	$phpmailer->Password   = defined( 'REGOLIA_SMTP_PASS' ) ? REGOLIA_SMTP_PASS : '';
	// Fail-fast: se il server SMTP non risponde, non tenere appesa la richiesta.
	$phpmailer->Timeout = defined( 'REGOLIA_SMTP_TIMEOUT' ) ? (int) REGOLIA_SMTP_TIMEOUT : 12;
} );

add_filter( 'wp_mail_from', function ( $from ) {
	return ( defined( 'REGOLIA_SMTP_FROM' ) && REGOLIA_SMTP_FROM ) ? REGOLIA_SMTP_FROM : $from;
} );

add_filter( 'wp_mail_from_name', function ( $name ) {
	return ( defined( 'REGOLIA_SMTP_FROM_NAME' ) && REGOLIA_SMTP_FROM_NAME ) ? REGOLIA_SMTP_FROM_NAME : $name;
} );

/* ════════════════════════════════════════
   WAITLIST FORM HANDLER
   ════════════════════════════════════════ */

/**
 * Gestisce l'invio del form waitlist (landing + footer).
 * Il form fa POST a admin-post.php con action=regolia_waitlist.
 * Salva l'email in un'opzione, avvisa l'admin e reindirizza con un flag di esito.
 */
function regolia_handle_waitlist(): void {
	$referer = wp_get_referer() ?: home_url( '/' );
	$referer = remove_query_arg( 'rg_waitlist', $referer );

	$redirect = static function ( string $status ) use ( $referer ): void {
		wp_safe_redirect( add_query_arg( 'rg_waitlist', $status, $referer ) . '#waitlist' );
		exit;
	};

	if ( ! isset( $_POST['rg_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rg_nonce'] ) ), 'regolia_waitlist_nonce' ) ) {
		$redirect( 'error' );
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		$redirect( 'invalid' );
	}

	$entries = get_option( 'regolia_waitlist_emails', [] );
	if ( ! is_array( $entries ) ) {
		$entries = [];
	}
	$existing = array_map(
		static fn( $e ) => is_array( $e ) ? ( $e['email'] ?? '' ) : (string) $e,
		$entries
	);
	if ( ! in_array( $email, $existing, true ) ) {
		$entries[] = [ 'email' => $email, 'date' => current_time( 'mysql' ) ];
		update_option( 'regolia_waitlist_emails', $entries, false );
		// Notifica admin in background (WP-Cron): non blocca mai la submit del form,
		// anche se l'SMTP è lento o non raggiungibile.
		wp_schedule_single_event( time() + 5, 'regolia_waitlist_notify', [ $email ] );
	}

	// Successo: atterra sulla pagina di ringraziamento dedicata, se esiste.
	$grazie = get_page_by_path( 'grazie' );
	if ( $grazie ) {
		wp_safe_redirect( get_permalink( $grazie ) );
		exit;
	}

	// Fallback: banner inline sulla pagina di provenienza.
	$redirect( 'ok' );
}
add_action( 'admin_post_nopriv_regolia_waitlist', 'regolia_handle_waitlist' );
add_action( 'admin_post_regolia_waitlist', 'regolia_handle_waitlist' );

/* Invia la notifica di iscrizione (eseguita da WP-Cron, fuori dalla richiesta). */
add_action( 'regolia_waitlist_notify', function ( $email ): void {
	wp_mail(
		get_option( 'admin_email' ),
		__( 'Nuova iscrizione alla waitlist Regolia', 'regolia' ),
		sprintf( "Email: %s\nData: %s", (string) $email, current_time( 'mysql' ) )
	);
} );

/**
 * Ritorna gli iscritti normalizzati: sempre [ ['email'=>, 'date'=>], … ].
 * Retrocompatibile con le voci salvate come semplice stringa email.
 */
function regolia_get_waitlist(): array {
	$raw = get_option( 'regolia_waitlist_emails', [] );
	if ( ! is_array( $raw ) ) {
		return [];
	}
	$out = [];
	foreach ( $raw as $e ) {
		if ( is_array( $e ) ) {
			$out[] = [ 'email' => (string) ( $e['email'] ?? '' ), 'date' => (string) ( $e['date'] ?? '' ) ];
		} else {
			$out[] = [ 'email' => (string) $e, 'date' => '' ];
		}
	}
	return $out;
}

/* ── Pagina admin: elenco iscritti waitlist ── */
add_action( 'admin_menu', function (): void {
	add_menu_page(
		__( 'Waitlist Regolia', 'regolia' ),
		__( 'Waitlist', 'regolia' ),
		'manage_options',
		'regolia-waitlist',
		'regolia_render_waitlist_page',
		'dashicons-email-alt',
		26
	);
} );

function regolia_render_waitlist_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$list  = regolia_get_waitlist();
	$total = count( $list );
	// Più recenti in cima (se hanno una data).
	$sorted = $list;
	usort( $sorted, static fn( $a, $b ) => strcmp( $b['date'], $a['date'] ) );

	$export_url = wp_nonce_url(
		admin_url( 'admin-post.php?action=regolia_export_waitlist' ),
		'regolia_export_waitlist'
	);
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Waitlist Regolia', 'regolia' ); ?></h1>
		<a href="<?php echo esc_url( $export_url ); ?>" class="page-title-action"><?php esc_html_e( 'Esporta CSV', 'regolia' ); ?></a>
		<hr class="wp-header-end">

		<p><strong><?php echo (int) $total; ?></strong> <?php esc_html_e( 'iscritti totali.', 'regolia' ); ?></p>

		<?php if ( ! $total ) : ?>
			<p><?php esc_html_e( 'Ancora nessuna iscrizione.', 'regolia' ); ?></p>
		<?php else : ?>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th style="width:60px;">#</th>
						<th><?php esc_html_e( 'Email', 'regolia' ); ?></th>
						<th style="width:220px;"><?php esc_html_e( 'Data iscrizione', 'regolia' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $sorted as $i => $row ) : ?>
						<tr>
							<td><?php echo (int) ( $i + 1 ); ?></td>
							<td><a href="<?php echo esc_url( 'mailto:' . $row['email'] ); ?>"><?php echo esc_html( $row['email'] ); ?></a></td>
							<td><?php echo $row['date'] ? esc_html( $row['date'] ) : '&mdash;'; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<?php
}

/* ── Export CSV degli iscritti ── */
function regolia_export_waitlist(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Permessi insufficienti.', 'regolia' ) );
	}
	check_admin_referer( 'regolia_export_waitlist' );

	$list = regolia_get_waitlist();

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=regolia-waitlist-' . gmdate( 'Y-m-d' ) . '.csv' );

	$out = fopen( 'php://output', 'w' );
	fprintf( $out, "\xEF\xBB\xBF" ); // BOM per Excel
	fputcsv( $out, [ 'email', 'data' ] );
	foreach ( $list as $row ) {
		fputcsv( $out, [ $row['email'], $row['date'] ] );
	}
	fclose( $out );
	exit;
}
add_action( 'admin_post_regolia_export_waitlist', 'regolia_export_waitlist' );

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
