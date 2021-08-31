<?php

function load_more_news()
{
    $paged = $_POST['paged'] + 1;

    $query = new WP_Query([
        'post_type' => 'news',
        'posts_per_page' => 3,
        'paged' => $paged,
        'news-types' => 'regular',
    ]);

    if ($query->have_posts()) :

        while ($query->have_posts()) : $query->the_post(); ?>

            <li class="news__item news__item--hidden">
                <a class="news__link" href="<?php the_permalink(); ?>">
                    <div class="news__img">
                        <?php $img = get_field('news_post_img_aside'); ?>
                        <img src='<?php echo $img['sizes']['large']; ?>' alt='<?php echo $img['alt']; ?>'>
                    </div>

                    <div class="news__block">
                        <p class="news__subtitle">Стаття</p>
                        <h2 class="news__block-title">
                            <?php the_title(); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 57.069 19.626">
                                <path d="M18.543,11.627a1.336,1.336,0,0,1,.01,1.881l-6.2,6.225H63.633a1.329,1.329,0,0,1,0,2.658H12.349l6.214,6.225a1.345,1.345,0,0,1-.01,1.881,1.323,1.323,0,0,1-1.87-.01L8.26,22h0a1.492,1.492,0,0,1-.276-.419,1.268,1.268,0,0,1-.1-.511,1.332,1.332,0,0,1,.378-.93l8.422-8.484A1.3,1.3,0,0,1,18.543,11.627Z" transform="translate(64.951 30.878) rotate(180)"></path>
                            </svg>
                        </h2>
                    </div>
                </a>
            </li>

        <?php endwhile;
        wp_reset_postdata();

    endif;

    die();
}
add_action('wp_ajax_load_more_news', 'load_more_news');
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');


function update_news_pagination()
{
    $paged = $_POST['paged'] + 1;

    $query = new WP_Query([
        'post_type' => 'news',
        'posts_per_page' => 3,
        'paged' => $paged,
        'news-types' => 'regular',
    ]);

    $big = 999999999;

    $args = [
        'base' => str_replace($big, '%#%', esc_url(get_home_url() . '/news/page/' . $big)),
        'format' => '/page/%#%/',
        'current' => max(1, $paged),
        'total' => $query->max_num_pages,
        'end_size' => 1,
        'mid_size' => 2,
        'prev_next' => false,
        'prev_text' => '',
        'next_text' => '',
        'type' => 'plain',
        'add_args' => false,
        'add_fragment' => '',
        'before_page_number' => '',
        'after_page_number' => ''
    ];

    echo paginate_links($args);

    wp_reset_postdata();

    die();
}
add_action('wp_ajax_update_news_pagination', 'update_news_pagination');
add_action('wp_ajax_nopriv_update_news_pagination', 'update_news_pagination');


// ==== tips page sort function ====//

function tips_sort()
{

    $tipsSlug = $_POST["tipsSlug"];

    $query = new WP_Query([
        'post_type'      => 'tips',
        'tips-types' => $tipsSlug,
        'posts_per_page' => 5
    ]);

    while ($query->have_posts()) : $query->the_post();

        $image = get_field('post_tips_banner');
        $p =  get_field('post_tips');

        $post_id = get_the_ID();
        $category = wp_get_post_terms($post_id, 'tips-types');
        ?>

        <li>
            <article>
                <div class="tips-article-image">
                    <img class="section-img" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                </div>

                <div class="tips-article-container">
                    <div class="tips-heading-link">
                        <a class="add-text" href="#"><?php echo $category[0]->name ?></a>
                    </div>

                    <h2 class="tips-article-header">
                        <?php the_title() ?>
                    </h2>

                    <p><?php $desc = get_field('short_text_for_tips_list');
                        $limit = 125;
                        if (mb_strlen($desc) > $limit) :
                            $desc = mb_strimwidth($desc, 0, $limit);
                            $desc .= '...';
                        endif;
                        echo $desc; ?></p>
                    <a class="aside-link" href="<?php echo get_permalink() ?>">
                        Дізнатися більше
                        <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 4H10M10 4L7 1M10 4L7 7" stroke="#80BA27" />
                        </svg>
                    </a>
                </div>
            </article>
        </li>
        <hr />

    <?php

    endwhile;
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_tips_sort', 'tips_sort');
add_action('wp_ajax_nopriv_tips_sort', 'tips_sort');


// ==== tips page loadmore function ====//

function loadmore_tips()
{
    $paged = $_POST['paged'];
    $tips_slug = $_POST['tips_slug'];

    // echo $tips_slug;

    $query = new WP_Query([
        'post_type'      => 'tips',
        'tips-types' => $tips_slug,
        'posts_per_page' => 5,
        'paged' => $paged
    ]);

    while ($query->have_posts()) : $query->the_post();

        $image = get_field('post_tips_banner');
        $p =  get_field('post_tips');

        $post_id = get_the_ID();
        $category = wp_get_post_terms($post_id, 'tips-types');
    ?>

        <li>
            <article>
                <div class="tips-article-image">
                    <img class="section-img" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                </div>

                <div class="tips-article-container">
                    <div class="tips-heading-link">
                        <a class="add-text" href="#"><?php echo $category[0]->name ?></a>
                    </div>

                    <h2 class="tips-article-header">
                        <?php the_title() ?>
                    </h2>

                    <p><?php $desc = get_field('short_text_for_tips_list');
                        $limit = 125;
                        if (mb_strlen($desc) > $limit) :
                            $desc = mb_strimwidth($desc, 0, $limit);
                            $desc .= '...';
                        endif;
                        echo $desc; ?></p>
                    <a class="aside-link" href="<?php echo get_permalink() ?>">
                        Дізнатися більше
                        <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 4H10M10 4L7 1M10 4L7 7" stroke="#80BA27" />
                        </svg>
                    </a>
                </div>
            </article>
        </li>
        <hr />

        <?php

    endwhile;
    wp_reset_postdata();
    die();
}

add_action('wp_ajax_loadmore_tips', 'loadmore_tips');
add_action('wp_ajax_nopriv_loadmore_tips', 'loadmore_tips');



// ==== tips page pagination function ====//

function update_tips_pagination()
{

    $paged = $_POST['paged'] + 1;
    $main_query = new WP_Query([
        'post_type'      => 'tips',
        'posts_per_page' => 5,
        'paged' => $paged
    ]);

    $big  = 999999999;
    $args = array(
        'base'    => str_replace($big, '%#%', esc_url(get_home_url() . 'tips/' . $big)),
        'format'  => '?paged=%#%',
        'current' => $paged,
        'total'   => $query->max_num_pages,
        'end_size'           => 1,
        'mid_size'           => 2,
        'prev_next'          => true,
        'prev_text'          => '',
        'next_text'          => '',
        'type'               => 'plain',
        'add_args'           => false,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
    );
    echo paginate_links($args);

    die();
}

add_action('wp_ajax_update_tips_pagination', 'update_tips_pagination');
add_action('wp_ajax_nopriv_update_tips_pagination', 'update_tips_pagination');





//==== page about concrete pagination ====//


function page_about_concrete_pagination()
{

    $paged = $_POST['paged'];

    $query = new WP_Query([
        'post_type'      => 'videos',
        'posts_per_page' => 5,
        'paged' => $paged
    ]);

    $big  = 999999999;
    $args = array(
        'base'    => str_replace($big, '%#%', esc_url(get_home_url() . '/video-pro-gazobeton/page/' . $big)),
        'format'  => '?paged=%#%',
        'current' => $paged,
        'total'   => $query->max_num_pages,
        'end_size'           => 1,
        'mid_size'           => 2,
        'prev_next'          => true,
        'prev_text'          => '',
        'next_text'          => '',
        'type'               => 'plain',
        'add_args'           => false,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
    );
    echo paginate_links($args);

    die();
}

add_action('wp_ajax_page_about_concrete_pagination', 'page_about_concrete_pagination');
add_action('wp_ajax_nopriv_page_about_concrete_pagination', 'page_about_concrete_pagination');


// ==== page about concrete loadmore function ====//

function loadmore_videos()
{
    $paged = $_POST['paged'];

    $query = new WP_Query([
        'post_type'      => 'videos',
        'posts_per_page' => 5,
        'paged' => $paged
    ]);
    $i = 0;
    while ($query->have_posts()) : $query->the_post();


        $v =  get_field('single_video_v');
        if ($v) : ?>
            <li>
                <div class="video-item">

                    <video>
                        <source src="<?php echo $v['url'] ?>">
                    </video>
                </div>

                <div class="video-play-btn js-pop-btn" data-pop-target='v-<?php echo $i; ?>'>
                    <svg width="115" height="102" viewBox="0 0 115 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2178 33.5C25.2627 15.0804 43.104 2 64.0004 2C91.0623 2 113 23.938 113 51C113 78.062 91.0623 100 64.0004 100C43.104 100 25.2627 86.9196 18.2178 68.5" stroke="white" stroke-width="3" />
                        <path d="M63.8947 46L72 50.8L63.8947 56V50.8V46Z" fill="white" />
                        <path d="M0 50.8L72 50.8M72 50.8L63.8947 46V56L72 50.8Z" stroke="white" stroke-width="3" />
                    </svg>
                </div>

            </li>


        <?php endif; ?>
    <?php
        $i++;
    endwhile;
    wp_reset_postdata();  ?>

<?php die();
}

add_action('wp_ajax_loadmore_videos', 'loadmore_videos');
add_action('wp_ajax_nopriv_loadmore_videos', 'loadmore_videos');


// SUPER FILTERS 
include_once 'super-filter/super-filter.php';
include_once 'ajax/_ajax-stores.php';
include_once 'ajax/_ajax-calc-pdf.php';