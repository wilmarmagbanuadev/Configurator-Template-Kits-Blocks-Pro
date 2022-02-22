<?php
namespace BlankElementsPro\Modules\WoocommerceMiniCart;

use BlankElementsPro\Base\Module_Base;

class Module extends Module_Base {
	
	public function blank_cart_count_fragments( $fragments ) {

		$fragments['span.blank-cart-counter'] = '<span class="blank-cart-counter">' . WC()->cart->get_cart_contents_count() . '</span>';

		return $fragments;

	}

	public function __construct() {
		parent::__construct();

		// This is here for extensibility purposes - go to town and make things happen!
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'blank_cart_count_fragments' ] );

	}
	
	public function get_name() {
		return 'blank-woo-mini-cart';
	}

	public function get_widgets() {
		return [
			'Woo_Mini_Cart', // What is it goes here. This should match the widget/element class - the file name should also match but in small caps!
		];
	}
	
}