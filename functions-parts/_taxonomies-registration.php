<?php
/*
 * Creating taxonomy
 * */
add_action('init', 'create_taxonomy');
function create_taxonomy()
{
    register_taxonomy('news-types', array('news'), array(
        'label' => '',
        'labels' => array(
            'name' => 'Категорія новини',
            'singular_name' => 'Категорія',
            'search_items' => 'Знайти категорію',
        ),
        'description' => 'Категорія новини', // описание таксономии
        'public' => true,
        'publicly_queryable' => null, // равен аргументу public
        'show_in_nav_menus' => true, // равен аргументу public
        'show_ui' => true, // равен аргументу public
        'show_tagcloud' => true, // равен аргументу show_ui
        'show_in_rest' => null, // добавить в REST API
        'rest_base' => null, // $taxonomy
        'hierarchical' => true,
        'update_count_callback' => '',
        'rewrite' => true,
        'capabilities' => array(),
        'meta_box_cb' => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
        'show_admin_column' => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
        '_builtin' => false,
        'show_in_quick_edit' => null, // по умолчанию значение show_ui
    ));

    
}