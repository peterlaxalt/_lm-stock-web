<?php
/*
Template Name: Contact
*/
get_header(); ?>

	<div class="posts-wrap" id="page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php get_template_part('loop','page'); ?>

		<?php endwhile; endif; ?>

	</div><!-- end .posts-wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>