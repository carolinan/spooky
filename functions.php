<?php
/**
 * Spooky functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spooky
 */

if ( ! function_exists( 'spooky_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function spooky_setup() {

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
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'spooky' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Spooky dark orange', 'spooky' ),
					'slug'  => 'spooky-dark-orange',
					'color' => '#f74800',
				),
				array(
					'name'  => __( 'Spooky bright orange', 'spooky' ),
					'slug'  => 'spooky-bright-orange',
					'color' => '#f78b00',
				),
				array(
					'name'  => __( 'Spooky yellow', 'spooky' ),
					'slug'  => 'spooky-yellow',
					'color' => '#FAC006',
				),
			)
		);

		add_theme_support( 'align-wide' );

		add_theme_support( 'wp-block-styles' );

		add_theme_support( 'editor-styles' );

		if ( get_theme_mod( 'spooky_dark_mode' ) == true ) {
			add_theme_support( 'dark-editor-style' );
			add_editor_style( 'editor-style-dark.css' );
		}

	}
endif;
add_action( 'after_setup_theme', 'spooky_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function spooky_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'spooky_content_width', 640 );
}
add_action( 'after_setup_theme', 'spooky_content_width', 0 );

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/47891
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'spooky_skip_link' ) ) {
	/**
	 * Include a skip to content link at the top of the page so that users can bypass the menu.
	 */
	function spooky_skip_link() {
		echo '<a class="skip-link screen-reader-text" href="#content">' . esc_html__( 'Skip to content', 'spooky' ) . '</a>';
	}
	add_action( 'wp_body_open', 'spooky_skip_link', 5 );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function spooky_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'spooky' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'spooky' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'spooky_widgets_init' );


if ( ! function_exists( 'spooky_fonts_url' ) ) {
	/**
	 * Register custom fonts.
	 * Credits:
	 * Twenty Seventeen WordPress Theme, Copyright 2016 WordPress.org
	 * Twenty Seventeen is distributed under the terms of the GNU GPL
	 */
	function spooky_fonts_url() {
		$fonts_url = '';

		/*
		* Translators: If there are characters in your language that are not
		* supported by IM Fell English, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$imfell = _x( 'on', 'IM Fell English font: on or off', 'spooky' );

		if ( 'off' !== $imfell ) {
			$font_families = array();

			$font_families[] = 'IM Fell English';

			$query_args = array(
				'family' => rawurlencode( implode( '|', $font_families ) ),
				'subset' => rawurlencode( 'latin' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
}

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function spooky_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'spooky-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'spooky_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function spooky_scripts() {

	wp_enqueue_style( 'spooky-fonts', spooky_fonts_url(), array(), null );

	wp_enqueue_style( 'spooky-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_style_add_data( 'spooky-style', 'rtl', 'replace' );

	wp_enqueue_script( 'spooky-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get( 'Version' ), true );

	wp_enqueue_script( 'spooky-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), wp_get_theme()->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'spooky_scripts' );


/**
 * Add styles and fonts for the block editor.
 */
function spooky_editor_assets() {
	wp_enqueue_style( 'spooky-editor', get_theme_file_uri( 'block-editor.css' ), false );
	wp_enqueue_style( 'spooky-fonts', spooky_fonts_url(), array(), null );

	if ( get_theme_mod( 'spooky_dark_mode' ) == true ) {
		wp_enqueue_style( 'spooky-editor-dark', get_theme_file_uri( 'block-editor-dark.css' ), false );
	}
}
add_action( 'enqueue_block_editor_assets', 'spooky_editor_assets' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Spooky accent colors.
 */
function spooky_custom_colors() {
	if ( get_theme_mod( 'spooky_accent_color' ) ) {
		echo '<style type="text/css">';
		echo '.menu-toggle:hover,
		.menu-toggle:active,
		article a:hover,
		article a:active,
		article a:focus,
		.site-title a  { 
			color: ' . esc_attr( get_theme_mod( 'spooky_accent_color' ) ) . ';}';
		echo '</style>';
	}
}
add_action( 'wp_head', 'spooky_custom_colors' );
