<?php

/**
 * Menu Page declaration file.
 *
 * @package Kind Auth Wordpress/Includes
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Menu Page declaration class.
 */
class Kinde_Auth_Wordpress_Menu_Page
{
	/**
	 * The page title.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $page_title;

	/**
	 * The menu title.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $menu_title;

	/**
	 * The capability
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $capability;

	/**
	 * The menu slug
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $menu_slug;

	/**
	 * The callback.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $callback;

	/**
	 * The url of icon.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0
	 */
	public $icon_url;

	/**
	 * The position.
	 *
	 * @var     mixed
	 * @access  public
	 * @since   1.0
	 */
	public $position;

	/**
	 * Constructor
	 *
	 * @param string $page_title Menu Page page title.
	 * @param string $menu_title Menu Page menu title.
	 * @param string $capability Menu Page capability.
	 * @param string $icon_url Menu Page url of icon.
	 * @param mixed  $position Menu Page position.
	 */
	public function __construct($page_title = '', $menu_title = '', $capability = '', $menu_slug = '', $callback = '',  $icon_url = '', $position = null)
    {
		if (! $page_title || ! $menu_title || ! $capability  || ! $menu_slug) {
			return;
		}

		// menu page fields
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
		$this->capability = $capability;
		$this->menu_slug = $menu_slug;
		$this->callback = $callback;
		$this->icon_url = $icon_url;
		$this->position = $position;

		// add menu page
		add_action( 'admin_menu', array($this, 'register_my_custom_menu_page'));
	}

	/**
	 * Register my custom menu page
	 *
	 * @return void
	 */
	public function register_my_custom_menu_page() {
		add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, $this->callback, $this->icon_url, $this->position);
	}

}
