<?php
/*
Plugin Name: Fathom Analytics
Description: Fathom analytics is a simple, GDPR-compliant alternative to Google Analytics.
Author: Conva Ventures Inc
Version: 3.0.8

Fathom Analytics for WordPress
Copyright (C) 2020 Conva Ventures Inc

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

const FATHOM_PLUGIN_VERSION = '3.0.8';
const FATHOM_CUSTOM_DOMAIN_OPTION_NAME = 'fathom_custom_domain';
const FATHOM_URL_OPTION_NAME = 'fathom_url';
const FATHOM_SITE_ID_OPTION_NAME = 'fathom_site_id';
const FATHOM_ADMIN_TRACKING_OPTION_NAME = 'fathom_track_admin';
const FATHOM_PRIVATE_SHARE_PASSWORD = 'fathom_share_password';
const FATHOM_SHOW_ANALYTICS_MENU_ITEM = 'fathom_show_menu';

/**
 * Define a few helpful plugin constants if they don't exist.
 */
if ( ! defined( 'FATHOM_PLUGIN_FILE' ) ) {
	define( 'FATHOM_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'FATHOM_PLUGIN_BASENAME' ) && defined( 'FATHOM_PLUGIN_FILE' ) ) {
    define ( 'FATHOM_PLUGIN_BASENAME', plugin_basename( FATHOM_PLUGIN_FILE ) );
}

if ( ! defined( 'FATHOM_SETTINGS_URL' ) ) {
    define( 'FATHOM_SETTINGS_URL', admin_url( 'options-general.php?page=fathom-analytics' ) );
}

/**
* @since 1.0.0
*/
function fathom_get_url()
{
    $fathom_url = get_option(FATHOM_URL_OPTION_NAME, '');

    // don't print snippet if fathom URL is empty
    if (empty($fathom_url)) {
        return 'cdn.usefathom.com';
    }

    // trim trailing slash
    $fathom_url = rtrim($fathom_url, '/');

    // make relative
    $fathom_url = str_replace(array( 'https:', 'http:' ), '', $fathom_url);

    return $fathom_url;
}

/**
* @since 1.0.1
*/
function fathom_get_site_id()
{
    return get_option(FATHOM_SITE_ID_OPTION_NAME, '');
}

/**
 * @since 1.0.1
 */
function fathom_get_admin_tracking()
{
    return get_option(FATHOM_ADMIN_TRACKING_OPTION_NAME, '');
}

/**
* @since 3.0.8
*/
function fathom_enqueue_js_snippet()
{
    $url           = fathom_get_url();
    $exclude_admin = fathom_get_admin_tracking();

    if (
        empty( $url ) ||
        empty( $exclude_admin ) && current_user_can( 'manage_options' )
    ) {
        return;
    }

    wp_enqueue_script( 'fathom-snippet', 'https://cdn.usefathom.com/script.js', array(), FATHOM_PLUGIN_VERSION, array( 'strategy' => 'defer' ) );
}

/**
 * Add data attributes to the Fathom script tag.
 *
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @param string $src    The script source.
 *
 * @return string The modified script tag.
 *
 * @since 3.0.6
 */
function fathom_add_data_attributes_to_js_script( $tag, $handle, $src )
{
    if ( 'fathom-snippet' === $handle ) {
        $tag = str_replace( '></script>', ' data-site="' . fathom_get_site_id() . '" data-no-minify></script>', $tag );
    }

    return $tag;
}

/**
 * @since 2.0.0
 */
function fathom_stats_page()
{
    add_menu_page('Fathom', 'Analytics', 'edit_pages', 'analytics', 'fathom_print_stats_page', 'dashicons-chart-bar', 6);
}

/**
* @since 2.0.0
*/
function fathom_print_stats_page()
{
    if (!empty(get_option(FATHOM_SITE_ID_OPTION_NAME))) {
        wp_enqueue_script('fathom-iframresize', plugins_url('iframeResizer.min.js', __FILE__));
        wp_enqueue_script('fathom-stats-iframe', plugins_url('fathom-stats-iframe.js', __FILE__));
        echo '<div class="wrap">';
        echo '<iframe id="fathom-stats-iframe" src="https://app.usefathom.com/share/' . esc_attr(get_option(FATHOM_SITE_ID_OPTION_NAME)) . '/wordpress?password=' . hash('sha256', get_option(FATHOM_PRIVATE_SHARE_PASSWORD)) . '" style="width: 1px;min-width: 100%; height:1000px; max-width:1100px" frameborder="0" onload=fathomResizeIframe();></iframe>';
        echo '</div>';
    } else {
        echo '<div class="wrap">You have not configured Fathom. Go to Settings -> Fathom Analytics to configure this page.</div>';
    }
}

/**
* @since 1.0.0
*/
function fathom_register_settings()
{
    $fathom_logo_html = sprintf('<a href="https://usefathom.com/" style="margin-left: 6px;"><img src="%s" width=20 height=20 style="vertical-align: bottom;"></a>', plugins_url('fathom.png', __FILE__));

    // register page + section
    add_options_page('Fathom Analytics', 'Fathom Analytics', 'manage_options', 'fathom-analytics', 'fathom_print_settings_page');
    add_settings_section('default', "Fathom Analytics {$fathom_logo_html}", '__return_true', 'fathom-analytics');

    // register options
    register_setting('fathom', FATHOM_SITE_ID_OPTION_NAME, array( 'type' => 'string' ));
    register_setting('fathom', FATHOM_ADMIN_TRACKING_OPTION_NAME, array( 'type' => 'string'));
    register_setting('fathom', FATHOM_PRIVATE_SHARE_PASSWORD, array( 'type' => 'string' ));
    register_setting('fathom', FATHOM_SHOW_ANALYTICS_MENU_ITEM, array( 'type' => 'boolean', 'default' => 1 ));
    register_setting('fathom', FATHOM_CUSTOM_DOMAIN_OPTION_NAME, array( 'type' => 'string' ));

    // register settings fields
    add_settings_field(FATHOM_SITE_ID_OPTION_NAME, __('Site ID', 'fathom-analytics'), 'fathom_print_site_id_setting_field', 'fathom-analytics', 'default');
    add_settings_field(FATHOM_ADMIN_TRACKING_OPTION_NAME, __('Track Administrators', 'fathom-analytics'), 'fathom_print_admin_tracking_setting_field', 'fathom-analytics', 'default');
    add_settings_field(FATHOM_CUSTOM_DOMAIN_OPTION_NAME, __('Custom Domain', 'fathom-analytics'), 'fathom_print_custom_domain_setting_field', 'fathom-analytics', 'default');
    add_settings_field(FATHOM_PRIVATE_SHARE_PASSWORD, __('Fathom Share Password', 'fathom-analytics'), 'fathom_print_share_password_setting_field', 'fathom-analytics', 'default');
    add_settings_field(FATHOM_SHOW_ANALYTICS_MENU_ITEM, __('Display Analytics Menu Item', 'fathom-analytics'), 'fathom_print_display_analytics_menu_setting_field', 'fathom-analytics', 'default');
}

/**
* @since 1.0.1
*/
function fathom_print_settings_page()
{
    echo '<div class="wrap">';
    echo sprintf('<form method="POST" action="%s">', esc_attr(admin_url('options.php')));
    settings_fields('fathom');
    do_settings_sections('fathom-analytics');
    submit_button();
    echo '</form>';
    echo '</div>';
}

/**
 * @since 2.0.0
 */
function fathom_print_display_analytics_menu_setting_field($args = array())
{
    $value = get_option(FATHOM_SHOW_ANALYTICS_MENU_ITEM);
    echo sprintf('<input type="checkbox" name="%s" id="%s" class="regular-text" ' . (esc_attr($value) ? 'checked' : '') .' />', FATHOM_SHOW_ANALYTICS_MENU_ITEM, FATHOM_SHOW_ANALYTICS_MENU_ITEM);
    echo '<p class="description">' . __('Pro: Display the Fathom Tab in the sidebar (This is only available if you have enabled site sharing)', 'fathom-analytics') . '</p>';
}

/**
* @since 2.0.0
*/
function fathom_print_share_password_setting_field($args = array())
{
    $value = get_option(FATHOM_PRIVATE_SHARE_PASSWORD);
    $placeholder = '';
    echo sprintf('<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_PRIVATE_SHARE_PASSWORD, FATHOM_PRIVATE_SHARE_PASSWORD, esc_attr($value), esc_attr($placeholder));
    echo '<p class="description">' . __('Required if you have shared your dashboard privately. Publicly shared dashboards do not need a password', 'fathom-analytics') . '</p>';
}

/**
* @since 2.0.1
*/
function fathom_print_custom_domain_setting_field($args = array())
{
    $value = get_option(FATHOM_CUSTOM_DOMAIN_OPTION_NAME);
    $placeholder = 'https://cname.yourwebsite.com';
    echo sprintf('<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_CUSTOM_DOMAIN_OPTION_NAME, FATHOM_CUSTOM_DOMAIN_OPTION_NAME, esc_attr($value), esc_attr($placeholder));
    echo '<p class="description">' . __('Optional. Do not put anything in here unless you have a custom domain', 'fathom-analytics') . '</p>';
}

/**
* @since 1.0.1
*/
function fathom_print_site_id_setting_field($args = array())
{
    $value = get_option(FATHOM_SITE_ID_OPTION_NAME);
    $placeholder = 'ABCDEF';
    echo sprintf('<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_SITE_ID_OPTION_NAME, FATHOM_SITE_ID_OPTION_NAME, esc_attr($value), esc_attr($placeholder));
    echo '<p class="description">' . __('This is the <a href="https://usefathom.com/support/wordpress" target="_blank">unique Tracking ID</a> for your site', 'fathom-analytics') . '</p>';
}

/**
 * @since 1.0.1
 */
function fathom_print_admin_tracking_setting_field($args = array())
{
    $value = get_option(FATHOM_ADMIN_TRACKING_OPTION_NAME);
    echo sprintf('<input type="checkbox" name="%s" id="%s" value="1" %s />', FATHOM_ADMIN_TRACKING_OPTION_NAME, FATHOM_ADMIN_TRACKING_OPTION_NAME, checked(1, $value, false));
    echo '<p class="description">' . __('Check if you want to track visits by administrators', 'fathom-analytics') . '</p>';
}

add_action( 'wp_enqueue_scripts', 'fathom_enqueue_js_snippet' );
add_filter( 'script_loader_tag', 'fathom_add_data_attributes_to_js_script', 10, 3 );

if (is_admin() && ! wp_doing_ajax()) {
    add_action('admin_menu', 'fathom_register_settings');
}

if (get_option(FATHOM_SHOW_ANALYTICS_MENU_ITEM)) {
    add_action('admin_menu', 'fathom_stats_page');
}

/**
 * Adds link to Settings page in plugin action links.
 *
 * @since 3.0.8
 *
 * @param array  $plugin_links Already defined action links.
 * @param string $plugin_file Plugin file path and name being processed.
 * @return array $plugin_links The new array of action links.
 */
function add_plugin_action_links( $plugin_links, $plugin_file ) {

	// Abort if not dealing with Fathom plugin
	if ( FATHOM_PLUGIN_BASENAME !== $plugin_file ) {
		return $plugin_links;
	}

	$settings_link  = '<a href="' . FATHOM_SETTINGS_URL . '" aria-label="' . esc_attr( __( 'Navigate to the Fathom Analytics settings.', 'fathom' ) ) . '">';
	$settings_link .= __( 'Settings', 'fathom' );
	$settings_link .= '</a>';

    // Add Settings link beside 'Deactivate'
	array_unshift( $plugin_links, $settings_link );

	return $plugin_links;
}
add_filter( 'plugin_action_links', 'add_plugin_action_links', 10, 2 );
