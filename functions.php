<?php
// Functions parts
include_once 'functions-parts/Mobile_Detect.php';
include_once 'functions-parts/_assets.php';
include_once 'functions-parts/_post-types-registration.php';
include_once 'functions-parts/_taxonomies-registration.php';
include_once 'functions-parts/_breadcrumbs.php';
include_once 'functions-parts/_ajax.php';
include_once 'functions-parts/_hooks.php';
include_once 'functions-parts/_custom-functions.php';


/*
 * REMOVE EMOJI ICONS
 * */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


add_action( 'admin_menu', 'remove_menu_pages' );

function remove_menu_pages() {
    remove_menu_page('edit.php'); 
}


/*
 * Удаление "мусора"
 * */
remove_action('wp_head', 'feed_links_extra', 3); // убирает ссылки на rss категорий
remove_action('wp_head', 'feed_links', 2); // минус ссылки на основной rss и комментарии
remove_action('wp_head', 'rsd_link');  // сервис Really Simple Discovery
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // скрыть версию wordpress
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);


/*
 * Удаление пунктов меню (убрать комментарий для нужного пункта)
 * */
function remove_menus()
{
//    remove_menu_page('index.php');                  //Консоль
//    remove_menu_page('edit.php');                   //Записи
//    remove_menu_page('upload.php');                 //Медиафайлы
//    remove_menu_page('edit.php?post_type=page');    //Страницы
//    remove_menu_page('edit-comments.php');          //Комментарии
//    remove_menu_page('themes.php');                 //Внешний вид
//    remove_menu_page('plugins.php');                //Плагины
//    remove_menu_page('users.php');                  //Пользователи
//    remove_menu_page('tools.php');                  //Инструменты
//    remove_menu_page('options-general.php');        //Настройки

//    remove_menu_page('admin.php?page=pmxi-admin-import');
//    remove_menu_page('edit.php?post_type=acf-field-group');
//        remove_menu_page( 'admin.php?page=Wordfence' );
//        remove_menu_page( 'admin.php?page=pmxi-admin-import' );
//        remove_menu_page( 'admin.php?page=wpseo_dashboard' );
}
add_action('admin_menu', 'remove_menus');

/*
 * Страница опций
 * */
if (function_exists('acf_add_options_page')) acf_add_options_page();

/*
 * Add Menu Wp
 * */
//register_nav_menus(
//    array(
//        'menu' => __('Menu'),
//    )
//);


//if (function_exists('add_theme_support')) add_theme_support('menus');

/*
 * ACF Map activation
 * */
// function my_acf_init()
// {

//     acf_update_setting('google_api_key', 'GOOGLE_MAP_API_KEY');
// }
//add_action('acf/init', 'my_acf_init');

// Добавление поддержки миниатюр для следующих постов:
// add_theme_support( 'post-thumbnails', ['news'] );


/*
 * Поддержка SVG
 * */
function my_myme_types($mime_types)
{
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);


/*
 * Favicon for admin-panel
 * */
function mojFavicon() {
    echo '<link rel="Shortcut Icon" type="image/x-icon" href="" />';
}
//add_action( 'admin_head', 'mojFavicon' );

function get_current_template() {
    global $template;
    return basename($template, '.php');
}


// Serch form template
// add_filter( 'get_search_form', 'my_search_form' );
function my_search_form( $form ) {

	$form = '
	<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
		<input placeholder="'.get_field('search_title','options').'" type="text" value="' . get_search_query() . '" name="s" id="s" />
		<input type="submit" id="searchsubmit"  value="" />
	</form>';

	return $form;
}


// добавление редактора меню
if (function_exists('add_theme_support')) {
	add_theme_support('menus');
}

/*
 * Add Menu Wp
 * */
register_nav_menus(
    array(
        'Header menu' => 'Header menu',
    )
);

add_theme_support('menus');



add_theme_support( 'post-thumbnails' );
add_image_size( 'full_hd', 1920, 1080 );


add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_deregister_style( 'contact-form-7' );
    wp_deregister_style( 'wp-block-library' );
    wp_deregister_style( 'wp-block-library-theme' );
    wp_deregister_style( 'wc-block-style' );
}


/**
 * Filter URL entry before it gets added to the sitemap.
 *
 * @param array  $url  Array of URL parts.
 * @param string $type URL type. Can be user, post or term.
 * @param object $object Data object for the URL.
 */
add_filter( 'rank_math/sitemap/entry', function( $url, $type, $object ){

    $url = str_replace('/golovna', '', $url);
    return $url;
}, 10, 3 );

/**
 * Filter the URL Rank Math SEO uses in the XML sitemap for this post type archive.
 *
 * @param string $archive_url The URL of this archive
 * @param string $post_type   The post type this archive is for.
 */
add_filter( 'rank_math/sitemap/post_type_archive_link', function( $archive_url, $post_type ){
    return 0;
}, 10, 2 );

// Redirect from Uppercase urls to Lowercase urls
// add_action( 'init', 'redirect_to_lower_case' );
// function redirect_to_lower_case() 
// {
//     if ( $_SERVER['REQUEST_URI'] != strtolower( $_SERVER['REQUEST_URI']) ) {
//         header('Location: http://'.$_SERVER['HTTP_HOST'] . 
//                 strtolower($_SERVER['REQUEST_URI']), true, 301);
//         exit();
//     }
// }
