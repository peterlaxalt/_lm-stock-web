<?php get_header(); ?>

<div id="page" <?php if ((have_posts()) && (('download' != get_post_type()) || (is_active_sidebar( 'stocky_downloads_archive_sidebar' )))) { ?>class="posts-wrap"<?php } ?>>

	<?php if (have_posts()) : ?>

	<?php if ('post' == get_post_type() ) { ?>

		<?php /* Product Search Count */
		$allsearch = new WP_Query("s=$s&showposts=-1&post_type=post");
		$count = $allsearch->post_count;
		if ('0' != $count) { ?>

		<div class="box_title">
			<h3>
			<?php if ('1' == $count) {
				$string = sprintf( __('1 Result for <em>%2$s</em>', 'designcrumbs'), $count, get_search_query() );
			} else {
				$string = sprintf( __('%1$s Results for <em>%2$s</em>', 'designcrumbs'), $count, get_search_query() );
			}
			echo $string; ?>
			</h3>
		</div>

		<?php } ?>

	<?php } if ('download' == get_post_type() ) { // if results are downloads ?>
	
	<?php $class = is_active_sidebar( 'stocky_downloads_archive_sidebar' ) ? 'has_sidebar ' : '';?>
	<section id="image_grid" class="clearfix">
		<div id="stocky_downloads_list" class="edd_downloads_list">

	<?php } ?>

	<?php while (have_posts()) : the_post(); ?>

		<?php if ('download' == get_post_type() ) { // if results are downloads ?>

		<div <?php post_class('edd_download'); ?>>
			<div class="edd_download_inner">
				<?php get_template_part('edd_templates/shortcode','content-image'); ?>
			</div>
		</div>


		<?php } else { // if results are posts ?>

			<?php get_template_part( 'loop', 'post' ); ?>

		<?php } ?>

	<?php endwhile; ?>

	<?php if ('download' == get_post_type() ) { // if results are downloads ?>

		</div>
		
		<?php get_template_part("stocky","nav"); ?>
		
	</section><?php // end #image_grid ?>

	<?php } else { ?>

	<?php get_template_part("stocky","nav"); ?>
	
	<?php } ?>

	<?php else : ?>
	
	<div class="no_search_results">
		
		<h2>
		<?php
		$string = sprintf( __('Sorry, there are no results for <em>%1$s</em>.', 'designcrumbs'), get_search_query() );
		echo $string; ?>
		</h2>
		
		
		<h5><?php _e('Please search again.', 'designcrumbs'); ?></h5>
		
		<?php if (is_post_type_archive() ) get_template_part("searchform","downloads"); else get_search_form(); ?>
		
	</div>
	
	<?php endif; ?>
</div>
<?php if (have_posts()) : ?>
<?php if ('download' != get_post_type() ) get_sidebar(); else get_template_part("sidebar","downloads"); ?>
<?php endif; ?>

<?php get_footer(); ?>