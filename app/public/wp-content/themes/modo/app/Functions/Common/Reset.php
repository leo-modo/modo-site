<?php

declare( strict_types=1 );

namespace App\Functions\Common;

use App\Functions\Admin\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Reset {

	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @return Reset
	 */
	public static function get_instance(): Reset {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {

		/** Remove tags */
		add_action( 'init', [ $this, 'resetTags' ] );

		/** Remove customisation & edit file menu */
		add_action( 'admin_menu', [ $this, 'remove_admim_menus' ] );

		/** Remove admin header elements */
		add_action( 'wp_before_admin_bar_render', [ $this, 'admin_bar_remove_link_admin' ] );

		/** Disable emojis */
		add_action( 'init', [ $this, 'disable_emojis' ] );
		add_filter( 'tiny_mce_plugins', [ $this, 'disable_emojis_tinymce' ] );
		add_filter( 'wp_resource_hints', [ $this, 'disable_emojis_remove_dns_prefetch' ], 10, 2 );

		$this->resetMetas();
	}

	/**
	 * removeCustomizer
	 *
	 * @param mixed $wp_customize
	 *
	 * @return void
	 */
	public function remove_admim_menus() {
		Helpers::remove_menu_page( 'themes.php', 'customize.php' );
		Helpers::remove_menu_page( 'themes.php', 'theme-editor.php' );

		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

	}

	/**
	 * admin_bar_remove_link_admin
	 *
	 * @return void
	 */
	public function admin_bar_remove_link_admin() {
		global $wp_admin_bar;

		$wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_menu( 'customize' );
	}


	/**
	 * resetTags
	 *
	 * @return void
	 */
	public function resetTags() {
		register_taxonomy( 'post_tag', [] );
	}

	/**
	 * resetMetas
	 *
	 * @return void
	 */
	public function resetMetas() {

		/**
		 * Remove JSON API links in header html
		 */
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

		/**
		 * Remove Shortlink meta head
		 */
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

		/**
		 * Remove wlwmanifest tag haed
		 */
		remove_action( 'wp_head', 'wlwmanifest_link' );
	}


	/**
	 * Disable the emoji's
	 */
	public function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 */
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 */
	function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' == $relation_type ) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

			$urls = array_diff( $urls, array( $emoji_svg_url ) );
		}

		return $urls;
	}
}
