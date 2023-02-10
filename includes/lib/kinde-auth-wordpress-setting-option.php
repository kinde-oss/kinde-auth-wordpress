<?php
/**
 * Kinde Auth Wordpress Setting Option file.
 *
 * @package Kind Auth Wordpress/Includes
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Kinde Auth Wordpress Setting Option class.
 */
class Kinde_Auth_Wordpress_Setting_Option
{
	/**
	 * The updated.
	 *
	 * @var     boolean
	 * @access  public
	 * @since   1.0
	 */
	private $updated;

	/**
	 * Constructor function
	 */
	public function __construct()
	{
		$this->updated = true;
		$this->register_setting_page_options();
	}

    /**
	 * Register setting page option
	 *
	 * @return void
	 */
    public function register_setting_page_options()
	{
		register_setting('kinde-auth', 'kinde_auth_token_host', array($this, 'validate_setting_option_token_host'));
		register_setting('kinde-auth', 'kinde_auth_client_id', array($this, 'validate_setting_option_client_id'));
		register_setting('kinde-auth', 'kinde_auth_client_secret', array($this, 'validate_setting_option_client_secret'));
		register_setting('kinde-auth', 'kinde_auth_default_login_page');
		register_setting('kinde-auth', 'kinde_auth_auto_user_role');
		register_setting('kinde-auth', 'kinde_auth_grant_type', array($this, 'custom_show_message_success'));
		register_setting('kinde-auth', 'kinde_auth_site_protocol');
    }

	/**
	 * Validate for token host
	 *
	 * @return mixed
	 */
	public function validate_setting_option_token_host($value)
	{
		return $this->validate_setting_option($value, 'kinde_auth_token_host', 'Token host');
	}

	/**
	 * Validate for client id
	 *
	 * @return mixed
	 */
	public function validate_setting_option_client_id($value)
	{
		return $this->validate_setting_option($value, 'kinde_auth_client_id', 'Client ID');
	}

	/**
	 * Validate for client secret
	 *
	 * @return mixed
	 */
	public function validate_setting_option_client_secret($value)
	{
		return $this->validate_setting_option($value, 'kinde_auth_client_secret', 'Client Secret');
	}

	/**
	 * Validate for option
	 *
	 * @return mixed
	 */
	public function validate_setting_option($value, $field, $name)
	{
		if (empty($value)) {
			$this->updated = false;
			$value = get_option($field);
			add_settings_error('kinde_auth_notice', "invalid_$field", "$name is required.");
		}

		return $value;
	}

	/**
	 * Custom show success message after update option
	 *
	 * @return mixed
	 */
	public function custom_show_message_success($value)
	{
		if ($this->updated) {
			add_settings_error('kinde_auth_notice', "", "Settings saved.", "success");
		}
		return $value;
	}
}
