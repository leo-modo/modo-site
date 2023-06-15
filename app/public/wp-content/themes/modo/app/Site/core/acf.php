<?php

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Modo_ACF {

	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @return Modo_ACF
	 */
	public static function get_instance(): Modo_ACF {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct(){
		$this->acf_fields_load();
	}

	public function acf_fields_load() {

		// Synchronisation des champs ACF dans des fichiers JSON
		add_filter('acf/json_directory', function ($path) {
			return get_template_directory() . '/mia_functions/acf-fields';
		});

		// Sauvegarde des champs //
		add_filter('acf/settings/save_json', function ($path) {
			return apply_filters("acf/json_directory", NULL);
		});

		// Chargement des champs //
		add_filter('acf/settings/load_json', function ($paths) {
			return [
				apply_filters("acf/json_directory", NULL)
			];
		});
	}

}
