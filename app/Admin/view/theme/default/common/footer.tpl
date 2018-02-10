<!-- Footer -->
<footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
    <div class="text-center"><?php echo $text_footer; ?><br /><?php echo $text_version; ?></div>
</footer>
<!-- END Footer -->

</div>
<!-- END Page Container -->
<?php foreach ($scripts as $script) { ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/filemanager.js"></script>
<script type="text/javascript" src="js/summernote.js"></script>
<script type="text/javascript" src="js/admin.app.js"></script>
</body>
</html>
