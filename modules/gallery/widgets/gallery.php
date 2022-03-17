<?php
namespace BlankElementsPro\Modules\Gallery\Widgets;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Gallery extends Widget_Base {
	// public function __construct($data = [], $args = null) {
	// 	parent::__construct($data, $args);
		 

	// 	wp_register_style( 'slick-light', 'https://mreq.github.io/slick-lightbox/dist/slick-lightbox.css', array(), '1.0.0', true );
	// 	wp_register_style( 'slick-style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );   
	// 	wp_register_style( 'slick-light-theme', 'https://mreq.github.io/slick-lightbox/gh-pages/bower_components/slick-carousel/slick/slick-theme.css', array(), '1.0.0', true );
	// 	wp_register_style( 'style-gallery', BLANK_ELEMENTS_PRO_ASSETS_URL.'css/gallery.css');
		

	// 	wp_register_script( 'jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), '1.0.0', true );
    // 	wp_register_script( 'slick-js', 'https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array(), '1.0.0', true );
	// 	wp_register_script( 'script-light', 'https://mreq.github.io/slick-lightbox/dist/slick-lightbox.js', array(), '1.0.0', true );
	// 	wp_register_script( 'script-gallery', BLANK_ELEMENTS_PRO_ASSETS_URL.'js/gallery.js', array(), '1.0.0', true );

	// }

	public function get_style_depends() {
		return [ 
			'slick-light',
			'slick-style',
			'slick-light-theme'
		];
	}
	public function get_script_depends() {
		return [ 
			'jquery',
			'slick-js',
			'script-light',
			'script-gallery'
		 ];
	}

	
    
	public function get_name() {
		return 'blank-gallery';
	}

	public function get_title() {
		return __( 'Gallery', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets' ];
	}

	
    protected function _register_controls() {
				
        $this->start_controls_section(
            'gallery_settings',
            [
                'label'  => __( 'Settings', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
			'gallery_type',
			[
				'label' => __( 'Type', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'single'  => __( 'Single', 'blank-elements-pro' ),
				],
				'default' => 'single',
			]
		);
		$this->add_control(
			'gallery',
			[
				'type' => Controls_Manager::GALLERY,
				'default' => [],
			]
		);
		$this->add_control(
			'order_by',
			[
				'label' => __( 'Order By', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default'  => __( 'Default', 'blank-elements-pro' ),
					'random' => __( 'Random', 'blank-elements-pro' ),
				],
				'default' => 'default',
			]
		);
		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid'  => __( 'Grid', 'blank-elements-pro' ),
					// 'masonry' => __( 'Masonry', 'blank-elements-pro' ),
				],
				'default' => 'grid',
			]
		);
		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'blank-elements-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 4,
			]
		);
		$this->add_control(
			'spacing',
			[
				'label' => __( 'Spacing', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
			]
		);
        $this->end_controls_section();


		// AMP in advanced
		if(get_option('blank-elements-pro')['advanced_f']){
			if(in_array("a m p", get_option('blank-elements-pro')['advanced_f'])){ 
				$this->start_controls_section(
					'amp',
					[
						'label' => __( 'AMP is active', 'plugin-name' ),
						'tab' => Controls_Manager::TAB_ADVANCED,
					]
				);
				$this->add_control(
					'amp_enabled',
					[
						'label' => __( 'Using Accelerated Mobile Pages (AMP) is one way to speed up your webpages for people using mobile devices', 'blank-elements-pro' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
			}
		}

		$this->end_controls_section();
		
		// add advance Display Conditions
		$this->start_controls_section(
			'blank_element_advanced',
			[
				'label' => __( 'Blank Element Rules', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);
		$this->add_control(
			'blank_element_condition',
			[
				'label' => __( 'Rule Condition', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'options' => [
					'yes' => __( 'Yes', 'blank-elements-pro' ),
					'no' => __( 'No', 'blank-elements-pro' ),
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
					'authentication'  => _( 'Login Status', 'blank-elements-pro' ),
					'user'  => _( 'Current User', 'blank-elements-pro' ),
					'role'  => _( 'User Role', 'blank-elements-pro' ),
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
					'is'  => _( 'Is', 'blank-elements-pro' ),
					'is_not'  => _( 'Is Not', 'blank-elements-pro' ),
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
					'authenticated'  => _( 'Logged in', 'blank-elements-pro' ),
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
				'placeholder' => __( 'Current User', 'blank-elements-pro' ),
		
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
					'administrator'  => _( 'Administrator', 'blank-elements-pro' ),
					'editor'  => _( 'Editor', 'blank-elements-pro' ),
					'author'  => _( 'Author', 'blank-elements-pro' ),
					'contributor'  => _( 'Contributor', 'blank-elements-pro' ),
					'subscriber'  => _( 'Subscriber', 'blank-elements-pro' )
				],	
		
			]
		);

		$this->add_control(
			
			'condition_list',
			[
				'label' => __( '', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'condition' => [
					'blank_element_condition' => 'yes'
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
        $settings = $this->get_settings_for_display(); ?>
		
		<div class="blank-elements-gallery-elementor-widget" id="blank-gallery">
			<div class="container">
  				<div class="blank-gallery-slider <?php echo ($settings['layout']=='grid') ? 'row' : 'masonry-'.$settings['columns']; ?>">
					<?php 
					 ($settings['order_by']=='random') ? shuffle($settings['gallery']) : null ;
					 switch ($settings['columns']) {
						case 1:
							$col = 12;
							break;
						case 2:
							$col = 6;
							break;
						case 3:
							$col = 4;
							break;
						case 4:

							$col = 3;
							break;
						case 5:
							$col = 2;
							break;
						case 6:
							$col = 2;
							break;
						 default:
							 $col = null;
							 break;
					 }

					 foreach ( $settings['gallery'] as $image ) { ?>
					 	<?php if($settings['layout']=='grid'){?>
							<div class="<?php if($settings['columns']==5){echo ' w-20';}else{echo($col == null ) ? null : ' col-'.$col ;} ?>" style="<?php echo ($settings['spacing']['size'] !=null) ? "padding:".$settings['spacing']['size'].$settings['spacing']['unit'] :"padding:0".$settings['spacing']['unit'];?>">
								<img class="test" src="<?php echo $image['url'];?>"  > 
							</div>			
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php 
    }

}
?>