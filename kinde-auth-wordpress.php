<?php
/**
 * Plugin Name: Kinde Auth
 * Version: 0.0.1
 * Plugin URI: https://github.com/kinde-oss/kinde-auth-wordpress
 * Description: This is kinde auth plugin use for wordpress
 * Author: Kinde
 * Author URI: https://kinde.com/
 *
 * Text Domain: kinde-auth
 *
 * @package WordPress
 * @author Kinde
 * @since 0.0.1
 */


if (!defined('ABSPATH')) {
	exit;
}

// Load vendor
if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Load plugin class files.
require_once 'includes/kinde-auth-wordpress.php';

// Load plugin libraries.
require_once 'includes/lib/kinde-auth-wordpress-menu-page.php';
require_once 'includes/lib/kinde-auth-wordpress-template-admin.php';
require_once 'includes/lib/kinde-auth-wordpress-setting-option.php';
require_once 'includes/lib/kinde-auth-wordpress-short-code.php';
require_once 'includes/lib/kinde-auth-wordpress-authenticate.php';
require_once 'includes/lib/kinde-auth-wordpress-function.php';
require_once 'includes/lib/kinde-auth-wordpress-export.php';

/**
 * Returns the main instance of Kinde Auth Wordpress to prevent the need to use globals.
 *
 * @since  0.0.1
 * @return object KindeAuthWordpress
 */
function kinde_auth_wordpress_initial() {
	$instance = Kinde_Auth_Wordpress::instance(__FILE__, '0.0.1');

	if (is_null($instance->settings)) {
	    $instance->settings = Kinde_Auth_Wordpress::instance($instance);
	}

	return $instance;
}

kinde_auth_wordpress_initial();
