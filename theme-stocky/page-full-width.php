<?php
/*
Template Name: Full Width
*/
get_header(); ?>

	<div id="page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php get_template_part('loop','page'); ?>

		<?php endwhile; endif; ?>

	</div><!-- end #page -->

<?php get_footer(); ?>