<?php
/*
Plugin Name: Fathom Analytics for WP
Description: Fathom analytics is a simple, GDPR-compliant alternative to Google Analytics.
Author: Conva Ventures Inc
Version: 3.3.1
Tested up to: 6.8.3

Fathom Analytics for WordPress
Copyright (C) 2025 Conva Ventures Inc

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

const FATHOM_PLUGIN_VERSION            = '3.3.1';
const FATHOM_SITE_ID_OPTION_NAME       = 'fathom_site_id';
const FATHOM_EXCLUDE_ROLES_OPTION_NAME = 'fathom_exclude_roles';
const FATHOM_PRIVATE_SHARE_PASSWORD    = 'fathom_share_password';
const FATHOM_SHOW_ANALYTICS_MENU_ITEM  = 'fathom_show_menu';
const FATHOM_IGNORE_CANONICAL          = 'fathom_ignore_canonical';

/**
 * Deprecated constants.
 *
 * These constants are deprecated and will be removed in a future version.
 */
const FATHOM_ADMIN_TRACKING_OPTION_NAME = 'fathom_track_admin';
const FATHOM_CUSTOM_DOMAIN_OPTION_NAME  = 'fathom_custom_domain';

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
* @since 1.0.1
*/
function fathom_get_site_id()
{
    return get_option(FATHOM_SITE_ID_OPTION_NAME, '');
}

/**
 * @since 3.1.0
 */
function fathom_get_excluded_roles()
{
    $excluded_roles = get_option( FATHOM_EXCLUDE_ROLES_OPTION_NAME, array() );

    if ( ! is_array( $excluded_roles ) ) {
        $excluded_roles = array();
    }

    return $excluded_roles;
}

/**
 * Determine if the current user has any of the excluded roles.
 *
 * @return void
 */
function fathom_is_excluded_from_tracking() {
    if ( ! is_user_logged_in() ) {
        return false;
    }

    $user = wp_get_current_user();

    return array_intersect( fathom_get_excluded_roles(), $user->roles );
}

/**
* @since 3.1.0
*/
function fathom_enqueue_js_snippet()
{
    if ( fathom_is_excluded_from_tracking() ) {
        return;
    }

    wp_enqueue_script( 'fathom-snippet', 'https://cdn.usefathom.com/script.js', array(), null, array( 'strategy' => 'defer' ) );
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
        $attributes = ' data-site="' . fathom_get_site_id() . '"  ' . exclude_fathom_script_from_cookiebot();

        if ( get_option( FATHOM_IGNORE_CANONICAL ) ) {
            $attributes .= ' data-canonical="false"';
        }

        $attributes .= ' data-no-minify';
        $tag = str_replace( '></script>', $attributes . '></script>', $tag );
    }

    return $tag;
}

/**
 * Get the menu icon.
 *
 * @return string
 *
 * @since 3.1.0
 */
function fathom_get_menu_icon() {
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 32 32"><path fill="currentColor" d="M31.076 5.305h-1.127a.927.927 0 0 0-.874.621l-7.027 20.159a.927.927 0 0 0 .874 1.23h1.127a.926.926 0 0 0 .873-.62l7.026-20.16a.926.926 0 0 0-.873-1.23m-25.398 6.41v-.919a.927.927 0 0 0-.926-.926H2.98v-.852c-.003-.995.221-1.591.423-1.808l.01-.012a1.04 1.04 0 0 1 .5-.273 12.087 12.087 0 0 1 1.98-.153h.34a.927.927 0 0 0 .926-.927v-.83a.924.924 0 0 0-.748-.91 9.82 9.82 0 0 0-.377-.064C5.859 4.014 4.941 4 4.761 4H4.75c-1.492 0-2.763.348-3.613 1.261l-.002.002C.304 6.178.004 7.473 0 9.047V26.39a.927.927 0 0 0 .927.927h1.126a.927.927 0 0 0 .927-.927V12.64h1.772a.927.927 0 0 0 .926-.926m11.742-1.286a6.993 6.993 0 0 0-3.598-.855 8.192 8.192 0 0 0-3.59.73 5.763 5.763 0 0 0-2.445 2.186l-.004.006a.799.799 0 0 0-.12.422.845.845 0 0 0 .567.795l.91.323a1.297 1.297 0 0 0 1.44-.407c.085-.105.177-.206.274-.3.595-.578 1.478-.918 2.851-.923a4.958 4.958 0 0 1 1.739.27c.4.145.754.394 1.025.721.515.632.84 1.608.869 3.007-1.324.02-2.498.076-3.512.17a16.505 16.505 0 0 0-3.747.78l-.004.002-.011.003h-.002a5.958 5.958 0 0 0-2.877 1.781 4.826 4.826 0 0 0-1.045 3.17v.03a5.117 5.117 0 0 0 .787 2.836 4.904 4.904 0 0 0 2.2 1.826 7.872 7.872 0 0 0 3.157.58 7.195 7.195 0 0 0 2.433-.454 7.733 7.733 0 0 0 2.39-1.411c.14-.12.271-.246.398-.376.083.54.266 1.06.54 1.533a.92.92 0 0 0 .79.441h.002l.542-.006a.926.926 0 0 0 .915-.927v-9.923a8.683 8.683 0 0 0-.672-3.548 5.346 5.346 0 0 0-2.198-2.482m-.753 11.746a5.459 5.459 0 0 1-1.83 1.907 4.492 4.492 0 0 1-2.468.7c-1.165-.001-1.948-.269-2.476-.705a2.059 2.059 0 0 1-.58-.75 2.672 2.672 0 0 1-.197-1.058c-.007-.425.1-.845.309-1.216a2.477 2.477 0 0 1 1.137-.912 10.438 10.438 0 0 1 2.875-.749 32.23 32.23 0 0 1 3.906-.274v.573a4.846 4.846 0 0 1-.676 2.485"/></svg>';

    return sprintf( 'data:image/svg+xml;base64,%s', base64_encode( $icon ) );
}

/**
 * @since 2.0.0
 */
function fathom_stats_page() {
    add_menu_page(
        __( 'Fathom Analytics', 'fathom-analytics' ),
        'Fathom Analytics',
        'edit_pages',
        'analytics',
        'fathom_print_stats_page',
        fathom_get_menu_icon(),
        6
    );
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
    // register page + section
    add_options_page( 'Fathom Analytics', 'Fathom Analytics', 'manage_options', 'fathom-analytics', 'fathom_print_settings_page' );
    add_settings_section( 'default', "Fathom Analytics", 'fathom_settings_intro', 'fathom-analytics' );

    // register options
    register_setting( 'fathom', FATHOM_SITE_ID_OPTION_NAME, array( 'type' => 'string' ) );
    register_setting( 'fathom', FATHOM_PRIVATE_SHARE_PASSWORD, array( 'type' => 'string' ) );
    register_setting( 'fathom', FATHOM_EXCLUDE_ROLES_OPTION_NAME, array( 'type' => 'multi_checkbox' ) );
    register_setting( 'fathom', FATHOM_SHOW_ANALYTICS_MENU_ITEM, array( 'type' => 'boolean', 'default' => 1 ) );
    register_setting( 'fathom', FATHOM_IGNORE_CANONICAL, array( 'type' => 'boolean', 'default' => 0 ) );

    // register settings fields
    add_settings_field( FATHOM_SITE_ID_OPTION_NAME, __( 'Site ID', 'fathom-analytics' ), 'fathom_print_site_id_setting_field', 'fathom-analytics', 'default');
    add_settings_field( FATHOM_PRIVATE_SHARE_PASSWORD, __( 'Share Password', 'fathom-analytics' ), 'fathom_print_share_password_setting_field', 'fathom-analytics', 'default');
    add_settings_field( FATHOM_EXCLUDE_ROLES_OPTION_NAME, __( 'Exclude Roles', 'fathom-analytics' ), 'fathom_print_exclude_roles_setting_field', 'fathom-analytics', 'default' );
    add_settings_field( FATHOM_SHOW_ANALYTICS_MENU_ITEM, __( 'Display Analytics Menu Item', 'fathom-analytics' ), 'fathom_print_display_analytics_menu_setting_field', 'fathom-analytics', 'default');
    add_settings_field( FATHOM_IGNORE_CANONICAL, __( 'Ignore canonicals', 'fathom-analytics' ), 'fathom_print_ignore_canonical_setting_field', 'fathom-analytics', 'default');
}

/**
 * Settings page intro HTML.
 *
 * @param array $args Display arguments.
 *
 * @return string
 *
 * @since 3.1.0
 */
function fathom_settings_intro( $args ) {
	$intro = sprintf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( 'If you are enjoying the Fathom plugin for Wordpress, <a href="https://wordpress.org/support/plugin/fathom-analytics/reviews/#new-post" target="_blank">please leave us a ⭐️⭐️⭐️⭐️⭐️ rating</a>. <strong>Huge</strong> thanks in advance :)', 'fathom-analytics' )
	);

	if ( get_option( FATHOM_CUSTOM_DOMAIN_OPTION_NAME ) ) {
		if ( isset( $_GET['action'] ) && 'remove_custom_domain' === $_GET['action'] ) {
			delete_option( FATHOM_CUSTOM_DOMAIN_OPTION_NAME );
		} else {
			$intro .= sprintf(
				'<div class="notice notice-warning"><p>%s</p><p>%s</p></div>',
				__( 'As of May 9, 2023, we can no longer support custom domains - you can read more <a target="_blank" href="https://usefathom.com/docs/script/custom-domains">here</a>.', 'fathom-analytics' ),
				sprintf(
					'<a href="%s" class="button button-secondary" style="flex-shrink:0;">%s</a>',
					esc_url( add_query_arg( 'action', 'remove_custom_domain' ) ),
					__( 'Got it!', 'fathom-analytics' )
				)
			);
		}
	}

	echo $intro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
 * Print the Ignore Canonical checkbox setting field.
 *
 * @param array $args Display arguments.
 *
 * @return void
 *
 * @since 3.2.5
 */
function fathom_print_ignore_canonical_setting_field($args = array())
{
    $value = get_option(FATHOM_IGNORE_CANONICAL);
    echo sprintf('<input type="checkbox" name="%s" id="%s" class="regular-text" ' . (esc_attr($value) ? 'checked' : '') .' />', FATHOM_IGNORE_CANONICAL, FATHOM_IGNORE_CANONICAL);
    echo '<p class="description">' . __('If there\'s a canonical link in place, we use it instead of the current URL. Check this to use the current URL instead', 'fathom-analytics') . '</p>';
}

/**
* @since 2.0.0
*/
function fathom_print_share_password_setting_field($args = array())
{
    $value = get_option(FATHOM_PRIVATE_SHARE_PASSWORD);
    $placeholder = '';
    echo sprintf('<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_PRIVATE_SHARE_PASSWORD, FATHOM_PRIVATE_SHARE_PASSWORD, esc_attr($value), esc_attr($placeholder));
    echo '<p class="description">' . __('Required if you have shared your dashboard <a href="https://usefathom.com/docs/features/shared-dashboards" target="_blank">privately</a>. Publicly shared dashboards do not need a password.', 'fathom-analytics') . '</p>';
}

/**
 * Exclude Roles Field
 *
 * @param array $args
 *
 * @return void
 */
function fathom_print_exclude_roles_setting_field( $args = array() ) {
    $wp_roles = new WP_Roles();
    $roles    = array();

    foreach ( $wp_roles->get_names() as $role => $label ) {
        $roles[ $role ] = translate_user_role( $label );
    }

    $excluded_roles = fathom_get_excluded_roles();

    echo '<fieldset>';
        foreach ( $roles as $role => $label ) {
            $checked = in_array( $role, $excluded_roles, true ) ? 'checked' : '';
            echo sprintf( '<input type="checkbox" name="%s[]" id="%s" value="%s" %s />', FATHOM_EXCLUDE_ROLES_OPTION_NAME, $role, $role, $checked );
            echo sprintf( '<label for="%s">%s</label><br />', $role, $label );
        }
    echo '</fieldset>';

    echo '<p class="description">' . __( 'Choose the roles you would like to exclude from tracking.', 'fathom-analytics' ) . '</p>';
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

add_action( 'wp_enqueue_scripts', 'fathom_enqueue_js_snippet' );
add_filter( 'script_loader_tag', 'fathom_add_data_attributes_to_js_script', 10, 3 );

/**
 * Admin only actions.
 */
if ( is_admin() && ! wp_doing_ajax() ) {
    add_action( 'admin_menu', 'fathom_register_settings' );

    if ( get_option( FATHOM_SHOW_ANALYTICS_MENU_ITEM ) ) {
        add_action( 'admin_menu', 'fathom_stats_page' );
    }
}

/**
 * Migrate old settings for admin tracking into exclusion settings.
 *
 * @since 3.1.0
 */
function fathom_migrate_settings() {

    // Remove custom domain option if it's empty.
    if ( empty( get_option( FATHOM_CUSTOM_DOMAIN_OPTION_NAME ) ) ) {
        delete_option( FATHOM_CUSTOM_DOMAIN_OPTION_NAME );
    }

    // Migrate admin tracking option to exclusion roles.
    if ( ! get_option( FATHOM_EXCLUDE_ROLES_OPTION_NAME ) ) {
        $exclude_roles = array();

        if ( ! get_option( FATHOM_ADMIN_TRACKING_OPTION_NAME ) ) {
            $exclude_roles[] = 'administrator';
        }

        add_option( FATHOM_EXCLUDE_ROLES_OPTION_NAME, $exclude_roles );
        delete_option( FATHOM_ADMIN_TRACKING_OPTION_NAME );
    }
}

if ( ! wp_doing_ajax() ) {
    fathom_migrate_settings();
}

/**
 * Adds link to Settings page in plugin action links.
 *
 * @since 3.1.0
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

	$settings_link  = '<a href="' . FATHOM_SETTINGS_URL . '" aria-label="' . esc_attr( __( 'Navigate to the Fathom Analytics settings.', 'fathom-analytics' ) ) . '">';
	$settings_link .= __( 'Settings', 'fathom-analytics' );
	$settings_link .= '</a>';

    // Add Settings link beside 'Deactivate'
	array_unshift( $plugin_links, $settings_link );

	return $plugin_links;
}
add_filter( 'plugin_action_links', 'add_plugin_action_links', 10, 2 );

/**
 * Exclude Fathom from WP Rocket minification.
 *
 * @param array $excluded The excluded hostnames.
 *
 * @since 3.2.0
 *
 * @return array
 */
function fathom_exclude_from_wp_rocket_minify( $excluded ) {
    $excluded[] = 'cdn.usefathom.com';
    return $excluded;
}

add_filter( 'rocket_minify_excluded_external_js', 'fathom_exclude_from_wp_rocket_minify' );

/**
 * Exclude Fathom from SG Optimizer minification.
 *
 * @param array $excluded The excluded hostnames.
 *
 * @since 3.2.0
 *
 * @return array
 */
function fathom_exclude_from_sg_optimizer_minify( $excluded ) {
    $excluded[] = 'cdn.usefathom.com';
    return $excluded;
}

add_filter( 'sgo_javascript_combine_excluded_external_paths', 'fathom_exclude_from_sg_optimizer_minify' );

/**
 * Exclude Fathom from Hummingbird.
 *
 * @param bool   $minify Whether to minify the resource.
 * @param string $handle The resource handle.
 * @param string $type   The resource type.
 * @param string $url    The resource URL.
 *
 * @since 3.2.0
 *
 * @return bool
 */
function fathom_exclude_from_wphb( $minify, $handle, $type, $url ) {
    if ( 'fathom-snippet' === $handle ) {
        $minify = false;
    }

    return $minify;
}

add_filter( 'wphb_minify_resource', 'fathom_exclude_from_wphb', 10, 4 );
add_filter( 'wphb_combine_resource', 'fathom_exclude_from_wphb', 10, 4 );

/**
 * Exclude Fathom from LiteSpeed.
 *
 * @param array $excluded Excluded scripts.
 *
 * @since 3.2.1
 *
 * @return bool
 */
function fathom_exclude_from_litespeed( $excluded ) {
    $excluded[] = 'cdn.usefathom.com';

    return $excluded;
}

add_filter( 'litespeed_optimize_js_excludes', 'fathom_exclude_from_litespeed' );

/**
 * Whitelist Fathom script for OptimizePress.
 *
 * @param bool $allowed Whether the script is allowed. Default is false.
 * @param string $handle The resource handle.
 *
 * @since 3.2.3
 *
 * @return bool
 */

function allow_fathom_script($allowed, $handle) {
    if ($handle === 'fathom-snippet') {
        return true;
    }
    return $allowed;
}

add_filter('op3_script_is_allowed_in_blank_template', 'allow_fathom_script', 10, 2);

/**
 * Exclude Fathom script from Cookiebot.
 *
 * @since 3.2.4
 *
 * @return string
 */

function exclude_fathom_script_from_cookiebot() {
    if ( in_array( 'cookiebot/cookiebot.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        return 'data-cookieconsent="ignore"';
    } else {
        return '';
    }
}