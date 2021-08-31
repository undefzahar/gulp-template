<?php 
/*
 * Подключение стилей и скриптов
 * */

function my_assets()
{
    wp_deregister_script('jquery-core');
    wp_register_script('jquery-core', get_stylesheet_directory_uri() . '/build/static/js/jquery-3.5.0.min.js');
    wp_enqueue_script('jquery');

    wp_enqueue_style('main-style', get_template_directory_uri() . '/build/static/css/main.css');

 

    wp_enqueue_style('inter-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    wp_enqueue_script('gsap-js', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.4.0/gsap.min.js',  array('jquery'), '1.0', true);
    wp_enqueue_script('smooth-scroll', get_stylesheet_directory_uri() . '/build/static/js/libs/SmoothScroll.min.js',  array('jquery'), '1.0', true);
    wp_enqueue_script('lax', get_stylesheet_directory_uri() . '/build/static/js/libs/lax.min.js',  array('jquery'), '1.0', true);
    wp_enqueue_script('scroll-magic', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js',  array('jquery'), '1.0', true);

    // 
    // wp_enqueue_script('scroll-magic-animation', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js',  array('jquery'), '1.0', true);
    // https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js
    // wp_enqueue_script('scroll-magic-debug', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js',  array('jquery'), '1.0', true);

    wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/build/static/js/main.js',  array('jquery'), '1.0', true);

    $page_template =  mb_substr(get_page_template_slug(), 0, -4); // get template file name and cut last 4 symbols

    $css_file_path = get_template_directory_uri() . '/build/static/css/pages/' . $page_template . '.css';
    $js_file_path = get_template_directory_uri() . '/build/static/js/pages/' . $page_template . '.js';

    $is_singular = is_singular('news') || is_singular('products') || is_singular('tips');

    if (!$is_singular && !is_404() && !is_search(  )) {
        
        wp_enqueue_style( $page_template, $css_file_path );
        wp_enqueue_script($page_template, $js_file_path,  array('jquery'), '1.0', true);
    }


    if (is_front_page()) {
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('sticky-sidebar', get_stylesheet_directory_uri() . '/build/static/js/libs/sticky-sidebar.min.js',  array('jquery'), '1.0', true);   
    }

    if (is_page_template('page-about.php')) {
        // wp_enqueue_script('sticky-sidebar', get_stylesheet_directory_uri() . '/build/static/js/libs/sticky-sidebar.min.js',  array('jquery'), '1.0', true);   
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_style('front-page', get_template_directory_uri() . '/build/static/css/pages/front-page.css');
        wp_enqueue_script('front-page', get_stylesheet_directory_uri() . '/build/static/js/pages/front-page.js',  array('jquery'), '1.0', true);
    }

    if (is_page_template('page-sales.php')) {
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.min.js',  array('jquery'), '1.0', true);        
    }
    
    if (is_singular('news')) {
        wp_enqueue_style('single-news-css', get_template_directory_uri() . '/build/static/css/pages/single-news.css');
        wp_enqueue_script('wow', get_stylesheet_directory_uri() . '/build/static/js/libs/wow.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('single-news-js', get_stylesheet_directory_uri() . '/build/static/js/pages/single-news.js', array('jquery'), '1.0', true);
    }

    if (is_singular('tips')) {
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_style('single-tips-css', get_template_directory_uri() . '/build/static/css/pages/single-tips.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('single-tips-js', get_stylesheet_directory_uri() . '/build/static/js/pages/single-tips.js', array('jquery'), '1.0', true);
    }
    
    if (is_singular('products')) {
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_style('single-products-css', get_template_directory_uri() . '/build/static/css/pages/single-products.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('single-products-js', get_stylesheet_directory_uri() . '/build/static/js/pages/single-products.js', array('jquery'), '1.0', true);
    }

    if (is_page_template('page-price.php')) {
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.min.js',  array('jquery'), '1.0', true);
    }

    if (is_404()) {
        wp_enqueue_style('404', get_template_directory_uri() . '/build/static/css/pages/404.css');
    }


    if (is_page_template('page-concrate-in-world.php')) {
        wp_enqueue_script('raphael', get_stylesheet_directory_uri() . '/build/static/js/libs/raphael.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('mapael', get_stylesheet_directory_uri() . '/build/static/js/libs/jquery.mapael.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('world-countries', get_stylesheet_directory_uri() . '/build/static/js/libs/world_countries.js',  array('jquery'), '1.0', true);
    }

    if (is_page_template('page-history.php')) {
        wp_enqueue_style('swiper', get_template_directory_uri() . '/build/static/css/libs/swiper.css');
        wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/build/static/js/libs/swiper.modified.js',  array('jquery'), '1.0', true);
    }

    if (is_page_template('page-stores.php')) {
        wp_enqueue_script('marker-cluster', get_stylesheet_directory_uri() . '/build/static/js/libs/markerCluster.js',  array('jquery'), '1.0', true);
        wp_enqueue_script('super-filter', get_stylesheet_directory_uri() . '/build/static/js/libs/filtersSuperClass.js',  array('jquery'), '1.0', true);
        wp_enqueue_style('from-parts', get_template_directory_uri() . '/build/static/css/modules/partials/form-parts.css');
    }

    if (is_page_template('page-social.php')) {
        wp_enqueue_style('page-tips-style', get_template_directory_uri() . '/build/static/css/pages/page-tips.css');
    }

    if (is_page_template('page-calc.php')) {
        wp_enqueue_script('vue', get_stylesheet_directory_uri() . '/build/static/js/libs/vue.min.js',  array('jquery'), '1.0', true);
        wp_enqueue_style('from-parts', get_template_directory_uri() . '/build/static/css/modules/partials/form-parts.css');
    
        // wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.development.js',  array('jquery'), '1.0', true);
        // wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js',  array('jquery'), '1.0', true);
    }


    if (is_search()) {
        wp_enqueue_style('search-style', get_template_directory_uri() . '/build/static/css/pages/search.css');
    }

  
}

add_action('wp_enqueue_scripts', 'my_assets');
