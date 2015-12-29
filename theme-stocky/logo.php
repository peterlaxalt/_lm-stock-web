<?php if (of_get_option('logo') != '') { ?>
<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" class="the_logo">
	<img src="<?php echo stripslashes(of_get_option('logo')); ?>" alt="<?php bloginfo('name'); ?>" id="logo" <?php if ('1' == of_get_option('retina_logo')) { ?>class="retina_logo"<?php } ?>/>
</a>
<?php } else { ?>
<h1 class="sitename_logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
<?php } ?>