<?php

# helpers
function generate_link($path, $crumbs)
{
    $parent_page_id = get_page_by_path($path)->ID;
    $page =  get_permalink($parent_page_id);

    $temp_arr = [];
    $bc_arr = $crumbs;

    foreach($bc_arr as $key_1 => $value):

        if ($key_1 == '1'):

            $bc_arr[$key_1][1] = $page;

        endif;

        $temp_arr[] = $bc_arr[$key_1];

    endforeach;

    return $temp_arr;
}

# hook
add_filter( 'rank_math/frontend/breadcrumb/items', function($crumbs) {

    $locale = get_locale();

    # rewrite home page manualy
    if ($locale == 'uk'):

        $crumbs[0][0] = 'Головна';

    elseif ($locale == 'ru'):

        $crumbs[0][0] = 'Главная';

    elseif ($locale == 'en'):

        $crumbs[0][0] = 'Home page';

    endif;

    # rewrite parent page
    # NEWS
    if (is_singular('news')):

        $crumbs = generate_link('news', $crumbs);

    endif;

    if (is_singular('products')):

        $crumbs = generate_link('products', $crumbs);

    endif;

    if (is_singular('tips')):

        $crumbs = generate_link('tips', $crumbs);

    endif;

    if (is_page_template('page-news.php')):

        $crumbs = [$crumbs[0], $crumbs[1]]; # remove pagination

    endif;

    if (is_page_template('page-tips.php')):

        $crumbs = [$crumbs[0], $crumbs[1]]; # remove pagination

    endif;

    return $crumbs;

}, 10, 2);