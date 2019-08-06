
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
        $html = jQuery('html');
        $body = jQuery('body');
        $page = jQuery('#page-container');
        $sidebar = jQuery('#sidebar');
        $sidebarScroll = jQuery('#sidebar-scroll');
        $header = jQuery('#header-navbar');
        $main = jQuery('#main-container');
        $footer = jQuery('#page-footer');

        /**  Tooltips */
        jQuery('[data-toggle="tooltip"], .tooltip').tooltip({
            container: 'body',
            animation: false
        });

        /**  Popovers */
        jQuery('[data-toggle="popover"], .popover').popover({
            container: 'body',
            animation: true,
            trigger: 'hover'
        });

        /** Tabs */
        jQuery('[data-toggle="tabs"] a, .tabs a').click(function (e) {
            e.preventDefault();
            jQuery(this).tab('show');
        });
    };

    var nav = function () {
        jQuery('[data-toggle="nav-submenu"]').on('click', function (e) {
            e.stopPropagation();

            var $link = jQuery(this);
            var $parent = $link.parent('li');

            if ($parent.hasClass('open')) {
                $parent.removeClass('open');
            } else {
                $link.closest('ul').find('> li').removeClass('open');
                $parent.addClass('open');
            }

            if ($html.hasClass('no-focus')) {
                $link.blur();
            }
        });
    };

    var datepicker = function () {
        jQuery('.datepicker').add('.input-daterange').datepicker({
            weekStart: 1,
            autoclose: true,
            todayHighlight: true
        });
    };

    var alert = function () {
        $(".swal").on("click", function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d26a5c",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: false
            }, function () {
                document.forms.form.submit();
            });
        });
    };

    var layout = function () {

        var $windowHeight = jQuery(window).height();
        var $headerHeight = $header.outerHeight();
        var $footerHeight = $footer.outerHeight();

        if ($page.hasClass('header-navbar-fixed')) {
            $main.css('min-height', $windowHeight - $footerHeight);
        } else {
            $main.css('min-height', $windowHeight - ($headerHeight + $footerHeight));
        }

        if ($page.hasClass('header-navbar-fixed') && $page.hasClass('header-navbar-transparent')) {
            jQuery(window).on('scroll', function () {
                if (jQuery(this).scrollTop() > 20) {
                    $page.addClass('header-navbar-scroll');
                } else {
                    $page.removeClass('header-navbar-scroll');
                }
            });
        }

        /** Sidebar */
        jQuery('[data-toggle="layout"]').on('click', function () {
            var $btn = jQuery(this);

            layout($btn.data('action'));

            if ($html.hasClass('no-focus')) {
                $btn.blur();
            }
        });

        /** Layout */
        var layout = function ($mode) {
            var $width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            // Mode selection
            switch ($mode) {
                case 'sidebar_pos_toggle':
                    $page.toggleClass('sidebar-l sidebar-r');
                    break;
                case 'sidebar_pos_left':
                    $page.removeClass('sidebar-r').addClass('sidebar-l');
                    break;
                case 'sidebar_pos_right':
                    $page.removeClass('sidebar-l').addClass('sidebar-r');
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
    };

    var form = function () {
        jQuery('.form-material.floating > .form-control').each(function () {
            var $input = jQuery(this);
            var $parent = $input.parent('.form-material');

                if ($input.val()) {
                    $parent.addClass('open');
                }

            $input.on('change', function () {
                if ($input.val()) {
                    $parent.addClass('open');
                } else {
                    $parent.removeClass('open');
                }
            });
        });

        jQuery('.validation').validate({
            ignore: [],
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function (error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function (e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error').addClass('has-error');
                elem.closest('.help-block').remove();
            },
            success: function (e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error');
                elem.closest('.help-block').remove();
            }
        });
    };

    var table = function () {
        jQuery('.table-checkable').each(function () {
            var $table = jQuery(this);

            jQuery('thead input:checkbox', $table).on('click', function () {
                var $checkedStatus = jQuery(this).prop('checked');

                jQuery('tbody input:checkbox', $table).each(function () {
                    var $checkbox = jQuery(this);

                    $checkbox.prop('checked', $checkedStatus);
                    checkRow($checkbox, $checkedStatus);
                });
            });

            jQuery('tbody input:checkbox', $table).on('click', function () {
                var $checkbox = jQuery(this);

                checkRow($checkbox, $checkbox.prop('checked'));
            });

            jQuery('tbody > tr', $table).on('click', function (e) {
                if (e.target.type !== 'checkbox'
                    && e.target.type !== 'button'
                    && e.target.tagName.toLowerCase() !== 'a'
                    && !jQuery(e.target).parent('label').length) {
                    var $checkbox = jQuery('input:checkbox', this);
                    var $checkedStatus = $checkbox.prop('checked');

                    $checkbox.prop('checked', !$checkedStatus);
                    checkRow($checkbox, !$checkedStatus);
                }
            });

            var checkRow = function ($checkbox, $checkedStatus) {
                if ($checkedStatus) {
                    $checkbox
                        .closest('tr')
                        .addClass('active');
                } else {
                    $checkbox
                        .closest('tr')
                        .removeClass('active');
                }
            };
        });
    };

    var scroll = function () {
        jQuery('[data-toggle="scroll-to"]').on('click', function () {
            var $this = jQuery(this);
            var $target = $this.data('target');
            var $speed = $this.data('speed') ? $this.data('speed') : 1000;

            jQuery('html, body').animate({
                scrollTop: jQuery($target).offset().top
            }, $speed);
        });
    };

    var select = function () {
        jQuery('.select2').select2();
    };

    var tags = function () {
        jQuery('.tags-input').tagsInput({
            height: '36px',
            width: '100%',
            defaultText: 'Add tag',
            removeWithBackspace: true,
            delimiter: [',']
        });
    };

    var summernote = function () {
        // Text editor in air mode (inline)
        jQuery('.summernote-air').summernote({
            airMode: true
        });

        // Full text editor
        jQuery('.summernote').summernote({
            height: 350,
            minHeight: null,
            maxHeight: null
        });
    };

    var appear = function () {
        // Add a specific class on elements (when they become visible on scrolling)
        jQuery('[data-toggle="appear"]').each(function () {
            // var $windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            var $this = jQuery(this);
            var $class = $this.data('class') ? $this.data('class') : 'animated fadeIn';
            var $offset = $this.data('offset') ? $this.data('offset') : 0;
            //var $timeout = ($html.hasClass('ie9') || $windowWidth < 992) ? 0 : ($this.data('timeout') ? $this.data('timeout') : 0);

            // $this.appear(function () {
            //     setTimeout(function () {
            //         $this
            //             .removeClass('visibility-hidden')
            //             .addClass($class);
            //     }, $timeout);
            // }, {accY: $offset});

            $this.appear(function () {
                $this.removeClass('visibility-hidden').addClass($class);
            }, {accY: $offset});
        });
    };

    var loader = function ($mode) {
        var $pageLoader = jQuery('#page-loader');

        if ($mode === 'show') {
            if ($pageLoader.length) {
                $pageLoader.fadeIn(250);
            } else {
                $body.prepend('<div id="page-loader"></div>');
            }
        } else if ($mode === 'hide') {
            if ($pageLoader.length) {
                $pageLoader.fadeOut(250);
            }
        }

        return false;
    };

    var toggle = function () {
        jQuery('[data-toggle="class-toggle"]').on('click', function () {
            var $el = jQuery(this);

            jQuery($el.data('target').toString()).toggleClass($el.data('class').toString());

            if ($html.hasClass('no-focus')) {
                $el.blur();
            }
        });
    };

    var theme = function () {
        var $cssTheme = jQuery('#css-theme');
        var $cookies = $page.hasClass('enable-cookies') ? true : false;

        // If cookies are enabled
        if ($cookies) {
            var $theme = Cookies.get('colorTheme') ? Cookies.get('colorTheme') : false;

            // Update color theme
            if ($theme) {
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
            }

            $cssTheme = jQuery('#css-theme');
        }

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

            // If cookies are enabled, save the new active color theme
            if ($cookies) {
                Cookies.set('colorTheme', $theme, {expires: 7});
            }
        });
    };

    return {
        init: function ($func) {
            switch ($func) {
                case 'init':
                    init();
                    break;
                case 'layout':
                    layout();
                    break;
                case 'nav':
                    nav();
                    break;
                case 'form':
                    form();
                    break;
                case 'theme':
                    theme();
                    break;
                case 'toggle':
                    toggle();
                    break;
                case 'scroll':
                    scroll();
                    break;
                case 'loader':
                    loader('hide');
                    break;
                default:
                    init();
                    layout();
                    nav();
                    form();
                    theme();
                    toggle();
                    scroll();
                    loader('hide');
            }
        },
        loader: function ($mode) {
            loader($mode);
        },
        vendor: function ($vendor) {
            switch ($vendor) {
                case 'table':
                    table();
                    break;
                case 'appear':
                    appear();
                    break;
                case 'summernote':
                    summernote();
                    break;
                case 'datepicker':
                    datepicker();
                    break;
                case 'tags':
                    tags();
                    break;
                case 'select':
                    select();
                    break;
                case 'alert':
                    alert();
                    break;
                default:
                    return false;
            }
        },
        vendors: function ($vendors) {
            if ($vendors instanceof Array) {
                for (var $index in $vendors) {
                    App.vendor($vendors[$index]);
                }
            } else {
                App.vendor($vendors);
            }
        }
    };
}();

// Initialize app when page loads
jQuery(function () {
    App.init();
});


