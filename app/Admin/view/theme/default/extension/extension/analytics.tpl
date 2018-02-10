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
        <div class="row">

        </div>
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title"><?php echo $text_list; ?></h3>
            </div>
            <div class="block-content">
                <p class="push-30"></p>
                <div class="table-responsive">
                    <table class="js-table-sections table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th><?php echo $column_name; ?></th>
                            <th style="width: 15%;"><?php echo $column_status; ?></th>
                            <th class="text-center" style="width: 100px;"><?php echo $column_action; ?></th>
                        </tr>
                        </thead>

                        <?php if ($extensions) { ?>
                        <tbody>
                            <?php foreach ($extensions as $extension) { ?>
                                <tr>
                                    <td class="font-w600"><?php echo $extension['name'] ?></td>
                                    <td>
                                        <span class="label label-<?php echo ($extension['status'] ? 'success' : 'danger')  ?>"><?php echo ($extension['status'] ? 'enabled' : 'disabled')  ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($extension['installed']) { ?>
                                            <div class="btn-group">
                                                <a href="<?php echo $extension['edit']; ?>"
                                                   data-toggle="tooltip"
                                                   title="<?php echo $button_edit; ?>"
                                                   class="btn btn-sm btn-success">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </div>
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
                                                    <i class="fa fa-plus-circle"></i>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
                            </tr>
                        <?php } ?>
                                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>

