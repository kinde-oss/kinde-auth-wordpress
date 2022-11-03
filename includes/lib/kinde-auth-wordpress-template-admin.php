<?php
/**
 * Kinde Auth Wordpress Template Admin file.
 *
 * @package WordPress Plugin Template/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WP_KINDE_AUTH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); // Includes trailing slash

/**
 * Admin Template class.
 */
class Kinde_Auth_Wordpress_Template_Admin
{

	/**
	 * Constructor function
	 */
	public function __construct() {
        $this->render_setting_page_html();
	}

    /**
     * Render setting page html
     *
     * @return void
     */
    private function render_setting_page_html()
    {
        include WP_KINDE_AUTH_PLUGIN_DIR.'../../templates/setting-page.php';
    }
}
