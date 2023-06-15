<?php

declare( strict_types=1 );

namespace App\Functions\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Helpers {

	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @return Helpers
	 */
	public static function get_instance(): Helpers {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @param $mymenu
	 * @param $mysubmenu
	 *
	 * @return void
	 */
	public static function remove_menu_page( $mymenu, $mysubmenu = false ) {

		if ( is_admin() ) {

			global $submenu;

			if ( ! empty( $mysubmenu ) ) {

				if ( ! empty( $submenu[ $mymenu ] ) ) {
					foreach ( $submenu[ $mymenu ] as $index => $item ) {
						if ( strpos( $item[2], $mysubmenu ) !== false ) {
							unset( $submenu[ $mymenu ][ $index ] );
						}
					}
				}
			} else {
				unset( $submenu[ $mymenu ] );
			}
		}
	}
}
