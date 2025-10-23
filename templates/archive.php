<?php
/**
 * Archive Template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$template_design = get_option('ekwa_blog_template_design', 'design1');

?>

<div class="ekwa-blog-container ekwa-archive-page ekwa-<?php echo esc_attr($template_design); ?>">
    <div class="ekwa-content-wrapper">

        <!-- Main Content -->
        <main class="ekwa-main-content ekwa-full-width">

            <?php if (have_posts()) : ?>

                <!-- Archive Header -->
                <div class="ekwa-archive-header">
                    <?php
                    the_archive_title('<h1 class="ekwa-archive-title">', '</h1>');
                    the_archive_description('<div class="ekwa-archive-description">', '</div>');
                    ?>
                </div>

                <div class="ekwa-posts-grid">
                    <?php
                    while (have_posts()) : the_post();
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('ekwa-blog-post'); ?>>

                            <!-- Featured Image -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="ekwa-post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Post Header -->
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

                            <!-- Post Excerpt -->
                            <div class="ekwa-post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <!-- Read More -->
                            <div class="ekwa-post-footer">
                                <a href="<?php the_permalink(); ?>" class="ekwa-read-more">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            </div>

                        </article>
                    <?php
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <nav class="ekwa-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Previous',
                        'next_text' => 'Next <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                    ));
                    ?>
                </nav>

            <?php else : ?>

                <div class="ekwa-no-posts">
                    <h2>No posts found</h2>
                    <p>Sorry, no posts were found in this archive. Please check back later.</p>
                </div>

            <?php endif; ?>

        </main>

    </div>
</div>

<?php get_footer(); ?>
