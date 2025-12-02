<?php /* Template Name: Custom Template */ ?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="info-content" class="info-content">
    <div class="container">
        <div class="info-content__inner">
            <h1 class="info-content__title"><?php the_title(); ?></h1>

            <div class="info-content__content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>