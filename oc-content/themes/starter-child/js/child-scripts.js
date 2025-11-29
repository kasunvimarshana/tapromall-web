/**
 * Starter Child Theme - JavaScript
 *
 * Custom JavaScript functionality for the child theme.
 * This file is loaded after jQuery and parent theme scripts.
 *
 * @package StarterChild
 * @version 1.0.0
 */

(function($) {
    'use strict';

    /**
     * StarterChild namespace
     * Contains all child theme JavaScript functionality
     */
    var StarterChild = {

        /**
         * Configuration settings
         */
        config: {
            debug: false,
            animationSpeed: 300
        },

        /**
         * Initialize all modules
         */
        init: function() {
            this.log('StarterChild: Initializing...');
            
            // Initialize modules
            this.accessibility.init();
            this.navigation.init();
            this.forms.init();
            this.ui.init();
            
            // Fire ready event for external plugins
            $(document).trigger('starterchild:ready');
            
            this.log('StarterChild: Initialization complete');
        },

        /**
         * Debug logging
         * @param {string} message - Message to log
         */
        log: function(message) {
            if (this.config.debug && console && console.log) {
                console.log(message);
            }
        },

        /**
         * Accessibility enhancements
         */
        accessibility: {
            init: function() {
                this.addSkipLink();
                this.handleKeyboardNavigation();
                this.handleReducedMotion();
            },

            /**
             * Add skip to content link
             */
            addSkipLink: function() {
                if ($('.child-skip-link').length === 0) {
                    var skipLink = $('<a>', {
                        'class': 'child-skip-link',
                        'href': '#main-content',
                        'text': 'Skip to main content'
                    });
                    $('body').prepend(skipLink);
                }
            },

            /**
             * Handle keyboard navigation
             */
            handleKeyboardNavigation: function() {
                // Add keyboard support for custom interactive elements
                $(document).on('keypress', '[role="button"]', function(e) {
                    if (e.which === 13 || e.which === 32) {
                        e.preventDefault();
                        $(this).trigger('click');
                    }
                });
            },

            /**
             * Handle reduced motion preference
             */
            handleReducedMotion: function() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    StarterChild.config.animationSpeed = 0;
                }
            }
        },

        /**
         * Navigation enhancements
         */
        navigation: {
            init: function() {
                this.smoothScroll();
                this.backToTop();
            },

            /**
             * Smooth scrolling for anchor links
             */
            smoothScroll: function() {
                $('a[href^="#"]:not([href="#"])').on('click', function(e) {
                    var target = $(this.hash);
                    if (target.length) {
                        e.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top - 80
                        }, StarterChild.config.animationSpeed);
                    }
                });
            },

            /**
             * Back to top button functionality
             */
            backToTop: function() {
                var $backToTop = $('.child-back-to-top');
                
                if ($backToTop.length === 0) {
                    return;
                }

                $(window).on('scroll', function() {
                    if ($(this).scrollTop() > 300) {
                        $backToTop.fadeIn(StarterChild.config.animationSpeed);
                    } else {
                        $backToTop.fadeOut(StarterChild.config.animationSpeed);
                    }
                });

                $backToTop.on('click', function(e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, StarterChild.config.animationSpeed);
                });
            }
        },

        /**
         * Form enhancements
         */
        forms: {
            init: function() {
                this.enhanceInputs();
                this.floatingLabels();
            },

            /**
             * Enhance form inputs
             */
            enhanceInputs: function() {
                // Add focus state class to parent
                $('input, select, textarea').on('focus', function() {
                    $(this).closest('.form-group, .form-field').addClass('is-focused');
                }).on('blur', function() {
                    $(this).closest('.form-group, .form-field').removeClass('is-focused');
                    
                    // Add filled class if has value
                    if ($(this).val()) {
                        $(this).closest('.form-group, .form-field').addClass('is-filled');
                    } else {
                        $(this).closest('.form-group, .form-field').removeClass('is-filled');
                    }
                });
            },

            /**
             * Floating labels support
             */
            floatingLabels: function() {
                $('.child-floating-label input, .child-floating-label textarea').each(function() {
                    if ($(this).val()) {
                        $(this).closest('.child-floating-label').addClass('is-filled');
                    }
                });
            }
        },

        /**
         * UI enhancements
         */
        ui: {
            init: function() {
                this.lazyLoadImages();
                this.handleModals();
                this.tooltips();
            },

            /**
             * Lazy load images with native loading
             * Excludes above-the-fold images (hero, logo, critical images)
             */
            lazyLoadImages: function() {
                // Add native lazy loading to images without it
                // Exclude hero images, logos, and images in the header/first section
                var excludeSelectors = [
                    '#header-bar img',
                    '.logo img',
                    '.hero img',
                    '[data-no-lazy]',
                    '.above-fold img'
                ].join(', ');

                $('img:not([loading])').not(excludeSelectors).each(function() {
                    $(this).attr('loading', 'lazy');
                });
            },

            /**
             * Modal handling
             */
            handleModals: function() {
                // Close modal on backdrop click
                $(document).on('click', '.child-modal-backdrop', function() {
                    $(this).closest('.child-modal').fadeOut(StarterChild.config.animationSpeed);
                });

                // Close modal on escape key
                $(document).on('keyup', function(e) {
                    if (e.key === 'Escape') {
                        $('.child-modal:visible').fadeOut(StarterChild.config.animationSpeed);
                    }
                });
            },

            /**
             * Tooltip initialization
             */
            tooltips: function() {
                $('[data-child-tooltip]').each(function() {
                    var $el = $(this);
                    var tooltipText = $el.attr('data-child-tooltip');
                    
                    $el.on('mouseenter focus', function() {
                        var $tooltip = $('<div class="child-tooltip">' + tooltipText + '</div>');
                        $('body').append($tooltip);
                        
                        var offset = $el.offset();
                        $tooltip.css({
                            top: offset.top - $tooltip.outerHeight() - 8,
                            left: offset.left + ($el.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
                        }).fadeIn(150);
                    }).on('mouseleave blur', function() {
                        $('.child-tooltip').remove();
                    });
                });
            }
        },

        /**
         * Utility functions
         */
        utils: {
            /**
             * Debounce function for performance optimization
             * @param {Function} func - Function to debounce
             * @param {number} wait - Wait time in ms
             * @returns {Function} Debounced function
             */
            debounce: function(func, wait) {
                var timeout;
                return function() {
                    var context = this;
                    var args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            },

            /**
             * Throttle function for performance optimization
             * @param {Function} func - Function to throttle
             * @param {number} limit - Throttle limit in ms
             * @returns {Function} Throttled function
             */
            throttle: function(func, limit) {
                var inThrottle;
                return function() {
                    var context = this;
                    var args = arguments;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(function() {
                            inThrottle = false;
                        }, limit);
                    }
                };
            },

            /**
             * Check if element is in viewport
             * @param {jQuery} $el - jQuery element
             * @returns {boolean} True if in viewport
             */
            isInViewport: function($el) {
                var elementTop = $el.offset().top;
                var elementBottom = elementTop + $el.outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                return elementBottom > viewportTop && elementTop < viewportBottom;
            },

            /**
             * Format number with thousands separator
             * @param {number} num - Number to format
             * @returns {string} Formatted number
             */
            formatNumber: function(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },

            /**
             * Get URL parameter
             * @param {string} name - Parameter name
             * @returns {string|null} Parameter value
             */
            getUrlParam: function(name) {
                var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
                return results ? decodeURIComponent(results[1]) : null;
            }
        },

        /**
         * Hooks for plugin/extension integration
         */
        hooks: {
            callbacks: {},

            /**
             * Add a callback to a hook
             * @param {string} hookName - Name of the hook
             * @param {Function} callback - Callback function
             */
            add: function(hookName, callback) {
                if (!this.callbacks[hookName]) {
                    this.callbacks[hookName] = [];
                }
                this.callbacks[hookName].push(callback);
            },

            /**
             * Run all callbacks for a hook
             * @param {string} hookName - Name of the hook
             * @param {*} data - Data to pass to callbacks
             */
            run: function(hookName, data) {
                if (this.callbacks[hookName]) {
                    for (var i = 0; i < this.callbacks[hookName].length; i++) {
                        this.callbacks[hookName][i](data);
                    }
                }
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        StarterChild.init();
    });

    // Expose to global scope for external access
    window.StarterChild = StarterChild;

})(jQuery);
