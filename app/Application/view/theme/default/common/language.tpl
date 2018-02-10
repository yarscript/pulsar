<?php if (count($languages) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
    <ul class="js-nav-main-header nav-main-header pull-right">
        <li>
            <?php foreach ($languages as $language) { ?>
                <?php if ($language['code'] == $code) { ?>
            <a class="nav-submenu" href="javascript:void(0)"><img src="img/flag/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"></a>
                <?php } ?>
            <?php } ?>
            <ul>
                <?php foreach ($languages as $language) { ?>
                    <li>
                        <button class="btn btn-link language-select" type="button" name="<?php echo $language['code']; ?>"><img src="img/flag/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></button>
                    </li>
                <?php } ?>
            </ul>
        </li>
            <input type="hidden" name="code" value="" />
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    </ul>
</form>
<?php } ?>
