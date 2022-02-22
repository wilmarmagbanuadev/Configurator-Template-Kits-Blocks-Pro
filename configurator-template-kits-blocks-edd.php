<?php
// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'EDD_SL_STORE_URL', Configurator_Template_Kits_Blocks_VERSION_SL_STORE_URL ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
 
// the name of your product. This should match the download name in EDD exactly
define( 'EDD_SL_ITEM_NAME', Configurator_Template_Kits_Blocks_VERSION_SL_ITEM_NAME ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
define( 'EDD_SL_ITEM_ID', 38 ); 

 
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}
 
// retrieve our license key from the DB
// $license_key = trim( get_option( 'edd_sample_license_key' ) );

// retrieve our license key from the DB.
$license_key = trim( get_option( 'edd_sample_license_key' ) );

$active_plugins = get_option( 'active_plugins' );

		// echo "<pre>";print_r($active_plugins);die();
foreach ( $active_plugins as $active_plugin ) {
	if ( false !== strpos( $active_plugin, 'configurator-template-kits-blocks/configurator-template-kits-blocks.php' ) ) {
		$plugin_dir_and_filename = $active_plugin;
		break;
	}
}
if ( ! isset( $plugin_dir_and_filename ) || empty( $plugin_dir_and_filename ) ) {
$plugin_activated = 0;
}
 
// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater( EDD_SL_STORE_URL, __FILE__, array( 
		'version' 	=> '1.0', 		// current version number
		'license' 	=> $license_key, 	// license key (used get_option above to retrieve from DB)
		'item_name'     => EDD_SL_ITEM_NAME, 	// name of this plugin
		'item_id'       => EDD_SL_ITEM_ID,	// id of this plugin
		'author' 	=> 'vijay',  // author of this plugin
		'url'           => home_url(),
        'beta'          => false // set to true if you wish customers to receive update notifications of beta releases
	)
);


function edd_sample_license_page() {
	$license = get_option( 'edd_sample_license_key' );
	$status  = get_option( 'edd_sample_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Plugin License Options'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('edd_sample_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="edd_sample_license_key" name="edd_sample_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="edd_sample_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

function edd_sample_register_option() {
	// creates our settings in the options table
	register_setting('edd_sample_license', 'edd_sample_license_key', 'edd_sanitize_license' );
}
add_action('admin_init', 'edd_sample_register_option');

function edd_sanitize_license( $new ) {
	$old = get_option( 'edd_sample_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'edd_sample_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}



// activate license

function edd_sample_activate_license() {
	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {
		
		update_option( 'edd_sample_license_key', $_POST['edd_sample_license_key'] );
		// run a quick security check
	 	if( ! check_admin_referer( 'edd_sample_nonce', 'edd_sample_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_sample_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_id'    => EDD_SL_ITEM_ID, // The ID of the item in EDD
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( EDD_SL_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			$message =  ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __( 'An error occurred, please try again.' );

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
				// echo "<pre>";print_r($license_data);die();
			$message2 = "";
			if ( false === $license_data->success ) {
				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							__( 'Your license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'revoked' :

						$message = __( 'Your license key has been disabled.' );
						break;

					case 'missing' :

						$message = __( 'Invalid license.' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), EDD_SAMPLE_ITEM_NAME );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.' );
						break;

					default :

						$message = __( 'An error occurred, please try again.' );
						break;
				}

			}else{
					 $message2 = '&message=activated';
				}

		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . "configurator-template-kits-blocks-license" );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		// $license_data->license will be either "valid" or "invalid"

		update_option( 'edd_sample_license_status', $license_data->license );
		wp_redirect( admin_url( 'admin.php?page=' . "configurator-template-kits-blocks-license".$message2 ) );
		exit();
	}


	if (isset( $_POST['edd_license_deactivate'] )) {
		// data to send in our API request
		$license = trim( get_option( 'edd_sample_license_key' ) );
				// echo "<pre>";print_r($license);die();
				update_option( 'edd_sample_license_status', 0 );
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => 'Sample Plugin', // the name of our product in EDD
			'url'        => home_url(),
			'item_id'    => EDD_SL_ITEM_ID, // The ID of the item in EDD
		);
		$response = wp_remote_post( EDD_SL_STORE_URL, array( 'body' => $api_params, 'timeout' => 15, 'sslverify' => false ) );
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ($license_data->success == 1) {
			wp_redirect( admin_url( 'admin.php?page=' . "configurator-template-kits-blocks-license&message=diactivated" ) );
		exit();
		}
	
		
				// $status  = get_option( 'edd_sample_license_status' );
	}
}
add_action('admin_init', 'edd_sample_activate_license');


/**
 * This is a means of catching errors from the activation method above and displaying it to the customer
 */
function edd_sample_admin_notices() {
	if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {
				// echo "<pre>";print_r($_GET);die();
		switch( $_GET['sl_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:
				// Developers can put a custom success message here for when activation is successful if they way.
				break;

		}
	}
}
add_action( 'admin_notices', 'edd_sample_admin_notices' );

