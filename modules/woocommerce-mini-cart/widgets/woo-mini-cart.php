<?php
/**
 * Blank WooCommerce Cart widget.
 *
 * @package Blank
 */

namespace BlankElementsPro\Modules\WoocommerceMiniCart\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Woo_Mini_Cart.
 */
class Woo_Mini_Cart extends Widget_Base {

	/**
	 * Retrieve toggle widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'blank-woo-mini-cart';
	}

	/**
	 * Retrieve toggle widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Woo - Mini Cart', 'blank-elements-pro' );
	}

    /**
	 * Retrieve the list of categories the toggle widget belongs to.
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
	 * Retrieve toggle widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-cart';
	}
    
    /**
	 * Retrieve the list of scripts the toggle widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
    public function get_script_depends() {
        return [
            'blank-mini-cart-js',
            'blank-js'
        ];
    }

	/**
	 * Register controls.
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		/* General Settings */
		$this->register_content_general_controls();

		/* Button Settings */
		$this->register_content_button_controls();
		
		/* Style Tab: Cross Sells */
		$this->register_style_cart_button_controls();

		/* Style Tab: Counter */
		$this->register_style_counter_controls();

		/* Style Tab: Items Container */
		$this->register_style_items_container_controls();

		/* Style Tab: Item */
		$this->register_style_items_controls();
		
		/* Style Tab: Checkout Button */
		$this->register_style_buttons_controls();

		/**
		 *Adnvance Rule Tab
		 */
		$this->register_advance_rule_control();
	}

	/**
	 * Register toggle widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_content_general_controls() {

		$this->start_controls_section(
			'section_settings',
			[
				'label'                 => __( 'General', 'blank-elements-pro' ),
				'tab'                   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_cart_on',
			[
				'label'                 => __( 'Show Cart on', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'on-click',
				'options'               => [
					'on-click'		=> __( 'Click', 'blank-elements-pro' ),
					'on-hover'		=> __( 'Hover', 'blank-elements-pro' ),
					'none'			=> __( 'None', 'blank-elements-pro' ),
				],
			]
		);

		$this->add_control(
			'cart_title',
			[
				'label'					=> __( 'Cart Title', 'blank-elements-pro' ),
				'description'			=> __( 'Cart title is displayed on top of mini cart.', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => '',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_message',
			[
				'label'					=> __( 'Cart Message', 'blank-elements-pro' ),
				'description'			=> __( 'Cart message is displayed on bottom of mini cart.', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::TEXTAREA,
				'default'               => '',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);
        
        $this->add_control(
			'cart_align',
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
				'default'				=> 'right',
				'selectors'			=> [
					'{{WRAPPER}} .blank-woo-cart-button' => 'text-align: {{VALUE}};',
				],
			]
		);
        
		$this->end_controls_section();
	}

	/**
	 * Register toggle widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_content_button_controls() {

		$this->start_controls_section(
			'section_button_settings',
			[
				'label'                 => __( 'Button', 'blank-elements-pro' ),
				'tab'                   => Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'show_subtotal',
			[
				'label'					=> __( 'Subtotal', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'label_on'				=> __( 'Show', 'blank-elements-pro' ),
				'label_off'				=> __( 'Hide', 'blank-elements-pro' ),
				'return_value'			=> 'yes',
				'default'				=> 'yes',
			]
		);

		$this->add_control(
			'counter_position',
			[
				'label'                 => __( 'Counter Position', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'after',
				'options'               => [
					'before' => __( 'Before Button', 'blank-elements-pro' ),
					'after'  => __( 'After Button', 'blank-elements-pro' ),
					'top'    => __( 'Bubble', 'blank-elements-pro' ),
				],
			]
		);

		$this->add_control(
			'icon_style',
			[
				'label'                 => __( 'Style', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'text',
				'options'               => [
					'icon'      => __( 'Icon only', 'blank-elements-pro' ),
					'icon_text' => __( 'Icon + Text', 'blank-elements-pro' ),
					'text'      => __( 'Text only', 'blank-elements-pro' ),
				],
			]
		);

		$this->add_control(
			'cart_text',
			[
				'label'                 => __( 'Text', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => __( 'Cart', 'blank-elements-pro' ),
				'condition'             => [
					'icon_style' => ['icon_text', 'text'],
				],
			]
		);
        
        $this->add_control(
			'icon_type',
			[
				'label'                 => esc_html__( 'Icon Type', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'       => false,
				'toggle'       => false,
				'options'               => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'blank-elements-pro' ),
						'icon' => 'fa fa-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'blank-elements-pro' ),
						'icon' => 'fa fa-picture-o',
					],
				],
				'default'               => 'icon',
				'condition'             => [
					'icon_style' => ['icon_text', 'icon'],
				],
			]
		);

        $this->add_control(
            'icon',
            [
                'label'                 => __( 'Icon', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::ICON,
                'default'               => 'fa fa-shopping-cart',
                'condition'             => [
					'icon_style' => ['icon_text', 'icon'],
                    'icon_type'     => 'icon',
                ],
            ]
        );

		$this->add_control(
			'icon_image',
			[
				'label'                 => __( 'Image Icon', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::MEDIA,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => [
					'url' => Utils::get_placeholder_image_src(),
				],
                'condition'             => [
					'icon_style' => ['icon_text', 'icon'],
                    'icon_type' => 'image',
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'					=> 'icon_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'				=> 'full',
				'separator'				=> 'none',
                'condition'             => [
                    'icon_type' => 'image',
                ],
			]
		);
        
		$this->end_controls_section();
	}

	/**
	 * Style Tab
	 */
	/**
	 * Register Layout Controls.
	 *
	 * @access protected
	 */
	
	/**
	 * Style Tab: Counter
	 * -------------------------------------------------
	 */
	protected function register_style_counter_controls() {
		$this->start_controls_section(
			'section_subtotal_style',
			[
				'label'                 => __( 'Subtotal', 'blank-elements-pro' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->add_control(
			'subtotal_text_color',
			[
				'label'                 => __( 'Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-cart-subtotal' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'					=> 'subtotal_typography',
				'label'					=> __( 'Typography', 'blank-elements-pro' ),
				'selector'				=> '{{WRAPPER}} .blank-cart-subtotal',
				'condition'             => [
					'show_subtotal'     => 'yes',
				],
			]
		);
        
		$this->add_responsive_control(
			'subtotal_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '20',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-cart-subtotal' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_subtotal' => 'yes',
				],
			]
		);
        
		$this->end_controls_section();
	}
	
	/**
	 * Style Tab: Cart Table
	 * -------------------------------------------------
	 */
	protected function register_style_items_container_controls() {
		$this->start_controls_section(
			'section_items_container_style',
			[
				'label'                 => __( 'Items Container', 'blank-elements-pro' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'items_container_background',
				'types'                 => [ 'classic', 'gradient' ],
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .blank-woo-mini-cart-items',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'items_container_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .blank-woo-mini-cart-items',
			]
		);

		$this->add_control(
			'items_container_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .blank-woo-mini-cart-items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_container_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .blank-woo-mini-cart-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'					=> 'items_container_box_shadow',
				'separator'				=> 'before',
				'selector'				=> '{{WRAPPER}} .blank-woo-mini-cart .blank-woo-mini-cart-items',
			]
		);
        
		$this->end_controls_section();
	}
	
	/**
	 * Style Tab: Cart Table
	 * -------------------------------------------------
	 */
	protected function register_style_items_controls() {
		$this->start_controls_section(
			'section_items_style',
			[
				'label'                 => __( 'Item', 'blank-elements-pro' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);
        
        $this->add_control(
            'cart_items_row_separator_type',
            [
                'label'                 => __( 'Separator Type', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'solid',
                'options'               => [
                    'none'		=> __( 'None', 'blank-elements-pro' ),
                    'solid'		=> __( 'Solid', 'blank-elements-pro' ),
                    'dotted'	=> __( 'Dotted', 'blank-elements-pro' ),
                    'dashed'	=> __( 'Dashed', 'blank-elements-pro' ),
                    'double'	=> __( 'Double', 'blank-elements-pro' ),
                ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.product_list_widget li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
            ]
        );

		$this->add_control(
			'cart_items_row_separator_color',
			[
				'label'                 => __( 'Separator Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.product_list_widget li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
					'cart_items_row_separator_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'cart_items_row_separator_size',
			[
				'label'                 => __( 'Separator Size', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.product_list_widget li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
					'cart_items_row_separator_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'cart_items_spacing',
			[
				'label'                 => __( 'Items Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.product_list_widget li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'cart_items_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.product_list_widget li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->start_controls_tabs( 'cart_items_rows_tabs_style' );

		$this->start_controls_tab(
			'cart_items_even_row',
			[
				'label'                 => __( 'Even Row', 'blank-elements-pro' ),
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_even_row_text_color',
			[
				'label'                 => __( 'Text Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item:nth-child(2n)' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_even_row_links_color',
			[
				'label'                 => __( 'Links Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item:nth-child(2n) a' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_even_row_background_color',
			[
				'label'                 => __( 'Background Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item:nth-child(2n)' => 'background-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_items_odd_row',
			[
				'label'                 => __( 'Odd Row', 'blank-elements-pro' ),
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_odd_row_text_color',
			[
				'label'                 => __( 'Text Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item:nth-child(2n+1)' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_odd_row_links_color',
			[
				'label'                 => __( 'Links Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item:nth-child(2n+1) a' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_odd_row_background_color',
			[
				'label'                 => __( 'Background Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item:nth-child(2n+1)' => 'background-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'item_name_heading',
			[
				'label'                 => __( 'Item Name', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'					=> 'item_name_typography',
				'label'					=> __( 'Typography', 'blank-elements-pro' ),
				'selector'				=> '{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item a:not(.remove)',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'item_name_text_color',
			[
				'label'                 => __( 'Text Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item a:not(.remove)' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'item_name_bottom_spacing',
			[
				'label'                 => __( 'Bottom Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .mini_cart_item a:not(.remove)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
					'cart_items_row_separator_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_image_heading',
			[
				'label'                 => __( 'Image', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

        $this->add_responsive_control(
            'cart_items_image_position',
            [
                'label'                 => __( 'Position', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::CHOOSE,
                'label_block'			=> false,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> __( 'Left', 'blank-elements-pro' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'right' 		=> [
                        'title' 	=> __( 'Right', 'blank-elements-pro' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
                ],
                'default'               => 'left',
				'selectors' => [
					'{{WRAPPER}} .blank-woo-mini-cart ul li.woocommerce-mini-cart-item a img' => 'float: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
            ]
        );

		$this->add_responsive_control(
			'cart_items_image_spacing',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul li.woocommerce-mini-cart-item a img' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'cart_items_image_width',
			[
				'label'                 => __( 'Width', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 10,
						'max' => 250,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul li.woocommerce-mini-cart-item a img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_price_heading',
			[
				'label'                 => __( 'Item Quantity & Price', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'					=> 'cart_items_price_typography',
				'label'					=> __( 'Typography', 'blank-elements-pro' ),
				'selector'				=> '{{WRAPPER}} .blank-woo-mini-cart .cart_list .quantity',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_price_color',
			[
				'label'                 => __( 'Text Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .cart_list .quantity' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_remove_icon_heading',
			[
				'label'                 => __( 'Remove Item Icon', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'cart_items_remove_icon_size',
			[
				'label'                 => __( 'Size', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em' ],
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove' => 'font-size: {{SIZE}}{{UNIT}}; width: calc({{SIZE}}{{UNIT}} + 6px); height: calc({{SIZE}}{{UNIT}} + 6px);',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_cart_items_remove_icon_style' );

        $this->start_controls_tab(
            'tab_cart_items_remove_icon_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
				'condition'             => [
					'show_cart_on!' => 'none',
				],
            ]
        );

		$this->add_control(
			'cart_items_remove_icon_color',
			[
				'label'                 => __( 'Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_remove_icon_bg_color',
			[
				'label'                 => __( 'Background Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove' => 'background-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_remove_icon_border_color',
			[
				'label'                 => __( 'Border Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove' => 'border-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_cart_items_remove_icon_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
				'condition'             => [
					'show_cart_on!' => 'none',
				],
            ]
        );

		$this->add_control(
			'cart_items_remove_icon_color_hover',
			[
				'label'                 => __( 'Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove:hover' => 'color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_remove_icon_bg_color_hover',
			[
				'label'                 => __( 'Background Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove:hover' => 'background-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

		$this->add_control(
			'cart_items_remove_icon_border_color_hover',
			[
				'label'                 => __( 'Border Color', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart ul.cart_list li a.remove:hover' => 'border-color: {{VALUE}};',
				],
				'condition'             => [
					'show_cart_on!' => 'none',
				],
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
		$this->end_controls_section();
	}
		
	/**
	 * Style Tab: Buttons
	 * -------------------------------------------------
	 */
	protected function register_style_buttons_controls() {

        $this->start_controls_section(
            'section_buttons_style',
            [
                'label'                 => __( 'Buttons', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'buttons_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button',
            ]
        );

		$this->add_control(
			'buttons_width',
			[
				'label'                 => __( 'Width', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'auto',
				'options'               => [
					'auto'		=> __( 'Auto', 'blank-elements-pro' ),
					'full'		=> __( 'Full Width', 'blank-elements-pro' ),
					'custom'	=> __( 'Custom', 'blank-elements-pro' ),
				],
                'prefix_class'          => 'blank-woo-cart-checkout-button-',
			]
		);

		$this->add_responsive_control(
			'buttons_custom_width',
			[
				'label'                 => __( 'Custom Width', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .buttons .button' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'buttons_width'	=> 'custom',
                ],
			]
		);

		$this->add_responsive_control(
			'buttons_gap',
			[
				'label'                 => __( 'Gap Between', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'buttons_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .buttons .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view_cart_button_heading',
			[
				'label'                 => __( 'View Cart Button', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
			]
		);

        $this->start_controls_tabs( 'tabs_view_cart_button_style' );

        $this->start_controls_tab(
            'tab_view_cart_button_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'view_cart_button_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout)' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'view_cart_button_text_color_normal',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout)' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'view_cart_button_border_normal',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout)',
			]
		);

		$this->add_control(
			'view_cart_button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'view_cart_button_box_shadow',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout)',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_view_cart_button_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'view_cart_button_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout):hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'view_cart_button_text_color_hover',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout):hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'view_cart_button_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout):hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'view_cart_button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button:not(.checkout):hover',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_control(
			'checkout_button_heading',
			[
				'label'                 => __( 'Checkout Button', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
			]
		);

        $this->start_controls_tabs( 'tabs_checkout_button_style' );

        $this->start_controls_tab(
            'tab_checkout_button_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'checkout_button_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'checkout_button_text_color_normal',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'checkout_button_border_normal',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout',
			]
		);

		$this->add_control(
			'checkout_button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'checkout_button_box_shadow',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_checkout_button_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'checkout_button_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'checkout_button_text_color_hover',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'checkout_button_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'checkout_button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .blank-woo-mini-cart .buttons .button.checkout:hover',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->end_controls_section();
	}
		
	/**
	 * Style Tab: Cart Button
	 * -------------------------------------------------
	 */
	protected function register_style_cart_button_controls() {

        $this->start_controls_section(
            'section_cart_button_style',
            [
                'label'                 => __( 'Cart', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'cart_button_title_heading',
			[
				'label'                 => __( 'Cart Title', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
			]
		);

        $this->add_control(
            'cart_title_color_normal',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart-title' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'					=> 'cart_title_typography',
				'label'					=> __( 'Typography', 'blank-elements-pro' ),
				'selector'				=> '{{WRAPPER}} .blank-woo-mini-cart-title',
			]
		);
        
        $this->add_responsive_control(
			'cart_title_spacing',
			[
				'label'                 => __( 'Size', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em' ],
				'default'               => [
					'size' => '',
				],
				'range'                => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-woo-mini-cart-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
        
        $this->add_control(
			'cart_message_title_heading',
			[
				'label'                 => __( 'Cart Message', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
			]
		);

        $this->add_control(
            'cart_message_color_normal',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-woo-mini-cart-message' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'					=> 'cart_message_typography',
				'label'					=> __( 'Typography', 'blank-elements-pro' ),
				'selector'				=> '{{WRAPPER}} .blank-woo-mini-cart-message',
			]
		);

		$this->add_control(
			'cart_button_counter_heading',
			[
				'label'                 => __( 'Counter', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'				=> 'before',
			]
		);

        $this->add_control(
            'cart_button_counter_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-cart-counter' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_button_counter_bg_color',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-cart-counter' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'					=> 'cart_button_counter_typography',
				'label'					=> __( 'Typography', 'blank-elements-pro' ),
				'selector'				=> '{{WRAPPER}} .blank-cart-counter',
			]
		);

		$this->add_responsive_control(
			'cart_button_counter_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-cart-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
	}
	protected function register_advance_rule_control(){
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
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_counter() {
		?>
		<span class="blank-cart-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
		<?php
	}
	
	/**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_icon() {
		$settings = $this->get_settings_for_display();
		
		if ( 'icon' == $settings['icon_type'] ) { ?>
			<span class="blank-cart-contents-icon <?php echo $settings['icon']; ?>"></span>
			<?php
		} elseif ( 'image' == $settings['icon_type'] && $settings['icon_image']['url'] ) { ?>
			<span class="blank-cart-contents-icon-image">
				<?php
					echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'icon_image', 'icon_image' );
				?>
			</span>
			<?php
		}
	}
	
	/**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();
		?>
		<span class="blank-cart-contents-text"><?php echo $settings['cart_text']; ?></span>
		<?php
	}
    
    /**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_subtotal() {
		$settings = $this->get_settings();
		
		$sub_total = WC()->cart->get_cart_subtotal();
		
		if ( 'yes' == $settings['show_subtotal'] ) {
			?>
			<span class="blank-cart-subtotal"><?php echo $sub_total; ?></span>
			<?php
		}
	}
	
	/**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
        if ( null === WC()->cart ) {
			return;
		}
		$settings = $this->get_settings_for_display();
        
        $this->add_render_attribute( 'container', [
			'class' => [
				'blank-woocommerce blank-woo-cart',
				'blank-woo-mini-cart-container',
			],
			'data-target'	=> $settings['show_cart_on'],
        ] );
        
        $this->add_render_attribute( 'button', [
			'class'			=> [
				'blank-woo-cart-contents',
				'blank-woo-cart-' . $settings['icon_style'],
			],
			'href'			=> wc_get_cart_url(),
			'title'			=> __( 'View your shopping cart' ),
		] );
		// wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
						  ?>

							<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
								
								<div class="blank-woo-cart-button">
									<?php $this->render_subtotal(); ?>
									<?php if ( 'before' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-before">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<span class="cart-button-wrap">
											<?php
												if ( 'icon' == $settings['icon_style'] ) {

													$this->render_icon();

												} elseif ( 'icon_text' == $settings['icon_style'] ) {

													$this->render_icon();
													$this->render_text();

												} else {

													$this->render_text();

												}
											?>
										</span>
										
										<?php if ( 'top' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
									</a>

									<?php if ( 'after' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-after">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
								</div>

								<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
									<div class="blank-woo-mini-cart">
										<div class="blank-woo-mini-cart-items">
											<?php if ( $settings['cart_title'] ) { ?>
												<h3 class="blank-woo-mini-cart-title">
													<?php echo $settings['cart_title']; ?>
												</h3>
											<?php } ?>
											
											<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
											
											<?php if ( $settings['cart_message'] ) { ?>
												<div class="blank-woo-mini-cart-message">
													<?php echo $settings['cart_message']; ?>
												</div>
											<?php } ?>
											
										</div>
									</div>
								<?php } ?>
							</div>
							<?php
                        }elseif($item['is_not']=='is_not'  && !is_user_logged_in()){
                           // show original here
						   ?>

							<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
								
								<div class="blank-woo-cart-button">
									<?php $this->render_subtotal(); ?>
									<?php if ( 'before' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-before">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<span class="cart-button-wrap">
											<?php
												if ( 'icon' == $settings['icon_style'] ) {

													$this->render_icon();

												} elseif ( 'icon_text' == $settings['icon_style'] ) {

													$this->render_icon();
													$this->render_text();

												} else {

													$this->render_text();

												}
											?>
										</span>
										
										<?php if ( 'top' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
									</a>

									<?php if ( 'after' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-after">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
								</div>

								<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
									<div class="blank-woo-mini-cart">
										<div class="blank-woo-mini-cart-items">
											<?php if ( $settings['cart_title'] ) { ?>
												<h3 class="blank-woo-mini-cart-title">
													<?php echo $settings['cart_title']; ?>
												</h3>
											<?php } ?>
											
											<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
											
											<?php if ( $settings['cart_message'] ) { ?>
												<div class="blank-woo-mini-cart-message">
													<?php echo $settings['cart_message']; ?>
												</div>
											<?php } ?>
											
										</div>
									</div>
								<?php } ?>
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

								<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
									
									<div class="blank-woo-cart-button">
										<?php $this->render_subtotal(); ?>
										<?php if ( 'before' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count-before">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
										
										<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
											<span class="cart-button-wrap">
												<?php
													if ( 'icon' == $settings['icon_style'] ) {

														$this->render_icon();

													} elseif ( 'icon_text' == $settings['icon_style'] ) {

														$this->render_icon();
														$this->render_text();

													} else {

														$this->render_text();

													}
												?>
											</span>
											
											<?php if ( 'top' == $settings['counter_position'] ) { ?>
												<span class="blank-cart-contents-count">
													<?php $this->render_counter(); ?>
												</span>
											<?php } ?>
										</a>

										<?php if ( 'after' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count-after">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
										
									</div>

									<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
										<div class="blank-woo-mini-cart">
											<div class="blank-woo-mini-cart-items">
												<?php if ( $settings['cart_title'] ) { ?>
													<h3 class="blank-woo-mini-cart-title">
														<?php echo $settings['cart_title']; ?>
													</h3>
												<?php } ?>
												
												<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
												
												<?php if ( $settings['cart_message'] ) { ?>
													<div class="blank-woo-mini-cart-message">
														<?php echo $settings['cart_message']; ?>
													</div>
												<?php } ?>
												
											</div>
										</div>
									<?php } ?>
								</div>
								<?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
								?>

							<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
								
								<div class="blank-woo-cart-button">
									<?php $this->render_subtotal(); ?>
									<?php if ( 'before' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-before">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<span class="cart-button-wrap">
											<?php
												if ( 'icon' == $settings['icon_style'] ) {

													$this->render_icon();

												} elseif ( 'icon_text' == $settings['icon_style'] ) {

													$this->render_icon();
													$this->render_text();

												} else {

													$this->render_text();

												}
											?>
										</span>
										
										<?php if ( 'top' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
									</a>

									<?php if ( 'after' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-after">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
								</div>

								<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
									<div class="blank-woo-mini-cart">
										<div class="blank-woo-mini-cart-items">
											<?php if ( $settings['cart_title'] ) { ?>
												<h3 class="blank-woo-mini-cart-title">
													<?php echo $settings['cart_title']; ?>
												</h3>
											<?php } ?>
											
											<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
											
											<?php if ( $settings['cart_message'] ) { ?>
												<div class="blank-woo-mini-cart-message">
													<?php echo $settings['cart_message']; ?>
												</div>
											<?php } ?>
											
										</div>
									</div>
								<?php } ?>
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

							<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
								
								<div class="blank-woo-cart-button">
									<?php $this->render_subtotal(); ?>
									<?php if ( 'before' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-before">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<span class="cart-button-wrap">
											<?php
												if ( 'icon' == $settings['icon_style'] ) {

													$this->render_icon();

												} elseif ( 'icon_text' == $settings['icon_style'] ) {

													$this->render_icon();
													$this->render_text();

												} else {

													$this->render_text();

												}
											?>
										</span>
										
										<?php if ( 'top' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
									</a>

									<?php if ( 'after' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-after">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
								</div>

								<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
									<div class="blank-woo-mini-cart">
										<div class="blank-woo-mini-cart-items">
											<?php if ( $settings['cart_title'] ) { ?>
												<h3 class="blank-woo-mini-cart-title">
													<?php echo $settings['cart_title']; ?>
												</h3>
											<?php } ?>
											
											<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
											
											<?php if ( $settings['cart_message'] ) { ?>
												<div class="blank-woo-mini-cart-message">
													<?php echo $settings['cart_message']; ?>
												</div>
											<?php } ?>
											
										</div>
									</div>
								<?php } ?>
							</div>
							<?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
								?>

							<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
								
								<div class="blank-woo-cart-button">
									<?php $this->render_subtotal(); ?>
									<?php if ( 'before' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-before">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<span class="cart-button-wrap">
											<?php
												if ( 'icon' == $settings['icon_style'] ) {

													$this->render_icon();

												} elseif ( 'icon_text' == $settings['icon_style'] ) {

													$this->render_icon();
													$this->render_text();

												} else {

													$this->render_text();

												}
											?>
										</span>
										
										<?php if ( 'top' == $settings['counter_position'] ) { ?>
											<span class="blank-cart-contents-count">
												<?php $this->render_counter(); ?>
											</span>
										<?php } ?>
									</a>

									<?php if ( 'after' == $settings['counter_position'] ) { ?>
										<span class="blank-cart-contents-count-after">
											<?php $this->render_counter(); ?>
										</span>
									<?php } ?>
									
								</div>

								<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
									<div class="blank-woo-mini-cart">
										<div class="blank-woo-mini-cart-items">
											<?php if ( $settings['cart_title'] ) { ?>
												<h3 class="blank-woo-mini-cart-title">
													<?php echo $settings['cart_title']; ?>
												</h3>
											<?php } ?>
											
											<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
											
											<?php if ( $settings['cart_message'] ) { ?>
												<div class="blank-woo-mini-cart-message">
													<?php echo $settings['cart_message']; ?>
												</div>
											<?php } ?>
											
										</div>
									</div>
								<?php } ?>
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

		<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
			
			<div class="blank-woo-cart-button">
				<?php $this->render_subtotal(); ?>
				<?php if ( 'before' == $settings['counter_position'] ) { ?>
					<span class="blank-cart-contents-count-before">
						<?php $this->render_counter(); ?>
					</span>
				<?php } ?>
				
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<span class="cart-button-wrap">
						<?php
							if ( 'icon' == $settings['icon_style'] ) {

								$this->render_icon();

							} elseif ( 'icon_text' == $settings['icon_style'] ) {

								$this->render_icon();
								$this->render_text();

							} else {

								$this->render_text();

							}
						?>
					</span>
					
					<?php if ( 'top' == $settings['counter_position'] ) { ?>
						<span class="blank-cart-contents-count">
							<?php $this->render_counter(); ?>
						</span>
					<?php } ?>
				</a>

				<?php if ( 'after' == $settings['counter_position'] ) { ?>
					<span class="blank-cart-contents-count-after">
						<?php $this->render_counter(); ?>
					</span>
				<?php } ?>
				
			</div>

			<?php if ( 'none' != $settings['show_cart_on'] ) { ?>
				<div class="blank-woo-mini-cart">
					<div class="blank-woo-mini-cart-items">
                        <?php if ( $settings['cart_title'] ) { ?>
                            <h3 class="blank-woo-mini-cart-title">
                                <?php echo $settings['cart_title']; ?>
                            </h3>
                        <?php } ?>
                        
						<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart();?></div>
                        
                        <?php if ( $settings['cart_message'] ) { ?>
                            <div class="blank-woo-mini-cart-message">
                                <?php echo $settings['cart_message']; ?>
                            </div>
                        <?php } ?>
                        
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
             
		}
		//end
        
	}
}