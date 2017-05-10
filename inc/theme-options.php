<?php

/**
 * Create admin menu items..
 */
function greg_jowdy_admin_menu() {
	// Create menu page
	add_theme_page( 'Footer Content', 'Footer Content', 'manage_options', 'greg-jowdy-footer-content', 'greg_jowdy_footer_content_page' );
	add_theme_page( 'Home Page Content', 'Home Page', 'manage_options', 'greg-jowdy-home-page-content', 'greg_jowdy_home_page_content_page' );
	add_theme_page( 'Home Page Boxes', 'Boxes', 'manage_options', 'greg-jowdy-home-page-boxes', 'greg_jowdy_home_page_boxes_page' );
	
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
	register_setting( 'greg_jowdy_home_page_content_group', 'greg_jowdy_home_page_title' );
	register_setting( 'greg_jowdy_home_page_content_group', 'greg_jowdy_home_page_main_content' );
	register_setting( 'greg_jowdy_home_page_content_group', 'greg_jowdy_home_page_secondary_content' );
	
	// Home page boxes custom settings
	register_setting( 'greg_jowdy_home_page_boxes_group', 'greg_jowdy_home_page_boxes' );
}

/**
* Home page boxes page.
*/
function greg_jowdy_home_page_boxes_page() {
	
	$box_options = get_option( 'greg_jowdy_home_page_boxes' );
	// Get all pages
	$pages = get_posts( 
		array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		)	
	);
	?>
	<div class="wrap">
		<h1>Home Page Boxes</h1>
		<?php settings_errors(); ?>
		<p>Use this page to edit the content of the home page boxes.</p>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'greg_jowdy_home_page_boxes_group' );
				do_settings_sections( 'greg_jowdy_home_page_boxes_group' );
			?>
			
			<?php for ( $i = 0; $i <= 2; $i++ ) { ?>
				<h2>Box <?php echo $i + 1; ?></h2>
				<table class="form-table">
					<input type="hidden" name="greg_jowdy_home_page_boxes[order][]" value="" />
					<tr><!-- Image -->
						<th scope="row">
							<label for="greg_jowdy_home_page_boxes[image][]">Image:</label>
						</th>
						<td>
							<input name="greg_jowdy_home_page_boxes[image][]" class="box-image-field" type="hidden" size="50" value="<?php echo $box_options['image'][$i]; ?>" />
							<input id="upload-button" type="button" class="button upload-image-button" value="Add/Change Image" />
							<?php 
								$image = wp_get_attachment_image( $box_options['image'][$i], 'homepage_box_image_thumb', false, array( 'class' => 'preview-image' ) ); 
								
								if ( $image != '' ) {
									echo $image;
								} else {
									echo '<img src='' class="preview-image" width="300" height="200" />';
								}
							?>

						</td>
					</tr>
					
					<tr><!-- Box Text -->
						<th scope="row">
							<label for="greg_jowdy_home_page_boxes[text][]">Box Text:</label>
						</th>
						<td>
							<input type="text" name="greg_jowdy_home_page_boxes[text][]" size="50" value="<?php echo $box_options['text'][$i]; ?>" />
						</td>
					</tr>
					
					<tr><!-- Linked Page -->
						<th scope="row">
							<label for="greg_jowdy_home_page_boxes[link][]">Page to Link To:</label>
						</th>
						<td>
							<select name="greg_jowdy_home_page_boxes[link][]">
								<?php
									foreach ( $pages as $page ) {
										echo '<option value="' . $page->ID . '"';
										if ( $box_options['link'][$i] == $page->ID ) {
											echo " selected";
										}
										
										echo '>' . $page->post_title . '</option>';
									}
								?>
							</select>
						</td>
					</tr>
				</table>
				<hr>
			<?php } // End for statement ?>
			<?php submit_button(); ?>
		</form>
	</div>
<?}


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
			<h2>Home Page Title</h2>
			<input type="text" name="greg_jowdy_home_page_title" size="50" value="<?php echo get_option( 'greg_jowdy_home_page_title'); ?>" />
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