<style type="text/css">
a {
	color:<?php echo stripslashes(of_get_option('link_color')); ?>;
}

a:hover,
.meta_block a:hover {
	color:<?php echo stripslashes(of_get_option('link_color_hover')); ?>;
}

input[type="submit"],
button[type="submit"],
.btn,
div.fes-form .fes-submit input[type="submit"],
a.button,
a.more-link,
.widget .cart_item.edd_checkout a,
.stocky_navigation a,
.fes-product-list-pagination-container a,
.edd-reviews-voting-buttons a.vote-yes,
.edd-reviews-voting-buttons a.vote-no,
#edd-purchase-button,
.edd-submit,
input.edd-submit[type="submit"],
.edd-submit.button,
.edd-submit.button:visited,
.navigation a,
.navigation span.current,
a.insert-file-row  {
	border-color:<?php echo stripslashes(of_get_option('button_color')); ?> !important;
	color:<?php echo stripslashes(of_get_option('button_color')); ?> !important;
}

input[type="submit"]:hover,
button[type="submit"]:hover,
.btn:hover,
div.fes-form .fes-submit input[type="submit"]:hover,
a.button:hover,
a.more-link:hover,
.widget .cart_item.edd_checkout a:hover,
.stocky_navigation a:hover,
.fes-product-list-pagination-container a:hover,
.edd-reviews-voting-buttons a.vote-yes:hover,
.edd-reviews-voting-buttons a.vote-no:hover,
#edd-purchase-button:hover,
.edd-submit:hover,
input.edd-submit[type="submit"]:hover,
.edd-submit.button:hover,
.navigation a:hover,
.navigation span.current,
a.insert-file-row:hover  {
	
}

<?php if (of_get_option('header_image') != '') { ?>
#header,
body.page-template-page-login-php {
	background-image:url("<?php echo stripslashes(of_get_option('header_image')); ?>");
}
<?php } if (of_get_option('cta_image') != '') { ?>
#home_cta {
	background-image:url("<?php echo stripslashes(of_get_option('cta_image')); ?>");
}
<?php } ?>
</style>