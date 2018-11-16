<p class="footer_rights">2015-<?=date('Y')?> POSTEASE.ORG ALL RIGHTS RESERVED.</p>
<script src="plugin/bootstrap/js/bootstrap.min.js"></script>
<script src="plugin/fancybox2/jquery.fancybox.pack.js"></script>
<script src="js/common.js?v=<?=$_SESSION[$session_key]['configs']['postease_version']?>"></script>
<?php $js_exclusive = './js/_'. $view_page . '.js'?>
<?php if (file_exists($js_exclusive)):?>
<script src="<?=$js_exclusive?>?v=<?=$_SESSION[$session_key]['configs']['postease_version']?>"></script>
<?php endif?>
<?php if (file_exists('./custom/custom.js')):?>
<script src="./custom/custom.js"></script>
<?php endif?>
<script src="plugin/prism-dark/prism.js"></script>
</body>
</html>