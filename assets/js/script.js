/**
 * EKWA Related Articles - JavaScript
 * Version: 1.0.0
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Smooth scroll for navigation links
        $('.ekwa-nav-link').on('click', function(e) {
            // Add any custom navigation behavior here
        });

        // Add loaded class for animations
        $('.ekwa-blog-post').each(function(index) {
            $(this).delay(100 * index).queue(function(next) {
                $(this).addClass('loaded');
                next();
            });
        });

    });

})(jQuery);
