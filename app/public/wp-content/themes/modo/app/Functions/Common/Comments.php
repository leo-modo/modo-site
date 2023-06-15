<?php

namespace App\Functions\Common;

use App\Functions\Admin\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Comments {

	public static $instance;

	public static function get_instance(): Comments {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * reset
	 *
	 * @return void
	 */
	public static function disable() {

		add_action( 'admin_init', function () {
			// Redirect any user trying to access comments page
			global $pagenow;

			if ( $pagenow === 'edit-comments.php' ) {
				wp_redirect( admin_url() );
				exit;
			}

			// Remove comments metabox from dashboard
			remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

			// Disable support for comments and trackbacks in post types
			foreach ( get_post_types() as $post_type ) {
				if ( post_type_supports( $post_type, 'comments' ) ) {
					remove_post_type_support( $post_type, 'comments' );
					remove_post_type_support( $post_type, 'trackbacks' );
				}
			}
		} );

		// Close comments on the front-end
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );

		// Hide existing comments
		add_filter( 'comments_array', '__return_empty_array', 10, 2 );

		// Remove comments page in menu
		add_action( 'admin_menu', function () {
			remove_menu_page( 'edit-comments.php' );
		} );

		// Remove comments links from admin bar
		add_action( 'init', function () {
			if ( is_admin_bar_showing() ) {
				remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
			}
		} );

		// Remove comments in admin top bar //
		add_action( 'wp_before_admin_bar_render', function () {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu( 'comments' );
		} );

		// Remove admin configuration menu
		add_action( 'admin_menu', function () {
			Helpers::remove_menu_page( 'options-general.php', 'options-discussion.php' );
		} );
	}
}
