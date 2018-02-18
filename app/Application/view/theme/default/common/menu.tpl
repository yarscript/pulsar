<?php if ($categories) { ?>
    <div class="bg-primary-darker">
        <section class="content content-full content-boxed ">
            <!-- Top Navigation -->
            <div class="row">
                <ul class="js-nav-main-header nav-main-header">
                    <li class="text-right hidden-md hidden-lg">
                        <button class="btn btn-link text-white" data-toggle="class-toggle"
                                data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </li>
                    <?php foreach ($categories as $category) { ?>
                        <?php if ($category['children']) { ?>
                            <li>
                                <a class="nav-submenu <?php echo $category['active']; ?>" href="javascript:void(0)"><?php echo $category['name']; ?></a>
                                <ul>
                                    <?php foreach ($category['children'] as $child) { ?>
                                        <li><a href="<?php echo $child['href']; ?>" class="<?php echo $child['active']; ?>"><?php echo $child['name']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li><a href="<?php echo $category['href']; ?>" class="<?php echo $category['active']; ?>"><?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <!-- Top Navigation -->
        </section>
    </div>
<?php } ?>
