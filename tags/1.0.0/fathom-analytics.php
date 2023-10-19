<?php
/*
Plugin Name: Fathom Analytics
Description: A simple plugin to add the Fathom tracking snippet to your WordPress site.
Author: Fathom Team
Version: 1.0.0

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

const FATHOM_OPTION_NAME = 'fathom_url';

function fathom_print_js_snippet() {
   $fathom_url = get_option( FATHOM_OPTION_NAME, '' );

    // don't print snippet if fathom URL is empty
   if( empty( $fathom_url ) ) {
      return;
   }

   // trim trailing slash
   $fathom_url = rtrim( $fathom_url, '/' );

   // make relative
   $fathom_url = str_replace( array( 'https:', 'http:' ), '', $fathom_url );

   ?>
   <!-- Fathom - simple website analytics - https://github.com/usefathom/fathom -->
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
   })(document, window, '//<?php echo esc_attr( $fathom_url ); ?>/tracker.js', 'fathom');
   fathom('trackPageview');
   </script>
   <!-- / Fathom -->
   <?php
}

add_action( 'wp_head', 'fathom_print_js_snippet', 50 );

function fathom_register_settings() {
   // register option
   register_setting( 'general', FATHOM_OPTION_NAME, array( 'type' => 'string' ) );

   // register settings field
   $title = __( 'Fathom URL', 'fathom-analytics' );
   add_settings_field( FATHOM_OPTION_NAME, $title, 'fathom_print_setting_field', 'general' );
}

function fathom_print_setting_field( $args = array() ) {
   $value = get_option( FATHOM_OPTION_NAME );
   $placeholder = 'http://my-stats.usefathom.com/';
   echo sprintf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s" />', FATHOM_OPTION_NAME, FATHOM_OPTION_NAME, esc_attr( $value ), esc_attr( $placeholder ) );
   echo '<p class="description">' . __( 'Enter the full URL to your Fathom instance here.', 'fathom-analytics' ) . '</p>';
}

if( is_admin() && ! wp_doing_ajax() ) {
   add_action( 'admin_menu', 'fathom_register_settings' );
}
