<?php

/*
Plugin Name: 	Woodokan Checkout Form
Plugin URI:		https://woodokan.com
Description: 	woodokan checkout Allow the visitor to request the product on the same page. it provides you with great features to facilitate the selling process.
Version: 		2.0.1

Author: 		Chafik Amraoui
Author URI: 	https://woodokan.com
Text Domain: 	cod-express-checkout
Domain Path:	/languages/
*/
#-------------------------
# Prevent direct access
#-------------------------
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
#--------------------------
# Define constants
#---------------------------
define( 'EXPCOD_PATH', plugin_dir_path( __FILE__ ) );
define( 'EXPCOD_URL', plugin_dir_url( __FILE__ ) );
define( 'EXPCOD_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
define( 'EXPCOD_CAPABILITY', 'manage_options' );
define( 'EXPCOD_FILE', __FILE__ );
define( 'WDLF_VERSION','1.0.2' );

#---------------------------
# include main class
#---------------------------
if ( !class_exists( 'CodExpressCheckout' ) ) {
 ;
    include_once EXPCOD_PATH . 'classes/class-codexpress.php';
    include_once EXPCOD_PATH . 'google-sheets/advanced-form-integration.php';
   
}

#---------------------------
# instance from main class
#---------------------------
function codexp(){
    return CodExpressCheckout::instance();
}

#---------------------------
# Load textdomain
#---------------------------
function expcod_load_textdomain(){
    load_plugin_textdomain( 'cod-express-checkout', false, EXPCOD_DIRNAME . '/languages' );
}
add_action( 'init', 'expcod_load_textdomain' );

#---------------------------
# Autoloader
#---------------------------
require EXPCOD_PATH . 'classes/Autoload.php';

#---------------------------
# Ajax logic
#--------------------------
$Expcod_Ajax = new Expcod_Ajax();

if ( !is_admin() ) {
    #----------------------
    # Front end logic
    #----------------------
    $Expcod_Front = new Expcod_Front();
} else {
    #------------------------
    # Admin logic
    #------------------------
    $Expcod_Admin = new Expcod_Admin();
}

#-----------------
# version 2 changes
#-----------------
require EXPCOD_PATH . 'classes/version-2.php';
require EXPCOD_PATH . 'classes/add-to-cart-sc.php';



# -----------------
# Imprt shipping locations 
# ----------------

if(isset($_POST['wdk-import-locations'])){
    require EXPCOD_PATH . 'classes/includes/locations/'.$_POST['wdk-import-locations'].'.php';
}