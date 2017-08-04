<?php
/**
 * wpblanky functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpblanky
 */

if ( ! function_exists( 'wpblanky_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wpblanky_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wpblanky, use a find and replace
		 * to change 'wpblanky' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wpblanky', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'wpblanky' ),
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
		add_theme_support( 'custom-background', apply_filters( 'wpblanky_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'wpblanky_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpblanky_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wpblanky_content_width', 640 );
}
add_action( 'after_setup_theme', 'wpblanky_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpblanky_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wpblanky' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wpblanky' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpblanky_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wpblanky_scripts() {
	wp_enqueue_style( 'wpblanky-style', get_stylesheet_uri() );

	wp_enqueue_script( 'wpblanky-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'wpblanky-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpblanky_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}




include 'wp_theme_settings.php';

$wpts = new wp_theme_settings(
    array(
        'general' => array('description' => 'Here you can set up your theme settings'),
        'settingsID' => 'wp_theme_settings',
        'settingFields' => array('wp_theme_settings_title'),
        'tabs' => array(
            'general' => array(
                'text' => 'General',
                'dashicon' => 'dashicons-admin-generic',
                'tabFields' => array(
                    array(
                        'type' => 'file',
                        'label' => 'Logo',
                        'name' => 'website_logo',
                        'class' => '',
                        'preview' => true,
                        'description' => 'Upload the logo for your website'
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => 'Enable Bootstrap',
                        'name' => 'enable_bootstrap',
                        'value' => 1,
                        'description' => 'Toggle this if you want to enable Bootstrap Framework'
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => 'Enable FontAwesome',
                        'name' => 'enable_fontawesome',
                        'value' => 1,
                        'description' => 'Toggle this if you want to enable FontAwesome Icon Pack'
                    )

                ) )
        ),

    )
);

add_action('wpts_tab_general' , 'general');
function general(){
    ?>
    <p><label>Title</label></p>
    <input type="text" name="wp_theme_settings_title" value="<?php echo esc_attr( get_option('wp_theme_settings_title') ); ?>" />
    <?php



}

add_action('admin_enqueue_scripts', 'wp_theme_settings_add_stylesheet');
function wp_theme_settings_add_stylesheet(){
    wp_enqueue_style('wp_theme_settings', get_template_directory_uri().'/wp_theme_settings.css');
    wp_register_script('wp_theme_settings',get_template_directory_uri() . '/wp_theme_settings.js', array('jquery'));
    wp_enqueue_script('wp_theme_settings');
}