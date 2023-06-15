<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 *
 */
class Modo_Pagination {

	/**
	 * @var
	 */
	protected $current_page;

	/**
	 * @var
	 */
	protected $total_page;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct($args = []) {

		$this->get_current_page();
		$this->get_total_page();
	}

	/**
	 * get_current_page
	 *
	 * @return void
	 */
	public function get_current_page() {
		$this->current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	/**
	 * get_total_page
	 *
	 * @return void
	 */
	public function get_total_page() {

		global $wp_query;
		$this->total_page = $wp_query->max_num_pages;
	}


	/**
	 * @return string|void
	 */
	public function render() {

		if ($this->total_page < 2) return;

		$html = '<div class="pagination">';
		$html .= '<div class="pagination-wrap">';

		// Previous button //
		if ($this->current_page == 1) {
			$html .= '<span class="prev is-disabled">' . __('Précédent', 'modo') . '</span>';
		} else {
			$prev_page = (int)$this->current_page - 1;
			$html .= '<a href="' . get_pagenum_link($prev_page) . '" class="prev">' . __('Précédent', 'modo') . '</a>';
		}

		// Links //
		for ($i = 1; $i <= $this->total_page; $i++) {

			if ($this->current_page == $i) {
				$html .= '<span class="current">' . $i . '</span>';
			} else {
				$html .= '<a href="' . get_pagenum_link($i) . '">' . $i . '</a>';
			}
		}

		// Next button //
		if ($this->current_page == $this->total_page) {
			$html .= '<span class="next is-disabled">' . __('Suivant', 'modo') . '</span>';
		} else {
			$next_page = (int)$this->current_page + 1;
			$html .= '<a href="' . get_pagenum_link($next_page) . '" class="next">' . __('Suivant', 'modo') . '</a>';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}
