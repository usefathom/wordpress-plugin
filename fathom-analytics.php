<?php
/*
Plugin Name: Fathom Analytics
Description: A simple plugin to add the Fathom tracking snippet to your WordPress site.
Author: Conva Ventures Inc
Note: Huge thanks to Danny Van Kooten for his hard work on Version 1 of this plugin
Version: 2.0.0

Fathom Analytics for WordPress
Copyright (C) 2019 Conva Ventures Inc

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


const FATHOM_URL_OPTION_NAME = 'fathom_url';
const FATHOM_SITE_ID_OPTION_NAME = 'fathom_site_id';
const FATHOM_ADMIN_TRACKING_OPTION_NAME = 'fathom_track_admin';
const FATHOM_PRIVATE_SHARE_PASSWORD = 'fathom_share_password';
const FATHOM_SHOW_ANALYTICS_MENU_ITEM = 'fathom_show_menu';

/**
* @since 1.0.0
*/
function fathom_get_url() {
    $fathom_url = get_option( FATHOM_URL_OPTION_NAME, '' );

    // don't print snippet if fathom URL is empty
   if( empty( $fathom_url ) ) {
      return 'cdn.usefathom.com';
   }

   // trim trailing slash
   $fathom_url = rtrim( $fathom_url, '/' );

   // make relative
   $fathom_url = str_replace( array( 'https:', 'http:' ), '', $fathom_url );

   return $fathom_url;
}

/**
* @since 1.0.1
*/
function fathom_get_site_id() {
    return get_option( FATHOM_SITE_ID_OPTION_NAME, '' );
}

/**
 * @since 1.0.1
 */
function fathom_get_admin_tracking() {
    return get_option( FATHOM_ADMIN_TRACKING_OPTION_NAME, '');
}

/**
* @since 1.0.0
*/
function fathom_print_js_snippet() {
   $url = fathom_get_url();
   $exclude_admin = fathom_get_admin_tracking();
   	
    // don't print snippet if fathom URL is empty
   if( empty( $url ) ) {
      return;
   }

   if( empty( $exclude_admin ) && current_user_can('manage_options') ) {
       return;
   }

   $site_id = fathom_get_site_id();

   if (empty($site_id)) {
      return;
   }

    ?>
   <!-- Fathom - simple website analytics - https://usefathom.com/ -->
   <script>
   (function(f, a, t, h, o, m){
      a[h]=a[h]||function(){
         (a[h].q=a[h].q||[]).push(arguments)
      };
      o=f.createElement('script'),
      o.id=h+'-script';
      m=f.getElementsByTagName('script')[0];
      o.async=1; o.src=t;
      m.parentNode.insertBefore(o,m)
   })(document, window, 'https://<?php echo esc_attr( $url ); ?>/tracker.js', 'fathom');
   fathom('set', 'siteId', '<?php echo esc_attr( $site_id ); ?>');
   fathom('trackPageview');
   </script>
   <!-- / Fathom -->
   <?php
}

/**
 * @since 2.0.0
 */
function fathom_stats_page() {
   add_menu_page( 'Fathom', 'Analytics', 'edit_pages', 'analytics', 'fathom_print_stats_page', 'dashicons-chart-bar', 6  );
}

/**
* @since 2.0.0
*/
function fathom_print_stats_page() {
   wp_enqueue_script('fathom-iframresize', plugins_url('iframeResizer.min.js', __FILE__));
   wp_enqueue_script('fathom-stats-iframe', plugins_url('fathom-stats-iframe.js', __FILE__));
   echo '<div class="wrap">';
   echo '<iframe id="fathom-stats-iframe" src="https://app.usefathom.com/share/' . get_option( FATHOM_SITE_ID_OPTION_NAME ) . '/wordpress?password=' . hash('sha256', get_option( FATHOM_PRIVATE_SHARE_PASSWORD )) . '" style="width: 1px;min-width: 100%; height:1000px; max-width:1100px" frameborder="0" onload=fathomResizeIframe();></iframe>';
   echo '</div>';
}

/**
* @since 1.0.0
*/
function fathom_register_settings() {
   $fathom_logo_html = sprintf( '<a href="https://usefathom.com/" style="margin-left: 6px;"><img src="%s" width=20 height=20 style="vertical-align: bottom;"></a>', plugins_url( 'fathom.png', __FILE__ ) );

   // register page + section
   add_options_page( 'Fathom Analytics', 'Fathom Analytics', 'manage_options', 'fathom-analytics', 'fathom_print_settings_page' );
   add_settings_section(  'default', "Fathom Analytics {$fathom_logo_html}", '__return_true', 'fathom-analytics' );

   // register options
   register_setting( 'fathom', FATHOM_SITE_ID_OPTION_NAME, array( 'type' => 'string' ) );
   register_setting( 'fathom', FATHOM_ADMIN_TRACKING_OPTION_NAME, array( 'type' => 'string') );
   register_setting( 'fathom', FATHOM_URL_OPTION_NAME, array( 'type' => 'string' ) );
   register_setting( 'fathom', FATHOM_PRIVATE_SHARE_PASSWORD, array( 'type' => 'string' ) );
   register_setting( 'fathom', FATHOM_SHOW_ANALYTICS_MENU_ITEM, array( 'type' => 'boolean' ) );

   // register settings fields
   add_settings_field( FATHOM_SITE_ID_OPTION_NAME, __( 'Site ID', 'fathom-analytics' ), 'fathom_print_site_id_setting_field', 'fathom-analytics', 'default' );
   add_settings_field( FATHOM_ADMIN_TRACKING_OPTION_NAME, __('Track Administrators', 'fathom-analytics'), 'fathom_print_admin_tracking_setting_field', 'fathom-analytics', 'default');
   add_settings_field( FATHOM_SHOW_ANALYTICS_MENU_ITEM,  __( 'Display Analytics Menu Item', 'fathom-analytics' ), 'fathom_print_display_analytics_menu_setting_field', 'fathom-analytics', 'default' );
   add_settings_field( FATHOM_PRIVATE_SHARE_PASSWORD, __( 'Fathom Share Password', 'fathom-analytics' ), 'fathom_print_share_password_setting_field', 'fathom-analytics', 'default' );
   add_settings_field( FATHOM_URL_OPTION_NAME, __( 'Fathom URL', 'fathom-analytics' ), 'fathom_print_url_setting_field', 'fathom-analytics', 'default' );
}

/**
* @since 1.0.1
*/
function fathom_print_settings_page() {
   echo '<div class="wrap">';
   echo sprintf( '<form method="POST" action="%s">', esc_attr( admin_url( 'options.php' ) ) );
   settings_fields( 'fathom' );
   do_settings_sections( 'fathom-analytics' );
   submit_button();
   echo '</form>';
   echo '</div>';
}

/**
 * @since 2.0.0
 */
function fathom_print_display_analytics_menu_setting_field( $args = array() ) {
   $value = get_option( FATHOM_SHOW_ANALYTICS_MENU_ITEM );
   echo sprintf( '<input type="checkbox" name="%s" id="%s" class="regular-text" ' . (esc_attr($value) ? 'checked' : '') .' />', FATHOM_SHOW_ANALYTICS_MENU_ITEM, FATHOM_SHOW_ANALYTICS_MENU_ITEM);
   echo '<p class="description">' . __( 'Display the Fathom Tab', 'fathom-analytics' ) . '</p>';
}

/**
* @since 2.0.0
*/
function fathom_print_share_password_setting_field( $args = array() ) {
   $value = get_option( FATHOM_PRIVATE_SHARE_PASSWORD );
   echo sprintf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_PRIVATE_SHARE_PASSWORD, FATHOM_PRIVATE_SHARE_PASSWORD, esc_attr( $value ), esc_attr( $placeholder ) );
   echo '<p class="description">' . __( 'If you don\'t set a password here, the user will be prompted to enter one on the Analytics menu option', 'fathom-analytics' ) . '</p>';
}

/**
* @since 1.0.0
*/
function fathom_print_url_setting_field( $args = array() ) {
   $value = get_option( FATHOM_URL_OPTION_NAME );
   $placeholder = 'https://my-stats.usefathom.com/';
   echo sprintf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_URL_OPTION_NAME, FATHOM_URL_OPTION_NAME, esc_attr( $value ) ?: 'cdn.usefathom.com', esc_attr( $placeholder ) );
   echo '<p class="description">' . __( 'Only edit this value if you are using Fathom Lite', 'fathom-analytics' ) . '</p>';
}

/**
* @since 1.0.1
*/
function fathom_print_site_id_setting_field( $args = array() ) {
   $value = get_option( FATHOM_SITE_ID_OPTION_NAME );
   $placeholder = 'ABCDEF';
   echo sprintf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_SITE_ID_OPTION_NAME, FATHOM_SITE_ID_OPTION_NAME, esc_attr( $value ), esc_attr( $placeholder ) );
   echo '<p class="description">' . __( 'This is the <a href="https://usefathom.com/support/wordpress" target="_blank">unique Tracking ID</a> for your site', 'fathom-analytics' ) . '</p>';
}

/**
 * @since 1.0.1
 */
function fathom_print_admin_tracking_setting_field( $args = array() ) {
    $value = get_option( FATHOM_ADMIN_TRACKING_OPTION_NAME );
    echo sprintf( '<input type="checkbox" name="%s" id="%s" value="1" %s />', FATHOM_ADMIN_TRACKING_OPTION_NAME, FATHOM_ADMIN_TRACKING_OPTION_NAME, checked( 1, $value, false ) );
    echo '<p class="description">' . __( 'Check if you want to track visits by administrators', 'fathom-analytics' ) . '</p>';
}

add_action( 'wp_head', 'fathom_print_js_snippet', 50 );

if( is_admin() && ! wp_doing_ajax() ) {
   add_action( 'admin_menu', 'fathom_register_settings' );
}

if (get_option( FATHOM_SHOW_ANALYTICS_MENU_ITEM )) {
   add_action( 'admin_menu', 'fathom_stats_page' );
}

/**
 * Adds link to Settings page in plugin action links.
 *
 * @since 2.0.1
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
