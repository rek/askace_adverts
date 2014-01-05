/**
* (not currently used)
*/

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$option_name = 'askace_adverts';

delete_option( $option_name );
add_action( 'admin_notices', 'plugin_deactivated_notice' );

remove_cap('edit_adverts');
remove_role('advert_editor');
