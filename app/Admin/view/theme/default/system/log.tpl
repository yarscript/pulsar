<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <div class="content content-boxed">
        <?php if ($error) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><?php echo $error; ?></p>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="<?php echo $cancel; ?>">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-black-op"><i class="fa fa-reply"></i></div>
                    </div>
                    <div
                            class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">
                        <?php echo $button_cancel; ?>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="<?php echo $download; ?>">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-success"><i class="fa fa-download"></i></div>
                    </div>
                    <div
                        class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">
                        <?php echo $button_download; ?>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="<?php echo $clear; ?>">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-danger"><i class="fa fa-eraser"></i></div>
                    </div>
                    <div
                        class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">
                        <?php echo $button_clear; ?>
                    </div>
                </a>
            </div>
        </div>
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title"><i class="fa fa-warning push-15-r"></i><?php echo $text_list; ?></h3>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea class="form-control" wrap="hard" rows="36" readonly disabled><?php echo $log; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
