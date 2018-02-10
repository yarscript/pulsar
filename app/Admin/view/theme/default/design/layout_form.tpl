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
        <form id="form" enctype="multipart/form-data" class="form-horizontal js-validation-material" method="post" action="<?php echo $action; ?>">
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title"><?php echo $text_route; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_layout; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_layout; ?>" id="input-name" class="form-control" />
                                </div>
                            </div>
                            <table id="route" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-left"><?php echo $entry_route; ?></td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $route_row = 0; ?>
                                <?php foreach ($layout_routes as $layout_route) { ?>
                                    <tr id="route-row<?php echo $route_row; ?>">
                                        <td class="text-left"><input type="text" name="layout_route[<?php echo $route_row; ?>][route]" value="<?php echo $layout_route['route']; ?>" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>
                                        <td class="text-left"><button type="button" onclick="$('#route-row<?php echo $route_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                    </tr>
                                    <?php $route_row++; ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-left"><button type="button" onclick="addRoute();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title"><?php echo $text_module; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <?php $module_row = 0; ?>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <table id="module-column-left" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-center"><?php echo $text_column_left; ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($layout_modules as $layout_module) { ?>
                                    <?php if ($layout_module['position'] === 'column_left') { ?>
                                        <tr id="module-row<?php echo $module_row; ?>">
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <select name="layout_module[<?php echo $module_row; ?>][code]" class="form-control input-sm">
                                                        <?php foreach ($extensions as $extension) { ?>
                                                            <optgroup label="<?php echo $extension['name']; ?>">
                                                                <?php if (!$extension['module']) { ?>
                                                                    <?php if ($extension['code'] == $layout_module['code']) { ?>
                                                                        <option value="<?php echo $extension['code']; ?>" selected="selected"><?php echo $extension['name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php foreach ($extension['module'] as $module) { ?>
                                                                        <?php if ($module['code'] == $layout_module['code']) { ?>
                                                                            <option value="<?php echo $module['code']; ?>" selected="selected"><?php echo $module['name']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </optgroup>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" value="<?php echo $layout_module['position']; ?>" />
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" />
                                                    <div class="input-group-btn"><a href="<?php echo $layout_module['edit']; ?>" type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                                        <button type="button" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $module_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="text-left"><div class="input-group">
                                            <select class="form-control input-sm">
                                                <option value=""></option>
                                                <?php foreach ($extensions as $extension) { ?>
                                                    <optgroup label="<?php echo $extension['name']; ?>">
                                                        <?php if (!$extension['module']) { ?>
                                                            <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                        <?php } else { ?>
                                                            <?php foreach ($extension['module'] as $module) { ?>
                                                                <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="button" onclick="addModule('column-left');" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-12">
                            <table id="module-content-top" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-center"><?php echo $text_content_top; ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($layout_modules as $layout_module) { ?>
                                    <?php if ($layout_module['position'] === 'content_top') { ?>
                                        <tr id="module-row<?php echo $module_row; ?>">
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <select name="layout_module[<?php echo $module_row; ?>][code]" class="form-control input-sm">
                                                        <?php foreach ($extensions as $extension) { ?>
                                                            <optgroup label="<?php echo $extension['name']; ?>">
                                                                <?php if (!$extension['module']) { ?>
                                                                    <?php if ($extension['code'] == $layout_module['code']) { ?>
                                                                        <option value="<?php echo $extension['code']; ?>" selected="selected"><?php echo $extension['name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php foreach ($extension['module'] as $module) { ?>
                                                                        <?php if ($module['code'] == $layout_module['code']) { ?>
                                                                            <option value="<?php echo $module['code']; ?>" selected="selected"><?php echo $module['name']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </optgroup>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" value="<?php echo $layout_module['position']; ?>" />
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" />
                                                    <div class="input-group-btn"><a href="<?php echo $layout_module['edit']; ?>" type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                                        <button type="button" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $module_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="text-left"><div class="input-group">
                                            <select class="form-control input-sm">
                                                <option value=""></option>
                                                <?php foreach ($extensions as $extension) { ?>
                                                    <optgroup label="<?php echo $extension['name']; ?>">
                                                        <?php if (!$extension['module']) { ?>
                                                            <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                        <?php } else { ?>
                                                            <?php foreach ($extension['module'] as $module) { ?>
                                                                <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="button" onclick="addModule('content-top');" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            <table id="module-content-bottom" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-center"><?php echo $text_content_bottom; ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($layout_modules as $layout_module) { ?>
                                    <?php if ($layout_module['position'] === 'content_bottom') { ?>
                                        <tr id="module-row<?php echo $module_row; ?>">
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <select name="layout_module[<?php echo $module_row; ?>][code]" class="form-control input-sm">
                                                        <?php foreach ($extensions as $extension) { ?>
                                                            <optgroup label="<?php echo $extension['name']; ?>">
                                                                <?php if (!$extension['module']) { ?>
                                                                    <?php if ($extension['code'] == $layout_module['code']) { ?>
                                                                        <option value="<?php echo $extension['code']; ?>" selected="selected"><?php echo $extension['name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php foreach ($extension['module'] as $module) { ?>
                                                                        <?php if ($module['code'] == $layout_module['code']) { ?>
                                                                            <option value="<?php echo $module['code']; ?>" selected="selected"><?php echo $module['name']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </optgroup>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" value="<?php echo $layout_module['position']; ?>" />
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" />
                                                    <div class="input-group-btn"><a href="<?php echo $layout_module['edit']; ?>" type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                                        <button type="button" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $module_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="text-left"><div class="input-group">
                                            <select class="form-control input-sm">
                                                <option value=""></option>
                                                <?php foreach ($extensions as $extension) { ?>
                                                    <optgroup label="<?php echo $extension['name']; ?>">
                                                        <?php if (!$extension['module']) { ?>
                                                            <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                        <?php } else { ?>
                                                            <?php foreach ($extension['module'] as $module) { ?>
                                                                <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="button" onclick="addModule('content-bottom');" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <table id="module-column-right" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-center"><?php echo $text_column_right; ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($layout_modules as $layout_module) { ?>
                                    <?php if ($layout_module['position'] === 'column_right') { ?>
                                        <tr id="module-row<?php echo $module_row; ?>">
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <select name="layout_module[<?php echo $module_row; ?>][code]" class="form-control input-sm">
                                                        <?php foreach ($extensions as $extension) { ?>
                                                            <optgroup label="<?php echo $extension['name']; ?>">
                                                                <?php if (!$extension['module']) { ?>
                                                                    <?php if ($extension['code'] == $layout_module['code']) { ?>
                                                                        <option value="<?php echo $extension['code']; ?>" selected="selected"><?php echo $extension['name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php foreach ($extension['module'] as $module) { ?>
                                                                        <?php if ($module['code'] == $layout_module['code']) { ?>
                                                                            <option value="<?php echo $module['code']; ?>" selected="selected"><?php echo $module['name']; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </optgroup>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" value="<?php echo $layout_module['position']; ?>" />
                                                    <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" />
                                                    <div class="input-group-btn"><a href="<?php echo $layout_module['edit']; ?>" type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                                        <button type="button" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $module_row++; ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="text-left"><div class="input-group">
                                            <select class="form-control input-sm">
                                                <option value=""></option>
                                                <?php foreach ($extensions as $extension) { ?>
                                                    <optgroup label="<?php echo $extension['name']; ?>">
                                                        <?php if (!$extension['module']) { ?>
                                                            <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>
                                                        <?php } else { ?>
                                                            <?php foreach ($extension['module'] as $module) { ?>
                                                                <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="button" onclick="addModule('column-right');" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
<script type="text/javascript">
    var route_row = <?php echo $route_row; ?>;

    function addRoute() {
        html  = '<tr id="route-row' + route_row + '">';
        html += '  <td class="text-left"><select name="layout_route[' + route_row + ']" class="form-control">';
        html += '  <option value="0"><?php echo $text_default; ?></option>';
        html += '  </select></td>';
        html += '  <td class="text-left"><input type="text" name="layout_route[' + route_row + '][route]" value="" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#route-row' + route_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#route tbody').append(html);

        route_row++;
    }

    var module_row = <?php echo $module_row; ?>;

    function addModule(type) {
        html  = '<tr id="module-row' + module_row + '">';
        html += '  <td class="text-left"><div class="input-group"><select name="layout_module[' + module_row + '][code]" class="form-control input-sm">';
        <?php foreach ($extensions as $extension) { ?>
        html += '    <optgroup label="<?php echo $extension['name']; ?>">';
        <?php if (!$extension['module']) { ?>
        html += '      <option value="<?php echo $extension['code']; ?>"><?php echo $extension['name']; ?></option>';
        <?php } else { ?>
        <?php foreach ($extension['module'] as $module) { ?>
        html += '      <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>';
        <?php } ?>
        <?php } ?>
        html += '    </optgroup>';
        <?php } ?>
        html += '  </select>';
        html += '  <input type="hidden" name="layout_module[' + module_row + '][position]" value="' + type.replace('-', '_') + '" />';
        html += '  <input type="hidden" name="layout_module[' + module_row + '][sort_order]" value="" />';
        html += '  <div class="input-group-btn"><a href="" target="_blank" type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a><button type="button" onclick="$(\'#module-row' + module_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button></div></div></td>';
        html += '</tr>';

        $('#module-' + type + ' tbody').append(html);

        $('#module-' + type + ' tbody select[name=\'layout_module[' + module_row + '][code]\']').val($('#module-' + type + ' tfoot select').val());

        $('#module-' + type + ' select[name*=\'code\']').trigger('change');

        $('#module-' + type + ' tbody input[name*=\'sort_order\']').each(function(i, element) {
            $(element).val(i);
        });

        module_row++;
    }

    $('#module-column-left, #module-column-right, #module-content-top, #module-content-bottom').delegate('select[name*=\'code\']', 'change', function() {
        var part = this.value.split('.');

        if (!part[1]) {
            $(this).parent().find('a').attr('href', 'index.php?route=extension/module/' + part[0] + '&token={{ token }}');
        } else {
            $(this).parent().find('a').attr('href', 'index.php?route=extension/module/' + part[0] + '&token={{ token }}&module_id=' + part[1]);
        }
    });

    $('#module-column-left, #module-column-right, #module-content-top, #module-content-bottom').trigger('change');
</script>
