<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class SDC_Jobs {

	/**
	 * @var
	 */
	public static $instance;


	/**
	 * @return SDC_Jobs
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'cpt' ], 10 );
		add_action( 'admin_init', [ $this, 'metabox' ] );
		add_action( 'init', [ $this, 'archive' ] );
		add_action( 'init', [ $this, 'columns' ] );

	}

	/**
	 * cpt
	 *
	 * @return void
	 */
	public function cpt() {

		register_post_type( 'jobs', [
			'labels'      => kalelia_cpt_labels( 'emploi', 'emplois', 'm' ),
			'supports'    => [ 'title', 'editor' ],
			'public'      => true,
			'has_archive' => true,
			'menu_icon'   => 'dashicons-welcome-learn-more',
			'rewrite'     => [ 'slug' => 'emplois' ]
		] );


		register_taxonomy( 'jobs-contract', 'jobs', [
			'labels'       => kalelia_taxo_labels( 'contrat', 'contrats' ),
			'public'       => false,
			'show_ui'      => true,
			'hierarchical' => true,
		] );


	}

	/**
	 * metabox
	 *
	 * @return void
	 */
	public function metabox() {

		if ( class_exists( 'Kalelia_Custom_Fields' ) ) {

			// Init //
			$kalelia_cf = new Kalelia_Custom_Fields();

			// Dit sur quelle page //
			$kalelia_cf->locations( [
				'type'     => 'jobs',
				'operator' => '=',
				'value'    => 'all'
			] );

			$kalelia_cf->field( [ 'type' => 'text', 'name' => 'jobs_city', 'label' => 'Ville' ] );


			// Génération de la métabox - Doit être à la fin //
			$kalelia_cf->metabox( [ 'title' => "Informations d'un emploi", 'priority' => 'high' ] );
		}
	}

	/**
	 * archive
	 *
	 * @return void
	 */
	public function archive() {

		if ( class_exists( 'Kalelia_Option_Page' ) ) {

			$page_option_fields = [
				[ 'type' => 'text', 'name' => 'jobs_archive_title', 'label' => 'Titre' ],
				[ 'type' => 'editor', 'name' => 'jobs_archive_description', 'label' => 'Description' ],
				[ 'type' => 'select', 'name' => 'jobs_archive_form', 'label' => 'Formulaire', 'relation' => 'gravityforms', 'description' => "Sélectionnez le formulaire de candidature spontanée" ],
			];

			$page_option = [
				'parent_slug' => 'edit.php?post_type=jobs',
				'page_title'  => 'Page archive des emplois',
				'menu_title'  => 'Page archive',
				'description' => 'Voir la page : <a href="' . get_post_type_archive_link( 'jobs' ) . '" target="_blank">Emplois</a>',
				'menu_slug'   => 'jobs-archive',
				'id'          => 'jobs_archive',
				'fields'      => $page_option_fields
			];

			new Kalelia_Option_Page( $page_option );
		}
	}


	/**
	 * @return void
	 */
	public function columns() {

		if ( class_exists( 'Kalelia_Post_Column' ) ) {

			new Kalelia_Post_Column( [
				'post_type' => 'jobs',
				'name'      => [ 'id' => 'jobs-contract', 'label' => 'Contrat' ],
				'value'     => [ 'type' => 'taxo', 'name' => 'jobs-contract' ]
			] );

		}
	}
}
