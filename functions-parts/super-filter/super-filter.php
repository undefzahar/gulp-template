<?php 
function super_filter_tax_q($query_args_name)
{
  session_start();

  $needle = $_POST['needle'];
  $tax_arr = str_replace('\\', '', $_POST['tax_arr']); // remove all \ symbols from string 
  $tax_arr = str_replace('_', '-', $tax_arr); // categories are using - symbol to separete words instead of _
  $tax_arr = json_decode($tax_arr); // parse json from string to array 
  $filters_empty = false;
  // $_SESSION[$query_args_name]['paged'] = 1;

  foreach ($tax_arr as $tax_name => $terms_arr):

    if (empty($terms_arr) || $terms_arr === 'all'): // if income array is empty - remove it form tax_query at all
      
      $filters_empty = true;
      unset($_SESSION[$query_args_name]['tax_query'][$tax_name]);

    else: // if array is not empty - add it to tax_query 
      $_SESSION[$query_args_name]['tax_query'][$tax_name] = [
        'taxonomy' => $tax_name,
        'field' => 'id',
        'terms' => $terms_arr
      ];
    endif;
  endforeach;

 

  $argsArrCopy = $_SESSION[$query_args_name];
  $argsArrCopy['paged'] = 1;



  return $filters_empty ? $_SESSION[$query_args_name] : $argsArrCopy;

}

function super_filter_meta_q($query_args_name)
{
  session_start();

  // $needle = $_POST['needle'];
  $meta_arr = str_replace('\\', '', $_POST['meta_arr']); // remove all \ symbols from string 
  $meta_arr = str_replace('_', '-', $meta_arr); // categories are using - symbol to separete words instead of _
  $meta_arr = json_decode($meta_arr); // parse json from string to array 
  $filters_empty = false;

  foreach ($meta_arr as $meta_name => $meta_value):

    $meta_name = str_replace('-', '_', $meta_name);


    if (empty($meta_value) || $meta_value == 'all'): // if income array is empty - remove it form meta_query at all
      unset($_SESSION[$query_args_name]['meta_query'][$meta_name]);
      $filters_empty = true;

    else: // if array is not empty - add it to tax_query 
      $_SESSION[$query_args_name]['meta_query'][$meta_name] = [
        'key' => $meta_name,
        'value' => $meta_value,
        'compare' => 'LIKE'
      ];
    endif;
  endforeach;
  


  $argsArrCopy = $_SESSION[$query_args_name];
  $argsArrCopy['paged'] = 1;

  return $filters_empty ? $_SESSION[$query_args_name] : $argsArrCopy;


}

function update_super_filter( $query_args_name , $filter_name, $query_type = 'tax_query' )
{
  session_start();
  
  $temp_args = $_SESSION[$query_args_name]; // get current arguments
  $temp_args['posts_per_page'] = -1; // set posts per page to -1
  //  = 1;
  unset($temp_args['paged']);
  unset($temp_args[$query_type][$filter_name]); // no need to include current taxonomy or meta field for updating 
  $query = new WP_Query( $temp_args );
  $avalible_terms = [];

  while ($query->have_posts()):$query->the_post();
    if ($query_type == 'tax_query'):

      $terms = wp_get_post_terms( get_the_ID(), $filter_name );

      foreach ($terms as $term):
        if (!in_array($term->term_id, $avalible_terms)):
          $avalible_terms[] = $term->term_id;
        endif;
      endforeach;

    else:
      
      // $meta_val =  get_post_meta(get_the_ID(), $filter_name);

      $meta_val = get_field($filter_name, get_the_ID());


      if (!in_array($meta_val, $avalible_terms)):
        $avalible_terms[] = $meta_val;
      endif;

    endif;

    
  endwhile;  wp_reset_postdata();


  $avalible_terms = json_encode($avalible_terms);
  echo $avalible_terms; // output encoded array of avalible terms


    
  die();
}

function update_super_filter_max_posts()
{
  session_start();
  $filter_args_name = $_POST['filter_args_name'];
  $query = new WP_Query( $_SESSION[$filter_args_name] );

  echo $query->found_posts;

  die();

}

add_action('wp_ajax_update_super_filter_max_posts', 'update_super_filter_max_posts');
add_action('wp_ajax_nopriv_update_super_filter_max_posts', 'update_super_filter_max_posts');


function super_filter_clear_filters_query()
{
  session_start();
  $filter_args_name = $_POST['filter_args_name'];
  $_SESSION[$filter_args_name]['tax_query'] = [
    'relation' => 'AND',
  ];
  $_SESSION[$filter_args_name]['meta_query'] = [
    'relation' => 'AND',
  ];

  // $_SESSION[$filter_args_name]['posts_per_page'] = -1;

  $temp_args = $_SESSION[$filter_args_name];

  $temp_args['posts_per_page'] = -1;
  // unset($temp_args['posts_per_page']);
  unset($temp_args['paged']);
  unset($temp_args['tax_query']);
  unset($temp_args['meta_query']);


  $query = new WP_Query( $temp_args );

  return $query;
}