<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Modo_Media {

	/**
	 * @var array
	 */
	protected $custom_image_sizes = [];

	/**
	 * @var
	 */
	public static $instance;


	/**
	 * @return Modo_Media
	 */
	public static function get_instance(): Modo_Media {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {

		$this->set_image_sizes();
		$this->add_image_sizes();

		add_action( 'admin_menu', [ $this, 'remove_admin_menu' ] );
		add_filter( 'intermediate_image_sizes_advanced', [ $this, 'remove_default_image_sizes' ] );

		add_action( 'after_setup_theme', [ $this, 'wysiwyg_images_setup' ] );
	}

	/**
	 * @return void
	 */
	public function wysiwyg_images_setup() {
		// Réglage du lien : file/post/none
		$image_link = get_option( 'image_default_link_type' );
		if ( $image_link !== 'none' ) {
			update_option( 'image_default_link_type', 'none' );
		}
		// Réglage de l'alignement : none/left/center/right
		$image_align = get_option( 'image_default_align' );
		if ( $image_align !== 'none' ) {
			update_option( 'image_default_align', 'none' );
		}
		// Réglage de la taille : full/slug de votre format ajouté avec add_image_size()
		$image_size = get_option( 'image_default_size' );
		if ( $image_size !== 'full' ) {
			update_option( 'image_default_size', 'large' );
		}
	}

	/**
	 * remove_admin_menu
	 *
	 * @return void
	 */
	public function remove_admin_menu() {
		if ( function_exists( 'kalelia_remove_menu_page' ) ) {
			kalelia_remove_menu_page( 'options-general.php', 'options-media.php' );
		}
	}

	/**
	 * set_image_sizes
	 *
	 * @return void
	 */
	public function set_image_sizes() {

		$this->custom_image_sizes = [
			'banner'  => [ 890, 390, true ],
			'product' => [ 570, 440, true ],
			'teaser'  => [ 390, 390, true ],
		];
	}

	/**
	 * add_image_sizes
	 *
	 * @return void
	 */
	public function add_image_sizes() {

		foreach ( $this->custom_image_sizes as $name => $datas ) {
			add_image_size( $name, $datas[0], $datas[1], $datas[2] );
		}
	}


	/**
	 * remove_default_image_sizes
	 *
	 * @return void
	 */
	public function remove_default_image_sizes( $sizes ) {

		// defaults = ['thumbnail', 'medium', 'medium_large', 'large', '1536x1536', '2048x2048'];
		$accetped = [ 'thumbnail', 'medium', 'large' ];
		$accetped = array_merge( $accetped, array_keys( $this->custom_image_sizes ) );

		foreach ( $sizes as $size_name => $size_datas ) {
			if ( ! in_array( $size_name, $accetped ) ) {
				unset( $sizes[ $size_name ] );
			}
		}

		return $sizes;
	}
}
