<!DOCTYPE html>
<html class="no-focus" lang="en">
<head>
    <base href="/">
    <meta charset="utf-8">
    <title><?php echo $heading_title; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <link rel="shortcut icon" href="img/favicons/favicon.png">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css">
    <link rel="stylesheet" id="css-main" href="css/admin.app.css">
    <link rel="stylesheet" id="css-main" href="css/app.css">
    <script type="text/javascript" src="vendor/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="vendor/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="js/admin.app.js"></script>
</head>
<body>
<div class="bg-white pulldown">
    <div  class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 animated fadeIn">
                    <div class="text-center">
                        <i class="fa fa-2x fa-bullseye text-primary"></i>
                        <p class="text-muted push-15-t"><?php echo $text_login; ?></p>
                    </div>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <form class="validation form-horizontal push-30-t" action="admin/login" method="post" novalidate="novalidate" autocomplete="off">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input id="username" class="form-control" type="text" name="username" minlength="3" value="<?php echo $username; ?>" required>
                                    <label for="username"><?php echo $entry_username; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input id="password" class="form-control" type="password" name="password" minlength="4" value="<?php echo $password; ?>" required>
                                    <label for="password"><?php echo $entry_password; ?></label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <button class="btn btn-sm btn-block btn-primary" type="submit"><?php echo $button_login; ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pulldown push-30-t text-center animated fadeInUp">
    <small class="text-muted"><?php echo $text_footer; ?><br /><?php echo $text_version; ?></small>
</div>
</body>
</html>
