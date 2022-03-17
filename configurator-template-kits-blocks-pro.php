<?php
/**
 * Plugin Name: Configurator Template Kits Blocks Pro
 * Description: Custom Elementor widgets for Configurator Theme
 * Plugin URI: https://innwit.com/
 * Author: Innwit
 * Version: 1.0.0
 * Author URI: https://innwit.com/
 *
 * Text Domain: configurator-template-kits-blocks
 *
 */

 defined( 'ABSPATH' ) || exit;

define( 'Configurator_Template_Kits_Blocks_VERSION', '1.0.0' );

define( 'Configurator_Template_Kits_Blocks__FILE__', __FILE__ );
define( 'Configurator_Template_Kits_Blocks_PLUGIN_BASE', plugin_basename( Configurator_Template_Kits_Blocks__FILE__ ) );
define( 'Configurator_Template_Kits_Blocks_PATH', plugin_dir_path( Configurator_Template_Kits_Blocks__FILE__ ) );
define( 'Configurator_Template_Kits_Blocks_INCLUDES_PATH', Configurator_Template_Kits_Blocks_PATH . 'includes/' );
define( 'Configurator_Template_Kits_Blocks_MODULES_PATH', Configurator_Template_Kits_Blocks_PATH . 'modules/' );
define( 'Configurator_Template_Kits_Blocks_URL', plugins_url( '/', Configurator_Template_Kits_Blocks__FILE__ ) );
define( 'Configurator_Template_Kits_Blocks_ASSETS_URL', Configurator_Template_Kits_Blocks_URL . 'assets/' );
define( 'Configurator_Template_Kits_Blocks_MODULES_URL', Configurator_Template_Kits_Blocks_URL . 'modules/' );


define( 'Configurator_Template_Kits_SL_ITEM_NAME', 'configurator-template-kits-blocks' );
/**
*global $validator;
*require_once (plugin_dir_path(__FILE__) . 'admin/checker.php' ); 
*include_once plugin_dir_path(__FILE__) . 'admin/checker.php';
**/
require_once (plugin_dir_path(__FILE__) . 'admin/admin-functions.php' ); 

require_once ( Configurator_Template_Kits_Blocks_PATH . 'classes/class-menu-walker.php' );
require_once (Configurator_Template_Kits_Blocks_PATH . 'includes/class-configurator-template-kits-blocks-hft-builder.php');
require_once (Configurator_Template_Kits_Blocks_PATH . 'includes/helper-functions.php');



// add action
//add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'configurator_template_kits_blocks__pro_action_links' );

function configurator_template_kits_blocks__pro_action_links( $actions ) {
   $actions[] = '<a href="admin.php?page=configurator-template-kits-blocks-license" target="_blank">License</a>';
   return $actions;
}