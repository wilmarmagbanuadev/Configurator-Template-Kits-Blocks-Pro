<?php
namespace BlankElementsPro\Modules\PortfolioSlider\Skins;

use BlankElementsPro\Classes\Blank_Posts_Helper;
// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Skin Base
 */
abstract class Skin_Base extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/blank-portfolio-slider/section_skin/before_section_end', [ $this, 'register_layout_controls' ] );
		add_action( 'elementor/element/blank-portfolio-slider/section_post_query/after_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/blank-portfolio-slider/section_post_query/after_section_end', [ $this, 'register_style_sections' ] );
	}

	public function register_style_sections( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_style_controls();
	}

	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_post_settings_controls();
		//$this->register_title_controls();
	}

	public function register_style_controls() {
		$this->register_style_layout_controls();
		$this->register_style_title_controls();
		$this->register_style_content_controls();
		$this->register_style_terms_controls();
		$this->register_style_read_more_controls();
	}
	
    public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;
		
		$this->register_content_layout_controls();
	}

    /**
	 * Register posts slider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function register_content_layout_controls() {
        /**
         * Content Tab: Layout
         */
        
        $this->add_control(
            'post_excerpt',
            [
                'label'                 => __( 'Post Excerpt', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'excerpt_length',
            [
                'label'					=> __( 'Excerpt Length', 'blank-elements' ),
                'type'					=> Controls_Manager::NUMBER,
                'default'				=> 20,
                'min'					=> 0,
                'max'					=> 58,
                'step'					=> 1,
                'condition'				=> [
                    $this->get_control_id( 'post_excerpt' ) => 'yes',
                ]
            ]
        );
        
        $this->add_control(
            'read_more',
            [
                'label'                 => __( 'Read More', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'                 => __( 'Read More Text', 'blank-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( 'Read More', 'blank-elements' ),
                'condition'             => [
                    $this->get_control_id( 'read_more' ) => 'yes',
                ]
            ]
        );
	}
	
	protected function register_post_settings_controls() {
        /**
         * Content Tab: Post Settings
         */
        $this->start_controls_section(
            'section_post_settings',
            [
                'label'             => __( 'Post Settings', 'blank-elements' ),
            ]
        );
        
        $this->add_control(
            'post_title',
            [
                'label'             => __( 'Post Title', 'blank-elements' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Show', 'blank-elements' ),
                'label_off'         => __( 'Hide', 'blank-elements' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'post_thumbnail',
            [
                'label'             => __( 'Post Thumbnail', 'blank-elements' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Show', 'blank-elements' ),
                'label_off'         => __( 'Hide', 'blank-elements' ),
                'return_value'      => 'yes',
            ]
        );
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'              => 'image_size',
				'label'             => __( 'Image Size', 'blank-elements' ),
				'default'           => 'medium_large',
                'condition'         => [
                    'post_thumbnail'  => 'yes'
                ]
			]
		);
        
        $this->add_control(
            'post_category',
            [
                'label'             => __( 'Post Category', 'blank-elements' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'blank-elements' ),
                'label_off'         => __( 'No', 'blank-elements' ),
                'return_value'      => 'yes',
            ]
        );

        $this->end_controls_section();
	}
	
	/**
	 * Content Tab: Title
	 */
	protected function register_title_controls() {
        $this->start_controls_section(
            'section_post_title',
            [
                'label'                 => __( 'Post Title', 'blank-elements' ),
            ]
        );
        
        $this->add_control(
            'post_title',
            [
                'label'                 => __( 'Post Title', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'post_title_link',
            [
                'label'                 => __( 'Link to Post', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'blank-elements' ),
                'label_off'             => __( 'No', 'blank-elements' ),
                'return_value'          => 'yes',
                'condition'             => [
                    $this->get_control_id( 'post_title' ) => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'title_html_tag',
            [
                'label'					=> __( 'HTML Tag', 'blank-elements' ),
                'type'					=> Controls_Manager::SELECT,
                'default'				=> 'h2',
                'options'				=> [
                    'h1'     => __( 'H1', 'blank-elements' ),
                    'h2'     => __( 'H2', 'blank-elements' ),
                    'h3'     => __( 'H3', 'blank-elements' ),
                    'h4'     => __( 'H4', 'blank-elements' ),
                    'h5'     => __( 'H5', 'blank-elements' ),
                    'h6'     => __( 'H6', 'blank-elements' ),
                    'div'    => __( 'div', 'blank-elements' ),
                    'span'   => __( 'span', 'blank-elements' ),
                    'p'      => __( 'p', 'blank-elements' ),
                ],
                'condition'				=> [
                    $this->get_control_id( 'post_title' ) => 'yes',
                ],
            ]
        );
        
        $this->end_controls_section();
	}
	
	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Style Tab: Layout
	 */
	protected function register_style_layout_controls() {
		
        $this->start_controls_section(
            'section_layout_style',
            [
                'label'                 => __( 'Layout', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->end_controls_section();
	}
	
	/**
	 * Style Tab: Title
	 */
	protected function register_style_title_controls() {
        $this->start_controls_section(
            'section_title_style',
            [
                'label'					=> __( 'Post Title', 'blank-elements' ),
                'tab'					=> Controls_Manager::TAB_STYLE,
                'condition'				=> [
					$this->get_control_id( 'post_title' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
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
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .blank-entry-title',
                'condition'             => [
                    $this->get_control_id( 'post_title' ) => 'yes',
                ]
            ]
        );
        
        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'                 => __( 'Margin Bottom', 'blank-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_title' ) => 'yes',
                ]
            ]
        );
        
        $this->end_controls_section();
	}
	
	/**
	 * Style Tab: Post Content
	 */
	protected function register_style_content_controls() {
        $this->start_controls_section(
            'section_content_style',
            [
                'label'					=> __( 'Post Content', 'blank-elements' ),
                'tab'					=> Controls_Manager::TAB_STYLE,
                'condition'				=> [
					$this->get_control_id( 'post_excerpt' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .blank-entry-content' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_excerpt' ) => 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'content_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .blank-entry-content',
                'condition'             => [
                    $this->get_control_id( 'post_excerpt' ) => 'yes',
                ]
            ]
        );
        
        $this->add_responsive_control(
            'content_margin_bottom',
            [
                'label'                 => __( 'Margin Bottom', 'blank-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_excerpt' ) => 'yes',
                ]
            ]
        );
        
        $this->end_controls_section();
	}

	/**
	 * Style Tab: Post Category
	 */
	protected function register_style_terms_controls() {
        $this->start_controls_section(
            'section_terms_style',
            [
                'label'                 => __( 'Post Category', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    $this->get_control_id( 'post_category' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'cat_text_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .post-meta .post-cats a' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_category' ) => 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'cat_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .post-meta .post-cats a',
                'condition'             => [
                    $this->get_control_id( 'post_category' ) => 'yes',
                ]
            ]
        );
        
        $this->add_responsive_control(
            'cat_margin_bottom',
            [
                'label'                 => __( 'Margin Bottom', 'blank-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .post-meta .post-cats a' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'             => [
                    $this->get_control_id( 'post_category' ) => 'yes',
                ]
            ]
        );
        
        $this->end_controls_section();
    }
        
    /**
	 * Style Tab: Read more
	 */
	protected function register_style_read_more_controls() {
        $this->start_controls_section(
            'section_read_more_style',
            [
                'label'                 => __( 'Read More', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    $this->get_control_id( 'read_more' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'read_more_text_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-read-more a' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    $this->get_control_id( 'read_more' ) => 'yes',
                ]
            ]
        );

        $this->add_control(
            'read_more_bg_color',
            [
                'label'                 => __( 'Background Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-portfolio-read-more a' => 'background: {{VALUE}}',
                ],
                'condition'             => [
                    $this->get_control_id( 'read_more' ) => 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'read_more_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .blank-portfolio-read-more a',
                'condition'             => [
                    $this->get_control_id( 'read_more' ) => 'yes',
                ]
            ]
        );
        
        $this->add_control(
			'read_more_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-portfolio-read-more a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    $this->get_control_id( 'read_more' ) => 'yes',
                ]
			]
		);
        
        $this->end_controls_section();
	}
    
	protected function get_tile_post_title() {
		?>
		<h2 class="blank-entry-title">
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>
		<?php
	}
	
	protected function get_tile_post_cats() {
        $settings = $this->parent->get_settings_for_display();
		$bb_post_category = $this->get_instance_value( 'post_category' );
		$bb_custom_category = $settings[ 'taxonomy_type' ];
		
		if ( $bb_post_category == 'yes' ) { ?>
			<div class="post-meta post-meta-top">
				<span class="post-cats">
                    <?php if( !empty ($bb_custom_category) ) {
                        //echo get_the_term_list(get_the_ID(), $bb_custom_category[0], '', ', ', '');
                        echo strip_tags( get_the_term_list( $post->ID, $bb_custom_category[0], '', ', ') );
                    } else {
						// Categories
						$categories = get_the_category();
						$separator = ', ';
						$output = '';
						if( $categories ) {
							foreach( $categories as $category ) {
								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s','blogberg' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
							}
						echo trim( $output, $separator );
						}
                    }
					?>
				</span>
			</div><!--.post-meta-->
		<?php }
	}
	
	protected function get_post_thumbnail() {
		$settings = $this->parent->get_settings();
		
		$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$thumbnail_url = Group_Control_Image_Size::get_attachment_image_src( $thumbnail_id, 'thumbnail_size', $settings );
		
		return $thumbnail_url;
	}
	
	protected function render_post_thumbnail() {
		$bb_post_thumbnail = $this->get_instance_value( 'post_thumbnail' );

		$settings = $this->parent->get_settings();
		$setting_key = $this->get_control_id( 'thumbnail_size' );
		$settings[ $setting_key ] = [
			'id' => get_post_thumbnail_id( get_the_ID() ),
		];
		$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );

		if ( empty( $thumbnail_html ) ) {
			return;
		}
		
		$thumbnail_url = $this->get_post_thumbnail();
		
		$image_settings = array($this->get_instance_value( 'thumbnail_size_size' ));
		
		if ( has_post_thumbnail() && $bb_post_thumbnail == 'yes' ) {?>
			<div class="blank-portfolio-slider-thumbnail blank-portfolio-slider-col">
				<div class="blank-post-image">
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
						<?php //echo $thumbnail_html; ?>
						<img src="<?php echo $thumbnail_url; ?>">
					</a>
				</div>
			</div>
			<?php
		}
	}
	
	protected function render_post_content() {
		$bb_post_excerpt = $this->get_instance_value( 'post_excerpt' );
		$bb_post_read_more = $this->get_instance_value( 'read_more' );
		$bb_post_read_more_text = $this->get_instance_value( 'read_more_text' );
		$bb_post_excerpt_length = $this->get_instance_value( 'excerpt_length' );
		
		if ( $bb_post_excerpt == 'yes' ) {
			?>
			<div class="blank-entry-content entry-content">
				<?php echo Blank_Posts_Helper::custom_excerpt($bb_post_excerpt_length); ?>
			</div>
			<?php
		} if ( $bb_post_read_more == 'yes' ) {
			?>
			<div class="blank-portfolio-read-more">
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                    <?php echo $bb_post_read_more_text; ?>
                </a>
			</div>
			<?php
		} 
	}
	
	protected function render_post_body( $count ) {
        $settings = $this->parent->get_settings_for_display();
		?>
		<div class="blank-portfolio-slider-slide">
			<div class="blank-portfolio-slider-post">
				<div class="blank-portfolio-slider-body blank-portfolio-slider-col">
					<div class="blank-portfolio-slider-header">
						<?php $this->get_tile_post_cats(); ?>

						<?php $this->get_tile_post_title(); ?>
					</div>
					<div class="blank-portfolio-slider-content">
						<?php
							$this->render_post_content();
						?>
					</div>
				</div>
				<?php
					$this->render_post_thumbnail();
				?>
			</div>
		</div><!--.blank-tiled-post-->
		<?php
	}

    /**
	 * Render posts grid widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render() {
        $settings = $this->parent->get_settings();
		
        /*$this->parent->add_render_attribute( 'posts-wrap', 'class', [
			'pp-elementor-grid',
			'pp-posts',
			'pp-posts-skin-' . $this->get_id(),
			'clearfix'
			]
		);
        
        $this->parent->add_render_attribute( 'post-content', 'class', 'pp-post-content' );
        
        $this->parent->add_render_attribute( 'post-categories', 'class', 'pp-post-categories' );*/
        
		$this->parent->add_render_attribute( 'slider', 'class', [
			'blank-portfolio-slider',
			'blank-portfolio-slider-' . $settings['_skin'],
			]
		);
        // wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
                          ?>
                            <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                                <?php
                                    $pcount = 1;

                                    // Post Authors
                                    $bb_post_author = '';
                                    $bb_post_authors = $settings['authors'];
                                    if ( !empty( $bb_post_authors) ) {
                                        $bb_post_author = implode( ",", $bb_post_authors );
                                    }

                                    // Post Categories
                                    $pa_tiled_post_cat = '';
                                    $pa_tiled_post_cats = $settings['categories'];
                                    if ( !empty( $pa_tiled_post_cats) ) {
                                        $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                                    }

                                    // Query Arguments
                                    $args = array(
                                        'post_status'           => 'publish',
                                        'post_type'             => $settings['post_type'],
                                        'post__in'              => '',
                                        'cat'                   => $pa_tiled_post_cat,
                                        'author'                => $bb_post_author,
                                        'tag__in'               => $settings['tags'],
                                        'orderby'               => $settings['orderby'],
                                        'order'                 => $settings['order'],
                                        'post__not_in'          => $settings['exclude_posts'],
                                        'offset'                => $settings['offset'],
                                        'ignore_sticky_posts'   => 1,
                                        'showposts'             => $settings['post_count'],
                                    );
                                    $bb_grid_query = new \WP_Query( $args );

                                    if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
                            
                                        $this->render_post_body( $pcount );

                                        $pcount++;
                                    endwhile;
                                    wp_reset_postdata();
                                    endif;
                                    ?>
                            </div>
                            <div class="slider-progress">
                                <div class="progress"></div>
                            </div>
                            <div class="blank-progress-round">
                                <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                                <svg class="progress">
                                    <circle r="23" cx="23" cy="23"/>
                                </svg>
                        </div>
                            <?php
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
                           ?>
                            <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                                <?php
                                    $pcount = 1;

                                    // Post Authors
                                    $bb_post_author = '';
                                    $bb_post_authors = $settings['authors'];
                                    if ( !empty( $bb_post_authors) ) {
                                        $bb_post_author = implode( ",", $bb_post_authors );
                                    }

                                    // Post Categories
                                    $pa_tiled_post_cat = '';
                                    $pa_tiled_post_cats = $settings['categories'];
                                    if ( !empty( $pa_tiled_post_cats) ) {
                                        $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                                    }

                                    // Query Arguments
                                    $args = array(
                                        'post_status'           => 'publish',
                                        'post_type'             => $settings['post_type'],
                                        'post__in'              => '',
                                        'cat'                   => $pa_tiled_post_cat,
                                        'author'                => $bb_post_author,
                                        'tag__in'               => $settings['tags'],
                                        'orderby'               => $settings['orderby'],
                                        'order'                 => $settings['order'],
                                        'post__not_in'          => $settings['exclude_posts'],
                                        'offset'                => $settings['offset'],
                                        'ignore_sticky_posts'   => 1,
                                        'showposts'             => $settings['post_count'],
                                    );
                                    $bb_grid_query = new \WP_Query( $args );

                                    if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
                            
                                        $this->render_post_body( $pcount );

                                        $pcount++;
                                    endwhile;
                                    wp_reset_postdata();
                                    endif;
                                    ?>
                            </div>
                            <div class="slider-progress">
                                <div class="progress"></div>
                            </div>
                            <div class="blank-progress-round">
                                <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                                <svg class="progress">
                                    <circle r="23" cx="23" cy="23"/>
                                </svg>
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
                                <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                                    <?php
                                        $pcount = 1;

                                        // Post Authors
                                        $bb_post_author = '';
                                        $bb_post_authors = $settings['authors'];
                                        if ( !empty( $bb_post_authors) ) {
                                            $bb_post_author = implode( ",", $bb_post_authors );
                                        }

                                        // Post Categories
                                        $pa_tiled_post_cat = '';
                                        $pa_tiled_post_cats = $settings['categories'];
                                        if ( !empty( $pa_tiled_post_cats) ) {
                                            $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                                        }

                                        // Query Arguments
                                        $args = array(
                                            'post_status'           => 'publish',
                                            'post_type'             => $settings['post_type'],
                                            'post__in'              => '',
                                            'cat'                   => $pa_tiled_post_cat,
                                            'author'                => $bb_post_author,
                                            'tag__in'               => $settings['tags'],
                                            'orderby'               => $settings['orderby'],
                                            'order'                 => $settings['order'],
                                            'post__not_in'          => $settings['exclude_posts'],
                                            'offset'                => $settings['offset'],
                                            'ignore_sticky_posts'   => 1,
                                            'showposts'             => $settings['post_count'],
                                        );
                                        $bb_grid_query = new \WP_Query( $args );

                                        if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
                                
                                            $this->render_post_body( $pcount );

                                            $pcount++;
                                        endwhile;
                                        wp_reset_postdata();
                                        endif;
                                        ?>
                                </div>
                                <div class="slider-progress">
                                    <div class="progress"></div>
                                </div>
                                <div class="blank-progress-round">
                                    <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                                    <svg class="progress">
                                        <circle r="23" cx="23" cy="23"/>
                                    </svg>
                            </div>
                                <?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
                                ?>
                                <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                                    <?php
                                        $pcount = 1;

                                        // Post Authors
                                        $bb_post_author = '';
                                        $bb_post_authors = $settings['authors'];
                                        if ( !empty( $bb_post_authors) ) {
                                            $bb_post_author = implode( ",", $bb_post_authors );
                                        }

                                        // Post Categories
                                        $pa_tiled_post_cat = '';
                                        $pa_tiled_post_cats = $settings['categories'];
                                        if ( !empty( $pa_tiled_post_cats) ) {
                                            $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                                        }

                                        // Query Arguments
                                        $args = array(
                                            'post_status'           => 'publish',
                                            'post_type'             => $settings['post_type'],
                                            'post__in'              => '',
                                            'cat'                   => $pa_tiled_post_cat,
                                            'author'                => $bb_post_author,
                                            'tag__in'               => $settings['tags'],
                                            'orderby'               => $settings['orderby'],
                                            'order'                 => $settings['order'],
                                            'post__not_in'          => $settings['exclude_posts'],
                                            'offset'                => $settings['offset'],
                                            'ignore_sticky_posts'   => 1,
                                            'showposts'             => $settings['post_count'],
                                        );
                                        $bb_grid_query = new \WP_Query( $args );

                                        if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
                                
                                            $this->render_post_body( $pcount );

                                            $pcount++;
                                        endwhile;
                                        wp_reset_postdata();
                                        endif;
                                        ?>
                                </div>
                                <div class="slider-progress">
                                    <div class="progress"></div>
                                </div>
                                <div class="blank-progress-round">
                                    <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                                    <svg class="progress">
                                        <circle r="23" cx="23" cy="23"/>
                                    </svg>
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
                                <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                                    <?php
                                        $pcount = 1;

                                        // Post Authors
                                        $bb_post_author = '';
                                        $bb_post_authors = $settings['authors'];
                                        if ( !empty( $bb_post_authors) ) {
                                            $bb_post_author = implode( ",", $bb_post_authors );
                                        }

                                        // Post Categories
                                        $pa_tiled_post_cat = '';
                                        $pa_tiled_post_cats = $settings['categories'];
                                        if ( !empty( $pa_tiled_post_cats) ) {
                                            $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                                        }

                                        // Query Arguments
                                        $args = array(
                                            'post_status'           => 'publish',
                                            'post_type'             => $settings['post_type'],
                                            'post__in'              => '',
                                            'cat'                   => $pa_tiled_post_cat,
                                            'author'                => $bb_post_author,
                                            'tag__in'               => $settings['tags'],
                                            'orderby'               => $settings['orderby'],
                                            'order'                 => $settings['order'],
                                            'post__not_in'          => $settings['exclude_posts'],
                                            'offset'                => $settings['offset'],
                                            'ignore_sticky_posts'   => 1,
                                            'showposts'             => $settings['post_count'],
                                        );
                                        $bb_grid_query = new \WP_Query( $args );

                                        if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
                                
                                            $this->render_post_body( $pcount );

                                            $pcount++;
                                        endwhile;
                                        wp_reset_postdata();
                                        endif;
                                        ?>
                                </div>
                                <div class="slider-progress">
                                    <div class="progress"></div>
                                </div>
                                <div class="blank-progress-round">
                                    <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                                    <svg class="progress">
                                        <circle r="23" cx="23" cy="23"/>
                                    </svg>
                            </div>
                                <?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
                                ?>
                                <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                                    <?php
                                        $pcount = 1;

                                        // Post Authors
                                        $bb_post_author = '';
                                        $bb_post_authors = $settings['authors'];
                                        if ( !empty( $bb_post_authors) ) {
                                            $bb_post_author = implode( ",", $bb_post_authors );
                                        }

                                        // Post Categories
                                        $pa_tiled_post_cat = '';
                                        $pa_tiled_post_cats = $settings['categories'];
                                        if ( !empty( $pa_tiled_post_cats) ) {
                                            $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                                        }

                                        // Query Arguments
                                        $args = array(
                                            'post_status'           => 'publish',
                                            'post_type'             => $settings['post_type'],
                                            'post__in'              => '',
                                            'cat'                   => $pa_tiled_post_cat,
                                            'author'                => $bb_post_author,
                                            'tag__in'               => $settings['tags'],
                                            'orderby'               => $settings['orderby'],
                                            'order'                 => $settings['order'],
                                            'post__not_in'          => $settings['exclude_posts'],
                                            'offset'                => $settings['offset'],
                                            'ignore_sticky_posts'   => 1,
                                            'showposts'             => $settings['post_count'],
                                        );
                                        $bb_grid_query = new \WP_Query( $args );

                                        if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
                                
                                            $this->render_post_body( $pcount );

                                            $pcount++;
                                        endwhile;
                                        wp_reset_postdata();
                                        endif;
                                        ?>
                                </div>
                                <div class="slider-progress">
                                    <div class="progress"></div>
                                </div>
                                <div class="blank-progress-round">
                                    <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                                    <svg class="progress">
                                        <circle r="23" cx="23" cy="23"/>
                                    </svg>
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
            <div <?php echo $this->parent->get_render_attribute_string( 'slider' ) ?>>
                <?php
                    $pcount = 1;
    
                    // Post Authors
                    $bb_post_author = '';
                    $bb_post_authors = $settings['authors'];
                    if ( !empty( $bb_post_authors) ) {
                        $bb_post_author = implode( ",", $bb_post_authors );
                    }
    
                    // Post Categories
                    $pa_tiled_post_cat = '';
                    $pa_tiled_post_cats = $settings['categories'];
                    if ( !empty( $pa_tiled_post_cats) ) {
                        $pa_tiled_post_cat = implode( ",", $pa_tiled_post_cats );
                    }
    
                    // Query Arguments
                    $args = array(
                        'post_status'           => 'publish',
                        'post_type'             => $settings['post_type'],
                        'post__in'              => '',
                        'cat'                   => $pa_tiled_post_cat,
                        'author'                => $bb_post_author,
                        'tag__in'               => $settings['tags'],
                        'orderby'               => $settings['orderby'],
                        'order'                 => $settings['order'],
                        'post__not_in'          => $settings['exclude_posts'],
                        'offset'                => $settings['offset'],
                        'ignore_sticky_posts'   => 1,
                        'showposts'             => $settings['post_count'],
                    );
                    $bb_grid_query = new \WP_Query( $args );
    
                    if ( $bb_grid_query->have_posts() ) : while ( $bb_grid_query->have_posts() ) : $bb_grid_query->the_post();
            
                        $this->render_post_body( $pcount );
    
                        $pcount++;
                    endwhile;
                    wp_reset_postdata();
                    endif;
                    ?>
            </div>
            <div class="slider-progress">
                <div class="progress"></div>
            </div>
            <div class="blank-progress-round">
                <span class="slider-progress-title"><?php esc_html_e('Next','blank-elements'); ?></span>
                <svg class="progress">
                    <circle r="23" cx="23" cy="23"/>
                </svg>
          </div>
            <?php
		}
        
    }
}