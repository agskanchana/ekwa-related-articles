<?php
/**
 * Plugin Name: EKWA Related Articles
 * Plugin URI: https://ekwa.com
 * Description: Custom blog templates with multiple designs for single posts, blog roll, and archives. Includes configurable sidebar position and prev/next navigation.
 * Version: 1.0.4
 * Author: EKWA
 * Author URI: https://ekwa.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: ekwa-related-articles
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require 'includes/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/agskanchana/ekwa-related-articles/',
	__FILE__,
	'ekwa-related-articles'
);

// Define plugin constants
define('EKWA_RELATED_ARTICLES_VERSION', '1.0.4');
define('EKWA_RELATED_ARTICLES_PATH', plugin_dir_path(__FILE__));
define('EKWA_RELATED_ARTICLES_URL', plugin_dir_url(__FILE__));

class EKWA_Related_Articles {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        // Template override filters
        add_filter('template_include', array($this, 'override_templates'), 99);

        // Modify posts per page for blog
        add_action('pre_get_posts', array($this, 'modify_posts_per_page'));

        // Enqueue styles and scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        // Admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));

        // Register widget areas
        add_action('widgets_init', array($this, 'register_widget_areas'));

        // Register shortcode
        add_shortcode('ekwa_related_articles', array($this, 'related_articles_shortcode'));

        // AJAX handlers for pagination
        add_action('wp_ajax_ekwa_load_posts', array($this, 'ajax_load_posts'));
        add_action('wp_ajax_nopriv_ekwa_load_posts', array($this, 'ajax_load_posts'));
    }

    /**
     * Override theme templates
     */
    public function override_templates($template) {
        // Check if plugin templates are enabled
        $enable_override = get_option('ekwa_blog_enable_templates', '1');

        if ($enable_override !== '1') {
            return $template;
        }

        // Single post template - ONLY for blog posts
        if (is_single() && get_post_type() === 'post') {
            // First check if theme has override in article-templates folder
            $theme_override = get_stylesheet_directory() . '/article-templates/single.php';
            if (file_exists($theme_override)) {
                return $theme_override;
            }

            // Fall back to plugin template
            $plugin_template = EKWA_RELATED_ARTICLES_PATH . 'templates/single.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        // Blog index template - ONLY for blog posts page, NOT for static front page
        if (is_home() && !is_front_page()) {
            // First check if theme has override in article-templates folder
            $theme_override = get_stylesheet_directory() . '/article-templates/index.php';
            if (file_exists($theme_override)) {
                return $theme_override;
            }

            // Fall back to plugin template
            $plugin_template = EKWA_RELATED_ARTICLES_PATH . 'templates/index.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        // Archive templates - ONLY for post archives (categories, tags, dates)
        if (is_archive() && get_post_type() === 'post') {
            // First check if theme has override in article-templates folder
            $theme_override = get_stylesheet_directory() . '/article-templates/archive.php';
            if (file_exists($theme_override)) {
                return $theme_override;
            }

            // Fall back to plugin template
            $plugin_template = EKWA_RELATED_ARTICLES_PATH . 'templates/archive.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        return $template;
    }

    /**
     * Modify posts per page for blog posts
     */
    public function modify_posts_per_page($query) {
        // Only modify main query on blog pages, not admin
        if (is_admin() || !$query->is_main_query()) {
            return;
        }

        // Set 9 posts per page for blog index and archives
        if ($query->is_home() || ($query->is_archive() && $query->get('post_type') === 'post')) {
            $query->set('posts_per_page', 9);
        }
    }

    /**
     * Enqueue styles and scripts
     */
    public function enqueue_scripts() {
        // Only enqueue CSS for blog post templates
        if (
            (is_single() && get_post_type() === 'post') ||
            (is_home() && !is_front_page()) ||
            (is_archive() && get_post_type() === 'post')
        ) {
            // Enqueue base styles
            wp_enqueue_style(
                'ekwa-related-articles',
                EKWA_RELATED_ARTICLES_URL . 'assets/css/style.css',
                array(),
                EKWA_RELATED_ARTICLES_VERSION
            );

            // Get selected design
            $template_design = get_option('ekwa_blog_template_design', 'design1');

            // Enqueue design-specific stylesheet
            $design_files = array(
                'design1' => 'design-classic.css',
                'design2' => 'design-modern.css',
                'design3' => 'design-minimal.css'
            );

            if (isset($design_files[$template_design])) {
                wp_enqueue_style(
                    'ekwa-related-articles-' . $template_design,
                    EKWA_RELATED_ARTICLES_URL . 'assets/css/' . $design_files[$template_design],
                    array('ekwa-related-articles'),
                    EKWA_RELATED_ARTICLES_VERSION
                );
            }
        }
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'EKWA Related Articles Settings',
            'EKWA Related Articles',
            'manage_options',
            'ekwa-related-articles',
            array($this, 'settings_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('ekwa_blog_templates_settings', 'ekwa_blog_enable_templates');
        register_setting('ekwa_blog_templates_settings', 'ekwa_blog_sidebar_position');
        register_setting('ekwa_blog_templates_settings', 'ekwa_blog_template_design');
        register_setting('ekwa_blog_templates_settings', 'ekwa_blog_show_recent_posts');
        register_setting('ekwa_blog_templates_settings', 'ekwa_blog_show_categories');
        register_setting('ekwa_blog_templates_settings', 'ekwa_blog_recent_posts_count');

        // Carousel settings
        register_setting('ekwa_blog_templates_settings', 'ekwa_carousel_desktop_items');
        register_setting('ekwa_blog_templates_settings', 'ekwa_carousel_tablet_items');
        register_setting('ekwa_blog_templates_settings', 'ekwa_carousel_mobile_items');
        register_setting('ekwa_blog_templates_settings', 'ekwa_carousel_enable_arrows');
        register_setting('ekwa_blog_templates_settings', 'ekwa_carousel_enable_dots');
        register_setting('ekwa_blog_templates_settings', 'ekwa_carousel_enable_lazyload');
    }

    /**
     * Settings page callback
     */
    public function settings_page() {
        include EKWA_RELATED_ARTICLES_PATH . 'admin/settings-page.php';
    }

    /**
     * Register widget areas
     */
    public function register_widget_areas() {
        register_sidebar(array(
            'name'          => __('EKWA Related Articles Sidebar', 'ekwa-related-articles'),
            'id'            => 'ekwa-blog-sidebar',
            'description'   => __('Sidebar for related articles templates', 'ekwa-related-articles'),
            'before_widget' => '<div class="ekwa-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="ekwa-widget-title">',
            'after_title'   => '</h3>',
        ));
    }

    /**
     * Related Articles Shortcode
     */
    public function related_articles_shortcode($atts) {
        // Extract shortcode attributes
        $atts = shortcode_atts(
            array(
                'lazyload' => 'off',
            ),
            $atts,
            'ekwa_related_articles'
        );

        // Get the current page slug
        global $post;

        if (is_front_page()) {
            // For home page, try 'featured' or 'featured-articles'
            $slug = 'featured';

            // Check if there are posts with 'featured' category
            $test_query = new WP_Query(array(
                'category_name' => 'featured',
                'posts_per_page' => 1,
                'post_status' => 'publish',
            ));

            // If no posts found with 'featured', try 'featured-articles'
            if (!$test_query->have_posts()) {
                $slug = 'featured-articles';
            }
            wp_reset_postdata();

            $heading = 'Featured Articles';
        } else {
            // Get the current page slug
            $slug = $post->post_name;
            $heading_prefix = 'Related';
        }

        // Query posts with the matching category slug
        $args = array(
            'category_name' => $slug,
            'posts_per_page' => 20,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $articles_query = new WP_Query($args);

        if (!$articles_query->have_posts()) {
            wp_reset_postdata();
            return '';
        }

        $article_count = $articles_query->post_count;

        // Set heading based on count
        if (!is_front_page()) {
            $heading = $article_count === 1 ? 'Related Article' : 'Related Articles';
        }

        // Get carousel settings
        $desktop_items = get_option('ekwa_carousel_desktop_items', '3');
        $tablet_items = get_option('ekwa_carousel_tablet_items', '2');
        $mobile_items = get_option('ekwa_carousel_mobile_items', '1');
        $enable_arrows = get_option('ekwa_carousel_enable_arrows', '1');
        $enable_dots = get_option('ekwa_carousel_enable_dots', '1');

        // Determine if lazy loading is enabled
        $enable_lazyload = ($atts['lazyload'] === 'on') ? true : false;

        // Enqueue carousel script (will be lazy loaded)
        wp_enqueue_style('ekwa-carousel', EKWA_RELATED_ARTICLES_URL . 'assets/css/carousel.css', array(), EKWA_RELATED_ARTICLES_VERSION);

        // Build output
        ob_start();
        ?>
        <div class="ekwa-related-articles-carousel"
             data-desktop="<?php echo esc_attr($desktop_items); ?>"
             data-tablet="<?php echo esc_attr($tablet_items); ?>"
             data-mobile="<?php echo esc_attr($mobile_items); ?>"
             data-arrows="<?php echo esc_attr($enable_arrows); ?>"
             data-dots="<?php echo esc_attr($enable_dots); ?>">

            <h2 class="ekwa-carousel-heading"><?php echo esc_html($heading); ?></h2>

            <div class="ekwa-carousel-container">
                <div class="ekwa-carousel-track">
                    <?php
                    while ($articles_query->have_posts()) : $articles_query->the_post();
                        // Check for theme override first
                        $theme_template = get_stylesheet_directory() . '/article-templates/article-carousel-item.php';
                        $plugin_template = EKWA_RELATED_ARTICLES_PATH . 'templates/article-carousel-item.php';

                        // Make enable_lazyload available in the template
                        set_query_var('enable_lazyload', $enable_lazyload);

                        if (file_exists($theme_template)) {
                            include $theme_template;
                        } elseif (file_exists($plugin_template)) {
                            include $plugin_template;
                        }
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>

            <?php if ($enable_arrows === '1') : ?>
                <button class="ekwa-carousel-prev" aria-label="Previous">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="ekwa-carousel-next" aria-label="Next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            <?php endif; ?>

            <?php if ($enable_dots === '1') : ?>
                <div class="ekwa-carousel-dots"></div>
            <?php endif; ?>
        </div>

        <script>
        // Lazy load carousel script on user interaction
        (function() {
            var carouselLoaded = false;
            var carouselScript = '<?php echo EKWA_RELATED_ARTICLES_URL; ?>assets/js/carousel.js?v=<?php echo EKWA_RELATED_ARTICLES_VERSION; ?>';

            function loadCarousel() {
                if (!carouselLoaded) {
                    carouselLoaded = true;
                    var script = document.createElement('script');
                    script.src = carouselScript;
                    document.body.appendChild(script);
                }
            }

            // Load on scroll, mousemove, or touch
            var events = ['scroll', 'mousemove', 'touchstart', 'keydown'];
            events.forEach(function(event) {
                window.addEventListener(event, function() {
                    loadCarousel();
                    // Remove listeners after first trigger
                    events.forEach(function(e) {
                        window.removeEventListener(e, loadCarousel);
                    });
                }, { once: true, passive: true });
            });

            // Also load after 3 seconds as fallback
            setTimeout(loadCarousel, 3000);
        })();
        </script>
        <?php

        return ob_get_clean();
    }

    /**
     * AJAX handler for loading posts
     */
    public function ajax_load_posts() {
        $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
        $template_design = isset($_POST['design']) ? sanitize_text_field($_POST['design']) : 'design1';

        // Query posts
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 9,
            'paged' => $page,
            'post_status' => 'publish'
        );

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            wp_send_json_error('No posts found');
            return;
        }

        // Build posts HTML
        ob_start();
        while ($query->have_posts()) : $query->the_post();
            $categories = get_the_category();
            $first_category = !empty($categories) ? $categories[0]->name : '';
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('ekwa-blog-post'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="ekwa-post-thumbnail">
                        <?php if ($template_design === 'design2' && $first_category) : ?>
                            <span class="ekwa-category-badge"><?php echo esc_html($first_category); ?></span>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="ekwa-post-header">
                    <h2 class="ekwa-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <div class="ekwa-post-meta">
                        <span class="ekwa-post-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <?php echo get_the_date(); ?>
                        </span>

                        <span class="ekwa-post-author">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <?php the_author_posts_link(); ?>
                        </span>

                        <?php if (has_category()) : ?>
                            <span class="ekwa-post-categories">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="ekwa-post-excerpt">
                    <?php the_excerpt(); ?>
                </div>

                <div class="ekwa-post-footer">
                    <a href="<?php the_permalink(); ?>" class="ekwa-read-more">
                        Read More
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </article>
        <?php
        endwhile;
        $posts_html = ob_get_clean();

        // Build pagination HTML
        ob_start();
        $current_page = $page;
        $max_pages = $query->max_num_pages;

        if ($max_pages > 1) {
            echo '<div class="ekwa-pagination-wrapper">';

            // Previous button
            if ($current_page > 1) {
                echo '<a href="' . get_pagenum_link($current_page - 1) . '" class="ekwa-pagination-prev" data-page="' . ($current_page - 1) . '">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>';
                echo ' Previous</a>';
            }

            // Page numbers
            echo '<div class="ekwa-pagination-numbers">';
            for ($i = 1; $i <= $max_pages; $i++) {
                $active_class = ($i === $current_page) ? ' active' : '';
                echo '<a href="' . get_pagenum_link($i) . '" class="ekwa-pagination-number' . $active_class . '" data-page="' . $i . '">' . $i . '</a>';
            }
            echo '</div>';

            // Next button
            if ($current_page < $max_pages) {
                echo '<a href="' . get_pagenum_link($current_page + 1) . '" class="ekwa-pagination-next" data-page="' . ($current_page + 1) . '">Next ';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
                echo '</a>';
            }

            echo '</div>';
        }
        $pagination_html = ob_get_clean();

        wp_reset_postdata();

        // Send response
        wp_send_json_success(array(
            'posts' => $posts_html,
            'pagination' => $pagination_html,
            'url' => get_pagenum_link($page)
        ));
    }
}

// Initialize the plugin
function ekwa_related_articles_init() {
    return EKWA_Related_Articles::get_instance();
}

add_action('plugins_loaded', 'ekwa_related_articles_init');

// Activation hook
register_activation_hook(__FILE__, 'ekwa_related_articles_activate');
function ekwa_related_articles_activate() {
    // Set default options
    add_option('ekwa_blog_enable_templates', '1');
    add_option('ekwa_blog_sidebar_position', 'right');
    add_option('ekwa_blog_template_design', 'design1');
    add_option('ekwa_blog_show_recent_posts', '1');
    add_option('ekwa_blog_show_categories', '1');
    add_option('ekwa_blog_recent_posts_count', '5');

    // Carousel options
    add_option('ekwa_carousel_desktop_items', '3');
    add_option('ekwa_carousel_tablet_items', '2');
    add_option('ekwa_carousel_mobile_items', '1');
    add_option('ekwa_carousel_enable_arrows', '1');
    add_option('ekwa_carousel_enable_dots', '1');
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'ekwa_related_articles_deactivate');
function ekwa_related_articles_deactivate() {
    // Cleanup if needed
}
