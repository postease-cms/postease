<nav id="main_menu" class="col-md-2" data-lang="<?=$_SESSION[$session_key]['user']['lang']?>">
	<ul class="list-group">
		<?php if (! empty($_SESSION[$session_key]['common']['this_site'])):?>
		<?php if (! empty($_SESSION[$session_key]['common']['posttypes'])):?>
		<?php foreach ($_SESSION[$session_key]['common']['posttypes'] as $key => $values):?>
		<li class="list-group-item pointer">
			<?php if (! empty($values['menu_icon'])):?>
			<i class="fa fa-<?=$values['menu_icon']?>"></i>
			<?php endif?>
			<?=$values['name']?>
			<div class="list-group hidden">
				<?php if (isset($_GET['process']) && $_GET['process'] == 12 && $key == $_SESSION[$session_key]['common']['this_posttype']):?>
				<a class="list-group-item"><?=TXT_MAINMENU_LBL_EDIT?></a>
				<?php else:?>
				<a class="list-group-item" href="./?view_page=posts&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_LIST?></a>
				<?php endif?>
				<a class="list-group-item" href="./?view_page=post&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>&amp;process=11"><?=TXT_MAINMENU_LBL_NEW?></a>
				<?php if ($_SESSION[$session_key]['user']['role'] <= $_SESSION[$session_key]['configs']['editable_role_category_post']):?>
				<?php if ($_SESSION[$session_key]['common']['posttypes'][$key]['use_category_flg']):?>
				<a class="list-group-item" href="./?view_page=category&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_CATEGORY?></a>
				<?php endif?>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['user']['role'] <= $_SESSION[$session_key]['configs']['editable_role_tag_post']):?>
				<?php if ($_SESSION[$session_key]['common']['posttypes'][$key]['use_tag_flg']):?>
				<a class="list-group-item" href="./?view_page=tag&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_TAG?></a>
				<?php endif?>
				<?php endif?>
				<?php if ($values['use_customitem_flg'] && $_SESSION[$session_key]['user']['role'] < 7):?>
				<a class="list-group-item" href="./?view_page=custom_item&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_CUSTOMITEM?></a>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
				<a class="list-group-item" href="./?view_page=config_posttype&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><i class="fa fa-cog" aria-hidden="true"></i> <?=TXT_MAINMENU_LBL_CONFIGPOSTTYPE?></a>
				<?php endif?>
				<?php if (! empty($values['comment_type'])):?>
				<?php foreach (explode(',', $values['comment_type']) as $value1):?>
				<?php if ($value1 == 1):?>
				<a class="list-group-item" href="./?view_page=comments&amp;clear_layer=1&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>&amp;type=1&amp;page=1&amp;multi_column03=1&amp;sc_score="><i class="fa fa-comment"></i> <?=$posttype_comment_type[$value1]?></a>
				<?php elseif ($value1 == 2):?>
				<a class="list-group-item" href="./?view_page=comments&amp;clear_layer=1&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>&amp;type=2&amp;page=1&amp;multi_column03=2"><i class="fa fa-star-half-o"></i> <?=$posttype_comment_type[$value1]?></a>
				<?php elseif ($value1 == 3):?>
				<a class="list-group-item" href="./?view_page=comments&amp;clear_layer=1&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>&amp;type=3&amp;page=1&amp;multi_column03=1&amp;sc_score="><i class="fa fa-paperclip"></i> <?=$posttype_comment_type[$value1]?></a>
				<?php endif?>
				<?php endforeach?>
				<?php endif?>
			</div>
		</li>
		<?php endforeach?>
		<?php endif?>
		<?php endif?>

		<?php if ($_SESSION[$session_key]['common']['use_contact_flg']):?>
		<?php if (! empty($_SESSION[$session_key]['common']['posttypes_extra'])):?>
		<?php foreach ($_SESSION[$session_key]['common']['posttypes_extra'] as $key => $values):?>
		<li class="list-group-item pointer"><i class="fa fa-envelope-o"></i>
			<?=$values['name']?>
			<div class="list-group hidden">
				<?php if (isset($_GET['process']) && $_GET['process'] == 32 && $key == $_SESSION[$session_key]['common']['this_posttype']):?>
				<a class="list-group-item"><?=TXT_MAINMENU_LBL_INQUIRY?></a>
				<?php else:?>
				<a class="list-group-item" href="./?view_page=contacts&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_LIST?></a>
				<?php endif?>
				<a class="list-group-item" href="./?view_page=contact&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>&amp;process=31"><?=TXT_MAINMENU_LBL_NEW?></a>
				<?php if ($_SESSION[$session_key]['user']['role'] != 8):?>
				<a class="list-group-item" href="./?view_page=category&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_CATEGORY?></a>
				<?php endif?>
				<?php if ($values['use_customitem_flg'] && $_SESSION[$session_key]['user']['role'] < 7):?>
				<a class="list-group-item" href="./?view_page=custom_item&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><?=TXT_MAINMENU_LBL_CUSTOMITEM?></a>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
				<a class="list-group-item" href="./?view_page=config_contact&amp;this_posttype=<?=$key?>&amp;this_posttype_order=<?=$values['line_order']?>"><i class="fa fa-cog" aria-hidden="true"></i> <?=TXT_MAINMENU_LBL_CONFIGCONTACT?></a>
				<?php endif?>
			</div>
		</li>
		<?php endforeach?>
		<?php endif?>
		<?php endif?>

		<li class="list-group-item pointer"><i class="fa fa-picture-o"></i> <?=TXT_MAINMENU_LBL_MEDIA?>
			<div class="list-group hidden">
				<a class="list-group-item" href="./?view_page=media"><?=TXT_MAINMENU_LBL_EDIT?></a>
				<?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
				<a class="list-group-item" href="./?view_page=image_frame"><?=TXT_MAINMENU_LBL_IMAGE_CONFIG?></a>
				<?php endif?>
			</div>
		</li>

		<li class="list-group-item pointer"><i class="fa fa-user"></i> <?=TXT_MAINMENU_LBL_USER?>
			<div class="list-group hidden">
				<?php if ($_SESSION[$session_key]['user']['role'] <= 7):?>
				<a class="list-group-item" href="./?view_page=user"><?=TXT_MAINMENU_LBL_EDIT?></a>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['configs']['use_group_flg'] && $_SESSION[$session_key]['user']['role'] <= 2):?>
				<a class="list-group-item" href="./?view_page=group"><?=TXT_MAINMENU_LBL_GROUP?></a>
				<?php endif?>
				<a class="list-group-item" href="./?view_page=change_password"><?=TXT_MAINMENU_LBL_CHANGE_PASS?></a>
			</div>
		</li>

		<?php if ($option_count && $_SESSION[$session_key]['user']['role'] <= 2):?>
		<li class="list-group-item pointer"><i class="fa fa-plus"></i> <?=TXT_MAINMENU_LBL_SITE_OPTION?>
			<div class="list-group hidden">
				<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg']):?>
				<a class="list-group-item" href="./?view_page=site"><?=TXT_MAINMENU_LBL_SITE?></a>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['configs']['use_posttype_flg']):?>
				<a class="list-group-item" href="./?view_page=posttype"><?=TXT_MAINMENU_LBL_POSTTYPE?></a>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['configs']['use_multilingual_flg']):?>
				<a class="list-group-item" href="./?view_page=language"><?=TXT_MAINMENU_LBL_LANGUAGE?></a>
				<?php endif?>
			</div>
		</li>
		<?php endif?>

		<?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
		<li class="list-group-item pointer"><i class="fa fa-cog"></i> <?=TXT_MAINMENU_LBL_CONFIG?>
			<div class="list-group hidden">
				<a class="list-group-item" href="./?view_page=config_general"><?=TXT_MAINMENU_LBL_GENERAL?></a>
				<?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
				<a class="list-group-item " href="./?view_page=config_option"><?=TXT_MAINMENU_LBL_OPTION?></a>
				<?php endif?>
				<?php if ($_SESSION[$session_key]['user']['role'] == 1):?>
				<a class="list-group-item <?=($_SESSION[$session_key]['user']['role']!=1)?'hidden':''?>" href="./?view_page=config_core"><?=TXT_MAINMENU_LBL_CORE?></a>
				<?php endif?>
			</div>
		</li>
		<?php endif?>

	</ul>
	<?php if (! empty($_SESSION[$session_key]['configs']['site_name'])):?>
  <div class="loginLogo-text inside"><img src="img/logo_small.svg" width="90px"></div>
  <?php endif?>
</nav>
<script>
var page = $('body').attr('id');
if (page != 'index' && page != 0)
{
	page = page.split('-');
	var page_main = '#main_menu li.list-group-item:nth-of-type(' + page[0] + ')';
	var page_sub = page_main + ' a.list-group-item:nth-of-type(' + page[1] + ')';
	$(page_main).addClass('back-gray').removeClass('pointer').addClass('opened');
	$(page_main + ' > div.list-group').removeClass('hidden');
	$(page_sub).addClass('active');
}
</script>