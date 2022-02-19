<?php
## Example (delete)
function load_more_news()
{
    $paged = $_POST['paged'] + 1;

    $query = new WP_Query([
        'post_type' => 'news',
        'posts_per_page' => 3,
        'paged' => $paged,
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


include_once 'super-filter/super-filter.php';
include_once 'ajax/_ajax-example.php';