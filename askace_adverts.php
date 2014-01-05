<?php
/**
 * Plugin Name: Askace Adverts
 * Description: To use css advert templates to show products and catalogue them.
 * Version: 0.6
 * Author: rekarnar 
 * Author URI: http://rekarnar.com
 * License: GPL2 
 */

global $askace_adverts_db_version;
$askace_adverts_db_version = "0.6";

add_action('admin_menu', 'askace_adverts_menu_item');
function askace_adverts_menu_item(){
    add_menu_page( 'Askace Ads', 'Askace Ads', 'edit_adverts', 'askace_adverts/adverts-admin.php', '', 'http://www.askace.com/favicon.ico', 67 );

    add_submenu_page( 'askace_adverts/adverts-admin.php', 'Add New', 'Add an Advert', 'edit_adverts', 'askace_adverts/adverts-add.php', '' );

}

function askace_adverts_install() {
    global $wpdb;
    add_action( 'admin_notices', 'plugin_installed_notice' );
    //$installed_ver = get_option( "askace_adverts_db_version" );
    //update_option( "askace_adverts_db_version", $askace_adverts_db_version );

    //if($wpdb->get_var("show tables like '".$wpdb->askace_adverts_table_name."'") !=     
    //$wpdb->askace_adverts_table_name) {
    $sql = "CREATE TABLE $wpdb->askace_adverts_table_name (
       id mediumint(9) NOT NULL AUTO_INCREMENT,
       heading tinytext NOT NULL,
       summary text DEFAULT '' NULL,
       url VARCHAR(55) DEFAULT '' NOT NULL,
       supplier VARCHAR(155) DEFAULT '' NOT NULL,
       email tinytext NULL,
       image tinytext NULL,
       payment VARCHAR(15) NULL,
       layouttype VARCHAR(55) NULL,
       created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
       UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // insert any changes only
    dbDelta( $sql );

    add_action( 'admin_notices', 'plugin_installed_notice' );
    //}
}
register_activation_hook( __FILE__, 'askace_adverts_install');

add_action('admin_init', 'askace_adverts_admin_init');
function askace_adverts_admin_init() {
    global $wpdb;
    $wpdb->askace_adverts_table_name = "{$wpdb->prefix}askace_adverts";
    //add_action( 'admin_notices', 'plugin_activated_notice' );

    $result = add_role(
    'advert_editor',
    __( 'Askace Advert Admin' ),
    array(
        'edit_adverts' => true,
	'read' => true
    )
   );

   $role = get_role( 'administrator' );
   $role->add_cap( 'edit_adverts' ); 

}

require('shortcode.php');

// add a lightbox class, so they open up nicely (via Simple Light TBox plugin)
function bb_add_image_class($class){
   $class .= ' lightBox';
   return $class;
}

add_filter('get_image_tag_class','bb_add_image_class');
add_action( 'wp_ajax_preview_advert', 'preview_advert_callback' );
function preview_advert_callback() {
    global $wpdb;
    $a = $_POST['form'];
    $advert->id = 0;
    $advert->heading = $a['heading'];
    $advert->summary = $a['summary'];
    $advert->url = $a['url'];
    $advert->supplier = $a['supplier'];
    $advert->email = $a['email'];
    $advert->payment = $a['payment'];
    $advert->image = $a['upload_image'];
    $advert->layouttype = $a['layouttype'];

    echo getAdWithLayout($advert);
    die(); // this is required to return a proper result
}


/**
add_action('plugins_loaded', 'askace_adverts_update_db_check');
function askace_adverts_update_db_check() {
    global $askace_adverts_db_version;
    if (get_site_option( 'askace_adverts_db_version' ) != $askace_adverts_db_version)     
    {
        askace_adverts_install();
    }
}
*/

register_uninstall_hook( __FILE__, 'askace_adverts_uninstall' );
function askace_adverts_uninstall() {
    add_action( 'admin_notices', 'plugin_deactivated_notice' );
}

//***************//
/**** NOTICES ****/
//***************//
//***************//
function plugin_installed_notice() {
    ?><div class="updated">
        <p><strong>Askace Adverts: </strong><?php _e( "Successfully Installed", 'askace_adverts' ); ?></p>
    </div><?php
}
function plugin_activated_notice() {
    ?><div class="updated">
        <p><strong>Askace Adverts: </strong><?php _e( "Successfully Activated", 'askace_adverts' ); ?></p>
    </div><?php
}
function plugin_deactivated_notice() {
    ?><div class="updated">
        <p><strong>Askace Adverts: </strong><?php _e( "Successfully Deactivated", 'askace_adverts' ); ?></p>
    </div><?php
}
