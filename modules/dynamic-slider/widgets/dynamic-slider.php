<?php
namespace BlankElementsPro\Modules\DynamicSlider\Widgets;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;



class Dynamic_Slider extends Widget_Base {
	
	public function get_name() {
		return 'blank-dynamic-slider';
	}

	public function get_title() {
		return __( 'Dynamic Slider', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'fa fa-cogs';
	}

	public function get_categories() {
		return [ 'blank-elements-widgets' ];
	}
	protected function _register_controls() {

		$this->start_controls_section(
			'dynamic_slider',
			[
				'label' => __( 'Dynamic Slider', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$options = array();
		$posts = get_posts( array(
			'post_type'  => 'be_dynamic_slider'
		) );

		foreach ( $posts as $key => $post ) {
			$options[$post->ID] = get_the_title($post->ID);
			//$options[get_the_title($post->ID)] = get_the_title($post->ID);
		}
		// check if AMP is activated
		if(get_option('blank-elements-pro')['advanced_f']){
			if(in_array("a m p", get_option('blank-elements-pro')['advanced_f'])){ 
				$this->add_control(
					'ds_control_type',
					[
						'label' => __( 'Select Slider [AMP]', 'blank-elements-pro' ),
						'type' => Controls_Manager::SELECT,
						'label_block'=>true,
						'options' => $options,
					]
				);
			}
		}else{
			$this->add_control(
				'ds_control_type',
				[
					'label' => __( 'Select Slider', 'blank-elements-pro' ),
					'type' => Controls_Manager::SELECT,
					'label_block'=>true,
					'options' => $options,
				]
			);
		}
		

		$this->end_controls_section();
		



		
	}
	
		protected function render() {

			$settings = $this->get_settings_for_display();
			echo '<div class="dynamic-slider-elementor-widget">';
		 ?>
		<amp-img
			alt="A view of the sea"
			src="https://images.pexels.com/photos/10067102/pexels-photo-10067102.jpeg"
			width="450"
			height="500"
			layout="responsive"
		  >
		  </amp-img>
		
	  <?php
			//echo do_shortcode( '[dynamic_slider id='.$settings['ds_control_type'].']' );	
			echo "</div>";
		}

}


