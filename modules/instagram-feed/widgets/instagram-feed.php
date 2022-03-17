<?php
namespace BlankElementsPro\Modules\InstagramFeed\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Instagram_Feed extends Widget_Base {
    
    /**
	 * Retrieve instagram feed widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-instagram-feed';
    }

    /**
	 * Retrieve instagram feed widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Instagram Feed', 'blank-elements-pro' );
    }

    /**
	 * Retrieve the list of categories the instagram feed widget belongs to.
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
	 * Retrieve instagram feed widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-instagram-gallery';
    }
    
    /**
	 * Retrieve the list of scripts the instagram feed widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
    public function get_script_depends() {
        return [
            'instafeed',
            'blank-js'
        ];
    }

    /**
	 * Register instagram feed widget controls.
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
         * Content Tab: Instagram Account
         */
        $this->start_controls_section(
            'section_instaaccount',
            [
                'label'                 => __( 'Instagram Account', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'user_id',
            [
                'label'                 => __( 'User ID', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
            ]
        );
        
        $this->add_control(
            'access_token',
            [
                'label'                 => __( 'Access Token', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
            ]
        );
        
        $this->add_control(
            'client_id',
            [
                'label'                 => __( 'Client ID', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();
        
        /**
         * Content Tab: Feed Settings
         */
        $this->start_controls_section(
            'section_instafeed',
            [
                'label'                 => __( 'Feed Settings', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
            'images_count',
            [
                'label'                 => __( 'Images Count', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 5 ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
            ]
        );

        $this->add_control(
            'resolution',
            [
                'label'                 => __( 'Image Resolution', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'thumbnail'              => __( 'Thumbnail', 'blank-elements-pro' ),
                   'low_resolution'         => __( 'Low Resolution', 'blank-elements-pro' ),
                   'standard_resolution'    => __( 'Standard Resolution', 'blank-elements-pro' ),
                ],
                'default'               => 'low_resolution',
            ]
        );

        $this->add_control(
            'sort_by',
            [
                'label'                 => __( 'Sort By', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'none'               => __( 'None', 'blank-elements-pro' ),
                   'most-recent'        => __( 'Most Recent', 'blank-elements-pro' ),
                   'least-recent'       => __( 'Least Recent', 'blank-elements-pro' ),
                   'most-liked'         => __( 'Most Liked', 'blank-elements-pro' ),
                   'least-liked'        => __( 'Least Liked', 'blank-elements-pro' ),
                   'most-commented'     => __( 'Most Commented', 'blank-elements-pro' ),
                   'least-commented'    => __( 'Least Commented', 'blank-elements-pro' ),
                   'random'             => __( 'Random', 'blank-elements-pro' ),
                ],
                'default'               => 'none',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: General Settings
         */
        $this->start_controls_section(
            'section_general_settings',
            [
                'label'                 => __( 'General Settings', 'blank-elements-pro' ),
            ]
        );

        $this->add_responsive_control(
            'grid_cols',
            [
                'label'                 => __( 'Grid Columns', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'label_block'           => false,
                'default'               => '5',
                'tablet_default'        => '3',
                'mobile_default'        => '2',
                'options'               => [
                   '1'              => __( '1', 'blank-elements-pro' ),
                   '2'              => __( '2', 'blank-elements-pro' ),
                   '3'              => __( '3', 'blank-elements-pro' ),
                   '4'              => __( '4', 'blank-elements-pro' ),
                   '5'              => __( '5', 'blank-elements-pro' ),
                   '6'              => __( '6', 'blank-elements-pro' ),
                   '7'              => __( '7', 'blank-elements-pro' ),
                   '8'              => __( '8', 'blank-elements-pro' ),
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed-grid .blank-feed-item' => 'width: calc( 100% / {{VALUE}} )',
                ],
            ]
        );
        
        $this->add_control(
            'insta_likes',
            [
                'label'                 => __( 'Likes', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Show', 'blank-elements-pro' ),
                'label_off'             => __( 'Hide', 'blank-elements-pro' ),
                'return_value'          => 'yes',
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'insta_comments',
            [
                'label'                 => __( 'Comments', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Show', 'blank-elements-pro' ),
                'label_off'             => __( 'Hide', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'content_visibility',
            [
                'label'                 => __( 'Content Visibility', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'always',
                'options'               => [
                   'always'         => __( 'Always', 'blank-elements-pro' ),
                   'hover'          => __( 'On Hover', 'blank-elements-pro' ),
                ],
            ]
        );
        
        $this->add_control(
            'insta_image_popup',
            [
                'label'                 => __( 'Open Image in Popup', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'insta_profile_link',
            [
                'label'                 => __( 'Show Link to Instagram Profile?', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'insta_link_title',
            [
                'label'                 => __( 'Link Title', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( 'Follow Us @ Instagram', 'blank-elements-pro' ),
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->add_control(
            'insta_profile_url',
            [
                'label'                 => __( 'Instagram Profile URL', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::URL,
                'placeholder'           => 'https://www.your-link.com',
                'default'               => [
                    'url'           => '#',
                ],
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );
        
        $this->add_control(
            'insta_title_icon',
            [
                'label'                 => __( 'Title Icon', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::ICON,
                'default'               => 'fa fa-instagram',
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->add_control(
            'insta_title_icon_position',
            [
                'label'                 => __( 'Icon Position', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'before_title'   => __( 'Before Title', 'blank-elements-pro' ),
                   'after_title'    => __( 'After Title', 'blank-elements-pro' ),
                ],
                'default'               => 'before_title',
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );
        
        $this->add_control(
            'load_more_button',
            [
                'label'                 => __( 'Show Load More Button', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'load_more_button_text',
            [
                'label'                 => __( 'Button Text', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( 'Load More', 'blank-elements-pro' ),
				'condition'             => [
					'load_more_button'  => 'yes'
				],
            ]
        );
        
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Image
         */
        $this->start_controls_section(
            'section_image_style',
            [
                'label'                 => __( 'Image', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_image_style' );

        $this->start_controls_tab(
            'tab_image_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
            'insta_image_grayscale',
            [
                'label'                 => __( 'Grayscale Image', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'overlay_heading',
            [
                'label'                 => __( 'Overlay', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
            ]
        );
			
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'image_overlay_normal',
                'label'                 => __( 'Overlay', 'blank-elements-pro' ),
                'types'                 => [ 'classic','gradient' ],
                'selector'              => '{{WRAPPER}} .blank-instagram-feed .blank-feed-item:before',
            ]
        );
        
        $this->add_control(
            'image_overlay_opacity_normal',
            [
                'label'                 => __( 'Overlay Opacity', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => 0.1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed .blank-feed-item:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
            'insta_image_grayscale_hover',
            [
                'label'                 => __( 'Grayscale Image', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'overlay_heading_hover',
            [
                'label'                 => __( 'Overlay', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
            ]
        );
			
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'image_overlay_hover',
                'label'                 => __( 'Overlay', 'blank-elements-pro' ),
                'types'                 => [ 'none','classic','gradient' ],
                'selector'              => '{{WRAPPER}} .blank-instagram-feed .blank-feed-item:hover:before',
            ]
        );
        
        $this->add_control(
            'image_overlay_opacity_hover',
            [
                'label'                 => __( 'Overlay Opacity', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => 0.1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed .blank-feed-item:hover:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->add_control(
            'likes_comments_color',
            [
                'label'                 => __( 'Likes and Comments Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-overlay-container' => 'color: {{VALUE}};',
                ],
                'separator'             => 'before'
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Feed Title
         */
        $this->start_controls_section(
            'section_feed_title_style',
            [
                'label'                 => __( 'Feed Title', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );
        
        $this->add_control(
			'feed_title_position',
			[
				'label'                 => __( 'Position', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'default'               => 'middle',
				'options'               => [
					'top'          => [
						'title'    => __( 'Top', 'blank-elements-pro' ),
						'icon'     => 'eicon-v-align-top',
					],
					'middle'       => [
						'title'    => __( 'Middle', 'blank-elements-pro' ),
						'icon'     => 'eicon-v-align-middle',
					],
					'bottom'       => [
						'title'    => __( 'Bottom', 'blank-elements-pro' ),
						'icon'     => 'eicon-v-align-bottom',
					],
				],
				'prefix_class'          => 'blank-insta-title-',
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'feed_title_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .blank-instagram-feed-title',
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->start_controls_tabs( 'tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->add_control(
            'title_color_normal',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed-title-wrap a' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->add_control(
            'title_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed-title-wrap' => 'background: {{VALUE}};',
                ],
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'title_border_normal',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-instagram-feed-title-wrap'
			]
		);

		$this->add_control(
			'title_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-instagram-feed-title-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed-title-wrap a:hover' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

        $this->add_control(
            'title_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-instagram-feed-title-wrap:hover' => 'background: {{VALUE}};',
                ],
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'title_border_hover',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-instagram-feed-title-wrap:hover'
			]
		);

		$this->add_control(
			'title_border_radius_hover',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-instagram-feed-title-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

		$this->add_control(
			'title_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-instagram-feed-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'insta_profile_link' => 'yes',
				],
                'separator'             => 'before',
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_load_more_button_style',
            [
                'label'                 => __( 'Load More Button', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
            'button_alignment',
            [
                'label'                 => __( 'Alignment', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::CHOOSE,
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
				'default'               => 'center',
				'selectors'             => [
					'{{WRAPPER}} .blank-load-more-button-wrap' => 'text-align: {{VALUE}};',
				],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);
        
        $this->add_control(
            'button_top_spacing',
            [
                'label'                 => __( 'Top Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 20 ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => ['px'],
				'selectors'             => [
					'{{WRAPPER}} .blank-load-more-button-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

		$this->add_control(
			'button_size',
			[
				'label'                 => __( 'Size', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'md',
				'options'               => [
					'xs' => __( 'Extra Small', 'blank-elements-pro' ),
					'sm' => __( 'Small', 'blank-elements-pro' ),
					'md' => __( 'Medium', 'blank-elements-pro' ),
					'lg' => __( 'Large', 'blank-elements-pro' ),
					'xl' => __( 'Extra Large', 'blank-elements-pro' ),
				],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-load-more-button' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-load-more-button' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-load-more-button',
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-load-more-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .blank-load-more-button',
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-load-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .blank-load-more-button',
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);
        
        $this->add_control(
            'load_more_button_icon_heading',
            [
                'label'                 => __( 'Button Icon', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
                'condition'             => [
					'load_more_button'  => 'yes',
                    'button_icon!' => '',
                ],
            ]
        );

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'                 => __( 'Margin', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'       => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
                'condition'             => [
					'load_more_button'  => 'yes',
                    'button_icon!' => '',
                ],
				'selectors'             => [
					'{{WRAPPER}} .blank-info-box .blank-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-load-more-button:hover' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-load-more-button:hover' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-load-more-button:hover' => 'border-color: {{VALUE}}',
                ],
				'condition'             => [
					'load_more_button'  => 'yes',
				],
            ]
        );

		$this->add_control(
			'button_animation',
			[
				'label'                 => __( 'Animation', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .blank-load-more-button:hover',
				'condition'             => [
					'load_more_button'  => 'yes',
				],
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
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
                        'authentication'  => _( 'Login Status', 'configurator-blocks' ),
                        'user'  => _( 'Current User', 'configurator-blocks' ),
                        'role'  => _( 'User Role', 'configurator-blocks' ),
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
                        'is'  => _( 'Is', 'configurator-blocks' ),
                        'is_not'  => _( 'Is Not', 'configurator-blocks' ),
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
                        'authenticated'  => _( 'Logged in', 'configurator-blocks' ),
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
                        'administrator'  => _( 'Administrator', 'configurator-blocks' ),
                        'editor'  => _( 'Editor', 'configurator-blocks' ),
                        'author'  => _( 'Author', 'configurator-blocks' ),
                        'contributor'  => _( 'Contributor', 'configurator-blocks' ),
                        'subscriber'  => _( 'Subscriber', 'configurator-blocks' )
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
	 * Render promo box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings();
        
        $this->add_render_attribute( 'insta-feed-wrap', 'class', [
                'blank-instagram-feed',
                'blank-instagram-feed-grid',
                'clearfix',
                'blank-instagram-feed-' . $settings['content_visibility']
            ]
        );

        if ( $settings['grid_cols'] ) {
            $this->add_render_attribute( 'insta-feed-wrap', 'class', 'blank-instagram-feed-grid-' . $settings['grid_cols'] );
        }

        if ( $settings['insta_image_grayscale'] == 'yes' ) {
            $this->add_render_attribute( 'insta-feed-wrap', 'class', 'blank-instagram-feed-gray' );
        }

        if ( $settings['insta_image_grayscale_hover'] == 'yes' ) {
            $this->add_render_attribute( 'insta-feed-wrap', 'class', 'blank-instagram-feed-hover-gray' );
        }
        
        $this->add_render_attribute( 'insta-feed-container', 'class', 'blank-instafeed' );
        
        $this->add_render_attribute( 'insta-feed', 'id', 'blank-instafeed-' . esc_attr( $this->get_id() ) );

        $this->add_render_attribute( 'insta-feed-inner', 'class', 'blank-insta-feed-inner' );
        
        if ( ! empty( $settings['insta_profile_url']['url'] ) ) {
            $this->add_render_attribute( 'instagram-profile-link', 'href', $settings['insta_profile_url']['url'] );

            if ( ! empty( $settings['insta_profile_url']['is_external'] ) ) {
                $this->add_render_attribute( 'instagram-profile-link', 'target', '_blank' );
            }
        }
        
        $pp_widget_options = [
            'user_id'           => ! empty( $settings['user_id'] ) ? $settings['user_id'] : '',
            'access_token'      => ! empty( $settings['access_token'] ) ? $settings['access_token'] : '',
            'sort_by'           => ! empty( $settings['sort_by'] ) ? $settings['sort_by'] : '',
            'images_count'      => ! empty( $settings['images_count']['size'] ) ? $settings['images_count']['size'] : '3',
            'target'            => 'blank-instafeed-'. esc_attr( $this->get_id() ),
            'resolution'        => ! empty( $settings['resolution'] ) ? $settings['resolution'] : '',
            'popup'             => ( $settings['insta_image_popup'] == 'yes' ) ? '1' : '0',
            'likes'             => ( $settings['insta_likes'] == 'yes' ) ? '1' : '0',
            'comments'          => ( $settings['insta_comments'] == 'yes' ) ? '1' : '0',
            'layout'            => 'grid',
        ];
        // wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
                          ?>
                          <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                              <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                                  <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                                      <span class="blank-instagram-feed-title-wrap">
                                          <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                              <span class="blank-instagram-feed-title">
                                                  <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                      <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                                          <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                      <?php } ?>
                                                  <?php } ?>
                                                  <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                                  <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                      <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                                          <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                      <?php } ?>
                                                  <?php } ?>
                                              </span>
                                          </a>
                                      </span>
                                  <?php } ?>
                              <?php } ?>
                              
                              <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                                  <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                                      <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                                  </div>
                                  <?php
                                      $this->render_load_more_button();
                                  ?>
                              </div>
                          </div>
                          <?php
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
                           ?>
                           <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                               <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                                   <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                                       <span class="blank-instagram-feed-title-wrap">
                                           <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                               <span class="blank-instagram-feed-title">
                                                   <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                       <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                                           <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                       <?php } ?>
                                                   <?php } ?>
                                                   <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                                   <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                       <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                                           <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                       <?php } ?>
                                                   <?php } ?>
                                               </span>
                                           </a>
                                       </span>
                                   <?php } ?>
                               <?php } ?>
                               
                               <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                                   <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                                       <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                                   </div>
                                   <?php
                                       $this->render_load_more_button();
                                   ?>
                               </div>
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
                               <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                                   <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                                       <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                                           <span class="blank-instagram-feed-title-wrap">
                                               <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                                   <span class="blank-instagram-feed-title">
                                                       <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                           <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                                               <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                           <?php } ?>
                                                       <?php } ?>
                                                       <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                                       <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                           <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                                               <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                           <?php } ?>
                                                       <?php } ?>
                                                   </span>
                                               </a>
                                           </span>
                                       <?php } ?>
                                   <?php } ?>
                                   
                                   <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                                       <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                                           <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                                       </div>
                                       <?php
                                           $this->render_load_more_button();
                                       ?>
                                   </div>
                               </div>
                               <?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
                                ?>
                                <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                                    <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                                        <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                                            <span class="blank-instagram-feed-title-wrap">
                                                <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                                    <span class="blank-instagram-feed-title">
                                                        <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                            <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                                                <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                                        <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                            <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                                                <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </span>
                                                </a>
                                            </span>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                    <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                                        <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                                            <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                                        </div>
                                        <?php
                                            $this->render_load_more_button();
                                        ?>
                                    </div>
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
                               <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                                   <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                                       <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                                           <span class="blank-instagram-feed-title-wrap">
                                               <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                                   <span class="blank-instagram-feed-title">
                                                       <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                           <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                                               <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                           <?php } ?>
                                                       <?php } ?>
                                                       <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                                       <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                           <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                                               <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                           <?php } ?>
                                                       <?php } ?>
                                                   </span>
                                               </a>
                                           </span>
                                       <?php } ?>
                                   <?php } ?>
                                   
                                   <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                                       <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                                           <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                                       </div>
                                       <?php
                                           $this->render_load_more_button();
                                       ?>
                                   </div>
                               </div>
                               <?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
                                ?>
                                <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                                    <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                                        <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                                            <span class="blank-instagram-feed-title-wrap">
                                                <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                                    <span class="blank-instagram-feed-title">
                                                        <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                            <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                                                <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                                        <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                                            <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                                                <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </span>
                                                </a>
                                            </span>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                    <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                                        <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                                            <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                                        </div>
                                        <?php
                                            $this->render_load_more_button();
                                        ?>
                                    </div>
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
            <div <?php echo $this->get_render_attribute_string( 'insta-feed-wrap' ); ?> data-settings='<?php echo wp_json_encode( $pp_widget_options ); ?>'>
                <?php if ( $settings['insta_profile_link'] == 'yes' ) { ?>
                    <?php if ( ! empty( $settings['insta_link_title'] ) ) { ?>
                        <span class="blank-instagram-feed-title-wrap">
                            <a <?php echo $this->get_render_attribute_string( 'instagram-profile-link' ); ?>>
                                <span class="blank-instagram-feed-title">
                                    <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                        <?php if ( $settings['insta_title_icon_position'] == 'before_title' ) { ?>
                                            <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php echo esc_attr( $settings[ 'insta_link_title' ] ); ?>
                                    <?php if ( ! empty( $settings['insta_title_icon'] ) ) { ?>
                                        <?php if ( $settings['insta_title_icon_position'] == 'after_title' ) { ?>
                                            <span class="<?php echo esc_attr( $settings['insta_title_icon'] ); ?>" aria-hidden="true"></span>
                                        <?php } ?>
                                    <?php } ?>
                                </span>
                            </a>
                        </span>
                    <?php } ?>
                <?php } ?>
                
                <div <?php echo $this->get_render_attribute_string( 'insta-feed-inner' ); ?>>
                    <div <?php echo $this->get_render_attribute_string( 'insta-feed-container' ); ?>>
                        <div <?php echo $this->get_render_attribute_string( 'insta-feed' ); ?>></div>
                    </div>
                    <?php
                        $this->render_load_more_button();
                    ?>
                </div>
            </div>
            <?php
             
		}//end
      
    }

    /**
	 * Render load more button output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_load_more_button() {
        $settings = $this->get_settings();
        
        $this->add_render_attribute( 'load-more-button', 'class', [
				'blank-load-more-button',
				'elementor-button',
				'elementor-size-' . $settings['button_size'],
			]
		);

		if ( $settings['button_animation'] ) {
			$this->add_render_attribute( 'load-more-button', 'class', 'elementor-animation-' . $settings['button_animation'] );
		}

        if ( $settings['load_more_button'] == 'yes' ) { ?>
            <div class="blank-load-more-button-wrap">
                <div <?php echo $this->get_render_attribute_string( 'load-more-button' ) ?>>
                    <span class="blank-button-loader"></span>
                    <span class="blank-load-more-button-text">
                        <?php echo $settings['load_more_button_text']; ?>
                    </span>
                </div>
            </div>
        <?php }
    }

    protected function content_template() {}

}