<?php echo $header; ?>
    <!-- Main Container -->
    <main id="main-container">
        <!-- Hero Content -->
        <div class="bg-image" style="background-image: url('<?php echo $image; ?>');">
            <div class="bg-primary-op">
                <section class="content content-full content-boxed overflow-hidden">
                    <!-- Section Content -->
                    <div class="push-150-t push-150 text-center">
                        <h1 class="text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><?php echo $meta_title; ?></h1>
                        <h2 class="h5 text-white-op visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><?php echo $meta_description; ?></h2>
                    </div>
                    <!-- END Section Content -->
                </section>
            </div>
        </div>
        <!-- END Hero Content -->
        <!-- Story Content -->
        <div class="bg-white">
            <section class="content content-boxed">
                <!-- Section Content -->
                <div class="text-center">
                    <a class="link-effect font-s13 font-w600" href="javascript:void(0)"><?php echo $author; ?></a> on <?php echo $date; ?> &bull; <em><?php echo $ago; ?></em>
                </div>
                <div class="row push-50-t push-50 nice-copy-story">
                    <div class="col-sm-8 col-sm-offset-2">
                        <?php echo $description; ?>
                    </div>
                </div>
                <!-- END Section Content -->
            </section>
        </div>
        <!-- END Story Content -->
        <!-- More Stories -->
        <section class="content content-boxed">
            <!-- Section Content -->
            <div class="row push-30-t push-30">
                <?php foreach ($relateds as $related) { ?>
                <div class="col-sm-4">
                    <a class="block block-link-hover2" href="<?php //echo $related['href']; ?>">
                        <div class="block-content bg-image" style="background-image: url('img<?php echo $related['image']; ?>');">
                            <h4 class="text-white push-50-t push"><?php echo $related['name']; ?></h4>
                        </div>
                        <div class="block-content block-content-full font-s12">
                            <em class="pull-right"><?php echo $related['ago']; ?></em>
                            <span class="text-primary"><?php echo $related['author']; ?></span> on <?php echo $related['date']; ?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
            <!-- END Section Content -->
        </section>
        <!-- END More Stories -->
    </main>
    <!-- END Main Container -->
<?php echo $footer; ?>
