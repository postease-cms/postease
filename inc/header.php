<!DOCTYPE html>
<html lang="<?=$_SESSION[$session_key]['user']['lang']?>">
<head>
<meta charset="utf-8">
<title><?=TXT_HEADER_TITLE?> | <?=$_SESSION[$session_key]['configs']['site_name']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="plugin/jquery/jquery-ui.min.css">
<link rel="stylesheet" href="plugin/fancybox2/jquery.fancybox.css">
<link rel="stylesheet" href="plugin/select2/css/select2.css">
<link rel="stylesheet" href="plugin/prism-dark/prism.css">
<?php if (! empty($_SESSION[$session_key]['configs']['system_font'])):?>
<link rel="stylesheet" href="css/font/<?=$_SESSION[$session_key]['configs']['system_font']?>.css">
<?php endif?>
<script src="plugin/jquery/jquery-2.2.3.min.js"></script>
<script src="plugin/jquery/jquery-ui.min.js"></script>
<script src="plugin/select2/js/select2.min.js"></script>
<script src="lang/body_<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<script src="lib/functions.js"></script>
</head>
