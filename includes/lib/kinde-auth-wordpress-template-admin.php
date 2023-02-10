<?php
/**
 * Kinde Auth Wordpress Template Admin file.
 *
 * @package WordPress Plugin Template/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
        include_once(KINDE_AUTH__PLUGIN_DIR.'templates/setting-page.php');
    }
}
