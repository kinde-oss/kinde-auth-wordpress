<?php
/**
 * Kinde Auth Wordpress Authenticate file.
 *
 * @package Kind Auth Wordpress/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WP_KINDE_AUTH_AUTHENTICATE_DIR', plugin_dir_path( __FILE__ ) ); // Includes trailing slash

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Kinde\KindeSDK\Api\UserApi;
use Kinde\KindeSDK\Configuration;
use Kinde\KindeSDK\KindeClientSDK;
use Kinde\KindeSDK\Sdk\Enums\GrantType;

/**
 * Kinde Auth Wordpress Authenticate class.
 */
class Kinde_Auth_Wordpress_Authenticate
{
    /**
	 * The kinde authenticate token host.
	 *
	 * @var     string
	 * @access  public
	 * @since   0.0.1
	 */
	public $token_host;

    /**
	 * The kinde authenticate client id.
	 *
	 * @var     string
	 * @access  public
	 * @since   0.0.1
	 */
	public $client_id;

    /**
	 * The kinde authenticate client secret.
	 *
	 * @var     string
	 * @access  public
	 * @since   0.0.1
	 */
	public $client_secret;

    /**
	 * The kinde authenticate grant_type.
	 *
	 * @var     string
	 * @access  public
	 * @since   0.0.1
	 */
	public $grant_type;

    /**
	 * The kinde client.
	 *
	 * @var     object
	 * @access  public
	 * @since   0.0.1
	 */
	private $kinde_client;

    /**
	 * The kinde config.
	 *
	 * @var     object
	 * @access  public
	 * @since   0.0.1
	 */
	private $kinde_config;

    /**
	 * The kinde error url.
	 *
	 * @var     string
	 * @access  private
	 * @since   0.0.1
	 */
    private  $kinde_error_url = '/kinde-authenticate/error';

    /**
	 * The wordpress frontend url.
	 *
	 * @var     string
	 * @access  private
	 * @since   0.0.1
	 */
    private  $wordpress_frontend_url = '/index.php';

    /**
	 * The wordpress admin url.
	 *
	 * @var     string
	 * @access  private
	 * @since   0.0.1
	 */
    private  $wordpress_admin_url = '/wp-admin/index.php';


	/**
	 * Constructor function
	 */
	public function __construct()
	{
        $this->token_host = get_option('kinde_auth_token_host');
        $this->client_id = get_option('kinde_auth_client_id');
        $this->client_secret = get_option('kinde_auth_client_secret');
        $this->grant_type = get_option('kinde_auth_grant_type') ?? GrantType::authorizationCode;

        // register login,register,logout action
        add_action('init',  array($this, 'show_new_wordpress_login_form'));
        add_action('init',  array($this, 'handle_login_wordpress_site'));
        add_action('init',  array($this, 'create_login_action'));
        add_action('init',  array($this, 'create_register_action'));
        add_action('init',  array($this, 'create_logout_action'));
        add_action('init',  array($this, 'create_response_action'));
        add_action('init',  array($this, 'create_error_action'));
        add_action('init',  array($this, 'handle_logout_wordpress_site'));
	}

    /**
	 * Show new wp-login form
	 *
	 * @return void
	 */
	public function show_new_wordpress_login_form()
	{
		if (!is_match_url('/wp-new-login')) {
            return;
        }

        exit(header("Location: /wp-login.php?action=normal-login"));
    }

     /**
	 * Event and listening login action
	 *
	 * @return void
	 */
	public function handle_login_wordpress_site()
	{
        // kinde login page redirect type
        $redirect_page = get_option('kinde_auth_redirect_page') ?? 'wordpress';
        if ($redirect_page == 'wordpress') {
            return;
        }

        // not action if user login by wordpress method
        if (!empty($_POST['normal_login']) && $_POST['normal_login'] == 'normal-login') {
            return;
        }

        // user is logged
        if (is_user_logged_in()) {
            return;
        }

        $login_pass_urls = ['/wp-login.php', '/login'];
        $login_not_pass_urls = ['/wp-login.php?action=logout', '/wp-login.php?action=normal-login',
            '/wp-login.php?action=lostpassword', '/login/?loggedout=true'];
        if (!is_match_url($login_pass_urls) || is_match_url($login_not_pass_urls)) {
            return;
        }

        // kinde login
        $this->create_login_action(true);
    }

    /**
	 * Event and listening login action
	 *
	 * @return void
	 */
	public function create_login_action($skip_confirm_url = false)
	{
		if (!is_match_url('/kinde-authenticate/login') && !$skip_confirm_url) {
            return;
        }

        if (empty($this->kinde_client)) {
            $this->connection_with_kinde();
        }

        $errorMessage = "";
        try {
            $response = $this->kinde_client->login();
            if ($this->grant_type == GrantType::clientCredentials && !empty($response->access_token)) {
                exit(header("Location: /kinde-authenticate/response?code=$response->access_token"));
            }
        } catch (ClientException | RequestException $e) {
            $errorMessage = $e->getMessage();
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
        }

        if (!empty($errorMessage)) {
            exit(header("Location: $this->kinde_error_url?message=".urlencode($errorMessage)));
        }
    }

    /**
	 * Event and listening register action
	 *
	 * @return void
	 */
	public function create_register_action()
	{
		if (!is_match_url('/kinde-authenticate/register')) {
            return;
        }

        $this->validation_properties();

        if (empty($this->kinde_client)) {
            $this->connection_with_kinde();
        }

        $errorMessage = "";
        try {
            $this->kinde_client->register();
        } catch (ClientException $e) {
            $errorMessage = $e->getMessage();
        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
        }

        if (!empty($errorMessage)) {
            exit(header("Location: $this->kinde_error_url?message=".urlencode($errorMessage)));
        }
    }

    /**
	 * Event and listening logout action
	 *
	 * @return void
	 */
	public function create_logout_action()
	{
		if (!is_match_url('/kinde-authenticate/logout')) {
            return;
        }

        $this->handle_logout_wordpress_site(true);
    }

    /**
	 * Event and listening response action
	 *
	 * @return void
	 */
	public function create_response_action()
	{
		if (!is_match_url('/kinde-authenticate/response')) {
            return;
        }

        if (empty($_GET['code'])) {
            exit(header("Location: $this->kinde_error_url?message=Something went wrong"));
        }

        $access_token = $_GET['code'];

        if (in_array($this->grant_type, [GrantType::authorizationCode, GrantType::PKCE])) {
            $this->connection_with_kinde();
            $error_message = "";
            try {
                $response = $this->kinde_client->getToken();
                $access_token = $response->access_token;
                $this->kinde_config = new Configuration();
                $this->kinde_config->setHost($this->token_host);
                $user_api_instance = new UserApi($this->kinde_config);
                $user = $user_api_instance->getUserProfile();

                // get wordpress user
                $wordpress_user = $this->get_current_wordpress_user($user);
                $current_user = get_user_by('ID', $wordpress_user['user_id']);

                // switch wordpress user
                wp_set_current_user($wordpress_user['user_id'], $wordpress_user['user_login']);
                wp_set_auth_cookie($wordpress_user['user_id']);
                do_action('wp_login', $wordpress_user['user_login'], $current_user);

                if (in_array($wordpress_user['user_role'], ['subscriber', 'contributor'])) {
                    exit(header("Location:  $this->wordpress_frontend_url"));
                }

                exit(header("Location: $this->wordpress_admin_url"));

            } catch (ClientException | RequestException $e) {
                $error_message = $e->getMessage();
            } catch (\Throwable $e) {
                $error_message = $e->getMessage();
            }

            if (!empty($error_message)) {
                exit(header("Location: $this->kinde_error_url?message=".urlencode($error_message)));
            }
        }

        include WP_KINDE_AUTH_AUTHENTICATE_DIR.'../../templates/response-page.php';
    }

    /**
	 * Event and listening error action
	 *
	 * @return void
	 */
	public function create_error_action()
	{
		if (!is_match_url($this->kinde_error_url)) {
            return;
        }

        include WP_KINDE_AUTH_AUTHENTICATE_DIR.'../../templates/error-page.php';
    }

    /**
	 * Event and listening logout wordpress action
	 *
	 * @return void
	 */
	public function handle_logout_wordpress_site($skip_confirm_url = false)
	{
        $logout_urls = ['/logout', '/wp-login.php?action=logout', '/login/?loggedout=true'];
        if (!is_match_url($logout_urls) && !$skip_confirm_url) {
            return;
        }

        $current_user = wp_get_current_user();
        $user_type = get_user_meta($current_user->ID, 'user_type') ?? '';

        // logout user
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        wp_set_current_user( 0 );

        // if user not is kinde user -> user create by wordpress admin
        if (empty($user_type) || (!empty($user_type) && $user_type[0] != "kinde")) {

            // redirect follow roles
            $user_role = $current_user->roles[0] ?? '';
            if (in_array($user_role, ['subscriber', 'contributor'])) {
                exit(header("Location: $this->wordpress_frontend_url"));
            }
            exit(header("Location: /wp-new-login"));
        }

        // if user is kinde
        if (empty($this->kinde_client)) {
            $this->connection_with_kinde();
        }

        // handle logout by kinde authorization server
        $error_message = "";
        try {
            $this->kinde_client->logout();
        } catch (ClientException | RequestException $e) {
            $error_message = $e->getMessage();
        } catch (\Throwable $e) {
            $error_message = $e->getMessage();
        }

        if (!empty($error_message)) {
            exit(header("Location: $this->kinde_error_url?message=".urlencode($error_message)));
        }
    }

    /**
	 * Validation sdk client fields
	 *
	 * @return void
	 */
    private function validation_properties() {
        if (empty($this->token_host) || empty($this->client_id) || empty($this->client_secret)) {
            $error_message = "The token host, client_id or client_secret is not have value";
            header("Location: $this->kinde_error_url?message=$error_message");
            exit();
        }
    }

    /**
     * Connection with kinde authorization server
     *
     * @return mixed
     */
    private function connection_with_kinde() {
        if (empty($this->kinde_client)) {
            $error_message = "";
            try {
                $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https' : 'http';
                $domain_link = $protocol . '://' . $_SERVER['HTTP_HOST'];
                $this->kinde_client = new KindeClientSDK(
                    $this->token_host,
                    "$domain_link/kinde-authenticate/response",
                    $this->client_id,
                    $this->client_secret,
                    $this->grant_type
                );
            } catch (ClientException | RequestException $e) {
                $error_message = $e->getMessage();
            } catch (\Throwable $e) {
                $error_message = $e->getMessage();
            }

            if (!empty($error_message)) {
                exit(header("Location: $this->kinde_error_url?message=".urlencode($error_message)));
            }
        }
    }

    /**
     * Get current wordpress user
     *
     * @param  $kindeUser UserProfile
     * @return mixed
     */
    private function get_current_wordpress_user($kinde_user)
    {
        $current_user = get_user_by('email', $kinde_user['preferred_email']);
        $user_id = '';
        $user_login = '';
        if (empty($current_user)) {
            $user_login = "kinde_user_".generate_random_string();
            $user_role = get_option('kinde_auth_auto_user_role') ?? 'administrator';
            $user_data = array(
                'user_login' => $user_login,
                'user_email' => $kinde_user['preferred_email'],
                'first_name' => $kinde_user['first_name'],
                'last_name' => $kinde_user['last_name'],
                'user_registered' => date_i18n('Y-m-d H:i:s'),
                'role' => $user_role,
                'meta_input' => ['user_type' => 'kinde']
            );
            $user_id = wp_insert_user($user_data );
        } else {
            $user_type = get_user_meta($current_user->id, 'user_type') ?? '';
            if (empty($user_type)) {
                add_user_meta($current_user->id, 'user_type', 'kinde');
            }
            $user_id = $current_user->id;
            $user_login = $current_user->user_login;
            $user_role = $current_user->roles[0];
        }

        return [
            'user_id' => $user_id,
            'user_login' => $user_login,
            'user_role' => $user_role
        ];
    }

}
