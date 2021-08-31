<?php

// Stores 
// =================================================

function set_map_markers($q) {

  // Create locations array
  // =================================================
  $locations_arr = [];  

  while ($q->have_posts()):$q->the_post(); 
    $city_term_of_this_post = wp_get_object_terms( get_the_ID(), 'stores-cities' );
    $this_post_city = $city_term_of_this_post[0]->name;
    
    if (!in_array($this_post_city, $locations_arr)) :
      $locations_arr[$this_post_city] = [];
    endif;

  endwhile;  wp_reset_postdata();


  foreach ($locations_arr as $city_name => $city_locations):   // fill cities with locations
      $locations_query = new WP_Query( [
          'post_type'      => 'stores',
          'suppress_filters' => true,
          'stores-cities' => $city_name,
          'posts_per_page' => -1,
      ] );    
      $posts = $locations_query->posts;

      foreach ($posts as $post):     // fill city with locations
          $location_title = $post->post_title;
          $location_title = str_replace("\"", "'", $location_title);
          $location_info = get_field('adresa_tochky_prodazhu', $post->ID);
          $location_numbers = get_field('nomera_telefoniv', $post->ID);

          $locations_arr[$city_name][$location_title]['lat'] = $location_info['lat'];
          $locations_arr[$city_name][$location_title]['lng'] = $location_info['lng'];
          $locations_arr[$city_name][$location_title]['address'] = str_replace("\"", "'", $location_info['address']) ;

          $locations_arr[$city_name][$location_title]['name'] = $location_title;

          $locations_arr[$city_name][$location_title]['numbers'] = [];
          

          if ($location_numbers) :
              foreach ($location_numbers as $location_number):
                  $locations_arr[$city_name][$location_title]['numbers'][] = $location_number['telefon'];
              endforeach;
          endif;


          $logo = get_field('logotyp_tochky', $post->ID);

          if ($logo):
              $locations_arr[$city_name][$location_title]['logo'] = $logo['sizes']['thumbnail'];
          endif;

      endforeach;

  endforeach;


  ?>
  <script>
    var locations = 
    {
      <?php // Create locations object from php array  
      foreach ($locations_arr as $city_name => $city_locations): ?>

          "<?php echo $city_name ?>" : {
              <?php 
              foreach ($city_locations as $location_name => $location_info): 
                if ($location_info['lat'] && $location_info['lng'] && $location_info['address']):
                  ?>
                  "<?php echo $location_name ?>" : {
                      lat : <?php echo $location_info['lat'] ?>,
                      lng : <?php echo $location_info['lng'] ?>,
                      address : "<?php echo $location_info['address'] ?>",
                      name: "<?php echo $location_name ?>",
                      <?php if (isset($location_info['numbers'])): ?>
                          numbers: [
                              <?php foreach ($location_info['numbers'] as $num): ?>
                                  '<?php echo $num ?>',
                              <?php endforeach; ?>
                          ],
                      <?php endif; ?>

                      <?php if (isset($location_info['logo'])): ?>
                          logo: '<?php echo $location_info['logo'] ?>'
                      <?php endif; ?>


                  },

                  <?php
                endif;
              endforeach; ?>
          },
      <?php
      endforeach; ?>
    }
    console.log(locations);
    // Use set markers function
    // =================================================
    setMarkers(map, locations);
  </script>
  <?php
}

function tax_q_stores_countries()
{
  $result_query = super_filter_tax_q('stores_query_args');


  $query = new WP_Query( $result_query );

  while ($query->have_posts()):$query->the_post(); 
    $queried_object = get_post( get_the_ID() ); 
    print_store_card( $queried_object );
  endwhile;  wp_reset_postdata();


  set_map_markers($query);
  die();
}

add_action('wp_ajax_tax_q_stores_countries', 'tax_q_stores_countries');
add_action('wp_ajax_nopriv_tax_q_stores_countries', 'tax_q_stores_countries'); 

function tax_q_stores_regions()
{
  $result_query = super_filter_tax_q('stores_query_args');


  $query = new WP_Query( $result_query );

  while ($query->have_posts()):$query->the_post(); 
    $queried_object = get_post( get_the_ID() ); 
    print_store_card( $queried_object );
  endwhile;  wp_reset_postdata();


  set_map_markers($query);
  die();
}

add_action('wp_ajax_tax_q_stores_regions', 'tax_q_stores_regions');
add_action('wp_ajax_nopriv_tax_q_stores_regions', 'tax_q_stores_regions'); 


function tax_q_stores_cities()
{
  $result_query = super_filter_tax_q('stores_query_args');


  $query = new WP_Query( $result_query );

  while ($query->have_posts()):$query->the_post(); 
    $queried_object = get_post( get_the_ID() ); 
    print_store_card( $queried_object );
  endwhile;  wp_reset_postdata();


  set_map_markers($query);
  die();
}

add_action('wp_ajax_tax_q_stores_cities', 'tax_q_stores_cities');
add_action('wp_ajax_nopriv_tax_q_stores_cities', 'tax_q_stores_cities'); 



function clear_stores_filters()
{
  $query = super_filter_clear_filters_query();


  while ($query->have_posts()):$query->the_post(); 
    $queried_object = get_post( get_the_ID() ); 
    print_store_card( $queried_object );
  endwhile;  wp_reset_postdata();


  set_map_markers($query);
  die();
}

add_action('wp_ajax_clear_stores_filters', 'clear_stores_filters');
add_action('wp_ajax_nopriv_clear_stores_filters', 'clear_stores_filters'); 



// Filters updates 

// update countries filter
function update_filter_stores_countries()
{
  upadte_super_filter('stores_query_args', $_POST['filter_name'], 'tax_query');
}

add_action('wp_ajax_update_filter_stores_countries', 'update_filter_stores_countries');
add_action('wp_ajax_nopriv_update_filter_stores_countries', 'update_filter_stores_countries');

// update regions filter
function update_filter_stores_regions()
{
  upadte_super_filter('stores_query_args', $_POST['filter_name'], 'tax_query');
}

add_action('wp_ajax_update_filter_stores_regions', 'update_filter_stores_regions');
add_action('wp_ajax_nopriv_update_filter_stores_regions', 'update_filter_stores_regions');

// update cities filter
function update_filter_stores_cities()
{
  upadte_super_filter('stores_query_args', $_POST['filter_name'], 'tax_query');
}

add_action('wp_ajax_update_filter_stores_cities', 'update_filter_stores_cities');
add_action('wp_ajax_nopriv_update_filter_stores_cities', 'update_filter_stores_cities');