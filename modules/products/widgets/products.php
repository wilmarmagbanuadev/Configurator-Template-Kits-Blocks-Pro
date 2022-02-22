<?php
namespace BlankElementsPro\Modules\Products\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Products Widget
 */
class Products extends Widget_Base {
    
    /**
	 * Retrieve dual heading widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-products';
    }

    /**
	 * Retrieve dual heading widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Woo - Products', 'blank-elements-pro' );
    }

    /**
	 * Retrieve the list of categories the dual heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'blank-elements-widgets'];
    }

    /**
	 * Retrieve dual heading widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-products';
    }

    /**
	 * Register dual heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Dual Heading
         */
        $this->start_controls_section(
            'section_products',
            [
                'label'                 => __( 'Settings', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_responsive_control(
            'columns',
            [    
                'label'                 => __( 'Columns', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '2',
                'mobile_default'        => '1',
                'options'               => [
                 '1' => '1',
                 '2' => '2',
                 '3' => '3',
                 '4' => '4',
                 '5' => '5',
                 '6' => '6',
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'limit_product',
            [
                'label'                 => __( 'Number of Products', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::NUMBER,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => __( '3', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
            'show_title',
            [
                'label'                 => __( 'Product Title', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_image',
            [
                'label'                 => __( 'Product Thumbnail', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'              => 'small_thumbs_size',
                'label'             => __( 'Thumbnail Size', 'blank-elements-pro' ),
                'default'           => 'medium',
                'condition'         => [
                    'show_image'  => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'show_category',
            [
                'label'                 => __( 'Product Category', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_sale_tag',
            [
                'label'                 => __( 'Product Sale Tag', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_price',
            [
                'label'                 => __( 'Product Price', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_rating',
            [
                'label'                 => __( 'Product Rating', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_button',
            [
                'label'                 => __( 'Add To Cart Button', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'pagination',
            [
                'label'                 => __( 'Pagination', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Layout
         */
        $this->start_controls_section(
            'layout_style',
            [
                'label'                 => __( 'Layout', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'columns_gap',
			[
				'label'                 => __( 'Columns Gap', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
                'default'               => [
                    'size' 	=> 30,
                ],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .blank-elementor-grid .blank-grid-item-wrap' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2)',
					'{{WRAPPER}} .blank-products .blank-elementor-grid' => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
				],
			]
		);
        
        $this->add_responsive_control(
			'rows_gap',
			[
				'label'                 => __( 'Rows Gap', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
                'default'               => [
                    'size' 	=> 30,
                ],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .blank-elementor-grid .blank-grid-item-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'products_bg_color',
            [
                'label'             => __( 'Background Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-products .blank-elementor-grid .blank-grid-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'products_border',
				'label'                 => __( 'Border', 'power-pack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-products .blank-elementor-grid .blank-grid-item',
			]
		);

		$this->add_control(
			'products_border_radius',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .blank-elementor-grid .blank-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'products_box_shadow',
				'selector'              => '{{WRAPPER}} .blank-products .blank-elementor-grid .blank-grid-item',
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'content_style',
            [
                'label'                 => __( 'Content', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_heading',
            [
                'label'                 => __( 'Image', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'show_image'   => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'image_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
                'default'               => [
                    'size' => 20,
                    'unit' => 'px',
                ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .prod-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_image'   => 'yes',
				],
			]
		);

        $this->add_control(
            'category_heading',
            [
                'label'                 => __( 'Category', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'show_category'     => 'yes',
				],
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .blank-woo-product-category' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_category'     => 'yes',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'category_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-products .blank-woo-product-category',
				'condition'             => [
					'show_category'     => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'category_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
                'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .blank-woo-product-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_category'     => 'yes',
				],
			]
		);

        $this->add_control(
            'title_heading',
            [
                'label'                 => __( 'Title', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'show_title'   => 'yes',
				],
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#111',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_title'   => 'yes',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-products .woocommerce-loop-product__title',
				'condition'             => [
					'show_title'   => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'title_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
                'default'               => [
                    'size' => 0,
                    'unit' => 'px',
                ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_title'   => 'yes',
				],
			]
		);

        $this->add_control(
            'rating_heading',
            [
                'label'                 => __( 'Rating', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'show_rating'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .star-rating, {{WRAPPER}} .blank-products .star-rating span:before' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_rating'  => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'rating_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
                'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_rating'  => 'yes',
				],
			]
		);

        $this->add_control(
            'price_heading',
            [
                'label'                 => __( 'Price', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'show_price'     => 'yes',
				],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#111111',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .product .price' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_price'   => 'yes',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'price_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-products .product .price',
				'condition'             => [
					'show_price'   => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'price_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
                'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .products .product .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_price'   => 'yes',
				],
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Add to Cart
         */
        $this->start_controls_section(
            'add_to_cart_style',
            [
                'label'                 => __( 'Add to Cart', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
            'button_width',
            [
                'label'                 => __( 'Width', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 200,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .product .button' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'show_button'  => 'yes',
                ],
            ]
        );
        
        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'             => __( 'Normal', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'add_to_cart_text_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .product .button' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'add_to_cart_bg',
                'label'                 => __( 'Background', 'blank-elements-pro' ),
                'types'                 => [ 'classic','gradient' ],
                'selector'              => '{{WRAPPER}} .blank-products .product .button',
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'add_to_cart_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-products .product .button',
				'condition'             => [
					'show_title'   => 'yes',
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'add_to_cart_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-products .product .button',
				'condition'             => [
					'show_button'  => 'yes',
				],
			]
		);

		$this->add_control(
			'add_to_cart_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .product .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'show_button'  => 'yes',
				],
			]
		);

		$this->add_control(
			'add_to_cart_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-products .product .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'show_button'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'add_to_cart_box_shadow',
				'selector'              => '{{WRAPPER}} .blank-products .product .button',
				'condition'             => [
					'show_button'  => 'yes',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'             => __( 'Hover', 'blank-elements-pro' ),
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'add_to_cart_text_color_hover',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .product .button:hover' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'add_to_cart_bg_hover',
                'label'                 => __( 'Background', 'blank-elements-pro' ),
                'types'                 => [ 'classic','gradient' ],
                'selector'              => '{{WRAPPER}} .blank-products .product .button:hover',
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'add_to_cart_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-products .product .button:hover' => 'border-color: {{VALUE}};',
                ],
				'condition'             => [
					'show_button'  => 'yes',
				],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->end_controls_section();

    }
    // first create a function 
    protected function pagainate_link_function(){
        global $wp_query;
        echo paginate_links(array(
            'current'=>max(1,get_query_var('paged')),
            'total'=>$wp_query->max_num_pages,
            'type'=>'list', //default it will return anchor
        ));
    }

    /**
	 * Render dual heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'products', 'class', ['blank-products', 'woocommerce'] );
        
        /*if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'dual-heading-link', 'href', $settings['link']['url'] );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'dual-heading-link', 'target', '_blank' );
            }

            if ( $settings['link']['nofollow'] ) {
                $this->add_render_attribute( 'dual-heading-link', 'rel', 'nofollow' );
            }
        }
        
        printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
            if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
            foreach ( $settings['headings'] as $part ) {
                //print_r( $part );
                ?>
                <span class="elementor-repeater-item-<?php echo $part['_id']; ?>">
                    <?php echo $part['heading']; ?>
                </span>
                <?php
            }
            if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
        printf( '</%1$s>', $settings['heading_html_tag'] );*/
        $paged = '';
        
        if ( 'yes' == $settings['pagination'] ) {
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
        }
        
        $args = array(
            'post_type'	=> 'product',
            'post_status' => 'publish',
            'posts_per_page'  => $settings['limit_product'],
            'ignore_sticky_posts'	=> 1,
            'paged'                 => $paged,
        );

        $products = new \WP_Query( $args );

        //$woocommerce_loop['columns'] = $columns;
        if ( $products->have_posts() ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                <div class="products blank-elementor-grid">

                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    <?php

                        global $post, $product;

                        // Ensure visibility.
                        if ( empty( $product ) || ! $product->is_visible() ) {
                            return;
                        }
                        ?>
                        <div <?php wc_product_class('blank-grid-item-wrap'); ?>>
                            <div class="blank-product blank-grid-item">
                            <?php
                            /**
                             * Hook: woocommerce_before_shop_loop_item.
                             *
                             * @hooked woocommerce_template_loop_product_link_open - 10
                             */
                            //do_action( 'woocommerce_before_shop_loop_item' );
                            
                            // Sale tag
                            if ( $settings['show_sale_tag'] == 'yes' ) {
                                if ( $product->is_on_sale() ) :

                                    echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
                                endif;
                            }
                            
                            // Woocommerce thumbnail
                            if ( $settings['show_image'] == 'yes' ) {
                                ?>
                                <div class="prod-img">
                                    <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                        <?php

                                            echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                        ?>
                                    </a>
                                    <div class="product-overlay">
                                        <?php 
                                            // Add To cart Button
                                            if ( $settings['show_button'] == 'yes' ) {
                                                if ( $product ) {
                                                    $defaults = array(
                                                        'quantity'   => 1,
                                                        'class'      => implode( ' ', array_filter( array(
                                                            'button',
                                                            'product_type_' . $product->get_type(),
                                                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                            $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                                        ) ) ),
                                                        'attributes' => array(
                                                            'data-product_id'  => $product->get_id(),
                                                            'data-product_sku' => $product->get_sku(),
                                                            'aria-label'       => $product->add_to_cart_description(),
                                                            'rel'              => 'nofollow',
                                                        ),
                                                    );

                                                    $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

                                                    if ( isset( $args['attributes']['aria-label'] ) ) {
                                                        $args['attributes']['aria-label'] = strip_tags( $args['attributes']['aria-label'] );
                                                    }
                                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                                                        sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s %s</a>',
                                                            esc_url( $product->add_to_cart_url() ),
                                                            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                            '<span class="flaticon flaticon-shopping-basket"></span>',
                                                            esc_html( $product->add_to_cart_text() )
                                                        ),
                                                    $product, $args );
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            
                            // Product Categories
                            if ( $settings['show_category'] == 'yes' ) {
                                ?>
                                <div class="blank-woo-product-category prod-cat">
                                    <?php
                                        echo wc_get_product_category_list($product->get_id());
                                    ?>
                                </div>
                                <?php
                            }
                            
                            // Product Title
                            if ( $settings['show_title'] == 'yes' ) { ?>
                                <h2 class="woocommerce-loop-product__title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </h2>
                            <?php
                            }
        
                            // Product Rating 
                            if ( $settings['show_rating'] == 'yes' ) {
                                echo wc_get_rating_html( $product->get_average_rating() );
                            }
                            
                            // Product Price
                            if ( $settings['show_price'] == 'yes' ) {
                                if ( $price_html = $product->get_price_html() ) : ?>
                                    <div class="price"><?php echo $price_html; ?></div>
                                <?php endif;
                            }
                            
                            ?>
                            </div>
                        </div>
                    <?php endwhile; // end of the loop. ?>

                </div>
                <?php if ( 'yes' == $settings['pagination'] ) { ?>
                    <div class="blank-product-pagination">
                        <?php 
                            echo paginate_links(array(
                                'current'=>max(1,get_query_var('paged')),
                                'total'=>$products->max_num_pages,
                                'prev_text'=>'<i class="fas fa-angle-left"></i>',
                                'next_text'=>'<i class="fas fa-angle-right"></i>'
                            ));
                        ?>
                    </div>
                <?php } ?>
            </div>
        <?php endif; 
        wp_reset_query();
        
        //echo do_shortcode('[products]');
    }
    
    /**
	 * Render dual heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {
    }
}