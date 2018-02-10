<!DOCTYPE html>
<html class="no-focus" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
    <base href="/">
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

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
    <link rel="stylesheet" id="css-main" href="css/admin.app.css">

    <?php if ($theme) { ?>
        <link rel="stylesheet" id="css-theme" href="css/themes/<?php echo $theme; ?>.min.css">
    <?php } ?>
    <!-- END Stylesheets -->

    <script type="text/javascript" src="vendor/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="vendor/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="vendor/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <script type="text/javascript" src="vendor/select2/dist/js/select2.js"></script>
    <script type="text/javascript" src="vendor/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="vendor/summernote/dist/summernote.js"></script>
    <script type="text/javascript" src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <?php foreach ($scripts as $script) { ?>
        <script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>
</head>
<body>

<!-- Page Container -->
<div id="page-container" class="<?php echo $page_classes; ?>">
<?php echo $sidebar; ?>
    <!-- Header -->
    <header id="header-navbar" class="content-mini content-mini-full">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right">
            <li>
                <div class="btn-group">
                    <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                        <img src="<?php echo $image ?>">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a tabindex="-1" href="<?php echo $profile; ?>"><i class="fa fa-user-circle-o pull-right"></i><?php echo $text_profile; ?></a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo $front; ?>"><i class="fa fa-desktop pull-right"></i><?php echo $text_front; ?></a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo $logout; ?>"><i class="fa fa-sign-out pull-right"></i><?php echo $text_logout; ?></a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- END Header Navigation Right -->
        <!-- Header Navigation Left -->
        <ul class="nav-header pull-left">
            <li class="hidden-md hidden-lg">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                    <i class="fa fa-navicon"></i>
                </button>
            </li>
            <li class="hidden-xs hidden-sm">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
            </li>
        </ul>
        <!-- END Header Navigation Left -->
    </header>
    <!-- END Header -->
