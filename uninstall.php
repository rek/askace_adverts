//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$option_name = 'askace_adverts';

delete_option( $option_name );
add_action( 'admin_notices', 'plugin_deactivated_notice' );
