=== Kinde Auth ===
Contributors: kinde
Donate link: https://kinde.com/
Tags: auth, kinde
Requires at least: 4.9
Tested up to: 6.1.1
Stable tag: 1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Easily add Kinde Authorization on your WordPress site

== Description ==

[Kinde](https://kinde.com/) is a new era of authentication with simple, powerful authentication you can integrate with your product in minutes.

Kinde supports all of the most popular languages including JavaScript (React, React Native, Node Express, Node NextJs), PHP, .NET

== Installation ==

1. Upload the `kinde-auth` folder to the `/wp-content/plugins/` directory or install directly through the plugin installer
2. Activate the plugin through the 'Plugins' menu in WordPress or by using the link provided by the plugin installer
3. Visit the settings page in the Admin at `/wp-admin/admin.php?page=kinde-auth` and configure the plugin with your account details

== Frequently Asked Questions ==

= How to configure this plugin? =
1. Go to the plugin setting page at `YOUR_WORDPRESS_URL/wp-admin/admin.php?page=kinde-auth`
2. Enter value for `Token host`, `Client ID`, `Client Secret`, `Grant Type`, `Auto Create User as Role`, `Default Login Page`, `Your Site Protocol`
3. For the Grant Type, choose one of the two methods `Authorization Code`, `Authorization Code with PKCE`
4. For the Your Site Protocol, choose one of the two methods `HTTP`, `HTTPS`
5. Click `Save Changes` button to save your config

= How to Config on Kinde Authorization Server? =
1. If you don't have an account, go to the `https://app.kinde.com/register` to register an account
2. If you have account then, go to `https://app.kinde.com/admin` to login
3. Navigate to the `Settings -> Applications` menu page
4. Click to the `Backend app (Regular Web Application)` to show the config page
5. Fill `YOUR_WORDPRESS_URL/kinde-authenticate/response` into the `Allowed callback URLs` field
6. Click `Save` button and finish configuration

= How to use? =
There are 3 ways to use Kinde Auth plugin on your website:

1. Use by setting up in the `Kinde Login Page` for `Default Login Page`field
1.1. Set `Kinde Login Page` value for `Default Login Page` field on the admin setup wizard
Note: This method will override all login URLs based on your website and create a new WordPress URL for default login `/wp-new-login`

2. Use by Shortcode
2.1. Login button Shortcode `[kinde_auth_login_button title="YOUR_TITLE"]` -> title default: Sign In With Kinde
2.2. Register button Shortcode `[kinde_auth_register_button title="YOUR_TITLE"]` -> title default: Sign Up With Kinde
2.3. Logout button Shortcode `[kinde_auth_logout_button]`

3. Use by links
3.1. Login URL: `/kinde-authenticate/login`
3.2. Register URL: `/kinde-authenticate/register`
3.3. Logout URL: `/kinde-authenticate/logout`

= I need help installing, configuring Kinde. =
Please visit [our document site at https://kinde.com/docs](https://kinde.com/docs/) for more information.

= I found a bug in the plugin. =
Please post it in the [WordPress support forum](https://wordpress.org/support/plugin/kinde-auth/) and we'll fix it right away. Thanks for helping.

== Screenshots ==

1. Configuration options for using the Kinde Auth

== Changelog ==

= 1.0 (2023-02-08): =
* FIX BUG feedbacks review form WordPress Plugin Support
* UPGRADE Kinde SDK PHP library from version 0.0.1 to 0.0.2

= 0.0.1 (2022-11-18): =
* Initial Release

== Upgrade Notice ==

= 1.0 =
UPGRADE Kinde SDK PHP library from version 0.0.1 to 0.0.2