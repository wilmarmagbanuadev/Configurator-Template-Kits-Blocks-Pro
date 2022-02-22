<?php
$license = get_option( 'edd_sample_license_key' );
$status  = get_option( 'edd_sample_license_status' );
?>
<div class="blankelements_wrapper">
    <div class="license_container">
        <div class="blankelements_logo">
            <!-- <img src="<?php echo BLANK_ELEMENTS_PRO_URL . '/assets/images/settings_logo.png'; ?>" /> -->
            <h1 style="color:#fff;">Configurator Template Kits Blocks</h1>
        </div>
        <div class="wrap license_wrap">
                <form method="post" action="options.php">
            <div class="blankelements-content-head">
                <div class="tab_titles">
                <h2 class="head_title">
                    <?php esc_html_e('License Page', 'blank-elements-pro'); ?>                                    
                </h2>                
                <h4 class="head_subtitle">
                   <?php esc_html_e('License Details', 'blank-elements-pro'); ?>                                    
                </h4>
                </div>
                <div class="blank-input-switch" style="display: none;">
                    <?php submit_button(); ?>
                </div>
            </div>
            <div class="license_form">

                    <?php settings_fields('edd_sample_license'); ?>
                    <?php 
                        if (isset($_GET['message']) && $_GET['message'] == 'diactivated') { ?>
                            <div class="notify_msg success">
                    <p> 
                        <?php esc_html_e('Diactivated! Your license key is Diactivated successfully.', 'blank-elements-pro'); ?>
                    </p>
                </div>  
                        <?php }
                    
                        if (isset($_GET['message']) && $_GET['message'] == 'activated') { ?>
                            <div class="notify_msg success">
                    <p> 
                        <?php esc_html_e('Congratulations! Your license key is submitted successfully and product is activated and ready to use.', 'blank-elements-pro'); ?>
                    </p>
                </div>  
                        <?php }
                            // var_dump($_GET['sl_activation']);
                        if ( isset( $_GET['sl_activation'] ) ) {
                // echo "<pre>";print_r($_GET);die();
        switch( $_GET['sl_activation'] ) {

            case 'false':
                $message = urldecode( $_GET['message'] );
                ?>
                <div class="notify_msg failed">
                            <p> 
                                <?php echo $message; ?>
                            </p>
                        </div>
                <?php
                break;

            case 'true':
            default: ?>
                <div class="notify_msg success">
                    <p> 
                        <?php esc_html_e('Congratulations! Your license key is submitted successfully and product is activated and ready to use.', 'blank-elements-pro'); ?>
                    </p>
                </div>  
                <?php        
                break;

        }
    } ?>
                    
                       
                    <div class="form-group">
                        <h4 class="form-title">
                            <?php esc_html_e('License Key', 'blank-elements-pro'); ?>
                        </h4>
                        <label class="description" for="edd_sample_license_key">
                            <?php esc_html_e('Enter your License key.', 'blank-elements-pro'); ?>
                        </label>

                        <input id="edd_sample_license_key" name="edd_sample_license_key" type="text" class="regular-text" placeholder="<?php echo esc_attr('Enter your License key.', 'blank-elements-pro'); ?>" value="<?php esc_attr_e( $license ); ?>" />
                    </div>    
                    <div class="form-group license_btn">
                        <?php if( $status !== false && $status == 'valid' ) { ?>
                            <p class="notify_msg success">Congratulations! Your product is activated. </p>
                                <?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
                                    <input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License', 'blank-elements-pro'); ?>"/>
                            <?php } else {
                                    wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
                                    <input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License', 'blank-elements-pro'); ?>"/>
                            <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>