<?php
namespace BlankElementsPro\Modules\Portfolio\Widgets;

use BlankElementsPro\Classes\Blank_Posts_Helper;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Posts Grid Widget
 */
class Portfolio extends Widget_Base {
    
    /**
	 * Retrieve posts grid widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-portfolio';
    }

    /**
	 * Retrieve posts grid widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Portfolio', 'blank-elements-pro' );
    }

    /**
	 * Retrieve the list of categories the posts grid widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'configurator-template-kits-blocks-pro-widgets' ];
    }

    /**
	 * Retrieve posts grid widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-archive-posts';
    }

	public function get_script_depends() {
		return [
			'isotope',
			'imagesLoaded',
			'blank-portfolio-js',
            'blank-js'
		];
	}

    /**
	 * Register posts grid widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    public function register_query_section_controls() {

        /**
         * Content Tab: Query
         */
        $this->start_controls_section(
            'section_query',
            [
                'label'             	=> __( 'Query', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
            'post_type',
            [
                'label'             => __( 'Post Type', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SELECT,
				'options'           => Blank_Posts_Helper::get_post_types(),
            ]
        );
        
        $this->add_control(
            'posts_per_page',
            [
                'label'                 => __( 'Posts Per Page', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 10,
            ]
        ); 

        $this->add_control(
            'order',
            [
                'label'					=> __( 'Order', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SELECT,
                'options'				=> [
                   'DESC'		=> __( 'Descending', 'blank-elements-pro' ),
                   'ASC'		=> __( 'Ascending', 'blank-elements-pro' ),
                ],
                'default'				=> 'DESC',
                'separator'				=> 'before',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'					=> __( 'Order By', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SELECT,
                'options'				=> [
                   'date'           => __( 'Date', 'blank-elements-pro' ),
                   'modified'       => __( 'Last Modified Date', 'blank-elements-pro' ),
                   'rand'           => __( 'Random', 'blank-elements-pro' ),
                   'comment_count'  => __( 'Comment Count', 'blank-elements-pro' ),
                   'title'          => __( 'Title', 'blank-elements-pro' ),
                   'ID'             => __( 'Post ID', 'blank-elements-pro' ),
                   'author'         => __( 'Post Author', 'blank-elements-pro' ),
                ],
                'default'				=> 'date',
            ]
        );
        
        $this->add_control(
            'sticky_posts',
            [
                'label'					=> __( 'Sticky Posts', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SWITCHER,
                'default'				=> '',
                'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
                'label_off'				=> __( 'No', 'blank-elements-pro' ),
                'return_value'			=> 'yes',
                'separator'				=> 'before',
            ]
        );
        
        $this->add_control(
            'all_sticky_posts',
            [
                'label'					=> __( 'Show Only Sticky Posts', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SWITCHER,
                'default'				=> '',
                'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
                'label_off'				=> __( 'No', 'blank-elements-pro' ),
                'return_value'			=> 'yes',
				'condition'				=> [
					'sticky_posts' => 'yes',
				],
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'					=> __( 'Offset', 'blank-elements-pro' ),
                'description'			=> __( 'Use this setting to skip this number of initial posts', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::NUMBER,
                'default'				=> '',
                'separator'				=> 'before',
            ]
        );

        $this->end_controls_section();
    }
	
	protected function register_layout_content_controls() {
        /**
         * Content Tab: Layout
         */
        $this->start_controls_section(
            'section_layout',
            [
                'label'                 => __( 'Layout', 'blank-elements-pro' ),
            ]
        );
		
        $this->add_responsive_control(
            'columns',
            [
                'label'                 => __( 'Columns', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '2',
                'tablet_default'        => '2',
                'mobile_default'        => '1',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true,
            ]
        );
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'thumbnail',
				'label'                 => __( 'Image Size', 'blank-elements-pro' ),
				'default'               => 'large',
				'exclude'           => [ 'custom' ],
			]
		);
		
		$this->end_controls_section();
	}

	protected function register_filter_section_controls() {

		$this->start_controls_section(
			'section_filters',
			[
				'label'					=> __( 'Filters', 'blank-elements-pro' ),
				'tab'					=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_filters',
			[
				'label'					=> __( 'Show Filters', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
				'label_off'				=> __( 'No', 'blank-elements-pro' ),
				'return_value'			=> 'yes',
				'default'				=> 'no',
			]
		);
        
        $this->add_control(
            'filter_taxonomy',
            [
                'label'             => __( 'Filter By', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SELECT,
				'options'           => Blank_Posts_Helper::get_taxonomies_options(), 
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );

        $this->add_control(
            'filter_all_label',
            [
                'label'                 => __( '"All" Filter Label', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( 'All', 'blank-elements-pro' ),
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );
		
		$this->end_controls_section();
	}

	public function register_pagination_controls() {
		$this->start_controls_section(
			'section_pagination',
			[
				'label'					=> __( 'Pagination', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label'					=> __( 'Pagination', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SELECT,
				'default'				=> 'none',
				'options'				=> [
					'none'					=> __( 'None', 'blank-elements-pro' ),
					'numbers'				=> __( 'Numbers', 'blank-elements-pro' ),
					'numbers_and_prev_next'	=> __( 'Numbers', 'blank-elements-pro' ) . ' + ' . __( 'Previous/Next', 'blank-elements-pro' ),
					'load_more'				=> __( 'Load More Button', 'blank-elements-pro' ),
					'infinite'				=> __( 'Infinite', 'blank-elements-pro' ),
				],
			]
		);

		$this->add_control(
			'pagination_page_limit',
			[
				'label'					=> __( 'Page Limit', 'blank-elements-pro' ),
				'default'				=> '5',
				'condition'				=> [
					'pagination_type!'	=> 'none',
				],
			]
		);

		$this->add_control(
			'pagination_numbers_shorten',
			[
				'label'					=> __( 'Shorten', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'default'				=> '',
				'condition'				=> [
					'pagination_type'	=> [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_load_more_label',
			[
				'label'					=> __( 'Button Label', 'blank-elements-pro' ),
				'default'				=> __( 'Load More', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type'	=> 'load_more',
				],
			]
		);

		$this->add_control(
			'pagination_prev_label',
			[
				'label'					=> __( 'Previous Label', 'blank-elements-pro' ),
				'default'				=> __( '&laquo; Previous', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type'	=> 'numbers_and_prev_next',
				],
			]
		);

		$this->add_control(
			'pagination_next_label',
			[
				'label'					=> __( 'Next Label', 'blank-elements-pro' ),
				'default'				=> __( 'Next &raquo;', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type'	=> 'numbers_and_prev_next',
				],
			]
		);

		$this->add_control(
			'pagination_align',
			[
				'label'					=> __( 'Alignment', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::CHOOSE,
				'options'			=> [
					'left'		=> [
						'title'	=> __( 'Left', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-left',
					],
					'center'	=> [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-center',
					],
					'right'		=> [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-right',
					],
				],
				'default'				=> 'center',
				'selectors'			=> [
					'{{WRAPPER}} .blank-portfolio-pagination-wrap' => 'text-align: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!'	=> 'none',
				],
			]
		);

		$this->end_controls_section();
	}
    
	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Style Tab: Layout
	 */
	protected function register_style_layout_controls() {
		
        $this->start_controls_section(
            'section_layout_style',
            [
                'label'                 => __( 'Layout', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'posts_horizontal_spacing',
            [
                'label'                 => __( 'Column Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size' 	=> 70,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-elementor-grid .blank-grid-item-wrap' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .blank-elementor-grid'  => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'posts_vertical_spacing',
            [
                'label'                 => __( 'Row Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size' 	=> 70,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-elementor-grid .blank-grid-item-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
	}
	
	/**
	 * Style Tab: Box
	 */
	protected function register_style_box_controls() {
        $this->start_controls_section(
            'section_post_box_style',
            [
                'label'                 => __( 'Box', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'post_box_bg',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-grid-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'post_box_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-grid-item',
			]
		);

		$this->add_control(
			'post_box_padding',
			[
				'label'					=> __( 'Padding', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::DIMENSIONS,
				'size_units'			=> [ 'px', 'em', '%' ],
				'selectors'				=> [
					'{{WRAPPER}} .blank-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'              => 'post_box_shadow',
				'selector'          => '{{WRAPPER}} .blank-grid-item',
			]
		);
        
        $this->end_controls_section();
	}
	
	/**
	 * Style Tab: Content
	 */
	protected function register_style_content_controls() {
        $this->start_controls_section(
            'section_post_content_style',
            [
                'label'                 => __( 'Content', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'post_content_align',
			[
				'label'					=> __( 'Alignment', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::CHOOSE,
				'label_block'			=> false,
				'options'			=> [
					'left'		=> [
						'title'	=> __( 'Left', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-left',
					],
					'center'	=> [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-center',
					],
					'right'		=> [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-right',
					],
				],
				'default'				=> '',
				'selectors'			=> [
					'{{WRAPPER}} .blank-portfolio-content' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'post_content_bg',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'post_content_padding',
			[
				'label'					=> __( 'Padding', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::DIMENSIONS,
				'size_units'			=> [ 'px', 'em', '%' ],
				'selectors'				=> [
					'{{WRAPPER}} .blank-portfolio-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
	}
	
    public function register_style_filter_controls() {    
        /**
         * Style Tab: Filters
         */
        $this->start_controls_section(
            'section_filter_style',
            [
                'label'                 => __( 'Filters', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'filter_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-portfolio-filters .blank-portfolio-filter',
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );
        
        $this->add_responsive_control(
            'filters_margin_bottom',
            [
                'label'                 => __( 'Filters Bottom Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 80,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-filters' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );

        $this->start_controls_tabs( 'tabs_filter_style' );

        $this->start_controls_tab(
            'tab_filter_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );

        $this->add_control(
            'filter_color_normal',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-filter' => 'color: {{VALUE}};',
                ],
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );

		$this->add_responsive_control(
			'filter_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'placeholder'           => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-portfolio-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_filter_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );

        $this->add_control(
            'filter_color_hover',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-filter:hover' => 'color: {{VALUE}};',
                ],
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'              => 'filter_box_shadow_hover',
				'selector'          => '{{WRAPPER}} .blank-portfolio-filter:hover',
                'condition'				=> [
					'show_filters'	=> 'yes',
                ]
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
    }
	
	/**
	 * Style Tab: Image
	 */
	protected function register_style_image_controls() {
		$this->start_controls_section(
			'section_image_style',
			[
				'label'					=> __( 'Image', 'blank-elements-pro' ),
				'tab'					=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label'					=> __( 'Spacing', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SLIDER,
				'range'					=> [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'				=> [
					'{{WRAPPER}} .blank-portfolio-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'default'				=> [
					'size' => 20,
				],
			]
		);

		$this->end_controls_section();
	}
	
	/**
	 * Style Tab: Title
	 */
	protected function register_style_title_controls() {
        $this->start_controls_section(
            'section_title_style',
            [
                'label'					=> __( 'Title', 'blank-elements-pro' ),
                'tab'					=> Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#111111',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'                 => __( 'Hover Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-portfolio-title',
            ]
        );
        
        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'                 => __( 'Margin Bottom', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size' 	=> 10,
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
	}

	/**
	 * Style Tab: Meta
	 */
	protected function register_style_meta_controls() {
		
        $this->start_controls_section(
            'section_meta_style',
            [
                'label'                 => __( 'Meta', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'category_text_color',
            [
                'label'                 => __( 'Category Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#111111',
                'selectors'             => [
                    '{{WRAPPER}} .post-cats a' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'cat_typography',
                'label'                 => __( 'Category Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .post-cats',
            ]
        );
        
        $this->add_responsive_control(
            'cat_margin_bottom',
            [
                'label'                 => __( 'Category Margin Bottom', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size' 	=> 0,
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .post-cats' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();

    }

	public function register_style_pagination_controls() {
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'					=> __( 'Pagination', 'blank-elements-pro' ),
				'tab'					=> Controls_Manager::TAB_STYLE,
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'				=> 'pagination_typography',
				'selector'			=> '{{WRAPPER}} .elementor-pagination',
				'scheme'			=> Scheme_Typography::TYPOGRAPHY_2,
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_color_heading',
			[
				'label'					=> __( 'Colors', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::HEADING,
				'separator'			=> 'before',
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->start_controls_tabs( 'pagination_colors' );

		$this->start_controls_tab(
			'pagination_color_normal',
			[
				'label'					=> __( 'Normal', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'					=> __( 'Color', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::COLOR,
				'selectors'			=> [
					'{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_hover',
			[
				'label'					=> __( 'Hover', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label'					=> __( 'Color', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::COLOR,
				'selectors'			=> [
					'{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_active',
			[
				'label'					=> __( 'Active', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'					=> __( 'Color', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::COLOR,
				'selectors'			=> [
					'{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'					=> __( 'Space Between', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SLIDER,
				'separator'			=> 'before',
				'default'				=> [
					'size' => 10,
				],
				'range'				=> [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'			=> [
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_section();
	}
	public function register_advance_rule_control(){
		// add advance Display Conditions
		$this->start_controls_section(
			'configurator_block_advanced',
                [
                    'label' => __( 'Configurator Block Rule', 'configurator-blocks' ),
                    'tab' => Controls_Manager::TAB_ADVANCED,
                ]
            );
            $this->add_control(
                'configurator_block_condition',
                [
                    'label' => __( 'Rule Condition', 'configurator-blocks' ),
                    'type' => Controls_Manager::SWITCHER,
                    'options' => [
                        'yes' => __( 'Yes', 'configurator-blocks' ),
                        'no' => __( 'No', 'configurator-blocks' ),
                    ],
                    'default' => 'no'
                ]
            );
            $repeater = new Repeater();

            $repeater->add_control(
                'condition_key',
                [
                    'type' => Controls_Manager::SELECT,
                    'label_block'=>true,
                    'default' => 'authentication',
                    'show_label' => false,
                    'options' => [
                        // User
                        'authentication'  =>__( 'Login Status', 'configurator-blocks' ),
                        'user'  =>__( 'Current User', 'configurator-blocks' ),
                        'role'  =>__( 'User Role', 'configurator-blocks' ),
                    ],	
            
                ]
            );
            $repeater->add_control(
                'is_not',
                [
                    'type' => Controls_Manager::SELECT,
                    'label_block'=>true,
                    'default' => 'is',
                    'show_label' => false,
                    'options' => [
                        'is'  =>__( 'Is', 'configurator-blocks' ),
                        'is_not'  =>__( 'Is Not', 'configurator-blocks' ),
                    ],	
            
                ]
            );
            $repeater->add_control(
                'is_login',
                [
                    'type' => Controls_Manager::SELECT,
                    'label_block'=>true,
                    'default' => 'authenticated',
                    'condition' => [
                        'condition_key' => 'authentication'
                    ],
                    'show_label' => false,
                    'options' => [
                        'authenticated'  =>__( 'Logged in', 'configurator-blocks' ),
                    ],	
            
                ]
            );
            $repeater->add_control(
                'current_user',
                [
                    'type' => Controls_Manager::TEXT,
                    'label_block'=>true,
                    'condition' => [
                        'condition_key' => 'user'
                    ],
                    'show_label' => false,
                    'placeholder' => __( 'Current User', 'configurator-blocks' ),
            
                ]
            );
    
            $repeater->add_control(
                'user_role',
                [
                    'type' => Controls_Manager::SELECT,
                    'label_block'=>true,
                    'default' => 'subscriber',
                    'condition' => [
                        'condition_key' => 'role'
                    ],
                    'show_label' => false,
                    'options' => [
                        'administrator'  =>__( 'Administrator', 'configurator-blocks' ),
                        'editor'  =>__( 'Editor', 'configurator-blocks' ),
                        'author'  =>__( 'Author', 'configurator-blocks' ),
                        'contributor'  =>__( 'Contributor', 'configurator-blocks' ),
                        'subscriber'  =>__( 'Subscriber', 'configurator-blocks' )
                    ],	
            
                ]
            );
    
            $this->add_control(
                
                'condition_list',
                [
                    'label' => __( '', 'configurator-blocks' ),
                    'type' => Controls_Manager::REPEATER,
                    'condition' => [
                        'configurator_block_condition' => 'yes'
                    ],
                    'fields' => $repeater->get_controls(),
                    'item_actions' => [
                        'add'       => false,
                        'duplicate' => false,
                        'remove'    => false,
                        'sort'      => true,
                    ],
					'default' => [
                        [
                            'condition_key' =>__( 'authentication', 'configurator-blocks-pro' ),
                        ],
                    ],
                    'title_field' => 'Rule',
                ]
            );
        $this->end_controls_section();
	}

	protected function _register_controls() {
		$this->register_layout_content_controls();
		$this->register_query_section_controls();
		$this->register_filter_section_controls();
		$this->register_pagination_controls();

		$this->register_style_layout_controls();
		$this->register_style_box_controls();
		$this->register_style_content_controls();
		$this->register_style_filter_controls();
		$this->register_style_image_controls();
		$this->register_style_title_controls();
		$this->register_style_meta_controls();
		$this->register_style_pagination_controls();

		$this->register_advance_rule_control();
	}

    /**
	 * Get post query arguments.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function query_posts_args( $filter = '', $filter_taxonomy = '' ) {
        $settings = $this->get_settings();
        $paged = $this->get_paged();
        $tax_count = 0;
        
		// Query Arguments
		$args = array(
			'post_status'           => array( 'publish' ),
			'post_type'             => $settings['post_type'],
			'orderby'               => $settings['orderby'],
			'order'                 => $settings['order'],
			'offset'                => $settings['offset'],
			'ignore_sticky_posts'   => ( 'yes' == $settings[ 'sticky_posts' ] ) ? 0 : 1,
			'showposts'             => $settings['posts_per_page'],
			'paged'					=> $paged,
		);
		
		if ( '' != $filter && '*' != $filter ) {
			$args['tax_query'][$tax_count]['taxonomy'] = $filter_taxonomy;
			$args['tax_query'][$tax_count]['field'] = 'slug';
			$args['tax_query'][$tax_count]['terms'] = $filter;
			$args['tax_query'][$tax_count]['operator'] = 'IN';
		}
		
		// Sticky Posts Filter
		if ( $settings['sticky_posts'] == 'yes' && $settings['all_sticky_posts'] == 'yes' ) {
			$post__in = get_option( 'sticky_posts' );
			
			$args['post__in'] = $post__in;
		}
        //print_r($args);
		return $args;

        
	}

	public function query_posts( $filter = '', $filter_taxonomy = '' ) {
		
		$query_args  = $this->query_posts_args( $filter, $filter_taxonomy );
		
		return new \WP_Query( $query_args );
	}

	/**
	 * Returns the paged number for the query.
	 *
	 * @since 1.7.0
	 * @return int
	 */
	static public function get_paged() {

		global $wp_the_query, $paged;

		if ( isset( $_POST['page_number'] ) && '' != $_POST['page_number'] ) {
			return $_POST['page_number'];
		}

		// Check the 'paged' query var.
		$paged_qv = $wp_the_query->get( 'paged' );

		if ( is_numeric( $paged_qv ) ) {
			if ( ! $paged_qv ) {
				$paged_qv = 1;
			}
			return $paged_qv;
		}

		// Check the 'page' query var.
		$page_qv = $wp_the_query->get( 'page' );

		if ( is_numeric( $page_qv ) ) {
			return $page_qv;
		}

		// Check the $paged global?
		if ( is_numeric( $paged ) ) {
			return $paged;
		}

		return 0;
	}

	public function get_posts_nav_link( $page_limit = null ) {
		if ( ! $page_limit ) {
			$page_limit = $this->query->max_num_pages;
		}

		$return = [];

		$paged = $this->get_paged();

		$link_template = '<a class="page-numbers %s" href="%s">%s</a>';
		$disabled_template = '<span class="page-numbers %s">%s</span>';

		if ( $paged > 1 ) {
			$next_page = intval( $paged ) - 1;
			if ( $next_page < 1 ) {
				$next_page = 1;
			}

			$return['prev'] = sprintf( $link_template, 'prev', $this->get_wp_link_page( $next_page ), $this->get_settings( 'pagination_prev_label' ) );
		} else {
			$return['prev'] = sprintf( $disabled_template, 'prev', $this->get_settings( 'pagination_prev_label' ) );
		}

		$next_page = intval( $paged ) + 1;

		if ( $next_page <= $page_limit ) {
			$return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), $this->get_settings( 'pagination_next_label' ) );
		} else {
			$return['next'] = sprintf( $disabled_template, 'next', $this->get_settings( 'pagination_next_label' ) );
		}

		return $return;
	}

	private function get_wp_link_page( $i ) {
		if ( ! is_singular() || is_front_page() ) {
			return get_pagenum_link( $i );
		}

		// Based on wp-includes/post-template.php:957 `_wp_link_page`.
		global $wp_rewrite;
		$post = get_post();
		$query_args = [];
		$url = get_permalink();

		if ( $i > 1 ) {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
				$url = add_query_arg( 'page', $i, $url );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
			} else {
				$url = trailingslashit( $url ) . user_trailingslashit( $i, 'single_paged' );
			}
		}

		if ( is_preview() ) {
			if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
				$query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
				$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
			}

			$url = get_preview_post_link( $post, $query_args, $url );
		}

		return $url;
	}

	/**
	 * Get Filter taxonomy array.
	 *
	 * Returns the Filter array of objects.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function get_filter_values() {

		$settings = $this->get_settings_for_display();

		$filter_by = 'category';
        
		// Get the categories for post types.
		$taxs = get_terms($filter_by);
		$filter_array = array();

		if ( is_wp_error( $taxs ) ) {
			return array();
		}

		$filter_array = $taxs;
		return $filter_array;
	}

	/**
	 * Render Filters.
	 *
	 * Returns the Filter HTML.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function render_filters() {
		$settings = $this->get_settings_for_display();
		
		$show_filters = $settings[ 'show_filters' ];

		if ( 'yes' != $show_filters ) {
			return;
		}
        
        $taxonomy = $settings['filter_taxonomy'];
		$filters = get_terms($taxonomy);
		$all_label = $settings[ 'filter_all_label' ];

		?>
		<div class="blank-portfolio-filters-wrap" data-filter-taxonomy="<?php echo $settings['filter_taxonomy']; ?>">
			<ul class="blank-portfolio-filters">
                <li class="blank-portfolio-filter blank-filter-current" data-filter="*"><span class="blank-filter-title"><?php echo __( 'Filter by -', 'blank-elements-pro' ); ?></span><?php echo __( 'All', 'blank-elements-pro' ); ?></li>
                <?php foreach ( $filters as $key => $value ) { 
                    $filter_value = $value->name;
                ?>
                <li class="blank-portfolio-filter" data-filter="<?php echo '.' . $value->slug; ?>"><?php echo $filter_value; ?></li>
                <?php } ?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Get Masonry classes array.
	 *
	 * Returns the Masonry classes array.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function get_masonry_classes() {

		$settings = $this->get_settings_for_display();

		$post_type = $settings['post_type'];

		$filter_by = $this->get_instance_value( 'tax_' . $post_type . '_filter' );

		$taxonomies = wp_get_post_terms( get_the_ID(), $filter_by );
		$class      = array();

		if ( count( $taxonomies ) > 0 ) {

			foreach ( $taxonomies as $taxonomy ) {

				if ( is_object( $taxonomy ) ) {

					$class[] = $taxonomy->slug;
				}
			}
		}

		return implode( ' ', $class );
	}
    
    /**
	 * Render post thumbnail output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function get_post_thumbnail() {

		$settings = $this->get_settings_for_display();

		if ( has_post_thumbnail() ) {
            
            $image_id = get_post_thumbnail_id( get_the_ID() );
			
			$setting_key = $settings[ 'thumbnail_size' ];
			$settings[ $setting_key ] = [
				'id' => $image_id,
			];
			$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );

		}

		if ( empty( $thumbnail_html ) ) {
			return;
		}
		
		return $thumbnail_html;
	}
    
    /**
	 * Render post title output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_post_title() {
        ?>
		<div class="blank-portfolio-title">
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
				<?php the_title(); ?>
			</a>
		</div>
        <?php
    }
    
    /**
	 * Render post thumbnail output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_post_thumbnail() {
		
		$thumbnail_html = $this->get_post_thumbnail();

		if ( empty( $thumbnail_html ) ) {
			return;
		}
		
		//$thumbnail_html = '<a href="' . get_the_permalink() . '">' . $thumbnail_html . '</a>';
		?>
		<div class="blank-portfolio-thumbnail">
			<a href="<?php echo get_the_permalink() ?>"><?php echo $thumbnail_html; ?>
			</a>
		</div>
		<?php
	}
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render_ajax_post_body( $filter = '', $filter_taxonomy = '' ) {
		ob_start();
		
		$query = $this->query_posts( $filter, $filter_taxonomy );
		$total_pages = $query->max_num_pages;

		while ($query->have_posts()) {
			$query->the_post();

			$this->render_post_body();

		$i++;
		}

		wp_reset_postdata();
		
		return ob_get_clean();
	}
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render_ajax_pagination() {
		ob_start();
		$this->render_pagination();
		return ob_get_clean();
	}

	/**
	 * Get Pagination.
	 *
	 * Returns the Pagination HTML.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function render_pagination() {
		$settings = $this->get_settings_for_display();

		$pagination_type = $settings[ 'pagination_type' ];
		$page_limit = $settings[ 'pagination_page_limit' ];
		$pagination_shorten = $settings[ 'pagination_numbers_shorten' ];
		$load_more_label = $settings[ 'pagination_load_more_label' ];

		if ( 'none' == $pagination_type ) {
			return;
		}

		// Get current page number.
		$paged = $this->get_paged();
		
		$query = $this->query_posts();
		$total_pages = $query->max_num_pages;

		if ( 'load_more' != $pagination_type || 'infinite' != $pagination_type ) {

			if ( '' !== $page_limit && null != $page_limit ) {
				$total_pages = min( $page_limit, $total_pages );
			}
		}
		
		if ( 2 > $total_pages ) {
			return;
		}
		
		$has_numbers = in_array( $pagination_type, [ 'numbers', 'numbers_and_prev_next' ] );
		$has_prev_next = ( $pagination_type == 'numbers_and_prev_next' );
		$is_load_more = ( $pagination_type == 'load_more' );
		$is_infinite = ( $pagination_type == 'infinite' );
		
		$links = [];

		if ( $has_numbers || $is_infinite ) {
			
			$current_page = $paged;
			if ( ! $current_page ) {
				$current_page = 1;
			}
			
			$paginate_args = [
				'type'			=> 'array',
				'current'		=> $current_page,
				'total'			=> $total_pages,
				'prev_next'		=> false,
				'show_all'		=> 'yes' !== $pagination_shorten,
			];

			if ( is_singular() && ! is_front_page() ) {
				global $wp_rewrite;
				if ( $wp_rewrite->using_permalinks() ) {
					$paginate_args['base'] = trailingslashit( get_permalink() ) . '%_%';
					$paginate_args['format'] = user_trailingslashit( '%#%', 'single_paged' );
				} else {
					$paginate_args['format'] = '?page=%#%';
				}
			}

			$links = paginate_links( $paginate_args );
		}

		if ( $has_prev_next || $is_infinite ) {
			$prev_next = $this->get_posts_nav_link( $total_pages );
			array_unshift( $links, $prev_next['prev'] );
			$links[] = $prev_next['next'];
		}
		if ( !$is_load_more ) {
			?>
			<nav class="blank-portfolio-pagination elementor-pagination" role="navigation" aria-label="<?php _e( 'Pagination', 'blank-elements-pro' ); ?>">
				<?php echo implode( PHP_EOL, $links ); ?>
			</nav>
			<?php
		}
		
		if ( $is_load_more ) {
			?>
			<div class="blank-portfolio-load-more-wrap">
				<a class="blank-portfolio-load-more elementor-button elementor-size-sm" href="javascript:void(0);">
                    <span class="flaticon flaticon-rotate"></span>
					<span><?php echo $load_more_label; ?></span>
				</a>
			</div>
			<?php
		}
	}
	
	public function get_item_wrap_classes() {
		
		$classes[] = 'blank-grid-item-wrap';
		
		return implode( ' ', $classes );
	}
	
	public function get_item_classes() {
		
		$classes = array();
		
		$classes[] = 'blank-portfolio';
		
		$classes[] = 'blank-grid-item';
		
		return implode( ' ', $classes );
	}
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_post_body() {
        $settings = $this->get_settings_for_display();
		?>
		<div class="<?php echo $this->get_item_wrap_classes(); ?>">
			<div class="<?php echo $this->get_item_classes(); ?>">				
				<?php
					$this->render_post_thumbnail();
				?>
                <div class="blank-portfolio-content">
                    <?php
                        //post title
                        $this->render_post_title();
                    ?> 
                    <div class="post-cats">
                        <?php
                            // Categories
                            $taxonomy = Blank_Posts_Helper::get_post_taxonomies( $settings['post_type'] );
                            $related_tax = [];

                            // Get all taxonomy values under the taxonomy.
                            foreach ( $taxonomy as $index => $tax ) {

                                $terms = get_terms( $index );

                                $related_tax[ $index ] = $tax->label;
                            }
        
                            $taxonomies = array_keys( $related_tax )[0];
                            $categories = wp_get_post_terms( get_the_ID(), $taxonomies );
                            //print_r($cats);
                            $separator = ', ';
                            $output = '';
                            if ( $categories ) {
                                foreach( $categories as $category ) {
                                        $output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s','blogberg' ), $category->name ) ) . '">'.$category->name.'</a>'.$separator;
                                }
                                echo trim( $output, $separator );
                            }
                        ?>
                    </div>
                </div>

			</div>
		</div>
        <?php
    }

    /**
	 * Render posts grid widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render() {
        $settings = $this->get_settings_for_display();
		
		$pagination_type = $settings['pagination_type'];
		$skin			= $this->get_id();
		$page_id		= '';
		
		if ( null != \Elementor\Plugin::$instance->documents->get_current() ) {
			$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
		}
        
        $this->add_render_attribute( 'posts-wrap', 'class', [
			'blank-portfolio',
			'blank-elementor-grid',
			'blank-portfolio-skin-' . $this->get_id(),
			]
		);
		
		$this->add_render_attribute( 'posts-wrap', 'class', [
			'blank-elementor-grid',
			'blank-portfolio-grid',
			]
		);
		
		if ( $pagination_type == 'infinite' ) {
			$this->add_render_attribute( 'posts-wrap', 'class', 'blank-portfolio-infinite-scroll' );
		}
		
		$this->add_render_attribute( 'posts-wrap', 'data-page', $page_id );
		$this->add_render_attribute( 'posts-wrap', 'data-skin', $skin );
        
        $this->add_render_attribute( 'post-categories', 'class', 'blank-portfolio-categories' );
		// wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
						?>
						<div class="blank-portfolio-wrap">
							<div class="blank-portfolio-filters-container">
								<?php
									// Filters
									$this->render_filters();
								?>
							</div>
							
							<div class="blank-portfolio-container">
								<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
									<?php
										$filter = '';
										$filter_taxonomy = '';
										if( $settings['show_filters'] == 'yes' ) {
											$filter_taxonomy = $settings['filter_taxonomy'];
										}
										$count = 1;
										$query = $this->query_posts($filter, $filter_taxonomy);
										$total_pages = $query->max_num_pages;
										

										if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
						
											$this->render_post_body();
						
										$count++;

										endwhile; endif; wp_reset_postdata();
									?>
								</div>
								<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
								<div class="blank-portfolio-loader"></div>
								<?php } ?>
							</div>
						</div>
						<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
							<?php
								$this->render_pagination();
							?>
						</div>
						<?php
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in() ){
                           // show original here
						   ?>
							<div class="blank-portfolio-wrap">
								<div class="blank-portfolio-filters-container">
									<?php
										// Filters
										$this->render_filters();
									?>
								</div>
								
								<div class="blank-portfolio-container">
									<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
										<?php
											$filter = '';
											$filter_taxonomy = '';
											if( $settings['show_filters'] == 'yes' ) {
												$filter_taxonomy = $settings['filter_taxonomy'];
											}
											$count = 1;
											$query = $this->query_posts($filter, $filter_taxonomy);
											$total_pages = $query->max_num_pages;
											

											if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
							
												$this->render_post_body();
							
											$count++;

											endwhile; endif; wp_reset_postdata();
										?>
									</div>
									<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
									<div class="blank-portfolio-loader"></div>
									<?php } ?>
								</div>
							</div>
							<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
								<?php
									$this->render_pagination();
								?>
							</div>
							<?php
                        }
                    break;
                    case 'user':
                        global $current_user;
                        wp_get_current_user();
                        $current_user = $current_user->user_login;
                        if($item['is_not']=='is'){
                            if($current_user==$item['current_user']){
                               // show original here
							   ?>
								<div class="blank-portfolio-wrap">
									<div class="blank-portfolio-filters-container">
										<?php
											// Filters
											$this->render_filters();
										?>
									</div>
									
									<div class="blank-portfolio-container">
										<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
											<?php
												$filter = '';
												$filter_taxonomy = '';
												if( $settings['show_filters'] == 'yes' ) {
													$filter_taxonomy = $settings['filter_taxonomy'];
												}
												$count = 1;
												$query = $this->query_posts($filter, $filter_taxonomy);
												$total_pages = $query->max_num_pages;
												

												if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
								
													$this->render_post_body();
								
												$count++;

												endwhile; endif; wp_reset_postdata();
											?>
										</div>
										<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
										<div class="blank-portfolio-loader"></div>
										<?php } ?>
									</div>
								</div>
								<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
									<?php
										$this->render_pagination();
									?>
								</div>
								<?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
								?>
								<div class="blank-portfolio-wrap">
									<div class="blank-portfolio-filters-container">
										<?php
											// Filters
											$this->render_filters();
										?>
									</div>
									
									<div class="blank-portfolio-container">
										<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
											<?php
												$filter = '';
												$filter_taxonomy = '';
												if( $settings['show_filters'] == 'yes' ) {
													$filter_taxonomy = $settings['filter_taxonomy'];
												}
												$count = 1;
												$query = $this->query_posts($filter, $filter_taxonomy);
												$total_pages = $query->max_num_pages;
												

												if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
								
													$this->render_post_body();
								
												$count++;

												endwhile; endif; wp_reset_postdata();
											?>
										</div>
										<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
										<div class="blank-portfolio-loader"></div>
										<?php } ?>
									</div>
								</div>
								<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
									<?php
										$this->render_pagination();
									?>
								</div>
								<?php

                            }
                        }
                    break;
                    case 'role':
                        $user_meta = get_userdata(get_current_user_id());
						$user_roles=$user_meta->roles;
                        // Check if the role you're interested in, is present in the array.
						if($user_roles){
							if ( in_array( 'administrator', $user_roles, true ) ) {
								$user_role = 'administrator';
							}else if(in_array( 'editor', $user_roles, true )){
								$user_role = 'editor';
							}else if(in_array( 'author', $user_roles, true )){
								$user_role = 'author';
							}else if(in_array( 'contributor', $user_roles, true )){
								$user_role = 'contributor';
							}else if(in_array( 'subscriber', $user_roles, true )){
								$user_role = 'subscriber';
							}
						}

                        if($item['is_not']=='is'){
							if($item['user_role']==$user_role){
                               // show original here
							   ?>
								<div class="blank-portfolio-wrap">
									<div class="blank-portfolio-filters-container">
										<?php
											// Filters
											$this->render_filters();
										?>
									</div>
									
									<div class="blank-portfolio-container">
										<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
											<?php
												$filter = '';
												$filter_taxonomy = '';
												if( $settings['show_filters'] == 'yes' ) {
													$filter_taxonomy = $settings['filter_taxonomy'];
												}
												$count = 1;
												$query = $this->query_posts($filter, $filter_taxonomy);
												$total_pages = $query->max_num_pages;
												

												if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
								
													$this->render_post_body();
								
												$count++;

												endwhile; endif; wp_reset_postdata();
											?>
										</div>
										<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
										<div class="blank-portfolio-loader"></div>
										<?php } ?>
									</div>
								</div>
								<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
									<?php
										$this->render_pagination();
									?>
								</div>
								<?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
								?>
									<div class="blank-portfolio-wrap">
										<div class="blank-portfolio-filters-container">
											<?php
												// Filters
												$this->render_filters();
											?>
										</div>
										
										<div class="blank-portfolio-container">
											<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
												<?php
													$filter = '';
													$filter_taxonomy = '';
													if( $settings['show_filters'] == 'yes' ) {
														$filter_taxonomy = $settings['filter_taxonomy'];
													}
													$count = 1;
													$query = $this->query_posts($filter, $filter_taxonomy);
													$total_pages = $query->max_num_pages;
													
							
													if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
									
														$this->render_post_body();
									
													$count++;
							
													endwhile; endif; wp_reset_postdata();
												?>
											</div>
											<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
											<div class="blank-portfolio-loader"></div>
											<?php } ?>
										</div>
									</div>
									<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
										<?php
											$this->render_pagination();
										?>
									</div>
									<?php
                            }
                        }

                    break;
                    default:
                    echo $item['condition_key'].' condition need to set up';
                    break;
                }
            }
        }else{
            //show original here
			?>
				<div class="blank-portfolio-wrap">
					<div class="blank-portfolio-filters-container">
						<?php
							// Filters
							$this->render_filters();
						?>
					</div>
					
					<div class="blank-portfolio-container">
						<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
							<?php
								$filter = '';
								$filter_taxonomy = '';
								if( $settings['show_filters'] == 'yes' ) {
									$filter_taxonomy = $settings['filter_taxonomy'];
								}
								$count = 1;
								$query = $this->query_posts($filter, $filter_taxonomy);
								$total_pages = $query->max_num_pages;
								

								if ( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
				
									$this->render_post_body();
				
								$count++;

								endwhile; endif; wp_reset_postdata();
							?>
						</div>
						<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
						<div class="blank-portfolio-loader"></div>
						<?php } ?>
					</div>
				</div>
				<div class="blank-portfolio-pagination-wrap" data-total="<?php echo $total_pages; ?>">
					<?php
						$this->render_pagination();
					?>
				</div>
				<?php
             
		}
		//end
		
    }

	/*public function query_posts() {

	}*/

	/*protected function _register_controls() {
		parent::_register_controls();

		$this->register_query_section_controls();
		//$this->register_pagination_section_controls();
	}

	public function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->end_controls_section();
	}*/
}