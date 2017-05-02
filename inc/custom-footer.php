<?php
/**
* Custom Footer function
*/

function greg_jowdy_custom_footer( $wp_customize ) {
	$wp_customize->add_section(
		'greg_jowdy_footer_options',
		array(
			'title'	=> __( 'Footer Settings', 'gregjowdy' ),
			'priority' => 100,
			'capability' => 'edit_theme_options',
			'description' => __( 'Change footer options here.', 'gregjowdy' ),
		)
	);
	
	$wp_customize->add_setting( 
		'greg_jowdy_footer_content',
		array(
			'default' => 'All content &copy; ' . date( 'Y' ) . ' Greg Jowdy.<br />All rights reserved.',
			'type' => 'option',
			'capability' => 'edit_theme_options',
		)
	);
	
	$wp_customize->add_control(
		'footer_content',
		array(
			'settings' => 'footer_content',
			'label' => __( 'Add/Edit Footer Content' ),
			'section' => 'greg_jowdy_footer_options',
			'type' => 'textarea',
		)
	);
	
}
add_action( 'customize_register', 'greg_jowdy_custom_footer');
