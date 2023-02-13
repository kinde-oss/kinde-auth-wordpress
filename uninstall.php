<?php
/**
 * This file runs when the plugin in uninstalled (deleted).
 * This will not run when the plugin is deactivated.
 * Ideally you will add all your clean-up scripts here
 * that will clean-up unused meta, options, etc. in the database.
 *
 * @package Kindle Auth Wordpress/Uninstall
 */

// If plugin is not being uninstalled, exit (do nothing).
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Do something here if plugin is being uninstalled.
foreach ( wp_load_alloptions() as $option => $value ) {
    if ( strpos( $option, 'kinde_auth_' ) === 0 ) {
        delete_option( $option );
    }
}
