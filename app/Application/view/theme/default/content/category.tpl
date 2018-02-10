<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url(<?php echo $image; ?>);">
        <div class="bg-primary-dark-op">
            <section class="content content-full content-boxed overflow-hidden">
                <!-- Section Content -->
                <div class="push-100-t push-50 text-center">
                    <h1 class="h2 text-white push-10" data-toggle="appear" data-class="animated fadeInDown"><?php echo $name; ?></h1>
                    <h2 class="h5 text-white-op" data-toggle="appear" data-class="animated fadeInDown"><?php echo $description; ?></h2>
                </div>
                <!-- END Section Content -->
            </section>
        </div>
    </div>
    <!-- END Hero Content -->
    <section class="content content-boxed">
        <div class="row">
            <div class="col-md-2 col-sm-6 hidden-xs">
                <div class="btn-group btn-group-sm">
                    <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                    <button type="button" id="grid-view" class="btn btn-default"><i class="fa fa-th"></i></button>
                </div>
            </div>
        </div>
    </section>
    <!-- List Content -->
    <section class="content content-boxed">
        <!-- Section Content -->
        <div class="push-50-t push-50">
            <div class="row">
                <div id="posts" class="col-sm-8 col-sm-offset-2">
                    <?php foreach ($posts as $post) { ?>
                    <!-- Story -->
                    <div class="post-list push" data-toggle="appear" data-offset="50" data-class="animated fadeIn">
                        <a class="block block-link-hover2" href="<?php echo $post['href']; ?>">
                            <img class="img-responsive hidden-xs" src="<?php echo $post['image']; ?>" alt="">
                            <div class="block-content">
                                <div class="font-s12 push">
                                    <em class="pull-right"><?php echo $post['ago']; ?></em>
                                    <span class="text-primary"><?php echo $post['author']; ?></span> on <?php echo $post['date']; ?>
                                </div>
                                <h4 class="push-10"><?php echo $post['name']; ?></h4>
                            <p><?php echo $post['description']; ?></p>
                            </div>
                        </a>
                    </div>
                    <!-- END Story -->
                    <?php } ?>
                </div>
            </div>
            <!-- Pagination -->
            <?php echo $pagination; ?>
            <?php echo $results; ?>
            <!-- END Pagination -->
        </div>
        <!-- END Section Content -->
    </section>
    <!-- END List Content -->
    <!-- Get Started -->
    <div class="bg-primary-dark">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="push-20-t push-20 text-center">
                <h3 class="h4 text-white-op push-20 " data-toggle="appear">Do you like our stories? Sign up today and get access to over <strong>10.000</strong> travel stories!</h3>
                <a class="btn btn-rounded btn-noborder btn-lg btn-success" data-toggle="appear" data-class="animated bounceIn" href="frontend_pricing.html">Get Started Today</a>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    <!-- END Get Started -->
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
