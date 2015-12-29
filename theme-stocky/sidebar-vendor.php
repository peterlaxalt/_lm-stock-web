<?php
$author = get_query_var( 'vendor' );
$author = get_user_by( 'slug', $author );

if ( ! $author ) {
	$author = get_user_by( 'id', get_current_user_id() );
}
?>

<div id="sidebar" class="stocky_vendor_sidebar">

	<div class="stocky_vendor">

		<?php echo get_avatar( $author->ID, 120 ); ?>
		<span class="vendor_name"><?php echo esc_attr( $author->display_name ); ?></span>
		<span class="vendor_since"><?php printf( __( 'Member Since: %s', 'designcrumbs' ), date_i18n( 'Y', strtotime( $author->user_registered ) ) ); ?></span>

	</div>

	<?php if ( '' != $author->description ) : ?>

	<div class="stocky_vendor_bio">

		<div class="box_title">
			<h3><?php _e('About Me', 'designcrumbs') ?></h3>
		</div>

		<span><?php echo esc_attr( $author->description ); ?></span>

	</div>

	<?php endif; ?>

	<?php if ( get_current_user_id() != $author->ID ) : // if user is not on their own profile ?>

	<div class="stocky_vendor_contact">

		<div class="box_title">
			<h3><?php _e( 'Contact', 'designcrumbs'); ?></h3>
		</div>

		<?php echo do_shortcode( '[fes_vendor_contact_form id="' . $author->ID . '"]' ); ?>

	</div>

	<?php endif; ?>

</div>