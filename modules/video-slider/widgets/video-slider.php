<?php
namespace BlankElementsPro\Modules\VideoSlider\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Video_Slider extends Widget_Base {
    public function get_name() {
        return 'blank-video-slider';
    }

    public function get_title() {
		return __( 'Video Slider', 'blank-elements-pro' );
	}

    public function get_categories() {
        return [ 'blank-elements-widgets'];
    }

    public function get_icon() {
        return 'eicon-video-playlist';
    }
	public function get_script_depends() {
		return [ 'blank-slick', 'video-slider-js' ];
	}
	public function get_styles_depends() {
		return [ 'video-slider' ];
	}
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Slider', 'blank-elements-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		
        $repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'video_type',
			[
				'label' => __( 'Type', 'blank-elements-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'youtube' => [
						'title' => __( 'YouTube', 'blank-elements-pro' ),
						'icon' => 'fa fa-youtube',
					],
					'vimeo' => [
						'title' => __( 'Vimeo', 'blank-elements-pro' ),
						'icon' => 'fa fa-vimeo',
					],
					
				],
				'default' => 'url',
				'toggle' => true,
			]
		);
        $repeater->add_control(
			'video_url',
			[
				'label' => __( 'URL', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
					'video_type' => 'url'
				],
				'placeholder' => __( 'https://your-link.com', 'blank-elements-pro' ),
			]
		);
        $repeater->add_control(
			'video_youtube',
			[
				'label' => __( 'YouTube', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
					'video_type' => 'youtube'
				],
                'default' => __( 'https://www.youtube.com/watch?v=NpEaa2P7qZI', 'blank-elements-pro' ),
				'placeholder' => __( 'https://www.youtube.com/watch?v=NpEaa2P7qZI', 'blank-elements-pro' ),
			]
		);

		$repeater->add_control(
			'video_vimeo',
			[
				'label' => __( 'Vimeo', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
					'video_type' => 'vimeo'
				],
                'default' => __( 'https://vimeo.com/235215203', 'blank-elements-pro' ),
				'placeholder' => __( 'https://vimeo.com/235215203', 'blank-elements-pro' ),
			]
		);


        $this->add_control(
			'video_list',
			[
				'label' => __( 'Video Lists', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => 'Slider',
			]
		);
        $this->end_controls_section();
		// Slider Control
		$this->start_controls_section(
            'video_slider_control',
            [
                'label' => __( 'Controls', 'blank-elements-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'show_arrow',
			[
				'label' => __( 'Arrow', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blank-elements-pro' ),
				'label_off' => __( 'Hide', 'blank-elements-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'show_dots',
			[
				'label' => __( 'Dots', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blank-elements-pro' ),
				'label_off' => __( 'Hide', 'blank-elements-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'blank-elements-pro' ),
				'label_off' => __( 'No', 'blank-elements-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Auto Play', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'blank-elements-pro' ),
				'label_off' => __( 'No', 'blank-elements-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'pauseonhover',
			[
				'condition' => [
					'autoplay' => 'yes'
				],
				'label' => __( 'Pause On Hover', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'blank-elements-pro' ),
				'label_off' => __( 'No', 'blank-elements-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);



		$this->add_control(
			'autoplaySpeed',
			[
				'condition' => [
					'autoplay' => 'yes'
				],
				'label' => __( 'Auto Play Speed (ms)', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'min' => 0,
					'max' => 1000,
					'step' => 1,
				],
				
			]
		);
		$this->add_control(
			'slidesToShow',
			[
				'label' => __( 'Slides To Show', 'blank-elements-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'slidesToShow_desktop',
			[
				'label' => _( '<i class="fa fa-desktop" aria-hidden="true"></i>', 'blank-elements-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 4,

			]
		);
		$this->add_control(
			'slidesToShow_tablet',
			[
				'label' => _( '<i class="fa fa-tablet" aria-hidden="true"></i>', 'blank-elements-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 2,
			]
		);
		$this->add_control(
			'slidesToShow_mobile',
			[
				'label' => _( '<i class="fa fa-mobile" aria-hidden="true"></i>', 'blank-elements-pro' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 1,
			]
		);
		
		$this->add_control(
			'slidesToScroll',
			[
				'label' => _( 'Slide To Scroll', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'min' => 0,
					'max' => 10,
				]
				
			]
		);
		$this->add_responsive_control(
			'slidespace',
			[
				'label' => __( 'Slide Spacing(px)', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
				],
				'tablet_default' => [
					'size' => '',
				],
				'mobile_default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .video-slider-slide' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_section();
		// Slider Skin
		$this->start_controls_section(
            'slider_skin',
            [
                'label' => __( 'Skin', 'blank-elements-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
			'slider_skins',
			[
				'label' => esc_html__( 'Slider Skins', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'blank-elements-pro' ),
					'style1' => esc_html__( 'Style 1', 'blank-elements-pro' ),
					'style2' => esc_html__( 'Style 2', 'blank-elements-pro' ),
					'style3' => esc_html__( 'Style 3', 'blank-elements-pro' ),
				],
			]
		);
		$this->end_controls_section();

		// slider style
		$this->start_controls_section(
			'arrows_style',
			[
				'label' => esc_html__( 'Arrow', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'arrow_style_type',
			[
				'label' => esc_html__( 'Arrow Type', 'blank-elements-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text' => [
						'title' => esc_html__( 'Text', 'blank-elements-pro' ),
						'icon' => 'eicon-t-letter-bold',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'blank-elements-pro' ),
						'icon' => ' eicon-arrow-circle-left',
					],

				],
				'default' => 'text',
				'toggle' => true,
			]
		);
		$this->add_control(
			'icon_style',
			[
				'condition' => [
					'arrow_style_type' => 'icon'
				],
				'label' => esc_html__( 'Icon Style', 'blank-elements-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'style1' => [
						'title' => esc_html__( 'Style 1', 'blank-elements-pro' ),
						'icon' => 'eicon-chevron-right',
					],
					'style2' => [
						'title' => esc_html__( 'Style 2', 'blank-elements-pro' ),
						'icon' => 'eicon-arrow-circle-left',
					],
					'style3' => [
						'title' => esc_html__( 'Style 3', 'blank-elements-pro' ),
						'icon' => 'eicon-chevron-double-right',
					],
				],
				'default' => 'style1',
				'toggle' => true,
			]
		);
		$this->add_control(
			'icon_size',
			[
				'condition' => [
					'arrow_style_type' => 'icon'
				],
				'label' => esc_html__( 'Icon Size', 'blank-elements-pro' ),
				'type' =>Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .arrow-style-icon .slick-prev::before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .arrow-style-icon .slick-next::before' => 'font-size: {{SIZE}}{{UNIT}};',
				],

			]
		);
		$this->end_controls_section();

		// Dots Style
		$this->start_controls_section(
			'dots_style',
			[
				'label' => esc_html__( 'Dots', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dots_style_type',
			[
				'label' => esc_html__( 'Dots Type', 'blank-elements-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'number' => [
						'title' => esc_html__( 'Number', 'blank-elements-pro' ),
						'icon' => 'eicon-number-field',
					],
					'dots' => [
						'title' => esc_html__( 'Dots', 'blank-elements-pro' ),
						'icon' => ' eicon-circle-o',
					],

				],
				'default' => 'number',
				'toggle' => true,
			]
		);
		$this->add_control(
			'dot_size',
			[
				'condition' => [
					'dots_style_type' => 'dots'
				],
				'label' => esc_html__( 'Dots Size', 'blank-elements-pro' ),
				'type' =>Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .video-slider-elementor-widget.dots_style-circle .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'number_size',
			[
				'condition' => [
					'dots_style_type' => 'number'
				],
				'label' => esc_html__( 'Number Size', 'blank-elements-pro' ),
				'type' =>Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .video-slider-elementor-widget.dots_style-number .slick-dots li button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

    }

	protected function render() {
		$id = $this->get_id();
		$settings = $this->get_settings_for_display();
		// icon style
		$arrow_style_type = ($settings['arrow_style_type']=='text')?'arrow-style-text':'arrow-style-icon';
		$icon_style = $settings['icon_style'];

		// dots style
		$dots_style = ($settings['dots_style_type']=="number")?'dots_style-number':'dots_style-circle';
		
		// slider control
		$arrow =  ($settings['show_arrow']==='yes') ? 'true': 'false';
		$dots = ($settings['show_dots']==='yes') ? 'true': 'false'; 
		$infinite = ($settings['infinite']==='yes') ? 'true': 'false'; 
		$autoplay = ($settings['autoplay']==='yes') ? 'true': 'false'; 
		$pauseonhover = ($settings['pauseonhover']==='yes') ? 'true': 'false'; 
		$autoplayspeed =  $settings['autoplaySpeed']['size'];
		$slidestoshow =  ($settings['slidesToShow_desktop']==null) ? 4 : $settings['slidesToShow_desktop'];
		$slidestoscroll =  $settings['slidesToScroll']['size'];
		$slidespace =  $settings['slidespace']['size'];
		
		// tablet
		$slidestoshow_tab =  ($settings['slidesToShow_tablet']==null) ? 2 : $settings['slidesToShow_tablet'];
		// mobile
		$slidestoshow_mobile =  ($settings['slidesToShow_mobile']==null) ? 1 : $settings['slidesToShow_mobile'];
		

		echo '<div class="video-slider-elementor-widget '.$arrow_style_type.' arrow_style-'.$icon_style.' '.$dots_style.'">';
			// echo '<i class="eicon-chevron-double-left"></i>';
			echo '<div id="'.$id.'_videos_lider" class="video-slider" 
			arrow="'.$arrow.'" 
			dots="'.$dots.'" 
			infinite="'.$infinite.'" 
			autoplay="'.$autoplay.'" 
			pauseonhover="'.$pauseonhover.'" 
			autoplayspeed="'.$autoplayspeed.'" 
			slidestoshow="'.$slidestoshow.'" tab_slidestoshow="'.$slidestoshow_tab.'" mobile_slidestoshow="'.$slidestoshow_mobile.'"
			slidestoscroll="'.$slidestoscroll.'"
			 >';
				foreach (  $settings['video_list'] as $video ) {
					switch ($video['video_type']) {
						case 'url':?>
							<div class="video_url video-slider-slide">
								<iframe src="<?php echo $video['video_url']; ?>"></iframe>
							</div>
							<?php break;
						case 'youtube': ?>
							<div class="video_youtube video-slider-slide">
								<iframe src="<?php echo str_replace("watch?v=","embed/",($video['video_youtube']) ? $video['video_youtube']:'https://www.youtube.com/watch?v=NpEaa2P7qZI')?>"></iframe>
							</div>
							<?php break;
						case 'vimeo':?>
							<!-- https://player.vimeo.com/video/235215203 sample only-->
							<div class="video_vimeo video-slider-slide">
								<iframe src="<?php echo str_replace("https://vimeo.com/","https://player.vimeo.com/video/",$video['video_vimeo']); ?>" ></iframe>
							</div>
							<?php break;
						default:?>
							<div class="video_youtube">
								<iframe src="<?php echo str_replace("watch?v=","embed/",($video['video_youtube']) ? $video['video_youtube']:'https://www.youtube.com/watch?v=NpEaa2P7qZI')?>"></iframe>
							</div>
							<?php break;
					}
				}
			echo '</div>';//.video-slider
		echo '</div>';//.video-slider-elementor-widget
	}
}


