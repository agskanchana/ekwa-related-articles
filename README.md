# EKWA Related Articles

A comprehensive WordPress plugin that provides multiple customizable designs for blog posts, with configurable templates that override your theme's default single, index, and archive templates.

## Features

- **Multiple Template Designs**: Choose from 3 different design styles (Classic, Modern, Minimal)
- **Configurable Sidebar**: Position sidebar on the left or right side
- **Recent Posts Widget**: Automatically displays recent posts with thumbnails
- **Categories Widget**: Shows all post categories with post counts
- **Post Navigation**: Previous and next post navigation on single posts
- **Template Override**: Seamlessly overrides theme templates for single posts, blog index, and archives
- **Responsive Design**: Fully mobile-friendly layouts
- **Easy Settings Page**: Manage all options from WordPress admin

## Installation

1. Upload the `ekwa-related-articles` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > EKWA Related Articles to configure options

## File Structure

```
ekwa-related-articles/
├── admin/
│   └── settings-page.php          # Admin settings interface
├── assets/
│   ├── css/
│   │   └── style.css              # Main stylesheet
│   └── js/
│       └── script.js              # JavaScript functionality
├── templates/
│   ├── single.php                 # Single post template
│   ├── index.php                  # Blog index template
│   ├── archive.php                # Archive template
│   └── partials/
│       └── sidebar-content.php    # Sidebar partial
├── ekwa-blog-templates.php        # Main plugin file
└── README.md                      # Documentation
```

## Configuration Options

### Settings Page (Settings > EKWA Related Articles)

- **Enable Custom Templates**: Turn plugin templates on/off
- **Sidebar Position**: Choose left or right sidebar placement
- **Template Design**: Select from Design 1 (Classic), Design 2 (Modern), or Design 3 (Minimal)
- **Show Recent Posts**: Enable/disable recent posts in sidebar
- **Recent Posts Count**: Number of recent posts to display (1-20)
- **Show Categories**: Enable/disable categories section

## Templates Included

### Single Post Template (`single.php`)
- Configurable sidebar (left or right)
- Recent posts section
- Categories section
- Previous/Next post navigation
- Featured image
- Post meta (date, author, categories, comments)
- Tags
- Comments section

### Blog Index Template (`index.php`)
- Grid layout for blog posts
- Post excerpts with featured images
- Pagination
- Responsive design

### Archive Template (`archive.php`)
- Archive header with title and description
- Grid layout for posts
- Category/tag/date archive support
- Pagination

## Widget Areas

The plugin registers a custom sidebar widget area:
- **EKWA Related Articles Sidebar**: Add custom widgets to appear in the sidebar

## Design Variations

### Design 1 - Classic
- Traditional blog design
- Rounded corners
- Soft shadows

### Design 2 - Modern
- Left border accent
- Serif headings
- Contemporary styling

### Design 3 - Minimal
- Clean borders
- Minimalist approach
- Maximum content focus

## Customization

### CSS Customization
Add custom styles to your theme's `style.css` or child theme:

```css
/* Override plugin styles */
.ekwa-blog-container {
    /* Your custom styles */
}
```

### PHP Customization
Use WordPress hooks and filters to modify functionality:

```php
// Example: Modify recent posts count
add_filter('ekwa_recent_posts_count', function($count) {
    return 10;
});
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

## Changelog

### Version 1.0.0
- Initial release
- Single post template with sidebar
- Blog index template
- Archive template
- Settings page
- Multiple design options
- Responsive design

## Support

For support, please contact EKWA or visit https://ekwa.com

## License

GPL-2.0+

---

**Author**: EKWA
**Version**: 1.0.0
**Last Updated**: 2025
