<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    <?php echo $heading_title; ?>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php if ($breadcrumb['href']) { ?>
                            <li><a class="link-effect"
                                   href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                        <?php } else { ?>
                            <li><?php echo $breadcrumb['text']; ?></li>
                        <?php } ?>
                    <?php } ?>
                </ol>
            </div>
        </div>
    </div>
    <div class="content">
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
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title"><?php echo $text_list; ?></h3>
            </div>
            <div class="block-content">
                <p class="push-30"></p>
                <div class="table-responsive">
                    <table class="table-sections table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th style="width: 30px;"></th>
                            <th><?php echo $column_name; ?></th>
                            <th style="width: 15%;"><?php echo $column_status; ?></th>
                            <th class="text-center" style="width: 100px;"><?php echo $column_action; ?></th>
                        </tr>
                        </thead>
                        <?php if ($extensions) { ?>
                        <?php foreach ($extensions as $extension) { ?>
                        <tbody class="open <?php echo $extension['installed'] && $extension['module'] ? 'table-sections-header' : ''; ?>">
                            <tr>
                                <td class="text-center">
                                    <?php echo $extension['installed'] && $extension['module'] ? '<i class="fa fa-angle-right"></i>' : ''; ?>
                                </td>
                                <td class="font-w600"><?php echo $extension['name'] ?></td>
                                <td>
                                    <span class="label label-<?php echo ($extension['installed'] && $extension['module'] ? 'success' : 'danger')  ?>"><?php echo ($extension['installed'] && $extension['module'] ? 'enabled' : 'disabled')  ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($extension['installed']) { ?>
                                        <?php if ($extension['module']) { ?>
                                            <div class="btn-group">
                                                <a href="<?php echo $extension['edit']; ?>"
                                                   data-toggle="tooltip"
                                                   title="<?php echo $button_add; ?>"
                                                   class="btn btn-sm btn-success">
                                                    <i class="fa fa-plus-circle"></i>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="btn-group">
                                                <a href="<?php echo $extension['edit']; ?>"
                                                   data-toggle="tooltip"
                                                   title="<?php echo $button_edit; ?>"
                                                   class="btn btn-sm btn-success">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        <div class="btn-group">
                                            <a href="<?php echo $extension['uninstall']; ?>"
                                               data-toggle="tooltip"
                                               title="<?php echo $button_uninstall; ?>"
                                               class="btn btn-sm btn-danger">
                                                <i class="fa fa-minus-circle"></i>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="btn-group">
                                            <a href="<?php echo $extension['install']; ?>"
                                               data-toggle="tooltip"
                                               title="<?php echo $button_install; ?>"
                                               class="btn  btn-sm btn-success">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                                </tbody>
                                <tbody>
                                <?php foreach ($extension['module'] as $module) { ?>
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="font-w600">&nbsp;&nbsp;&nbsp;<i class="fa fa-folder-open"></i>&nbsp;&nbsp;&nbsp;<?php echo $module['name'] ?></td>
                                        <td>
                                            <span class="label label-<?php echo ($module['status'] ? 'success' : 'danger')  ?>"><?php echo ($module['status'] ? 'enabled' : 'disabled')  ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?php echo $module['edit']; ?>"
                                                   data-toggle="tooltip"
                                                   title="<?php echo $button_edit; ?>"
                                                   class="btn btn-sm btn-default">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="<?php echo $module['delete']; ?>"
                                                   data-toggle="tooltip"
                                                   title="<?php echo $button_delete; ?>"
                                                   class="btn btn-sm btn-default">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                        <?php } ?>
                        <?php } else { ?>
                            <tbody>
                            <tr>
                                <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
                            </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
