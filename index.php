<?php
/**
 * Главный шаблон темы
 *
 * @package Push
 */

get_header(); ?>

<?php get_template_part('components/home/hero'); ?>
<?php get_template_part('components/home/services'); ?>
<?php get_template_part('components/home/whyus'); ?>
<?php get_template_part('components/home/pushstart'); ?>
<?php get_template_part('components/home/cases'); ?>
<?php get_template_part('components/home/actors'); ?>
<?php get_template_part('components/home/collab'); ?>
<?php get_template_part('components/home/faq'); ?>
<?php get_template_part('components/home/bonus'); ?>

<?php
get_footer();

