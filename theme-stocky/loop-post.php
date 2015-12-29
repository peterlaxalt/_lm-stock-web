<?php if (!is_single()) {
	$blog_post_class = 'blog-home-post';
} else {
	$blog_post_class = 'blog-single-post';
} ?>

<article <?php post_class($blog_post_class); ?> id="post-<?php the_ID(); ?>">
	<div class="post_content">
		<h2 class="post_title">
			<span>
				<?php if (is_single()) { ?>
					<?php the_title(); ?>
				<?php } else { ?>
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				<?php } ?>
			</span>
		</h2>
	    <div class="post_meta blocks_wrap clearfix">
			<div class="meta_block block-category">
				<?php the_category(', ') ?>
			</div>
			<div class="meta_block block-author">
				<?php echo get_avatar( get_the_author_meta('email'), '70' ); ?>
				<?php the_author_posts_link(); ?>
			</div>
			<div class="meta_block block-comments">
				<?php comments_popup_link( __( '0 Comments', 'designcrumbs' ), __( '1 Comment', 'designcrumbs' ), __( '% Comments', 'designcrumbs' ), 'comments-link', __('Comments Closed', 'designcrumbs')); ?>
			</div>
			<div class="meta_block block-date">
				<?php the_time(get_option( 'date_format' )); ?>
			</div>
		</div>
		<div class="the_content_wrap">
			<?php the_content(__('Read More', 'designcrumbs')); ?>
		</div>
	</div>
</article>