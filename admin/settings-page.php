<?php
/**
 * Settings Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Save settings
if (isset($_POST['ekwa_blog_save_settings'])) {
    check_admin_referer('ekwa_blog_settings_nonce');

    update_option('ekwa_blog_enable_templates', isset($_POST['ekwa_blog_enable_templates']) ? '1' : '0');
    update_option('ekwa_blog_sidebar_position', sanitize_text_field($_POST['ekwa_blog_sidebar_position']));
    update_option('ekwa_blog_template_design', sanitize_text_field($_POST['ekwa_blog_template_design']));
    update_option('ekwa_blog_show_recent_posts', isset($_POST['ekwa_blog_show_recent_posts']) ? '1' : '0');
    update_option('ekwa_blog_show_categories', isset($_POST['ekwa_blog_show_categories']) ? '1' : '0');
    update_option('ekwa_blog_recent_posts_count', absint($_POST['ekwa_blog_recent_posts_count']));

    // Carousel settings
    update_option('ekwa_carousel_desktop_items', absint($_POST['ekwa_carousel_desktop_items']));
    update_option('ekwa_carousel_tablet_items', absint($_POST['ekwa_carousel_tablet_items']));
    update_option('ekwa_carousel_mobile_items', absint($_POST['ekwa_carousel_mobile_items']));
    update_option('ekwa_carousel_enable_arrows', isset($_POST['ekwa_carousel_enable_arrows']) ? '1' : '0');
    update_option('ekwa_carousel_enable_dots', isset($_POST['ekwa_carousel_enable_dots']) ? '1' : '0');
    update_option('ekwa_carousel_enable_lazyload', isset($_POST['ekwa_carousel_enable_lazyload']) ? '1' : '0');

    echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
}

// Get current options
$enable_templates = get_option('ekwa_blog_enable_templates', '1');
$sidebar_position = get_option('ekwa_blog_sidebar_position', 'right');
$template_design = get_option('ekwa_blog_template_design', 'design1');
$show_recent_posts = get_option('ekwa_blog_show_recent_posts', '1');
$show_categories = get_option('ekwa_blog_show_categories', '1');
$recent_posts_count = get_option('ekwa_blog_recent_posts_count', '5');

// Carousel options
$carousel_desktop_items = get_option('ekwa_carousel_desktop_items', '3');
$carousel_tablet_items = get_option('ekwa_carousel_tablet_items', '2');
$carousel_mobile_items = get_option('ekwa_carousel_mobile_items', '1');
$carousel_enable_arrows = get_option('ekwa_carousel_enable_arrows', '1');
$carousel_enable_dots = get_option('ekwa_carousel_enable_dots', '1');
$carousel_enable_lazyload = get_option('ekwa_carousel_enable_lazyload', '0');
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form method="post" action="">
        <?php wp_nonce_field('ekwa_blog_settings_nonce'); ?>

        <table class="form-table">
            <tbody>
                <!-- Enable Templates -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_blog_enable_templates">Enable Custom Templates</label>
                    </th>
                    <td>
                        <input type="checkbox"
                               name="ekwa_blog_enable_templates"
                               id="ekwa_blog_enable_templates"
                               value="1"
                               <?php checked($enable_templates, '1'); ?>>
                        <p class="description">Enable plugin templates to override theme templates</p>
                    </td>
                </tr>

                <!-- Sidebar Position -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_blog_sidebar_position">Sidebar Position</label>
                    </th>
                    <td>
                        <select name="ekwa_blog_sidebar_position" id="ekwa_blog_sidebar_position">
                            <option value="right" <?php selected($sidebar_position, 'right'); ?>>Right</option>
                            <option value="left" <?php selected($sidebar_position, 'left'); ?>>Left</option>
                        </select>
                        <p class="description">Choose sidebar position for single post template</p>
                    </td>
                </tr>

                <!-- Template Design -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_blog_template_design">Template Design</label>
                    </th>
                    <td>
                        <select name="ekwa_blog_template_design" id="ekwa_blog_template_design">
                            <option value="design1" <?php selected($template_design, 'design1'); ?>>Design 1 - Classic</option>
                            <option value="design2" <?php selected($template_design, 'design2'); ?>>Design 2 - Modern</option>
                            <option value="design3" <?php selected($template_design, 'design3'); ?>>Design 3 - Minimal</option>
                        </select>
                        <p class="description">Choose the design style for blog templates</p>
                    </td>
                </tr>

                <!-- Show Recent Posts -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_blog_show_recent_posts">Show Recent Posts</label>
                    </th>
                    <td>
                        <input type="checkbox"
                               name="ekwa_blog_show_recent_posts"
                               id="ekwa_blog_show_recent_posts"
                               value="1"
                               <?php checked($show_recent_posts, '1'); ?>>
                        <p class="description">Display recent posts in sidebar</p>
                    </td>
                </tr>

                <!-- Recent Posts Count -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_blog_recent_posts_count">Recent Posts Count</label>
                    </th>
                    <td>
                        <input type="number"
                               name="ekwa_blog_recent_posts_count"
                               id="ekwa_blog_recent_posts_count"
                               value="<?php echo esc_attr($recent_posts_count); ?>"
                               min="1"
                               max="20"
                               step="1">
                        <p class="description">Number of recent posts to display (1-20)</p>
                    </td>
                </tr>

                <!-- Show Categories -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_blog_show_categories">Show Categories</label>
                    </th>
                    <td>
                        <input type="checkbox"
                               name="ekwa_blog_show_categories"
                               id="ekwa_blog_show_categories"
                               value="1"
                               <?php checked($show_categories, '1'); ?>>
                        <p class="description">Display categories in sidebar</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 style="margin-top: 40px;">Carousel Settings</h2>
        <table class="form-table">
            <tbody>
                <!-- Desktop Items -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_carousel_desktop_items">Desktop Items</label>
                    </th>
                    <td>
                        <input type="number"
                               name="ekwa_carousel_desktop_items"
                               id="ekwa_carousel_desktop_items"
                               value="<?php echo esc_attr($carousel_desktop_items); ?>"
                               min="1"
                               max="6"
                               step="1">
                        <p class="description">Number of articles to show per slide on desktop (1-6)</p>
                    </td>
                </tr>

                <!-- Tablet Items -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_carousel_tablet_items">Tablet Items</label>
                    </th>
                    <td>
                        <input type="number"
                               name="ekwa_carousel_tablet_items"
                               id="ekwa_carousel_tablet_items"
                               value="<?php echo esc_attr($carousel_tablet_items); ?>"
                               min="1"
                               max="4"
                               step="1">
                        <p class="description">Number of articles to show per slide on tablet (1-4)</p>
                    </td>
                </tr>

                <!-- Mobile Items -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_carousel_mobile_items">Mobile Items</label>
                    </th>
                    <td>
                        <input type="number"
                               name="ekwa_carousel_mobile_items"
                               id="ekwa_carousel_mobile_items"
                               value="<?php echo esc_attr($carousel_mobile_items); ?>"
                               min="1"
                               max="2"
                               step="1">
                        <p class="description">Number of articles to show per slide on mobile (1-2)</p>
                    </td>
                </tr>

                <!-- Enable Arrows -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_carousel_enable_arrows">Enable Navigation Arrows</label>
                    </th>
                    <td>
                        <input type="checkbox"
                               name="ekwa_carousel_enable_arrows"
                               id="ekwa_carousel_enable_arrows"
                               value="1"
                               <?php checked($carousel_enable_arrows, '1'); ?>>
                        <p class="description">Show prev/next arrow buttons in carousel</p>
                    </td>
                </tr>

                <!-- Enable Dots -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_carousel_enable_dots">Enable Dots</label>
                    </th>
                    <td>
                        <input type="checkbox"
                               name="ekwa_carousel_enable_dots"
                               id="ekwa_carousel_enable_dots"
                               value="1"
                               <?php checked($carousel_enable_dots, '1'); ?>>
                        <p class="description">Show pagination dots below carousel</p>
                    </td>
                </tr>

                <!-- Enable Lazy Loading -->
                <tr>
                    <th scope="row">
                        <label for="ekwa_carousel_enable_lazyload">Enable Image Lazy Loading</label>
                    </th>
                    <td>
                        <input type="checkbox"
                               name="ekwa_carousel_enable_lazyload"
                               id="ekwa_carousel_enable_lazyload"
                               value="1"
                               <?php checked($carousel_enable_lazyload, '1'); ?>>
                        <p class="description">Enable lazy loading for carousel images (improves page load performance)</p>
                            <div style="margin-top:6px; color:#d35400; font-size:13px;">
                                <strong>Note:</strong> Only enable lazy loading if you are adding the shortcode to a template file. For most themes, lazy loading is already handled automatically.
                            </div>
                    </td>
                </tr>

                <!-- Dynamic Shortcode Display -->
                <tr>
                    <th scope="row">
                        <label>Shortcode to Use</label>
                    </th>
                    <td>
                        <code id="ekwa-dynamic-shortcode" style="background: #f0f0f0; padding: 8px 12px; display: inline-block; border-radius: 3px; font-size: 13px;">
                            [ekwa_related_articles<?php echo $carousel_enable_lazyload == '1' ? ' lazyload="on"' : ''; ?>]
                        </code>
                        <p class="description">Copy and paste this shortcode into any page. The shortcode updates automatically based on lazy loading setting.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <script>
        // Update shortcode display when lazy loading checkbox changes
        document.getElementById('ekwa_carousel_enable_lazyload').addEventListener('change', function() {
            var shortcodeDisplay = document.getElementById('ekwa-dynamic-shortcode');
            if (this.checked) {
                shortcodeDisplay.textContent = '[ekwa_related_articles lazyload="on"]';
            } else {
                shortcodeDisplay.textContent = '[ekwa_related_articles]';
            }
        });
        </script>

        <p class="submit">
            <input type="submit"
                   name="ekwa_blog_save_settings"
                   class="button button-primary"
                   value="Save Settings">
        </p>
    </form>

    <hr>

    <div class="ekwa-info-box" style="background: #fff; padding: 20px; border-left: 4px solid #2271b1; margin-top: 20px;">
        <h2>Plugin Information</h2>
        <p><strong>Version:</strong> <?php echo EKWA_RELATED_ARTICLES_VERSION; ?></p>
        <p><strong>Description:</strong> This plugin overrides your theme's single post, blog index, and archive templates with custom designs.</p>
        <p><strong>Features:</strong></p>
        <ul style="list-style: disc; margin-left: 20px;">
            <li>Configurable sidebar position (left or right)</li>
            <li>Multiple design options</li>
            <li>Recent posts section</li>
            <li>Categories section (only shows categories with posts)</li>
            <li>Previous/Next post navigation</li>
        </ul>
    </div>

    <div class="ekwa-info-box" style="background: #e8f5e9; padding: 20px; border-left: 4px solid #4caf50; margin-top: 20px;">
        <h2>📌 Related Articles Shortcode</h2>
        <p><strong>Display related articles carousel on any page!</strong></p>

        <p><strong>Shortcode:</strong></p>
        <code style="background: #fff; padding: 10px 15px; display: block; margin: 10px 0; font-size: 14px;">[ekwa_related_articles]</code>

        <p><strong>How it works:</strong></p>
        <ul style="list-style: disc; margin-left: 20px;">
            <li><strong>On regular pages:</strong> Automatically displays posts from a category matching the page slug
                <br><span style="font-size: 0.9em; color: #666;">Example: Page "Teeth Whitening" (slug: teeth-whitening) → Shows posts from "teeth-whitening" category</span>
            </li>
            <li><strong>On home page:</strong> Displays posts from "featured" or "featured-articles" category
                <br><span style="font-size: 0.9em; color: #666;">Heading changes to "Featured Articles"</span>
            </li>
            <li><strong>Heading:</strong> Automatically shows "Related Article" (singular) or "Related Articles" (plural)</li>
            <li><strong>Carousel:</strong> Uses settings configured above (desktop/tablet/mobile items, arrows, dots)</li>
            <li><strong>Lazy Loading:</strong> Carousel script loads on user interaction (scroll, mousemove, touch)</li>
        </ul>

        <p style="margin-top: 15px;"><strong>Usage:</strong> Simply add the shortcode to any page content where you want to display the carousel.</p>
    </div>

    <div class="ekwa-info-box" style="background: #fff5e6; padding: 20px; border-left: 4px solid #ff9800; margin-top: 20px;">
        <h2>🎨 Custom Template Override</h2>
        <p><strong>Want to customize the plugin templates?</strong></p>
        <p>You can override the plugin's templates by creating an <code>article-templates</code> folder in your theme directory and placing your custom template files there.</p>

        <p><strong>Steps to override:</strong></p>
        <ol style="margin-left: 20px;">
            <li>Create a folder named <code>article-templates</code> in your active theme directory:<br>
                <code style="background: #fff; padding: 5px 10px; display: inline-block; margin: 5px 0;"><?php echo get_stylesheet_directory(); ?>/article-templates/</code>
            </li>
            <li>Copy any of these files from the plugin and customize them:
                <ul style="list-style: circle; margin-left: 20px; margin-top: 10px;">
                    <li><code>single.php</code> - Single blog post template</li>
                    <li><code>index.php</code> - Blog posts listing template</li>
                    <li><code>archive.php</code> - Category/tag/date archive template</li>
                    <li><code>article-carousel-item.php</code> - Carousel article card template</li>
                </ul>
            </li>
            <li>Your custom templates will automatically take priority over the plugin's default templates.</li>
        </ol>

        <p style="margin-top: 15px;"><strong>Note:</strong> Categories with 0 posts will not be displayed in the sidebar.</p>
    </div>
</div>

<style>
.form-table th {
    width: 250px;
}
code {
    background: #f5f5f5;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: monospace;
    color: #d63384;
}
</style>
