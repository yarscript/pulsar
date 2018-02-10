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
        <div class="block">
            <div class="bg-image" style="background-image: url('img/bg/profile.jpg');">
                <div class="block-content bg-primary-op text-center overflow-hidden">
                    <div class="push-30-t push animated fadeInDown">
                        <img class="img-avatar img-avatar96 img-avatar-thumb" src="<?php echo $thumb; ?>">
                    </div>
                    <div class="push-30 animated fadeInUp">
                        <h2 class="h4 font-w600 text-white push-5"><?php echo $user['firstname'] ?> <?php echo $user['lastname'] ?></h2>
                        <h3 class="h5 text-white-op"><?php echo isset($user['group']) ? $user['group'] : ''; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <form action="<?php echo $action; ?>" method="post">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified push-20" data-toggle="tabs">
                    <li class="active">
                        <a href="#tab-personal"><i class="fa fa-fw fa-pencil"></i> <?php echo $tab_user; ?></a>
                    </li>
                    <li>
                        <a href="#tab-password"><i class="fa fa-fw fa-asterisk"></i> <?php echo $tab_password; ?></a>
                    </li>
                    <li>
                        <a href="#tab-access"><i class="fa fa-fw fa-lock"></i> <?php echo $tab_access; ?></a>
                    </li>
                    <li>
                        <a href="#tab-image"><i class="fa fa-fw fa-picture-o"></i> <?php echo $tab_image; ?></a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane fade in active" id="tab-personal">
                        <div class="row items-push">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="username"><?php echo $entry_username; ?></label>
                                        <input class="form-control input-lg" type="text" name="username"
                                               value="<?php echo $user['username'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="firstname"><?php echo $entry_firstname; ?></label>
                                        <input class="form-control input-lg" type="text" name="firstname"
                                               value="<?php echo $user['firstname'] ?>">
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="lastname"><?php echo $entry_lastname; ?></label>
                                        <input class="form-control input-lg" type="text" name="lastname"
                                               value="<?php echo $user['lastname'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="email"><?php echo $entry_email; ?></label>
                                        <input class="form-control input-lg" type="email" name="email"
                                               value="<?php echo $user['email'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="tab-password">
                        <div class="row items-push">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="password"><?php echo $entry_password; ?></label>
                                        <input class="form-control input-lg" type="password" name="password" placeholder="<?php echo $entry_password; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label for="confirm"><?php echo $entry_confirm; ?></label>
                                        <input class="form-control input-lg" type="password" name="confirm" placeholder="<?php echo $entry_confirm; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fadein" id="tab-access">
                        <div class="row items-push">
                            <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <div class="font-s13 font-w600"><?php echo $entry_access; ?></div>
                                        <div class="font-s13 font-w400 text-muted"><?php echo $entry_group; ?></div>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <select class="form-control" id="example-select" name="group_id" size="1">
                                            <?php foreach ($groups as $group) { ?>
                                                <option value="<?php echo $group['id'] ?>" <?php echo ($group['id'] == $user['group_id']) ? 'selected' : '' ?>><?php echo $group['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-xs-8">
                                        <div class="font-s13 font-w600"><?php echo $entry_status; ?></div>
                                        <div class="font-s13 font-w400 text-muted"><?php echo $text_enabled; ?>
                                            /<?php echo $text_disabled; ?></div>
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <label class="css-input switch switch-sm switch-primary push-10-t">
                                            <input name="status"
                                                   type="checkbox" <?php echo((int)$user['status'] ? 'checked' : '') ?> value="1"><span></span>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <!-- Start Image Tab -->
                    <div class="tab-pane fade fade-up" id="tab-image">
                        <div class="block">
                            <div class="block-content block-content-full">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
                                    <div class="col-sm-10">
                                        <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                                            <img src="<?php echo $thumb; ?>" width="100px" height="100px" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                                        </a>
                                        <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Image Tab -->
                </div>
                <div class="block-content block-content-full bg-gray-lighter text-center">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i>
                        <?php echo $button_save; ?>
                    </button>
                    <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-refresh push-5-r"></i>
                        <?php echo $button_reset; ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
