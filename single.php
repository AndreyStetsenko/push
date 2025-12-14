<?php
/**
 * Шаблон для одиночной записи
 *
 * @package Push
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <div class="entry-meta">
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                    <span class="byline"><?php echo get_the_author(); ?></span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php 
                    $thumbnail_id = get_post_thumbnail_id();
                    $thumbnail_image = crb_get_image($thumbnail_id, 'large');
                    if ($thumbnail_image && isset($thumbnail_image['url'])) {
                        echo push_optimized_image($thumbnail_image, 'large', array(
                            'loading' => 'lazy',
                            'fetchpriority' => 'auto'
                        ));
                    } else {
                        the_post_thumbnail('large', array('loading' => 'lazy'));
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();

