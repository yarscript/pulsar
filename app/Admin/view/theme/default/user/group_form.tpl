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
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="javascript:document.forms.form.submit()">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-success"><i class="fa fa-save"></i></div>
                    </div>
                    <div
                        class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">
                        <?php echo $button_save; ?>
                    </div>
                </a>
            </div>
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
        </div>
        <form id="form" enctype="multipart/form-data" class="form-horizontal validation" method="post" action="<?php echo $action; ?>">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                    <li class="active">
                        <a href="#tabs-general"><i class="fa fa-home"></i> <?php echo $tab_general; ?></a>
                    </li>
                    <li class="">
                        <a href="#tabs-data"><i class="fa fa-chain"></i> <?php echo $tab_data; ?></a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <!-- Start General Tab -->
                    <div class="tab-pane fade fade-up active in" id="tabs-general">
                        <div class="block">
                            <ul class="nav nav-tabs nav-tabs-alt " data-toggle="tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                    <li>
                                        <a href="#language<?php echo $language['id']; ?>" data-toggle="tab" aria-expanded="true">
                                            <img src="img/flag/<?php echo $language['code']; ?>.png">
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div class="block-content block-content-full tab-content">
                                <?php foreach ($languages as $language) { ?>
                                    <div class="tab-pane fade fade-right" id="language<?php echo $language['id']; ?>">
                                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material form-material-primary">
                                                        <input class="form-control" type="text"
                                                               name="description[<?php echo $language['id']; ?>][name]"
                                                               value="<?php echo $description[$language['id']]['name']; ?>"
                                                               minlength="3"
                                                               required/>
                                                        <label>
                                                            <?php echo $entry_name; ?> <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12 push-10">
                                                    <div class="form-material form-material-primary">
                                                        <label>
                                                            <?php echo $entry_description; ?> <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 push-10">
                                                    <textarea name="description[<?php echo $language['id']; ?>][description]" rows="5" class="form-control"><?php echo ($description && $description[$language['id']]) ? $description[$language['id']]['description'] : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="block-content block-content-full bg-gray-lighter text-center">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> <?php echo $button_save; ?></button>
                                <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-refresh push-5-r"></i> <?php echo $button_reset; ?></button>
                            </div>
                        </div>
                    </div>
                    <!-- End General Tab -->
                    <!-- Start Data Tab -->
                    <div class="tab-pane fade fade-up" id="tabs-data">
                        <div class="block">
                            <div class="block-content block-content-full">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label><?php echo $entry_access; ?></label>
                                                <div class="well well-sm" style="height: 150px; overflow: auto;">
                                                    <?php foreach ($permissions as $permission) { ?>
                                                        <div class="checkbox">
                                                            <label
                                                                    class="css-input css-checkbox css-checkbox-sm css-checkbox-primary">
                                                                <?php if (in_array($permission, $access)) { ?>
                                                                    <input type="checkbox" name="permission[access][]"
                                                                           value="<?php echo $permission; ?>" checked="checked"/>
                                                                    <span></span>
                                                                    <?php echo $permission; ?>
                                                                <?php } else { ?>
                                                                    <input type="checkbox" name="permission[access][]"
                                                                           value="<?php echo $permission; ?>"/>
                                                                    <span></span>
                                                                    <?php echo $permission; ?>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <a style="cursor: pointer" onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a style="cursor: pointer" onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label><?php echo $entry_modify; ?></label>
                                                <div class="well well-sm" style="height: 150px; overflow: auto;">
                                                    <?php foreach ($permissions as $permission) { ?>
                                                        <div class="checkbox">
                                                            <label
                                                                    class="css-input css-checkbox css-checkbox-sm css-checkbox-primary">
                                                                <?php if (in_array($permission, $modify, true)) { ?>
                                                                    <input type="checkbox" name="permission[modify][]"
                                                                           value="<?php echo $permission; ?>" checked="checked"/>
                                                                    <span></span>
                                                                    <?php echo $permission; ?>
                                                                <?php } else { ?>
                                                                    <input type="checkbox" name="permission[modify][]"
                                                                           value="<?php echo $permission; ?>"/>
                                                                    <span></span>
                                                                    <?php echo $permission; ?>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <a style="cursor: pointer" onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a style="cursor: pointer" onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_approval; ?>?</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox"
                                                           name="approval" <?php echo $approval ? 'checked' : ''; ?>
                                                           value="1"><span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full bg-gray-lighter text-center">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> <?php echo $button_save; ?></button>
                                <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-refresh push-5-r"></i> <?php echo $button_reset; ?></button>
                            </div>
                        </div>
                    </div>
                    <!-- End Data Tab -->
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
<script type="text/javascript">
    $('#language a:first').tab('show');
</script>
