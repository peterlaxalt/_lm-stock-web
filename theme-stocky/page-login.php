<?php
/*
Template Name: Login & Register
*/
get_header(); ?>

	<div id="page" class="stocky_login_register <?php echo stripslashes(of_get_option('header_text_color')); ?>">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div id="header_inner">

				<?php get_template_part( 'logo' ); ?>

			</div>

			<?php get_template_part('loop','page'); ?>

			<?php if (is_user_logged_in()) { ?>

				<div id="back_home_wrap">
					<a href="<?php echo home_url(); ?>" title="<?php _e('Back To Home','designcrumbs') ?>" id="back_home"><?php _e('&larr; Back To Home','designcrumbs') ?></a>
				</div>

			<?php } ?>

		<?php endwhile; endif; ?>

	</div><!-- end #page -->

<?php get_footer(); ?>