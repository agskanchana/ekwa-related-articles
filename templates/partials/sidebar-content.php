<?php
/**
 * Sidebar Content Partial
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$show_recent_posts = get_option('ekwa_blog_show_recent_posts', '1');
$show_categories = get_option('ekwa_blog_show_categories', '1');
$recent_posts_count = get_option('ekwa_blog_recent_posts_count', '5');
?>

<div class="ekwa-sidebar-content">

    <?php if ($show_recent_posts === '1') : ?>
        <!-- Recent Posts Widget -->
        <div class="ekwa-widget ekwa-recent-posts-widget">
            <h3 class="ekwa-widget-title">Recent Posts</h3>
            <div class="ekwa-widget-content">
                <?php
                $recent_posts = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => $recent_posts_count,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'post__not_in'   => array(get_the_ID()),
                ));

                if ($recent_posts->have_posts()) :
                ?>
                    <ul class="ekwa-recent-posts-list">
                        <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                            <li class="ekwa-recent-post-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="ekwa-recent-post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="ekwa-recent-post-details">
                                    <h4 class="ekwa-recent-post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <span class="ekwa-recent-post-date"><?php echo get_the_date(); ?></span>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php
                    wp_reset_postdata();
                else :
                    echo '<p>No recent posts found.</p>';
                endif;
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($show_categories === '1') : ?>
        <!-- Categories Widget -->
        <div class="ekwa-widget ekwa-categories-widget">
            <h3 class="ekwa-widget-title">Categories</h3>
            <div class="ekwa-widget-content">
                <?php
                $categories = get_categories(array(
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hide_empty' => true,
                ));

                // Filter out categories with 0 posts (even if they're parent categories)
                $categories_with_posts = array();
                foreach ($categories as $category) {
                    if ($category->count > 0) {
                        $categories_with_posts[] = $category;
                    }
                }

                if (!empty($categories_with_posts)) :
                ?>
                    <ul class="ekwa-categories-list">
                        <?php foreach ($categories_with_posts as $category) : ?>
                            <li class="ekwa-category-item">
                                <a href="<?php echo get_category_link($category->term_id); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="ekwa-category-count">(<?php echo $category->count; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php
                else :
                    echo '<p>No categories found.</p>';
                endif;
                ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- WordPress Default Sidebar (if active) -->
    <?php if (is_active_sidebar('ekwa-blog-sidebar')) : ?>
        <div class="ekwa-widget ekwa-custom-widgets">
            <?php dynamic_sidebar('ekwa-blog-sidebar'); ?>
        </div>
    <?php endif; ?>

</div>
