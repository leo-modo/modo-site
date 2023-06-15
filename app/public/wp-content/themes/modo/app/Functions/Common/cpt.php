<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modo_CPT {

	public static $instance;

	public static function get_instance(): Modo_CPT {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @param mixed $singular
	 * @param mixed $plurial
	 * @param mixed $genre
	 *
	 * @return array
	 */
	public static function cpt_labels( $singular, $plurial, $genre = 'm' ) {

		$singular = strtolower( $singular );
		$plurial  = strtolower( $plurial );

		$labels = [
			'name'          => ucfirst( $plurial ),
			'singular_name' => ucfirst( $singular ),
			'menu_name'     => ucfirst( $plurial ),
		];


		$first_letter = substr( $plurial, 0, 1 );
		$is_voyelle   = ( in_array( $first_letter, [ 'a', 'e', 'u', 'i', 'o', 'y' ] ) ) ? true : false;

		if ( $genre === 'f' ) {
			$denominator                  = ( $is_voyelle ) ? "l'" : 'la ';
			$labels['all_items']          = 'Toutes les ' . $plurial;
			$labels['add_new_item']       = 'Ajouter une ' . $singular;
			$labels['update_item']        = 'Modifier une ' . $singular;
			$labels['search_items']       = 'Rechercher une ' . $singular;
			$labels['not_found']          = 'Non trouvée';
			$labels['not_found_in_trash'] = 'Non trouvée dans la corbeille';
		} else {
			$denominator                  = ( $is_voyelle ) ? "l'" : 'le ';
			$labels['all_items']          = 'Tous les ' . $plurial;
			$labels['add_new_item']       = 'Ajouter un ' . $singular;
			$labels['update_item']        = 'Modifier un ' . $singular;
			$labels['search_items']       = 'Rechercher un ' . $singular;
			$labels['not_found']          = 'Non trouvé';
			$labels['not_found_in_trash'] = 'Non trouvé dans la corbeille';
		}

		$labels['edit_item']  = 'Editer ' . $denominator . $singular;
		$labels['view_item']  = 'Voir ' . $denominator . $singular;
		$labels['view_items'] = 'Voir les ' . $plurial;

		return $labels;
	}


	/**
	 * @param $singular
	 * @param $plurial
	 * @param $genre
	 *
	 * @return array
	 */
	public static function taxo_labels( $singular, $plurial, $genre = 'm' ) {

		$labels = [
			'name'          => ucfirst( $plurial ),
			'singular_name' => ucfirst( $singular ),
			'menu_name'     => ucfirst( $plurial ),
		];

		if ( $genre === 'f' ) {
			$labels['search_items']          = 'Rechercher une ' . $singular;
			$labels['all_items']             = 'Toutes les ' . $plurial;
			$labels['edit_item']             = 'Editer une ' . $singular;
			$labels['update_item']           = 'Mettre à jour une ' . $singular;
			$labels['add_new_item']          = 'Ajouter une nouvelle ' . $singular;
			$labels['new_item_name']         = 'Nom de la nouvelle ' . $singular;
			$labels['add_or_remove_items']   = 'Ajouter ou supprimer une ' . $singular;
			$labels['choose_from_most_used'] = 'Choisir parmi les ' . $plurial . ' les plus utilisées';
			$labels['not_found']             = 'Pas de ' . $singular . ' trouvée';
		} else {
			$labels['search_items']          = 'Rechercher un ' . $singular;
			$labels['all_items']             = 'Tous les ' . $plurial;
			$labels['edit_item']             = 'Editer un ' . $singular;
			$labels['update_item']           = 'Mettre à jour un ' . $singular;
			$labels['add_new_item']          = 'Ajouter un nouveau ' . $singular;
			$labels['new_item_name']         = 'Nom du nouveau ' . $singular;
			$labels['add_or_remove_items']   = 'Ajouter ou supprimer un ' . $singular;
			$labels['choose_from_most_used'] = 'Choisir parmi les ' . $plurial . ' les plus utilisés';
			$labels['not_found']             = 'Pas de ' . $singular . ' trouvé';
		}

		$labels['popular_items'] = ucfirst( $plurial ) . ' populaires';

		return $labels;
	}
}
