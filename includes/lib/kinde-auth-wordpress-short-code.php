<?php
/**
 * Kinde Auth Wordpress Short Code file.
 *
 * @package Kind Auth Wordpress/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Kinde Auth Wordpress Short Code class.
 */
class Kinde_Auth_Wordpress_Short_Code
{
	/**
	 * Constructor function
	 */
	public function __construct()
	{
		$short_code_buttons = [
			'kinde_auth_login_button' => array($this, 'create_login_button_short_code'),
			'kinde_auth_register_button' => array($this, 'create_register_button_short_code'),
			'kinde_auth_logout_button' => array($this, 'create_logout_button_short_code'),
		];

		foreach ($short_code_buttons as $button_name => $button_action) {
			add_shortcode($button_name, $button_action);
		}
	}

    /**
	 * Register login button short code
	 *
	 * @return string
	 */
	public function create_login_button_short_code($attribute = [])
	{
		$title = $attribute['title'] ?? 'Sign In With Kinde';
		return '<a class="button button-primary button-large" href="/kinde-authenticate/login" title="'.esc_html($title).'">'.esc_html($title).'</a>';
    }

    /**
	 * Register login button short code
	 *
	 * @return string
	 */
    public function create_register_button_short_code($attribute = [])
	{
		$title = $attribute['title'] ?? 'Sign Up With Kinde';
		return '<a class="button button-primary button-large" href="/kinde-authenticate/register" title="'.esc_html($title).'">'.esc_html($title).'</a>';
    }

	/**
	 * Logout button short code
	 *
	 * @return string
	 */
    public function create_logout_button_short_code()
	{
		return '<a class="button button-primary button-large" href="/kinde-authenticate/logout" title="Logout">Logout</a>';
    }
}
