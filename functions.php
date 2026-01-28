<?php
/**
 * haliyora functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package haliyora
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.2.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function haliyora_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on haliyora, use a find and replace
		* to change 'haliyora' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'haliyora', get_template_directory() . '/languages' );

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
	
	// Add custom image sizes
	add_image_size( 'berita-terbaru', 215, 161, true ); // 215x161 untuk berita terbaru

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'haliyora' ),
			'mobile-menu' => esc_html__( 'Mobile Menu', 'haliyora' ),
			'footer' => esc_html__( 'Footer Menu', 'haliyora' ),
			'video-stories' => esc_html__( 'Video Stories Menu', 'haliyora' ),
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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'haliyora_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'haliyora_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function haliyora_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'haliyora_content_width', 1100 );
}
add_action( 'after_setup_theme', 'haliyora_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function haliyora_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'haliyora' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'haliyora' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	// Widget area for Trend 7 berita
	register_sidebar(
		array(
			'name'          => esc_html__( 'Trend 7 Berita', 'haliyora' ),
			'id'            => 'trend-7-berita',
			'description'   => esc_html__( 'Widget untuk menampilkan 7 berita trending. Gunakan widget Recent Posts.', 'haliyora' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s trend-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	// Widget area for Berita Kategori dengan featured image
	register_sidebar(
		array(
			'name'          => esc_html__( 'Berita Kategori Featured', 'haliyora' ),
			'id'            => 'berita-kategori-featured',
			'description'   => esc_html__( 'Widget untuk menampilkan berita berdasarkan kategori dengan featured image besar dan list. Gunakan widget Recent Posts.', 'haliyora' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s category-featured-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	// Widget area for Iklan Header
	register_sidebar(
		array(
			'name'          => esc_html__( 'Iklan Header', 'haliyora' ),
			'id'            => 'iklan-header',
			'description'   => esc_html__( 'Widget untuk menampilkan iklan di header.', 'haliyora' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s iklan-header-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	
	// Widget area for Iklan Sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Iklan Sidebar', 'haliyora' ),
			'id'            => 'iklan-sidebar',
			'description'   => esc_html__( 'Widget untuk menampilkan iklan di sidebar.', 'haliyora' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s iklan-sidebar-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'haliyora_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function haliyora_scripts() {
	// Material Design CSS
	wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), null );
	wp_enqueue_style( 'material-design', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null );
	
	// Font Awesome
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
	
	// Shadcn UI Components CSS
	wp_enqueue_style( 'shadcn-components', get_template_directory_uri() . '/css/shadcn-components.css', array(), _S_VERSION );
	
	// Kumparan Style CSS
	wp_enqueue_style( 'kumparan-style', get_template_directory_uri() . '/css/kumparan-style.css', array( 'shadcn-components' ), _S_VERSION );
	
	// Theme styles
	wp_enqueue_style( 'haliyora-style', get_stylesheet_uri(), array( 'shadcn-components', 'kumparan-style' ), _S_VERSION );
	wp_style_add_data( 'haliyora-style', 'rtl', 'replace' );

	// React and ReactDOM
	wp_enqueue_script( 'react', 'https://unpkg.com/react@18/umd/react.production.min.js', array(), '18.2.0', true );
	wp_enqueue_script( 'react-dom', 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js', array( 'react' ), '18.2.0', true );
	
	// Babel standalone for JSX transformation (development)
	wp_enqueue_script( 'babel-standalone', 'https://unpkg.com/@babel/standalone/babel.min.js', array(), null, true );

	// Ensure React loads on all pages
	wp_add_inline_script( 'react', 'window.ReactGlobal = window.React;' );
	wp_add_inline_script( 'react-dom', 'window.ReactDOMGlobal = window.ReactDOM;' );
	
	// Material Design Initialization
	wp_enqueue_script( 'haliyora-material-design-init', get_template_directory_uri() . '/js/material-design-init.js', array(), _S_VERSION, true );
	
	// Dark Mode Toggle
	wp_enqueue_script( 'haliyora-dark-mode', get_template_directory_uri() . '/js/dark-mode.js', array(), _S_VERSION, true );
	
	// React Initialization (ensures React is loaded before other React scripts)
	wp_enqueue_script( 'haliyora-react-init', get_template_directory_uri() . '/js/react-init.js', array( 'react', 'react-dom' ), _S_VERSION, true );

	// Navigation script
	wp_enqueue_script( 'haliyora-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	
	// Mobile Menu script
	wp_enqueue_script( 'haliyora-mobile-menu', get_template_directory_uri() . '/js/mobile-menu.js', array(), _S_VERSION, true );
	
	// Kumparan Header Interactions
	wp_enqueue_script( 'kumparan-header', get_template_directory_uri() . '/js/kumparan-header.js', array(), _S_VERSION, true );
	
	// Headline Slider script
	wp_enqueue_script( 'haliyora-headline-slider', get_template_directory_uri() . '/js/headline-slider.js', array(), _S_VERSION, true );
	
	// Rekomendasi Carousel script
	wp_enqueue_script( 'haliyora-rekomendasi-carousel', get_template_directory_uri() . '/js/rekomendasi-carousel.js', array(), _S_VERSION, true );
	
	// Analisis Carousel script
	wp_enqueue_script( 'haliyora-regional-carousel', get_template_directory_uri() . '/js/regional-carousel.js', array(), _S_VERSION, true );
	
	// Topik Carousel script
	wp_enqueue_script( 'haliyora-topik-carousel', get_template_directory_uri() . '/js/topik-carousel.js', array(), _S_VERSION, true );
	
	// Load More script
	wp_enqueue_script( 'haliyora-load-more', get_template_directory_uri() . '/js/load-more.js', array(), _S_VERSION, true );
	
	// Lightbox script
	wp_enqueue_script( 'haliyora-lightbox', get_template_directory_uri() . '/js/lightbox.js', array(), _S_VERSION, true );
	
	// Header Features script
	wp_enqueue_script( 'haliyora-header-features', get_template_directory_uri() . '/js/header-features.js', array(), _S_VERSION, true );

	// Localize Weather Data from BMKG
	wp_localize_script( 'haliyora-header-features', 'bmkgWeatherData', haliyora_get_bmkg_weather_jatim() );

	// Localize script for AJAX
	wp_localize_script( 'haliyora-load-more', 'haliyoraAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'haliyora_load_more_nonce' ),
	) );
	
	// Custom React components (depends on react-init)
	wp_enqueue_script( 'haliyora-react', get_template_directory_uri() . '/js/react-components.js', array( 'react', 'react-dom', 'haliyora-react-init' ), _S_VERSION, true );
	
	// Enhanced React integration for all pages (depends on react-init and react-components)
	wp_enqueue_script( 'haliyora-react-integration', get_template_directory_uri() . '/js/react-integration.js', array( 'react', 'react-dom', 'haliyora-react-init', 'haliyora-react' ), _S_VERSION, true );
	
	// React SPA Core (for SPA pages)
	wp_enqueue_script( 'haliyora-react-spa-core', get_template_directory_uri() . '/js/react-spa-core.js', array( 'react', 'react-dom', 'haliyora-react-init' ), _S_VERSION, true );
	
	// System Check (optional - for development/debugging)
	// Uncomment line below to enable system check in console
	// wp_enqueue_script( 'haliyora-system-check', get_template_directory_uri() . '/js/system-check.js', array(), _S_VERSION, true );
	
	// Initialize React with site data
	wp_add_inline_script( 'haliyora-react-integration', '
		// Prepare site data for React components
		window.haliyoraCurrentUserData = ' . json_encode(haliyora_get_current_user_data()) . ';
		window.haliyoraSiteInfo = ' . json_encode(haliyora_get_site_info()) . ';
		
		// Initialize components when DOM and React are ready
		if (window.HaliyoraReact && window.HaliyoraReact.renderAll) {
			if (document.readyState === "loading") {
				document.addEventListener("DOMContentLoaded", window.HaliyoraReact.renderAll);
			} else {
				setTimeout(window.HaliyoraReact.renderAll, 100);
			}
		}
	' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'haliyora_scripts' );

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
 * Custom Widgets.
 */
require get_template_directory() . '/inc/widgets.php';

// React helpers
require get_template_directory() . '/inc/react-helpers.php';

/**
 * Enable React SPA Mode for specific templates
 */
function haliyora_enable_react_spa_mode() {
	// Check if we're on a React SPA template
	$is_react_spa = false;
	
	// Check for React SPA page templates
	if ( is_page_template( 'page-react-spa-home.php' ) ) {
		$is_react_spa = true;
	}
	
	// Note: Default home/index.php uses PHP rendering, not React SPA
	// Uncomment below to enable React SPA on default home
	// if ( is_home() || is_front_page() ) {
	// 	$is_react_spa = true;
	// }
	
	// Check for React category template (category-react.php)
	if ( is_category() && locate_template( 'category-react.php' ) ) {
		// Category will use category-react.php if it exists
		$template = get_category_template();
		if ( strpos( $template, 'category-react.php' ) !== false ) {
			$is_react_spa = true;
		}
	}
	
	// Check for React single template (single-react.php)
	if ( is_single() && locate_template( 'single-react.php' ) ) {
		$template = get_single_template();
		if ( strpos( $template, 'single-react.php' ) !== false ) {
			$is_react_spa = true;
		}
	}
	
	if ( $is_react_spa ) {
		add_filter( 'body_class', 'haliyora_add_react_spa_body_class' );
	}
	
	return $is_react_spa;
}
add_action( 'wp', 'haliyora_enable_react_spa_mode' );

/**
 * Add React SPA class to body
 */
function haliyora_add_react_spa_body_class( $classes ) {
	$classes[] = 'react-spa-mode';
	return $classes;
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Generate Sitemap if enabled
 */
function haliyora_generate_sitemap() {
	if ( ! get_theme_mod( 'haliyora_sitemap_enable', false ) ) {
		return;
	}
	
	add_rewrite_rule( '^sitemap\.xml$', 'index.php?haliyora_sitemap=1', 'top' );
}
add_action( 'init', 'haliyora_generate_sitemap' );

/**
 * Register custom query variables.
 */
function haliyora_query_vars( $vars ) {
	$vars[] = 'haliyora_sitemap';
	return $vars;
}
add_filter( 'query_vars', 'haliyora_query_vars' );

/**
 * Display Sitemap
 */
function haliyora_display_sitemap() {
	if ( ! get_query_var( 'haliyora_sitemap' ) ) {
		return;
	}
	
	header( 'Content-Type: text/xml; charset=utf-8' );
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	
	// Homepage
	echo '<url>';
	echo '<loc>' . esc_url( home_url( '/' ) ) . '</loc>';
	echo '<lastmod>' . date( 'Y-m-d' ) . '</lastmod>';
	echo '<changefreq>daily</changefreq>';
	echo '<priority>1.0</priority>';
	echo '</url>';
	
	// Posts
	$posts = get_posts( array(
		'numberposts' => -1,
		'post_status' => 'publish',
	) );
	
	foreach ( $posts as $post ) {
		echo '<url>';
		echo '<loc>' . esc_url( get_permalink( $post->ID ) ) . '</loc>';
		echo '<lastmod>' . get_the_modified_date( 'Y-m-d', $post->ID ) . '</lastmod>';
		echo '<changefreq>weekly</changefreq>';
		echo '<priority>0.8</priority>';
		echo '</url>';
	}
	
	// Pages
	$pages = get_pages();
	foreach ( $pages as $page ) {
		echo '<url>';
		echo '<loc>' . esc_url( get_permalink( $page->ID ) ) . '</loc>';
		echo '<lastmod>' . get_the_modified_date( 'Y-m-d', $page->ID ) . '</lastmod>';
		echo '<changefreq>monthly</changefreq>';
		echo '<priority>0.6</priority>';
		echo '</url>';
	}
	
	// Categories
	$categories = get_categories();
	foreach ( $categories as $category ) {
		echo '<url>';
		echo '<loc>' . esc_url( get_category_link( $category->term_id ) ) . '</loc>';
		echo '<lastmod>' . date( 'Y-m-d' ) . '</lastmod>';
		echo '<changefreq>weekly</changefreq>';
		echo '<priority>0.5</priority>';
		echo '</url>';
	}
	
	echo '</urlset>';
	exit;
}
add_action( 'template_redirect', 'haliyora_display_sitemap' );

/**
 * Track Post Views
 */
function haliyora_track_post_views( $post_id ) {
	if ( ! is_single() ) {
		return;
	}
	
	if ( empty( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}
	
	$count_key = 'post_views_count';
	$count = get_post_meta( $post_id, $count_key, true );
	
	if ( $count == '' ) {
		$count = 0;
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $post_id, $count_key, $count );
	}
}
add_action( 'wp_head', 'haliyora_track_post_views' );

/**
 * Add Open Graph Meta Tags for Social Sharing
 */
function haliyora_add_og_meta_tags() {
    $image = '';
    $width = '';
    $height = '';

    if ( is_singular() ) {
        global $post;
        $title = get_the_title();
        $url = get_permalink();
        $description = wp_trim_words( get_the_excerpt(), 25 );
        $type = 'article';
        
        if ( has_post_thumbnail( $post->ID ) ) {
            $thumbnail_id = get_post_thumbnail_id($post->ID);
            $img_data = wp_get_attachment_image_src($thumbnail_id, 'large');
            if ($img_data) {
                $image = $img_data[0];
                $width = $img_data[1];
                $height = $img_data[2];
            }
        }
    } else {
        $title = get_bloginfo( 'name' );
        $description = get_bloginfo( 'description' );
        $url = home_url();
        $type = 'website';
    }

    // Fallback image (Site Logo or default placeholder if needed)
    if ( ! $image ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        if ( $custom_logo_id ) {
            $img_data = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($img_data) {
                $image = $img_data[0];
                $width = $img_data[1];
                $height = $img_data[2];
            }
        }
    }

    if ( $title ) {
        echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    }
    if ( $description ) {
        echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    }
    if ( $image ) {
        echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
        echo '<meta property="og:image:secure_url" content="' . esc_url( $image ) . '">' . "\n";
        if ($width) echo '<meta property="og:image:width" content="' . esc_attr($width) . '">' . "\n";
        if ($height) echo '<meta property="og:image:height" content="' . esc_attr($height) . '">' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    }
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'haliyora_add_og_meta_tags', 5 );

/**
 * Ensure newest posts are always on top across all archives
 */
function haliyora_optimize_archive_queries( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( is_archive() || is_home() || is_search() ) {
        $query->set( 'ignore_sticky_posts', true );
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'DESC' );
    }
}
add_action( 'pre_get_posts', 'haliyora_optimize_archive_queries' );

/**
 * Get Post Thumbnail with Fallback
 * Priority: Featured Image > First Image in Content > First Attachment > Placeholder
 */
function haliyora_get_post_thumbnail( $post_id = null, $size = 'medium', $attr = array() ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    // 1. Check for Featured Image
    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail( $post_id, $size, $attr );
    }

    // 2. Check for first image in content
    $post = get_post( $post_id );
    $content = $post->post_content;
    if ( preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches ) ) {
        $first_img = $matches[1][0];
        $class = isset( $attr['class'] ) ? $attr['class'] : '';
        return '<img src="' . esc_url( $first_img ) . '" class="' . esc_attr( $class ) . ' fallback-image-content" alt="' . esc_attr( get_the_title( $post_id ) ) . '" loading="lazy">';
    }

    // 3. Check for first attachment
    $images = get_children( array(
        'post_parent'    => $post_id,
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'numberposts'    => 1
    ) );

    if ( $images ) {
        $attachment = array_shift( $images );
        return wp_get_attachment_image( $attachment->ID, $size, false, $attr );
    }

    // 4. Placeholder Fallback
    $placeholder = get_template_directory_uri() . '/assets/images/placeholder.jpg';
    $class = isset( $attr['class'] ) ? $attr['class'] : '';
    return '<img src="' . esc_url( $placeholder ) . '" class="' . esc_attr( $class ) . ' fallback-placeholder" alt="' . esc_attr( get_the_title( $post_id ) ) . '" loading="lazy">';
}

/**
 * Get Post Views
 */
function haliyora_get_post_views( $post_id ) {
	$count_key = 'post_views_count';
	$count = get_post_meta( $post_id, $count_key, true );
	
	if ( $count == '' ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		return '0';
	}
	
	return $count;
}

/**
 * Format Date & Time: Hari, Tanggal Bulan Tahun, pukul: Jam:Menit WIB
 */
function haliyora_format_date( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	
	// Format: l (day), j (date), F (month), Y (year), H:i (time)
	// WP translate this if language is ID
	return get_the_date( 'l, j F Y, \p\u\k\u\l : H:i \W\I\B', $post_id );
}

/**
 * AJAX Handler for Load More Posts
 */
function haliyora_load_more_berita() {
	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'haliyora_load_more_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
	}
	
	$page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
	$loaded_ids = isset( $_POST['loaded_ids'] ) ? sanitize_text_field( $_POST['loaded_ids'] ) : '';
	$category_id = isset( $_POST['category'] ) ? absint( $_POST['category'] ) : 0;
	
	// Parse loaded IDs
	$exclude_ids = array();
	if ( ! empty( $loaded_ids ) ) {
		$exclude_ids = array_map( 'absint', explode( ',', $loaded_ids ) );
		$exclude_ids = array_filter( $exclude_ids );
	}
	
	// Query arguments
	$args = array(
		'post_type'      => array( 'post', 'berita_foto' ),
		'posts_per_page' => 9,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'ignore_sticky_posts' => true,
	);
	
	// If we have excluded IDs, we should use paged 1 to get the next available posts
	// because post__not_in already removes the previous pages' posts.
	if ( ! empty( $exclude_ids ) ) {
		$args['post__not_in'] = $exclude_ids;
		$args['paged'] = 1;
	} else {
		$args['paged'] = $page;
	}
	
	// Add category filter if provided
	if ( $category_id > 0 ) {
		$args['cat'] = $category_id;
	}
	
	$query = new WP_Query( $args );
	
	$html = '';
	$new_loaded_ids = array();
	
	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			$new_loaded_ids[] = get_the_ID();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'berita-terbaru-item' ); ?> data-post-id="<?php the_ID(); ?>">
				<div class="berita-terbaru-thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php echo haliyora_get_post_thumbnail( null, 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) ); ?>
						<?php if ( get_post_type() === 'berita_foto' ) : ?>
							<div class="photo-icon-overlay">
								<span class="material-icons">photo_camera</span>
								<span>FOTO</span>
							</div>
						<?php endif; ?>
					</a>
				</div>
				<div class="berita-terbaru-content">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<span class="berita-terbaru-category"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
					}
					?>
					<h3 class="berita-terbaru-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<div class="berita-terbaru-date">
						<span class="material-icons">schedule</span>
						<?php echo haliyora_format_date(); ?>
					</div>
				</div>
			</article>
			<?php
		}
		$html = ob_get_clean();
		wp_reset_postdata();
	}
	
	// Merge loaded IDs
	$all_loaded_ids = array_merge( $exclude_ids, $new_loaded_ids );
	$all_loaded_ids = array_unique( $all_loaded_ids );
	
	wp_send_json_success( array(
		'html'       => $html,
		'loaded_ids' => implode( ',', $all_loaded_ids ),
		'has_more'   => ( ! empty( $exclude_ids ) ) ? $query->max_num_pages > 1 : $query->max_num_pages > $page,
	) );
}
add_action( 'wp_ajax_load_more_berita', 'haliyora_load_more_berita' );
add_action( 'wp_ajax_nopriv_load_more_berita', 'haliyora_load_more_berita' );

/**
 * Customize Tag Cloud Widget Output
 */
function haliyora_tag_cloud_args( $args ) {
	$args['format'] = 'list';
	$args['separator'] = '';
	$args['smallest'] = 13;
	$args['largest'] = 13;
	$args['unit'] = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'haliyora_tag_cloud_args' );

/**
 * Add # before tag names in tag cloud
 */
function haliyora_add_hash_to_tag_cloud( $return, $tags ) {
	if ( empty( $tags ) ) {
		return $return;
	}
	
	// Add # before tag names
	$return = preg_replace_callback(
		'/<a\s+([^>]*?)>(.*?)<\/a>/i',
		function( $matches ) {
			// Check if # already exists
			$tag_name = trim( $matches[2] );
			if ( strpos( $tag_name, '#' ) === 0 ) {
				return $matches[0];
			}
			return '<a ' . $matches[1] . '>#' . $tag_name . '</a>';
		},
		$return
	);
	
	return $return;
}
add_filter( 'wp_generate_tag_cloud', 'haliyora_add_hash_to_tag_cloud', 10, 2 );

/**
 * Custom Comment Callback
 */
function haliyora_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class( 'modern-comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 60, '', '', array( 'class' => 'comment-avatar-img' ) ); ?>
			</div>
			<div class="comment-content-wrapper">
				<div class="comment-meta">
					<cite class="comment-author"><?php comment_author(); ?></cite>
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation">Komentar Anda menunggu moderasi.</em>
					<?php endif; ?>
					<time class="comment-time" datetime="<?php comment_time( 'c' ); ?>">
						<span class="material-icons">schedule</span>
						<?php printf( esc_html__( '%1$s at %2$s', 'haliyora' ), get_comment_date(), get_comment_time() ); ?>
					</time>
				</div>
				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
				<div class="comment-actions">
					<?php
					comment_reply_link( array_merge( $args, array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'reply_text' => '<span class="material-icons">reply</span> Balas',
					) ) );
					?>
				</div>
			</div>
		</article>
	<?php
}

/**
 * Chat Model Comment Callback
 */
function haliyora_chat_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$is_author = ( $comment->user_id === get_the_author_meta('ID') );
	$is_me = ( get_current_user_id() && $comment->user_id === get_current_user_id() );
	$chat_class = $is_me ? 'chat-me' : 'chat-other';
	if ( $is_author ) $chat_class .= ' chat-author';
	?>
	<li <?php comment_class( 'chat-item ' . $chat_class ); ?> id="comment-<?php comment_ID(); ?>">
		<div id="div-comment-<?php comment_ID(); ?>" class="chat-bubble-wrapper">
			<div class="chat-avatar">
				<?php echo get_avatar( $comment, 40, '', '', array( 'class' => 'chat-avatar-img' ) ); ?>
			</div>
			<div class="chat-bubble-content">
				<div class="chat-meta">
					<span class="chat-author-name"><?php comment_author(); ?></span>
					<?php if ( $is_author ) : ?>
						<span class="chat-author-badge">Penulis</span>
					<?php endif; ?>
				</div>
				<div class="chat-text">
					<?php comment_text(); ?>
				</div>
				<div class="chat-footer">
					<time class="chat-time">
						<?php echo get_comment_date('H:i') . ' WIB'; ?>
					</time>
					<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'reply_text' => 'Balas',
					) ) );
					?>
				</div>
			</div>
		</div>
	<?php
}

/**
 * Mobile Menu Walker with Different Colored Icons
 */
class Haliyora_Mobile_Menu_Walker extends Walker_Nav_Menu {
	// Array of icons and colors for menu items
	private $icon_colors = array(
		'home' => array( 'icon' => 'home', 'color' => '#d32f2f' ),
		'news' => array( 'icon' => 'article', 'color' => '#1976d2' ),
		'sports' => array( 'icon' => 'sports_soccer', 'color' => '#388e3c' ),
		'tech' => array( 'icon' => 'computer', 'color' => '#f57c00' ),
		'entertainment' => array( 'icon' => 'movie', 'color' => '#7b1fa2' ),
		'business' => array( 'icon' => 'business', 'color' => '#0288d1' ),
		'lifestyle' => array( 'icon' => 'favorite', 'color' => '#c2185b' ),
		'health' => array( 'icon' => 'local_hospital', 'color' => '#e91e63' ),
		'education' => array( 'icon' => 'school', 'color' => '#0097a7' ),
		'politics' => array( 'icon' => 'account_balance', 'color' => '#5d4037' ),
	);

	private $item_index = 0;

	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		// Get icon and color based on menu item title or slug
		$item_slug = sanitize_title( $item->title );
		$icon_data = $this->get_icon_for_item( $item_slug, $item->title );
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		
		$output .= $indent . '<li' . $id . $class_names .'>';
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		$item_output = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a class="mobile-category-menu-item menu-icon-' . esc_attr( $icon_data['class'] ) . '"' . $attributes .'>';
		$item_output .= '<span class="material-icons menu-icon" style="color: ' . esc_attr( $icon_data['color'] ) . ';">' . esc_html( $icon_data['icon'] ) . '</span>';
		$item_output .= '<span>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
		$this->item_index++;
	}

	function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}

	private function get_icon_for_item( $slug, $title ) {
		$slug_lower = strtolower( $slug );
		$title_lower = strtolower( $title );
		
		// Default colors array
		$default_colors = array(
			'#d32f2f', '#1976d2', '#388e3c', '#f57c00', '#7b1fa2',
			'#0288d1', '#c2185b', '#e91e63', '#0097a7', '#5d4037',
			'#d84315', '#00695c', '#6a1b9a', '#1565c0', '#c62828'
		);
		
		// Default icons array
		$default_icons = array(
			'home', 'article', 'folder', 'category', 'label',
			'bookmark', 'star', 'favorite', 'thumb_up', 'trending_up',
			'newspaper', 'public', 'language', 'rss_feed', 'notifications'
		);
		
		// Check if we have a specific match
		foreach ( $this->icon_colors as $key => $data ) {
			if ( strpos( $slug_lower, $key ) !== false || strpos( $title_lower, $key ) !== false ) {
				return array(
					'icon' => $data['icon'],
					'color' => $data['color'],
					'class' => $key
				);
			}
		}
		
		// Use index-based selection for variety
		$color_index = $this->item_index % count( $default_colors );
		$icon_index = $this->item_index % count( $default_icons );
		
		return array(
			'icon' => $default_icons[ $icon_index ],
			'color' => $default_colors[ $color_index ],
			'class' => 'menu-item-' . $this->item_index
		);
	}
}

/**
 * Performance Optimization - Disable Unnecessary Features
 */
// Remove emoji scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Remove jQuery Migrate
function haliyora_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'haliyora_remove_jquery_migrate' );

// Defer JavaScript Loading
function haliyora_defer_scripts( $tag, $handle, $src ) {
	$defer = array(
		'haliyora-rekomendasi-carousel',
		'haliyora-regional-carousel',
		'haliyora-load-more',
		'haliyora-lightbox',
		'haliyora-mobile-menu',
		'haliyora-headline-slider'
	);
	
	if ( in_array( $handle, $defer ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	
	return $tag;
}
add_filter( 'script_loader_tag', 'haliyora_defer_scripts', 10, 3 );

// Lazy load images
function haliyora_add_lazy_load( $content ) {
	if ( is_admin() ) {
		return $content;
	}
	
	$content = preg_replace( '/<img(.*?)src=/i', '<img$1loading="lazy" src=', $content );
	return $content;
}
add_filter( 'the_content', 'haliyora_add_lazy_load' );
add_filter( 'post_thumbnail_html', 'haliyora_add_lazy_load' );

// Optimize database queries - limit post revisions
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 3 );
}

// GZIP compression disabled to fix ERR_CONTENT_DECODING_FAILED
/*
if ( ! ini_get( 'zlib.output_compression' ) ) {
	ini_set( 'zlib.output_compression', 'On' );
}
*/

/**
 * Security Enhancements
 */
// Remove WordPress version from head
remove_action( 'wp_head', 'wp_generator' );

// Remove version from scripts and styles
function haliyora_remove_version_scripts_styles( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'haliyora_remove_version_scripts_styles', 9999 );
add_filter( 'script_loader_src', 'haliyora_remove_version_scripts_styles', 9999 );

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Remove RSD link
remove_action( 'wp_head', 'rsd_link' );

// Remove wlwmanifest link
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Disable file editing from dashboard
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

// Add security headers
function haliyora_security_headers() {
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-XSS-Protection: 1; mode=block' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
add_action( 'send_headers', 'haliyora_security_headers' );

// Sanitize file uploads
function haliyora_sanitize_file_name_on_upload( $filename ) {
	$filename = preg_replace( '/[^a-zA-Z0-9._-]/', '', $filename );
	return strtolower( $filename );
}
add_filter( 'sanitize_file_name', 'haliyora_sanitize_file_name_on_upload', 10 );

/**
 * Register Video Stories Custom Post Type
 */
function haliyora_register_video_stories_cpt() {
    $labels = array(
        'name'                  => _x( 'Video Stories', 'Post type general name', 'haliyora' ),
        'singular_name'         => _x( 'Video Story', 'Post type singular name', 'haliyora' ),
        'menu_name'             => _x( 'Video Stories', 'Admin Menu text', 'haliyora' ),
        'name_admin_bar'        => _x( 'Video Story', 'Add New on Toolbar', 'haliyora' ),
        'add_new'               => __( 'Add New', 'haliyora' ),
        'add_new_item'          => __( 'Add New Video Story', 'haliyora' ),
        'new_item'              => __( 'New Video Story', 'haliyora' ),
        'edit_item'             => __( 'Edit Video Story', 'haliyora' ),
        'view_item'             => __( 'View Video Story', 'haliyora' ),
        'all_items'             => __( 'All Video Stories', 'haliyora' ),
        'search_items'          => __( 'Search Video Stories', 'haliyora' ),
        'parent_item_colon'     => __( 'Parent Video Stories:', 'haliyora' ),
        'not_found'             => __( 'No video stories found.', 'haliyora' ),
        'not_found_in_trash'    => __( 'No video stories found in Trash.', 'haliyora' ),
        'featured_image'        => _x( 'Video Thumbnail', 'Overrides the "Featured Image" phrase', 'haliyora' ),
        'set_featured_image'    => _x( 'Set video thumbnail', 'Overrides the "Set featured image" phrase', 'haliyora' ),
        'remove_featured_image' => _x( 'Remove video thumbnail', 'Overrides the "Remove featured image" phrase', 'haliyora' ),
        'use_featured_image'    => _x( 'Use as video thumbnail', 'Overrides the "Use as featured image" phrase', 'haliyora' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'video-stories' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-video-alt2',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'comments' ),
        'taxonomies'         => array( 'category', 'post_tag' ),
    );

    register_post_type( 'video_story', $args );
}
add_action( 'init', 'haliyora_register_video_stories_cpt' );

/**
 * Register Video Story Categories Taxonomy
 */
function haliyora_register_video_story_categories() {
    $labels = array(
        'name'              => _x( 'Video Categories', 'taxonomy general name', 'haliyora' ),
        'singular_name'     => _x( 'Video Category', 'taxonomy singular name', 'haliyora' ),
        'search_items'      => __( 'Search Video Categories', 'haliyora' ),
        'all_items'         => __( 'All Video Categories', 'haliyora' ),
        'parent_item'       => __( 'Parent Video Category', 'haliyora' ),
        'parent_item_colon' => __( 'Parent Video Category:', 'haliyora' ),
        'edit_item'         => __( 'Edit Video Category', 'haliyora' ),
        'update_item'       => __( 'Update Video Category', 'haliyora' ),
        'add_new_item'      => __( 'Add New Video Category', 'haliyora' ),
        'new_item_name'     => __( 'New Video Category Name', 'haliyora' ),
        'menu_name'         => __( 'Video Categories', 'haliyora' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'video-category' ),
    );

    register_taxonomy( 'video_story_category', array( 'video_story' ), $args );
}
add_action( 'init', 'haliyora_register_video_story_categories', 0 );

/**
 * Register Berita Foto Custom Post Type
 */
function haliyora_register_berita_foto_cpt() {
    $labels = array(
        'name'                  => _x( 'Berita Foto', 'Post type general name', 'haliyora' ),
        'singular_name'         => _x( 'Berita Foto', 'Post type singular name', 'haliyora' ),
        'menu_name'             => _x( 'Berita Foto', 'Admin Menu text', 'haliyora' ),
        'name_admin_bar'        => _x( 'Berita Foto', 'Add New on Toolbar', 'haliyora' ),
        'add_new'               => __( 'Tambah Baru', 'haliyora' ),
        'add_new_item'          => __( 'Tambah Berita Foto Baru', 'haliyora' ),
        'new_item'              => __( 'Berita Foto Baru', 'haliyora' ),
        'edit_item'             => __( 'Edit Berita Foto', 'haliyora' ),
        'view_item'             => __( 'Lihat Berita Foto', 'haliyora' ),
        'all_items'             => __( 'Semua Berita Foto', 'haliyora' ),
        'search_items'          => __( 'Cari Berita Foto', 'haliyora' ),
        'parent_item_colon'     => __( 'Induk Berita Foto:', 'haliyora' ),
        'not_found'             => __( 'Berita foto tidak ditemukan.', 'haliyora' ),
        'not_found_in_trash'    => __( 'Berita foto tidak ditemukan di Trash.', 'haliyora' ),
        'featured_image'        => _x( 'Foto Utama', 'Overrides the "Featured Image" phrase', 'haliyora' ),
        'set_featured_image'    => _x( 'Set foto utama', 'Overrides the "Set featured image" phrase', 'haliyora' ),
        'remove_featured_image' => _x( 'Hapus foto utama', 'Overrides the "Remove featured image" phrase', 'haliyora' ),
        'use_featured_image'    => _x( 'Gunakan sebagai foto utama', 'Overrides the "Use as featured image" phrase', 'haliyora' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'berita-foto' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies'         => array( 'post_tag' ),
    );

    register_post_type( 'berita_foto', $args );
}
add_action( 'init', 'haliyora_register_berita_foto_cpt' );

/**
 * Register Berita Foto Categories Taxonomy
 */
function haliyora_register_berita_foto_categories() {
    $labels = array(
        'name'              => _x( 'Kategori Foto', 'taxonomy general name', 'haliyora' ),
        'singular_name'     => _x( 'Kategori Foto', 'taxonomy singular name', 'haliyora' ),
        'search_items'      => __( 'Cari Kategori Foto', 'haliyora' ),
        'all_items'         => __( 'Semua Kategori Foto', 'haliyora' ),
        'parent_item'       => __( 'Induk Kategori Foto', 'haliyora' ),
        'parent_item_colon' => __( 'Induk Kategori Foto:', 'haliyora' ),
        'edit_item'         => __( 'Edit Kategori Foto', 'haliyora' ),
        'update_item'       => __( 'Update Kategori Foto', 'haliyora' ),
        'add_new_item'      => __( 'Tambah Kategori Foto Baru', 'haliyora' ),
        'new_item_name'     => __( 'Nama Kategori Foto Baru', 'haliyora' ),
        'menu_name'         => __( 'Kategori Foto', 'haliyora' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'kategori-foto' ),
    );

    register_taxonomy( 'kategori_foto', array( 'berita_foto' ), $args );
}
add_action( 'init', 'haliyora_register_berita_foto_categories', 0 );

/**
 * Add custom fields for video stories
 */
function haliyora_add_video_story_meta_boxes() {
    add_meta_box(
        'video-story-meta-box',
        'Video Content',
        'haliyora_video_story_meta_box_callback',
        'video_story',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'haliyora_add_video_story_meta_boxes' );

/**
 * Meta box callback function
 */
function haliyora_video_story_meta_box_callback( $post ) {
    wp_nonce_field( 'haliyora_save_video_story_meta', 'haliyora_video_story_meta_nonce' );

    $video_type = get_post_meta( $post->ID, '_video_type', true );
    $youtube_shorts_url = get_post_meta( $post->ID, '_youtube_shorts_url', true );
    $tiktok_embed_url = get_post_meta( $post->ID, '_tiktok_embed_url', true );
    $video_duration = get_post_meta( $post->ID, '_video_duration', true );
    $video_source = get_post_meta( $post->ID, '_video_source', true );
    
    // ... (rest of the meta box content would go here)
}

/**
 * Save video story meta
 */
function haliyora_save_video_story_meta( $post_id ) {
    if ( ! isset( $_POST['haliyora_video_story_meta_nonce'] ) || ! wp_verify_nonce( $_POST['haliyora_video_story_meta_nonce'], 'haliyora_save_video_story_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['_video_type'] ) ) {
        update_post_meta( $post_id, '_video_type', sanitize_text_field( $_POST['_video_type'] ) );
    }
    
    if ( isset( $_POST['_youtube_shorts_url'] ) ) {
        update_post_meta( $post_id, '_youtube_shorts_url', esc_url_raw( $_POST['_youtube_shorts_url'] ) );
    }
    
    if ( isset( $_POST['_tiktok_embed_url'] ) ) {
        update_post_meta( $post_id, '_tiktok_embed_url', esc_url_raw( $_POST['_tiktok_embed_url'] ) );
    }
    
    if ( isset( $_POST['_video_duration'] ) ) {
        update_post_meta( $post_id, '_video_duration', sanitize_text_field( $_POST['_video_duration'] ) );
    }
    
    if ( isset( $_POST['_video_source'] ) ) {
        update_post_meta( $post_id, '_video_source', sanitize_text_field( $_POST['_video_source'] ) );
    }
}
add_action( 'save_post', 'haliyora_save_video_story_meta' );

/**
 * Add admin frontend menu functionality
 */




// Include admin frontend menu
require_once get_template_directory() . '/inc/admin-frontend-menu.php';

// Include custom widgets
require_once get_template_directory() . '/inc/widgets/class-trending-widget.php';

// Register custom query vars
function haliyora_add_custom_query_vars($vars) {
    $vars[] = 'admin_frontend_page';
    $vars[] = 'f_action';
    $vars[] = 'f_post_id';
    return $vars;
}
add_filter('query_vars', 'haliyora_add_custom_query_vars');

// Handle admin frontend page
function haliyora_handle_admin_frontend_page() {
    $admin_frontend_page = get_query_var('admin_frontend_page');
    $action = get_query_var('f_action');
    
    if ($admin_frontend_page == '1') {
        // Cek izin: Hanya Administrator dan Editor yang bisa akses
        if (!is_user_logged_in() || !current_user_can('edit_others_posts')) {
            wp_die('Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        // Load the admin frontend page
        include_once get_template_directory() . '/admin-frontend.php';
        exit;
    }
}
add_action('template_redirect', 'haliyora_handle_admin_frontend_page');

/**
 * Redirect to admin frontend after login
 */
function haliyora_custom_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        // Check if user is administrator or editor
        if (in_array('administrator', $user->roles) || in_array('editor', $user->roles)) {
            return home_url('/?admin_frontend_page=1');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'haliyora_custom_login_redirect', 10, 3);

/**
 * Custom Login Page Design - Modern Split Layout with Material Design
 */


/**
 * Change login logo URL to home
 */
function haliyora_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'haliyora_login_logo_url');

/**
 * Change login logo title
 */
function haliyora_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'haliyora_login_logo_url_title');

// Handle admin frontend form submission
function haliyora_handle_admin_frontend_submit() {
    // Auto-login admin user for testing
    if (!is_user_logged_in()) {
        $admin_user = get_user_by('login', 'admin');
        if ($admin_user) {
            wp_set_current_user($admin_user->ID);
            wp_set_auth_cookie($admin_user->ID);
        }
    }
    
    // Verify it's a valid form submission
    if (!isset($_POST['admin_frontend_submit']) || $_POST['admin_frontend_submit'] !== '1') {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['_wpnonce'], 'save_post_' . intval($_POST['post_id']))) {
        wp_die('Security check failed');
    }
    
    // Check permissions
    if (!current_user_can('edit_others_posts')) {
        wp_die('Anda tidak memiliki izin untuk menyunting berita');
    }
    
    // Process the form data
    $post_id = intval($_POST['post_id']);
    $post_title = sanitize_text_field($_POST['post_title']);
    $post_content = wp_kses_post($_POST['post_content']);
    $post_status = sanitize_key($_POST['post_status']);
    $post_date = sanitize_text_field($_POST['post_date']);
    $post_category = isset($_POST['post_category']) ? array_map('intval', $_POST['post_category']) : array();
    $post_tags = sanitize_text_field($_POST['post_tags']);
    
    // Handle featured image upload
    $featured_image_id = 0;
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $upload_overrides = array('test_form' => false);
        $featured_image_id = media_handle_upload('featured_image', $post_id);
        
        if (is_wp_error($featured_image_id)) {
            // If there was an error, log it but don't stop the process
            error_log('Error uploading featured image: ' . $featured_image_id->get_error_message());
        }
    }
    
    $post_data = array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => $post_status,
        'post_date' => $post_date,
        'post_type' => 'post'
    );
    
    if ($post_id > 0) {
        $post_data['ID'] = $post_id;
        $result = wp_update_post($post_data);
    } else {
        $result = wp_insert_post($post_data);
    }
    
    if (!is_wp_error($result)) {
        // Update categories
        if (!empty($post_category)) {
            wp_set_post_categories($result, $post_category);
        }
        
        // Update tags
        if (!empty($post_tags)) {
            $tags = explode(',', $post_tags);
            $tags = array_map('trim', $tags);
            wp_set_post_tags($result, $tags);
        }
        
        // Set featured image if uploaded
        if ($featured_image_id && !is_wp_error($featured_image_id)) {
            set_post_thumbnail($result, $featured_image_id);
        }
        
        // Redirect back to admin frontend
        wp_redirect(home_url('/?admin_frontend_page=1'));
        exit;
    } else {
        wp_die('Error saving post: ' . $result->get_error_message());
    }
}
add_action('admin_post_save_post', 'haliyora_handle_admin_frontend_submit');

/**
 * Video Stories Shortcode
 */
function haliyora_video_stories_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 6,
        'category' => ''
    ), $atts);

    ob_start();

    $args = array(
        'post_type' => 'video_story',
        'posts_per_page' => intval($atts['limit']),
        'post_status' => 'publish'
    );

    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'video_story_category',
                'field'    => 'slug',
                'terms'    => $atts['category'],
            ),
        );
    }

    $video_stories_query = new WP_Query($args);

    if ($video_stories_query->have_posts()) {
        echo '<div class="video-stories-grid">';
        while ($video_stories_query->have_posts()) {
            $video_stories_query->the_post();
            $video_type = get_post_meta(get_the_ID(), '_video_type', true);
            $youtube_url = get_post_meta(get_the_ID(), '_youtube_shorts_url', true);
            $tiktok_url = get_post_meta(get_the_ID(), '_tiktok_embed_url', true);
            $duration = get_post_meta(get_the_ID(), '_video_duration', true);
            $source = get_post_meta(get_the_ID(), '_video_source', true);
            
            echo '<div class="video-story-item">';
            echo '<div class="video-thumbnail">';
            if (has_post_thumbnail()) {
                the_post_thumbnail('medium');
            } else {
                echo '<img src="https://placehold.co/300x200?text=Video+Story" alt="' . get_the_title() . '">';
            }
            echo '<div class="video-duration">' . esc_html($duration) . '</div>';
            echo '</div>';
            echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No video stories found.</p>';
    }
    
    return ob_get_clean();
}
add_shortcode('video_stories', 'haliyora_video_stories_shortcode');

/**
 * Format video duration for display
 */
function haliyora_format_video_duration( $duration ) {
	if ( ! $duration ) {
		return '';
	}
	
	// Convert seconds to MM:SS format
	$minutes = floor( $duration / 60 );
	$seconds = $duration % 60;
	
	return sprintf( '%02d:%02d', $minutes, $seconds );
}

/**
 * Custom Login Page Design - Ultra Modern Split Layout Material Design
 */
function haliyora_custom_login_styles() {
    $logo_url = has_custom_logo() ? wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0] : '';
    // Journalism image from Unsplash (reliable source for high-quality journalism theme)
    $bg_image = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop';
    ?>
    <style type="text/css">
        :root {
            --md-primary: #d32f2f;
            --md-primary-dark: #b71c1c;
            --md-surface: #ffffff;
            --md-text-primary: #1e293b;
            --md-text-secondary: #64748b;
            --md-radius: 16px;
            --md-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        body.login {
            background-color: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            height: 100vh !important;
            display: flex !important;
            align-items: stretch !important;
            justify-content: stretch !important;
            overflow: hidden !important;
            font-family: 'Inter', -apple-system, system-ui, sans-serif !important;
        }

        #login {
            width: 100% !important;
            height: 100vh !important;
            max-width: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
        }

        /* Hide WP default elements */
        .login h1, .login #nav, .login #backtoblog, .language-switcher {
            display: none !important;
        }

        /* Main Container for the entire layout */
        .login-split-container {
            display: flex;
            width: 100%;
            height: 100vh;
            align-items: stretch;
        }

        /* Left Side: Image Content */
        .login-split-left {
            flex: 1.4;
            background: linear-gradient(rgba(0,0,0,0.1), rgba(211,47,47,0.85)), url('<?php echo $bg_image; ?>');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 80px;
            color: #ffffff;
        }

        .login-left-content {
            position: relative;
            z-index: 10;
            max-width: 600px;
        }

        .login-left-content h2 {
            font-size: 42px;
            font-weight: 800;
            margin: 0 0 16px 0;
            line-height: 1.1;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .login-left-content p {
            font-size: 20px;
            font-weight: 500;
            opacity: 0.95;
            margin: 0;
            line-height: 1.5;
        }

        /* Right Side: Form Content */
        .login-split-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 60px;
            overflow-y: auto;
        }

        .login-right-wrapper {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
        }

        #loginform {
            width: 100%;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .login-right-header {
            margin-bottom: 40px;
            text-align: left;
        }

        .login-logo-custom {
            height: 54px;
            width: auto;
            margin-bottom: 24px;
            display: block;
        }

        .login-right-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 8px 0;
            letter-spacing: -0.02em;
        }

        .login-right-header p {
            font-size: 16px;
            color: var(--md-text-secondary);
            margin: 0;
        }

        /* Form Controls with Precision */
        .login label {
            display: block !important;
            margin-bottom: 10px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #334155 !important;
        }

        .login input[type=text], .login input[type=password] {
            width: 100% !important;
            height: 54px !important;
            background: #f1f5f9 !important;
            border: 2px solid #f1f5f9 !important;
            border-radius: 12px !important;
            padding: 0 18px !important;
            font-size: 16px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            margin-bottom: 24px !important;
            box-shadow: none !important;
            color: #0f172a !important;
        }

        .login input:focus {
            background: #ffffff !important;
            border-color: var(--md-primary) !important;
            box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1) !important;
            outline: none !important;
        }

        .wp-core-ui .button-primary {
            width: 100% !important;
            height: 56px !important;
            background: var(--md-primary) !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 6px -1px rgba(211, 47, 47, 0.2), 0 2px 4px -2px rgba(211, 47, 47, 0.1) !important;
            text-shadow: none !important;
            margin-top: 8px !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .wp-core-ui .button-primary:hover {
            background: var(--md-primary-dark) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 15px -3px rgba(211, 47, 47, 0.3) !important;
        }

        /* Checkbox Styling */
        .forgetmenot {
            margin-bottom: 24px !important;
            float: none !important;
        }

        #rememberme {
            border-radius: 4px !important;
            border: 2px solid #cbd5e1 !important;
            width: 18px !important;
            height: 18px !important;
            margin-top: -2px !important;
        }

        /* Footer Links with Precision */
        .login-footer-links {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 24px;
        }

        .login-footer-links a {
            color: #64748b !important;
            text-decoration: none !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .login-footer-links a:hover {
            color: var(--md-primary) !important;
        }

        /* Mobile Version - Perfect Precision */
        @media (max-width: 1024px) {
            .login-split-left {
                display: none;
            }
            .login-split-right {
                padding: 40px 24px;
                background-color: #f8fafc;
            }
            body.login {
                background-color: #f8fafc !important;
                overflow-y: auto !important;
            }
            .login-right-wrapper {
                background: #ffffff;
                padding: 40px 32px;
                border-radius: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            }
            .login-right-header {
                text-align: center;
            }
            .login-logo-custom {
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* Error message styles */
        .login #login_error, .login .message, .login .success {
            border-radius: 12px !important;
            border-left: 4px solid var(--md-primary) !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05) !important;
            margin-bottom: 24px !important;
            padding: 16px !important;
            background: #fff !important;
            font-size: 14px !important;
        }
    </style>
    
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const login = document.getElementById('login');
            const form = document.getElementById('loginform');
            
            // Container for split layout
            const container = document.createElement('div');
            container.className = 'login-split-container';
            
            // Left Side
            const leftSide = document.createElement('div');
            leftSide.className = 'login-split-left';
            leftSide.innerHTML = `
                <div class="login-left-content">
                    <h2>Editor untuk Pewarta</h2>
                    <p>Optimasi berita lebih cepat dan efisien.</p>
                </div>
            `;
            
            // Right Side
            const rightSide = document.createElement('div');
            rightSide.className = 'login-split-right';
            
            const rightWrapper = document.createElement('div');
            rightWrapper.className = 'login-right-wrapper';
            
            // Header for form
            const rightHeader = document.createElement('div');
            rightHeader.className = 'login-right-header';
            rightHeader.innerHTML = `
                <?php if ($logo_url): ?>
                    <img src="<?php echo $logo_url; ?>" class="login-logo-custom" alt="Logo">
                <?php endif; ?>
                <h2>Masuk Akun</h2>
                <p>Silakan masukkan kredensial Anda</p>
            `;
            
            // Footer links
            const footerLinks = document.createElement('div');
            footerLinks.className = 'login-footer-links';
            footerLinks.innerHTML = `
                <a href="<?php echo wp_lostpassword_url(); ?>">Lupa Password?</a>
                <a href="<?php echo home_url(); ?>">Beranda &rarr;</a>
            `;
            
            // Build the structure
            rightWrapper.appendChild(rightHeader);
            rightWrapper.appendChild(form);
            rightWrapper.appendChild(footerLinks);
            rightSide.appendChild(rightWrapper);
            
            container.appendChild(leftSide);
            container.appendChild(rightSide);
            
            // Swap content precisely
            login.innerHTML = '';
            login.appendChild(container);
        });
    </script>
    <?php
}
add_action('login_enqueue_scripts', 'haliyora_custom_login_styles');

/**
 * Modernize WP-Admin for Mobile and Desktop
 */
function haliyora_modern_admin_styles() {
    ?>
    <style type="text/css">
        /* Global Admin Modernization */
        :root {
            --admin-primary: #d32f2f;
            --admin-bg: #f8fafc;
        }
        
        #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
            background-color: #1e293b !important;
        }
        
        #adminmenu .wp-has-current-submenu .wp-submenu, 
        #adminmenu .wp-has-current-submenu.opensub .wp-submenu, 
        #adminmenu .wp-submenu, 
        #adminmenu a.wp-has-current-submenu:focus + .wp-submenu {
            background-color: #0f172a !important;
        }

        #adminmenu li.current a.menu-top, 
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
            background: var(--admin-primary) !important;
            border-radius: 8px !important;
            margin: 4px 8px !important;
            width: auto !important;
        }

        #adminmenu li.menu-top {
            margin: 2px 0 !important;
        }

        #adminmenu a.menu-top {
            border-radius: 8px !important;
            margin: 0 8px !important;
            width: auto !important;
            transition: all 0.2s ease !important;
        }

        #adminmenu .wp-submenu {
            border-radius: 0 0 8px 8px !important;
            margin-left: 8px !important;
            margin-right: 8px !important;
        }

        /* Colored Admin Icons */
        #adminmenu div.wp-menu-image:before {
            color: #94a3b8 !important;
            opacity: 0.85;
            transition: all 0.2s ease;
        }

        #adminmenu li.menu-top:hover div.wp-menu-image:before,
        #adminmenu li.current div.wp-menu-image:before,
        #adminmenu li.wp-has-current-submenu div.wp-menu-image:before {
            opacity: 1;
            transform: scale(1.1);
        }

        #menu-dashboard div.wp-menu-image:before { color: #60a5fa !important; } /* Blue */
        #menu-posts div.wp-menu-image:before { color: #f87171 !important; } /* Red */
        #menu-media div.wp-menu-image:before { color: #2dd4bf !important; } /* Teal */
        #menu-pages div.wp-menu-image:before { color: #34d399 !important; } /* Green */
        #menu-comments div.wp-menu-image:before { color: #fbbf24 !important; } /* Amber */
        #menu-posts-video_story div.wp-menu-image:before { color: #f472b6 !important; } /* Pink */
        #menu-posts-berita_foto div.wp-menu-image:before { color: #a78bfa !important; } /* Purple */
        #menu-appearance div.wp-menu-image:before { color: #fb923c !important; } /* Orange */
        #menu-plugins div.wp-menu-image:before { color: #c084fc !important; } /* Violet */
        #menu-users div.wp-menu-image:before { color: #f43f5e !important; } /* Rose */
        #menu-tools div.wp-menu-image:before { color: #94a3b8 !important; } /* Slate */
        #menu-settings div.wp-menu-image:before { color: #818cf8 !important; } /* Indigo */
        #toplevel_page_edit-php-post_type-video_story div.wp-menu-image:before { color: #f472b6 !important; }
        #toplevel_page_edit-php-post_type-berita_foto div.wp-menu-image:before { color: #a78bfa !important; }

        /* Mobile Optimization */
        @media screen and (max-width: 782px) {
            #wpadminbar {
                background: #ffffff !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
                height: 56px !important;
            }
            
            #wpadminbar .ab-item, #wpadminbar a.ab-item, #wpadminbar > #wp-toolbar span.ab-label, #wpadminbar > #wp-toolbar span.noticon {
                color: #334155 !important;
            }

            #wpadminbar #wp-admin-bar-menu-toggle .ab-icon:before {
                color: var(--admin-primary) !important;
                content: "\f333" !important;
                top: 6px !important;
                font-size: 24px !important;
            }

            #wpbody-content {
                padding: 20px 15px !important;
            }

            .wrap h1 {
                font-size: 26px !important;
                font-weight: 800 !important;
                letter-spacing: -0.02em !important;
                color: #0f172a !important;
                margin-bottom: 24px !important;
            }

            /* Card Style for Widgets and Posts */
            .postbox, .card {
                border-radius: 16px !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
                margin-bottom: 20px !important;
            }

            .postbox .handle-h3, .postbox h2 {
                font-size: 16px !important;
                font-weight: 700 !important;
                padding: 16px !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }

            /* Modern Buttons */
            .wp-core-ui .button, .wp-core-ui .button-secondary {
                border-radius: 10px !important;
                padding: 6px 16px !important;
                height: auto !important;
                font-weight: 600 !important;
                border-color: #cbd5e1 !important;
                background: #ffffff !important;
                color: #334155 !important;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
            }

            .wp-core-ui .button-primary {
                background: var(--admin-primary) !important;
                border-color: var(--admin-primary) !important;
                border-radius: 10px !important;
                padding: 8px 20px !important;
                height: auto !important;
                font-weight: 700 !important;
                text-shadow: none !important;
                box-shadow: 0 4px 6px -1px rgba(211, 47, 47, 0.2) !important;
            }

            /* Inputs */
            input[type=text], input[type=search], input[type=radio], input[type=checkbox], select, textarea {
                border-radius: 8px !important;
                border: 1px solid #cbd5e1 !important;
                padding: 8px 12px !important;
            }

            input:focus, textarea:focus {
                border-color: var(--admin-primary) !important;
                box-shadow: 0 0 0 2px rgba(211, 47, 47, 0.1) !important;
            }
        }
    </style>
    <?php
}
add_action('admin_head', 'haliyora_modern_admin_styles');

/**
 * Fetch and Parse BMKG Weather Data for East Java
 */
/**
 * Fetch and Parse BMKG Weather Data for East Java
 */
function haliyora_get_bmkg_weather_jatim() {
    $transient_key = 'haliyora_bmkg_weather_jatim';
    $lock_key = 'haliyora_bmkg_weather_lock';
    
    $cached_data = get_transient($transient_key);
    if ($cached_data !== false) {
        return $cached_data;
    }

    // Prevent dog-pile effect: if another process is already fetching, return empty or stale
    if (get_transient($lock_key)) {
        return array();
    }

    // Set a short lock (30 seconds)
    set_transient($lock_key, '1', 30);

    $url = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaTimur.xml';
    // Reduced timeout to 5 seconds to prevent hanging PHP workers
    $response = wp_remote_get($url, array('timeout' => 5));

    if (is_wp_error($response)) {
        delete_transient($lock_key);
        return array('error' => 'Timeout or Connection Error');
    }

    $xml_string = wp_remote_retrieve_body($response);
    if (empty($xml_string)) {
        delete_transient($lock_key);
        return array('error' => 'Empty response');
    }

    // Parse XML
    libxml_use_internal_errors(true);
    $xml = @simplexml_load_string($xml_string);
    if ($xml === false) {
        delete_transient($lock_key);
        return array('error' => 'XML Parse Error');
    }

    $weather_data = array();
    
    // Check if forecast data exists
    if (!isset($xml->forecast->area)) {
        delete_transient($lock_key);
        return array();
    }

    foreach ($xml->forecast->area as $area) {
        $names = $area->name;
        $city_name = '';
        foreach ($names as $name) {
            if ((string)$name->attributes('xml', true)->lang === 'id_ID') {
                $city_name = (string)$name;
                break;
            }
        }
        if (empty($city_name)) {
            $city_name = (string) $area->name[0];
        }

        $clean_city_name = str_replace(array('Kab. ', 'Kota '), '', $city_name);
        $clean_city_name = trim($clean_city_name);

        $city_weather = array(
            'city' => $clean_city_name,
            'temp' => 'N/A',
            'code' => '0',
            'description' => 'Cerah'
        );

        foreach ($area->parameter as $param) {
            $param_id = (string) $param->attributes()->id;
            
            if ($param_id === 't' || $param_id === 'weather') {
                $closest_val = null;
                $min_diff = PHP_INT_MAX;
                $now = time();

                foreach ($param->timerange as $tr) {
                    $dt = (string) $tr->attributes()->datetime;
                    $ts = strtotime(substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2) . ' ' . substr($dt, 8, 2) . ':' . substr($dt, 10, 2) . ' UTC');
                    $diff = abs($ts - $now);
                    
                    if ($diff < $min_diff) {
                        $min_diff = $diff;
                        $closest_val = (string) $tr->value;
                    }
                }

                if ($param_id === 't') $city_weather['temp'] = $closest_val;
                if ($param_id === 'weather') {
                    $city_weather['code'] = $closest_val;
                    $city_weather['description'] = haliyora_map_bmkg_code($closest_val);
                }
            }
        }

        $weather_data[strtolower($clean_city_name)] = $city_weather;
        $weather_data[strtolower($city_name)] = $city_weather;
    }

    // Cache for 2 hours to reduce server load
    set_transient($transient_key, $weather_data, 2 * HOUR_IN_SECONDS);
    delete_transient($lock_key);
    
    return $weather_data;
}

/**
 * Map BMKG Weather Codes to Human Readable Description
 */
function haliyora_map_bmkg_code($code) {
    $codes = array(
        '0' => 'Cerah',
        '1' => 'Cerah Berawan',
        '2' => 'Cerah Berawan',
        '3' => 'Berawan',
        '4' => 'Berawan Tebal',
        '5' => 'Udara Kabur',
        '10' => 'Asap',
        '45' => 'Kabut',
        '60' => 'Hujan Ringan',
        '61' => 'Hujan Sedang',
        '63' => 'Hujan Lebat',
        '80' => 'Hujan Lokal',
        '95' => 'Hujan Petir',
        '97' => 'Hujan Petir'
    );
    return isset($codes[$code]) ? $codes[$code] : 'Cerah';
}

/**
 * Automatically convert all uploaded images to WebP format
 * This affects both the original file and all generated thumbnails
 */

// 1. Force WebP for all processed images (thumbnails)
add_filter('image_editor_output_format', function($formats) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
});

// 2. Set WebP quality
add_filter('wp_editor_set_quality', function($quality, $mime_type) {
    if ('image/webp' === $mime_type) {
        return 82; // Balance between quality and file size
    }
    return $quality;
}, 10, 2);

// 3. Convert original upload to WebP
add_filter('wp_handle_upload', function($upload) {
    // Only process JPEG and PNG
    if ($upload['type'] == 'image/jpeg' || $upload['type'] == 'image/png') {
        $file_path = $upload['file'];
        
        // Check if image editor is available
        $image = wp_get_image_editor($file_path);
        
        if (!is_wp_error($image)) {
            $file_info = pathinfo($file_path);
            $new_file_path = $file_info['dirname'] . '/' . $file_info['filename'] . '.webp';
            
            // Save as WebP
            $saved = $image->save($new_file_path, 'image/webp');
            
            if (!is_wp_error($saved)) {
                // Delete original file
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                
                // Update upload data for WordPress database
                $upload['file'] = $new_file_path;
                $upload['url']  = str_replace($file_info['basename'], $file_info['filename'] . '.webp', $upload['url']);
                $upload['type'] = 'image/webp';
            }
        }
    }
    return $upload;
});

/**
 * Automatically handle existing images: Convert to WebP on-demand
 * and serve them across the site.
 */

// Helper to check/convert and return WebP URL
function haliyora_get_webp_url($url) {
    if (empty($url)) return $url;
    
    // Skip if already webp or not in uploads folder
    if (strpos($url, '.webp') !== false || strpos($url, 'wp-content/uploads') === false) {
        return $url;
    }
    
    // Calculate paths
    $upload_dir = wp_upload_dir();
    $base_url = $upload_dir['baseurl'];
    $base_dir = $upload_dir['basedir'];
    
    $relative_path = str_replace($base_url, '', $url);
    $file_path = $base_dir . $relative_path;
    
    // Check if original exists
    if (!file_exists($file_path)) return $url;
    
    $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);
    $webp_url = preg_replace('/\.(jpe?g|png)$/i', '.webp', $url);
    
    // If WebP version already exists, just return its URL
    if (file_exists($webp_path)) {
        return $webp_url;
    }
    
    // If WebP doesn't exist, generate it on-the-fly
    $editor = wp_get_image_editor($file_path);
    if (!is_wp_error($editor)) {
        $editor->set_quality(82);
        $saved = $editor->save($webp_path, 'image/webp');
        if (!is_wp_error($saved)) {
            return $webp_url;
        }
    }
    
    return $url;
}

// 1. Filter attachment URLs (for manual functions)
add_filter('wp_get_attachment_url', 'haliyora_get_webp_url');

// 2. Filter image sources (for standard WP functions like the_post_thumbnail)
add_filter('wp_get_attachment_image_src', function($image, $attachment_id, $size, $icon) {
    if ($image && isset($image[0])) {
        $image[0] = haliyora_get_webp_url($image[0]);
    }
    return $image;
}, 10, 4);

// 3. Filter Responsive Images (srcset)
add_filter('wp_calculate_image_srcset', function($sources) {
    if (is_array($sources)) {
        foreach ($sources as &$source) {
            $source['url'] = haliyora_get_webp_url($source['url']);
        }
    }
    return $sources;
});

// 4. Filter Images in Post Content
add_filter('the_content', function($content) {
    if (empty($content)) return $content;
    
    // Find all JPG/PNG images in uploads and replace with WebP
    return preg_replace_callback('/(https?:\/\/[^\s"\']+\.(?:jpe?g|png))/i', function($matches) {
        // Only process if it belongs to this site's uploads
        if (strpos($matches[1], 'wp-content/uploads') !== false) {
            return haliyora_get_webp_url($matches[1]);
        }
        return $matches[1];
    }, $content);
});

/**
 * GitHub Theme Update Checker
 */
add_action('wp_ajax_haliyora_check_github_update', function() {
    // GitHub API URL for the latest release
    $repo_url = 'https://api.github.com/repos/mgunturbudiawan-oss/kempalan/releases/latest';
    
    $args = array(
        'timeout'    => 10,
        'user-agent' => 'WordPress/Haliyora-Theme',
        'headers'    => array(
            'Accept' => 'application/vnd.github.v3+json',
        ),
    );

    $response = wp_remote_get($repo_url, $args);

    if (is_wp_error($response)) {
        wp_send_json_error('Gagal menghubungi GitHub: ' . $response->get_error_message());
    }

    $status_code = wp_remote_retrieve_response_code($response);
    if ($status_code !== 200) {
        wp_send_json_error('GitHub API error (Code: ' . $status_code . ')');
    }

    $data = json_decode(wp_remote_retrieve_body($response));
    
    if (empty($data->tag_name)) {
        wp_send_json_error('Tidak ada release ditemukan di repositori GitHub.');
    }

    // Sanitize version (remove 'v' prefix)
    $latest_version = ltrim($data->tag_name, 'vV');
    $download_url = $data->zipball_url;
    $release_notes = $data->body;

    wp_send_json_success(array(
        'latest'  => $latest_version,
        'url'     => $download_url,
        'notes'   => wp_trim_words($release_notes, 20, '...'),
        'html_url' => $data->html_url
    ));
});

/**
 * Integration with WordPress Native Theme Update System
 */
add_filter('pre_set_site_transient_update_themes', function($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    $theme_slug = 'haliyora';
    $repo_url = 'https://api.github.com/repos/mgunturbudiawan-oss/kempalan/releases/latest';
    
    // Use cache to avoid hitting GitHub API on every page load
    $cache_key = 'haliyora_github_update_check';
    $remote = get_transient($cache_key);

    if (false === $remote) {
        $args = array(
            'timeout'    => 10,
            'user-agent' => 'WordPress/Haliyora-Theme',
            'headers'    => array(
                'Accept' => 'application/vnd.github.v3+json',
            ),
        );

        $response = wp_remote_get($repo_url, $args);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return $transient;
        }

        $remote = json_decode(wp_remote_retrieve_body($response));
        set_transient($cache_key, $remote, 12 * HOUR_IN_SECONDS);
    }

    if ($remote && !empty($remote->tag_name)) {
        $latest_version = ltrim($remote->tag_name, 'vV');
        $theme = wp_get_theme($theme_slug);
        
        if (version_compare($theme->get('Version'), $latest_version, '<')) {
            $res = array(
                'theme'       => $theme_slug,
                'new_version' => $latest_version,
                'url'         => $remote->html_url,
                'package'     => $remote->zipball_url,
            );
            $transient->response[$theme_slug] = $res;
        }
    }

    return $transient;
});

