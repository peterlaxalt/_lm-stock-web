<?php get_header(); ?>
<div id="single_product_page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php
		$files = edd_get_download_files( $post->ID );
		$exclude = wp_list_pluck( $files, 'attachment_id' ); // exclude the actual download files
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => null,
			'post_status' => null,
			'post_mime_type' => 'image',
			'order'		  => 'ASC',
			'post_parent' => $post->ID,
			'posts_per_page'	=> '99',
			'post__not_in' => $exclude
		);
		$attachments = get_posts($args); ?>
	<div <?php post_class(); ?>>

		<div id="single_item_wrap" class="clearfix">

			<div class="posts-wrap">

				<div id="product_images">

					<?php if (get_post_meta($post->ID, '_dc_embed_link', true) != '') { // if there is a video ?>

						<?php echo wp_oembed_get(get_post_meta($post->ID, '_dc_embed_link', true), array('width'=>780)); ?>

					<?php } else { // if no video ?>

						<?php if (has_post_thumbnail()) { ?>
						<a id="main_product_image" href="<?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'product_page_image'); echo esc_attr($image_url[0]); ?>" class="lightbox">
							<span class="preview"></span>
							<?php the_post_thumbnail( 'product_page_image' ); ?>
						</a>
						<?php } ?>

						<?php if(count($attachments) > 1) { // if there are more than one image uploaded to the post ?>

							<div id="extra_images" class="clearfix">

								<?php $featured_image = get_post_thumbnail_id(get_the_ID());
									foreach ($attachments as $attachment) {
										if ($featured_image != ($attachment->ID)) { ?>
								<div class="single_extra_image">
									<a href="<?php $image_url = wp_get_attachment_image_src( $attachment->ID, 'product_page_image'); echo esc_attr($image_url[0]); ?>" class="lightbox" rel="gallery">
										<span class="preview"><i class="fa fa-search-plus"></i></span>
										<?php echo wp_get_attachment_image( $attachment->ID, 'product_med' ); ?>
									</a>
								</div>
								<?php } } ?>

							</div>

						<?php } ?>

					<?php } // end if no video ?>

				</div><!-- end #product_images -->

			</div>

				<div id="sidebar" class="clearfix">

					<div id="product_info" class="clearfix">
						<div class="clearfix">
							<?php echo get_avatar( get_the_author_meta('email'), '100' ); ?>
							<div id="post_user">
								<div><strong><?php the_title(); ?></strong></div>
								<div>
								<?php
									if ( class_exists( 'EDD_Front_End_Submissions' ) ) :
										$url = FES_Vendors::get_vendor_store_url( get_the_author_meta( 'ID'  ) );
									else :
										$url = get_post_type_archive_link( 'download' );
									endif;
									$string = sprintf( __('<em>by</em> <a href="%1$s">%2$s</a>', 'designcrumbs'), $url, get_the_author_meta( 'display_name' ) );
									echo $string;
								?>
								</div>
							</div>
						</div>

					</div>

					<div id="product_pricing">
						<?php
						$button_text = get_post_meta($post->ID, '_edd_purchase_text', true) ? get_post_meta($post->ID, '_edd_purchase_text', true) : __('Add To Cart', 'designcrumbs');
						$style = get_post_meta($post->ID, '_edd_purchase_style', true) ? get_post_meta($post->ID, '_edd_purchase_style', true) : 'button';
						$color = get_post_meta($post->ID, '_edd_purchase_color', true);
						if($color) { $color = str_replace(' ', '_', $color); }
						?>

						<?php echo edd_get_purchase_link( array( 'text' => $button_text ) ); ?>
					</div>

					<?php echo dcs_star_ratings(); ?>

					<?php echo dcs_exif_data(); ?>

					<div id="product_meta_wrap">

						<?php if ((get_the_term_list( $post->ID, 'download_category' ) != '')) { ?>
						<div class="single-product-meta">
							<span><?php _e('#Categories', 'designcrumbs'); ?></span>
							<?php echo get_the_term_list( $post->ID, 'download_category' ); ?>
						</div>
						<?php } ?>

						<?php if ((get_the_term_list( $post->ID, 'download_tag' ) != '')) { ?>
						<div class="single-product-meta">
							<span><?php _e('#Tags', 'designcrumbs'); ?></span>
							<?php echo get_the_term_list( $post->ID, 'download_tag'); ?>
						</div>
						<?php } ?>

					</div>
					
					<?php if (has_excerpt()) { ?>
						<div class="single-product-meta download_excerpt">
							<span><?php _e('#About', 'designcrumbs'); ?></span>
							<?php the_excerpt(); ?>
						</div>
					<?php } ?>
					
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('download_sidebar') ) : endif; /* WIDGETS */ ?>

					<?php if ( class_exists( 'EDD_Front_End_Submissions' ) ) : ?>

						<div id="stocky_portfolio_link_wrap">
							<a href="<?php echo esc_attr($url); ?>" id="portfolio_link" title="<?php _e('More From This User','designcrumbs'); ?>"><?php _e('More From This User','designcrumbs'); ?></a>
						</div>

					<?php endif; ?>

				</div>

		</div>

		<?php if (get_the_content() != '') { ?>
		<div id="product_content" class="entry-content clearfix">
			<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
		</div><!-- end #product_info -->
		<?php } ?>

		<?php comments_template('', true); ?>

		<?php dcs_related_products(); ?>

	</div><!-- end .post_class -->

	<?php endwhile; else: ?>
	<h2 class="page_title"><?php _e('Sorry, we can\'t seem to find what you\'re looking for.', 'designcrumbs'); ?></h2>
	<p><?php _e('Please try one of the links on top.', 'designcrumbs'); ?></p>

	<?php endif; ?>
	<div class="clear"></div>
</div><!-- end #single_product_page -->
<?php get_footer(); ?>