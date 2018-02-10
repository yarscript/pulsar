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
        <form id="form" enctype="multipart/form-data" class="form-horizontal validation" method="post"
              action="<?php echo $action; ?>">
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title"><?php echo $text_edit; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text" name="name"
                                               value="<?php echo $name; ?>" minlength="3"
                                               required/>
                                        <label><?php echo $entry_name; ?> <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="block">
                            <ul class="nav nav-tabs nav-tabs-alt " data-toggle="tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                    <li>
                                        <a href="#language<?php echo $language['id']; ?>" data-toggle="tab"
                                           aria-expanded="true">
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
                                                        <input class="form-control"
                                                               type="text"
                                                               name="description[<?php echo $language['id']; ?>][title]"
                                                               value="<?php echo $description[$language['id']]['title']; ?>"
                                                        />
                                                        <label><?php echo $entry_title; ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12 push-10">
                                                    <div class="form-material form-material-primary">
                                                        <label><?php echo $entry_description; ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 push-10">
                                        <textarea class="summernote"
                                                  name="description[<?php echo $language['id']; ?>][description]"><?php echo $description[$language['id']]['description']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_status; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="status" <?php echo $status ? 'checked' : ''; ?> value="1"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><?php echo $button_save; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<?php echo $footer; ?>
<script type="text/javascript">
    $('#language a:first').tab('show');
</script>
