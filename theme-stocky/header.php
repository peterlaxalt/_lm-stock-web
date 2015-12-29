<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php global $edd_options; ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php if (of_get_option('favicon') != '') { ?>
		<link rel="shortcut icon" href="<?php echo stripslashes(of_get_option('favicon')); ?>" />
		<?php } ?>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class('button_'. stripslashes(of_get_option('button_text')) .' '. stripslashes(of_get_option('layout')) .''); ?>>
		<section id="site_wrap">

			<?php if (!is_page_template( 'page-login.php' )) { // don't show this if we're on a login screen ?>

			<header class="wrapper <?php echo stripslashes(of_get_option('menu_scheme')); ?>" id= "header<?php if (!is_front_page()) { ?> head-bg-fix<?php } ?>" style="background-position: center bottom;">
				<div class="container">

					<div id="menu_wrap" class="clearfix">


						<div id="logo_wrap">
						<?php get_template_part( 'logo' ); ?>
						</div>


						<?php if ('1' != of_get_option('expanded_menu')) { ?>
						<a href="#" id="menu_toggle"></a>
						<?php } ?>

						<a href="#" id="search_toggle" style="float: right; margin-left: 20px;"></a>

						<div id="cart_links" class="clearfix">
							<ul>

								<?php if (is_user_logged_in()) { ?>

								<li>
									<a href="<?php echo wp_logout_url( home_url() ); ?>" title="<?php _e('Logout', 'designcrumbs'); ?>" id="stocky_logout"><span><?php _e('Logout', 'designcrumbs'); ?></span></a>
								</li>

								<?php } else { ?>

									<?php if (of_get_option('member_login') != '') { ?>
									<li>
										<a href="<?php echo stripslashes(of_get_option('member_login')) ?>" title="<?php _e('Member Login', 'designcrumbs'); ?>" id="stocky_login">
											<span><?php _e('Member Login', 'designcrumbs'); ?></span>
										</a>
									</li>
									<?php } ?>

								<?php } if(function_exists('edd_get_settings')) { ?>

								<li>
									<a href="<?php echo get_permalink($edd_options['purchase_page']); ?>" title="<?php _e('Cart', 'designcrumbs'); ?>" id="head_cart">
										<span><?php _e('Cart', 'designcrumbs'); ?> (<span id="header_cart_count" class="edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span>)</span>
									</a>
								</li>

								<?php } ?>

							</ul>
						</div>

						<div id="search_wrap">
							<?php get_template_part("searchform","downloads"); ?>
						</div>

					</div>

					<?php $menu_class = 1 == of_get_option( 'expanded_menu' ) ? 'expanded' : ''; ?>
					<nav id="main_menu" class="clearfix <?php echo $menu_class; ?>">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'stocky_menu', 'container_id' => 'stocky_menu_container' ) ); ?>
					</nav>

					<?php if ((is_front_page()) || ('download' == get_post_type() && is_search()) || (is_page_template('page-vendor.php')) || ((is_page_template('page-contact.php')) && (((of_get_option('address') != '')) || (of_get_option('phone') != '')) ) ) { ?>

					<div id="header_inner" class="<?php echo stripslashes(of_get_option('header_text_color')); if (!(is_front_page())) echo ' search_result_header' ?>">

						<?php if ('download' == get_post_type() && is_search()) { ?>

							<?php /* Product Search Count */
							global $wp_query;

							$count = $wp_query->found_posts;
							if ('0' != $count) { ?>

							<h2>
							<?php if ('1' == $count) {
								$string = sprintf( __('1 Product Result for <em>%2$s</em>', 'designcrumbs'), $count, get_search_query() );
							} else {
								$string = sprintf( __('%1$s Product Results for <em>%2$s</em>', 'designcrumbs'), $count, get_search_query() );
							}
							echo $string; ?>
							</h2>

							<?php get_template_part("searchform","downloads"); ?>

							<?php } ?>

						<?php } elseif (is_front_page()) { ?>

<img src="http://antidotetotheordinary.com/wp-content/uploads/2015/11/LM2015_Logo_mark_white-e1447450296592.png" /><br />
<h2 id="slogan"><?php echo bloginfo('description'); ?></h2>

							<?php get_template_part("searchform","downloads"); ?>

						<?php } elseif (is_page_template('page-contact.php')) { ?>

							<div id="stocky_contact_info">
								<div id="stocky_contact_inner" class="clearfix">

									<?php if (of_get_option('address') != '') { ?>
										<div class="contact-address">
											<?php echo stripslashes(of_get_option('address')); ?>
										</div>
									<?php } if (of_get_option('phone') != '') { ?>
										<div class="contact-phone">
											<?php echo stripslashes(of_get_option('phone')); ?>
										</div>
									<?php } ?>

								</div>
							</div>

						<?php } if (is_page_template('page-vendor.php')) {

							$author = get_query_var( 'vendor' );
							$author = get_user_by( 'slug', $author );

							if ( $author ) :
								?><h2><?php printf( __( 'The Shop of %s', 'designcrumbs' ), esc_attr( $author->display_name ) ); ?></h2><?php
							endif;

						} ?>

					</div>
					<?php } ?>

				</div>
			</header>

			<?php } /* end if is page-login.php */ ?>

			<section class="wrapper" id="content" style="<?php if (is_front_page()) { ?>background-color: #060812 !important;<?php } ?>"><?php // #content ends in footer.php ?>
				<div class="container clearfix"><?php // .container ends in footer.php ?>
