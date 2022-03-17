<?php
namespace BlankElementsPro\Modules\ProductSlider\Widgets;

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
class Product_Slider extends Widget_Base {
    
    /**
	 * Retrieve dual heading widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-product-slider';
    }

    /**
	 * Retrieve dual heading widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Woo - Products Slider', 'blank-elements' );
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
        return [ 'configurator-template-kits-blocks-pro-widgets'];
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
	
	public function get_script_depends() {
        return [
            'blank-slick',
            'blank-js'
        ];
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
                'label'                 => __( 'Settings', 'blank-elements' ),
            ]
        );

        $this->add_control(
            'limit_product',
            [
                'label'                 => __( 'Number of Products', 'blank-elements' ),
                'type'                  => Controls_Manager::NUMBER,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => __( '4', 'blank-elements' ),
            ]
        );
        
        $this->add_control(
            'show_title',
            [
                'label'                 => __( 'Product Title', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_image',
            [
                'label'                 => __( 'Product Thumbnail', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'              => 'small_thumbs_size',
                'label'             => __( 'Thumbnail Size', 'blank-elements' ),
                'default'           => 'medium',
                'condition'         => [
                    'show_image'  => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'show_price',
            [
                'label'                 => __( 'Product Price', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'show_excerpt',
            [
                'label'                 => __( 'Excerpt', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'excerpt_length',
            [
                'label'             => __( 'Excerpt Length', 'ep-addons' ),
                'type'              => Controls_Manager::NUMBER,
                'default'           => 20,
                'min'               => 0,
                'max'               => 58,
                'step'              => 1,
                'condition'         => [
                    'show_excerpt'  => 'yes'
                ]
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
                'label'                 => __( 'Layout', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'columns_gap',
			[
				'label'                 => __( 'Columns Gap', 'blank-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .be-products .be-elementor-grid .be-grid-item-wrap' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}} .be-products .be-elementor-grid' => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
				],
			]
		);
        
        $this->add_responsive_control(
			'rows_gap',
			[
				'label'                 => __( 'Rows Gap', 'blank-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .be-products .be-elementor-grid .be-grid-item-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'products_bg_color',
            [
                'label'             => __( 'Background Color', 'blank-elements' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .be-products .be-product-info' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'products_box_shadow',
				'selector'              => '{{WRAPPER}} .be-products .be-product-info',
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'content_style',
            [
                'label'                 => __( 'Content', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'content_padding',
            [
                'label'                 => __( 'Padding', 'blank-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', 'em', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .be-product-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'cat_heading',
            [
                'label'                 => __( 'Category', 'blank-elements' ),
                'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
            ]
        );

        $this->add_control(
            'cat_text_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-product-category a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'cat_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-product-category a',
            ]
        );
        
        $this->add_responsive_control(
			'cat_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements' ),
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
					'{{WRAPPER}} .be-product-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'title_heading',
            [
                'label'                 => __( 'Title', 'blank-elements' ),
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
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-products .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_title'   => 'yes',
				],
            ]
        );
		
		$this->add_control(
            'title_text_hover_color',
            [
                'label'                 => __( 'Hover Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-products .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}};',
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
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-products .woocommerce-loop-product__title',
				'condition'             => [
					'show_title'   => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'title_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements' ),
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
					'{{WRAPPER}} .be-products .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_title'   => 'yes',
				],
			]
		);

        $this->add_control(
            'price_heading',
            [
                'label'                 => __( 'Price', 'blank-elements' ),
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
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-products .product .price' => 'color: {{VALUE}};',
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
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-products .product .price',
				'condition'             => [
					'show_price'   => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'price_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements' ),
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
					'{{WRAPPER}} .be-products .products .product .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_price'   => 'yes',
				],
			]
		);
        
        $this->add_control(
            'desc_heading',
            [
                'label'                 => __( 'Description', 'blank-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
				'condition'             => [
					'show_excerpt'   => 'yes',
				],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-product-desc' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'show_excerpt'   => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
			'desc_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements' ),
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
					'{{WRAPPER}} .be-product-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_excerpt'   => 'yes',
				],
			]
		);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'desc_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-product-desc',
				'condition'             => [
					'show_excerpt'   => 'yes',
				],
            ]
        );

        $this->add_control(
            'button_heading',
            [
                'label'                 => __( 'Button', 'blank-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'                 => __( 'Background Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-view-more' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-view-more' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-view-more',
            ]
        );
        
        $this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'blank-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .be-view-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
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

    /**
	 * Render dual heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'products', 'class', ['be-products', 'woocommerce','blank-product-slider'] );
        
        $args = array(
            'post_type'	=> 'product',
            'post_status' => 'publish',
            'posts_per_page'  => $settings['limit_product'],
            'ignore_sticky_posts'	=> 1,
        );

        $products = new \WP_Query( $args );
        // wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
                          if ( $products->have_posts() ) : ?>
                            <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                                <div class="products">
                
                                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php
                
                                        global $post, $product;
                
                                        // Ensure visibility.
                                        if ( empty( $product ) || ! $product->is_visible() ) {
                                            return;
                                        }
                                        ?>
                                        <div <?php wc_product_class(); ?>>
                                            <div class="be-grid-item">
                                                <div class="be-product">
                                                    
                                                    <div class="be-product-info">
                                                        <?php
                                                        echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
                        
                                                        // Product Title
                                                        if ( $settings['show_title'] == 'yes' ) {
                                                            echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                                        }
                                                        
                                                        // Product Price
                                                        if ( $settings['show_price'] == 'yes' ) {
                                                            if ( $price_html = $product->get_price_html() ) : ?>
                                                                <span class="price"><?php echo $price_html; ?></span>
                                                            <?php endif;
                                                        } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                                        <div class="be-product-desc">
                                                            <?php 
                                                                $limit = $settings['excerpt_length'];
                                                                $excerpt = explode(' ', get_the_excerpt(), $limit);
                
                                                                if ( count( $excerpt ) >= $limit ) {
                                                                    array_pop( $excerpt );
                                                                    $excerpt = implode( " ", $excerpt ).'...';
                                                                } else {
                                                                    $excerpt = implode( " ", $excerpt );
                                                                }
                
                                                                $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                                echo $excerpt;
                                                            ?>
                                                        </div>
                                                        <?php }
                                                        /*// Add To cart Button
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
                                                                    sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                                        esc_url( $product->add_to_cart_url() ),
                                                                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                                        esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                                        esc_html( $product->add_to_cart_text() )
                                                                    ),
                                                                $product, $args );
                                                            }
                                                        }*/
                                                        ?>
                                                        <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                                    </div>
                                                    <?php
                                                    /**
                                                     * Hook: woocommerce_before_shop_loop_item.
                                                     *
                                                     * @hooked woocommerce_template_loop_product_link_open - 10
                                                     */
                                                    //do_action( 'woocommerce_before_shop_loop_item' );
                                                    
                                                    
                                                    // Woocommerce thumbnail
                                                    if ( $settings['show_image'] == 'yes' ) {
                                                        ?>
                                                        <div class="be-product-img">
                                                            <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                                <?php
                
                                                                    echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                                ?>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; // end of the loop. ?>
                
                                </div>
                            </div>
                
                        <?php endif;
                        }elseif($item['is_not']=='is_not'  && !is_user_logged_in()){
                           // show original here
                           if ( $products->have_posts() ) : ?>
                            <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                                <div class="products">
                
                                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                    <?php
                
                                        global $post, $product;
                
                                        // Ensure visibility.
                                        if ( empty( $product ) || ! $product->is_visible() ) {
                                            return;
                                        }
                                        ?>
                                        <div <?php wc_product_class(); ?>>
                                            <div class="be-grid-item">
                                                <div class="be-product">
                                                    
                                                    <div class="be-product-info">
                                                        <?php
                                                        echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
                        
                                                        // Product Title
                                                        if ( $settings['show_title'] == 'yes' ) {
                                                            echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                                        }
                                                        
                                                        // Product Price
                                                        if ( $settings['show_price'] == 'yes' ) {
                                                            if ( $price_html = $product->get_price_html() ) : ?>
                                                                <span class="price"><?php echo $price_html; ?></span>
                                                            <?php endif;
                                                        } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                                        <div class="be-product-desc">
                                                            <?php 
                                                                $limit = $settings['excerpt_length'];
                                                                $excerpt = explode(' ', get_the_excerpt(), $limit);
                
                                                                if ( count( $excerpt ) >= $limit ) {
                                                                    array_pop( $excerpt );
                                                                    $excerpt = implode( " ", $excerpt ).'...';
                                                                } else {
                                                                    $excerpt = implode( " ", $excerpt );
                                                                }
                
                                                                $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                                echo $excerpt;
                                                            ?>
                                                        </div>
                                                        <?php }
                                                        /*// Add To cart Button
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
                                                                    sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                                        esc_url( $product->add_to_cart_url() ),
                                                                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                                        esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                                        esc_html( $product->add_to_cart_text() )
                                                                    ),
                                                                $product, $args );
                                                            }
                                                        }*/
                                                        ?>
                                                        <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                                    </div>
                                                    <?php
                                                    /**
                                                     * Hook: woocommerce_before_shop_loop_item.
                                                     *
                                                     * @hooked woocommerce_template_loop_product_link_open - 10
                                                     */
                                                    //do_action( 'woocommerce_before_shop_loop_item' );
                                                    
                                                    
                                                    // Woocommerce thumbnail
                                                    if ( $settings['show_image'] == 'yes' ) {
                                                        ?>
                                                        <div class="be-product-img">
                                                            <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                                <?php
                
                                                                    echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                                ?>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; // end of the loop. ?>
                
                                </div>
                            </div>
                
                        <?php endif;
                        }
                    break;
                    case 'user':
                        global $current_user;
                        wp_get_current_user();
                        $current_user = $current_user->user_login;
                        if($item['is_not']=='is'){
                            if($current_user==$item['current_user']){
                               // show original here
                               if ( $products->have_posts() ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                                    <div class="products">
                    
                                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                        <?php
                    
                                            global $post, $product;
                    
                                            // Ensure visibility.
                                            if ( empty( $product ) || ! $product->is_visible() ) {
                                                return;
                                            }
                                            ?>
                                            <div <?php wc_product_class(); ?>>
                                                <div class="be-grid-item">
                                                    <div class="be-product">
                                                        
                                                        <div class="be-product-info">
                                                            <?php
                                                            echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
                            
                                                            // Product Title
                                                            if ( $settings['show_title'] == 'yes' ) {
                                                                echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                                            }
                                                            
                                                            // Product Price
                                                            if ( $settings['show_price'] == 'yes' ) {
                                                                if ( $price_html = $product->get_price_html() ) : ?>
                                                                    <span class="price"><?php echo $price_html; ?></span>
                                                                <?php endif;
                                                            } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                                            <div class="be-product-desc">
                                                                <?php 
                                                                    $limit = $settings['excerpt_length'];
                                                                    $excerpt = explode(' ', get_the_excerpt(), $limit);
                    
                                                                    if ( count( $excerpt ) >= $limit ) {
                                                                        array_pop( $excerpt );
                                                                        $excerpt = implode( " ", $excerpt ).'...';
                                                                    } else {
                                                                        $excerpt = implode( " ", $excerpt );
                                                                    }
                    
                                                                    $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                                    echo $excerpt;
                                                                ?>
                                                            </div>
                                                            <?php }
                                                            /*// Add To cart Button
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
                                                                        sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                                            esc_url( $product->add_to_cart_url() ),
                                                                            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                                            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                                            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                                            esc_html( $product->add_to_cart_text() )
                                                                        ),
                                                                    $product, $args );
                                                                }
                                                            }*/
                                                            ?>
                                                            <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                                        </div>
                                                        <?php
                                                        /**
                                                         * Hook: woocommerce_before_shop_loop_item.
                                                         *
                                                         * @hooked woocommerce_template_loop_product_link_open - 10
                                                         */
                                                        //do_action( 'woocommerce_before_shop_loop_item' );
                                                        
                                                        
                                                        // Woocommerce thumbnail
                                                        if ( $settings['show_image'] == 'yes' ) {
                                                            ?>
                                                            <div class="be-product-img">
                                                                <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                                    <?php
                    
                                                                        echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                                    ?>
                                                                </a>
                                                            </div>
                                                            <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; // end of the loop. ?>
                    
                                    </div>
                                </div>
                    
                            <?php endif;
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
                                if ( $products->have_posts() ) : ?>
                                    <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                                        <div class="products">
                        
                                            <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                            <?php
                        
                                                global $post, $product;
                        
                                                // Ensure visibility.
                                                if ( empty( $product ) || ! $product->is_visible() ) {
                                                    return;
                                                }
                                                ?>
                                                <div <?php wc_product_class(); ?>>
                                                    <div class="be-grid-item">
                                                        <div class="be-product">
                                                            
                                                            <div class="be-product-info">
                                                                <?php
                                                                echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
                                
                                                                // Product Title
                                                                if ( $settings['show_title'] == 'yes' ) {
                                                                    echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                                                }
                                                                
                                                                // Product Price
                                                                if ( $settings['show_price'] == 'yes' ) {
                                                                    if ( $price_html = $product->get_price_html() ) : ?>
                                                                        <span class="price"><?php echo $price_html; ?></span>
                                                                    <?php endif;
                                                                } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                                                <div class="be-product-desc">
                                                                    <?php 
                                                                        $limit = $settings['excerpt_length'];
                                                                        $excerpt = explode(' ', get_the_excerpt(), $limit);
                        
                                                                        if ( count( $excerpt ) >= $limit ) {
                                                                            array_pop( $excerpt );
                                                                            $excerpt = implode( " ", $excerpt ).'...';
                                                                        } else {
                                                                            $excerpt = implode( " ", $excerpt );
                                                                        }
                        
                                                                        $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                                        echo $excerpt;
                                                                    ?>
                                                                </div>
                                                                <?php }
                                                                /*// Add To cart Button
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
                                                                            sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                                                esc_url( $product->add_to_cart_url() ),
                                                                                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                                                esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                                                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                                                esc_html( $product->add_to_cart_text() )
                                                                            ),
                                                                        $product, $args );
                                                                    }
                                                                }*/
                                                                ?>
                                                                <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                                            </div>
                                                            <?php
                                                            /**
                                                             * Hook: woocommerce_before_shop_loop_item.
                                                             *
                                                             * @hooked woocommerce_template_loop_product_link_open - 10
                                                             */
                                                            //do_action( 'woocommerce_before_shop_loop_item' );
                                                            
                                                            
                                                            // Woocommerce thumbnail
                                                            if ( $settings['show_image'] == 'yes' ) {
                                                                ?>
                                                                <div class="be-product-img">
                                                                    <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                                        <?php
                        
                                                                            echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                                        ?>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; // end of the loop. ?>
                        
                                        </div>
                                    </div>
                        
                                <?php endif;

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
                               if ( $products->have_posts() ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                                    <div class="products">
                    
                                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                        <?php
                    
                                            global $post, $product;
                    
                                            // Ensure visibility.
                                            if ( empty( $product ) || ! $product->is_visible() ) {
                                                return;
                                            }
                                            ?>
                                            <div <?php wc_product_class(); ?>>
                                                <div class="be-grid-item">
                                                    <div class="be-product">
                                                        
                                                        <div class="be-product-info">
                                                            <?php
                                                            echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
                            
                                                            // Product Title
                                                            if ( $settings['show_title'] == 'yes' ) {
                                                                echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                                            }
                                                            
                                                            // Product Price
                                                            if ( $settings['show_price'] == 'yes' ) {
                                                                if ( $price_html = $product->get_price_html() ) : ?>
                                                                    <span class="price"><?php echo $price_html; ?></span>
                                                                <?php endif;
                                                            } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                                            <div class="be-product-desc">
                                                                <?php 
                                                                    $limit = $settings['excerpt_length'];
                                                                    $excerpt = explode(' ', get_the_excerpt(), $limit);
                    
                                                                    if ( count( $excerpt ) >= $limit ) {
                                                                        array_pop( $excerpt );
                                                                        $excerpt = implode( " ", $excerpt ).'...';
                                                                    } else {
                                                                        $excerpt = implode( " ", $excerpt );
                                                                    }
                    
                                                                    $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                                    echo $excerpt;
                                                                ?>
                                                            </div>
                                                            <?php }
                                                            /*// Add To cart Button
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
                                                                        sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                                            esc_url( $product->add_to_cart_url() ),
                                                                            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                                            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                                            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                                            esc_html( $product->add_to_cart_text() )
                                                                        ),
                                                                    $product, $args );
                                                                }
                                                            }*/
                                                            ?>
                                                            <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                                        </div>
                                                        <?php
                                                        /**
                                                         * Hook: woocommerce_before_shop_loop_item.
                                                         *
                                                         * @hooked woocommerce_template_loop_product_link_open - 10
                                                         */
                                                        //do_action( 'woocommerce_before_shop_loop_item' );
                                                        
                                                        
                                                        // Woocommerce thumbnail
                                                        if ( $settings['show_image'] == 'yes' ) {
                                                            ?>
                                                            <div class="be-product-img">
                                                                <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                                    <?php
                    
                                                                        echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                                    ?>
                                                                </a>
                                                            </div>
                                                            <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; // end of the loop. ?>
                    
                                    </div>
                                </div>
                    
                            <?php endif;
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
                                if ( $products->have_posts() ) : ?>
                                    <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                                        <div class="products">
                        
                                            <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                            <?php
                        
                                                global $post, $product;
                        
                                                // Ensure visibility.
                                                if ( empty( $product ) || ! $product->is_visible() ) {
                                                    return;
                                                }
                                                ?>
                                                <div <?php wc_product_class(); ?>>
                                                    <div class="be-grid-item">
                                                        <div class="be-product">
                                                            
                                                            <div class="be-product-info">
                                                                <?php
                                                                echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
                                
                                                                // Product Title
                                                                if ( $settings['show_title'] == 'yes' ) {
                                                                    echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                                                }
                                                                
                                                                // Product Price
                                                                if ( $settings['show_price'] == 'yes' ) {
                                                                    if ( $price_html = $product->get_price_html() ) : ?>
                                                                        <span class="price"><?php echo $price_html; ?></span>
                                                                    <?php endif;
                                                                } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                                                <div class="be-product-desc">
                                                                    <?php 
                                                                        $limit = $settings['excerpt_length'];
                                                                        $excerpt = explode(' ', get_the_excerpt(), $limit);
                        
                                                                        if ( count( $excerpt ) >= $limit ) {
                                                                            array_pop( $excerpt );
                                                                            $excerpt = implode( " ", $excerpt ).'...';
                                                                        } else {
                                                                            $excerpt = implode( " ", $excerpt );
                                                                        }
                        
                                                                        $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                                        echo $excerpt;
                                                                    ?>
                                                                </div>
                                                                <?php }
                                                                /*// Add To cart Button
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
                                                                            sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                                                esc_url( $product->add_to_cart_url() ),
                                                                                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                                                esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                                                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                                                esc_html( $product->add_to_cart_text() )
                                                                            ),
                                                                        $product, $args );
                                                                    }
                                                                }*/
                                                                ?>
                                                                <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                                            </div>
                                                            <?php
                                                            /**
                                                             * Hook: woocommerce_before_shop_loop_item.
                                                             *
                                                             * @hooked woocommerce_template_loop_product_link_open - 10
                                                             */
                                                            //do_action( 'woocommerce_before_shop_loop_item' );
                                                            
                                                            
                                                            // Woocommerce thumbnail
                                                            if ( $settings['show_image'] == 'yes' ) {
                                                                ?>
                                                                <div class="be-product-img">
                                                                    <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                                        <?php
                        
                                                                            echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                                        ?>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; // end of the loop. ?>
                        
                                        </div>
                                    </div>
                        
                                <?php endif;
                                   
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
            if ( $products->have_posts() ) : ?>
                <div <?php echo $this->get_render_attribute_string( 'products' ); ?>>
                    <div class="products">
    
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                        <?php
    
                            global $post, $product;
    
                            // Ensure visibility.
                            if ( empty( $product ) || ! $product->is_visible() ) {
                                return;
                            }
                            ?>
                            <div <?php wc_product_class(); ?>>
                                <div class="be-grid-item">
                                    <div class="be-product">
                                        
                                        <div class="be-product-info">
                                            <?php
                                            echo '<div class="be-product-category">' .wc_get_product_category_list($product->get_id()) .'</div>';
            
                                            // Product Title
                                            if ( $settings['show_title'] == 'yes' ) {
                                                echo '<h2 class="woocommerce-loop-product__title"><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';
                                            }
                                            
                                            // Product Price
                                            if ( $settings['show_price'] == 'yes' ) {
                                                if ( $price_html = $product->get_price_html() ) : ?>
                                                    <span class="price"><?php echo $price_html; ?></span>
                                                <?php endif;
                                            } if ( $settings['show_excerpt'] == 'yes' ) { ?>
                                            <div class="be-product-desc">
                                                <?php 
                                                    $limit = $settings['excerpt_length'];
                                                    $excerpt = explode(' ', get_the_excerpt(), $limit);
    
                                                    if ( count( $excerpt ) >= $limit ) {
                                                        array_pop( $excerpt );
                                                        $excerpt = implode( " ", $excerpt ).'...';
                                                    } else {
                                                        $excerpt = implode( " ", $excerpt );
                                                    }
    
                                                    $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt ); 
                                                    echo $excerpt;
                                                ?>
                                            </div>
                                            <?php }
                                            /*// Add To cart Button
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
                                                        sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                            esc_url( $product->add_to_cart_url() ),
                                                            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                                                            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                            esc_html( $product->add_to_cart_text() )
                                                        ),
                                                    $product, $args );
                                                }
                                            }*/
                                            ?>
                                            <a href="<?php the_permalink(); ?>" class="be-view-more be-product-view-more"><?php esc_html_e('Shop Now','blank-elements'); ?></a>
                                        </div>
                                        <?php
                                        /**
                                         * Hook: woocommerce_before_shop_loop_item.
                                         *
                                         * @hooked woocommerce_template_loop_product_link_open - 10
                                         */
                                        //do_action( 'woocommerce_before_shop_loop_item' );
                                        
                                        
                                        // Woocommerce thumbnail
                                        if ( $settings['show_image'] == 'yes' ) {
                                            ?>
                                            <div class="be-product-img">
                                                <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                    <?php
    
                                                        echo $product ? $product->get_image( $settings['small_thumbs_size_size'] ) : '';
                                                    ?>
                                                </a>
                                            </div>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; // end of the loop. ?>
    
                    </div>
                </div>
    
            <?php endif;
             
		}
        //end
        //$woocommerce_loop['columns'] = $columns;
         
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