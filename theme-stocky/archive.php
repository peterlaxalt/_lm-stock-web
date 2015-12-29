<?php get_header(); ?>
<div class="<?php if (!((is_tax('download_tag')) || (is_tax('download_category'))) || is_active_sidebar( 'stocky_downloads_archive_sidebar' )) { ?>posts-wrap <?php } ?>the_archive" >
	<?php if (have_posts()) : ?>

	<div class="box_title">
		<h4>
		<?php /* If this is a category */ if (is_category()) { ?>
			<?php _e('Category', 'designcrumbs'); ?> &#8220;<?php single_cat_title(); ?>&#8221;

		<?php /* If this is a tag */ } elseif( is_tag() ) { ?>
			<?php _e('Posts Tagged with', 'designcrumbs'); ?> &#8220;<?php single_tag_title(); ?>&#8221;

		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<?php _e('Archive for', 'designcrumbs'); ?> <?php the_time(get_option( 'date_format' )); ?>

		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<?php _e('Archive for', 'designcrumbs'); ?> <?php the_time('F, Y'); ?>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<?php _e('Archive for', 'designcrumbs'); ?> <?php the_time('Y'); ?>

		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<?php _e('Author Archive ', 'designcrumbs'); ?>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<?php _e('Blog Archives ', 'designcrumbs'); ?>

		<?php } elseif (is_tax()) { ?>
			<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
			<?php echo $term->name; ?>
		<?php }  ?>
		</h4>
	</div>

	<?php echo category_description(); ?>

	<?php if (!((is_tax('download_tag')) || (is_tax('download_category')))) { ?>

		<?php while (have_posts()) : the_post(); ?>

	     	<?php get_template_part( 'loop', 'post' ); ?>

		<?php endwhile; ?>
		
		<?php get_template_part("stocky","nav"); ?>

	<?php } else { ?>

		<section id="image_grid" class="clearfix">
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

	<?php } ?>

	<?php else : ?>

	<h2><?php _e('Sorry, we can\'t seem to find what you\'re looking for.', 'designcrumbs'); ?></h2>
	<p><?php _e('Please try one of the links on top.', 'designcrumbs'); ?></p>

	<?php endif; ?>
</div><!-- end .posts-wrap -->

<?php if ('download' != get_post_type() ) get_sidebar(); else get_template_part("sidebar","downloads"); ?>
<?php get_footer(); ?>