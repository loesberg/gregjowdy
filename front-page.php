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
			<div id="home-page-main-content">
				<?php echo get_option( 'greg_jowdy_home_page_main_content', 'Enter some content here!' ); ?>
			</div>
			
			<?php if ( greg_jowdy_show_home_page_secondary_content() ) : ?>
			
			<div id="home-page-secondary">
				<?php echo greg_jowdy_show_home_page_secondary_content(); ?>
			</div>
			
			<?php endif; ?>

			<div id="home-page-boxes">
				<?php echo greg_jowdy_show_home_page_boxes(); ?>					
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
