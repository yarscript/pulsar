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
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title"><?php echo $text_form; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                            <div class="form-group required">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text"
                                               name="name"
                                               value="<?php echo $name; ?>"
                                               minlength="3"
                                               required/>
                                        <label>
                                            <?php echo $entry_name; ?><span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_status; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox" name="status" <?php echo $status ? 'checked' : ''; ?> value="1"><span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <?php $image_row = 0; ?>
                    <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane fade fade-right" id="language<?php echo $language['id']; ?>">
                            <table id="images<?php echo $language['id']; ?>" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-left"><?php echo $entry_title; ?></td>
                                    <td class="text-left"><?php echo $entry_link; ?></td>
                                    <td class="text-center"><?php echo $entry_image; ?></td>
                                    <td class="text-right"><?php echo $entry_sort_order; ?></td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($images[$language['id']])) { ?>
                                    <?php foreach ($images[$language['id']] as $image) { ?>
                                        <tr id="image-row<?php echo $image_row; ?>">
                                            <td class="text-left"><input type="text" name="image[<?php echo $language['id']; ?>][<?php echo $image_row; ?>][title]" value="<?php echo $image['title']; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control"/>
                                            <td class="text-left" style="width: 30%;"><input type="text" name="image[<?php echo $language['id']; ?>][<?php echo $image_row; ?>][link]" value="<?php echo $image['link']; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control"/></td>
                                            <td class="text-center"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>"/></a> <input type="hidden" name="image[<?php echo $language['id']; ?>][<?php echo $image_row; ?>][image]" value="<?php echo $image['image']; ?>" id="input-image<?php echo $image_row; ?>"/></td>
                                            <td class="text-right" style="width: 10%;"><input type="text" name="image[<?php echo $language['id']; ?>][<?php echo $image_row; ?>][sort_order]" value="<?php echo $image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control"/></td>
                                            <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $image_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td class="text-left"><button type="button" onclick="addImage('<?php echo $language['id']; ?>');" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->

<?php echo $footer; ?>
<script type="text/javascript">
var image_row = <?php echo $image_row; ?>;

function addImage(language_id) {
	html = '<tr id="image-row' + image_row + '">';
	html += '  <td class="text-left"><input type="text" name="image[' + language_id + '][' + image_row + '][title]" value="" placeholder="<?php echo $entry_title; ?>" class="form-control" /></td>';
	html += '  <td class="text-left" style="width: 30%;"><input type="text" name="image[' + language_id + '][' + image_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>';
	html += '  <td class="text-center"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="image[' + language_id + '][' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
	html += '  <td class="text-right" style="width: 10%;"><input type="text" name="image[' + language_id + '][' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + ', .tooltip\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#images' + language_id + ' tbody').append(html);

	image_row++;
}

</script>
<script type="text/javascript">
$('#language a:first').tab('show');
</script>
