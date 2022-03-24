<?php
namespace BlankElementsPro\Modules\Slider\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Slider extends Widget_Base {

	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-slider';
	}

	public function get_title() {
		return __( 'Widget Slider', 'blank-elements-pro' );
	}

	public function get_icon() {
		return ' eicon-slideshow';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}
	
	public function get_script_depends() {
		return [ 'imagesloaded', 'blank-slick', 'blank-js' ];
	}

    /**
	 * Register dual heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {
		
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Slides', 'blank-elements-pro' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );
        
        $repeater->add_control(
			'image',
			[
				'label'                 => __( 'Image', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::MEDIA,
                'default'               => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
			]
		);

		$repeater->add_control(
			'heading',
			[
				'label' => __( 'Title', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'blank-elements-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'Description', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'I am slide description. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'blank-elements-pro' ),
			]
		);

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'heading' => __( 'Slide 1 Heading', 'blank-elements-pro' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'blank-elements-pro' ),
					],
					[
						'heading' => __( 'Slide 2 Heading', 'blank-elements-pro' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'blank-elements-pro' ),
					],
					[
						'heading' => __( 'Slide 3 Heading', 'blank-elements-pro' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'blank-elements-pro' ),
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'image_height',
			[
				'label' => __( 'Height', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blank-slide-image img' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => __( 'Spacing', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blank-slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blank-slide-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				//'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .blank-slide-title',
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Description', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blank-slide-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blank-slide-content,{{WRAPPER}} .blank-slide-content' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				//'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .blank-slide-content,{{WRAPPER}} .blank-slide-content',
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
        
        $this->add_render_attribute( 'list_carousel', 'class', 'blank-slider' );
		// wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
						  ?>
							<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
								<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
									<?php
										$slide_number = $index + 1;
									?>
									<div>
										<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
											<div class="blank-slide-col blank-col-1">
												<?php
													if ( ! empty( $slide['image']['url'] ) ) { ?>
														<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
														</div>
													<?php }
												?>
											</div>
											<div class="blank-slide-col blank-col-2">
												<div class="container">
													<div class="blank-slide-title">
														<?php echo $slide['heading']; ?>
													</div>
													<div class="blank-slide-content">
														<?php echo $slide['description']; ?>
													</div> 
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<?php
                        }elseif($item['is_not']=='is_not'  && !is_user_logged_in()){
                           // show original here
						   ?>
							<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
								<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
									<?php
										$slide_number = $index + 1;
									?>
									<div>
										<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
											<div class="blank-slide-col blank-col-1">
												<?php
													if ( ! empty( $slide['image']['url'] ) ) { ?>
														<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
														</div>
													<?php }
												?>
											</div>
											<div class="blank-slide-col blank-col-2">
												<div class="container">
													<div class="blank-slide-title">
														<?php echo $slide['heading']; ?>
													</div>
													<div class="blank-slide-content">
														<?php echo $slide['description']; ?>
													</div> 
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
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
								<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
									<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
										<?php
											$slide_number = $index + 1;
										?>
										<div>
											<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
												<div class="blank-slide-col blank-col-1">
													<?php
														if ( ! empty( $slide['image']['url'] ) ) { ?>
															<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
															</div>
														<?php }
													?>
												</div>
												<div class="blank-slide-col blank-col-2">
													<div class="container">
														<div class="blank-slide-title">
															<?php echo $slide['heading']; ?>
														</div>
														<div class="blank-slide-content">
															<?php echo $slide['description']; ?>
														</div> 
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
								<?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
								?>
									<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
										<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
											<?php
												$slide_number = $index + 1;
											?>
											<div>
												<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
													<div class="blank-slide-col blank-col-1">
														<?php
															if ( ! empty( $slide['image']['url'] ) ) { ?>
																<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
																</div>
															<?php }
														?>
													</div>
													<div class="blank-slide-col blank-col-2">
														<div class="container">
															<div class="blank-slide-title">
																<?php echo $slide['heading']; ?>
															</div>
															<div class="blank-slide-content">
																<?php echo $slide['description']; ?>
															</div> 
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
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
								<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
									<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
										<?php
											$slide_number = $index + 1;
										?>
										<div>
											<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
												<div class="blank-slide-col blank-col-1">
													<?php
														if ( ! empty( $slide['image']['url'] ) ) { ?>
															<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
															</div>
														<?php }
													?>
												</div>
												<div class="blank-slide-col blank-col-2">
													<div class="container">
														<div class="blank-slide-title">
															<?php echo $slide['heading']; ?>
														</div>
														<div class="blank-slide-content">
															<?php echo $slide['description']; ?>
														</div> 
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
								<?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
								?>
								<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
									<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
										<?php
											$slide_number = $index + 1;
										?>
										<div>
											<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
												<div class="blank-slide-col blank-col-1">
													<?php
														if ( ! empty( $slide['image']['url'] ) ) { ?>
															<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
															</div>
														<?php }
													?>
												</div>
												<div class="blank-slide-col blank-col-2">
													<div class="container">
														<div class="blank-slide-title">
															<?php echo $slide['heading']; ?>
														</div>
														<div class="blank-slide-content">
															<?php echo $slide['description']; ?>
														</div> 
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
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
				<div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
					<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
						<?php
							$slide_number = $index + 1;
						?>
						<div>
							<div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
								<div class="blank-slide-col blank-col-1">
									<?php
										if ( ! empty( $slide['image']['url'] ) ) { ?>
											<div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
											</div>
										<?php }
									?>
								</div>
								<div class="blank-slide-col blank-col-2">
									<div class="container">
										<div class="blank-slide-title">
											<?php echo $slide['heading']; ?>
										</div>
										<div class="blank-slide-content">
											<?php echo $slide['description']; ?>
										</div> 
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php
             
		}
		//end
        
	}
    
    protected function _content_template() {
        
    }
}