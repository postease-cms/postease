<p class="footer_rights">2015-<?=date('Y')?> POSTEASE.ORG ALL RIGHTS RESERVED.</p>
<script src="js/scripts.js?v=<?=$_SESSION[$session_key]['configs']['postease_version']?>"></script>
<?php $js_exclusive = './js/_'. $view_page . '.js'?>
<?php if (file_exists($js_exclusive)):?>
<script src="<?=$js_exclusive?>"></script>
<?php endif?>
<?php if (file_exists('./custom/custom.js')):?>
<script src="./custom/custom.js"></script>
<?php endif?>
<script src="plugin/prism-dark/prism.js"></script>
</body>
</html>