<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Modo_Post_Column {

	/**
	 * @var mixed
	 */
	protected $post_type;

	/**
	 * @var mixed
	 */
	protected $name;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @param array $args
	 */
	public function __construct( array $args = [] ) {

		$this->post_type = $args['post_type'];
		$this->name      = $args['name'];
		$this->value     = $args['value'];

		add_filter( 'manage_' . $this->post_type . '_posts_columns', [ $this, 'manage_columns' ] );
		add_action( 'manage_' . $this->post_type . '_posts_custom_column', [ $this, 'manage_content' ], 10, 2 );
	}

	/**
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function manage_columns( $columns ) {

		unset( $columns['date'] );
		$columns[ $this->name['id'] ] = $this->name['label'];
		$columns['date']              = 'Date';

		return $columns;
	}


	/**
	 * @param $column_key
	 * @param $post_id
	 *
	 * @return int|mixed|string|void
	 */
	public function manage_content( $column_key, $post_id ) {
		if ( $column_key === $this->name['id'] ) {

			switch ( $this->value['type'] ) {

				case 'meta':
					return $this->get_meta( $post_id );

				case 'taxo':
					$this->get_taxo( $post_id );
					break;

				case 'callback':

					if ( ! empty( $this->value['name']['class'] ) && ! empty( $this->value['name']['method'] ) ) {
						if ( class_exists( $this->value['name']['class'] ) ) {
							call_user_func( [$this->value['name']['class'], $this->value['name']['method']], $post_id );
						}
					}

					break;
			}
		}
	}

	/**
	 * @param $post_id
	 *
	 * @return int|mixed|string|void
	 */
	public function get_meta( $post_id ) {

		$meta = get_post_meta( $post_id, $this->value['name'], true );

		if ( ! empty( $meta ) ) {

			switch ( $meta['type'] ) {

				case 'url':
					echo '<a href="' . esc_url( $meta['value'] ) . '" target="_blank">' . esc_url( $meta['value'] ) . '</a>';
					break;

				default:
					echo sanitize_text_field( $meta['value'] );
					break;
			}
		}
	}

	/**
	 * @param $post_id
	 *
	 * @return void
	 */
	public function get_taxo( $post_id ) {

		$terms = get_the_terms( $post_id, $this->value['name'] );
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $k => $term ) {
				echo ( $k !== 0 ) ? ', ' : '';
				echo $term->name;
			}
		}
	}
}