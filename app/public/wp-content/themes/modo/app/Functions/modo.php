<?php

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Constates
 */
define( 'MODO_ROOT', dirname( __FILE__ ) . '/' );
define( 'MODO_ADMIN_PATH', MODO_ROOT . 'admin/' );
define( 'MODO_PUBLIC_PATH', MODO_ROOT . 'public/' );
define( 'MODO_COMMON_PATH', MODO_ROOT . 'common/' );
define( 'MODO_ASSETS_PATH', MODO_ROOT . 'assets/' );

define( 'MODO_ROOT_URL', str_replace( $_SERVER['DOCUMENT_ROOT'], get_site_url(), MODO_ROOT ) );
define( 'MODO_ASSETS_URL', str_replace( $_SERVER['DOCUMENT_ROOT'], get_site_url(), MODO_ASSETS_PATH ) );

class Modo_Plugin {

	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @return Modo_Plugin
	 */
	public static function get_instance(): Modo_Plugin {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {

		add_action('plugins_loaded', [$this, 'include_dependencies']);
	}

	public function include_dependencies(){

		// Reset //
		require MODO_COMMON_PATH . 'Reset.php';

		// cron //
		require MODO_COMMON_PATH . 'cron.php';

		// CPT //
		require MODO_COMMON_PATH . 'cpt.php';

		// Comments //
		require MODO_COMMON_PATH . 'Comments.php';

		if ( is_admin() ) {

			// Admin helpers //
			require MODO_ADMIN_PATH . 'Helpers.php';

			// Post columns //
			require MODO_ADMIN_PATH . 'post-columns.php';
		}

		// SEO //
		require MODO_PUBLIC_PATH . 'seo.php';

		// Public functions //
		require MODO_PUBLIC_PATH . 'functions.php';

		// Debug //
		if ( WP_DEBUG && WP_DEBUG_DISPLAY ) {
			require MODO_ADMIN_PATH . 'debug.php';
			Modo_Debug::get_instance();
		}
	}
}

Modo_Plugin::get_instance();