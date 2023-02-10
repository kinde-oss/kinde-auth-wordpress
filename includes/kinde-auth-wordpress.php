<?php
/**
 * Main plugin class file.
 *
 * @package Kind Auth Wordpress/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class Kinde_Auth_Wordpress
{

	/**
	 * The single instance of KindeAuthWordpress.
	 *
	 * @var     object
	 * @access  private
	 * @since   1.0
	 */
	private static $instance = null; //phpcs:ignore

	/**
	 * The version number.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $version; //phpcs:ignore

	/**
	 * The token.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $token; //phpcs:ignore

	/**
	 * The main plugin file.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $file;

	/**
	 * Constructor function.
	 *
	 * @param string $file File constructor.
	 * @param string $version Plugin version.
	 */
	public function __construct($file = '', $version = KINDE_AUTH_VERSION)
	{
		$this->version = $version;
		$this->token = 'kinde-auth';

		// Load plugin environment variables.
		$this->file = $file;

		// Register hook plugin install
		register_activation_hook($this->file, array($this, 'install'));

		if (is_admin()) {
			// Register a menu
			$this->register_menu_page(
				'Kinde Auth Setting',
				'Kinde Auth',
				'manage_options',
				$this->token,
				array($this, 'register_template_admin'),
				KINDE_AUTH__PLUGIN_URL."assets/img/logo.png",
				6
			);

			// call register settings function
			add_action( 'admin_init', array($this, 'register_setting_options'));
		}

		// add short_codes
		$this->register_short_codes();

		// register kinde authenticate
		$this->register_kinde_authenticate();

		// register kinde auth functions
		$this->register_kinde_functions();

		// register kinde auth export
		$this->register_kinde_export();
	}

	/**
	 * Register a custom menu kinde auth
	 *
	 * @param string $page_title Page Title.
	 * @param string $menu_title Menu Title.
	 * @param string $capability Capability.
	 * @param string $menu_slug Menu Slug.
	 * @param mixed $callback Callback.
	 * @param string $icon_url Icon URL.
	 * @param string $position Position.
	 *
	 * @return bool|Kinde_Auth_Wordpress_Menu_Page
	 */
	public function register_menu_page($page_title = '', $menu_title = '', $capability = '', $menu_slug = '', $callback = '',  $icon_url = '', $position = null)
	{
		if ( ! $page_title || ! $menu_title || ! $capability  || ! $menu_slug) {
			return false;
		}

		$menu_page = new Kinde_Auth_Wordpress_Menu_Page($page_title, $menu_title, $capability, $menu_slug, $callback, $icon_url, $position);
		return $menu_page;
	}


	/**
	 * Register a custom menu kinde auth
	 *
	 * @return Kinde_Auth_Wordpress_Template_Admin
	 */
	public function register_template_admin()
	{
		$template_admin = new Kinde_Auth_Wordpress_Template_Admin();
		return $template_admin;
	}

	/**
	 * Register options for admin setting
	 *
	 * @return Kinde_Auth_Wordpress_Setting_Option
	 */
	public function register_setting_options()
	{
		$setting_option = new Kinde_Auth_Wordpress_Setting_Option();
		return $setting_option;
	}

	/**
	 * Register a short code item
	 *
	 * @return Kinde_Auth_Wordpress_Short_Code
	 */
	public function register_short_codes()
	{
		$short_code = new Kinde_Auth_Wordpress_Short_Code();
		return $short_code;
	}

	/**
	 * Register a kinde authenticate functions
	 *
	 * @return Kinde_Auth_Wordpress_Authenticate
	 */
	public function register_kinde_authenticate()
	{
		$kinde_authenticate = new Kinde_Auth_Wordpress_Authenticate();
		return $kinde_authenticate;
	}

	/**
	 * Register a kinde functions
	 *
	 * @return Kinde_Auth_Wordpress_Function
	 */
	public function register_kinde_functions()
	{
		$kinde_function = new Kinde_Auth_Wordpress_Function();
		return $kinde_function;
	}

	/**
	 * Register a kinde authenticate functions
	 *
	 * @return Kinde_Auth_Wordpress_Export
	 */
	public function register_kinde_export()
	{
		$kinde_export = new Kinde_Auth_Wordpress_Export();
		return $kinde_export;
	}

	/**
	 * Main Kinde_Auth_Wordpress Instance
	 *
	 * Ensures only one instance of Kinde_Auth_Wordpress is loaded or can be loaded.
	 *
	 * @param string $file File instance.
	 * @param string $version Version parameter.
	 *
	 * @return object Kinde_Auth_Wordpress instance
	 * @see Kinde_Auth_Wordpress()
	 * @since 1.0
	 * @static
	 */
	public static function instance($file = '', $version = '1.0')
	{
		if (is_null(self::$instance)) {
			self::$instance = new self($file, $version);
		}

		return self::$instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html( __( 'Cloning of WordPress_Plugin_Template is forbidden' ) ), esc_attr( $this->_version ) );

	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html( __( 'Unserializing instances of WordPress_Plugin_Template is forbidden' ) ), esc_attr( $this->_version ) );
	}

	/**
	 * Installation. Runs on activation.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0
	 */
	private function _log_version_number() {
		update_option( $this->token . '_version', $this->version );
	}

}
