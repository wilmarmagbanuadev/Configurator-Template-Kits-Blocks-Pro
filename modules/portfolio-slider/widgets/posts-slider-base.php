<?php
namespace BlankElementsPro\Modules\PortfolioSlider\Widgets;

use BlankElementsPro\Classes\Blank_Posts_Helper;
// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Posts_Slider_base extends Widget_Base {

	/**
	 * @var \WP_Query
	 */
	protected $query = null;

	protected $_has_template_content = false;

    public function get_icon() {
        return 'eicon-posts-group';
    }

    public function register_query_section_controls() {

        $this->start_controls_section(
            'section_post_query',
            [
                'label'             => __( 'Query', 'blank-elements' ),
            ]
        );
        
        $this->add_control(
            'post_type',
            [
                'label'             => __( 'Post Type', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => Blank_Posts_Helper::get_post_types(),
            ]
        );
        
        $this->add_control(
            'taxonomy_type',
            [
                'label'             => __( 'Taxonomy', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => Blank_Posts_Helper::get_taxonomies_options(),
            ]
        );
        
        $this->add_control(
            'post_count',
            [
                'label'   => __( 'Post Count', 'blank-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 5,
                'min'     => 1,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'             => __( 'Categories', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => Blank_Posts_Helper::get_post_categories(),
            ]
        );

        $this->add_control(
            'authors',
            [
                'label'             => __( 'Authors', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => Blank_Posts_Helper::get_users(),
            ]
        );

        $this->add_control(
            'tags',
            [
                'label'             => __( 'Tags', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => Blank_Posts_Helper::get_post_tags(),
            ]
        );

        $this->add_control(
            'exclude_posts',
            [
                'label'             => __( 'Exclude Posts', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => Blank_Posts_Helper::get_all_posts(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label'             => __( 'Order', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'DESC'           => __( 'Descending', 'blank-elements' ),
                   'ASC'            => __( 'Ascending', 'blank-elements' ),
                ],
                'default'           => 'DESC',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'             => __( 'Order By', 'blank-elements' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'date'           => __( 'Date', 'blank-elements' ),
                   'modified'       => __( 'Last Modified Date', 'blank-elements' ),
                   'rand'           => __( 'Rand', 'blank-elements' ),
                   'comment_count'  => __( 'Comment Count', 'blank-elements' ),
                   'title'          => __( 'Title', 'blank-elements' ),
                   'ID'             => __( 'Post ID', 'blank-elements' ),
                   'author'         => __( 'Post Author', 'blank-elements' ),
                ],
                'default'           => 'date',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'             => __( 'Offset', 'blank-elements' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => '',
            ]
        );

        $this->end_controls_section();
		
	}

    public function register_slider_section_controls() {
        $this->start_controls_section(
            'section_additional_options',
            [
                'label'                 => __( 'Additional Options', 'blank-elements' ),
            ]
        );

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_control(
			'slides_count',
			[
				'type'                  => Controls_Manager::SELECT,
				'label'                 => __( 'Slides', 'blank-elements' ),
				'options'               => $slides_per_view,
				'default'               => '3',
				'frontend_available'    => true,
			]
		);

        $this->add_control(
            'animation_speed',
            [
                'label'                 => __( 'Animation Speed', 'blank-elements' ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 600,
                'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'arrows',
            [
                'label'                 => __( 'Arrows', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
				'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'dots',
            [
                'label'                 => __( 'Dots', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
				'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'autoplay',
            [
                'label'                 => __( 'Autoplay', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'                 => __( 'Autoplay Speed', 'blank-elements' ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 3000,
                'frontend_available'    => true,
                'condition'             => [
                    'autoplay'  => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'pause_on_hover',
            [
                'label'                 => __( 'Pause on Hover', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
                'condition'             => [
                    'autoplay'  => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'infinite_loop',
            [
                'label'                 => __( 'Infinite Loop', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'adaptive_height',
            [
                'label'                 => __( 'Adaptive Height', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'                 => __( 'Direction', 'blank-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => false,
                'toggle'                => false,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> __( 'Left', 'blank-elements' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'right' 		=> [
                        'title' 	=> __( 'Right', 'blank-elements' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
                ],
                'default'               => 'left',
                'frontend_available'    => true,
                'condition'             => [
                    'effect!'       => 'fade',
                ],
            ]
        );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_skin',
			[
				'label' => __( 'Layout', 'blank-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'thumbnail_size',
				'label'                 => __( 'Image Size', 'blank-elements' ),
				'default'               => 'large',
				'exclude'           => [ 'custom' ],
			]
		);

		$this->end_controls_section();
		$this->register_query_section_controls();
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
		$this->register_slider_section_controls();
	}

}