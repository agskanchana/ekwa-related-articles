# EKWA Related Articles

A comprehensive WordPress plugin that provides multiple customizable designs for blog posts, with a powerful carousel shortcode system and configurable templates that override your theme's default single, index, and archive templates.

## Features

### Template System
- **Multiple Template Designs**: Choose from 3 distinct design styles (Classic, Modern, Minimal)
- **Configurable Sidebar**: Position sidebar on the left or right side
- **Recent Posts Widget**: Automatically displays recent posts with thumbnails
- **Categories Widget**: Shows all post categories with post counts (excludes empty categories)
- **Post Navigation**: Previous and next post navigation on single posts
- **Template Override**: Seamlessly overrides theme templates for single posts, blog index, and archives
- **Custom Override Support**: Theme developers can override plugin templates via `article-templates/` folder
- **Mobile Optimized**: Featured images appear after first paragraph on mobile devices

### Carousel Shortcode
- **Related Articles Carousel**: Display related articles in a responsive carousel on any page
- **Smart Matching**: Automatically matches page slug to category slug
- **Featured Articles**: Special handling for homepage with "featured" or "featured-articles" categories
- **Responsive Configuration**: Separate settings for desktop, tablet, and mobile items per slide
- **Navigation Controls**: Optional arrows and pagination dots
- **Lazy Loading**: Script loads on user interaction for better performance
- **Optional Image Lazy Load**: Can enable lazy loading for carousel images via shortcode attribute

### Design System
- **9 Posts Per Page**: Blog index and archives display 9 posts per page
- **Responsive Design**: Fully mobile-friendly layouts with breakpoints
- **Three Distinct Designs**: Each with unique visual style and typography
- **Back to Category Link**: Single posts show contextual back link to category page
- **Smart Category Filtering**: Excludes uncategorized, featured, and featured-articles from back links

## Installation

1. Upload the `ekwa-related-articles` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > EKWA Related Articles to configure options
4. Use the `[ekwa_related_articles]` shortcode on any page

## File Structure

```
ekwa-related-articles/
├── admin/
│   └── settings-page.php          # Admin settings interface
├── assets/
│   ├── css/
│   │   ├── style.css              # Base stylesheet
│   │   ├── carousel.css           # Carousel styles
│   │   ├── design-classic.css     # Classic design styles
│   │   ├── design-modern.css      # Modern design styles
│   │   └── design-minimal.css     # Minimal design styles
│   └── js/
│       └── carousel.js            # Carousel functionality
├── templates/
│   ├── single.php                 # Single post template
│   ├── index.php                  # Blog index template
│   ├── archive.php                # Archive template
│   ├── article-carousel-item.php  # Carousel item template
│   └── partials/
│       └── sidebar-content.php    # Sidebar partial
├── includes/
│   └── plugin-update-checker/     # Auto-update functionality
├── ekwa-related-articles.php      # Main plugin file
└── README.md                      # Documentation
```

## Configuration Options

### Settings Page (Settings > EKWA Related Articles)

#### Template Settings
- **Enable Custom Templates**: Turn plugin templates on/off globally
- **Sidebar Position**: Choose left or right sidebar placement for single posts
- **Template Design**: Select from 3 distinct designs
  - **Design 1 - Classic**: Traditional blog layout with elegant typography
  - **Design 2 - Modern**: Contemporary design with bold typography and dynamic effects
  - **Design 3 - Minimal**: Clean, minimalist layout focused on content
- **Show Recent Posts**: Enable/disable recent posts section in sidebar
- **Recent Posts Count**: Number of recent posts to display (1-20)
- **Show Categories**: Enable/disable categories section in sidebar

#### Carousel Settings
- **Desktop Items**: Number of articles per slide on desktop (1-6, default: 3)
- **Tablet Items**: Number of articles per slide on tablet (1-4, default: 2)
- **Mobile Items**: Number of articles per slide on mobile (1-2, default: 1)
- **Enable Navigation Arrows**: Show/hide prev/next arrow buttons
- **Enable Dots**: Show/hide pagination dots below carousel
- **Enable Image Lazy Loading**: Optional lazy loading for carousel images
  - ⚠️ **Note**: Only enable if adding shortcode to template files. Most themes handle lazy loading automatically.
- **Dynamic Shortcode Display**: Copy-ready shortcode that updates based on settings

## Shortcode Usage

### Basic Shortcode

```
[ekwa_related_articles]
```

Display a carousel of related articles on any page or post.

### How It Works

#### On Regular Pages
The shortcode automatically displays posts from a category matching the page slug.

**Example:**
- Page: "Teeth Whitening" (slug: `teeth-whitening`)
- Displays: Posts from the `teeth-whitening` category
- Heading: "Related Article" (singular) or "Related Articles" (plural)

#### On Homepage
Displays posts from either the `featured` or `featured-articles` category.

**Example:**
- Homepage with shortcode
- Displays: Posts from `featured` category (or `featured-articles` if `featured` doesn't exist)
- Heading: "Featured Articles"

### Shortcode with Lazy Loading

```
[ekwa_related_articles lazyload="on"]
```

Enable lazy loading for carousel images. Use this only when:
- Adding the shortcode directly to template files (e.g., `page.php`, `front-page.php`)
- Your theme doesn't have built-in lazy loading

### Shortcode Attributes

| Attribute | Values | Default | Description |
|-----------|--------|---------|-------------|
| `lazyload` | `on` or `off` | `off` | Enable lazy loading for carousel images |

### Implementation Examples

#### In Page/Post Editor
Simply paste the shortcode in the content editor:
```
[ekwa_related_articles]
```

#### In Template Files
Add to your theme's template file:
```php
<?php echo do_shortcode('[ekwa_related_articles]'); ?>
```

#### In Widgets
Use the shortcode in a text widget or shortcode widget.

#### With Lazy Loading in Template
```php
<?php echo do_shortcode('[ekwa_related_articles lazyload="on"]'); ?>
```

## Templates Included

### Single Post Template (`single.php`)

**Features:**
- Configurable sidebar (left or right)
- Mobile-responsive featured image placement (after first paragraph on mobile)
- Recent posts section with thumbnails
- Categories section (excludes empty categories)
- Previous/Next post navigation with post titles
- Featured image with responsive sizing
- Post meta information (date, author, categories)
- Tags section
- Social sharing buttons integration
- Smart "Back to Category" link
- Comments section

**Back to Category Link:**
- Automatically generates a back link to the category page
- Excludes "Uncategorized", "featured", and "featured-articles" from display
- If post only has featured/uncategorized categories, no back link is shown
- Uses first available non-excluded category for the link
- Example: "Back to Teeth Whitening Page"

**Mobile Optimization:**
Featured image is intelligently placed after the first paragraph on mobile devices using `wp_is_mobile()`.

### Blog Index Template (`index.php`)

**Features:**
- Full-width grid layout (no sidebar)
- 9 posts per page
- Post excerpts with featured images
- Post meta (date, author, categories)
- Read More buttons with animated icons
- Pagination with numbers and prev/next buttons
- Page header with "Blog" title
- Responsive grid adapts to screen size

### Archive Template (`archive.php`)

**Features:**
- Archive header with dynamic title and description
- 9 posts per page
- Grid layout for posts
- Support for:
  - Category archives
  - Tag archives
  - Date archives
  - Author archives
- Post excerpts and featured images
- Pagination
- Responsive design

### Carousel Item Template (`article-carousel-item.php`)

**Features:**
- Featured image with link to post
- Post title with link
- Post date with calendar icon
- Excerpt (limited to 15 words)
- Read More button with arrow icon
- Conditional lazy loading support
- Card-based design
- Hover effects

**Can be overridden** in theme via `article-templates/article-carousel-item.php`

## Widget Areas

The plugin registers a custom sidebar widget area:
- **EKWA Related Articles Sidebar**: Add custom widgets to appear in the sidebar

## Design Variations

### Design 1 - Classic
**Style:** Traditional blog layout with elegant typography

**Characteristics:**
- Georgia serif font for titles
- Classic card design with subtle borders and shadows
- Gentle hover effects with shadow enhancement
- Clean post meta with horizontal divider line
- Traditional button style with solid background fill
- Border changes color on hover
- Conservative spacing and padding
- Professional, timeless aesthetic

**Best For:** Professional blogs, business sites, news sites

### Design 2 - Modern
**Style:** Contemporary layout with bold typography and clean aesthetics

**Characteristics:**
- Bold, sans-serif typography (800 weight) with negative letter spacing
- Dramatic hover effects (lift + image rotation)
- Category badges positioned over thumbnails (top-left overlay)
- Animated gradient underline effect on post titles
- Rounded, pill-shaped buttons with slide-in background animation
- Red accent color for icons (#e74c3c)
- 4px colored accent bar on left side appearing on hover
- Modern card shadows with pronounced depth
- Height of 280px for featured images with object-fit
- Elevated cards with significant shadow

**Best For:** Creative agencies, portfolios, lifestyle blogs, modern brands

### Design 3 - Minimal
**Style:** Clean, minimalist layout with focus on content and whitespace

**Characteristics:**
- Transparent backgrounds (no card containers)
- Light typography weights (300-600)
- SVG icons hidden for ultra-clean look
- Simple underline on "Read More" links (no buttons)
- Horizontal separator lines between posts
- Minimal hover effects (opacity fade only)
- Focus on typography and generous whitespace
- Dotted separators in post meta
- Simple 1px borders throughout
- Maximum content focus with minimal decoration

**Best For:** Writers, authors, minimalist blogs, content-focused sites

### Design Comparison Table

| Feature | Classic | Modern | Minimal |
|---------|---------|--------|---------|
| Card Style | Bordered cards with shadows | Elevated cards with depth | No cards, transparent |
| Typography | Serif titles, medium weight | Bold sans-serif, heavy | Light sans-serif |
| Hover Effect | Shadow + border color | Lift + image rotate | Opacity fade |
| Button Style | Solid fill with border | Animated pill shape | Simple underline |
| Icons | Visible, primary color | Visible, red accent | Hidden |
| Category Badge | No | Yes (overlay on image) | No |
| Visual Weight | Medium | Heavy/Bold | Light/Minimal |
| Post Separators | Card spacing | Card spacing | Horizontal lines |
| Featured Image | Auto height | 280px fixed | Auto height |
| Best Use Case | Professional/Corporate | Creative/Modern | Content/Writing |

## Customization

### Theme Override System

You can override any plugin template by creating an `article-templates` folder in your theme:

**Directory Structure:**
```
your-theme/
└── article-templates/
    ├── single.php                 # Override single post template
    ├── index.php                  # Override blog index template
    ├── archive.php                # Override archive template
    └── article-carousel-item.php  # Override carousel item
```

**How It Works:**
1. Plugin checks for templates in `your-theme/article-templates/` first
2. If not found, uses plugin's default templates
3. Your custom templates automatically take priority

**Example: Custom Single Template**

Create `wp-content/themes/your-theme/article-templates/single.php`:

```php
<?php
get_header();

while (have_posts()) : the_post();
    ?>
    <article>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </article>
    <?php
endwhile;

get_footer();
```

### CSS Customization

**Method 1: Child Theme**
Add to your child theme's `style.css`:

```css
/* Override Classic Design */
.ekwa-blog-post {
    border-radius: 12px;
    background: #fafafa;
}

/* Customize Modern Design buttons */
.ekwa-read-more {
    background: #ff6b6b;
    border-color: #ff6b6b;
}

/* Minimal Design typography */
.ekwa-post-title {
    font-family: 'Merriweather', serif;
}
```

**Method 2: Customizer Additional CSS**
Go to Appearance > Customize > Additional CSS and add your styles.

**Method 3: Custom Plugin**
Create a custom plugin to enqueue additional styles:

```php
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'custom-ekwa-styles',
        get_stylesheet_directory_uri() . '/custom-ekwa.css',
        array('ekwa-related-articles'),
        '1.0.0'
    );
}, 20);
```

### Carousel Customization

**Customize Carousel Colors:**
```css
.ekwa-carousel-prev,
.ekwa-carousel-next {
    background: #ff6b6b;
}

.ekwa-carousel-dots .dot.active {
    background: #ff6b6b;
}
```

**Customize Carousel Item Cards:**
```css
.ekwa-article-card {
    border: 2px solid #ddd;
    border-radius: 16px;
}

.ekwa-article-card:hover {
    transform: scale(1.02);
}
```

### PHP Hooks and Filters

**Modify Query Parameters:**
```php
// Change posts per page
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_home()) {
        $query->set('posts_per_page', 12);
    }
});
```

**Customize Carousel Query:**
```php
// Filter carousel posts
add_filter('ekwa_carousel_query_args', function($args) {
    $args['orderby'] = 'rand';
    return $args;
});
```

**Modify Recent Posts Count:**
```php
// Override recent posts setting
add_filter('ekwa_recent_posts_count', function($count) {
    return 10;
});
```

## Advanced Features

### Smart Category Filtering

**Sidebar Categories:**
- Only displays categories with at least 1 post
- Parent categories with 0 direct posts (but child posts) are excluded
- Prevents empty category links

**Back to Category Link:**
- Excludes `uncategorized`, `featured`, and `featured-articles` categories
- Finds the first eligible category for the back link
- If only excluded categories exist, no link is shown
- Example: Post in "Featured" and "Dental Implants" → Shows "Back to Dental Implants Page"

### Mobile Optimization

**Responsive Breakpoints:**
- Desktop: 992px and above
- Tablet: 768px - 991px
- Mobile: 767px and below

**Mobile-Specific Features:**
- Featured image repositions after first paragraph on single posts
- Carousel adapts items per slide based on screen size
- Navigation arrows resize for touch devices
- Grid layouts stack vertically on mobile

### Carousel Performance

**Lazy Loading Strategy:**
- Carousel script loads on first user interaction (scroll, mousemove, touch, keypress)
- Fallback loads after 3 seconds if no interaction
- Reduces initial page load time
- Image lazy loading optional via shortcode attribute

**Touch Support:**
- Swipe gestures on mobile/tablet
- Touch-friendly navigation buttons
- Smooth transitions

**Keyboard Navigation:**
- Arrow keys to navigate slides
- Accessible for keyboard-only users

### Pagination System

**AJAX Pagination (Optional):**
The plugin supports AJAX-based pagination for seamless page transitions.

**Static Pagination (Default):**
- Standard WordPress pagination with page numbers
- Previous/Next buttons with arrow icons
- Current page highlighting
- Maintains URL structure for SEO

### Auto-Update System

Plugin includes automatic update checking from GitHub repository:
- Checks for updates from `https://github.com/agskanchana/ekwa-related-articles/`
- Updates appear in WordPress admin under Plugins
- Maintains compatibility and security

## Troubleshooting

### Templates Not Showing

**Issue:** Plugin templates not overriding theme templates.

**Solutions:**
1. Check "Enable Custom Templates" is ON in settings
2. Clear all caches (WordPress cache, browser cache, CDN cache)
3. Verify template files exist in plugin's `templates/` folder
4. Check for theme conflicts in `functions.php`

### Carousel Not Displaying

**Issue:** Shortcode shows no carousel.

**Solutions:**
1. Verify posts exist in matching category
2. Check page slug matches category slug
3. For homepage, ensure `featured` or `featured-articles` category exists with posts
4. Clear browser cache
5. Check browser console for JavaScript errors

### Sidebar Not Appearing

**Issue:** Sidebar missing on single posts.

**Solutions:**
1. Check "Show Recent Posts" and/or "Show Categories" is enabled
2. Verify posts exist for recent posts to display
3. Ensure categories with posts exist
4. Check theme compatibility

### Images Not Lazy Loading

**Issue:** Carousel images load immediately.

**Solutions:**
1. Verify `lazyload="on"` attribute is in shortcode
2. Check that theme's lazy loading isn't conflicting
3. Only use when shortcode is in template files
4. Most themes handle lazy loading automatically - often not needed

### Styling Issues

**Issue:** Design doesn't match expectations.

**Solutions:**
1. Check correct design is selected in settings (Classic/Modern/Minimal)
2. Clear all caches
3. Verify no theme CSS is overriding plugin styles
4. Check browser inspector for CSS conflicts
5. Try switching to a default WordPress theme to isolate issue

### Posts Per Page Issues

**Issue:** Not showing 9 posts per page.

**Solutions:**
1. Clear permalinks: Settings > Permalinks > Save Changes
2. Clear all caches
3. Check for theme/plugin conflicts modifying query
4. Verify not using custom query in theme templates

## Frequently Asked Questions

### Can I use multiple carousel shortcodes on one page?
Yes, you can use `[ekwa_related_articles]` multiple times. Each will display posts based on the page slug.

### Does this work with custom post types?
No, the plugin is specifically designed for standard WordPress posts. Custom post types are not supported.

### Can I change the colors?
Yes, use CSS customization in your theme or child theme to override the default colors.

### Will this slow down my site?
No. The plugin uses performance best practices:
- Lazy loads carousel JavaScript
- Optional image lazy loading
- Minimal CSS files loaded only when needed
- Efficient database queries

### Can I translate the plugin?
Yes, the plugin uses WordPress translation functions. Use a plugin like Loco Translate or WPML for translations.

### Does it work with page builders?
Yes, the shortcode works with:
- Gutenberg (use Shortcode block)
- Elementor (use Shortcode widget)
- WPBakery
- Divi
- Beaver Builder
- Any page builder supporting WordPress shortcodes

### How do I remove the plugin completely?
1. Deactivate the plugin
2. Delete the plugin files
3. Settings are stored in WordPress options (auto-cleanup on deletion)

### Can I use this with WooCommerce?
Yes, but it only affects blog posts, not product pages. WooCommerce pages remain unchanged.

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Modern browser (Chrome, Firefox, Safari, Edge, Opera)
- JavaScript enabled for carousel functionality

## Browser Support

### Desktop Browsers
- Chrome 90+ ✓
- Firefox 88+ ✓
- Safari 14+ ✓
- Edge 90+ ✓
- Opera 76+ ✓

### Mobile Browsers
- iOS Safari 14+ ✓
- Chrome Mobile 90+ ✓
- Firefox Mobile 88+ ✓
- Samsung Internet 14+ ✓

### Features Support
- CSS Grid: Full support
- CSS Custom Properties: Full support (colors default to fallbacks)
- IntersectionObserver API: Full support with fallback
- Touch Events: Full support
- Flexbox: Full support

## Performance

### Optimization Features
- **Conditional Loading**: CSS files only load on relevant pages
- **Lazy Script Loading**: Carousel JS loads on user interaction
- **Minimal Dependencies**: No external libraries required
- **Efficient Queries**: Optimized database queries with proper caching
- **Image Optimization**: Optional lazy loading for carousel images
- **Mobile First**: Responsive images and adaptive layouts

### Performance Metrics
- **Page Load Impact**: < 50KB additional resources
- **JavaScript**: ~8KB (carousel.js, lazy loaded)
- **CSS**: ~10-15KB per design (only one loads at a time)
- **Database Queries**: Optimized with WP_Query caching

## Security

- Nonce verification on settings save
- Data sanitization on all inputs
- Escaped output throughout
- No external dependencies
- Regular security updates via GitHub

## Changelog

### Version 1.0.0 (2025-10-23)
**Initial Release**
- ✅ Single post template with configurable sidebar
- ✅ Blog index template (9 posts per page)
- ✅ Archive template (9 posts per page)
- ✅ Three distinct design systems (Classic, Modern, Minimal)
- ✅ Related articles carousel shortcode
- ✅ Responsive carousel with touch support
- ✅ Smart category matching for carousel
- ✅ Theme override system via `article-templates/` folder
- ✅ Mobile-optimized featured image placement
- ✅ SVG icons throughout (no icon fonts)
- ✅ Smart category filtering (excludes empty and special categories)
- ✅ Back to category page links with intelligent filtering
- ✅ Configurable carousel settings (items, arrows, dots, lazy loading)
- ✅ Lazy loading carousel script on user interaction
- ✅ Optional image lazy loading via shortcode
- ✅ AJAX pagination support
- ✅ Previous/Next post navigation
- ✅ Social sharing buttons integration support
- ✅ Auto-update system via GitHub
- ✅ Comprehensive settings page
- ✅ Full responsive design with mobile optimization

### Planned Features (Future Versions)
- Custom color picker in settings
- Additional design variations
- Widget for displaying related articles
- Shortcode builder in admin
- Grid view option for carousel
- Filter by tags support
- Custom excerpt length control
- Reading time display
- View counter
- Post reactions/likes

## Credits

**Developed By:** EKWA Marketing
**Author URI:** https://ekwa.com
**Plugin URI:** https://github.com/agskanchana/ekwa-related-articles
**License:** GPL-2.0+
**Version:** 1.0.0

### Technologies Used
- WordPress Hooks & Filters
- WP_Query for optimized database queries
- WordPress Settings API
- Vanilla JavaScript (no jQuery dependency for carousel)
- CSS Grid and Flexbox
- IntersectionObserver API for lazy loading
- SVG icons for lightweight design
- Mobile-first responsive design principles

## Support

For support, feature requests, or bug reports:
- **Email:** support@ekwa.com
- **Website:** https://ekwa.com
- **GitHub Issues:** https://github.com/agskanchana/ekwa-related-articles/issues

## Contributing

We welcome contributions! To contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This plugin is licensed under GPL-2.0+. You are free to use, modify, and distribute this plugin under the terms of the GNU General Public License v2 or later.

**Full License:** http://www.gnu.org/licenses/gpl-2.0.txt

---

## Quick Start Guide

### 1. Activate Plugin
- Go to Plugins > Installed Plugins
- Click "Activate" on EKWA Related Articles

### 2. Configure Settings
- Navigate to Settings > EKWA Related Articles
- Choose your design (Classic, Modern, or Minimal)
- Configure sidebar position
- Enable/disable sidebar widgets
- Configure carousel settings

### 3. Add Carousel to Pages
- Edit any page
- Add shortcode: `[ekwa_related_articles]`
- Ensure page slug matches a category slug (or use `featured` for homepage)
- Publish and view

### 4. Create Matching Categories
- Go to Posts > Categories
- Create categories matching your page slugs
- Example: Page "dental-implants" needs category "dental-implants"
- Add posts to those categories

### 5. Test and Customize
- View your blog index page
- Check single post pages
- Test carousel on pages with matching categories
- Customize CSS if needed

---

**Made with ❤️ by EKWA Marketing**
**Version:** 1.0.0
**Last Updated:** October 23, 2025
