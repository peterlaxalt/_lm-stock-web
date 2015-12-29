<?php

// Theme Prefix: dcs_

/* ========================================= Constants ========================================= */

if(!defined('DCS_THEME_DIR')) {
	define('DCS_THEME_DIR', dirname(__FILE__));
}

/* ========================================= File Includes ========================================= */

include(DCS_THEME_DIR . '/includes/scripts.php');

/* ========================================= General Things We Need ========================================= */

add_editor_style(); // Adds CSS to the editor to match the front end of the site.
add_theme_support('automatic-feed-links');
if ( ! isset( $content_width ) ) $content_width = 690; // This is the max width of the content, thus the max width of large images that are uploaded.
require_once(dirname(__FILE__) . "/includes/support/support.php"); // Load support tab
include(DCS_THEME_DIR . '/includes/edd-compatibility.php');

// Load Language File
load_theme_textdomain('designcrumbs', get_template_directory() . '/languages');
$locale = get_locale();
$locale_file = get_template_directory() . '/languages/$locale.php';
if ( is_readable($locale_file) )
	require_once($locale_file);

if(is_admin()) {
	// Check for Options Framework Plugin
	of_check();
	// Check for Easy Digital Downloads
	edd_plugin_check();
}

function of_check() {
	if ( !function_exists('of_get_option') ) {
		add_action('admin_notices', 'of_check_notice');
	}
}

// The Admin Notice
function of_check_notice() { ?>
	<div class='updated fade'>
		<p><?php _e('The Options Framework plugin is required for this theme to function properly.', 'designcrumbs'); ?> <a href="<?php echo network_admin_url('plugin-install.php?tab=plugin-information&plugin=options-framework&TB_iframe=true&width=640&height=517'); ?>" class="thickbox onclick"><?php _e('Install now', 'designcrumbs'); ?></a>.</p>
	</div>
<?php }

function edd_plugin_check() {
	if ( !function_exists('edd_get_settings') ){
		add_action('admin_notices', 'edd_check_notice');
	}
}

// The Admin Notice
function edd_check_notice() { ?>
  	<div class='updated fade'>
    	<p><?php _e('The Easy Digital Downloads plugin is required for this theme to function properly.', 'designcrumbs'); ?> <a href="<?php echo network_admin_url('plugin-install.php?tab=plugin-information&plugin=easy-digital-downloads&TB_iframe=true&width=640&height=517'); ?>" class="thickbox onclick"><?php _e('Install now', 'designcrumbs'); ?></a>.</p>
  	</div>
<?php }

/* =================================== Options Framework =================================== */

if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = 'false') {

		$optionsframework_settings = get_option('optionsframework');

		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];

		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}

		if ( !empty($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}

/* Toggles options on and off on click */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	// adds support tab
	jQuery(".embed-themes").html("<iframe width='770' height='390' src='http://themes.designcrumbs.com/iframe/index.html'></iframe>");

});
</script>

<?php
}

/* Removes the code stripping */

add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea_custom' );
}

function of_sanitize_textarea_custom($input) {
    global $allowedposttags;
        $of_custom_allowedtags["embed"] = array(
			"src" => array(),
			"type" => array(),
			"allowfullscreen" => array(),
			"allowscriptaccess" => array(),
			"height" => array(),
			"width" => array()
		);
		$of_custom_allowedtags["script"] = array(
			"type" => array()
		);
		$of_custom_allowedtags["iframe"] = array(
			"height" => array(),
			"width" => array(),
			"src" => array(),
			"frameborder" => array(),
			"allowfullscreen" => array()
		);
		$of_custom_allowedtags["object"] = array(
			"height" => array(),
			"width" => array()
		);
		$of_custom_allowedtags["param"] = array(
			"name" => array(),
			"value" => array()
		);

	$of_custom_allowedtags = array_merge($of_custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $of_custom_allowedtags);
	return $output;
}

/* =================================== WP Header =================================== */

/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support( 'title-tag' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function stocky_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'designcrumbs' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'stocky_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function stocky_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'stocky_render_title' );
endif;

/* =================================== Add Fancybox to linked Images =================================== */

function dcs_link_images($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
	$classes = 'lightbox'; // separated by spaces, e.g. 'img image-link'

	// check if there are already classes assigned to the anchor
	if ( preg_match('/<a.*? class=".*?">/', $html) ) {
		$html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
	} else {
		$html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
	}
	return $html;
}
add_filter('image_send_to_editor','dcs_link_images',10,8);

/* =================================== Add Menus =================================== */

add_theme_support( 'menus' );

register_nav_menus( array(
	'primary' => __( 'Main Menu', 'designcrumbs' ),
) );

/* ========================================= Featured Images ========================================= */

add_theme_support( 'post-thumbnails');
add_image_size( 'product_med', 280, 280, true );
add_image_size( 'product_main', 548, 9999, false );
add_image_size( 'product_page_image', 1560, 9999, false );
set_post_thumbnail_size( 245, 245 );

/* ========================================= Change Excerpt Length ========================================= */

function dcs_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'dcs_excerpt_length', 999 );

/* ========================================= Sidebars ========================================= */

function stocky_widgets_init() {
	register_sidebar(array(
		'name' => __('Home', 'designcrumbs'),
		'id' => 'stocky_home',
		'description' => __('Widgets for the home page, just below the title and search bar. They will resize based on how many you use.', 'designcrumbs'),
		'before_widget' => '<div class="home_widget widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="box_title widgettitle"><h3>',
		'after_title' => '</h3></div>'
	));
	register_sidebar(array(
		'name' => __('Sidebar', 'designcrumbs'),
		'id' => 'stocky_sidebar',
		'description' => __('These widgets will show up in your sidebar.', 'designcrumbs'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="box_title widgettitle"><h4>',
		'after_title' => '</h4></div>'
	));
	register_sidebar(array(
		'name' => __('Single Download Sidebar', 'designcrumbs'),
		'id' => 'download_sidebar',
		'description' => __('These widgets display on single download pages, next to the featured image.', 'designcrumbs'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="box_title widgettitle"><h4>',
		'after_title' => '</h4></div>'
	));
	register_sidebar(array(
		'name' => __('Footer', 'designcrumbs'),
		'id' => 'stocky_footer',
		'description' => __('Widgets for the footer of your site. They will resize based on how many you use.', 'designcrumbs'),
		'before_widget' => '<div class="footer_widget widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="box_title"><h4>',
		'after_title' => '</h4></div>'
	));
	register_sidebar(array(
		'name' => __('Downloads sidebar', 'designcrumbs'),
		'id' => 'stocky_downloads_archive_sidebar',
		'description' => __('These widgets will show up in the sidebar on the downloads archive page.', 'designcrumbs'),
		'before_widget' => '<div class="downloads_widget widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="box_title"><h4>',
		'after_title' => '</h4></div>'
	));
}	
add_action( 'widgets_init', 'stocky_widgets_init' );

/* ====================================================== Meta Boxes ====================================================== */

add_filter( 'cmb_meta_boxes', 'dcs_metaboxes' );
function dcs_metaboxes( array $meta_boxes ) {

	$prefix = '_dc_';

	// Video Links
	$meta_boxes[] = array(
	    'id' => 'dc_video',
	    'title' => __('Featured Video', 'designcrumbs'),
	    'pages' => array('download'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
	    'fields' => array(
		    array(
		        'name' => __('oEmbed Link', 'designcrumbs'),
		        'desc' => __('Enter the full URL to your video. <a href="http://codex.wordpress.org/Embeds">Learn more about oEmbeds</a>.', 'designcrumbs'),
		        'id' => $prefix . 'embed_link',
		        'type' => 'text'
		    ),
	    )
	);

	return $meta_boxes;
}

add_action( 'init', 'dcs_initialize_cmb_meta_boxes', 9999 );
function dcs_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'includes/metabox/init.php';

}

/* =================================== Related Products =================================== */

function dcs_related_products() {

    global $post;
    $orig_post = $post;
    $tags = wp_get_post_terms($post->ID, 'download_tag');

    if ($tags) {
    	$tag_ids = array();
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		$args=array(
			'tax_query' => array(
				array(
				    'taxonomy'  => 'download_tag',
				    'terms'     => $tag_ids,
				    'operator'  => 'IN'
				)
			),
			'post__not_in' => array($post->ID),
			'posts_per_page'=>8,
			'ignore_sticky_posts'=>0,
			'orderby'=>'rand'
		);

		$my_query = new wp_query( $args );

		if( $my_query->have_posts() ) {

			echo '<div class="related_products_wrap"><div class="box_title"><h3>'. __('Related Products', 'designcrumbs') .'</h3></div><div class="related_products clearfix">';

			while( $my_query->have_posts() ) {
				$my_query->the_post(); ?>

				<?php get_template_part('loop','related'); ?>

			<?php }

			echo '</div></div>';
		}

    }

    $post = $orig_post;
    wp_reset_query();

}

/* =================================== Count How Many Widgets are in a Sidebar =================================== */

function dcs_count_sidebar_widgets( $sidebar_id, $echo = true ) {
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return __( 'Invalid sidebar ID', 'designcrumbs' );
    if( $echo )
        echo count( $the_sidebars[$sidebar_id] );
    else
        return count( $the_sidebars[$sidebar_id] );
}

// To call it on the front end - dcs_count_sidebar_widgets( 'some-sidebar-id' );

/* =================================== Author Box =================================== */

function dcs_author_box() { ?>

<div class="about_the_author clearfix">
	<?php echo get_avatar( get_the_author_meta('email'), '200' ); ?>
	<div class="author_info clearfix">
		<h3 class="author_title">
			<?php $written_by_string = sprintf( __('This post was written by <a href="%1$s">%2$s</a>', 'designcrumbs'), get_author_posts_url( get_the_author_meta( 'ID' ) ), get_the_author_meta( 'display_name' ) );
			echo $written_by_string; ?>
		</h3>
		<div class="author_about">
			<?php the_author_meta( 'description' ); ?>
		</div>
	</div>
</div>

<?php }

/* =================================== Featured User Widget =================================== */

class dcs_featured_user_widget extends WP_Widget {

	//function to set up widget in admin
	function dcs_featured_user_widget() {

		$widget_ops = array( 'classname' => 'featured-user',
		'description' => __('A widget that will display a specified user\'s gravatar, display name, bio, and link to their author post archive.', 'designcrumbs') );

		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'featured-user' );
		parent::__construct( 'featured-user', __('Featured User', 'designcrumbs'), $widget_ops, $control_ops );

	}

	//function to echo out widget on sidebar
	function widget( $args, $instance ) {

		extract( $args );

		$title = $instance['title'];

		echo $before_widget;
		echo "<div class='featured_user'>";

		// if user written title echo out
		if ( $title ){
		echo $before_title . esc_attr($title) . $after_title;
		}
	    //don't touch this!
		$userid = $instance['user_id'];

		//user information array
		//refer to http://codex.wordpress.org/Function_Reference/get_userdata
		$userinfo = get_userdata($userid);

		//user meta data
		//refer to http://codex.wordpress.org/Function_Reference/get_user_meta
		$userbio = get_user_meta($userid,'description',true);

		//user post url
		//refer to http://codex.wordpress.org/Function_Reference/get_author_posts_url
		if ( class_exists( 'EDD_Front_End_Submissions' ) ) :
			$userposturl = FES_Vendors::get_vendor_store_url( $userinfo );
		else :
			$userposturl = $userposturl = get_author_posts_url($userid);
		endif;
		?>

		<!--Now we print out speciifc user informations to screen!-->
		<div class='specific_user clearfix'>
			<?php echo get_avatar($userid,200); ?>
			<h4 class='featured_user_name'>
				<a href='<?php echo esc_attr( $userposturl ); ?>' title='<?php echo esc_attr($userinfo->display_name); ?>'>
					<?php echo esc_attr($userinfo->display_name); ?>
				</a>
			</h4>
			<?php echo esc_attr( $userbio ); ?>
		</div>
		<!--end-->

		<?php

		echo '</div>';
		echo $after_widget;

	 }//end of function widget



	//function to update widget setting
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user_id'] = strip_tags( $new_instance['user_id'] );
		return $instance;

	}//end of function update


	//function to create Widget Admin form
	function form($instance) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '','user_id' => '') );

		$instance['title'] = $instance['title'];
		$instance['user_id'] = $instance['user_id'];

		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Widget Title:', 'designcrumbs'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>"
			 type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'user_id' )); ?>"><?php _e('Select User:', 'designcrumbs'); ?></label>

			<select id="<?php echo esc_attr($this->get_field_id( 'user_id' ));?>" name="<?php echo esc_attr($this->get_field_name( 'user_id' ));?>" class="widefat" style="width:100%;">
			<?php
			$instance = $instance['user_id'];
			$option_list = user_get_users_list_option($instance);
			echo $option_list;
			?>
			</select>

		</p>



	<?php } //end of function form($instance)

}//end of  Class

//function to get all users
function user_get_users_list_option($instance){
$output = '';
global $wpdb;
$users = $wpdb->get_results("SELECT display_name, ID FROM $wpdb->users");
	foreach($users as $u){
    $uname = $u->display_name;
    $uid = $u->ID;
    $output .="<option value='$uid'";
    if($instance == $uid){
    $output.= 'selected="selected"';
    }
    $output.= ">$uname</option>";
	}
return $output;
}

register_widget('dcs_featured_user_widget');

/* =================================== Recent Posts Widget =================================== */

class dcs_widget_recent_posts extends WP_Widget {

    function dcs_widget_recent_posts() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( 'Displays a grid of thumbnails of your latest products.', 'designcrumbs') );
        parent::__construct('my-recent-posts', __('New Products', 'designcrumbs'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('dcs_widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('New Products', 'designcrumbs') : $instance['title'], $instance, $this->id_base);
        if ( !$number = (int) $instance['number'] )
            $number = 9;
        else if ( $number < 1 )
            $number = 1;
        else if ( $number > 15 )
            $number = 15;

        $r = new WP_Query(array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post_type' => 'download'));
        if ($r->have_posts()) : ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . esc_attr($title) . $after_title; ?>

        <div id="recent_products" class="clearfix">

        <?php while ($r->have_posts()) : $r->the_post(); ?>

        	<?php if (has_post_thumbnail()) { ?>
        	<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'thumbnail', array( 'alt' => get_the_title()) ); ?>
			</a>
			<?php } ?>

        <?php endwhile; ?>

        </div>

        <?php echo $after_widget;

        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('dcs_widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('dcs_widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
            $number = 8;
?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"<?php _e('Title:', 'designcrumbs'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

        <p><label for="<?php echo esc_attr( $this->get_field_id('number')); ?>"><?php _e('Number of posts to show:', 'designcrumbs'); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
<?php
    }
}

register_widget('dcs_widget_recent_posts');

/* ====================================================== EXIF data ====================================================== */

function dcs_exif_data() {

	if ( ! is_singular( 'download' ) || ! has_post_thumbnail( get_the_ID() ) || ! of_get_option( 'display_exif' ) ) :
		return;
	endif;

	$image_id	= get_post_thumbnail_id();
	$image 		= wp_get_attachment_metadata( $image_id );
	$image_meta = $image['image_meta'];

	$display_exif = false;
	foreach ( $image_meta as $key => $meta ) :
		$display_exif = isset( $image_meta[ $key ] ) && ! empty( $meta ) || $display_exif ? true : false;
	endforeach;

	if ( $image_meta && apply_filters( 'stocky_display_meta', $display_exif ) ) :

		?><div id='product_exif' class='clearfix'>

			<div class='single-product-meta clearfix'>

				<span><?php _e( '#EXIF data', 'designcrumbs' ); ?></span><?php

				if ( isset( $image_meta['aperture'] ) && ! empty( $image_meta['aperture'] ) && apply_filters( 'stocky_display_exif_aperture', true ) ) :
					?><div class='image-meta-aperture'>
						<span class='label'><?php _e( 'Aperture', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['aperture']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['credit'] ) && ! empty( $image_meta['credit'] ) && apply_filters( 'stocky_display_exif_credit', true ) ) :
					?><div class='image-meta-credit'>
						<span class='label'><?php _e( 'Credit', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['credit']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['camera'] ) && ! empty( $image_meta['camera'] ) && apply_filters( 'stocky_display_exif_camera', true ) ) :
					?><div class='image-meta-camera'>
						<span class='label'><?php _e( 'Camera', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['camera']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['caption'] ) && ! empty( $image_meta['caption'] ) && apply_filters( 'stocky_display_exif_caption', true ) ) :
					?><div class='image-meta-caption'>
						<span class='label'><?php _e( 'Caption', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['caption']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['created_timestamp'] ) && ! empty( $image_meta['created_timestamp'] ) && apply_filters( 'stocky_display_exif_timestamp', true ) ) :
					?><div class='image-meta-credit'>
						<span class='label'><?php _e( 'Created', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo date( 'd-m-Y', $image_meta['created_timestamp'] ); ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['copyright'] ) && ! empty( $image_meta['copyright'] ) && apply_filters( 'stocky_display_exif_copyright', true ) ) :
					?><div class='image-meta-copyright'>
						<span class='label'><?php _e( 'Copyright', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['copyright']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['focal_length'] ) && ! empty( $image_meta['focal_length'] ) && apply_filters( 'stocky_display_exif_focal_length', true ) ) :
					?><div class='image-meta-focal_length'>
						<span class='label'><?php _e( 'Focal length', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['focal_length']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['iso'] ) && ! empty( $image_meta['iso'] ) && apply_filters( 'stocky_display_exif_iso', true ) ) :
					?><div class='image-meta-iso'>
						<span class='label'><?php _e( 'ISO', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['iso']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['shutter_speed'] ) && ! empty( $image_meta['shutter_speed'] ) && apply_filters( 'stocky_display_exif_shutter_speed', true ) ) :
					?><div class='image-meta-shutter-speed'>
						<span class='label'><?php _e( 'Shutter speed', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo round( $image_meta['shutter_speed'], 4 ); ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['title'] ) && ! empty( $image_meta['title'] ) && apply_filters( 'stocky_display_exif_title', true ) ) :
					?><div class='image-meta-title'>
						<span class='label'><?php _e( 'Title', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['title']; ?></span>
					</div><?php
				endif;

				if ( isset( $image_meta['orientation'] ) && ! empty( $image_meta['orientation'] ) && apply_filters( 'stocky_display_exif_orientation', true ) ) :
					?><div class='image-meta-orientation'>
						<span class='label'><?php _e( 'Orientation', 'designcrumbs' ); ?></span>
						<span class='value'><?php echo $image_meta['orientation'] ?></span>
					</div><?php
				endif;

				do_action( 'stocky_display_image_meta', $image_id, $image_meta );

			?></div>

			</div><?php


	endif;

	do_action( 'stocky_after_display_image_meta', $image_id, $image_meta );

}

/* ====================================================== EDD Ratings ====================================================== */

function dcs_star_ratings() {
	// make sure edd reviews is active
	if ( ! function_exists( 'edd_reviews' ) )
		return;

	$edd_reviews = edd_reviews();
	// get the average rating for this download
	$average_rating = (int) $edd_reviews->average_rating( false );
	$rating = $average_rating;

	ob_start();
	?>

		<?php
		/* Only show the ratings if there are indeed ratings */
		if ('0' != $rating) { ?>
		<div itemprop="reviewRating" class="reviewRating clearfix">
			<div class="edd_reviews_rating_box stars<?php echo esc_attr($rating); ?> clearfix">
				<div><?php _e( 'Average Rating', 'designcrumbs' ); ?></div>
					<?php for ( $i = 1; $i <= $rating; $i++ ) : ?>
					<span class="icon-star icon-star-full"></span>
					<?php endfor; for ( $i = 0; $i < ( 5 - $rating ); $i++ ) : ?>
					<span class="icon-star icon-star-empty"></span>
					<?php endfor; ?>
			</div>
			<div style="display:none" >
				<meta itemprop="worstRating" content="1" />
				<span itemprop="ratingValue"><?php echo esc_attr($rating); ?></span>
				<span itemprop="bestRating">5</span>
			</div>
		</div>
		<?php } ?>

	<?php
	$rating_html = ob_get_clean();

	return $rating_html;
}

function dcs_edd_reviews_rating_box() {
	ob_start();
?>
<span class="edd_reviews_rating_box">
	<span class="edd_ratings">
		<a class="edd_rating" href="" data-rating="5"><i class="icon-star-empty"></i></a>
		<span class="edd_show_if_no_js"><input type="radio" name="edd_rating" id="edd_rating" value="5"/>5&nbsp;</span>

		<a class="edd_rating" href="" data-rating="4"><i class="icon-star-empty"></i></a>
		<span class="edd_show_if_no_js"><input type="radio" name="edd_rating" id="edd_rating" value="4"/>4&nbsp;</span>

		<a class="edd_rating" href="" data-rating="3"><i class="icon-star-empty"></i></a>
		<span class="edd_show_if_no_js"><input type="radio" name="edd_rating" id="edd_rating" value="3"/>3&nbsp;</span>

		<a class="edd_rating" href="" data-rating="2"><i class="icon-star-empty"></i></a>
		<span class="edd_show_if_no_js"><input type="radio" name="edd_rating" id="edd_rating" value="2"/>2&nbsp;</span>

		<a class="edd_rating" href="" data-rating="1"><i class="icon-star-empty"></i></a>
		<span class="edd_show_if_no_js"><input type="radio" name="edd_rating" id="edd_rating" value="1"/>1&nbsp;</span>
	</span>
</span>
<?php
	return ob_get_clean();
}
add_filter( 'edd_reviews_rating_box', 'dcs_edd_reviews_rating_box' );

function dcs_edd_reviews_ratings_html( $rating_html, $comment) {

	$rating = get_comment_meta( $comment->comment_ID, 'edd_rating', true );

	ob_start();

	?>
<span itemprop="name" class="review-title-text"><?php echo get_comment_meta( $comment->comment_ID, 'edd_review_title', true ); ?></span>

<div itemprop="reviewRating" class="reviewRating clearfix">
	<div class="edd_reviews_rating_box stars<?php echo esc_attr($rating); ?> clearfix">
		<?php for ( $i = 1; $i <= $rating; $i++ ) : ?>
		<span class="icon-star icon-star-full"></span>
		<?php endfor; for ( $i = 0; $i < ( 5 - $rating ); $i++ ) : ?>
		<span class="icon-star icon-star-empty"></span>
		<?php endfor; ?>
	</div>
	<div style="display:none" >
		<meta itemprop="worstRating" content="1" />
		<span itemprop="ratingValue"><?php echo esc_attr($rating); ?></span>
		<span itemprop="bestRating">5</span>
	</div>
</div>
<?php
	return ob_get_clean();
}
add_filter( 'edd_reviews_ratings_html', 'dcs_edd_reviews_ratings_html', 10, 2 );

/* ====================================================== EDD STUFF ====================================================== */

// filter the EDD downloads shortcode
function dcs_shortcode_atts_downloads( $atts ) {
	$atts[ 'full_content' ] = false;
	$atts[ 'buy_button' ] = false;
	$atts[ 'excerpt' ] = false;
	$atts[ 'price' ] = false;
	$atts[ 'columns' ] = 0;
	if ( ! is_front_page() ) {
		$atts[ 'number' ] = stripslashes(of_get_option('products_total'));
	}
	
	return $atts;
}
add_filter( 'shortcode_atts_downloads', 'dcs_shortcode_atts_downloads' );

// Set the link on pagination to move to the top of the div, not top of the page
function dcs_paginate_links( $link ) {
	return $link . '#stocky_downloads_list';
}
add_filter( 'paginate_links', 'dcs_paginate_links' );

// add stocky_downloads_list ID to downloads list
function dcs_downloads_shortcode( $display ) {
	$output = str_replace( 'class="edd_downloads_list', 'id="stocky_downloads_list" class="edd_downloads_list', $display );

	return $output;
}
add_filter( 'downloads_shortcode', 'dcs_downloads_shortcode' );

// Echo downloads list if EDD is active
function dcs_edd_downloads() {
	if ( function_exists('edd_get_settings') ){
		
		$home_categories = of_get_option( 'home_download_categories' );
		$categories = '';
		if ( ! empty( $home_categories ) ) :
			$categories = implode( ',', array_keys( array_filter( $home_categories ) ) );
		endif;
		
		$home_products_total = 25;
		if ('' != of_get_option('home_products_total')) :
			$home_products_total = esc_attr(of_get_option( 'home_products_total' ));
		endif;
		
		//echo edd_downloads_query( array( 'category' => $categories, 'relation' => 'IN' ) );
		echo do_shortcode('[downloads category="'. $categories .'" number="'. $home_products_total .'"]');
	}
}

// Echo the Add To Wish List button if plugin is active
function dcs_edd_wishlist() {
	if ( function_exists('EDD_Wish_Lists') ) {
		echo (do_shortcode('[edd_wish_lists_add icon="heart"]'));
	}
}

// Echo class for placement of buttons on masonry image hovers
function dcs_edd_wishlist_class() {
	if ( function_exists('EDD_Wish_Lists') ) {
		echo 'stocky_wish_list_on';
	}
}

// Set number of posts for downloads archives
function dcs_downloads_archive_number($query) {
    if ( ! is_admin() && ( $query->is_main_query() && ( $query->is_post_type_archive( 'download' ) || $query->is_tax( 'download_tag' ) || $query->is_tax( 'download_category' ) ) ) )
        $query->set('posts_per_page', stripslashes(of_get_option('products_total')));
}
add_action('pre_get_posts', 'dcs_downloads_archive_number');

// change the size of the featured review avatar
function dcs_edd_reviews_widget_avatar_size( $size ) {
	return 120;
}
add_filter( 'edd_reviews_widget_avatar_size', 'dcs_edd_reviews_widget_avatar_size' );

/* ====================================================== COMMENTS ====================================================== */

function custom_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID( ); ?>">
<div class="the_comment clearfix">
<?php if(function_exists('get_avatar')) { echo get_avatar($comment, '120'); } ?>
<div class="the_comment_author"><?php
echo sprintf( __('<span>%1$s</span> says', 'designcrumbs'), get_comment_author_link() );
?></div>
<?php if ($comment->comment_approved == '0') : //message if comment is held for moderation ?>
<span class="moderation"><?php _e('Your comment is awaiting moderation', 'designcrumbs'); ?>.</span>
<?php endif; ?>
<div class="the_comment_text"><?php comment_text() ?></div>
<small class="commentmetadata">
<a href="<?php comment_link() ?>" class="comment_permalink"><i class="fa fa-clock-o"></i><?php comment_date(get_option( 'date_format' )) ?> - <?php comment_date('g:i a') ?></a>
</small>
<div class="reply">
<?php edit_comment_link( '<i class="fa fa-pencil"></i>' . __('Edit', 'designcrumbs') ); ?><?php echo comment_reply_link(array('reply_text' => '<i class="fa fa-reply"></i>' . __('Reply', 'designcrumbs'), 'depth' => $depth, 'max_depth' => $args['max_depth']));  ?>
</div>
</div>
<?php } ?>
<?php function custom_pings($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID( ); ?>">
<?php _e('Trackback from', 'designcrumbs'); ?> <em><?php comment_author_link() ?></em>
<div class="the_comment_text"><?php comment_text() ?></div>
<small class="commentmetadata">
<?php comment_date(get_option( 'date_format' )) ?>
</small>
<div class="clear"></div>
<?php }


/**
 * Set the vendor header image to the image chosen by the vendor.
 * This requires a profile form field called 'header_image'.
 *
 * @since 1.2.0
 */
function dcs_custom_vendor_header() {

	if ( ! class_exists( 'FES_Vendor_Shop' ) ) :
		return;
	endif;

	$vendor = get_query_var( 'vendor' );
	if ( ! empty( $vendor ) ) :
		if ( is_numeric( $vendor ) ) :
			$vendor = get_userdata( absint( $vendor ) );
		else :
			$vendor = get_user_by( 'slug', $vendor );
		endif;
	endif;

	if ( ! $vendor ) :
		return;
	endif;

	if ( ! is_page( EDD_FES()->helper->get_option( 'fes-vendor-page', false ) ) ) :
		return;
	endif;

	$header_image_id = EDD_FES()->helper->get_user_meta( 'header_image', $vendor->ID );
	if ( ! $header_image_id ) :
		return;
	endif;

	// Set background image
	?><style>
		#header, body.page-template-page-login-php { background-image: url( '<?php echo wp_get_attachment_url( $header_image_id ); ?>' ); }
	</style><?php

}
add_action( 'wp_head', 'dcs_custom_vendor_header' );


/**
 * Save the oEmbed URL from the frontend submission form..
 * This requires a url field called 'oembed_url'.
 *
 * @since 1.2.0
 */

function dcs_fes_save_oembed( $post_id ) {

	if ( isset( $_POST['oembed_url'] ) ) :
		update_post_meta( $post_id, '_dc_embed_link', sanitize_text_field( $_POST['oembed_url'] ) );
	endif;

}
add_action( 'fes_submission_form_save_custom_fields', 'dcs_fes_save_oembed' );