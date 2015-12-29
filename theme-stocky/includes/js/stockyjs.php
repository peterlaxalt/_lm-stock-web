<?php
/*
Stocky JS
Code and stuff you need for the Stocky theme by Design Crumbs
*/
?>
<script type="text/javascript">
/* <![CDATA[  */

<?php if (('1' == of_get_option('retina_logo')) && ('' != of_get_option('logo'))) { ?>
jQuery(function($) {
	$(window).load(function(){
		// RETINA LOGO
		var screenImage = $(".retina_logo");
		var imageWidth = screenImage[0].naturalWidth;
		var imageHeight = screenImage[0].naturalHeight;
		$('#header_inner .retina_logo').css('width',parseInt(imageWidth)/2).css('height',parseInt(imageHeight)/2).fadeIn().css('display','block');
	});
});
<?php } ?>

jQuery(document).ready(function($){

	// load mobile menu
	$('#main_menu ul.menu').mobileMenu();
    $('select.select-menu').each(function(){
        var title = $(this).attr('title');
        if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
        $(this)
            .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
            .after('<span class="select">' + title + '</span>')
            .change(function(){
                val = $('option:selected',this).text();
                $(this).next().text(val);
            })
    });

	/* Masonry */
	var $container = $('.edd_downloads_list');
	// initialize Masonry after all images have loaded
	$container.imagesLoaded( function() {
		$container.masonry( { itemSelector: '.edd_download' } );
	});
	
	// Moving the pagination up a div
	var $edd_pagination = $('#edd_download_pagination');
	$edd_pagination.parent().after($edd_pagination);

	/* Parallax */
	(function(){
		var ua = navigator.userAgent,
		isMobileWebkit = /WebKit/.test(ua) && /Mobile/.test(ua);

		/* only show if not on mobile */
		if (isMobileWebkit) {
// 			$('html').addClass('stocky_mobile');
		} else {
			$.stellar({
				horizontalScrolling: false,
				verticalOffset: 0
			});
		}

	})();

	// FitVids
	$("#content").fitVids();

	/* Menu Toggle */
	$('#menu_toggle').click(function() {
		$('#main_menu').slideToggle('fast');
	});

	/* Search Toggle */
	$('#search_toggle').click(function() {
		$('#search_wrap').slideToggle('fast');
	});

	/* Ratings */
	$( '.comment_form_rating .edd_reviews_rating_box' ).find('a').on('click', function (e) {
		e.preventDefault();
		$( '.comment_form_rating .edd_reviews_rating_box' ).find('a').removeClass( 'active' );
		$( this ).addClass( 'active' );
	});

	/* Add span within comment reply title, move the <small> outside of it */
	$('#reply-title').wrapInner('<span>').append( $('#reply-title small') );

	// Increase counter on add to cart
	$('.purAddToCart').ajaxComplete(function(event,request, settings) {
		if(JSON.parse(request.responseText).msgId == 0) {
			var currentCount = parseInt($('#header_cart_count').text());
			var newCount = currentCount + 1;
			$('#header_cart_count').text(newCount);
		}
	});

	// Fancybox
	if( $('.lightbox').length ) {
		$(".lightbox").attr('rel', 'gallery').fancybox({
			'transitionIn'		: 'fade',
			'transitionOut'		: 'fade',
			'showNavArrows' 	: 'true'
		});
	}

});

/* ]]> */
</script>