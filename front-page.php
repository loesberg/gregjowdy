<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Greg_Jowdy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h1 class="page-title"><?php echo get_option( 'greg_jowdy_home_page_title', 'Welcome' ); ?></h1>
			
			<?php if ( current_user_can(  'administrator' ) ) echo '<p><a href="/wp-admin/themes.php?page=greg-jowdy-home-page-content">Edit This</a></p>'; ?>
			<div id="home-page-main" class="clear">
				<?php echo greg_jowdy_get_custom_content( 'home_page_primary' ); ?>
			</div>
			<div id="home-page-contact"><a href="/contact"><?php echo greg_jowdy_contact_button(); ?></a></div>
			
			<?php if ( greg_jowdy_get_custom_content( 'home_page_secondary') ) : ?>
			<div class="border"></div>
			
			<div id="home-page-secondary">
				<?php echo greg_jowdy_get_custom_content( 'home_page_secondary'); ?>
			</div>
			
			<?php endif; ?>
			
			<div class="border"></div>

			<div id="home-page-boxes">
				<?php echo greg_jowdy_show_home_page_boxes(); ?>					
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
