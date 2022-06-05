<?php 
function hide_show_adminpanel() { ?>
  <style>
    #wpadminbar {
      /* display: none !important; */
      top: -32px;
      transition: all .2s linear;
      opacity: 0;
      visibility: hidden;
    }

    #wpadminbar.show {
      top: 0;
      opacity: 1;
      visibility: visible;
    }

    html {
      margin-top: 0 !important;
    }
  </style>
  <script>
    window.onload = function () {
      document.addEventListener('mousemove', function (e) {
        var Y = e.clientY;

        if (Y <= 32) {
          document.querySelector('#wpadminbar').classList.add('show');
        } else {
          document.querySelector('#wpadminbar').classList.remove('show');
        }
      });
    }
  </script>
  <?php
}

if (is_user_logged_in()) :
  add_action('wp_footer', 'hide_show_adminpanel');
endif;

// Remove auto p from Contact Form 7 shortcode output
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
    return false;
}


function my_acf_google_map_api( $api ){
  $api['key'] = 'AIzaSyDUWsFsO6reAfRrNXBo0tt9BdcnA_FceA4';

  return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


// add_filter ('acf_the_content', 'img_p_class_content_filter', 20);
// function img_p_class_content_filter($content) {

//     $content = preg_replace("/(<p[^>]*)(\>.*)(\<img.*)(<\/p>)/im", "\$1 class='clear'\$2\$3\$4", $content);

//     return $content;
// } 

// /* Do something with the data entered */
// add_action( 'save_post', 'update_title_field' );

// /* When the post is saved, saves our custom data */
// function update_title_field( $post_id ) {
//   $post_type = get_post_type( $post_id );
//   if ($post_type == 'stores') {
//     $title = get_the_title( $post_id ); 
//     update_post_meta( $post_id, 'custom_adress', $title );
//   }
// }