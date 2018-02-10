<?php echo $header; ?>
<!-- Main Container -->
<main id="main-container">
    <div class="content content-boxed">
        <?php  foreach ($dashboards as $dashboard) { ?>
            <?php echo $dashboard['output']; ?>
        <?php  } ?>
    </div>
</main>
<!-- END Main Container -->
<?php echo $footer; ?>
<script>
    // jQuery(function () {
    //     App.initHelpers(['appear', 'appear-countTo']);
    // });
</script>