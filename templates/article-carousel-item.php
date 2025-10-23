<?php
/**
 * Article Carousel Item Template
 * Can be overridden by placing file in: theme/article-templates/article-carousel-item.php
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get lazy loading setting
$enable_lazyload = get_query_var('enable_lazyload', false);
?>

<div class="ekwa-carousel-item">
    <article class="ekwa-article-card">
        <?php if (has_post_thumbnail()) : ?>
            <div class="ekwa-article-image">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if ($enable_lazyload) {
                        // Get image URL for lazy loading
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                        ?>
                        <img data-src="<?php echo esc_url($image_url); ?>"
                             alt="<?php echo esc_attr($image_alt ?: get_the_title()); ?>"
                             class="lazyload">
                    <?php } else {
                        the_post_thumbnail('medium');
                    } ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="ekwa-article-content">
            <h3 class="ekwa-article-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <div class="ekwa-article-meta">
                <span class="ekwa-article-date">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <?php echo get_the_date(); ?>
                </span>
            </div>

            <div class="ekwa-article-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
            </div>

            <a href="<?php the_permalink(); ?>" class="ekwa-article-read-more">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </article>
</div>
