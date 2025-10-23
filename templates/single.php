<?php
/**
 * Single Post Template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$sidebar_position = get_option('ekwa_blog_sidebar_position', 'right');
$template_design = get_option('ekwa_blog_template_design', 'design1');
$show_recent_posts = get_option('ekwa_blog_show_recent_posts', '1');
$show_categories = get_option('ekwa_blog_show_categories', '1');
$recent_posts_count = get_option('ekwa_blog_recent_posts_count', '5');

?>

<div class="ekwa-blog-container ekwa-<?php echo esc_attr($template_design); ?> ekwa-sidebar-<?php echo esc_attr($sidebar_position); ?>">
    <div class="ekwa-content-wrapper">

        <?php if ($sidebar_position === 'left') : ?>
            <!-- Left Sidebar -->
            <aside class="ekwa-sidebar ekwa-sidebar-left">
                <?php get_template_part('templates/partials/sidebar-content'); ?>
                <?php include EKWA_RELATED_ARTICLES_PATH . 'templates/partials/sidebar-content.php'; ?>
            </aside>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="ekwa-main-content">
            <?php
            while (have_posts()) : the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('ekwa-single-post'); ?>>

                    <!-- Post Header -->
                    <div class="ekwa-post-header">
                        <h1 class="ekwa-post-title"><?php the_title(); ?></h1>

                        <div class="ekwa-post-meta">
                            <span class="ekwa-post-date">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <?php echo get_the_date(); ?>
                            </span>

                            <span class="ekwa-post-author">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <a href="<?php echo get_page_slug_by_id(get_theme_mod('author_page'));?>">
							    <?php the_author(); ?>
							    </a>
                            </span>

                            <?php if (has_category()) : ?>
                                <span class="ekwa-post-categories">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (wp_is_mobile()) : ?>
                        <!-- Post Content on Mobile (image comes after first paragraph) -->
                        <div class="ekwa-post-content">
                            <?php
                            $content = get_the_content();
                            $content = apply_filters('the_content', $content);

                            // Split content into paragraphs
                            $paragraphs = preg_split('/(<p[^>]*>.*?<\/p>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

                            $first_paragraph_shown = false;
                            $image_inserted = false;

                            foreach ($paragraphs as $paragraph) {
                                // Check if this is a paragraph tag
                                if (preg_match('/<p[^>]*>.*?<\/p>/is', $paragraph)) {
                                    echo $paragraph;

                                    // After first paragraph, insert featured image
                                    if (!$first_paragraph_shown && has_post_thumbnail() && !$image_inserted) {
                                        echo '<div class="ekwa-post-thumbnail">';
                                        the_post_thumbnail('large');
                                        echo '</div>';
                                        $image_inserted = true;
                                    }
                                    $first_paragraph_shown = true;
                                } else {
                                    echo $paragraph;
                                }
                            }

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('Pages:', 'ekwa-related-articles'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>
                    <?php else : ?>
                        <!-- Featured Image (Desktop) -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="ekwa-post-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content (Desktop) -->
                        <div class="ekwa-post-content">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('Pages:', 'ekwa-related-articles'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Footer -->
                    <div class="ekwa-post-footer">
                        <?php if (has_tag()) : ?>
                            <div class="ekwa-post-tags">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                <?php the_tags('', ', ', ''); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Get primary category and create back to link
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            // Filter out "Uncategorized"
                            $filtered_categories = array_filter($categories, function($cat) {
                                return strtolower($cat->slug) !== 'uncategorized';
                            });

                            if (!empty($filtered_categories)) {
                                // Get the primary category (first one after filtering)
                                $primary_category = reset($filtered_categories);
                                $category_slug = $primary_category->slug;
                                $category_name = $primary_category->name;

                                // Build the page URL using the category slug
                                $page_url = home_url('/' . $category_slug . '/');
                                ?>
                                <div class="ekwa-back-to-category">
                                    <a href="<?php echo esc_url($page_url); ?>" class="ekwa-back-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                        Back to <?php echo esc_html($category_name); ?> Page
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div id="sm-buttons" class="lazyload" data-script="https://www.doneformesocial.com/sm-share-buttons/embed.js"></div>

                </article>

                <!-- Post Navigation -->
                <nav class="ekwa-post-navigation">
                    <div class="ekwa-nav-links">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>

                        <div class="ekwa-nav-previous">
                            <?php if (!empty($prev_post)) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="ekwa-nav-link">
                                    <span class="ekwa-nav-subtitle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                        Previous Post
                                    </span>
                                    <span class="ekwa-nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="ekwa-nav-next">
                            <?php if (!empty($next_post)) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="ekwa-nav-link">
                                    <span class="ekwa-nav-subtitle">
                                        Next Post
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                    </span>
                                    <span class="ekwa-nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>

                <!-- Comments -->
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php
            endwhile;
            ?>
        </main>

        <?php if ($sidebar_position === 'right') : ?>
            <!-- Right Sidebar -->
            <aside class="ekwa-sidebar ekwa-sidebar-right">
                <?php include EKWA_RELATED_ARTICLES_PATH . 'templates/partials/sidebar-content.php'; ?>
            </aside>
        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
