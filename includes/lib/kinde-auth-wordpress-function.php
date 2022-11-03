<?php
/**
 * Kinde Auth Wordpress Function file.
 *
 * @package Kind Auth Wordpress/Includes
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Kinde Auth Wordpress Function class.
 */
class Kinde_Auth_Wordpress_Function
{
	/**
	 * Constructor function
	 */
	public function __construct()
	{
        // register kinde auth on login form
        add_action( 'login_form', array( $this, 'kinde_auth_login_form_login_button' ), 10 );
	}

     /**
     * Kinde Auth login form button
     *
     * @return string
     */
    public function kinde_auth_login_form_login_button()
    {
        $input_append = '';
        if (is_match_url('/wp-login.php?action=normal-login')) {
            $input_append = '<input type="hidden" name="normal_login" value="normal-login">';
        }

        echo
        '<div
            class="kinde-auth"
            style="
                display: flex;
                flex-direction: column;
                text-align: center;
                margin-bottom: 20px;
            ">
            <div class="or-separator" style="margin-bottom:10px">
                <span class="or-text">Or</span>
            </div>
            <a href="/kinde-authenticate/login" class="button button-primary button-large">
                Sign in with Kinde
            </a>
            '.$input_append.'
            <div class="clearfix"></div>
        </div>';
    }
}
