<?php require_once './_system_header.php'?>
<?php include_once './inc/header.php'?>
<body id="<?=$page_main?><?=($page_sub)?'-'.$page_sub:null?>" data-view_page="<?=$_SESSION[$session_key]['common']['view_page']?>">
<?php if ($view_page != 'login'):?>
<?php include_once './inc/global_navi.php'?>
<?php include_once './inc/main_menu.php'?>
<?php endif?>
<?php require_once './view/' . $view_page . '.php'?>
<?php require_once './inc/footer.php'?>