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
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="javascript:document.forms.form.submit()">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-success"><i class="fa fa-save"></i></div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">
                        <?php echo $button_save; ?>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a class="block block-link-hover3 text-center" href="<?php echo $dashboard; ?>">
                    <div class="block-content block-content-full">
                        <div class="h1 font-w700 text-black-op"><i class="fa fa-reply"></i></div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">
                        <?php echo $button_cancel; ?>
                    </div>
                </a>
            </div>
        </div>
        <form id="form" enctype="multipart/form-data" class="form-horizontal validation" method="post" action="<?php echo $action; ?>">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                    <li class="active"><a href="#tabs-general"><i class="fa fa-home"></i> <?php echo $tab_general; ?></a></li>
                    <li><a href="#tabs-option"><i class="fa fa-cog"></i> <?php echo $tab_option; ?></a></li>
                    <li><a href="#tabs-user"><i class="fa fa-user"></i> <?php echo $tab_user; ?></a></li>
                    <li><a href="#tabs-mail"><i class="fa fa-envelope"></i> <?php echo $tab_mail; ?></a></li>
                    <li><a href="#tabs-server"><i class="fa fa-server"></i> <?php echo $tab_server; ?></a></li>
                </ul>
                <div class="block-content tab-content">
                    <!-- Start General Tab -->
                    <div class="tab-pane fade fade-up active in" id="tabs-general">
                        <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control"
                                               type="text"
                                               name="config_name"
                                               value="<?php echo $config_name; ?>" minlength="3"
                                               data-always-show="true"
                                               required/>
                                        <label><?php echo $entry_name; ?> <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control"
                                               type="email"
                                               name="config_email"
                                               value="<?php echo $config_email; ?>"
                                               minlength="3"
                                               required/>
                                        <label><?php echo $entry_email; ?> <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text" name="config_meta_title"
                                               minlength="3"
                                               value="<?php echo $config_meta_title; ?>"
                                               required>
                                        <label><?php echo $entry_meta_title; ?> <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                    <textarea class="form-control" name="config_meta_description" rows="5"><?php echo $config_meta_description; ?></textarea>
                                        <label><?php echo $entry_meta_description; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <input class="tags-input form-control" type="text" name="config_meta_keyword"
                                               value="<?php echo $config_meta_keyword; ?>">
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
                    </div>
                    <!-- End General Tab -->
                    <!-- Start Options Tab -->
                    <div class="tab-pane fade fade-up" id="tabs-option">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material form-material-primary">
                                                <input class="form-control" type="number" name="config_limit"
                                                       value="<?php echo $config_limit; ?>" minlength="1"
                                                       required/>
                                                <label><?php echo $entry_limit; ?> <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material">
                                                <select class="select2 form-control" name="config_language"
                                                        style="width: 100%;"
                                                        data-placeholder="Choose one.." required>
                                                    <option></option>
                                                    <?php foreach ($languages as $language) { ?>
                                                        <?php if ($language['code'] == $config_language) { ?>
                                                            <option value="<?php echo $language['code']; ?>"
                                                                    selected="selected"><?php echo $language['name']; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <label><?php echo $entry_language; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material">
                                                <select class="select2 form-control" name="config_admin_language"
                                                        style="width: 100%;"
                                                        data-placeholder="Choose one.." required>
                                                    <option></option>
                                                    <?php foreach ($languages as $language) { ?>
                                                        <?php if ($language['code'] == $config_admin_language) { ?>
                                                            <option value="<?php echo $language['code']; ?>"
                                                                    selected="selected"><?php echo $language['name']; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <label><?php echo $entry_admin_language; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material form-material-primary">
                                                <input class="form-control" type="text" name="config_theme" value="<?php echo $config_theme; ?>">
                                                <label><?php echo $entry_theme; ?></label>
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
                        </div>
                    </div>
                    <!-- End Options Tab -->
                    <!-- Start Users Tab -->
                    <div class="tab-pane fade fade-up" id="tabs-user">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                                    <div class="form-group">
                                        <label class="col-xs-12"><?php echo $entry_user_online; ?>?</label>
                                        <div class="col-xs-12">
                                            <label class="css-input switch switch-sm switch-primary">
                                                <input type="checkbox"
                                                       name="config_user_online" <?php echo $config_user_online ? 'checked' : ''; ?>
                                                       value="1"><span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12"><?php echo $entry_user_activity; ?>?</label>
                                        <div class="col-xs-12">
                                            <label class="css-input switch switch-sm switch-primary">
                                                <input type="checkbox"
                                                       name="config_user_activity" <?php echo $config_user_activity ? 'checked' : ''; ?>
                                                       value="1"><span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12"><?php echo $entry_user_search; ?>?</label>
                                        <div class="col-xs-12">
                                            <label class="css-input switch switch-sm switch-primary">
                                                <input type="checkbox"
                                                       name="config_user_search" <?php echo $config_user_search ? 'checked' : ''; ?>
                                                       value="1"><span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material">
                                                <select class="select2 form-control" name="config_user_group"
                                                        style="width: 100%;"
                                                        data-placeholder="Choose one.." required>
                                                    <option></option>
                                                    <?php foreach ($user_groups as $user_group) { ?>
                                                        <?php if ($user_group['id'] == $config_user_group) { ?>
                                                            <option value="<?php echo $user_group['id']; ?>"
                                                                    selected="selected"><?php echo $user_group['name']; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $user_group['id']; ?>"><?php echo $user_group['name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <label><?php echo $entry_user_group; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <label><?php echo $entry_user_groups; ?>?</label>
                                            <div class="well well-sm" style="height: 150px; overflow: auto;">
                                                <?php foreach ($user_groups as $user_group) { ?>
                                                    <div class="checkbox">
                                                        <label class="css-input css-checkbox css-checkbox-sm css-checkbox-primary">
                                                            <input type="checkbox"
                                                                   name="config_user_group_display[]" <?php echo in_array($user_group['id'], $config_user_group_display) ? 'checked' : ''; ?>
                                                                   value="1">
                                                            <span></span>
                                                            <?php echo $user_group['name']; ?>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a style="cursor: pointer"
                                               onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a>
                                            / <a style="cursor: pointer"
                                                 onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material form-material-primary">
                                                <input class="form-control" type="number"
                                                       name="config_login_attempts"
                                                       value="<?php echo $config_login_attempts; ?>" required>
                                                <label><?php echo $entry_login_attempts; ?></label>
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
                        </div>
                    </div>
                    <!-- End Users Tab -->

                    <!-- Start Mail Tab -->
                    <div class="tab-pane fade fade-up" id="tabs-mail">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">
                                    <div class="form-group">
                                        <label><?php echo $entry_mail_engine; ?></label>
                                        <select class="select2 form-control" name="config_mail_engine" style="width: 100%;"
                                                data-placeholder="Choose one.." required>
                                            <option></option>
                                            <?php if ($config_mail_engine === 'mail') { ?>
                                                <option value="mail" selected="selected">MAIL</option>
                                            <?php } else { ?>
                                                <option value="mail">MAIL</option>
                                            <?php } ?>
                                            <?php if ($config_mail_engine === 'smtp') { ?>
                                                <option value="smtp" selected="selected">SMTP</option>
                                            <?php } else { ?>
                                                <option value="smtp">SMTP</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label><?php echo $entry_mail_secure; ?></label>
                                        <select class="select2 form-control" name="config_mail_secure" style="width: 100%;"
                                                data-placeholder="Choose one..">
                                            <option>-- None --</option>
                                            <option value="ssl" <?php echo isset($config_mail_secure) && $config_mail_secure === 'ssl' ? 'selected' : ''; ?>>
                                                SSL
                                            </option>
                                            <option value="tls" <?php echo isset($config_mail_secure) && $config_mail_secure === 'tls' ? 'selected' : ''; ?>>
                                                TLS
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $entry_mail_parameter; ?></label>
                                        <input class="form-control" type="text" name="config_mail_parameter"
                                               data-always-show="true"
                                               value="<?php echo $config_mail_parameter; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $entry_smtp_hostname; ?></label>
                                        <input class="form-control" type="text" name="config_mail_smtp_hostname"
                                               data-always-show="true"
                                               value="<?php echo $config_mail_smtp_hostname; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $entry_smtp_port; ?></label>
                                        <input class="form-control" type="number" name="config_mail_smtp_port"
                                               data-always-show="true"
                                               value="<?php echo $config_mail_smtp_port; ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label><?php echo $entry_smtp_username; ?></label>
                                        <input class="form-control" type="text" name="config_mail_smtp_username"
                                               data-always-show="true"
                                               value="<?php echo $config_mail_smtp_username; ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label><?php echo $entry_smtp_password; ?></label>
                                        <input class="form-control" type="text" name="config_mail_smtp_password"
                                               data-always-show="true"
                                               value="<?php echo $config_mail_smtp_password; ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label><?php echo $entry_smtp_timeout; ?></label>
                                        <input class="form-control" type="number" name="config_mail_smtp_timeout"
                                               data-always-show="true"
                                               value="<?php echo $config_mail_smtp_timeout; ?>">
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
                    <!-- End Mail Tab -->
                    <!-- Start Server Tab -->
                    <div class="tab-pane fade fade-up" id="tabs-server">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 push-30-t push-30">

                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_maintenance; ?>?</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox"
                                                           name="config_maintenance" <?php echo isset($config_maintenance) ? 'checked' : ''; ?>><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <div class="form-material">
                                                    <select class="select2 form-control" name="config_compression">
                                                        <option value="0">0</option>
                                                        <option value="1" <?php echo $config_compression == '1' ? 'selected' : ''; ?>>
                                                            1
                                                        </option>
                                                        <option value="2" <?php echo $config_compression == '2' ? 'selected' : ''; ?>>
                                                            2
                                                        </option>
                                                        <option value="3" <?php echo $config_compression == '3' ? 'selected' : ''; ?>>
                                                            3
                                                        </option>
                                                        <option value="4" <?php echo $config_compression == '4' ? 'selected' : ''; ?>>
                                                            4
                                                        </option>
                                                        <option value="5" <?php echo $config_compression == '5' ? 'selected' : ''; ?>>
                                                            5
                                                        </option>
                                                        <option value="6" <?php echo $config_compression == '6' ? 'selected' : ''; ?>>
                                                            6
                                                        </option>
                                                        <option value="7" <?php echo $config_compression == '7' ? 'selected' : ''; ?>>
                                                            7
                                                        </option>
                                                        <option value="8" <?php echo $config_compression == '8' ? 'selected' : ''; ?>>
                                                            8
                                                        </option>
                                                        <option value="9" <?php echo $config_compression == '9' ? 'selected' : ''; ?>>
                                                            9
                                                        </option>
                                                    </select>
                                                    <label><?php echo $entry_compression; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_secure; ?>?</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox"
                                                           name="config_secure" <?php echo isset($config_secure) ? 'checked' : ''; ?>
                                                           value="1"><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_error_display; ?>?</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox"
                                                           name="config_error_display" <?php echo $config_error_display ? 'checked' : ''; ?>
                                                           value="1"><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12"><?php echo $entry_error_log; ?>?</label>
                                            <div class="col-xs-12">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input type="checkbox"
                                                           name="config_error_log" <?php echo $config_error_log ? 'checked' : ''; ?>
                                                           value="1"><span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <div class="col-xs-12">
                                                <div class="form-material form-material-primary">
                                                    <input class="form-control" type="text"
                                                           name="config_error_filename"
                                                           value="<?php echo $config_error_filename; ?>" required>
                                                    <label><?php echo $entry_error_filename; ?> <span class="text-danger">*</span></label>
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
                        </div>
                    </div>
                    <!-- End Server Tab -->
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
