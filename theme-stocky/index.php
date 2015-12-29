<?php get_header(); ?>
<div class="posts-wrap">
<?php if (have_posts()) : ?>
	<div class="the_blog">
	<?php while (have_posts()) : the_post(); ?>

		<?php get_template_part( 'loop', 'post' ); ?>

	<?php endwhile; ?>
	</div><!-- end .the_blog -->

	<?php get_template_part("stocky","nav"); ?>

	<?php else : ?>

	<h2><?php _e('Sorry, we can\'t seem to find what you\'re looking for.', 'designcrumbs'); ?></h2>
	<p><?php _e('Please try one of the links on top.', 'designcrumbs'); ?></p>

	<?php endif; ?>

</div><!-- end .posts-wrap -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
