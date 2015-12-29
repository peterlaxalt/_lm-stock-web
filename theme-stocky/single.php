<?php get_header(); ?>
<?php if (have_posts()) : ?>
<div class="posts-wrap">
	<?php while (have_posts()) : the_post(); ?>

		<?php get_template_part( 'loop', 'post' ); ?>

		<?php if (has_tag()) { ?>

		<div class="meta_block block-tags">
			<?php the_tags( "", ", ", " " ) ?>
		</div>

		<?php } if ('yes' == of_get_option('author_box')) { // if the author box is enabled ?>

			<?php dcs_author_box(); ?>

		<?php } ?>

		<?php comments_template('', true); ?>
	<?php endwhile; else : ?>

	<h2><?php _e('Sorry, we can\'t seem to find what you\'re looking for.', 'designcrumbs'); ?></h2>
	<p><?php _e('Please try one of the links on top.', 'designcrumbs'); ?></p>

	<?php endif; ?>
</div><!-- end .posts-wrap -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>