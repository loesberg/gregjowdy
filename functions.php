<?php
/**
 * Greg Jowdy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Greg_Jowdy
 */

if ( ! function_exists( 'greg_jowdy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function greg_jowdy_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Greg Jowdy, use a find and replace
	 * to change 'greg-jowdy' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'greg-jowdy', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'greg-jowdy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'greg_jowdy_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}

/**
* Custom image sizes
*/
add_image_size( 'homepage_box_image', 600, 400, true );
add_image_size( 'homepage_box_image_thumb', 300, 200, true );

endif;
add_action( 'after_setup_theme', 'greg_jowdy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function greg_jowdy_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'greg_jowdy_content_width', 640 );
}
add_action( 'after_setup_theme', 'greg_jowdy_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function greg_jowdy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'greg-jowdy' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'greg-jowdy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'greg_jowdy_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function greg_jowdy_scripts() {
	
	// Stylesheet
// 	wp_enqueue_style( 'greg-jowdy-style', get_stylesheet_uri() );
	
	// Minified and aggregated JS
	wp_enqueue_script( 'greg-jowdy-script', get_template_directory_uri() . '/js/script.min.js', array( 'jquery' ), time(), true );
	
	// Google Fonts
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,400i|Open+Sans:400,400i,600', false );
	
	// Fontawesome
	wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/c4628d7a0d.js', false);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'greg_jowdy_scripts' );

/**
* Enqueue admin scripts
*/
function greg_jowdy_admin_scripts() {
	wp_enqueue_media();
	wp_register_script( 'greg-jowdy-admin-script', get_template_directory_uri() . '/admin/js/box-options.js', array( 'jquery' ), time(), true );
	wp_enqueue_script( 'greg-jowdy-admin-script' );
}
add_action( 'admin_enqueue_scripts', 'greg_jowdy_admin_scripts' );

/**
* Get homepage, secondary, and footer content
*/
function greg_jowdy_get_custom_content( $location ) {
	
	$display = false;
		
	switch ( $location ) {
		case 'home_page_primary':
			$option = 'greg_jowdy_home_page_main_content';
			break;
			
		case 'home_page_secondary':
			$option = 'greg_jowdy_home_page_secondary_content';
			break;
			
		case 'footer':
			$option = 'greg_jowdy_footer_content';
			break;
			
		default:
			$option = 'none';
	}
	
	$content = get_option( $option );
	
	if ( $content && $content != '') {
		$display = apply_filters( 'the_content', get_option( $option ) );	
	}
	
	return $display;
}

/**
* Display home page boxes
*/
function greg_jowdy_show_home_page_boxes() {
	
	$display = "";
	
	$boxes = get_option( 'greg_jowdy_home_page_boxes' );
	
	for ( $i = 0; $i <= 2; $i++ ) {
		$display .= '<div class="home-page-box">';
		$display .= '<a href="' . get_permalink( $boxes['link'][$i] ) . '">';
		$display .= wp_get_attachment_image( $boxes['image'][$i], 'homepage_box_image', false, array( 'class' => 'home-page-box-image' ) );
		$display .= '<p class="home-page-box-text">' . $boxes['text'][$i] . '</p>';
		$display .= '</a>';
		$display .= '</div>';
	}
	
	return $display;
}

/**
* Display home page secondary content
*/
function greg_jowdy_show_home_page_secondary_content() {
	
	$display = false;
	
	$secondary_content = get_option( 'greg_jowdy_home_page_secondary_content' );
	
	if ( $secondary_content && $secondary_content != '' ) {
		$display = $secondary_content;
	} 
	
	return $display;
}

/**
* Contact button
*/
function greg_jowdy_contact_button() {
	
	$button = "<button class='contact-button'>Contact Me</button>";
	
	return $button;
}
add_shortcode( 'contact_button', 'greg_jowdy_contact_button' );

/**
* Shortcode for getting the full year (mostly for the footer)
*/
function greg_jowdy_get_year() {
	
	$year = date( 'Y' );
	
	return $year;
}
add_shortcode( 'copyright_year', 'greg_jowdy_get_year' );


/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* Load theme options page.
*/
require get_template_directory() . '/inc/theme-options.php';
