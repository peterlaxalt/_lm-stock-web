<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<input type="text" class="search_input" value="<?php _e('Search Products', 'designcrumbs'); ?>" name="s" onfocus="if (this.value == '<?php _e('Search Products', 'designcrumbs'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search Products', 'designcrumbs'); ?>';}" />
		<input type="hidden" id="searchsubmit" value="Search" />
		<input type="hidden" name="post_type" value="download" />
	</div>
</form>