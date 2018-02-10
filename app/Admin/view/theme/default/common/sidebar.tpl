<!-- Sidebar -->
<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="side-header side-content bg-white-op">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button"
                        data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                <div class="btn-group pull-right">
                    <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button">
                        <i class="fa fa-tint"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right font-s13 sidebar-mini-hide">
                        <li>
                            <a data-toggle="theme" data-theme="default" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-default pull-right"></i> <span
                                        class="font-w600">Default</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="css/themes/amethyst.min.css" tabindex="-1"
                               href="javascript:void(0)">
                                <i class="fa fa-circle text-amethyst pull-right"></i> <span
                                        class="font-w600">Amethyst</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="css/themes/city.min.css" tabindex="-1"
                               href="javascript:void(0)">
                                <i class="fa fa-circle text-city pull-right"></i> <span
                                        class="font-w600">City</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="css/themes/flat.min.css" tabindex="-1"
                               href="javascript:void(0)">
                                <i class="fa fa-circle text-flat pull-right"></i> <span
                                        class="font-w600">Flat</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="css/themes/modern.min.css" tabindex="-1"
                               href="javascript:void(0)">
                                <i class="fa fa-circle text-modern pull-right"></i> <span
                                        class="font-w600">Modern</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="css/themes/smooth.min.css" tabindex="-1"
                               href="javascript:void(0)">
                                <i class="fa fa-circle text-smooth te pull-right"></i> <span
                                        class="font-w600">Smooth</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="h4 text-white" href="<?php echo $dashboard; ?>">
                    <i class="fa fa-bullseye text-primary"></i>
                    <span class="h4 font-w600 sidebar-mini-hide">Pulsar</span>
                </a>
            </div>
            <!-- END Side Header -->
            <!-- Side Content -->
            <div class="side-content">
                <ul id="menu" class="nav-main">
                    <?php foreach ($menus as $menu) { ?>
                        <?php if (!$menu['id']) { ?>
                            <li class="nav-main-heading">
                                <span class="sidebar-mini-hide"> <?php echo $menu['name']; ?></span>
                            </li>
                        <?php } else { ?>
                            <li id="<?php echo $menu['id']; ?>">
                                <?php if ($menu['href']) { ?>
                                    <a href="<?php echo $menu['href']; ?>">
                                        <i class="<?php echo $menu['icon']; ?>"></i>
                                        <span class="sidebar-mini-hide"> <?php echo $menu['name']; ?></span>
                                    </a>
                                <?php } else { ?>
                                    <a class="nav-submenu" data-toggle="nav-submenu">
                                        <i class="<?php echo $menu['icon']; ?>"></i>
                                        <span class="sidebar-mini-hide"> <?php echo $menu['name']; ?></span>
                                    </a>
                                <?php } ?>
                                <?php if ($menu['children']) { ?>
                                    <ul>
                                        <?php foreach ($menu['children'] as $children_1) { ?>
                                            <li>
                                                <?php if ($children_1['href']) { ?>
                                                    <a href="<?php echo $children_1['href']; ?>"><?php echo $children_1['name']; ?></a>
                                                <?php } else { ?>
                                                    <a><?php echo $children_1['name']; ?></a>
                                                <?php } ?>
                                                <?php if ($children_1['children']) { ?>
                                                    <ul>
                                                        <?php foreach ($children_1['children'] as $children_2) { ?>
                                                            <li>
                                                                <?php if ($children_2['href']) { ?>
                                                                    <a href="<?php echo $children_2['href']; ?>"><?php echo $children_2['name']; ?></a>
                                                                <?php } else { ?>
                                                                    <a class="nav-submenu" data-toggle="nav-submenu">
                                                                        <?php echo $children_2['name']; ?>
                                                                    </a>
                                                                <?php } ?>
                                                                <?php if ($children_2['children']) { ?>
                                                                    <ul>
                                                                        <?php foreach ($children_2['children'] as $children_3) { ?>
                                                                            <li>
                                                                                <a href="<?php echo $children_3['href']; ?>"><?php echo $children_3['name']; ?></a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                <?php } ?>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->

