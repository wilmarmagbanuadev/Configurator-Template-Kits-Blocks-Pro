<?php
namespace BlankElementsPro\Modules\Portfolio;

use BlankElementsPro\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'blank-portfolio';
	}

	public function get_widgets() {
		return [
			'Portfolio',
		];
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		/**
		 * Pagination Break.
		 *
		 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
		 */
		/*add_action( 'pre_get_posts', [ $this, 'fix_query_offset' ], 1 );
		add_filter( 'found_posts', [ $this, 'fix_query_found_posts' ], 1, 2 );*/

		add_action( 'wp_ajax_blank_get_portfolio', array( $this, 'get_post_data' ) );
	}
	
	public function get_post_data() {
		
		$post_id   = $_POST['page_id'];
		$widget_id = $_POST['widget_id'];
		$search    = $_POST['search'];
        $filter_taxonomy	= $_POST['filter_taxonomy'];
        $filter    	= $_POST['filter'];
		//$filter    = $_POST['category'];
		//$filter    = str_replace( '.', '', $filter );

		$elementor = \Elementor\Plugin::$instance;
		$meta      = $elementor->db->get_plain_editor( $post_id );

		$widget_data = $this->find_element_recursive( $meta, $widget_id );
		
		$data = array(
			'message'    => __( 'Saved', 'blank-elements-pro' ),
			'ID'         => '',
			'html'       => '',
			'pagination' => '',
		);
		
		if ( null != $widget_data ) {
			
			// Restore default values.
			$widget = $elementor->elements_manager->create_element_instance( $widget_data );
			//$skin = $widget->get_current_skin();
			$skin_body = $widget->render_ajax_post_body( $filter, $filter_taxonomy, $search );
			$pagination = $widget->render_ajax_pagination();
		
			$data['ID']         = $widget->get_id();
			$data['html']		= $skin_body;
			$data['pagination'] = $pagination;
		}
		wp_send_json_success( $data );
	}

	/**
	 * Get Widget Setting data.
	 *
	 * @since 1.7.0
	 * @access public
	 * @param array  $elements Element array.
	 * @param string $form_id Element ID.
	 * @return Boolean True/False.
	 */
	public function find_element_recursive( $elements, $form_id ) {

		foreach ( $elements as $element ) {
			if ( $form_id === $element['id'] ) {
				return $element;
			}

			if ( ! empty( $element['elements'] ) ) {
				$element = $this->find_element_recursive( $element['elements'], $form_id );

				if ( $element ) {
					return $element;
				}
			}
		}

		return false;
	}
}
