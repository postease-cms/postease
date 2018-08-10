<?php

$fa_user = 'fa-user';
if ($_SESSION[$session_key]['user']['role'] == 1) $fa_user = 'fa-universal-access';
if ($_SESSION[$session_key]['user']['role'] == 2) $fa_user = 'fa-universal-access';

?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-header">
		<button class="navbar-toggle" data-toggle="collapse" data-target=".target">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<?php if (! empty($_SESSION[$session_key]['configs']['site_name'])):?>
		<a class="navbar-brand" href="./?view_page=index&amp;change=1&amp;clear=1"><?=$_SESSION[$session_key]['configs']['site_name']?></a>
		<?php else:?>
		<a class="navbar-brand" href="./?view_page=index&amp;change=1&amp;clear=1"><img src="../img/logo_white.svg" width="120px"></a>
		<?php endif?>
	</div>
	<div class="collapse navbar-collapse target">
		<ul class="nav navbar-nav">
			<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg']):?>
			<?php foreach ($_SESSION[$session_key]['common']['sites'] as $key => $row):?>
			<li <?=($key==$_SESSION[$session_key]['common']['this_site'])?'class="active"':''?>><a href="./?view_page=index&this_site=<?=$key?>&amp;change=1&amp;reset_posttype=1"><?=$row['name']?></a></li>
			<?php endforeach?>
			<?php endif?>
		</ul>
		<ul class="nav navbar-nav navbar-right" id="logout">
			<li><a href="./_logout.php"><i class="fa fa-sign-out"></i> <?=TXT_GNAVI_LNK_LOGOUT?></a></li>
		</ul>
		<p class="navbar-text navbar-right" class="loginInfo">
			<?php if ($_SESSION[$session_key]['user']['group_name']):?>
			<span class="loginInfo-group"><i class="fa fa-users"></i> <?=$_SESSION[$session_key]['user']['group_name']?></span>
			<?php endif?>
			<span class="loginInfo-user"><i class="fa <?=$fa_user?>"></i> <?=$_SESSION[$session_key]['user']['nickname']?></span>
		</p>
	</div>
</nav>
