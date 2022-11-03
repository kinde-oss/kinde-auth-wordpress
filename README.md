Kinde Auth Plugin
=========================

A product developed by Kinde

## How to install Kinde Auth Plugin?

### Install from `plugin.zip` file

- Download or clone the `plugin.zip` file from `GitHub` or `Plugin site`

- Go to your WordPress plugins page at this URL `YOUR_WORDPRESS_URL/wp-admin/plugins.php`

- Click `Add new` then click `Upload Plugins`

- Choose the `plugin.zip` file and click `Install Now`

- Active plugin and finish installation!!!

### Install from a plugin marketplace

- Not supported yet

## How to config plugin?

### Config in a WordPress site

- Go to the plugin setting page at `YOUR_WORDPRESS_URL/wp-admin/admin.php?page=kinde-auth`

- Enter value for `Token host`, `Client ID`, `Client Secret`, `Grant Type`, `Auto Create User as Role`, `Default Login Page`

- For the Grant Type, choose one of the two methods `Authorization Code`, `Authorization Code with PKCE`

- Click `Save Changes` button to save your config

### Config on Kinde Authorization Server

- Go to your Kinde server at this URL: `https://app.kinde.com/auth/*`

- Navigate to the `App keys` menu page

- Fill `YOUR_WORDPRESS_URL/kinde-authenticate/response` into the `Allowed callback URLs` field

- Click `Save` button and finish configuration!!!

## How to use?

There are 3 ways to use Kinde Auth plugin on your website:

### Use by setting up in the `Kinde Login Page` for `Default Login Page`field

- Set `Kinde Login Page` value for `Default Login Page` field on the admin setup wizard

Note: This method will override all login URLs based on your website and create a new WordPress URL for default login `/wp-new-login`

### Use by Shortcode

- Login button Shortcode `[kinde_auth_login_button title="YOUR_TITLE"]` -> title default: Sign In With Kinde

- Register button Shortcode `[kinde_auth_register_button title="YOUR_TITLE"]` -> title default: Sign Up With Kinde

- Logout button Shortcode `[kinde_auth_logout_button]`

### Use by links

- Login URL: `/kinde-authenticate/login`

- Register URL: `/kinde-authenticate/register`

- Logout URL: `/kinde-authenticate/logout`