$(document).ready(function () {
    // Set last page opened on the menu
    $('#menu a[href]').on('click', function () {
        sessionStorage.setItem('menu', $(this).attr('href'));
    });

    if (location.href !== sessionStorage.getItem('menu')) {
        sessionStorage.removeItem('menu');
    }

    if (!sessionStorage.getItem('menu')) {
        $('#menu-dashboard a').addClass('active');
    } else {
        $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').addClass('active').parents("li").addClass('open');
    }

});

// App
var App = function () {

    var $html,
        $body,
        $page,
        $sidebar,
        $sidebarScroll,
        $header,
        $main,
        $footer;

    var init = function () {
        // Set variables
        $html = jQuery('html');
        $body = jQuery('body');
        $page = jQuery('#page-container');
        $sidebar = jQuery('#sidebar');
        $sidebarScroll = jQuery('#sidebar-scroll');
        $header = jQuery('#header-navbar');
        $main = jQuery('#main-container');
        $footer = jQuery('#page-footer');

        // Initialize Tooltips
        jQuery('[data-toggle="tooltip"], .js-tooltip').tooltip({
            container: 'body',
            animation: false
        });

        // Initialize Popovers
        jQuery('[data-toggle="popover"], .js-popover').popover({
            container: 'body',
            animation: true,
            trigger: 'hover'
        });

        jQuery('[data-toggle="scroll-to"]').on('click', function () {
            var $this = jQuery(this);
            var $target = $this.data('target');
            var $speed = $this.data('speed') ? $this.data('speed') : 1000;

            jQuery('html, body').animate({
                scrollTop: jQuery($target).offset().top
            }, $speed);
        });

        jQuery('[data-toggle="class-toggle"]').on('click', function () {
            var $el = jQuery(this);

            jQuery($el.data('target').toString()).toggleClass($el.data('class').toString());

            if ($html.hasClass('no-focus')) {
                $el.blur();
            }
        });

        // When a submenu link is clicked
        jQuery('[data-toggle="nav-submenu"]').on('click', function (e) {
            // Stop default behaviour
            e.stopPropagation();

            // Get link
            var $link = jQuery(this);

            // Get link's parent
            var $parentLi = $link.parent('li');

            if ($parentLi.hasClass('open')) { // If submenu is open, close it..
                $parentLi.removeClass('open');
            } else { // .. else if submenu is closed, close all other (same level) submenus first before open it
                $link
                    .closest('ul')
                    .find('> li')
                    .removeClass('open');

                $parentLi
                    .addClass('open');
            }

            // Remove focus from submenu link
            if ($html.hasClass('no-focus')) {
                $link.blur();
            }
        });


        // Resizes #main-container min height (push footer to the bottom)
        var $resizeTimeout;

        if ($main.length) {
            main();

            jQuery(window).on('resize orientationchange', function () {
                clearTimeout($resizeTimeout);

                $resizeTimeout = setTimeout(function () {
                    main();
                }, 150);
            });
        }

        // Init sidebar and side overlay custom scrolling
        //uiHandleScroll('init');

        // Init transparent header functionality (solid on scroll - used in frontend)
        if ($page.hasClass('header-navbar-fixed') && $page.hasClass('header-navbar-transparent')) {
            jQuery(window).on('scroll', function () {
                if (jQuery(this).scrollTop() > 20) {
                    $page.addClass('header-navbar-scroll');
                } else {
                    $page.removeClass('header-navbar-scroll');
                }
            });
        }

        // Call layout API on button click
        jQuery('[data-toggle="layout"]').on('click', function () {
            var $btn = jQuery(this);

            layout($btn.data('action'));

            if ($html.hasClass('no-focus')) {
                $btn.blur();
            }
        });


        jQuery('[data-toggle="appear"]').each(function () {
            var $window = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            var $this = jQuery(this);
            var $class = $this.data('class') ? $this.data('class') : 'animated fadeIn';
            var $offset = $this.data('offset') ? $this.data('offset') : 0;
            var $timeout = ($html.hasClass('ie9') || $window < 992) ? 0 : ($this.data('timeout') ? $this.data('timeout') : 0);

            $this.appear(function () {
                setTimeout(function () {
                    $this
                        .removeClass('visibility-hidden')
                        .addClass($class);
                }, $timeout);
            }, {accY: $offset});
        });


    };

    var main = function () {
        var $window = jQuery(window).height();
        var $headerHeight = $header.outerHeight();
        var $footerHeight = $footer.outerHeight();

        if ($page.hasClass('header-navbar-fixed')) {
            $main.css('min-height', $window - $footerHeight);
        } else {
            $main.css('min-height', $window - ($headerHeight + $footerHeight));
        }
    };

    var layout = function ($mode) {
        var $width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

        // Mode selection
        switch ($mode) {
            case 'sidebar_pos_toggle':
                $page.toggleClass('sidebar-l sidebar-r');
                break;
            case 'sidebar_pos_left':
                $page
                    .removeClass('sidebar-r')
                    .addClass('sidebar-l');
                break;
            case 'sidebar_pos_right':
                $page
                    .removeClass('sidebar-l')
                    .addClass('sidebar-r');
                break;
            case 'sidebar_toggle':
                if ($width > 991) {
                    $page.toggleClass('sidebar-o');
                } else {
                    $page.toggleClass('sidebar-o-xs');
                }
                break;
            case 'sidebar_open':
                if ($width > 991) {
                    $page.addClass('sidebar-o');
                } else {
                    $page.addClass('sidebar-o-xs');
                }
                break;
            case 'sidebar_close':
                if ($width > 991) {
                    $page.removeClass('sidebar-o');
                } else {
                    $page.removeClass('sidebar-o-xs');
                }
                break;
            case 'sidebar_mini_toggle':
                if ($width > 991) {
                    $page.toggleClass('sidebar-mini');
                }
                break;
            case 'sidebar_mini_on':
                if ($width > 991) {
                    $page.addClass('sidebar-mini');
                }
                break;
            case 'sidebar_mini_off':
                if ($width > 991) {
                    $page.removeClass('sidebar-mini');
                }
                break;
            case 'side_overlay_toggle':
                $page.toggleClass('side-overlay-o');
                break;
            case 'side_overlay_open':
                $page.addClass('side-overlay-o');
                break;
            case 'side_overlay_close':
                $page.removeClass('side-overlay-o');
                break;
            case 'side_overlay_hoverable_toggle':
                $page.toggleClass('side-overlay-hover');
                break;
            case 'side_overlay_hoverable_on':
                $page.addClass('side-overlay-hover');
                break;
            case 'side_overlay_hoverable_off':
                $page.removeClass('side-overlay-hover');
                break;
            case 'header_fixed_toggle':
                $page.toggleClass('header-navbar-fixed');
                break;
            case 'header_fixed_on':
                $page.addClass('header-navbar-fixed');
                break;
            case 'header_fixed_off':
                $page.removeClass('header-navbar-fixed');
                break;
            default:
                return false;
        }
    };

    var theme = function () {
        var $cssTheme = jQuery('#css-theme');

        // Set the active color theme link as active
        jQuery('[data-toggle="theme"][data-theme="' + ($cssTheme.length ? $cssTheme.attr('href') : 'default') + '"]')
            .parent('li')
            .addClass('active');

        // When a color theme link is clicked
        jQuery('[data-toggle="theme"]').on('click', function () {
            var $this = jQuery(this);
            var $theme = $this.data('theme');

            // Set this color theme link as active
            jQuery('[data-toggle="theme"]')
                .parent('li')
                .removeClass('active');

            jQuery('[data-toggle="theme"][data-theme="' + $theme + '"]')
                .parent('li')
                .addClass('active');

            // Update color theme
            if ($theme === 'default') {
                if ($cssTheme.length) {
                    $cssTheme.remove();
                }
            } else {
                if ($cssTheme.length) {
                    $cssTheme.attr('href', $theme);
                } else {
                    jQuery('#css-main')
                        .after('<link rel="stylesheet" id="css-theme" href="' + $theme + '">');
                }
            }

            $cssTheme = jQuery('#css-theme');
        });
    };

    return {
        init: function ($mode) {
            // Init all vital functions
            init();
            main();
            theme();
            layout($mode);
        }
    };
}();

// Initialize app when page loads
jQuery(function () {
    App.init();
});



$(document).ready(function () {
    // Language
    $('#form-language .language-select').on('click', function (e) {
        e.preventDefault();
        $('#form-language input[name=\'code\']').val($(this).attr('name'));
        $('#form-language').submit();
    });

    // List
    $('#list-view').click(function () {
        console.log('#list-view');
        $('#posts').addClass('col-sm-8 col-sm-offset-2');
        $('#posts > .post-grid').attr('class', 'post-list push');
        $('#grid-view').removeClass('active');
        $('#list-view').addClass('active');
        localStorage.setItem('display', 'list');
    });

    // Grid
    $('#grid-view').click(function () {
        var cols = $('#column-right, #column-left').length;
        $('#posts').removeClass('col-sm-8 col-sm-offset-2');
        $('#posts > .post-list').attr('class', 'post-grid col-md-4');
        $('#list-view').removeClass('active');
        $('#grid-view').addClass('active');
        localStorage.setItem('display', 'grid');
    });

    // List/Grid Storage
    if (localStorage.getItem('display') === 'list') {
        $('#list-view').trigger('click').addClass('active');
    } else {
        $('#grid-view').trigger('click').addClass('active');
    }
});
