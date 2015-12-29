<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
	<div class="edd_download_image">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php echo get_the_post_thumbnail( get_the_ID(), 'product_main' ); ?>
		</a>
		<div class="stocky_hover_details <?php dcs_edd_wishlist_class(); ?>">

			<div class="stocky_hover_lines">

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="dcs_view_details"><?php _e('Details','designcrumbs'); ?></a>

				<?php dcs_edd_wishlist(); ?>

			</div>

		</div>
	</div>
<?php endif; ?>