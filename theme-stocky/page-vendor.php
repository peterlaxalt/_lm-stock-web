<?php
/*
Template Name: Vendor Portfolio
*/
get_header(); ?>

	<div class="posts-wrap" id="page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php get_template_part('loop','page'); ?>

		<?php endwhile; endif; ?>

	</div><!-- end .posts-wrap -->

<?php get_template_part("sidebar","vendor"); ?>
<?php get_footer(); ?>