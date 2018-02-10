<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    <?php echo $heading_title; ?>
                    <small><?php echo $text_list; ?></small>
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
        <?php if($success) { ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><?php echo $success; ?></p>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-xs-6 col-sm-4">
                <a class="block block-link-hover3 text-center" href="<?php echo $add; ?>">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-success"><i class="fa fa-plus"></i></div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">
                        <?php echo $button_add; ?>
                    </div>
                </a>
            </div>
        </div>

        <div class="block">
            <div class="block-header">
                <h3 class="block-title"><?php echo $text_list; ?></h3>
            </div>
            <div class="block-content">
                <p class="push-30"></p>
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th><?php echo $column_name; ?></th>
                            <th class="text-center" style="width: 15%;"><?php echo $column_action; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($layouts as $layout) { ?>
                            <tr>
                                <td class="font-w600"><?php echo $layout['name'] ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?php echo $edit; ?>&id=<?php  echo $layout['id']; ?>"
                                           data-toggle="tooltip"
                                           title="<?php echo $button_edit; ?>"
                                           class="btn btn-sm btn-default">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="<?php echo $delete; ?>&id=<?php echo $layout['id']; ?>"
                                           onclick="return false"
                                           data-toggle="tooltip"
                                           title="<?php echo $button_delete; ?>"
                                           class="btn btn-sm btn-default js-swal-confirm">
                                            <i class="fa fa-close text-danger"></i>
                                        </a>
                                    </div>
                                </td>
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
