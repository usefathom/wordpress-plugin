<?php
/*
Plugin Name: Fathom Analytics
Description: A simple plugin to add the Fathom tracking snippet to your WordPress site.
Author: Fathom Team
Version: 1.0.1

Fathom Analytics for WordPress
Copyright (C) 2018 Danny van Kooten

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

const FATHOM_URL_OPTION_NAME = 'fathom_url';
const FATHOM_SITE_ID_OPTION_NAME = 'fathom_site_id';

/**
* @since 1.0.0
*/
function fathom_get_url() {
    $fathom_url = get_option( FATHOM_URL_OPTION_NAME, '' );
   	
    // don't print snippet if fathom URL is empty
   if( empty( $fathom_url ) ) {
      return '';
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
* @since 1.0.0
*/
function fathom_print_js_snippet() {
   $url = fathom_get_url();
   	
    // don't print snippet if fathom URL is empty
   if( empty( $url ) ) {
      return;
   }

   $site_id = fathom_get_site_id();

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
   })(document, window, '//<?php echo esc_attr( $url ); ?>/tracker.js', 'fathom');
   fathom('set', 'siteId', '<?php echo esc_attr( $site_id ); ?>');	
   fathom('trackPageview');
   </script>
   <!-- / Fathom -->
   <?php
}

/**
* @since 1.0.0
*/
function fathom_register_settings() {
   $fathom_logo_html = sprintf( '<a href="https://usefathom.com/" style="margin-left: 6px;"><img src="%s" width=16 height=16 style="vertical-align: bottom;"></a>', plugins_url( 'fathom.svg', __FILE__ ) );
   
   // register page + section
   add_options_page( 'Fathom Analytics', 'Fathom Analytics', 'manage_options', 'fathom-analytics', 'fathom_print_settings_page' );
   add_settings_section(  'default', "Fathom Analytics {$fathom_logo_html}", '__return_true', 'fathom-analytics' );

   // register options
   register_setting( 'fathom', FATHOM_URL_OPTION_NAME, array( 'type' => 'string' ) );
   register_setting( 'fathom', FATHOM_SITE_ID_OPTION_NAME, array( 'type' => 'string' ) );

   // register settings fields
   add_settings_field( FATHOM_URL_OPTION_NAME, __( 'Dashboard URL', 'fathom-analytics' ), 'fathom_print_url_setting_field', 'fathom-analytics', 'default' );

   add_settings_field( FATHOM_SITE_ID_OPTION_NAME, __( 'Site ID', 'fathom-analytics' ), 'fathom_print_site_id_setting_field', 'fathom-analytics', 'default' );
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
* @since 1.0.0
*/
function fathom_print_url_setting_field( $args = array() ) {
   $value = get_option( FATHOM_URL_OPTION_NAME );
   $placeholder = 'https://my-stats.usefathom.com/';
   echo sprintf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_URL_OPTION_NAME, FATHOM_URL_OPTION_NAME, esc_attr( $value ), esc_attr( $placeholder ) );
   echo '<p class="description">' . __( 'Enter the full URL to your Fathom instance here.', 'fathom-analytics' ) . '</p>';
}

/**
* @since 1.0.1
*/
function fathom_print_site_id_setting_field( $args = array() ) {
   $value = get_option( FATHOM_SITE_ID_OPTION_NAME );
   $placeholder = 'ABCDEF';
   echo sprintf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_SITE_ID_OPTION_NAME, FATHOM_SITE_ID_OPTION_NAME, esc_attr( $value ), esc_attr( $placeholder ) );
   echo '<p class="description">' . __( 'Find your site ID by by clicking the gearwheel in your Fathom dashboard.', 'fathom-analytics' ) . '</p>';
}

add_action( 'wp_head', 'fathom_print_js_snippet', 50 );

if( is_admin() && ! wp_doing_ajax() ) {
   add_action( 'admin_menu', 'fathom_register_settings' );
}
