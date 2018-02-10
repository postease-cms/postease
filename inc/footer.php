<script src="js/scripts.js"></script>
<?php $js_exclusive = './js/_'. $view_page . '.js'?>
<?php if (file_exists($js_exclusive)):?>
<script src="<?=$js_exclusive?>"></script>
<?php endif?>
<?php if (file_exists('./custom/custom.js')):?>
<script src="./custom/custom.js"></script>
<?php endif?>
</body>
</html>