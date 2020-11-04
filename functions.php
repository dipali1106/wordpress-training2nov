<?php
/**
 * Simone functions and definitions
 *
 * @package Simone
 */

/**
 * For child theme authors: To disable the styles and layouts from Simone properly,
 * add the following code to your child theme functions.php file:
 *
 * <?php
 * add_action( 'wp_enqueue_scripts', 'dequeue_parent_theme_styles', 11 );
 * function dequeue_parent_theme_styles() {
 *     wp_dequeue_style( 'simone-parent-style' );
 *     wp_dequeue_style( 'simone-layout' );
 * }
 */
if ( ! function_exists( 'simone_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function simone_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on simone, use a find and replace
		* to change 'simone' to the name of your theme in all the template files
		*/
		load_theme_textdomain( 'simone', get_template_directory() . '/languages' );

		/**
		* Set the content width based on the theme's design and stylesheet.
		*/
		if ( ! isset( $content_width ) ) {
			$content_width = 700; /* pixels */
		}

		// This theme styles the visual editor to resemble the theme style.
		$font_url = '//fonts.googleapis.com/css?family=Lato:300,400,400italic,700,900,900italic|PT+Serif:400,700,400italic,700italic';
		add_editor_style( array( 'inc/editor-style.css', str_replace( ',', '%2C', $font_url ) ) );

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
		* @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

		// Featured image sizes for single posts and pages.
		set_post_thumbnail_size( 1060, 650, true );

		// Featured image size for small image in archives.
		// Note to reviewer: This name needs to be kept for legacy support.
		add_image_size( 'index-thumb', 780, 250, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'simone' ),
				'social'  => __( 'Social Menu', 'simone' ),
			)
		);

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'aside' ) );

		// Setup the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters( 'simone_custom_background_args', array(
			'default-color' => 'b2b2b2',
			'default-image' => get_template_directory_uri() . '/images/pattern.svg',
		) ) );

		// Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			'caption',
		) );
	}
} // simone_setup

add_action( 'after_setup_theme', 'simone_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function simone_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'simone' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Widget', 'simone' ),
			'description'   => __( 'Footer widget area appears, not surprisingly, in the footer of the site.', 'simone' ),
			'id'            => 'sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		)
);
}
add_action( 'widgets_init', 'simone_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function simone_scripts() {
	// Get the current layout setting (sidebar left or right).
	$simone_layout = get_option( 'layout_setting' );
	if ( is_page_template( 'page-templates/page-nosidebar.php' ) || ! is_active_sidebar( 'sidebar-1' ) ) {
		$layout_stylesheet = '/layouts/no-sidebar.css';
	} elseif ( 'left-sidebar' == $simone_layout ) {
		$layout_stylesheet = '/layouts/sidebar-content.css';
	} else {
		$layout_stylesheet = '/layouts/content-sidebar.css';
	}

	// Load parent theme stylesheet even when child theme is active.
	wp_enqueue_style( 'simone-style', simon_get_parent_stylesheet_uri() );

	// Load layout stylesheet.
	wp_enqueue_style( 'simone-layout', get_template_directory_uri() . $layout_stylesheet );

	// Load child theme stylesheet.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'simone-child-style', get_stylesheet_uri() );
	}

	// Lato http://www.google.com/fonts/specimen/Lato + PT Serif http://www.google.com/fonts/specimen/PT+Serif.
	wp_enqueue_style( 'simone-google-fonts', '//fonts.googleapis.com/css?family=Lato:100,300,400,400italic,700,900,900italic|PT+Serif:400,700,400italic,700italic' );

	// FontAwesome.
	wp_enqueue_style( 'simone_fontawesome', get_template_directory_uri() . '/fonts/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_script( 'simone-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'simone-search', get_template_directory_uri() . '/js/hide-search.js', array(), '20120206', true );

	wp_enqueue_script( 'simone-superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), '20200729', true );

	wp_enqueue_script( 'simone-superfish-settings', get_template_directory_uri() . '/js/superfish-settings.js', array( 'jquery' ), '20140328', true );

	wp_enqueue_script( 'simone-masonry', get_template_directory_uri() . '/js/masonry-settings.js', array( 'masonry' ), '20140401', true );

	wp_enqueue_script( 'simone-enquire', get_template_directory_uri() . '/js/enquire.min.js', false, '20200729', true );

	if ( is_single() || is_author() ) {
		wp_enqueue_script( 'simone-hide', get_template_directory_uri() . '/js/hide.js', array( 'jquery' ), '20140310', true );
	}

	wp_enqueue_script( 'simone-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'simone_scripts' );

/**
 * Return parent stylesheet URI
 */
function simon_get_parent_stylesheet_uri() {
	if ( is_child_theme() ) {
		return trailingslashit( get_template_directory_uri() ) . 'style.css';
	} else {
		return get_stylesheet_uri();
	}
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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


/*wp_localize_script( 'core-js', 'ajax_posts', array(
	    'ajaxurl' => site_url(). '/wp-admin/admin-ajax.php' ,
	    'noposts' => __('No older posts found', 'simone'),
	));	
wp_register_script( 'core-js', get_template_directory_uri() . '/js/core.js');
	wp_enqueue_script( 'core-js' );


	function more_post_ajax(){

    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 1;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;

    header("Content-Type: text/html");

    $args = array(
        'suppress_filters' => true,
        'post_type' => 'post',
        'posts_per_page' => $ppp,
        'paged'    => $page,
    );

    $loop = new WP_Query($args);

    $out = '';

    if ($loop -> have_posts()) :  while ($loop -> have_posts()) : $loop -> the_post();
        $out .= '<div class="small-12 large-4 columns"><h1>'
        .get_the_title().'</h1> <p>'
        .get_the_content().'</p></div>';

    endwhile;
    endif;
    wp_reset_postdata();
    die($out);
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');*/

function misha_my_load_more_scripts() {
 
	global $wp_query; 
 
	// In most cases it is already included on the page and this line can be removed
	wp_enqueue_script('jquery');
 
	// register our main script but do not enqueue it yet
	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/myloadmore.js', array('jquery') );
 
	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
 	wp_enqueue_script( 'my_loadmore' );
}
 
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );

function misha_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
 
	// it is always better to use WP_Query but not here
	query_posts( $args );
 
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post();
 
			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			// do you remember? - my example is adapted for Twenty Seventeen theme
			get_template_part( 'content', get_post_format() );
			// for the test purposes comment the line above and uncomment the below one
			// the_title();
 
 
		endwhile;
 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
 
 
 
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}







//Isotope function to get taxonomy slug
function isotope_classes($id){
 $author_terms = wp_get_post_terms(get_the_id(), array('author'));
        foreach ( $author_terms as $author_term ){
        	echo $author_term->slug.' ';
        }

   $type_terms= wp_get_post_terms( get_the_id(), array( 'type' ) ); 
        foreach ( $type_terms as $type_term ) {
        	echo $type_term->slug.' '; 
        }
    }

    