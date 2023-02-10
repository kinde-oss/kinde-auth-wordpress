<?php
/**
 * Plugin Name: Kinde Auth
 * Version: 1.0
 * Plugin URI: https://kinde.com/
 * Description: A new era of authentication with simple, powerful authentication you can integrate with your site in minutes.
 * Author: Kinde
 * Author URI: https://kinde.com/
 *
 * Text Domain: kinde-auth
 *
 * @package WordPress
 * @author Kinde
 * @since 1.0
 */


if (!defined('ABSPATH')) {
	exit;
}

define('KINDE_AUTH_VERSION', '1.0');
define('KINDE_AUTH__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('KINDE_AUTH__PLUGIN_URL', plugin_dir_url( __FILE__ ));

// Load vendor
if (is_readable( KINDE_AUTH__PLUGIN_DIR . 'vendor/autoload.php')) {
	require_once(KINDE_AUTH__PLUGIN_DIR . 'vendor/autoload.php');
}

// Load plugin class files.
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/kinde-auth-wordpress.php');

// Load plugin libraries.
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-menu-page.php');
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-template-admin.php');
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-setting-option.php');
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-short-code.php');
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-authenticate.php');
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-function.php');
require_once(KINDE_AUTH__PLUGIN_DIR . 'includes/lib/kinde-auth-wordpress-export.php');

/**
 * Returns the main instance of Kinde Auth Wordpress to prevent the need to use globals.
 *
 * @since  1.0
 * @return object KindeAuthWordpress
 */
function kinde_auth_wordpress_initial() {
	$instance = Kinde_Auth_Wordpress::instance(__FILE__, KINDE_AUTH_VERSION);

	if (is_null($instance->settings)) {
	    $instance->settings = Kinde_Auth_Wordpress::instance($instance);
	}

	return $instance;
}

kinde_auth_wordpress_initial();
