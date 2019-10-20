<?php
/**
 * Spooky Theme Customizer
 *
 * @package Spooky
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function spooky_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'spooky_customize_partial_blogname',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'spooky_customize_partial_blogdescription',
			)
		);
	}

	$wp_customize->add_setting(
		'spooky_accent_color',
		array(
			'default'           => '#f74800',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'spooky_accent_color',
			array(
				'label'    => __( 'Accent color', 'spooky' ),
				'section'  => 'colors',
				'priority' => 100,
			)
		)
	);

	$wp_customize->add_setting(
		'spooky_dark_mode',
		array(
			'sanitize_callback' => 'spooky_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'spooky_dark_mode',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Enable dark mode in the editor.', 'spooky' ),
			'section'  => 'colors',
			'priority' => 1,
		)
	);

}
add_action( 'customize_register', 'spooky_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function spooky_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function spooky_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Checkbox sanitization callback, from
 * https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function spooky_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function spooky_customize_preview_js() {
	wp_enqueue_script( 'spooky-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'spooky_customize_preview_js' );
