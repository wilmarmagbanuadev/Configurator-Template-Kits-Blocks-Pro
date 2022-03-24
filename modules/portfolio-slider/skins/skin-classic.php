<?php
namespace BlankElementsPro\Modules\PortfolioSlider\Skins;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Classic Skin for Posts widget
 */
class Skin_Classic extends Skin_Base {
    
    /**
	 * Retrieve Skin ID.
	 *
	 * @access public
	 *
	 * @return string Skin ID.
	 */
    public function get_id() {
        return 'classic';
    }

    /**
	 * Retrieve Skin title.
	 *
	 * @access public
	 *
	 * @return string Skin title.
	 */
    public function get_title() {
        return __( 'Classic', 'blank-elements' );
    }

	/**
	 * Register Control Actions.
	 *
	 * @access protected
	 */
	protected function _register_controls_actions() {

		parent::_register_controls_actions();
		
		add_action( 'elementor/element/blank-portfolio-slider/classic_section_layout_style/before_section_end', [ $this, 'add_classic_layout_style_controls' ] );
		add_action( 'elementor/element/blank-portfolio-slider/classic_section_layout_style/after_section_end', [ $this, 'register_overlay_controls' ] );
	}
	
	protected function register_style_title_controls() {
		parent::register_style_title_controls();

        $this->update_control(
            'title_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
				// 'scheme' => [
				// 	'type' => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_2,
				// ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-entry-title a' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_title' ) => 'yes',
                ]
            ]
        );
	}
	
	protected function register_style_terms_controls() {
		parent::register_style_terms_controls();

        $this->update_control(
            'cat_text_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .post-meta .post-cats a' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_category' ) => 'yes',
                ]
            ]
        );
	}
	
	public function register_overlay_controls() {
        $this->start_controls_section(
            'section_overlay',
            [
                'label'             => __( 'Overlay', 'blank-elements' ),
				'tab'					=> Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'overlay_background_color',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .blank-portfolio-slider-classic .blank-portfolio-slider-post:before',
                'exclude'               => [
                    'image',
                ],
			]
		);
		
		$this->end_controls_section();
	}
	
	public function add_classic_layout_style_controls() {
        
        $this->add_responsive_control(
            'posts_height',
            [
                'label'                 => __( 'Height', 'blank-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-slider-post' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		
		$this->add_responsive_control(
            'slide_text_align',
            [
                'label'                 => __( 'Text Align', 'blank-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> __( 'Left', 'blank-elements' ),
                        'icon' 		=> 'fa fa-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> __( 'Center', 'blank-elements' ),
                        'icon' 		=> 'fa fa-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> __( 'Right', 'blank-elements' ),
                        'icon' 		=> 'fa fa-align-right',
                    ],
                ],
                'default'               => 'center',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-slider-post' => 'text-align: {{VALUE}};',
                ],
            ]
        );
	}
	
	protected function render_post_body( $count ) {
        $settings = $this->parent->get_settings_for_display();
		
		$thumbnail_url = $this->get_post_thumbnail();
		?>
		<div class="blank-portfolio-slider-slide">
			<div class="blank-portfolio-slider-post" style="background-image:url(<?php echo esc_url($thumbnail_url); ?>);">
				<div class="blank-portfolio-slider-body">
					<div class="blank-portfolio-slider-header">
						<?php $this->get_tile_post_cats(); ?>

						<?php $this->get_tile_post_title(); ?>
					</div>
					<div class="blank-portfolio-slider-content">

						<?php $this->render_post_content(); ?>

					</div>
				</div>
			</div>
		</div><!--.blank-tiled-post-->
		<?php
	}
}