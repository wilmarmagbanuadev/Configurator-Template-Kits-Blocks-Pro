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
		return [ 'configurator-template-kits-blocks-pro-widgets'];
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
		
	protected function render() {
		$settings = $this->get_settings();
		
		$this->add_render_attribute( 'container', 'class', [
            'blank-woocommerce',
            'blank-woo-cart',
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
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
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
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
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
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
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
		//end
       
	}

	protected function _content_template() {}
	
}