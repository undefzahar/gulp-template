<?php
# 1. Functions parts
	include_once 'functions-parts/Mobile_Detect.php';
	include_once 'functions-parts/_assets.php';
	include_once 'functions-parts/_post-types-registration.php';
	include_once 'functions-parts/_taxonomies-registration.php';
	include_once 'functions-parts/_breadcrumbs.php';
	include_once 'functions-parts/_ajax.php';
	include_once 'functions-parts/_hooks.php';
	include_once 'functions-parts/_custom-functions.php';


# 2. Удаление "мусора"
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

	add_action ( 'after_setup_theme' , function() {
		# удалить SVG и глобальные стили 
		remove_action ( 'wp_enqueue_scripts' , 'wp_enqueue_global_styles' );
	
		# удалить действия wp_footer, которые добавляют глобальные встроенные стили 
		remove_action ( 'wp_footer' , 'wp_enqueue_global_styles' , 1 );
	
		# удаляем фильтры render_block, добавляющие лишнее 
		remove_filter ( 'render_block' , 'wp_render_duotone_support' );
		remove_filter ( 'render_block' , 'wp_restore_group_inner_container' );
		remove_filter ( 'render_block' , 'wp_render_layout_support_flag' );
	});

	# Remove emoji icons
	function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		
		# Remove from TinyMCE
		add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	}
	add_action( 'init', 'disable_emojis' );

	# Filter out the tinymce emoji plugin.
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	# Отменить регистрацию стилей CF7 и Gutenberg
	add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
	function wps_deregister_styles() {
		wp_deregister_style( 'contact-form-7' );
		wp_deregister_style( 'wp-block-library' );
		wp_deregister_style( 'wp-block-library-theme' );
		wp_deregister_style( 'wc-block-style' );
	}


# 3. Удаление пунктов меню
	function remove_menus()
	{
	//    remove_menu_page('index.php');                  //Консоль
			remove_menu_page('edit.php');                   //Записи
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


# 4. Поддержка SVG
	function allow_svg($mimes)
	{
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter('upload_mimes', 'allow_svg');


# 5. Регистрация
	# 5.1 Регистрация меню
	add_theme_support('menus');
	add_action( 'after_setup_theme', function(){
		register_nav_menus( [
			'header_menu' => 'Меню в шапке',
			'footer_menu' => 'Меню в подвале'
		] );

		# 5.2 Регистрация обложки для постов
		//add_theme_support( 'post-thumbnails' );
		//add_theme_support( 'post-thumbnails', array( 'post' ) );          // Только для post
		//add_theme_support( 'post-thumbnails', array( 'page' ) );          // Только для page
		//add_theme_support( 'post-thumbnails', array( 'post', 'movie' ) ); // Для post и movie типов
	} );

	# 5.3 Кастомное WP меню
	// class My_Walker_Nav_Menu extends Walker_Nav_Menu
	// {
	//     function start_lvl( &$output, $depth = 0, $args = array() ) {
	//         $indent = str_repeat("\t", $depth);
	//         $output .= "\n$indent<div class='sub-menu-container'><div class='container'><ul class='sub-menu'>\n";
	//     }
	//     function end_lvl( &$output, $depth = 0, $args = array() ) {
	//         $indent = str_repeat("\t", $depth);
	//         $output .= "$indent</ul></div></div>\n";
	//     }
	// }

	# 5.4 Регистрация нового размера изображений
	//add_image_size( 'full_hd', 1920, 1080 );


# 6. Стилизация админки
	# 6.1 Добавить CSS стили
	add_action('admin_enqueue_scripts', 'my_admin_css', 99);
	function my_admin_css(){
		wp_enqueue_style('my-wp-admin', get_template_directory_uri() .'/wp-admin.css' );
	}

	# 6.2 Добавить Фавикон
	// function mojFavicon() {
	// 	echo '<link rel="Shortcut Icon" type="image/x-icon" href="" />';
	// }
	// add_action( 'admin_head', 'mojFavicon' );


	# 6.3 Изменение текста в подвале
	// add_filter( 'admin_footer_text', '__return_empty_string' ); //удалить подвал

	// add_filter('admin_footer_text', 'footer_admin_func');
	// function footer_admin_func () {
	// 	echo 'Розробка: <a href="#" target="_blank">DL Agency</a> ';
	// }


	# 6.4 Изменение внутреннего логотипа
	// add_action('add_admin_bar_menus', 'reset_admin_wplogo');
	// function reset_admin_wplogo(  ){
	// 	remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 ); // удаляем стандартную панель (логотип)

	// 	add_action( 'admin_bar_menu', 'my_admin_bar_wp_menu', 10 ); // добавляем свою
	// }
	// function my_admin_bar_wp_menu( $wp_admin_bar ) {
	// 	$wp_admin_bar->add_menu( array(
	// 		'id'    => 'wp-logo',
	// 		'title' => '<img style="max-height:100%;" src="'. get_bloginfo('template_directory') .'/build/static/images/admin-logo.jpeg" alt="" >', // иконка dashicon
	// 		'href'  => home_url(),
	// 		'meta'  => array(
	// 			'title' => 'Відвідати сайт',
	// 		),
	// 	) );
	// }


	# 6.5 Меняем логотип, его ссылку и title атрибут на странице входа
	// add_theme_support( 'custom-header' );
	// if(1){
	// 	## Берет картинку для логотипа на странице входа из установленной в настройках
	//     add_action( 'login_head', 'wp_login_logo_img_url' );
	//     function wp_login_logo_img_url() {
	//         echo '
	//         <style>
	//         .login h1 a {
	//             background-image: url('. get_header_image() .') !important;
	//             background-size: 260px auto !important;
	//             width: 260px !important;
	//             height: 60px !important;
	//         }
	//         </style>';
	//     }


	# 6.6 Изменение ссылки в логотипе
	// 	add_filter( 'login_headerurl', 'wp_login_logo_link_url' );
	// 	function wp_login_logo_link_url( $url ){
	// 		return home_url();
	// 	}


	# 6.7 Изменяем атрибут title у ссылки логотипа
	// 	add_filter( 'login_headertitle', 'wp_login_logo_title_attr' );
	// 	function wp_login_logo_title_attr( $title ) {
	// 		$title = get_bloginfo( 'name' );
	// 		return $title;
	// 	}   
	// }


# 7. Редирект
	# 7.1 Редирект из url верхнего регистра в url нижнего регистра
	add_action( 'init', 'redirect_to_lower_case' );
	function redirect_to_lower_case() 
	{
	    if ( $_SERVER['REQUEST_URI'] != strtolower( $_SERVER['REQUEST_URI']) ) {
	        header('Location: http://'.$_SERVER['HTTP_HOST'] . 
	                strtolower($_SERVER['REQUEST_URI']), true, 301);
	        exit();
	    }
	}


# 8. Безопасность
	# 8.1 Полное Удаление версии WP
	remove_action('wp_head', 'wp_generator'); // из заголовка
	add_filter('the_generator', '__return_empty_string'); // из фидов и URL

	# 8.2 Удаление параметра ver в добавляемых скриптах и стилях
	function rem_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}
	add_filter( 'style_loader_src', 'rem_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'rem_wp_ver_css_js', 9999 );

	# 8.3 Авто удаление файлов license.txt и readme.html
	if( is_admin() && ! defined('DOING_AJAX') ){
		add_action( 'init', 'remove_license_txt_readme_html' );
		function remove_license_txt_readme_html(){
			$license_file = ABSPATH .'/license.txt';
			$readme_file  = ABSPATH .'/readme.html';

			if( file_exists($license_file) && current_user_can('manage_options') ){

				$deleted = unlink($license_file) && unlink($readme_file);

				if( ! $deleted  )
					$GLOBALS['readmedel'] = 'Не удалось удалить файлы: license.txt и readme.html из папки `'. ABSPATH .'`. Удалите их вручную!';
				else
					$GLOBALS['readmedel'] = 'Файлы: license.txt и readme.html удалены из из папки `'. ABSPATH .'`.';

				add_action( 'admin_notices', function(){
					echo '<div class="error is-dismissible"><p>'. $GLOBALS['readmedel'] .'</p></div>';
				} );
			}
		}
	}

	# 8.4 Зашифровать логин и пароль во время передачи их серверу
	define('FORCE_SSL_LOGIN', true);

	# 8.5 SSL в админской части сайта
	define('FORCE_SSL_ADMIN', true);

	# 8.6 Отключить вывод ошибок на странице авторизации
	add_filter('login_errors', 'login_obscure_func');
	function login_obscure_func(){
		return 'Помилка: Ви ввели неправильний логін або пароль.';
	}

	# 8.7 Отключить возможность редактировать файлы в админке для тем, плагинов
	define('DISALLOW_FILE_EDIT', true);

	# 8.8 Закрыть возможность публикации через xmlrpc.php
	add_filter('xmlrpc_enabled', '__return_false');

# 9. Прочее
	# Страница опций ACF PRO
	// if (function_exists('acf_add_options_page')) acf_add_options_page();


	# ACF Map activation
	// function my_acf_init() {
	//    acf_update_setting('google_api_key', 'GOOGLE_MAP_API_KEY');
	// }
	//add_action('acf/init', 'my_acf_init');


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


	# Добавить таксономию(раздел) в url перед постом
	// function wpa_show_permalinks( $post_link, $post ){
	//     if (is_object( $post ) && ($post->post_type == 'products' || $post->post_type == 'services' || $post->post_type == 'cards') ){
	//         $terms = wp_get_object_terms( $post->ID, 'partition_type' );
			
	//         if( $terms ){
	//             return str_replace( '%partition_type%' , $terms[0]->slug , $post_link );
	//         }
	//     }
		
	//     return $post_link;
	// }
	// add_filter( 'post_type_link', 'wpa_show_permalinks', 1, 2 );