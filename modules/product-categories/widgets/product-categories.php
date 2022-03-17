<?php
namespace BlankElementsPro\Modules\ProductCategories\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Product_Categories extends Widget_Base {

	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-product-categories';
	}

	public function get_title() {
		return __( 'Product Categories', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-pro-widgets'];
	}
	
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label'					=> __( 'Categories', 'blank-elements-pro' ),
			]
		);

        $this->add_responsive_control(
            'columns',
            [
                'label'                 => __( 'Columns', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '2',
                'mobile_default'        => '1',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'hide_empty',
            [
                'label'                 => __( 'Hide Empty Categories', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'return_value'          => 'yes',
            ]
        );
		
		$this->add_control(
			'limit_cats',
			[
				'label'					=> __( 'Categories Count', 'blank-elements-pro' ),
				'description'			=> __( 'Enter number of categories to show.', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::NUMBER,
				'min'					=> 0,
				'step'					=> 1,
			]
		);
		
		$this->end_controls_section();

        /**
         * STYLE TAB
         * -------------------------------------------------
         * Add all style related settings below
         */

        $this->start_controls_section(
            'section_layout_style',
            [
                'label'             => __( 'Layout', 'blank-elements-pro' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'items_horizontal_spacing',
            [
                'label'                 => __( 'Column Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size' 	=> '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-categories .blank-grid-item-wrap' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blank-categories .blank-elementor-grid' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_vertical_spacing',
            [
                'label'                 => __( 'Row Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size'  => '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-categories .blank-grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
		
		$this->start_controls_section(
			'section_image_style',
			[
				'label'					=> __( 'Image', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
            'image_height',
            [
                'label'                 => __( 'Height', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 600,
                    ],
                ],
                'default'               => [
                    'size'  => '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-categories .blank-grid-item' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'image_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-categories .blank-grid-item',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-categories .blank-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
		
		$this->start_controls_section(
			'section_cat_title_style',
			[
				'label'					=> __( 'Category Name', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'cat_title_color',
            [
                'label'             => __( 'Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-cat-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cat_title_color_hover',
            [
                'label'             => __( 'Hover Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-grid-item:hover .blank-cat-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'cat_name_typography',
                'label'             => __( 'Typography', 'blank-elements-pro' ),
                'selector'          => '{{WRAPPER}} .blank-cat-title',
            ]
        );
        
        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'                 => __( 'Margin Bottom', 'blank-elements-pro' ),
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
                    '{{WRAPPER}} .blank-cat-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_read_more_style',
			[
				'label'					=> __( 'See More Text', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'read_more_typography',
                'label'             => __( 'Typography', 'blank-elements-pro' ),
                'selector'          => '{{WRAPPER}} .blank-product-cat-read-more',
            ]
        );

        $this->start_controls_tabs( 'tabs_read_more_style' );

        $this->start_controls_tab(
            'tab_read_more_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label'             => __( 'Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-product-cat-read-more' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_read_more_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'read_more_color_hover',
            [
                'label'             => __( 'Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-grid-item:hover .blank-product-cat-read-more' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_overlay_style',
			[
				'label'					=> __( 'Overlay', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'tabs_overlay_style' );

        $this->start_controls_tab(
            'tab_overlay_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'cat_overlay',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .blank-media-overlay',
                'exclude'               => [
                    'image',
                ],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_overlay_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'cat_overlay_hover',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .blank-grid-item:hover .blank-media-overlay',
                'exclude'               => [
                    'image',
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
		
	protected function render() {
		$settings = $this->get_settings();
		?>
		<div class="blank-categories">
			<?php
				$limit_cats = $settings['limit_cats'];           
                $taxonomy     = 'product_cat';
                $orderby      = 'name';  
                $show_count   = 0;      // 1 for yes, 0 for no
                $pad_counts   = 0;      // 1 for yes, 0 for no
                $hierarchical = 1;      // 1 for yes, 0 for no  
                $title        = '';  
                $empty        = $settings['hide_empty'];

                $args = array(
                     'taxonomy'     => $taxonomy,
                     'orderby'      => $orderby,
                     'number'       => $limit_cats,
                     'show_count'   => $show_count,
                     'pad_counts'   => $pad_counts,
                     'hierarchical' => $hierarchical,
                     'title_li'     => $title,
                     'hide_empty'   => $empty
                );

                $bb_cats = get_categories( $args );
                // wrap  orginal to variable
        if($settings['configurator_block_condition']=='yes'){
            foreach (  $settings['condition_list'] as $item ) {
                switch ($item['condition_key']) {
                    case 'authentication':
                        if($item['is_not']=='is' && is_user_logged_in()){
                          // show original here
                          ?>
                          <ul class="blank-elementor-grid">
                          <?php
                                foreach( $bb_cats as $cat ) {
                                    $category_ID = $cat->cat_ID;
                                    
                                    $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                                    $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                                    
                                    if ( $shop_catalog_img[0] ) {
                                        $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                                    } else {
                                        $bb_cat_bg = '';
                                    }
                                    
                                    ?>
                                    <li class="blank-grid-item-wrap">
                                        <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                            <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                            </a>
                                            <div class="blank-media-overlay"></div>
                                            <div class="cats-widget-text transition">
                                                <div class="blank-cat-title">
                                                    <?php
                                                        echo esc_attr( $cat->name );
                                                    ?>
                                                </div>
                                                <div class="blank-product-cat-read-more">
                                                    <?php esc_html_e('See more','blank-elements-pro'); ?>
                                                    <span class="flaticon flaticon-right"></span>
                                                </div>
                                                <!--<span class="blank-cat-posts-count">
                                                    <?php
                                                        /*$bb_cat_count = $cat->category_count;
            
                                                        $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );
            
                                                        echo esc_attr( $bb_cat_posts_count );*/
                                                    ?>
                                                </span>-->
                                            </div>
                                        </div>
                                    </li><?php
                                }
                            ?>
                            </ul>
                    </div>
                    <?php
                        }elseif($item['is_not']=='is_not' && !is_user_logged_in()){
                           // show original here
                           ?>
                           <ul class="blank-elementor-grid">
                           <?php
                                foreach( $bb_cats as $cat ) {
                                    $category_ID = $cat->cat_ID;
                                    
                                    $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                                    $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                                    
                                    if ( $shop_catalog_img[0] ) {
                                        $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                                    } else {
                                        $bb_cat_bg = '';
                                    }
                                    
                                    ?>
                                    <li class="blank-grid-item-wrap">
                                        <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                            <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                            </a>
                                            <div class="blank-media-overlay"></div>
                                            <div class="cats-widget-text transition">
                                                <div class="blank-cat-title">
                                                    <?php
                                                        echo esc_attr( $cat->name );
                                                    ?>
                                                </div>
                                                <div class="blank-product-cat-read-more">
                                                    <?php esc_html_e('See more','blank-elements-pro'); ?>
                                                    <span class="flaticon flaticon-right"></span>
                                                </div>
                                                <!--<span class="blank-cat-posts-count">
                                                    <?php
                                                        /*$bb_cat_count = $cat->category_count;
            
                                                        $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );
            
                                                        echo esc_attr( $bb_cat_posts_count );*/
                                                    ?>
                                                </span>-->
                                            </div>
                                        </div>
                                    </li><?php
                                }
                            ?>
                            </ul>
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
                               <ul class="blank-elementor-grid">
                                <?php
                                    foreach( $bb_cats as $cat ) {
                                        $category_ID = $cat->cat_ID;
                                        
                                        $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                                        $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                                        
                                        if ( $shop_catalog_img[0] ) {
                                            $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                                        } else {
                                            $bb_cat_bg = '';
                                        }
                                        
                                        ?>
                                        <li class="blank-grid-item-wrap">
                                            <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                                <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                                </a>
                                                <div class="blank-media-overlay"></div>
                                                <div class="cats-widget-text transition">
                                                    <div class="blank-cat-title">
                                                        <?php
                                                            echo esc_attr( $cat->name );
                                                        ?>
                                                    </div>
                                                    <div class="blank-product-cat-read-more">
                                                        <?php esc_html_e('See more','blank-elements-pro'); ?>
                                                        <span class="flaticon flaticon-right"></span>
                                                    </div>
                                                    <!--<span class="blank-cat-posts-count">
                                                        <?php
                                                            /*$bb_cat_count = $cat->category_count;
                
                                                            $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );
                
                                                            echo esc_attr( $bb_cat_posts_count );*/
                                                        ?>
                                                    </span>-->
                                                </div>
                                            </div>
                                        </li><?php
                                    }
                                ?>
                                </ul>
                        </div>
                        <?php
                            }
                        }elseif($item['is_not']=='is_not'){
                            if($current_user!=$item['current_user']){
                                // show original here
                                ?>
                                    <ul class="blank-elementor-grid">
                                    <?php
                                        foreach( $bb_cats as $cat ) {
                                            $category_ID = $cat->cat_ID;
                                            
                                            $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                                            $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                                            
                                            if ( $shop_catalog_img[0] ) {
                                                $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                                            } else {
                                                $bb_cat_bg = '';
                                            }
                                            
                                            ?>
                                            <li class="blank-grid-item-wrap">
                                                <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                                    <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                                    </a>
                                                    <div class="blank-media-overlay"></div>
                                                    <div class="cats-widget-text transition">
                                                        <div class="blank-cat-title">
                                                            <?php
                                                                echo esc_attr( $cat->name );
                                                            ?>
                                                        </div>
                                                        <div class="blank-product-cat-read-more">
                                                            <?php esc_html_e('See more','blank-elements-pro'); ?>
                                                            <span class="flaticon flaticon-right"></span>
                                                        </div>
                                                        <!--<span class="blank-cat-posts-count">
                                                            <?php
                                                                /*$bb_cat_count = $cat->category_count;
                    
                                                                $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );
                    
                                                                echo esc_attr( $bb_cat_posts_count );*/
                                                            ?>
                                                        </span>-->
                                                    </div>
                                                </div>
                                            </li><?php
                                        }
                                    ?>
                                    </ul>
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
                                <ul class="blank-elementor-grid">
                                <?php
                                    foreach( $bb_cats as $cat ) {
                                        $category_ID = $cat->cat_ID;
                                        
                                        $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                                        $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                                        
                                        if ( $shop_catalog_img[0] ) {
                                            $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                                        } else {
                                            $bb_cat_bg = '';
                                        }
                                        
                                        ?>
                                        <li class="blank-grid-item-wrap">
                                            <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                                <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                                </a>
                                                <div class="blank-media-overlay"></div>
                                                <div class="cats-widget-text transition">
                                                    <div class="blank-cat-title">
                                                        <?php
                                                            echo esc_attr( $cat->name );
                                                        ?>
                                                    </div>
                                                    <div class="blank-product-cat-read-more">
                                                        <?php esc_html_e('See more','blank-elements-pro'); ?>
                                                        <span class="flaticon flaticon-right"></span>
                                                    </div>
                                                    <!--<span class="blank-cat-posts-count">
                                                        <?php
                                                            /*$bb_cat_count = $cat->category_count;
                
                                                            $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );
                
                                                            echo esc_attr( $bb_cat_posts_count );*/
                                                        ?>
                                                    </span>-->
                                                </div>
                                            </div>
                                        </li><?php
                                    }
                                ?>
                                </ul>
                        </div>
                        <?php
                            }
                            
						}elseif($item['is_not']=='is_not'){
							if($item['user_role']!=$user_role){
                                // show original here
                                ?>
                                <ul class="blank-elementor-grid">
                                <?php
                                    foreach( $bb_cats as $cat ) {
                                        $category_ID = $cat->cat_ID;
                                        
                                        $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                                        $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                                        
                                        if ( $shop_catalog_img[0] ) {
                                            $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                                        } else {
                                            $bb_cat_bg = '';
                                        }
                                        
                                        ?>
                                        <li class="blank-grid-item-wrap">
                                            <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                                <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                                </a>
                                                <div class="blank-media-overlay"></div>
                                                <div class="cats-widget-text transition">
                                                    <div class="blank-cat-title">
                                                        <?php
                                                            echo esc_attr( $cat->name );
                                                        ?>
                                                    </div>
                                                    <div class="blank-product-cat-read-more">
                                                        <?php esc_html_e('See more','blank-elements-pro'); ?>
                                                        <span class="flaticon flaticon-right"></span>
                                                    </div>
                                                    <!--<span class="blank-cat-posts-count">
                                                        <?php
                                                            /*$bb_cat_count = $cat->category_count;
                
                                                            $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );
                
                                                            echo esc_attr( $bb_cat_posts_count );*/
                                                        ?>
                                                    </span>-->
                                                </div>
                                            </div>
                                        </li><?php
                                    }
                                ?>
                                </ul>
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
                <ul class="blank-elementor-grid">
                <?php
                    foreach( $bb_cats as $cat ) {
                        $category_ID = $cat->cat_ID;
                        
                        $cat_thumb_id = get_term_meta( $category_ID, 'thumbnail_id', true );
                        $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
                        
                        if ( $shop_catalog_img[0] ) {
                            $bb_cat_bg = 'style="background-image:url( '. esc_url( $shop_catalog_img[0] ) .' );"';
                        } else {
                            $bb_cat_bg = '';
                        }
                        
                        ?>
                        <li class="blank-grid-item-wrap">
                            <div class="blank-product-category blank-grid-item" <?php echo $bb_cat_bg; ?>>
                                <a href="<?php echo esc_url( home_url() ); ?>/category/<?php echo trailingslashit( $cat->slug ); ?>">
                                </a>
                                <div class="blank-media-overlay"></div>
                                <div class="cats-widget-text transition">
                                    <div class="blank-cat-title">
                                        <?php
                                            echo esc_attr( $cat->name );
                                        ?>
                                    </div>
                                    <div class="blank-product-cat-read-more">
                                        <?php esc_html_e('See more','blank-elements-pro'); ?>
                                        <span class="flaticon flaticon-right"></span>
                                    </div>
                                    <!--<span class="blank-cat-posts-count">
                                        <?php
                                            /*$bb_cat_count = $cat->category_count;

                                            $bb_cat_posts_count = sprintf( _n( '%s Post', '%s Posts', $bb_cat_count, 'digiters' ), $bb_cat_count );

                                            echo esc_attr( $bb_cat_posts_count );*/
                                        ?>
                                    </span>-->
                                </div>
                            </div>
                        </li><?php
                    }
                ?>
                </ul>
        </div>
        <?php
		}//end

                
	}

	protected function _content_template() {
	}
	
}
