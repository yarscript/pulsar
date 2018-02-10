<!DOCTYPE html>
<html class="no-focus" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
    <base href="/">
<!--    <base href="--><?php //echo $base; ?><!--" />-->
    <meta charset="utf-8">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $meta_title; ?></title>
    <?php if($meta_description) { ?>
    <meta name="description" content="<?php echo $meta_description; ?>" />
    <?php } ?>
    <?php if($meta_keywords) { ?>
    <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
    <?php } ?>


    <!-- Icons -->
    <link rel="shortcut icon" href="img/favicons/favicon.png">
    <!-- END Icons -->

    <!-- Web fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
    <!-- END Web fonts -->

    <!-- Stylesheets -->
    <?php foreach ($styles as $style) { ?>
        <link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>"/>
    <?php } ?>
    <?php foreach ($links as $link) { ?>
        <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>
    <!-- OneUI CSS framework -->
    <link rel="stylesheet" id="css-main" href="css/app.css">

    <?php if ($theme) { ?>
        <link rel="stylesheet" id="css-theme" href="css/themes/<?php echo $theme; ?>.min.css">
    <?php } ?>
    <!-- END Stylesheets -->

    <script type="text/javascript" src="vendor/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="vendor/jquery-ui/jquery-ui.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/dist/js/bootstrap.js"></script>

    <?php foreach ($scripts as $script) { ?>
        <script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>

    <?php foreach ($analytics as $analytic) { ?>
    <?php echo $analytic; ?>
    <?php } ?>
</head>
<body>
<!-- Page Container -->
<!--
    Available Classes:

    'enable-cookies'             Remembers active color theme between pages (when set through color theme list)
-->
<div id="page-container" class="side-scroll header-navbar-fixed header-navbar-transparent enable-cookies">
<!--<div id="page-container" class="--><?php //echo $page_classes; ?><!--">-->

    <!-- Header -->
    <header id="header-navbar" class="content-mini content-mini-full" >
        <div class="content-boxed">
            <!-- Header Navigation Right -->
            <ul class="nav-header pull-right">
                <li>
                    <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                    <div class="btn-group">
                        <button class="btn btn-link text-white dropdown-toggle" data-toggle="dropdown" type="button">
                            <i class="fa fa-tint"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right sidebar-mini-hide font-s13">
                            <li>
                                <a data-toggle="theme" data-theme="default" tabindex="-1" href="javascript:void(0)">
                                    <i class="fa fa-circle text-default pull-right"></i> <span class="font-w600">Default</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="theme" data-theme="css/themes/amethyst.min.css" tabindex="-1" href="javascript:void(0)">
                                    <i class="fa fa-circle text-amethyst pull-right"></i> <span class="font-w600">Amethyst</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="theme" data-theme="css/themes/city.min.css" tabindex="-1" href="javascript:void(0)">
                                    <i class="fa fa-circle text-city pull-right"></i> <span class="font-w600">City</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="theme" data-theme="css/themes/flat.min.css" tabindex="-1" href="javascript:void(0)">
                                    <i class="fa fa-circle text-flat pull-right"></i> <span class="font-w600">Flat</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="theme" data-theme="css/themes/modern.min.css" tabindex="-1" href="javascript:void(0)">
                                    <i class="fa fa-circle text-modern pull-right"></i> <span class="font-w600">Modern</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="theme" data-theme="css/themes/smooth.min.css" tabindex="-1" href="javascript:void(0)">
                                    <i class="fa fa-circle text-smooth pull-right"></i> <span class="font-w600">Smooth</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="hidden-md hidden-lg">
                    <!-- Toggle class helper (for main header navigation below in small screens), functionality initialized in App() -> uiToggleClass() -->
                    <button class="btn btn-link text-white pull-right" data-toggle="class-toggle" data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
                        <i class="fa fa-navicon"></i>
                    </button>
                </li>
            </ul>
            <!-- END Header Navigation Right -->

            <!-- Language -->
            <?php echo $language; ?>
            <!-- END Language -->

            <!-- Main Header Navigation -->
            <ul class="js-nav-main-header nav-main-header pull-right">
                <li class="text-right hidden-md hidden-lg">
                    <!-- Toggle class helper (for main header navigation in small screens), functionality initialized in App() -> uiToggleClass() -->
                    <button class="btn btn-link text-white" data-toggle="class-toggle" data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </li>
                <?php foreach ($pages as $page) { ?>
                    <?php if ($page['children']) { ?>
                        <li>
                            <a class="nav-submenu" href="javascript:void(0)"><?php echo $page['name']; ?></a>
                            <ul>
                                <?php foreach ($page['children'] as $child) { ?>
                                    <li><a href="<?php echo $child['href']; ?>" class="<?php echo $child['active']; ?>"><?php echo $child['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li><a href="<?php echo $page['href']; ?>" class="<?php echo $page['active']; ?>"><?php echo $page['name']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <!-- END Main Header Navigation -->

            <!-- Header Navigation Left -->
            <ul class="nav-header pull-left">
                <li class="header-content">
                    <a class="h4" href="<?php echo $home; ?>">
                        <i class="fa fa-bullseye text-primary"></i> <span class="h4 font-w600 text-white"><?php echo $name; ?></span>
                    </a>
                </li>
            </ul>
            <!-- END Header Navigation Left -->
        </div>
    </header>
    <!-- END Header -->
