<?php
namespace BlankElementsPro\Modules\PortfolioSlider\Widgets;

use BlankElementsPro\Modules\PortfolioSlider\Skins;

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

class Portfolio_Slider extends Posts_Slider_Base {
    
    public function get_name() {
        return 'blank-portfolio-slider';
    }

    public function get_title() {
        return __( 'Portfolio Slider', 'blank-elements' );
    }

    public function get_categories() {
        return [ 'blank-elements-widgets' ];
    }

    public function get_icon() {
        return 'eicon-posts-group';
    }
    
    /**
	 * Retrieve the list of scripts the magazine slider widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
    public function get_script_depends() {
        return [
			'blank-slick',
            'blank-js'
        ];
    }

	/**
	 * Register Skins.
	 *
	 * @access protected
	 */
	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Classic( $this ) );
	}
}