<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Modo_Admin {

	/**
	 * @var
	 */
	public static $instance;


	/**
	 * @return Modo_Admin
	 */
	public static function get_instance(): Modo_Admin {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {

		$this->disable_gutenberg();

		//login personnalisé
		add_action( 'login_head', [ $this, 'theme_custom_login' ] );

		// Editor css
		add_action( 'admin_init', [ $this, 'add_editor_css' ] );

		//TinyMCE
		add_filter( 'tiny_mce_before_init', [ $this, 'show_bar_editor' ] );
		add_filter( 'mce_buttons_2', [ $this, 'mce_buttons_2' ] );
		add_filter( 'tiny_mce_before_init', [ $this, 'mce_before_init_insert_formats' ] );
		//add_filter( 'tiny_mce_before_init', [ $this, 'mce_before_init_remove_h1' ] );
		add_filter( 'tiny_mce_before_init', [ $this, 'mce_before_init_remove_plugins' ] );

		// Add specifications to wp_kses_post
		add_filter( 'wp_kses_allowed_html', [ $this, 'custom_wp_kses_post_tags' ], 10, 2 );

	}


	/**
	 * disable_gutenberg
	 *
	 * @return void
	 */
	public function disable_gutenberg() {

		// disable Gutemberg for posts
		add_filter( 'use_block_editor_for_post', '__return_false', 10 );

		// disable Gutemberg for post types
		add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );

		// Disables the block editor from managing widgets in the Gutenberg plugin.
		add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

		// Disables the block editor from managing widgets.
		add_filter( 'use_widgets_block_editor', '__return_false' );
	}


	/**
	 * theme_custom_login
	 *
	 * @return void
	 */
	public function theme_custom_login() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'stylesheet_directory' ) . '/sdc_assets/css/login.css" />';
	}


	/**
	 * show_bar_editor
	 *
	 * @param mixed $in
	 *
	 * @return void
	 */
	public function show_bar_editor( $in ) {
		$in['wordpress_adv_hidden'] = false;

		return $in;
	}


	/**
	 * mce_buttons_2
	 *
	 * @param mixed $buttons
	 *
	 * @return void
	 */
	public function mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}


	/**
	 * mce_before_init_insert_formats
	 *
	 * @param mixed $init_array
	 *
	 * @return void
	 */
	public function mce_before_init_insert_formats( $init_array ) {

		$style_formats = [
			[
				'title'    => 'Bouton',
				'selector' => 'a',
				'classes'  => 'btn',
			]
		];

		$init_array['style_formats'] = json_encode( $style_formats );

		return $init_array;
	}

	/**
	 * @param $init_array
	 *
	 * @return mixed
	 */
	public function mce_before_init_remove_h1( $init_array ) {
		$init_array['block_formats'] = "Titre 2=h2; Titre 3=h3; Titre 4=h4; Titre 5=h5; Titre 6=h6; Paragraphe=p; Préformaté=pre";

		return $init_array;
	}

	/**
	 * @param $init_array
	 *
	 * @return mixed
	 */
	public function mce_before_init_remove_plugins( $init_array ) {

		$init_array['toolbar1'] = str_replace( 'wp_more,', '', $init_array['toolbar1'] );
		$init_array['toolbar2'] = str_replace( 'hr,', '', $init_array['toolbar2'] );
		$init_array['toolbar2'] = str_replace( 'forecolor,', '', $init_array['toolbar2'] );

		return $init_array;
	}

	/**
	 * add_editor_css
	 *
	 * @return void
	 */
	public function add_editor_css() {
		add_editor_style( 'sdc_assets/css/editor.css' );
	}

	/**
	 * @param $tags
	 * @param $context
	 *
	 * @return mixed
	 */
	public function custom_wp_kses_post_tags( $tags, $context ) {

		if ( 'post' === $context ) {
			$tags['iframe'] = [
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
			];
		}

		return $tags;
	}
}
