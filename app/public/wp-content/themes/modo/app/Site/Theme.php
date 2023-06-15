<?php

declare( strict_types=1 );

namespace App\Site;

use App\Functions\Public\Seo;
use App\Functions\Common\Comments;
use App\Functions\Common\Reset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'THEME_DOMAIN', 'modo' );

/**
 *
 */
class Theme {

	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @var bool
	 */
	public $check_extensions_status = false;

	/**
	 * @return Theme
	 */
	public static function get_instance(): Theme {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {


		// Check necessary plugins //
		add_action( 'after_setup_theme', [ $this, 'check_extensions' ], 10 );

		// Setup themes supports //
		add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ], 12 );

		// Reset WP //
		Reset::get_instance();

		// Remove comments //
		Comments::disable();

		// SEO //
		SEO::get_instance();

	}

	/**
	 * @return void
	 */
	public function check_extensions() {

		$this->check_extensions_status = true;

		$unactivated = [];

		$installed_plugins = get_option( 'active_plugins' );
		$needed_plugins    = [];

		foreach ( $needed_plugins as $plugin ) {
			if ( ! in_array( $plugin, $installed_plugins ) ) {
				$name          = explode( '/', $plugin );
				$name          = str_replace( '.php', '', $name[1] );
				$unactivated[] = ucfirst( $name );
			}
		}

		if ( ! empty( $unactivated ) ) {

			$this->check_extensions_status = false;

			$this->check_extensions_message = __( 'Veuillez activer les plugins suivant :', 'modo' );
			$this->check_extensions_message .= ' <strong>' . implode( ', ', $unactivated ) . '</strong>';

			if ( is_admin() || $GLOBALS['pagenow'] === 'wp-login.php' ) {
				add_action( 'admin_notices', function () {
					echo '<div class="notice notice-error"><p>' . $this->check_extensions_message . '</p></div>';
				} );
			} else {
				wp_die( $this->check_extensions_message );
			}
		}
	}

	/**
	 * @return void
	 */
	public function after_setup_theme() {

		// Languages //
		load_theme_textdomain( THEME_DOMAIN, get_template_directory() . '/modo_languages' );

		// Theme support //
		add_theme_support( 'title-tag' );
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );

		// Navigations //
		register_nav_menus( [
			'menu-main'   => esc_html__( 'Menu principal', THEME_DOMAIN ),
			'menu-footer' => esc_html__( 'Menu pied de page', THEME_DOMAIN ),
			'menu-legals' => esc_html__( 'Menu mentions légales', THEME_DOMAIN ),
		] );
	}
}