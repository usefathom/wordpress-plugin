<?php
/*
Plugin Name: Fathom Analytics
Description: A simple plugin to add the Fathom tracking snippet to your WordPress site.
Author: Fathom Team
Version: 1.0
*/

add_action( 'wp_head', function() {
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
   })(document, window, '//localhost:8080/tracker.js', 'fathom');
   fathom('trackPageview');
   </script>
   <!-- / Fathom -->
   <?php
});
