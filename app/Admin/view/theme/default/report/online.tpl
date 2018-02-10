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
    <div class="content content-boxed">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700" data-toggle="countTo" data-to="<?php echo $total; ?>"><?php echo number_format($total, 0, '.', ' '); ?></div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600"><?php echo $text_total; ?>
                    </div>
                </a>
            </div>
        </div>
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <ul class="block-options">
                    <li>
                        <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="icon-refresh"></i></button>
                    </li>
                    <li>
                        <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="icon-size-fullscreen"></i></button>
                    </li>
                </ul>
                <div class="block-title text-normal">
                    <?php echo $text_list; ?>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-bordered table-hover table-striped table-checkable">
                    <thead>
                    <tr>
                        <th><?php echo $column_ip; ?></th>
                        <th class="text-center" style="width: 15%;"><?php echo $column_user; ?></th>
                        <th class="text-center" style="width: 15%;"><?php echo $column_url; ?></th>
                        <th class="hidden-xs text-center" style="width: 10%;"><?php echo $column_referer; ?></th>
                        <th class="text-center" style="width: 15%;"><?php echo $column_action; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if($users) { ?>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td class="font-w600 text-middle">
                                        <a href="//whatismyipaddress.com/ip/<?php echo $user['ip']; ?>" target="_blank"><?php echo $user['ip']; ?></a>
                                    </td>
                                    <td class="text-middle text-center"><i><?php echo $user['user']; ?></i></td>
                                    <td class="font-w600 text-middle text-center">
                                        <a href="<?php echo $user['url']; ?>" target="_blank" rel="noreferrer"><?php echo $user['url']; ?></a>
                                    </td>
                                    <td class="hidden-xs text-middle text-center">
                                        <a href="<?php echo $user['url']; ?>" target="_blank"><?php echo $user['referer']; ?></a>
                                    </td>
                                    <td class="text-center text-middle">
                                        <div class="btn-group">
                                            <a href="<?php echo $user['edit']; ?>"
                                               data-toggle="tooltip"
                                               title="<?php echo $button_edit; ?>"
                                               class="btn btn-sm btn-default">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php echo $pagination; ?>
            <?php echo $results; ?>
        </div>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
