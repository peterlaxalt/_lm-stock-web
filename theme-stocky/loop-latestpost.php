<?php

$args = array(
	'post_type' => 'attachment',
	'numberposts' => null,
	'post_status' => null,
	'order'		  => 'ASC',
	'post_parent' => $post->ID,
	'posts_per_page'	=> '1'
);

$attachments = get_posts( $args );

$latest_bg_img = '';

if ((count( $attachments ) != 0) || (has_post_thumbnail()) ) {

	if (has_post_thumbnail()) { /* There IS a featured image set */

		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'full', true);
		$latest_bg_img = $image_url[0];

	 } else { /* There is NOT a featured image set */

		$count ='0';
		foreach ($attachments as $attachment) {

			$count++;
			if ( $count == 1 ) :
			$latest_bg_img = wp_get_attachment_url($attachment->ID);

			endif;

		}

	}

} ?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php if ('' != $latest_bg_img) { ?>
	<div class="latest_bg_img" style="background-image:url('<?php echo esc_attr($latest_bg_img); ?>');" /></div>
	<?php } ?>

	<div class="post_content">

		<div class="latest_content">

			<div class="latest_date">
				<?php the_time(get_option( 'date_format' )); ?>
			</div>

			<h3 class="latest_post_title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

			<?php the_excerpt(__('Read More &rarr;', 'designcrumbs')); ?>

		</div>

	</div>
</article>