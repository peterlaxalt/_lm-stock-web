<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath = get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array( "name" =>  __('Basic Settings', 'designcrumbs'),
						"type" => "heading");

	$options[] = array( "name" => __('Logo Retina Display', 'designcrumbs'),
						"desc" => __('Checking this box will display your logo at half size, making it look crisp on iDevices. Make your logo twice as big as you want it to display if you check this box.', 'designcrumbs'),
						"id" => "retina_logo",
						"std" => "0",
						"type" => "checkbox");

	$options[] = array( "name" =>  __('Logo', 'designcrumbs'),
						"desc" =>  __('Upload your logo.', 'designcrumbs'),
						"id" => "logo",
						"type" => "upload");

	$options[] = array( "name" =>  __('Favicon', 'designcrumbs'),
						"desc" =>  __('The Favicon is the little 16x16 icon that appears next to your URL in the browser. It is not required, but recommended.', 'designcrumbs'),
						"id" => "favicon",
						"type" => "upload");

	$options[] = array( "name" =>  __('Site Layout', 'designcrumbs'),
						"desc" =>  __('Select a layout for the site.', 'designcrumbs'),
						"id" => "layout",
						"std" => "content_left",
						"type" => "images",
						"options" => array(
							'content_right' => $imagepath . '2cl.png',
							'content_left' => $imagepath . '2cr.png',)
						);

	$options[] = array( "name" =>  __('Credit Where Credit Is Due', 'designcrumbs'),
						"desc" =>  __('Checking this box will give credit to the Stocky theme and Easy Digital Downloads in the footer.', 'designcrumbs'),
						"id" => "give_credit",
						"std" => "1",
						"type" => "checkbox");

	$options[] = array( "name" =>  __('Keep menu expanded', 'designcrumbs'),
						"desc" =>  __('Checking this box will keep the menu visible by default.', 'designcrumbs'),
						"id" => "expanded_menu",
						"std" => "0",
						"type" => "checkbox");

	$options[] = array( "name" =>  __('Home Page', 'designcrumbs'),
						"type" => "heading");

	$options[] = array( "name" => __('Header Background', 'designcrumbs'),
						"desc" => __('Upload the image for your header background. It will be sized to 100% width of the screen.', 'designcrumbs'),
						"id" => "header_image",
						"type" => "upload");

	$options[] = array( "name" =>  __('Header Text Color', 'designcrumbs'),
						"desc" =>  __('Select the color for the text overlaying the image in your header. This is to help it stand apart.', 'designcrumbs'),
						"id" => "header_text_color",
						"std" => "light_text",
						"type" => "radio",
						"options" => array("light_text" => __('Light', 'designcrumbs'),"dark_text" => __('Dark', 'designcrumbs')));

	$options[] = array( "name" =>  __('Call To Action Text', 'designcrumbs'),
						"desc" =>  __('This appears before the footer.', 'designcrumbs'),
						"id" => "cta_content",
						"std" => "",
						"type" => "editor");

	$options[] = array( "name" => __('Call To Action Background', 'designcrumbs'),
						"desc" => __('Upload the image for your call to action background. It will be sized to 100% width of the screen.', 'designcrumbs'),
						"id" => "cta_image",
						"type" => "upload");
						
	$options[] = array( "name" =>  __('Max Number of Products to be Displayed on Home Page', 'designcrumbs'),
						"desc" =>  __('How many products would you like to display on the home page before pagination starts?', 'designcrumbs'),
						"id" => "home_products_total",
						"std" => "25",
						"class" => "mini",
						"type" => "text");

	$download_categories 	= get_terms( 'download_category', array( 'hide_empty' => false ) );
	$categories_options		= wp_list_pluck( $download_categories, 'name', 'term_id' );
	$options[] = array( "name" => __('Homepage specific download categories', 'designcrumbs'),
						"desc" => __('Only display specific categories of downloads on the homepage. Leave empty to display all categories', 'designcrumbs'),
						"id" => "home_download_categories",
						"type" => "multicheck",
						"options" => $categories_options );

	$options[] = array( "name" =>  __('Store Settings', 'designcrumbs'),
						"type" => "heading");

	$options[] = array( "name" =>  __('Member Login Link', 'designcrumbs'),
						"desc" =>  __('This link will be used in the header. You must create this page and put the login form on it using the Easy Digital Downloads shortcode <strong>[edd_login]</strong>. There is also a <strong>Login Page Template</strong> available for you to use. Put the entire URL including the http://.', 'designcrumbs'),
						"id" => "member_login",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" =>  __('Max Number of Products to be Displayed Per Page', 'designcrumbs'),
						"desc" =>  __('How many products would you like to display per page, other than the home page, before pagination starts?', 'designcrumbs'),
						"id" => "products_total",
						"std" => "25",
						"class" => "mini",
						"type" => "text");

	$options[] = array( "name" =>  __('Display EXIF data', 'designcrumbs'),
						"desc" =>  __('Checking this box will display the EXIF data of the post thumbnail on the download page.', 'designcrumbs'),
						"id" => "display_exif",
						"std" => "0",
						"type" => "checkbox");

	$options[] = array( "name" =>  __('Styles', 'designcrumbs'),
						"type" => "heading");
						
	$options[] = array( "name" =>  __('Menu Color Scheme', 'designcrumbs'),
						"desc" =>  __('Select the color scheme for your menu.', 'designcrumbs'),
						"id" => "menu_scheme",
						"std" => "dark_scheme",
						"type" => "radio",
						"options" => array("dark_scheme" => __('Dark Background, Light Text', 'designcrumbs'),"light_scheme" => __('Light Background, Dark Text', 'designcrumbs')));

	$options[] = array( "name" =>  __('Post Author Box', 'designcrumbs'),
						"desc" =>  __('Enable the "About This Author" box after posts? The avatar pulls from gravatar.com and the description pulls from <strong>Users > Your Profile</strong>', 'designcrumbs'),
						"id" => "author_box",
						"std" => "no",
						"type" => "radio",
						"options" => array("no" => __('No', 'designcrumbs'),"yes" => __('Yes', 'designcrumbs')));

	$options[] = array( "name" =>  __('Link Color', 'designcrumbs'),
						"desc" =>  __('Select the color for your links.', 'designcrumbs'),
						"id" => "link_color",
						"std" => "#2860C5",
						"type" => "color");

	$options[] = array( "name" =>  __('Link Hover Color', 'designcrumbs'),
						"desc" =>  __('Select the hover color for your links.', 'designcrumbs'),
						"id" => "link_color_hover",
						"std" => "#3470DC",
						"type" => "color");

	$options[] = array( "name" =>  __('Button Color', 'designcrumbs'),
						"desc" =>  __('Select the color for your buttons.', 'designcrumbs'),
						"id" => "button_color",
						"std" => "#1E73BE",
						"type" => "color");

	$options[] = array( "name" =>  __('Button Text Color', 'designcrumbs'),
						"desc" =>  __('Select the color for the text of your buttons. This is to help it stand apart from the button background color.', 'designcrumbs'),
						"id" => "button_text",
						"std" => "light",
						"type" => "radio",
						"options" => array("light" => __('Light', 'designcrumbs'),"dark" => __('Dark', 'designcrumbs')));

	$options[] = array( "name" =>  __('Contact', 'designcrumbs'),
						"desc" =>  __('The information input here displays using the Contact Page Template. You must set this template on your contact page.', 'designcrumbs'),
						"type" => "heading");

	$options[] = array( "name" => __('Contact Information', 'designcrumbs'),
						"desc" =>  __('The information input here displays using the Contact Page Template. You must set this template on your contact page.', 'designcrumbs'),
						"type" => "info");

	$options[] = array( "name" => __('Physical Address', 'designcrumbs'),
						"desc" => __('Enter your full address.', 'designcrumbs'),
						"id" => "address",
						"type" => "text");

	$options[] = array( "name" => __('Phone Number', 'designcrumbs'),
						"desc" => __('Enter your phone number.', 'designcrumbs'),
						"id" => "phone",
						"type" => "text");

	$options[] = array( "name" => __('Social Networks', 'designcrumbs'),
						"type" => "heading");

	$options[] = array( "name" => __('Twitter', 'designcrumbs'),
						"desc" => __('Enter the URL to your Twitter profile.', 'designcrumbs'),
						"id" => "twitter",
						"type" => "text");

	$options[] = array( "name" => __('Facebook', 'designcrumbs'),
						"desc" => __('Enter the URL to your Facebook profile.', 'designcrumbs'),
						"id" => "facebook",
						"type" => "text");

	$options[] = array( "name" => __('Google+', 'designcrumbs'),
						"desc" => __('Enter the URL to your Google+ profile.', 'designcrumbs'),
						"id" => "google",
						"type" => "text");

	$options[] = array( "name" => __('Flickr', 'designcrumbs'),
						"desc" => __('Enter the URL to your Flickr Profile.', 'designcrumbs'),
						"id" => "flickr",
						"type" => "text");

	$options[] = array( "name" => __('Tumblr', 'designcrumbs'),
						"desc" => __('Enter the URL to your Tumblr Profile.', 'designcrumbs'),
						"id" => "tumblr",
						"type" => "text");

	$options[] = array( "name" => __('YouTube', 'designcrumbs'),
						"desc" => __('Enter the URL to your YouTube Profile.', 'designcrumbs'),
						"id" => "youtube",
						"type" => "text");

	$options[] = array( "name" => __('Vimeo', 'designcrumbs'),
						"desc" => __('Enter the URL to your Vimeo Profile.', 'designcrumbs'),
						"id" => "vimeo",
						"type" => "text");

	$options[] = array( "name" => __('Pinterest', 'designcrumbs'),
						"desc" => __('Enter the URL to your Pinterest Profile.', 'designcrumbs'),
						"id" => "pinterest",
						"type" => "text");
						
	$options[] = array( "name" => __('LinkedIn', 'designcrumbs'),
						"desc" => __('Enter the URL to your LinkedIn Profile.', 'designcrumbs'),
						"id" => "linkedin",
						"type" => "text");

	// Support

	$options[] = array( "name" => __('Support', 'designcrumbs'),
						"type" => "heading");

	$options[] = array( "name" => __('Theme Documentation & Support', 'designcrumbs'),
						"desc" => "<p class='dc-text'>Theme support and documentation is available for all ThemeForest customers. Visit the <a target='blank' href='http://support.designcrumbs.com'>Design Crumbs Support Forum</a> to get started. Simply follow the instructions on the home page to verify your purchase and get a support account.</p>

						<p class='dc-text'>For support for the Easy Digital Downloads plugin, please visit the <a target='blank' href='https://easydigitaldownloads.com/support/'>Easy Digital Downloads Support Forum</a>.</p>

						<div class='dc-buttons'><a target='blank' class='dc-button help-button' href='". get_template_directory_uri() ."/changelog.txt'><span class='dc-icon icon-changelog'>Changelog</span></a><a target='blank' class='dc-button help-button' href='http://support.designcrumbs.com/help_files/stockywp/'><span class='dc-icon icon-help'>Help File</span></a><a target='blank' class='dc-button support-button' href='http://support.designcrumbs.com'><span class='dc-icon icon-support'>Support Forum</span></a><a target='blank' class='dc-button custom-button' href='http://support.designcrumbs.com/customizations/'><span class='dc-icon icon-custom'>Customization Request</span></a></div>

						<h4 class='heading'>More Themes by Design Crumbs</h4>

						<div class='embed-themes'></div>

						",
						"type" => "info");

	return $options;
}