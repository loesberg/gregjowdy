<?php

/**
 * Create admin menu items..
 */
function greg_jowdy_admin_menu() {
	// Create menu page
	add_theme_page( 'Footer Content', 'Footer Content', 'manage_options', 'greg-jowdy-footer-content', 'greg_jowdy_footer_content_page' );
	add_theme_page( 'Home Page Content', 'Home Page', 'manage_options', 'greg-jowdy-home-page-content', 'greg_jowdy_home_page_content_page' );
	
	// Register settings
	add_action( 'admin_init', 'greg_jowdy_register_theme_settings' );
}
add_action('admin_menu', 'greg_jowdy_admin_menu' );


/**
 * Register custom theme settings.
 */
function greg_jowdy_register_theme_settings() {
	
	// Footer content custom settings
	register_setting( 'greg_jowdy_footer_content_group', 'greg_jowdy_footer_content' );
	
	// Home page content custom settings
	register_setting( 'greg_jowdy_home_page_content_group', 'greg_jowdy_home_page_main_content' );
	register_setting( 'greg_jowdy_home_page_content_group', 'greg_jowdy_home_page_secondary_content' );
}


/**
 * Footer content page.
 */
function greg_jowdy_footer_content_page() {
	$default_text = "<p>All content &copy; " . date('Y') . " Greg Jowdy.<br />All rights reserved.</p>";
	$current_text = get_option( 'greg_jowdy_footer_content', $default_text );
	?>
	<div class="wrap">
		<h1>Footer Content</h1>
		<?php settings_errors(); ?>
		<p>Use this form to edit the content that appears in the website footer.</p>
		<form method="post" action="options.php">
		<?php
			settings_fields( 'greg_jowdy_footer_content_group' );
			do_settings_sections ( 'greg_jowdy_footer_content_group' );
			// Render the WP Editor
			$settings = array(
				'textarea_name' => 'greg_jowdy_footer_content',
				'textarea_rows' => 5,
				'quicktags' => false,
				'media_buttons' => false,
			);
			wp_editor( $current_text, 'content', $settings );
		?>
		<?php submit_button(); ?>
		</form>
	</div>
<?php }

	
/**
 * Home page content page.
 */
function greg_jowdy_home_page_content_page() {
	
	// Get custom settings
	$home_page_main_content = get_option( 'greg_jowdy_home_page_main_content' );
	$home_page_secondary_content = get_option( 'greg_jowdy_home_page_secondary_content' );
	?>
	<div class="wrap">
		<h1>Home Page Content</h1>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'greg_jowdy_home_page_content_group' );
				do_settings_sections( 'greg_jowdy_footer_content_group' );
			?>
			<h2>Main Content Area</h2>
			<p>Use this field to update the main content area on the home page.</p>
			<?php
				// WP Editor for home page main content
				$current_main_content = ($home_page_main_content) ? $home_page_main_content : '';
				$main_content_settings = array(
					'textarea_name' => 'greg_jowdy_home_page_main_content',
					'drag_drop_upload' => true,
				);
				wp_editor( $current_main_content, 'home_page_main_content', $main_content_settings );
			?>
			<h2>Secondary Content Area</h2>
			<p>Use this field to update the secondary content area on the home page.</p>
			<?php
				// WP Editor for home page secondary content
				$current_secondary_content = ($home_page_secondary_content) ? $home_page_secondary_content : '';
				$secondary_content_settings = array(
					'textarea_name' => 'greg_jowdy_home_page_secondary_content',
					'drag_drop_upload' => true,
				);
				wp_editor( $current_secondary_content, 'home_page_secondary_content', $secondary_content_settings );
			?>
			<?php submit_button(); ?>
		</form>
	</div>
<?php }