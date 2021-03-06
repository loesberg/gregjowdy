<?php

/**
 * Create admin menu items..
 */
function greg_jowdy_admin_menu() {
	// Create menu page
	add_theme_page( 'Footer Content', 'Footer Content', 'manage_options', 'greg-jowdy-footer-content', 'greg_jowdy_footer_content_page' );
	add_theme_page( 'Home Page Content', 'Home Page', 'manage_options', 'greg-jowdy-home-page-content', 'greg_jowdy_home_page_content_page' );
	add_theme_page( 'Home Page Boxes', 'Boxes', 'manage_options', 'greg-jowdy-home-page-boxes', 'greg_jowdy_home_page_boxes_page' );
	add_theme_page( 'Contact Button', 'Contact Button', 'manage_options', 'greg-jowdy-contact-button', 'greg_jowdy_contact_button_page' );
	
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
	
	// Contact button
	register_setting( 'greg_jowdy_contact_button_group', 'greg_jowdy_contact_button' );
}

/**
* Function for generating a drop-down menu of published pages
*/
function greg_jowdy_pages_drop_down_menu( $option_name, $option_value = NULL ) {
	
	$pages = get_posts( 
		array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		)	
	);
	
	$drop_down = '<select name="'. $option_name . '">';
	
	foreach ( $pages as $page ) {
		$drop_down .= '<option value="' . $page->ID . '"';
		if ( $option_value == $page->ID ) {
			$drop_down .= ' selected';
		}
		$drop_down .= '>';
		$drop_down .= $page->post_title;
		$drop_down .= '</option>';
	}
	
	$drop_down .= '</select>';
	
	return $drop_down;
}

/**
* Home page boxes page.
*/
function greg_jowdy_home_page_boxes_page() {
	
	$box_options = get_option( 'greg_jowdy_home_page_boxes' );
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
									echo '<img src="" class="preview-image" width="300" height="200" />';
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
							<?php echo greg_jowdy_pages_drop_down_menu( 'greg_jowdy_home_page_boxes[link][]', $box_options['link'][$i]); ?>
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
	
/**
* Contact button settings page
*/
function greg_jowdy_contact_button_page() {
	$contact_button = get_option( 'greg_jowdy_contact_button' );
	?>
	<div class="wrap">
		<h1>Contact Button</h1>
		<p>Use this page to change the text of the contact button, and the page that it links to. <strong>These settings affect the contact button everywhere it appears on the site.</strong></p>
		<p>Use the following shortcode to place the button in a post or a page: 
			<pre>[greg-jowdy-contact-button]</pre>
		</p>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'greg_jowdy_contact_button_group' );
				do_settings_sections( 'greg_jowdy_contact_button_group' );
			?>
			<table class="form-table">
				<tr><!-- Button Text -->
					<th scope="row"><label for="contact-button-text">Button Text:</label></th>
					<td><input id="contact-button-text" type="text" name="greg_jowdy_contact_button[text]" value="<?php echo $contact_button['text']; ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="contact-button-page">Contact Page:</label></th>
					<td><?php echo greg_jowdy_pages_drop_down_menu( 'greg_jowdy_contact_button[page_id]',  $contact_button['page_id'] ); ?></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
<?}
	
/**
* Contact button display, with shortcode
*/
function greg_jowdy_contact_button() {
	
	$contact_button = get_option( 'greg_jowdy_contact_button' );
	
	if ( $contact_button ) {
		$display = '<a href="' . get_permalink( $contact_button['page_id'] ) . '">';
		$display .= '<button class="contact-button">' . $contact_button['text'] . '</button>';
		$display .= '</a>';
	} else {
		$display = "Your button needs settings.";
	}
	
	return $display;
}
add_shortcode( 'greg-jowdy-contact-button', 'greg_jowdy_contact_button');