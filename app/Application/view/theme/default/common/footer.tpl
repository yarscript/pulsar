<!-- Footer -->
<footer id="page-footer" class="bg-white">
    <div class="content content-boxed">
        <!-- Footer Navigation -->
        <div class="row push-30-t items-push-2x">
            <?php foreach ($pages as $page) { ?>
                <div class="col-sm-4">
                    <?php if ($page['children']) { ?>
                        <h3 class="h5 font-w600 text-uppercase push-20"><?php echo $page['name']; ?></h3>
                        <ul class="list list-simple-mini font-s13">
                            <?php foreach ($page['children'] as $child) { ?>
                                <li><a href="<?php echo $child['href']; ?>" class="font-w600"><?php echo $child['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <a href="<?php echo $page['href']; ?>" class="<?php echo $page['active']; ?>"><?php echo $page['name']; ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="col-sm-4">
                <h3 class="h5 font-w600 text-uppercase push-20">Get In Touch</h3>
                <div class="font-s13 push">
                    <strong>Company, Inc.</strong><br>
                    980 Folsom Ave, Suite 1230<br>
                    San Francisco, CA 94107<br>
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                </div>
                <div class="font-s13">
                    <i class="icon-envelope-open"></i> company@example.com
                </div>
            </div>
        </div>
        <!-- END Footer Navigation -->

        <!-- Copyright Info -->
        <div class="font-s12 push-20 clearfix">
            <hr class="remove-margin-t">
            <div class="pull-right">
                <?php echo $text_powered; ?>
            </div>
            <div class="pull-left">
                <?php echo $text_copyright; ?>
            </div>
        </div>
        <!-- END Copyright Info -->
    </div>
</footer>
<!-- END Footer -->
</div>
<!-- END Page Container -->

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<?php foreach ($scripts as $script) { ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
</body>
</html>
