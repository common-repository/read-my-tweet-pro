<?php
/**
 * Fired when the plugin is uninstalled.
 *
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//Define uninstall functionality here
delete_option( 'rmtp_apikey' );
delete_option( 'rmtp_apisecret' );
delete_option( 'rmtp_apitoken' );
delete_option( 'rmtp_apitokensecret' );
delete_option( 'rmtp_search' );
delete_option( 'rmtp_username' );
delete_option( 'rmtp_tweets' );
delete_option( 'rmtp_speed' );
delete_option( 'rmtp_color' );
delete_option( 'rmtp_width' );
delete_option( 'rmtp_margintop' );
delete_option( 'rmtp_marginbottom' );
delete_option( 'rmtp_text_notifications' );
delete_option( 'rmtp_show_notifications' );
