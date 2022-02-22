<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;

$all_shop_layouts = $widgets_class -> product_page_style();
$product_page_style_list = ! empty( $blank_elements_options['product_page_style-list'] ) ? $blank_elements_options['product_page_style-list'] : array(); 



$display_breadcrumb = $widgets_class -> display_breadcrumb();
$display_breadcrumb_option = ! empty( $blank_elements_options['display_breadcrumb-option'] ) ? $blank_elements_options['display_breadcrumb-option'] : array(); 


$related_products = $widgets_class -> related_products();
$related_products_option = ! empty( $blank_elements_options['related_products-option'] ) ? $blank_elements_options['related_products-option'] : array(); 



$cart_button = $widgets_class -> cart_button();
$cart_button_option = ! empty( $blank_elements_options['cart_button-option'] ) ? $blank_elements_options['cart_button-option'] : array(); 

$product_per_page = $widgets_class -> product_per_page();
$product_per_page_count = ! empty( $blank_elements_options['product_per_page-count'] ) ? $blank_elements_options['product_per_page-count'] : array(); 

?>

<div class="blank_tab_content_head">
    <h2 class="content_head_title">
        <?php esc_html_e('', 'blank-elements-pro'); ?>
    </h2>
    <h4 class="content_head_description">
        <?php esc_html_e('', 'blank-elements-pro'); ?>
    </h4>
    <div class="notice notice-warning " style="z-index: 2;">
		<p>some related shop modification won't affect if the current theme already modified the files of woocommerce</p>
        <!-- <p>shop page > Cart Button : Not working yet</p> -->
	</div>
</div>

<div class="elements-list-container">
    <div class="elements-list-section">
        <div class="panel-group attr-accordion" id="accordion" role="tablist" aria-multiselectable="true">
            <!-- Product Page -->
            <div class="attr-panel blank-accordian-panel">
                <!-- Start Single Shop page style -->
                <div class="attr-panel-heading" role="tab" id="single_product_pag">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                        href="#single_product_page_data_control" aria-expanded="true"
                        aria-controls="single_product_page_data_control">
                        <?php esc_html_e('Shop Single Page', 'blank-elements-pro'); ?>
                    </a>
                </div>
                <div id="single_product_page_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel" aria-labelledby="single_product_page_data_control">
                    <div class="attr-panel-body">
                            <hr>
                            <h4 class="" style="color:#fff;">Single page style</h4>
                            <p class="" style="color:#fff;">Choose single product page style.</p>
                            <div class="all_shop_layouts">
                                <?php foreach($all_shop_layouts as $widget): ?>
                                        <div class="attr-col-md-6 attr-col-lg-2">
                                            <?php
                                                $pro = ($widget && $widgets_class::PACKAGE_TYPE == 'free') ? false : true;
                                                $widgets_class->input([
                                                    'type' => 'image-option',
                                                    'name' => 'blank-elements-pro[product_page_style-list][]',
                                                    'style' => $widget[1],
                                                    'value' => $widget[0],
                                                    'options'=> [
                                                        'checked' => ((in_array( $widget[0], $product_page_style_list ) && $pro == false) ? true : false),
                                                    ]
                                                ]);
                                            ?>
                                        </div>
                                    <?php endforeach; ?>
                                <div class="clear"></div>
                            </div>
                            <hr>
                            <h4 style="color:#fff;">Display Breadcrumb</h4>
                            <p style="color:#fff;">Display Breadcrumb on single page.</p>
                            <div class="display_breadcrumb">
                                    <?php foreach($display_breadcrumb as $widget): ?>
                                            <?php
                                                $pro = ($widget && $widgets_class::PACKAGE_TYPE == 'free') ? false : true;
                                                $widgets_class->input([
                                                    'type' => 'show-hide',
                                                    'name' => 'blank-elements-pro[display_breadcrumb-option][]',
                                                    'style' => $widget,
                                                    'value' => $widget,
                                                    'options'=> [
                                                        'checked' => ((in_array( $widget, $display_breadcrumb_option ) && $pro == false) ? true : false),
                                                    ]
                                                ]);
                                                    ?>
                                        <?php endforeach; ?>                  
                                <div class="clear"></div>
                            </div>
                            <hr>
                            <h4 style="color:#fff;">Related Products</h4>
                            <p style="color:#fff;">Display related products on single page.</p>
                            <div class="related_products">
                                    <?php foreach($related_products as $widget): ?>
                                            <?php
                                                $pro = ($widget && $widgets_class::PACKAGE_TYPE == 'free') ? false : true;
                                                $widgets_class->input([
                                                    'type' => 'show-hide',
                                                    'name' => 'blank-elements-pro[related_products-option][]',
                                                    'style' => $widget,
                                                    'value' => $widget,
                                                    'options'=> [
                                                        'checked' => ((in_array( $widget, $related_products_option ) && $pro == false) ? true : false),
                                                    ]
                                                ]);
                                                    ?>
                                        <?php endforeach; ?>                  
                                <div class="clear"></div>
                            </div>
                    </div>
                </div>
                <!-- end Single Shop page style -->
            </div>

            <div class="attr-panel blank-accordian-panel">
                <!-- Start Shop page style -->
                <div class="attr-panel-heading" role="tab" id="shop_page_heading">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                        href="#shop_page_data_control" aria-expanded="true"
                        aria-controls="shop_page_data_control">
                        <?php esc_html_e('Shop Page', 'blank-elements-pro'); ?>
                    </a>
                </div>
                <div id="shop_page_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel" aria-labelledby="shop_page_data_control">
                    <div class="attr-panel-body">
                        <hr>
                        <h4 class="" style="color:#fff;">Cart Button</h4>
                        <p class="" style="color:#fff;">Do you want to display Cart Button?</p>
                        <div class="cart_button">
                                <?php foreach($cart_button as $widget): ?>
                                        <?php
                                            $pro = ($widget && $widgets_class::PACKAGE_TYPE == 'free') ? false : true;
                                            $widgets_class->input([
                                                'type' => 'show-hide',
                                                'name' => 'blank-elements-pro[cart_button-option][]',
                                                'style' => $widget,
                                                'value' => $widget,
                                                'options'=> [
                                                    'checked' => ((in_array( $widget, $cart_button_option ) && $pro == false) ? true : false),
                                                ]
                                            ]);
                                                ?>
                                    <?php endforeach; ?>                  
                            <div class="clear"></div>
                        </div>
                        <hr>
                        <h4 class="" style="color:#fff;">Number of Products</h4>
                        <p class="" style="color:#fff;">How many products you want to display per page?</p>
                        <?php //echo get_option('blank-elements-pro')['product_page_style-list'][0]; ?>
                        <?php
                              $widgets_class->input([
                                  'type' => 'number',
                                  'name' => 'blank-elements-pro[product_per_page-count][]',
                                  'label' => esc_html__('', 'blank-elements-pro'),
                                  'placeholder' => '',
                                  'value' => $product_per_page_count[0],
                              ]);
                          ?>
                        <pre>
                            <?php  //var_dump(get_option('blank-elements-pro')); check if option is ok ?>
                        </pre>
                     </div>
                </div>
                 <!-- End  Shop page style -->
            </div>
            
            
        </div>
    </div>
</div>
