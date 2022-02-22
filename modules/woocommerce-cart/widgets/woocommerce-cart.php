<?php
namespace BlankElementsPro\Modules\WoocommerceCart\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Woocommerce_Cart extends Widget_Base {

	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-woo-cart';
	}

	public function get_title() {
		return __( 'Woocommerce Cart', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'eicon-cart';
	}

	public function get_categories() {
		return [ 'blank-elements-widgets'];
	}
	
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Settings', 'blank-elements-pro' ),
			]
		);
		
		$this->add_control(
			'show_coupon',
			[
				'label'					=> __( 'Show Coupon Field', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'default'				=> 'yes',
				'return_value'			=> 'yes',
				'frontend_available'    => true,
			]
		);

		$this->add_control(
			'show_cross_sells',
			[
				'label'					=> __( 'Show Cross Sells', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'default'				=> 'yes',
				'return_value'			=> 'yes',
				'frontend_available'    => true,
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Styles', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		// Add your widget/element styling controls here! - Below is an example style option
		
		$this->add_control(
			'text_transform',
			[
				'label' => __( 'Text Transform', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'blank-elements-pro' ),
					'uppercase' => __( 'UPPERCASE', 'blank-elements-pro' ),
					'lowercase' => __( 'lowercase', 'blank-elements-pro' ),
					'capitalize' => __( 'Capitalize', 'blank-elements-pro' ),
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
	}
		
	protected function render() {
		$settings = $this->get_settings();
		
		$this->add_render_attribute( 'container', 'class', [
            'blank-woocommerce',
            'blank-woo-cart',
        ] );
        ?>

		<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
			<?php

				if ( '' === $settings['show_cross_sells'] ) {
					// Hide Cross Sell field on cart page
					remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
				}

				if ( '' === $settings['show_coupon'] ) {
					// Hide coupon field on cart page
					add_filter( 'woocommerce_coupons_enabled', '__return_false' );
				}

				echo do_shortcode('[woocommerce_cart]');

			?>
		</div>

		<?php
	}

	protected function _content_template() {}
	
}