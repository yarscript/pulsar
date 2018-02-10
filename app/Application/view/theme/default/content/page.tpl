<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <!-- Hero Content -->
    <div class="bg-primary-dark">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="push-100-t push-50 text-center">
                <h1 class="h2 text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><?php echo $meta_title; ?></h1>
                <h2 class="h5 text-white-op visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><?php echo $meta_description; ?></h2>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    <!-- END Hero Content -->
    <div class="bg-white">
        <section class="content content-boxed">
            <!-- Section Content -->
            <div class="row items-push push-20-t nice-copy">
                <?php echo $column_left; ?>
                <div class="col-md-<?php echo $column_left || $column_right ? 6 : 12; ?>">
                    <?php echo $description; ?>
                </div>
                <?php echo $column_right; ?>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
