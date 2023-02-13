<?php
    $selectedText = 'selected="selected"';
?>

<div class="a0-wrap settings wrap">
  <div class="container-fluid">
    <h1 class="postbox-header">Kinde Authorization Setup Wizard</h1>
    <form action="options.php" method="POST">
        <?php settings_fields('kinde-auth'); ?>
        <?php do_settings_sections('kinde-auth'); ?>
        <?php settings_errors('kinde_auth_notice'); ?>
        <p class="sub-title">Please inform these fields value</p>
        <table class="form-table" aria-describedby="Configuration Kinde">
            <tbody>
                <tr>
                    <th>
                        <label for="kinde_auth_token_host">Token host <code class="text-required">*</code></label>
                    </th>
                    <td>
                        <input
                            name="kinde_auth_token_host"
                            type="text" id="kinde_auth_token_host"
                            placeholder="Ex: https://test.kinde.com"
                            value="<?php echo esc_attr(get_option('kinde_auth_token_host')); ?>"
                            class="regular-text"
                        />
                        <p class="description">The token host in the authorization server</p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="kinde_auth_client_id">Client ID <code class="text-required">*</code></label>
                    </th>
                    <td>
                        <input
                            name="kinde_auth_client_id"
                            type="text" id="kinde_auth_client_id"
                            placeholder="Ex: example@live"
                            value="<?php echo esc_attr(get_option('kinde_auth_client_id')); ?>"
                            class="regular-text"
                        />
                        <p class="description">The client identifier in the authorization server</p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="kinde_auth_client_secret">Client Secret <code class="text-required">*</code></label>
                    </th>
                    <td>
                        <input
                            name="kinde_auth_client_secret"
                            type="password"
                            id="kinde_auth_client_secret"
                            value="<?php echo esc_attr(get_option('kinde_auth_client_secret')); ?>"
                            class="regular-text"
                        />
                        <p class="description">The secret token for the client in the authorization server</p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="kinde_auth_grant_type">Grant Type</label>
                    </th>
                    <td>
                    <select name="kinde_auth_grant_type" id="kinde_auth_grant_type" class="regular-text">
                        <?php
                            use Kinde\KindeSDK\Sdk\Enums\GrantType;

                            $grantTypes = [
                                'client_credentials' => 'Client Credentials',
                                'authorization_code' => 'Authorization Code',
                                'authorization_code_flow_pkce' => 'Authorization Code with PKCE',
                            ];

                            $grantType = esc_attr(get_option('kinde_auth_grant_type', GrantType::authorizationCode));
                            foreach ($grantTypes as $key => $value) {
                                $selected = '';
                                if ($grantType == $key) {
                                    $selected = $selectedText;
                                }
                        ?>
                                <option
                                    <?php echo esc_html($selected) ?>
                                    value="<?php echo esc_html($key) ?>"
                                >
                                <?php echo esc_html($value) ?>
                                </option>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="kinde_auth_auto_user_role">Auto Create User as Role</label>
                    </th>
                    <td>
                    <select name="kinde_auth_auto_user_role" id="kinde_auth_auto_user_role" class="regular-text">
                        <?php
                            $userKindeRoles = [
                                'subscriber' => 'Subscriber',
                                'contributor' => 'Contributor',
                                'author' => 'Author',
                                'editor' => 'Editor',
                                'administrator' => 'Administrator',
                            ];

                            $userKindeRole = esc_attr(get_option('kinde_auth_auto_user_role', $userKindeRoles[0]));
                            foreach ($userKindeRoles as $key => $value) {
                                $selected = '';
                                if ($userKindeRole == $key) {
                                    $selected = $selectedText;
                                }
                        ?>
                                <option
                                    <?php echo esc_html($selected) ?>
                                    value="<?php echo esc_html($key) ?>"
                                >
                                    <?php echo esc_html($value) ?>
                                </option>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="kinde_auth_default_login_page">Default Login Page</label></th>
                    <td>
                    <select
                        name="kinde_auth_default_login_page"
                        id="kinde_auth_default_login_page"
                        class="regular-text"
                        onchange="changeLoginPage(this)"
                    >
                        <?php
                            $defaultLoginPages = [
                                'wordpress' => 'Wordpress Login Page',
                                'kinde' => 'Kinde Login Page',
                            ];

                            $defaultLogin = esc_attr(get_option('kinde_auth_default_login_page', $defaultLoginPages[0]));
                            foreach ($defaultLoginPages as $key => $value) {
                                $selected = '';
                                if ($defaultLogin == $key) {
                                    $selected = $selectedText;
                                }
                        ?>
                                <option <?php echo esc_html($selected) ?>
                                    value="<?php echo esc_html($key) ?>"
                                >
                                <?php echo esc_html($value) ?>
                                </option>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="kinde_auth_site_protocol">Your Site Protocol</label>
                    </th>
                    <td>
                    <select name="kinde_auth_site_protocol" id="kinde_auth_site_protocol" class="regular-text">
                        <?php
                            $siteProtocols = [
                                'http' => 'HTTP',
                                'https' => 'HTTPS'
                            ];

                            $siteProtocol = esc_attr(get_option('kinde_auth_site_protocol')) ?? $siteProtocols[0];
                            foreach ($siteProtocols as $key => $value) {
                                $selected = '';
                                if ($siteProtocol == $key) {
                                    $selected = $selectedText;
                                }
                        ?>
                                <option
                                    <?php echo esc_html($selected) ?>
                                    value="<?php echo esc_html($key) ?>"
                                >
                                <?php echo esc_html($value) ?>
                                </option>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="sub-title">
            <strong>NOTE: </strong> Remember inform the <code>YOUR_SITE_URL/kinde-authenticate/response</code> into the
            <code>Allowed callback URLs</code> field of Kinde Authorization server
        </p>
        <?php submit_button(); ?>
    </form>
    <div class="kinde-export-users">
        <h2 class="sub-title">Export wordpress users</h2>
        <?php
            $error_export_field = sanitize_text_field($_GET['error_export'] ?? '');
            if (!empty($error_export_field)) {
        ?>
            <p class="export-error">
                <strong><?php echo esc_html(urldecode($error_export_field) ?? 'Something went wrong!!!') ?></strong>
            </p>
        <?php
            }
        ?>
        <a href="/kinde-authenticate/export-wp-users" class="button button-primary">Exports Data</a>
        <p class="sub-title">
            <strong>NOTE: </strong> You can export wordpress users and import to the kinde authorization server
        </p>
    </div>
    </div>
<style>
    h1.postbox-header {
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-family: inherit;
        font-size: 1.5rem;
        font-weight: bold;
        border-left: 4px solid #e91e63;
        padding-left: 20px;
    }

    p.sub-title {
        color: #333333;
        font-size: 0.9rem;
        font-family: inherit;
    }
    .text-required {
        color: #d63638;
    }

    .export-error {
        color: #d63638;
        font-size: 0.8rem;
    }

    .kinde-export-users {
        padding-top: 10px;
        border-top: 1px solid #c3c4c7
    }

    .kinde-export-users h2 {
        font-size: 1.2rem;
        font-weight: bold;
    }

    @media screen and (min-width: 786px){
        .form-table th {
            width: 300px;
        }
    }
</style>

