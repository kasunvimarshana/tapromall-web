/**
 * Starter Child Theme JavaScript
 * 
 * This file contains all custom JavaScript for the Starter Child theme.
 * All code is scoped within an IIFE to avoid global namespace pollution.
 * 
 * @package   StarterChild
 * @author    TaproMall Team
 * @version   1.0.0
 */

(function($) {
    'use strict';

    /**
     * Starter Child Theme Module
     * 
     * Main module pattern for organizing theme JavaScript.
     * Follows clean code principles and single responsibility.
     */
    const StarterChild = {

        /**
         * Configuration object
         */
        config: {
            version: '1.0.0',
            debug: false,
            selectors: {
                body: 'body',
                header: 'header',
                footer: 'footer',
                navigation: '.navigation',
                searchForm: '.search-form'
            }
        },

        /**
         * Initialize the theme
         * 
         * Called when DOM is ready. Sets up all event handlers
         * and initializes components.
         * 
         * @return {void}
         */
        init: function() {
            this.log('Initializing Starter Child Theme...');
            
            // Initialize components
            this.accessibility.init();
            this.navigation.init();
            this.forms.init();
            this.utilities.init();
            
            // Trigger custom init event
            $(document).trigger('starterChildInit');
            
            this.log('Starter Child Theme initialized successfully.');
        },

        /**
         * Accessibility enhancements
         */
        accessibility: {
            
            /**
             * Initialize accessibility features
             * 
             * @return {void}
             */
            init: function() {
                this.skipLink();
                this.keyboardNavigation();
                this.ariaLabels();
            },

            /**
             * Enhance skip to content link
             * 
             * @return {void}
             */
            skipLink: function() {
                const $skipLink = $('.starter-child-skip-link');
                
                if ($skipLink.length) {
                    $skipLink.on('click', function(e) {
                        const target = $(this).attr('href');
                        $(target).attr('tabindex', '-1').focus();
                    });
                }
            },

            /**
             * Enhance keyboard navigation
             * 
             * @return {void}
             */
            keyboardNavigation: function() {
                // Add keyboard navigation enhancements here
                $('a, button').on('keydown', function(e) {
                    // Handle Enter and Space keys
                    if (e.key === 'Enter' || e.key === ' ') {
                        $(this).trigger('click');
                    }
                });
            },

            /**
             * Add/update ARIA labels
             * 
             * @return {void}
             */
            ariaLabels: function() {
                // Ensure all interactive elements have proper ARIA labels
                $('[role="button"]').each(function() {
                    if (!$(this).attr('aria-label') && !$(this).text()) {
                        StarterChild.log('Warning: Button without label found', this);
                    }
                });
            }
        },

        /**
         * Navigation enhancements
         */
        navigation: {
            
            /**
             * Initialize navigation
             * 
             * @return {void}
             */
            init: function() {
                this.mobileMenu();
                this.smoothScroll();
            },

            /**
             * Mobile menu functionality
             * 
             * @return {void}
             */
            mobileMenu: function() {
                const $menuToggle = $('.menu-toggle, .mobile-menu-toggle');
                const $menu = $('.main-navigation, .primary-navigation');
                
                $menuToggle.on('click', function(e) {
                    e.preventDefault();
                    $(this).toggleClass('active');
                    $menu.toggleClass('active');
                    
                    // Update ARIA expanded state
                    const isExpanded = $(this).hasClass('active');
                    $(this).attr('aria-expanded', isExpanded);
                });
            },

            /**
             * Smooth scroll for anchor links
             * 
             * @return {void}
             */
            smoothScroll: function() {
                $('a[href^="#"]').on('click', function(e) {
                    const href = $(this).attr('href');
                    
                    // Ignore empty anchors and skip links
                    if (href === '#' || href === '#content') {
                        return;
                    }
                    
                    const $target = $(href);
                    
                    if ($target.length) {
                        e.preventDefault();
                        
                        $('html, body').animate({
                            scrollTop: $target.offset().top - 100
                        }, 500, function() {
                            // Update focus for accessibility
                            $target.attr('tabindex', '-1').focus();
                        });
                    }
                });
            }
        },

        /**
         * Form enhancements
         */
        forms: {
            
            /**
             * Initialize form enhancements
             * 
             * @return {void}
             */
            init: function() {
                this.validation();
                this.searchForm();
            },

            /**
             * Client-side form validation
             * 
             * @return {void}
             */
            validation: function() {
                // Add custom validation logic here
                $('form').on('submit', function(e) {
                    const $form = $(this);
                    const $requiredFields = $form.find('[required]');
                    let isValid = true;
                    
                    $requiredFields.each(function() {
                        const $field = $(this);
                        if (!$field.val()) {
                            isValid = false;
                            $field.addClass('error');
                        } else {
                            $field.removeClass('error');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        StarterChild.log('Form validation failed');
                    }
                });
            },

            /**
             * Search form enhancements
             * 
             * @return {void}
             */
            searchForm: function() {
                const $searchForm = $('.search-form');
                const $searchInput = $searchForm.find('input[type="search"], input[type="text"]');
                
                // Add placeholder text if not present
                if ($searchInput.length && !$searchInput.attr('placeholder')) {
                    $searchInput.attr('placeholder', 'Search...');
                }
                
                // Clear button functionality
                $searchInput.on('input', function() {
                    const $clearBtn = $(this).siblings('.clear-search');
                    if ($(this).val()) {
                        $clearBtn.show();
                    } else {
                        $clearBtn.hide();
                    }
                });
            }
        },

        /**
         * Utility functions
         */
        utilities: {
            
            /**
             * Initialize utilities
             * 
             * @return {void}
             */
            init: function() {
                this.lazyLoad();
                this.externalLinks();
                this.printStyles();
            },

            /**
             * Lazy load images
             * 
             * @return {void}
             */
            lazyLoad: function() {
                // Check if browser supports IntersectionObserver
                if ('IntersectionObserver' in window) {
                    const imageObserver = new IntersectionObserver((entries, observer) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const img = entry.target;
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        });
                    });
                    
                    document.querySelectorAll('img.lazy').forEach(img => {
                        imageObserver.observe(img);
                    });
                } else {
                    // Fallback for browsers without IntersectionObserver
                    $('.lazy').each(function() {
                        $(this).attr('src', $(this).data('src')).removeClass('lazy');
                    });
                }
            },

            /**
             * Handle external links
             * 
             * @return {void}
             */
            externalLinks: function() {
                $('a[href^="http"]').not('[href*="' + window.location.hostname + '"]').each(function() {
                    $(this).attr({
                        'target': '_blank',
                        'rel': 'noopener noreferrer'
                    });
                    
                    // Add screen reader text
                    if (!$(this).find('.sr-only').length) {
                        $(this).append('<span class="starter-child-sr-only"> (opens in new tab)</span>');
                    }
                });
            },

            /**
             * Print functionality
             * 
             * @return {void}
             */
            printStyles: function() {
                $('.print-page').on('click', function(e) {
                    e.preventDefault();
                    window.print();
                });
            }
        },

        /**
         * Logging utility
         * 
         * Logs messages to console when debug mode is enabled.
         * 
         * @param {string} message - The message to log
         * @param {*} data - Optional data to log
         * @return {void}
         */
        log: function(message, data) {
            if (this.config.debug && window.console) {
                console.log('[Starter Child]', message);
                if (data !== undefined) {
                    console.log(data);
                }
            }
        }
    };

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        StarterChild.init();
    });

    /**
     * Expose StarterChild to global scope for extensibility
     */
    window.StarterChild = StarterChild;

})(jQuery);

/**
 * Additional jQuery plugins or standalone functions can be added below
 */

/**
 * Example: Custom jQuery plugin
 * 
 * Usage: $('.element').starterChildPlugin();
 */
/*
(function($) {
    $.fn.starterChildPlugin = function(options) {
        const settings = $.extend({
            // Default settings
            option1: true,
            option2: 'value'
        }, options);

        return this.each(function() {
            // Plugin logic here
        });
    };
})(jQuery);
*/
