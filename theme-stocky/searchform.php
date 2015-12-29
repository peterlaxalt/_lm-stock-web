<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<input type="text" class="search_input" value="<?php _e('Search Posts', 'designcrumbs'); ?>" name="s" onfocus="if (this.value == '<?php _e('Search Posts', 'designcrumbs'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search Posts', 'designcrumbs'); ?>';}" />
		<input type="hidden" class="searchsubmit" value="Search" />
		<input type="hidden" name="post_type" value="post" />
	</div>
</form>