<?php
/**
 * Kinde Auth Wordpress Export file.
 *
 * @package Kind Auth Wordpress/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Kinde Auth Wordpress Export class.
 */
class Kinde_Auth_Wordpress_Export
{

	/**
	 * Constructor function
	 */
	public function __construct()
	{
        // register export action
        add_action('init',  array($this, 'handle_export_wordpress_user_to_csv'));
	}

    /**
	 * Validation sdk client fields
	 *
	 * @return void
	 */
    public function handle_export_wordpress_user_to_csv() {
        if (!is_match_url('/kinde-authenticate/export-wp-users')) {
            return;
        }

        try {
            $milliseconds = floor(microtime(true) * 1000);
            $file_name = "users_$milliseconds.csv";
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header("Content-Disposition: attachment; filename=$file_name");
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            $open_file = fopen('php://output', 'w');
            ob_clean(); // clean slate

            // add header
            $headers = array('id', 'first_name', 'last_name', 'email', 'salt', 'salt_position', 'hashed_password', 'hashing_method', 'email_verified');
            fputcsv($open_file, $headers);

            $users_data = get_users();
            foreach ($users_data as $user_data) {
                $first_name = get_user_meta($user_data->ID, 'first_name', true);
                $last_name = get_user_meta($user_data->ID, 'last_name', true);
                $kinde_user = [
                    'id' => $user_data->ID,
                    'first_name' => $first_name ?? '',
                    'last_name' => $last_name ?? '',
                    'email' => $user_data->user_email,
                    'salt' => substr($user_data->user_pass, 4, 8),
                    'salt_position' => 'prefix',
                    'hashed_password' => $user_data->user_pass,
                    'hashing_method' => 'brcypt',
                    'email_verified' => $user_data->user_status == "0" ? "true" : "false"
                ];

                fputcsv($open_file, $kinde_user, ",");
            }

            ob_flush(); // dump buffer
            fclose($open_file);
            exit;
        } catch (\Throwable $th) {
            $error_message = urlencode($th->getMessage());
            exit(header("Location: /wp-admin/admin.php?page=kinde-auth&error_export=$error_message"));
        }
    }
}
