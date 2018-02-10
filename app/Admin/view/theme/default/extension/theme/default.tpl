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
                                <label class="col-xs-12"><?php echo $entry_header_transparent; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'header-navbar-transparent') !== false ? 'checked' : ''; ?> value="header-navbar-transparent"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_header_fixed; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'header-navbar-fixed') !== false ? 'checked' : ''; ?> value="header-navbar-fixed"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_sidebar_mini; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'sidebar-mini') !== false ? 'checked' : ''; ?> value="sidebar-mini"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_sidebar_visible_desktop; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'sidebar-o') !== false ? 'checked' : ''; ?> value="sidebar-o"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_sidebar_visible_mobile; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'sidebar-o-xs') !== false ? 'checked' : ''; ?> value="sidebar-o-xs"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_side_overlay_visible; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'side-overlay-o') ? 'checked' : ''; ?> value="side-overlay-o"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_side_overlay_hoverable; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox" name="theme_default_class[]" <?php echo strpos($theme_default_class, 'side-overlay-hover') !== false ? 'checked' : ''; ?> value="side-overlay-hover"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_side_scroll; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox"
                                               name="theme_default_class[]" <?php echo strpos($theme_default_class, 'side-scroll') !== false ? 'checked' : ''; ?> value="side-scroll"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <select name="theme_default_class[]" class="form-control select2">
                                            <?php if (strpos($theme_default_class, 'sidebar-l')) { ?>
                                                <option value="sidebar-l" selected="selected">Left</option>
                                            <?php } else { ?>
                                                <option value="sidebar-l">Left</option>
                                            <?php } ?>

                                            <?php if (strpos($theme_default_class, 'sidebar-r')) { ?>
                                                <option value="sidebar-r"
                                                        selected="selected">Right</option>
                                            <?php } else { ?>
                                                <option value="sidebar-r">Right</option>
                                            <?php } ?>

                                        </select>
                                        <label><?php echo $entry_sidebar_position; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary">
                                        <select name="theme_default_theme" class="form-control select2">
                                            <?php if ($theme_default_theme == '') { ?>
                                                <option value="" selected="selected">Default</option>
                                            <?php } else { ?>
                                                <option value="">Default</option>
                                            <?php } ?>

                                            <?php if ($theme_default_theme == 'amethyst') { ?>
                                                <option value="amethyst" selected="selected">Amethyst</option>
                                            <?php } else { ?>
                                                <option value="amethyst">Amethyst</option>
                                            <?php } ?>

                                            <?php if ($theme_default_theme == 'city') { ?>
                                                <option value="city" selected="selected">City</option>
                                            <?php } else { ?>
                                                <option value="city">City</option>
                                            <?php } ?>

                                            <?php if ($theme_default_theme == 'flat') { ?>
                                                <option value="flat" selected="selected">Flat</option>
                                            <?php } else { ?>
                                                <option value="flat">Flat</option>
                                            <?php } ?>

                                            <?php if ($theme_default_theme == 'modern') { ?>
                                                <option value="modern" selected="selected">Modern</option>
                                            <?php } else { ?>
                                                <option value="modern">Modern</option>
                                            <?php } ?>

                                            <?php if ($theme_default_theme == 'smooth') { ?>
                                                <option value="smooth" selected="selected">Smooth</option>
                                            <?php } else { ?>
                                                <option value="smooth">Smooth</option>
                                            <?php } ?>
                                        </select>
                                        <label><?php echo $entry_theme; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12"><?php echo $entry_status; ?>?</label>
                                <div class="col-xs-12">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox" name="theme_default_status" <?php echo $theme_default_status ? 'checked' : ''; ?> value="1"><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary"
                                            type="submit"><?php echo $button_save; ?></button>
                                </div>
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
