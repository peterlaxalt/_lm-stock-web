<?php get_header(); ?>
<div id="archive_grid_wrap">
	<?php if (have_posts()) : ?>

		<?php $class = is_active_sidebar( 'stocky_downloads_archive_sidebar' ) ? 'has_sidebar ' : '';?>
		<section id="image_grid" class="<?php echo $class; ?>clearfix">
			<div id="stocky_downloads_list" class="edd_downloads_list">
				<?php while (have_posts()) : the_post(); ?>

					<div <?php post_class('edd_download'); ?>>
						<div class="edd_download_inner">
							<?php get_template_part('edd_templates/shortcode','content-image'); ?>
						</div>
					</div>

				<?php endwhile; ?>
			</div>
			
			<?php get_template_part("stocky","nav"); ?>

		</section><!-- end #image_grid -->
		
		<?php get_template_part("sidebar","downloads"); ?>

	<?php else : ?>

	<h2><?php _e('Sorry, we can\'t seem to find what you\'re looking for.', 'designcrumbs'); ?></h2>
	<p><?php _e('Please try one of the links on top.', 'designcrumbs'); ?></p>

	<?php endif; ?>
</div><!-- end #archive_grid_wrap -->

<?php get_footer(); ?>