<?php
namespace BlankElementsPro\Modules\Button\Widgets;

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

class Widget_Button extends Widget_Base {

	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-widget-button';
	}

	public function get_title() {
		return __( 'Button', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}
    
    public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'blank-elements-pro' ),
			'sm' => __( 'Small', 'blank-elements-pro' ),
			'md' => __( 'Medium', 'blank-elements-pro' ),
			'lg' => __( 'Large', 'blank-elements-pro' ),
			'xl' => __( 'Extra Large', 'blank-elements-pro' ),
		];
	}

	
	protected function _register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click here', 'blank-elements-pro' ),
				'placeholder' => __( 'Click here', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'blank-elements-pro' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'blank-elements-pro' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'blank-elements-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'blank-elements-pro' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'blank-elements-pro' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'blank-elements-pro' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'blank-elements-pro' ),
					'right' => __( 'After', 'blank-elements-pro' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'blank-elements-pro' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);
        
        $this->add_control(
			'button_line',
			[
				'label' => __( 'Button Line', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'right' => __( 'Right', 'elementor' ),
					'left' => __( 'Left', 'elementor' ),
				],
				'prefix_class' => 'blank-button-line-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'button_bg',
                'label'                 => __( 'Background', 'blank-elements-pro' ),
                'types'                 => [ 'none','classic','gradient' ],
                'selector'              => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
            ]
        );

		/*$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);*/
        
        $this->add_control(
			'button_line_color',
			[
				'label' => __( 'Line Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blank-button .blank-button-line, {{WRAPPER}} .blank-button .blank-button-line' => 'background: {{VALUE}};',
				],
                'condition'             => [
                    'button_line!'  => 'default',
                ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'button_bg_hover',
                'label'                 => __( 'Background', 'blank-elements-pro' ),
                'types'                 => [ 'none','classic','gradient' ],
                'selector'              => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover',
            ]
        );
        
        $this->add_control(
			'button_line_color_hover',
			[
				'label' => __( 'Line Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blank-button a:hover .blank-button-line, {{WRAPPER}} .blank-button a:hover .blank-button-line' => 'background: {{VALUE}};',
				],
                'condition'             => [
                    'button_line!'  => 'default',
                ],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'blank-elements-pro' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
        
        $this->add_responsive_control(
            'button_line_height',
            [
                'label'                 => __( 'Line Height', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-button-line' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'button_line!'  => 'default',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'button_line_width',
            [
                'label'                 => __( 'Line Width', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-button-line' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'button_line!'  => 'default',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_line_spacing',
            [
                'label'                 => __( 'Line Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}}.blank-button-line-right .blank-button-line' => 'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.blank-button-line-left .blank-button-line' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'button_line!'  => 'default',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'blank-elements-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'blank-elements-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
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
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper blank-button' );
		
		// wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
							if ( ! empty( $settings['link']['url'] ) ) {
								$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
								$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
					
								if ( $settings['link']['is_external'] ) {
									$this->add_render_attribute( 'button', 'target', '_blank' );
								}
					
								if ( $settings['link']['nofollow'] ) {
									$this->add_render_attribute( 'button', 'rel', 'nofollow' );
								}
							}
					
							$this->add_render_attribute( 'button', 'class', 'elementor-button' );
							$this->add_render_attribute( 'button', 'role', 'button' );
					
							if ( ! empty( $settings['button_css_id'] ) ) {
								$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
							}
					
							if ( ! empty( $settings['size'] ) ) {
								$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
							}
					
							if ( $settings['hover_animation'] ) {
								$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
							}
					
							?>
							<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
								<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
									<?php $this->render_text(); ?>
								</a>
							</div>
							<?php
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
								if ( ! empty( $settings['link']['url'] ) ) {
								$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
								$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
					
								if ( $settings['link']['is_external'] ) {
									$this->add_render_attribute( 'button', 'target', '_blank' );
								}
					
								if ( $settings['link']['nofollow'] ) {
									$this->add_render_attribute( 'button', 'rel', 'nofollow' );
								}
							}
					
							$this->add_render_attribute( 'button', 'class', 'elementor-button' );
							$this->add_render_attribute( 'button', 'role', 'button' );
					
							if ( ! empty( $settings['button_css_id'] ) ) {
								$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
							}
					
							if ( ! empty( $settings['size'] ) ) {
								$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
							}
					
							if ( $settings['hover_animation'] ) {
								$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
							}
					
							?>
							<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
								<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
									<?php $this->render_text(); ?>
								</a>
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
								if ( ! empty( $settings['link']['url'] ) ) {
									$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
									$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
						
									if ( $settings['link']['is_external'] ) {
										$this->add_render_attribute( 'button', 'target', '_blank' );
									}
						
									if ( $settings['link']['nofollow'] ) {
										$this->add_render_attribute( 'button', 'rel', 'nofollow' );
									}
								}
						
								$this->add_render_attribute( 'button', 'class', 'elementor-button' );
								$this->add_render_attribute( 'button', 'role', 'button' );
						
								if ( ! empty( $settings['button_css_id'] ) ) {
									$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
								}
						
								if ( ! empty( $settings['size'] ) ) {
									$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
								}
						
								if ( $settings['hover_animation'] ) {
									$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
								}
						
								?>
								<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<?php $this->render_text(); ?>
									</a>
								</div>
								<?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
								if ( ! empty( $settings['link']['url'] ) ) {
									$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
									$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
						
									if ( $settings['link']['is_external'] ) {
										$this->add_render_attribute( 'button', 'target', '_blank' );
									}
						
									if ( $settings['link']['nofollow'] ) {
										$this->add_render_attribute( 'button', 'rel', 'nofollow' );
									}
								}
						
								$this->add_render_attribute( 'button', 'class', 'elementor-button' );
								$this->add_render_attribute( 'button', 'role', 'button' );
						
								if ( ! empty( $settings['button_css_id'] ) ) {
									$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
								}
						
								if ( ! empty( $settings['size'] ) ) {
									$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
								}
						
								if ( $settings['hover_animation'] ) {
									$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
								}
						
								?>
								<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<?php $this->render_text(); ?>
									</a>
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
								if ( ! empty( $settings['link']['url'] ) ) {
									$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
									$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
						
									if ( $settings['link']['is_external'] ) {
										$this->add_render_attribute( 'button', 'target', '_blank' );
									}
						
									if ( $settings['link']['nofollow'] ) {
										$this->add_render_attribute( 'button', 'rel', 'nofollow' );
									}
								}
						
								$this->add_render_attribute( 'button', 'class', 'elementor-button' );
								$this->add_render_attribute( 'button', 'role', 'button' );
						
								if ( ! empty( $settings['button_css_id'] ) ) {
									$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
								}
						
								if ( ! empty( $settings['size'] ) ) {
									$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
								}
						
								if ( $settings['hover_animation'] ) {
									$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
								}
						
								?>
								<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
									<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<?php $this->render_text(); ?>
									</a>
								</div>
								<?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
									if ( ! empty( $settings['link']['url'] ) ) {
										$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
										$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
							
										if ( $settings['link']['is_external'] ) {
											$this->add_render_attribute( 'button', 'target', '_blank' );
										}
							
										if ( $settings['link']['nofollow'] ) {
											$this->add_render_attribute( 'button', 'rel', 'nofollow' );
										}
									}
							
									$this->add_render_attribute( 'button', 'class', 'elementor-button' );
									$this->add_render_attribute( 'button', 'role', 'button' );
							
									if ( ! empty( $settings['button_css_id'] ) ) {
										$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
									}
							
									if ( ! empty( $settings['size'] ) ) {
										$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
									}
							
									if ( $settings['hover_animation'] ) {
										$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
									}
							
									?>
									<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
										<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
											<?php $this->render_text(); ?>
										</a>
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
				if ( ! empty( $settings['link']['url'] ) ) {
					$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
					$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		
					if ( $settings['link']['is_external'] ) {
						$this->add_render_attribute( 'button', 'target', '_blank' );
					}
		
					if ( $settings['link']['nofollow'] ) {
						$this->add_render_attribute( 'button', 'rel', 'nofollow' );
					}
				}
		
				$this->add_render_attribute( 'button', 'class', 'elementor-button' );
				$this->add_render_attribute( 'button', 'role', 'button' );
		
				if ( ! empty( $settings['button_css_id'] ) ) {
					$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
				}
		
				if ( ! empty( $settings['size'] ) ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
				}
		
				if ( $settings['hover_animation'] ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
				}
		
				?>
				<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
					<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
						<?php $this->render_text(); ?>
					</a>
				</div>
				<?php
             
		}
		

		
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'button-line' => [
				'class' => 'blank-button-line',
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
            
            <?php if ( $settings['button_line'] != 'default' ) : ?>
            <!-- button line left -->
			<span <?php echo $this->get_render_attribute_string( 'button-line' ); ?>>
			</span>
			<?php endif; ?>
            
			<?php if ( ! empty( $settings['icon'] ) ) : ?>
            <!-- icon -->
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
            
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
            
		</span>
		<?php
	}
    
	protected function _content_template() {}
	
}