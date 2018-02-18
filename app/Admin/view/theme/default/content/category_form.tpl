<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    <?php echo $heading_title; ?>
                    <small><?php echo $text_form; ?></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php if ($breadcrumb['href']) { ?>
                            <li><a class="link-effect" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                        <?php } else { ?>
                            <li><?php echo $breadcrumb['text']; ?></li>
                        <?php } ?>
                    <?php } ?>
                </ol>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <?php if ($error) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><?php echo $error; ?></p>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <a class="block block-link-hover3 text-center" href="javascript:document.forms.form.submit()">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-success"><i class="fa fa-save"></i></div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">
                        <?php echo $button_save; ?>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6">
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
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                    <li class="active">
                        <a href="#tabs-general"><i class="fa fa-home"></i> <?php echo $tab_general; ?></a>
                    </li>
                    <li class="">
                        <a href="#tabs-data"><i class="fa fa-server"></i> <?php echo $tab_data; ?></a>
                    </li>
                    <li>
                        <a href="#tab-seo"><i class="fa fa-fw fa-link"></i> <?php echo $tab_seo; ?></a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <!-- Start General Tab -->
                    <div class="tab-pane fade fade-up active in" id="tabs-general">
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
                                    <div class="tab-pane" id="language<?php echo $language['id']; ?>">
                                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material form-material-primary">
                                                        <input class="form-control" type="text"
                                                               name="description[<?php echo $language['id']; ?>][name]"
                                                               value="<?php echo $description[$language['id']]['name']; ?>"
                                                               minlength="3"
                                                               required/>
                                                        <label><?php echo $entry_name; ?> <span class="text-danger">*</span></label>
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
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material form-material-primary">
                                                        <input class="form-control" type="text"
                                                               name="description[<?php echo $language['id']; ?>][meta_title]"
                                                               minlength="3"
                                                               value="<?php echo $description[$language['id']]['meta_title']; ?>"
                                                               required>
                                                        <label><?php echo $entry_meta_title; ?> <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material form-material-primary">
                                            <textarea class="form-control"
                                                      name="description[<?php echo $language['id']; ?>][meta_description]"
                                                      rows="5"><?php echo $description[$language['id']]['meta_description']; ?></textarea>
                                                        <label><?php echo $entry_meta_description; ?></label>
                                                        <div class="help-block text-right">255 Character Max</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material form-material-primary">
                                                        <input class="tags-input form-control" type="text"
                                                               name="description[<?php echo $language['id']; ?>][meta_keyword]"
                                                               value="<?php echo $description[$language['id']]['meta_keyword']; ?>">
                                                        <label><?php echo $entry_meta_keyword; ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-sm btn-primary" type="submit"><?php echo $button_save; ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
                                            <label class="col-xs-12"><?php echo $entry_parent; ?></label>
                                            <div class="col-xs-12">
                                            <input type="text" name="path"
                                                   value="<?php echo $path ?: ''; ?>"
                                                   placeholder="autocomplete" class="form-control"/>
                                            <input type="hidden" name="parent_id"
                                                   value="<?php echo $parent_id; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_image; ?></label>
                                            <div class="col-xs-12">
                                                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php echo $thumb; ?>" width="100px" height="100px" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                                                </a>
                                                <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_sort_order; ?>?</label>
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary ">
                                                    <input class="form-control" type="number" name="sort_order" value="<?php echo $sort_order; ?>"><span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_top; ?>?</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox"
                                                           name="top" <?php echo $top ? 'checked' : ''; ?> value="1"><span></span>
                                                </label>
                                            </div>
                                        </div>
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
                    </div>
                    <!-- End Data Tab -->
                    <!-- Start Seo Tab -->
                    <div class="tab-pane fade fade-up" id="tab-seo">
                        <div class="block">
                            <div class="block-content block-content-full">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-left"><?php echo $entry_keyword; ?></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($languages as $language) { ?>
                                        <tr>
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><img src="img/flag/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>"/></span>
                                                    <input type="text" name="seo_url[<?php echo $language['id']; ?>]" value="<?php echo ($seo_url && $seo_url[$language['id']]) ? $seo_url[$language['id']] : ''; ?>" placeholder="<?php echo $entry_keyword; ?>" class="form-control"/>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- End Seo Tab -->
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
<script type="text/javascript">
    $('#language a:first').tab('show');

    $('input[name=\'path\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: '<?php echo $autocomplete; ?>&name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    json.unshift({
                        category_id: 0,
                        path: '<?php echo $text_none; ?>'
                    });
                    response($.map(json, function (item) {
                        return {
                            label: item['path'],
                            value: item['category_id']
                        }
                    }));
                }
            });
        },
        'select': function (item) {
            $('input[name=\'path\']').val(item['label']);
            $('input[name=\'parent_id\']').val(item['value']);
        }
    });
</script>
<script type="text/javascript">
    App.vendors(['summernote', 'tags']);
</script>
