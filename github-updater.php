<?php
/**
 * Regolia GitHub Theme Updater
 *
 * Auto-aggiorna il tema da un repository GitHub privato o pubblico.
 *
 * Configurazione in wp-config.php:
 *   define( 'GITHUB_THEME_TOKEN', 'ghp_xxxxxxxxxxxx' );
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;

class Regolia_GitHub_Updater {

	private string $theme_slug;
	private string $github_user;
	private string $github_repo;
	private string $api_base     = 'https://api.github.com';
	private string $token;
	private string $current_version;

	public function __construct(
		string $theme_slug  = 'regolia-wordpress-theme',
		string $github_user = 'salvatoreromeo',
		string $github_repo = 'regolia-wordpress-theme'
	) {
		$this->theme_slug      = $theme_slug;
		$this->github_user     = $github_user;
		$this->github_repo     = $github_repo;
		$this->current_version = wp_get_theme( $theme_slug )->get( 'Version' ) ?: '0.0.0';
		$this->token           = defined( 'GITHUB_THEME_TOKEN' ) ? GITHUB_THEME_TOKEN : '';

		add_filter( 'pre_set_site_transient_update_themes', [ $this, 'check_for_update' ] );
		add_filter( 'upgrader_source_selection',            [ $this, 'fix_folder_name' ], 10, 4 );
		add_filter( 'themes_api',                           [ $this, 'theme_info' ],      10, 3 );
	}

	/* ── GitHub API ── */

	private function get_latest_release(): ?object {
		$transient_key = 'regolia_gh_release_' . md5( $this->github_user . $this->github_repo );
		$cached        = get_transient( $transient_key );
		if ( $cached ) {
			return $cached;
		}

		$url  = "{$this->api_base}/repos/{$this->github_user}/{$this->github_repo}/releases/latest";
		$args = [
			'timeout' => 15,
			'headers' => [
				'Accept'     => 'application/vnd.github+json',
				'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ),
			],
		];

		if ( ! empty( $this->token ) ) {
			$args['headers']['Authorization'] = "Bearer {$this->token}";
		}

		$response = wp_remote_get( $url, $args );

		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
			return null;
		}

		$release = json_decode( wp_remote_retrieve_body( $response ) );
		if ( $release ) {
			set_transient( $transient_key, $release, HOUR_IN_SECONDS );
		}

		return $release ?: null;
	}

	private function get_zipball_url( object $release ): string {
		// Preferisce asset .zip allegato alla release
		if ( ! empty( $release->assets ) ) {
			foreach ( $release->assets as $asset ) {
				if ( str_ends_with( (string) $asset->name, '.zip' ) ) {
					$url = $asset->browser_download_url;
					if ( ! empty( $this->token ) ) {
						$url = add_query_arg( 'access_token', $this->token, $url );
					}
					return $url;
				}
			}
		}

		$url = $release->zipball_url
			?? "{$this->api_base}/repos/{$this->github_user}/{$this->github_repo}/zipball/{$release->tag_name}";

		if ( ! empty( $this->token ) ) {
			$url = add_query_arg( 'access_token', $this->token, $url );
		}

		return $url;
	}

	/* ── WordPress Hooks ── */

	public function check_for_update( object $transient ): object {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$release = $this->get_latest_release();
		if ( ! $release || empty( $release->tag_name ) ) {
			return $transient;
		}

		$latest = ltrim( $release->tag_name, 'v' );

		if ( version_compare( $latest, $this->current_version, '>' ) ) {
			$transient->response[ $this->theme_slug ] = [
				'theme'       => $this->theme_slug,
				'new_version' => $latest,
				'url'         => "https://github.com/{$this->github_user}/{$this->github_repo}",
				'package'     => $this->get_zipball_url( $release ),
			];
		}

		return $transient;
	}

	/**
	 * GitHub crea la cartella con un nome come "user-repo-abc123".
	 * La rinominiamo allo slug corretto.
	 */
	public function fix_folder_name( string $source, string $remote_source, object $upgrader, array $hook_extra ): string {
		global $wp_filesystem;

		if ( ( $hook_extra['theme'] ?? '' ) !== $this->theme_slug ) {
			return $source;
		}

		$correct = trailingslashit( dirname( $source ) ) . $this->theme_slug . '/';

		if ( $source === $correct ) {
			return $source;
		}

		if ( $wp_filesystem->move( $source, $correct ) ) {
			return $correct;
		}

		return $source;
	}

	public function theme_info( mixed $result, string $action, object $args ): mixed {
		if ( $action !== 'theme_information' || ( $args->slug ?? '' ) !== $this->theme_slug ) {
			return $result;
		}

		$release = $this->get_latest_release();
		if ( ! $release ) {
			return $result;
		}

		return (object) [
			'name'          => 'Regolia',
			'slug'          => $this->theme_slug,
			'version'       => ltrim( $release->tag_name ?? '', 'v' ),
			'author'        => 'Salvatore Romeo',
			'homepage'      => "https://github.com/{$this->github_user}/{$this->github_repo}",
			'sections'      => [ 'changelog' => $release->body ?? '' ],
			'download_link' => $this->get_zipball_url( $release ),
		];
	}
}
