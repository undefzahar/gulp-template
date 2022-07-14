<?php
/*
 * Create custom post type
 * */
add_action('init', 'init_post_types');
function init_post_types()
{
    register_post_type('news', array(
        'label' => null,
        'labels' => array(
            'name' => 'Новини', // основное название для типа записи
            'singular_name' => 'Новини', // название для одной записи этого типа
            'add_new' => 'Додати новину', // для добавления новой записи
            'add_new_item' => 'Додавання', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item' => 'Редагувати', // для редактирования типа записи
            'new_item' => 'Нова новина', // текст новой записи
            'view_item' => 'Перегляд', // для просмотра записи этого типа.
            'search_items' => 'Пошук', // для поиска по этим типам записи
            'not_found' => 'Не знайдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'В корзині не знайдено', // если не было найдено в корзине
            'parent_item_colon' => '', // для родителей (у древовидных типов)
            'menu_name' => 'Новини', // название меню
        ),
        'description' => '',
        'public' => true,
        'publicly_queryable' => null,
        'exclude_from_search' => null,
        'show_ui' => null,
        'show_in_menu' => true, // показывать ли в меню адмнки
        'show_in_admin_bar' => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus' => null,
        'show_in_rest' => true, // добавить в REST API. C WP 4.7
        'rest_base' => null, // $post_type. C WP 4.7
        'menu_position' => 4,
        'menu_icon' => null,
        'hierarchical' => true,
        'supports' => array('title', 'editor', 'author', 'revisions'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies' => array(),
        'has_archive' => true,
        'rewrite' => array('slug' => 'news-post'),
        'query_var' => true,
        'menu_icon' => 'dashicons-analytics'
    ));

    // // Example without permalink
    // register_post_type('reviews', array(
    //     'label' => null,
    //     'labels' => array(
    //         'name' => 'Отзывы',
    //         'singular_name' => 'Отзывы',
    //         'add_new' => 'Додать отзыв',
    //         'add_new_item' => 'Добавление',
    //         'edit_item' => 'Редактировать',
    //         'new_item' => 'Новый отзыв',
    //         'view_item' => 'Посмотреть',
    //         'search_items' => 'Поиск',
    //         'not_found' => 'Не найдено',
    //         'not_found_in_trash' => 'В корзине не найдено',
    //         'parent_item_colon' => '',
    //         'menu_name' => 'Отзывы',
    //     ),
    //     'description' => '',
    //     'public' => false,
    //     'publicly_queryable' => true,
    //     'exclude_from_search' => true,
    //     'show_ui' => true,
    //     'show_in_menu' => true,
    //     'show_in_admin_bar' => null,
    //     'show_in_nav_menus' => false,
    //     'show_in_rest' => true,
    //     'rest_base' => null,
    //     'menu_position' => 4,
    //     'menu_icon' => null,
    //     'hierarchical' => true,
    //     'supports' => array('title', 'author', 'revisions'),
    //     'taxonomies' => array(),
    //     'has_archive' => false,
    //     'rewrite' => false,
    //     'query_var' => true,
    //     'menu_icon' => 'dashicons-format-aside'
    // ));

}