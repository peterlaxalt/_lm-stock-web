<?php $content = get_the_content();
if( has_shortcode( $content, 'edd_wish_lists' ) ) { $page_class = 'stocky_wish_list_page'; } else { $page_class = ''; } ?>

<article <?php post_class($page_class); ?>>
	<div class="entry-content clearfix" id="page-content">

		<?php if ( !is_page_template( 'page-login.php' ) && !is_page_template( 'page-vendor.php' ) ) { ?>

		<h2 class="post_title">
			<span>
				<?php the_title(); ?>
			</span>
		</h2>

		<?php } ?>

		<?php the_content(); ?>

		<div class="clear"></div>

		<?php wp_link_pages('before=<div class="page-links"><div class="page-links-wrap">&after=</div></div>&link_before=<span>&link_after=</span>'); ?>

	</div>
</article>