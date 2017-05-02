<?php

function greg_jowdy_admin_menu() {
	// Create menu page
	add_theme_page( 'Footer Content', 'Footer Content', 'manage_options', 'greg-jowdy-footer-content', 'greg_jowdy_footer_content_page' );
	
	// Register settings
	add_action( 'admin_init', 'greg_jowdy_register_theme_settings' );
}

add_action('admin_menu', 'greg_jowdy_admin_menu' );


function greg_jowdy_register_theme_settings() {
	
	register_setting( 'greg_jowdy_theme_settings_group', 'greg_jowdy_footer_content' );
}

function greg_jowdy_footer_content_page() {
	$default_text = "<p>All content &copy; " . date('Y') . " Greg Jowdy.<br />All rights reserved.</p>";
	$current_text = get_option( 'greg_jowdy_footer_content', $default_text );
	?>
	<div class="wrap">
		<h1>Footer Content</h1>
		<form method="post" action="options.php">
		<?php
			settings_fields( 'greg_jowdy_theme_settings_group' );
			do_settings_sections ( 'greg_jowdy_theme_settings_group' );
			// Render the WP Editor
			$settings = array(
				'textarea_name' => 'greg_jowdy_footer_content',
				'textarea_rows' => 15,
				'quicktags' => false,
			);
			wp_editor( $current_text, 'content', $settings );
		?>
		<?php submit_button(); ?>
		</form>
	</div>
<?php }

