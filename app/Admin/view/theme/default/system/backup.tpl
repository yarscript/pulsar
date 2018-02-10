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
            <?php if($success) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p><?php echo $success; ?></p>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <a class="block block-link-hover3 text-center" href="<?php echo $cancel; ?>">
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 text-black-op"><i class="fa fa-reply"></i></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">
                            <?php echo $button_cancel; ?>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <a class="block block-link-hover3 text-center" href="javascript:document.forms.backup.submit()">
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 text-success"><i class="fa fa-upload"></i></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">
                            <?php echo $button_export; ?>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <a class="block block-link-hover3 text-center" href="javascript:document.forms.restore.submit()">
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 text-primary"><i class="fa fa-download"></i></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter text-primary font-w600">
                            <?php echo $button_import; ?>
                        </div>
                    </a>
                </div>
            </div>
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title"><?php echo $heading_title; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                            <form id="restore" class="form-horizontal validation" enctype="multipart/form-data"
                                  action="<?php echo $restore; ?>" method="post">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary">
                                            <input type="file" name="import"/>
                                            <label><?php echo $entry_import; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="backup" class="form-horizontal validation" enctype="multipart/form-data"
                                  action="<?php echo $backup; ?>" method="post">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label><?php echo $entry_export; ?></label>
                                        <div class="well well-sm" style="height: 150px; overflow: auto;">
                                            <?php foreach ($tables as $table) { ?>
                                                <div class="checkbox">
                                                    <label
                                                        class="css-input css-checkbox css-checkbox-sm css-checkbox-primary">
                                                        <input type="checkbox" name="backup[]"
                                                               value="<?php echo $table; ?>" checked="checked"/>
                                                        <span></span>
                                                        <?php echo $table; ?>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a style="cursor: pointer" onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a style="cursor: pointer" onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
