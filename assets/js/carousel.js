/**
 * EKWA Related Articles - Carousel Script
 * Version: 1.0.0
 * Vanilla JavaScript Carousel
 */

(function() {
    'use strict';

    class EkwaCarousel {
        constructor(element) {
            this.carousel = element;
            this.track = this.carousel.querySelector('.ekwa-carousel-track');
            this.items = this.carousel.querySelectorAll('.ekwa-carousel-item');
            this.prevBtn = this.carousel.querySelector('.ekwa-carousel-prev');
            this.nextBtn = this.carousel.querySelector('.ekwa-carousel-next');
            this.dotsContainer = this.carousel.querySelector('.ekwa-carousel-dots');

            // Get settings from data attributes
            this.settings = {
                desktop: parseInt(this.carousel.dataset.desktop) || 3,
                tablet: parseInt(this.carousel.dataset.tablet) || 2,
                mobile: parseInt(this.carousel.dataset.mobile) || 1,
                arrows: this.carousel.dataset.arrows === '1',
                dots: this.carousel.dataset.dots === '1'
            };

            this.currentIndex = 0;
            this.itemsPerSlide = this.getItemsPerSlide();
            this.totalSlides = Math.ceil(this.items.length / this.itemsPerSlide);

            this.init();
        }

        init() {
            this.updateItemWidth();
            this.createDots();
            this.attachEventListeners();
            this.updateNavigation();

            // Update on window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    this.handleResize();
                }, 250);
            });
        }

        getItemsPerSlide() {
            const width = window.innerWidth;
            if (width <= 480) {
                return this.settings.mobile;
            } else if (width <= 992) {
                return this.settings.tablet;
            } else {
                return this.settings.desktop;
            }
        }

        updateItemWidth() {
            const percentage = 100 / this.itemsPerSlide;
            this.items.forEach(item => {
                item.style.flex = `0 0 ${percentage}%`;
            });
        }

        createDots() {
            if (!this.settings.dots || !this.dotsContainer) return;

            this.dotsContainer.innerHTML = '';

            for (let i = 0; i < this.totalSlides; i++) {
                const dot = document.createElement('button');
                dot.className = 'ekwa-carousel-dot';
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                if (i === 0) dot.classList.add('active');

                dot.addEventListener('click', () => {
                    this.goToSlide(i);
                });

                this.dotsContainer.appendChild(dot);
            }
        }

        attachEventListeners() {
            if (this.settings.arrows) {
                if (this.prevBtn) {
                    this.prevBtn.addEventListener('click', () => this.prev());
                }
                if (this.nextBtn) {
                    this.nextBtn.addEventListener('click', () => this.next());
                }
            }

            // Touch/swipe support
            let startX = 0;
            let endX = 0;

            this.track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            }, { passive: true });

            this.track.addEventListener('touchmove', (e) => {
                endX = e.touches[0].clientX;
            }, { passive: true });

            this.track.addEventListener('touchend', () => {
                const diff = startX - endX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        this.next();
                    } else {
                        this.prev();
                    }
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    this.prev();
                } else if (e.key === 'ArrowRight') {
                    this.next();
                }
            });
        }

        goToSlide(index) {
            if (index < 0 || index >= this.totalSlides) return;

            this.currentIndex = index;
            const offset = -index * 100;
            this.track.style.transform = `translateX(${offset}%)`;

            this.updateNavigation();
            this.updateDots();
        }

        next() {
            if (this.currentIndex < this.totalSlides - 1) {
                this.goToSlide(this.currentIndex + 1);
            }
        }

        prev() {
            if (this.currentIndex > 0) {
                this.goToSlide(this.currentIndex - 1);
            }
        }

        updateNavigation() {
            if (!this.settings.arrows) return;

            if (this.prevBtn) {
                this.prevBtn.disabled = this.currentIndex === 0;
            }

            if (this.nextBtn) {
                this.nextBtn.disabled = this.currentIndex === this.totalSlides - 1;
            }
        }

        updateDots() {
            if (!this.settings.dots || !this.dotsContainer) return;

            const dots = this.dotsContainer.querySelectorAll('.ekwa-carousel-dot');
            dots.forEach((dot, index) => {
                if (index === this.currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        handleResize() {
            const newItemsPerSlide = this.getItemsPerSlide();

            if (newItemsPerSlide !== this.itemsPerSlide) {
                this.itemsPerSlide = newItemsPerSlide;
                this.totalSlides = Math.ceil(this.items.length / this.itemsPerSlide);
                this.currentIndex = 0;

                this.updateItemWidth();
                this.createDots();
                this.goToSlide(0);
            }
        }
    }

    // Initialize all carousels on the page
    function initCarousels() {
        const carousels = document.querySelectorAll('.ekwa-related-articles-carousel');
        carousels.forEach(carousel => {
            new EkwaCarousel(carousel);
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousels);
    } else {
        initCarousels();
    }

})();
