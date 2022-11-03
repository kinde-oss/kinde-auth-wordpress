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
		// add short code login button
        add_shortcode( 'kinde_auth_login_button', array($this, 'create_login_button_short_code') );

		// add short code register button
		add_shortcode( 'kinde_auth_register_button', array($this, 'create_register_button_short_code') );

		// add short code logout button
		add_shortcode( 'kinde_auth_logout_button', array($this, 'create_logout_button_short_code') );
	}

    /**
	 * Register login button short code
	 *
	 * @return void
	 */
	public function create_login_button_short_code($atts = [])
	{
		$title = $atts['title'] ?? 'Sign In With Kinde';
		return '<a class="button button-primary button-large" href="/kinde-authenticate/login" title="'.$title.'">'.$title.'</a>';
    }

    /**
	 * Register login button short code
	 *
	 * @return void
	 */
    public function create_register_button_short_code($atts = [])
	{
		$title = $atts['title'] ?? 'Sign Up With Kinde';
		return '<a class="button button-primary button-large" href="/kinde-authenticate/register" title="'.$title.'">'.$title.'</a>';
    }

	/**
	 * Logout button short code
	 *
	 * @return void
	 */
    public function create_logout_button_short_code()
	{
		$title = 'Logout';
		return '<a class="button button-primary button-large" href="/kinde-authenticate/logout" title="'.$title.'">'.$title.'</a>';
    }
}
