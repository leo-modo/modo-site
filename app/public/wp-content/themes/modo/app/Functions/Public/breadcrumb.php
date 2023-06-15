<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Modo_Breadcrumb
 */
class Modo_Breadcrumb {

	/**
	 * @var array
	 */
	protected $tree = [];

	/**
	 * @var string[]
	 */
	protected $options = [
		'separator' => '»'
	];

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct( $args = [] ) {

		// Not in front page //
		if ( is_front_page() ) {
			return;
		}

		// Merge options //
		$this->options = array_merge( $this->options, $args );

		// Get tree //
		$this->get_tree();
	}


	/**
	 * get_tree
	 *
	 * @return void
	 */
	public function get_tree() {

		// Init tree //
		$this->tree[] = [
			'url'   => get_site_url(),
			'label' => __( 'Accueil', 'modo' )
		];

		$this->get_prefix();

		if ( ! is_front_page() && ( is_page() || is_home() ) ) {
			$this->get_tree_page();
		} elseif ( is_woocommerce() ) {
			$this->get_tree_woocommerce();
		} elseif ( is_single() ) {
			$this->get_tree_single();
		} elseif ( is_category() ) {
			$this->get_tree_category();
		} elseif ( is_tax() ) {
			$this->get_tree_taxonomy();
		} elseif ( is_archive() ) {
			$this->get_tree_archive();
		}
	}

	/**
	 * get_prefix
	 *
	 * @return void
	 */
	public function get_prefix() {

		if ( ! empty( $this->options['prefix'] ) ) {

			switch ( $this->options['prefix']['type'] ) {

				case 'page':
					if ( ! empty( $this->options['prefix']['id'] ) && is_numeric( $this->options['prefix']['id'] ) ) {
						$url   = get_permalink( $this->options['prefix']['id'] );
						$label = get_the_title( $this->options['prefix']['id'] );

						if ( ! empty( $url ) && ! empty( $label ) ) {
							$this->tree[] = [
								'url'   => $url,
								'label' => $label
							];
						}
					}
					break;
			}
		}
	}

	/**
	 * get_tree_page
	 *
	 * @return void
	 */
	public function get_tree_page() {

		$post = get_queried_object();

		// Ancestors //
		$ancestors = get_post_ancestors( $post );
		if ( ! empty( $ancestors ) && is_array( $ancestors ) ) {
			$ancestors = array_reverse( $ancestors );
			foreach ( $ancestors as $ancestor ) {
				$this->tree[] = [
					'url'   => get_permalink( $ancestor ),
					'label' => get_the_title( $ancestor )
				];
			}
		}

		// Current item //
		$this->tree[] = [
			'url'   => get_permalink( $post ),
			'label' => get_the_title( $post )
		];
	}


	/**
	 * get_tree_single
	 *
	 * @return void
	 */
	public function get_tree_single() {

		global $post;

		// Articles //
		if ( get_post_type() === 'post' ) {

			// Page home //
			$page_home_id = get_option( 'page_for_posts' );
			if ( ! empty( $page_home_id ) ) {
				$this->tree[] = [
					'url'   => get_permalink( $page_home_id ),
					'label' => get_the_title( $page_home_id )
				];
			}

			// Categories //
			$categories = get_the_category( $post->ID );
			if ( ! empty( $categories ) ) {
				$category = current( $categories );

				$this->get_term_tree( $category );
			}
		} else {

			// Archive CPT //
			$post_type_obj = get_post_type_object( get_post_type() );
			if ( $post_type_obj->has_archive ) {
				$this->tree[] = [
					'url'   => get_post_type_archive_link( get_post_type() ),
					'label' => $post_type_obj->label
				];
			}

			// Ancestors //
			$ancestors = get_post_ancestors( $post );
			if ( ! empty( $ancestors ) && is_array( $ancestors ) ) {
				$ancestors = array_reverse( $ancestors );
				foreach ( $ancestors as $ancestor ) {
					$this->tree[] = [
						'url'   => get_permalink( $ancestor ),
						'label' => get_the_title( $ancestor )
					];
				}
			}
		}


		// Current item //
		$this->tree[] = [
			'url'   => get_permalink( $post ),
			'label' => get_the_title( $post )
		];
	}

	/**
	 * get_tree_category
	 *
	 * @return void
	 */
	public function get_tree_category() {

		// Page home //
		$page_home_id = get_option( 'page_for_posts' );
		if ( ! empty( $page_home_id ) ) {
			$this->tree[] = [
				'url'   => get_permalink( $page_home_id ),
				'label' => get_the_title( $page_home_id )
			];
		}

		$category = get_queried_object();
		$this->get_term_tree( $category );
	}

	/**
	 * @return void
	 */
	public function get_tree_taxonomy() {

		$term = get_queried_object();

		// Add CPT item tree
		$cpts = get_taxonomy( $term->taxonomy );
		if ( ! empty( $cpts->object_type ) ) {
			$cpt          = current( $cpts->object_type );
			$this->tree[] = [
				'url'   => get_post_type_archive_link( $cpt ),
				'label' => get_post_type_object( $cpt )->labels->name
			];
		}

		// Add term tree
		$this->get_term_tree( $term );

	}


	/**
	 * get_term_tree
	 *
	 * @param mixed $term
	 *
	 * @return void
	 */
	public function get_term_tree( $term ) {


		if ( ! empty( $term ) && ! empty( $term->term_id ) ) {

			// Categorie ancestors //
			$ancestors = get_ancestors( $term->term_id, $term->taxonomy );
			if ( ! empty( $ancestors ) ) {
				$ancestors = array_reverse( $ancestors );
				foreach ( $ancestors as $ancestor ) {
					$ancestor_meta = get_term( $ancestor, $term->taxonomy );
					$this->tree[]  = [
						'url'   => get_term_link( $ancestor_meta ),
						'label' => $ancestor_meta->name
					];
				}
			}

			// Main post category //
			$this->tree[] = [
				'url'   => get_term_link( $term ),
				'label' => $term->name
			];
		}
	}

	/**
	 * get_tree_archive
	 *
	 * @return void
	 */
	public function get_tree_archive() {

		$post_type_obj = get_queried_object();

		if ( $post_type_obj->has_archive ) {
			$this->tree[] = [
				'url'   => get_post_type_archive_link( get_post_type() ),
				'label' => $post_type_obj->label
			];
		}
	}

	/**
	 * @return void
	 */
	public function get_tree_woocommerce() {

		global $post;

		$shop_page_id = wc_get_page_id( 'shop' );
		if ( ! empty( $shop_page_id ) ) {
			$this->tree[] = [
				'url'   => get_permalink( $shop_page_id ),
				'label' => get_the_title( $shop_page_id )
			];
		}

		if ( is_archive() ) {
			$category = get_queried_object();
			$this->get_term_tree( $category );
		}

		if ( is_single() ) {

			$terms = get_the_terms( $post->ID, 'product_cat' );

			if ( ! empty( $terms ) ) {
				$term = current( $terms );
				if ( ! empty( $term ) ) {
					$this->get_term_tree( $term );
				}
			}

			$this->tree[] = [
				'url'   => get_permalink( $post ),
				'label' => get_the_title( $post )
			];
		}
	}

	/**
	 * render
	 *
	 * @return void
	 */
	public function render() {

		$html = '<div class="breadcrumb">';
		$html .= '<ol itemscope itemtype="http://schema.org/BreadcrumbList">';

		if ( ! empty( $this->tree ) ) {
			foreach ( $this->tree as $k => $tree ) {

				$html .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';

				if ( $k === count( $this->tree ) - 1 ) {
					$html .= '<span class="current">' . $tree['label'] . '</span>';
				} else {
					$html .= '<a href="' . $tree['url'] . '" itemprop="item"><span itemprop="name">' . $tree['label'] . '</span></a>';
					$html .= '<span class="separator"> ' . $this->options['separator'] . ' </span>';
				}

				$pos  = $k + 1;
				$html .= '<meta itemprop="position" content="' . $pos . '" />';
				$html .= '</li>';
			}
		}

		$html .= '</ol>';
		$html .= '</div>';

		return $html;
	}
}
