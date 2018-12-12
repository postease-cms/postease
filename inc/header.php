<!DOCTYPE html>
<html lang="<?=$_SESSION[$session_key]['user']['lang']?>">
<head>
<meta charset="utf-8">
<title>
	<?php $view_page = $_SESSION[$session_key]['common']['view_page']?>
	<?php if (isset($view_page_type[$view_page])):?>
	<?php if ($view_page_type[$view_page] == 1 || ($view_page_type[$view_page] == 0 && $_SESSION[$session_key]['common']['this_posttype'] < 1000)):?>
	<?=$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name']?>&nbsp;&lsaquo;
	<?php elseif ($view_page_type[$view_page] == 2 || ($view_page_type[$view_page] == 0 && $_SESSION[$session_key]['common']['this_posttype'] >= 1000)):?>
	<?=$_SESSION[$session_key]['common']['posttypes_extra'][$_SESSION[$session_key]['common']['this_posttype']]['name']?>&nbsp;&lsaquo;
	<?php else:?>
	<?=$view_page_title[$view_page_type[$view_page]]?>&nbsp;&lsaquo;
	<?php endif?>
	<?php endif?>
	<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg']):?>
	<?=$_SESSION[$session_key]['common']['sites'][$_SESSION[$session_key]['common']['this_site']]['name']?>&nbsp;&lsaquo;
	<?php endif?>
	<?=($site_name = $_SESSION[$session_key]['configs']['site_name'])?$site_name:'POSTEASE'?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css?v=<?=$_SESSION[$session_key]['configs']['postease_version']?>">
<link rel="stylesheet" href="plugin/jquery/jquery-ui.min.css">
<link rel="stylesheet" href="plugin/fancybox2/jquery.fancybox.css">
<link rel="stylesheet" href="plugin/select2/css/select2.css">
<link rel="stylesheet" href="plugin/prism-dark/prism.css">
<?php if (file_exists('custom/favicon.ico')):?>
<link rel="icon" type="image/vnd.microsoft.icon" href="custom/favicon.ico">
<?php endif?>
<?php if (! empty($_SESSION[$session_key]['configs']['system_font'])):?>
<link rel="stylesheet" href="css/font/<?=$_SESSION[$session_key]['configs']['system_font']?>.css">
<?php endif?>
<script src="plugin/jquery/jquery-2.2.3.min.js"></script>
<script src="plugin/jquery/jquery-ui.min.js"></script>
<script src="plugin/select2/js/select2.min.js"></script>
<script src="plugin/jquery-cookie/jquery.cookie.js"></script>
<script src="lang/body_<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<script src="lib/functions.js"></script>
</head>
