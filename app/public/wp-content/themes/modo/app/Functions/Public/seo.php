<?php

declare( strict_types=1 );

namespace App\Functions\Public;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Seo {

	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @return Seo
	 */
	public static function get_instance(): Seo {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {

		add_filter( 'walker_nav_menu_start_el', [ $this, 'menu_diese_to_span' ], 10, 4 );
	}

	/**
	 * @param $item_output
	 * @param $item
	 * @param $depth
	 * @param $args
	 *
	 * @return mixed|string
	 */
	public static function menu_diese_to_span( $item_output, $item, $depth, $args ) {

		if ( empty( $item->url ) || '#' === $item->url ) {
			$item_output = $args->before;
			$item_output .= '<span>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</span>';
			$item_output .= $args->after;
		}

		return $item_output;
	}
}