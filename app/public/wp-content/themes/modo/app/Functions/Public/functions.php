<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * modo_breadcrumb
 *
 * @return void
 */
if ( ! function_exists( 'modo_breadcrumb' ) ) {
	function modo_breadcrumb( $args = [] ) {
		require MODO_PUBLIC_PATH . 'breadcrumb.php';
		$breadcrumb = new Modo_Breadcrumb( $args );

		return $breadcrumb->render();
	}
}

/**
 * modo_pagination
 *
 * @return void
 */
if ( ! function_exists( 'modo_pagination' ) ) {
	function modo_pagination( $args = [] ) {
		require MODO_PUBLIC_PATH . 'pagination.php';
		$pagination = new Modo_Pagination( $args );

		return $pagination->render();
	}
}


/**
 * modo_button
 */
if ( ! function_exists( 'modo_button' ) ) {
	function modo_button( $datas = [], $args = [] ) {

		if ( ! empty( $datas ) && ! empty( $datas['href'] ) ) {

			$label  = ( ! empty( $datas['label'] ) ) ? $datas['label'] : __( 'En savoir plus', 'modo' );
			$target = ( ! empty( $datas['target'] ) ) ? "target=_blank" : '';
			$class  = ( ! empty( $args['class'] ) ) ? $args['class'] : '';

			return '<a href="' . $datas['href'] . '" class="btn ' . $class . '" ' . $target . '>' . $label . '</a>';
		}

		return false;
	}
}

/**
 * modo_external_video
 */
if ( ! function_exists( 'modo_external_video' ) ) {
	function modo_external_video( $video_url = false ) {
		require MODO_PUBLIC_PATH . 'external-video.php';
		$video = new Modo_External_Video( $video_url );

		return $video->get();
	}
}
