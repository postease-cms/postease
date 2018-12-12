
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3></div>
	</div>
	
	<!-- INNER WRAP -->
	<div class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show config">
			
			<!-- Site Option -->
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGOPTION_LBL_TITLE_SITE?></h3></div>
				<div id="panel_option_site" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- use_multisite_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_multisite_flg"><?=TXT_CONFIGOPTION_LBL_USEMULTISITEFLG?>
								<a class="notice_yellow" data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_BUISINESS?>" data-content="<?=$popover['charged_option']?>">[B]</a>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_USEMULTISITEFLG?>" data-content="<?=$popover['use_multisite_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_multisite_flg_<?=$key?>"><input type="radio" id="use_multisite_flg_<?=$key?>" name="use_multisite_flg" value="<?=$key?>" <?=($key==$records['use_multisite_flg']['value'])?'checked':''?> <?=($_SESSION[$session_key]['license']['extra_license_code']==0&&$key==1)?'disabled':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_posttype_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_posttype_flg"><?=TXT_CONFIGOPTION_LBL_USEPOSTTYPEFLG?>
								<a class="notice_yellow" data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_BUISINESS?>" data-content="<?=$popover['charged_option']?>">[B]</a>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_USEPOSTTYPEFLG?>" data-content="<?=$popover['use_posttype_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_posttype_flg_<?=$key?>"><input type="radio" id="use_posttype_flg_<?=$key?>" name="use_posttype_flg" value="<?=$key?>" <?=($key==$records['use_posttype_flg']['value'])?'checked':''?> <?=($_SESSION[$session_key]['license']['extra_license_code']==0&&$key==1)?'disabled':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_multilingual_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_multilingual_flg"><?=TXT_CONFIGOPTION_LBL_USEMULTILINGUALFLG?>
								<a class="notice_yellow" data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_BUISINESS?>" data-content="<?=$popover['charged_option']?>">[B]</a>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_USEMULTILINGUALFLG?>" data-content="<?=$popover['use_multilingual_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_multilingual_flg_<?=$key?>"><input type="radio" id="use_multilingual_flg_<?=$key?>" name="use_multilingual_flg" value="<?=$key?>" <?=($key==$records['use_multilingual_flg']['value'])?'checked':''?> <?=($_SESSION[$session_key]['license']['extra_license_code']==0&&$key==1)?'disabled':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="option_site">
								<input class="btn btn-primary width120" type="submit" id="submit_record01" name="submit_record" value="<?=TXT_CONFIGOPTION_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<!-- Other Option -->
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGOPTION_LBL_TITLE_OTHERS?></h3></div>
				<div id="panel_option_others" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- use_contact_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_contact_flg"><?=TXT_CONFIGOPTION_LBL_USECONTACTFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_USECONTACTFLG?>" data-content="<?=$popover['use_contact_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_contact_flg_<?=$key?>"><input type="radio" id="use_contact_flg_<?=$key?>" name="use_contact_flg" value="<?=$key?>" <?=($key==$records['use_contact_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_group_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_group_flg"><?=TXT_CONFIGOPTION_LBL_USEGROUPFLG?>
								<a class="notice_yellow" data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_BUISINESS?>" data-content="<?=$popover['charged_option']?>">[B]</a>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_USEGROUPFLG?>" data-content="<?=$popover['use_group_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_group_flg_<?=$key?>"><input type="radio" id="use_group_flg_<?=$key?>" name="use_group_flg" value="<?=$key?>" <?=($key==$records['use_group_flg']['value'])?'checked':''?> <?=($_SESSION[$session_key]['license']['extra_license_code']==0&&$key==1)?'disabled':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_version_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_version_flg"><?=TXT_CONFIGOPTION_LBL_USEVERSIONFLG?>
								<a class="notice_yellow" data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_BUISINESS?>" data-content="<?=$popover['charged_option']?>">[B]</a>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGOPTION_LBL_USEVERSIONFLG?>" data-content="<?=$popover['use_version_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_version_flg_<?=$key?>"><input type="radio" id="use_version_flg_<?=$key?>" name="use_version_flg" value="<?=$key?>" <?=($key==$records['use_version_flg']['value'])?'checked':''?> <?=($_SESSION[$session_key]['license']['extra_license_code']==0&&$key==1)?'disabled':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="option_others">
								<input class="btn btn-primary width120" type="submit" id="submit_record02" name="submit_record" value="<?=TXT_CONFIGOPTION_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
		
		</div>
	</div>
</main>
<script src="js/config.js"></script>