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

		$repeater = new Repeater();
		$repeater->add_control(
			'ds_control_type',
			[
				'label' => __( 'Slider Component', 'blank-elements-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text'  => __( 'Text', 'blank-elements-pro' ),
					'number' => __( 'Number', 'blank-elements-pro' ),
					'textarea ' => __( 'Textarea', 'blank-elements-pro' ),
				],
			]
		);
		$this->add_control(
			'ds_slide_components',
			[
				'label' => __( 'Slide Components', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => 'Slide',
			]
		);

		$this->end_controls_section();
		



		
	}
		protected function render() {

			$settings = $this->get_settings_for_display();
			echo '<div class="dynamic-slider-elementor-widget">';
			echo '<h1>Dynamic Slider</h1>';
			echo "</div>";
		}

}


