<?php
namespace BlankElementsPro\Modules\Heading\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Multi Heading Widget
 */
class Multi_Heading extends Widget_Base {
    
    /**
	 * Retrieve dual heading widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-multi-heading';
    }

    /**
	 * Retrieve dual heading widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Multi Heading', 'blank-elements-pro' );
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
        return [ 'configurator-template-kits-blocks-widgets' ];
    }

    /**
	 * Retrieve dual heading widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-heading';
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
            'section_dual_heading',
            [
                'label'                 => __( 'Heading', 'blank-elements-pro' ),
            ]
        );

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'headings_repeater' );

		$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'blank-elements-pro' ) ] );

		$repeater->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
        
        $repeater->add_control(
            'show_underline',
            [
                'label'                 => __( 'Show Underline', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'return_value'          => 'yes',
            ]
        );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'blank-elements-pro' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label' => __( 'Custom', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'Set custom style that will only affect this specific heading part.', 'blank-elements-pro' ),
			]
		);

		$repeater->add_control(
			'custom_heading_normal',
			[
				'label'                 => __( 'Normal', 'power-pack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => __( 'Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'bg_color',
			[
				'label' => __( 'Background Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'heading_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'custom_heading_hover',
			[
				'label'                 => __( 'Hover', 'power-pack' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'color_hover',
			[
				'label' => __( 'Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blank-dual-heading:hover {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'bg_color_hover',
			[
				'label' => __( 'Background Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blank-dual-heading:hover {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);
        
        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'custom_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'separator'             => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
            ]
        );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'headings',
			[
				'label' => __( 'Headings', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'heading' => __( 'Our', 'blank-elements-pro' ),
					],
					[
						'heading' => __( 'Services', 'blank-elements-pro' ),
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

        $this->add_control(
            'link',
            [
                'label'                 => __( 'Link', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::URL,
				'dynamic'               => [
					'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
				],
                'label_block'           => true,
                'placeholder'           => 'https://www.your-link.com',
            ]
        );
        
        $this->add_control(
            'heading_html_tag',
            [
                'label'                 => __( 'HTML Tag', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'label_block'           => false,
                'default'               => 'h2',
                'options'               => [
                    'h1'     => __( 'H1', 'blank-elements-pro' ),
                    'h2'     => __( 'H2', 'blank-elements-pro' ),
                    'h3'     => __( 'H3', 'blank-elements-pro' ),
                    'h4'     => __( 'H4', 'blank-elements-pro' ),
                    'h5'     => __( 'H5', 'blank-elements-pro' ),
                    'h6'     => __( 'H6', 'blank-elements-pro' ),
                    'div'    => __( 'div', 'blank-elements-pro' ),
                    'span'   => __( 'span', 'blank-elements-pro' ),
                    'p'      => __( 'p', 'blank-elements-pro' ),
                ],
            ]
        );
        
        $this->add_responsive_control(
			'align',
			[
				'label'                 => __( 'Alignment', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => true,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}}'   => 'text-align: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
            'vertical_heading',
            [
                'label'					=> __( 'Vertical Heading', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SWITCHER,
                'default'				=> '',
                'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
                'label_off'				=> __( 'No', 'blank-elements-pro' ),
                'return_value'			=> 'yes',
                'prefix_class'          => 'blank-heading-vertical-'
            ]
        );
        
        $this->add_control(
            'heading_line',
            [
                'label'					=> __( 'Heading Line', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SWITCHER,
                'default'				=> '',
                'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
                'label_off'				=> __( 'No', 'blank-elements-pro' ),
                'return_value'			=> 'yes',
                'condition'				=> [
					'vertical_heading'	=> 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Heading
         */
        $this->start_controls_section(
            'heading_style',
            [
                'label'                 => __( 'Heading', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_text_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-dual-heading,{{WRAPPER}} .blank-dual-heading a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'heading_underline_color',
            [
                'label'                 => __( 'Underline Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-heading-underline:before' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'heading_line_color',
            [
                'label'                 => __( 'Heading Line Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-dual-heading-line:before' => 'background: {{VALUE}};',
                ],
                'condition'				=> [
					'heading_line'	    => 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'heading_bg',
                'label'                 => __( 'Background', 'blank-elements-pro' ),
                'types'                 => [ 'none','classic','gradient' ],
                'selector'              => '{{WRAPPER}} .blank-dual-heading',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'heading_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-dual-heading',
				'separator'             => 'before',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'heading_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-dual-heading',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'heading_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-dual-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'heading_text_margin',
			[
				'label'                 => __( 'Spacing', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ '%', 'px' ],
                'default'               => [
                    'size' => 0,
                    'unit' => 'px',
                ],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'tablet_default'        => [
					'unit' => 'px',
				],
				'mobile_default'        => [
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-dual-heading > span:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'heading_text_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-dual-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'                  => 'heading_text_shadow',
				'selector'              => '{{WRAPPER}} .blank-dual-heading',
				'separator'             => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'heading_box_shadow',
				'selector'              => '{{WRAPPER}} .blank-dual-heading',
				'separator'             => 'before',
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

        $this->add_render_attribute( 'dual-heading', 'class', 'blank-dual-heading' );
        
        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'dual-heading-link', 'href', $settings['link']['url'] );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'dual-heading-link', 'target', '_blank' );
            }

            if ( $settings['link']['nofollow'] ) {
                $this->add_render_attribute( 'dual-heading-link', 'rel', 'nofollow' );
            }
        }
        
        if( $settings['vertical_heading'] == 'yes' && $settings['heading_line'] == 'yes' ) {
            $this->add_render_attribute( 'dual-heading', 'class', 'blank-dual-heading-line' );
        }
		// wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
						  printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
							if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
							foreach ( $settings['headings'] as $part ) {
								//print_r( $part );
								$underline_class = '';
								if ( $part['show_underline'] == 'yes' ) {
									$underline_class = 'blank-heading-underline';
								}
								?>
								<span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
									<?php echo $part['heading']; ?>
								</span>
								<?php
							}
							if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
						printf( '</%1$s>', $settings['heading_html_tag'] );
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
						   printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
								if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
								foreach ( $settings['headings'] as $part ) {
									//print_r( $part );
									$underline_class = '';
									if ( $part['show_underline'] == 'yes' ) {
										$underline_class = 'blank-heading-underline';
									}
									?>
									<span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
										<?php echo $part['heading']; ?>
									</span>
									<?php
								}
								if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
							printf( '</%1$s>', $settings['heading_html_tag'] );
                        }
                    break;
                    case 'user':
                        global $current_user;
                        wp_get_current_user();
                        $current_user = $current_user->user_login;
                        if($item['is_not']=='is'){
                            if($current_user==$item['current_user']){
                               // show original here
							   printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
								if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
								foreach ( $settings['headings'] as $part ) {
									//print_r( $part );
									$underline_class = '';
									if ( $part['show_underline'] == 'yes' ) {
										$underline_class = 'blank-heading-underline';
									}
									?>
									<span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
										<?php echo $part['heading']; ?>
									</span>
									<?php
								}
								if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
							printf( '</%1$s>', $settings['heading_html_tag'] );
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
								printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
									if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
									foreach ( $settings['headings'] as $part ) {
										//print_r( $part );
										$underline_class = '';
										if ( $part['show_underline'] == 'yes' ) {
											$underline_class = 'blank-heading-underline';
										}
										?>
										<span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
											<?php echo $part['heading']; ?>
										</span>
										<?php
									}
									if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
								printf( '</%1$s>', $settings['heading_html_tag'] );

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
							   printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
								if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
								foreach ( $settings['headings'] as $part ) {
									//print_r( $part );
									$underline_class = '';
									if ( $part['show_underline'] == 'yes' ) {
										$underline_class = 'blank-heading-underline';
									}
									?>
									<span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
										<?php echo $part['heading']; ?>
									</span>
									<?php
								}
								if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
							printf( '</%1$s>', $settings['heading_html_tag'] );
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
								printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
								if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
								foreach ( $settings['headings'] as $part ) {
									//print_r( $part );
									$underline_class = '';
									if ( $part['show_underline'] == 'yes' ) {
										$underline_class = 'blank-heading-underline';
									}
									?>
									<span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
										<?php echo $part['heading']; ?>
									</span>
									<?php
								}
								if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
							printf( '</%1$s>', $settings['heading_html_tag'] );
                                   
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
			printf( '<%1$s %2$s>', $settings['heading_html_tag'], $this->get_render_attribute_string( 'dual-heading' ) );
            if ( ! empty( $settings['link']['url'] ) ) { printf( '<a %1$s>', $this->get_render_attribute_string( 'dual-heading-link' ) ); }
            foreach ( $settings['headings'] as $part ) {
                //print_r( $part );
                $underline_class = '';
                if ( $part['show_underline'] == 'yes' ) {
                    $underline_class = 'blank-heading-underline';
                }
                ?>
                <span class="elementor-repeater-item-<?php echo $part['_id']; ?> <?php echo $underline_class; ?>">
                    <?php echo $part['heading']; ?>
                </span>
                <?php
            }
            if ( ! empty( $settings['link']['url'] ) ) { printf( '</a>' ); }
        printf( '</%1$s>', $settings['heading_html_tag'] );
             
		}
		//end
        
        
    }

    /**
	 * Render dual heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {}
}