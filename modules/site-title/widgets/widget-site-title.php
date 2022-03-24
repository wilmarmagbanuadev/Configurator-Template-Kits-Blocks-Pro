<?php
namespace BlankElementsPro\Modules\SiteTitle\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Site_Title extends Widget_Base {

	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-site-title';
	}

	public function get_title() {
		return __( 'Site Title', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'eicon-site-title';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}

	
	/**
	 * Register site title controls controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_general_content_controls();
		$this->register_heading_typo_content_controls();

		$this->register_advance_rule_control();
	}

	/**
	 * Register Advanced Heading General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'General', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'before',
			[
				'label'   => __( 'Before Title Text', 'blank-elements-pro' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'after',
			[
				'label'   => __( 'After Title Text', 'blank-elements-pro' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => __( 'Icon', 'blank-elements-pro' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => 'true',
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .be-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'   => __( 'Link', 'blank-elements-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'custom'  => __( 'Custom URL', 'blank-elements-pro' ),
					'default' => __( 'Default', 'blank-elements-pro' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'heading_link',
			[
				'label'       => __( 'Link', 'blank-elements-pro' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'blank-elements-pro' ),
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => get_home_url(),
				],
				'condition'   => [
					'custom_link' => 'custom',
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => __( 'Size', 'blank-elements-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'blank-elements-pro' ),
					'small'   => __( 'Small', 'blank-elements-pro' ),
					'medium'  => __( 'Medium', 'blank-elements-pro' ),
					'large'   => __( 'Large', 'blank-elements-pro' ),
					'xl'      => __( 'XL', 'blank-elements-pro' ),
					'xxl'     => __( 'XXL', 'blank-elements-pro' ),
				],
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => __( 'HTML Tag', 'blank-elements-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'blank-elements-pro' ),
					'h2' => __( 'H2', 'blank-elements-pro' ),
					'h3' => __( 'H3', 'blank-elements-pro' ),
					'h4' => __( 'H4', 'blank-elements-pro' ),
					'h5' => __( 'H5', 'blank-elements-pro' ),
					'h6' => __( 'H6', 'blank-elements-pro' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'heading_text_align',
			[
				'label'        => __( 'Alignment', 'blank-elements-pro' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'selectors'    => [
					'{{WRAPPER}} .be-heading' => 'text-align: {{VALUE}};',
				],
				'prefix_class' => 'hfe%s-heading-align-',
			]
		);
		$this->end_controls_section();
	}


	/**
	 * Register Advanced Heading Typography Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_heading_typo_content_controls() {
		$this->start_controls_section(
			'section_heading_typography',
			[
				'label' => __( 'Title', 'blank-elements-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				//'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .be-heading a',
			]
		);
		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				// 'scheme'    => [
				// 	'type'  => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				'selectors' => [
					'{{WRAPPER}} .be-heading-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .be-icon i'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .be-icon svg'     => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'heading_shadow',
				'selector' => '{{WRAPPER}} .be-heading-text',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label'     => __( 'Blend Mode', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => __( 'Normal', 'blank-elements-pro' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'luminosity'  => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .be-heading-text' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label'     => __( 'Icon', 'blank-elements-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				// 'scheme'    => [
				// 	'type'  => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				'condition' => [
					'icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .be-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .be-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icons_hover_color',
			[
				'label'     => __( 'Icon Hover Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .be-icon:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .be-icon:hover svg' => 'fill: {{VALUE}};',
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
	/**
	 * Render Heading output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings();
		$title    = get_bloginfo( 'name' );

		$this->add_inline_editing_attributes( 'heading_title', 'basic' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( ! empty( $settings['heading_link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['heading_link']['url'] );

			if ( $settings['heading_link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['heading_link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}
			$link = $this->get_render_attribute_string( 'url' );
		}
		// wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
						  ?>
		

							<div class="be-module-content be-heading-wrapper elementor-widget-heading">
							<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
										<a <?php echo $link; ?> >
									<?php } else { ?>
										<a href="<?php echo get_home_url(); ?>">
									<?php } ?>
								<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
									<?php if ( '' !== $settings['icon']['value'] ) { ?>
										<span class="be-icon">
											<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
										</span>
									<?php } ?>
										<span class="be-heading-text" >
										<?php
										if ( '' !== $settings['before'] ) {
											echo wp_kses_post( $settings['before'] );
										}
										?>
										<?php echo wp_kses_post( $title ); ?>
										<?php
										if ( '' !== $settings['after'] ) {
											echo wp_kses_post( $settings['after'] );
										}
										?>
										</span>			
								</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
								</a>		
							</div>
							<?php
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
						   ?>
		

							<div class="be-module-content be-heading-wrapper elementor-widget-heading">
							<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
										<a <?php echo $link; ?> >
									<?php } else { ?>
										<a href="<?php echo get_home_url(); ?>">
									<?php } ?>
								<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
									<?php if ( '' !== $settings['icon']['value'] ) { ?>
										<span class="be-icon">
											<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
										</span>
									<?php } ?>
										<span class="be-heading-text" >
										<?php
										if ( '' !== $settings['before'] ) {
											echo wp_kses_post( $settings['before'] );
										}
										?>
										<?php echo wp_kses_post( $title ); ?>
										<?php
										if ( '' !== $settings['after'] ) {
											echo wp_kses_post( $settings['after'] );
										}
										?>
										</span>			
								</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
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
							   ?>
		

							<div class="be-module-content be-heading-wrapper elementor-widget-heading">
							<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
										<a <?php echo $link; ?> >
									<?php } else { ?>
										<a href="<?php echo get_home_url(); ?>">
									<?php } ?>
								<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
									<?php if ( '' !== $settings['icon']['value'] ) { ?>
										<span class="be-icon">
											<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
										</span>
									<?php } ?>
										<span class="be-heading-text" >
										<?php
										if ( '' !== $settings['before'] ) {
											echo wp_kses_post( $settings['before'] );
										}
										?>
										<?php echo wp_kses_post( $title ); ?>
										<?php
										if ( '' !== $settings['after'] ) {
											echo wp_kses_post( $settings['after'] );
										}
										?>
										</span>			
								</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
								</a>		
							</div>
							<?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
								?>
		

								<div class="be-module-content be-heading-wrapper elementor-widget-heading">
								<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
											<a <?php echo $link; ?> >
										<?php } else { ?>
											<a href="<?php echo get_home_url(); ?>">
										<?php } ?>
									<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
										<?php if ( '' !== $settings['icon']['value'] ) { ?>
											<span class="be-icon">
												<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
											</span>
										<?php } ?>
											<span class="be-heading-text" >
											<?php
											if ( '' !== $settings['before'] ) {
												echo wp_kses_post( $settings['before'] );
											}
											?>
											<?php echo wp_kses_post( $title ); ?>
											<?php
											if ( '' !== $settings['after'] ) {
												echo wp_kses_post( $settings['after'] );
											}
											?>
											</span>			
									</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
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
							   ?>
		

						<div class="be-module-content be-heading-wrapper elementor-widget-heading">
						<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
									<a <?php echo $link; ?> >
								<?php } else { ?>
									<a href="<?php echo get_home_url(); ?>">
								<?php } ?>
							<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
								<?php if ( '' !== $settings['icon']['value'] ) { ?>
									<span class="be-icon">
										<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
									</span>
								<?php } ?>
									<span class="be-heading-text" >
									<?php
									if ( '' !== $settings['before'] ) {
										echo wp_kses_post( $settings['before'] );
									}
									?>
									<?php echo wp_kses_post( $title ); ?>
									<?php
									if ( '' !== $settings['after'] ) {
										echo wp_kses_post( $settings['after'] );
									}
									?>
									</span>			
							</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
							</a>		
						</div>
						<?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
								?>
		

						<div class="be-module-content be-heading-wrapper elementor-widget-heading">
						<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
									<a <?php echo $link; ?> >
								<?php } else { ?>
									<a href="<?php echo get_home_url(); ?>">
								<?php } ?>
							<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
								<?php if ( '' !== $settings['icon']['value'] ) { ?>
									<span class="be-icon">
										<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
									</span>
								<?php } ?>
									<span class="be-heading-text" >
									<?php
									if ( '' !== $settings['before'] ) {
										echo wp_kses_post( $settings['before'] );
									}
									?>
									<?php echo wp_kses_post( $title ); ?>
									<?php
									if ( '' !== $settings['after'] ) {
										echo wp_kses_post( $settings['after'] );
									}
									?>
									</span>			
							</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
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
			?>
		

			<div class="be-module-content be-heading-wrapper elementor-widget-heading">
			<?php if ( ! empty( $settings['heading_link']['url'] ) && 'custom' === $settings['custom_link'] ) { ?>
						<a <?php echo $link; ?> >
					<?php } else { ?>
						<a href="<?php echo get_home_url(); ?>">
					<?php } ?>
				<<?php echo wp_kses_post( $settings['heading_tag'] ); ?> class="be-heading elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
					<?php if ( '' !== $settings['icon']['value'] ) { ?>
						<span class="be-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>					
						</span>
					<?php } ?>
						<span class="be-heading-text" >
						<?php
						if ( '' !== $settings['before'] ) {
							echo wp_kses_post( $settings['before'] );
						}
						?>
						<?php echo wp_kses_post( $title ); ?>
						<?php
						if ( '' !== $settings['after'] ) {
							echo wp_kses_post( $settings['after'] );
						}
						?>
						</span>			
				</<?php echo wp_kses_post( $settings['heading_tag'] ); ?>>
				</a>		
			</div>
			<?php
             
		}
		//end
		
	}
		/**
		 * Render site title output in the editor.
		 *
		 * Written as a Backbone JavaScript template and used to generate the live preview.
		 *
		 * @since 1.3.0
		 * @access protected
		 */
	protected function content_template() {
		?>
		<#
		if ( '' == settings.heading_title ) {
			return;
		}
		if ( '' == settings.size ){
			return;
		}
		if ( '' != settings.heading_link.url ) {
			view.addRenderAttribute( 'url', 'href', settings.heading_link.url );
		}
		var iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
		#>
		<div class="be-module-content be-heading-wrapper elementor-widget-heading">
				<# if ( '' != settings.heading_link.url ) { #>
					<a {{{ view.getRenderAttributeString( 'url' ) }}} >
				<# } #>
				<{{{ settings.heading_tag }}} class="be-heading elementor-heading-title elementor-size-{{{ settings.size }}}">
				<# if( '' != settings.icon.value ){ #>
				<span class="be-icon">
					{{{iconHTML.value}}}					
				</span>
				<# } #>
				<span class="be-heading-text  elementor-heading-title" data-elementor-setting-key="heading_title" data-elementor-inline-editing-toolbar="basic" >
				<#if ( '' != settings.before ){#>
					{{{ settings.before }}} 
				<#}#>
				<?php echo wp_kses_post( get_bloginfo( 'name' ) ); ?>
				<# if ( '' != settings.after ){#>
					{{{ settings.after }}}
				<#}#>
				</span>
			</{{{ settings.heading_tag }}}>
			<# if ( '' != settings.heading_link.url ) { #>
				</a>
			<# } #>
		</div>
		<?php
	}

	/**
	 * Render site title output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * Remove this after Elementor v3.3.0
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _content_template() {
		$this->content_template();
	}
}
