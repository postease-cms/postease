
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
			
			<!-- Config Core -->
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="configcoreHeading panel-title"><?=TXT_CONFIGCORE_LBL_SYSTEM?></h3>
				</div>
				<div id="panel_core_system" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- domain -->
						<div class="form-group">
							<label class="control-label col-md-4" for="domain"><?=TXT_CONFIGCORE_LBL_DOMAIN?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_DOMAIN?>" data-content="<?=$popover['domain']?>">[?]</a>
							</label>
							<div class="col-md-4 <?=($invalid_domain_flg)?'has-error':''?>">
								<input class="form-control" type="text" id="domain" name="domain" value="<?=$records['domain']['value']?>" readonly required>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- dir_name -->
						<div class="form-group">
							<label class="control-label col-md-4" for="dir_name"><?=TXT_CONFIGCORE_LBL_DIRNAME?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_DIRNAME?>" data-content="<?=$popover['dir_name']?>">[?]</a>
							</label>
							<div class="col-md-4 <?=($invalid_dir_name_flg)?'has-error':''?>">
								<input class="form-control" type="text" id="dir_name" name="dir_name" value="<?=$records['dir_name']['value']?>" readonly required>
							</div>
							<div class="col-md-4">
								<?php if ($invalid_domain_flg || $invalid_dir_name_flg):?>
									<input class="btn btn-danger" type="submit" id="auto_correct" name="auto_correct" value="<?=TXT_CONFIGCORE_BTN_FIXURLDIRNAME?>">
								<?php endif?>
							</div>
						</div>
						
						<!-- timezone -->
						<div class="form-group">
							<label class="control-label col-md-4" for="timezone"><?=TXT_CONFIGCORE_LBL_TIMEZONE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_TIMEZONE?>" data-content="<?=$popover['timezone']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="timezone" name="timezone" >
									<?php foreach ($timezones as $value):?>
										<option value="<?=$value?>"<?=($records['timezone']['value']==$value)?' selected="selected"':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- session_key -->
						<div class="form-group">
							<label class="control-label col-md-4" for="session_key"><?=TXT_CONFIGCORE_LBL_SESSIONKEY?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_SESSIONKEY?>" data-content="<?=$popover['session_key']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="session_key" name="session_key" value="<?=$records['session_key']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- display_errors -->
						<div class="form-group">
							<label class="control-label col-md-4" for="display_errors"><?=TXT_CONFIGCORE_LBL_DISPLAYERRORS?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_DISPLAYERRORS?>" data-content="<?=$popover['display_errors']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="display_errors" name="display_errors" >
									<?php foreach ($display_errors_list as $key => $value):?>
										<option value="<?=$key?>"<?=($records['display_errors']['value']==$key)?' selected="selected"':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- default_password -->
						<div class="form-group">
							<label class="control-label col-md-4" for="default_password"><?=TXT_CONFIGCORE_LBL_DEFAULTPASSWORD?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_DEFAULTPASSWORD?>" data-content="<?=$popover['default_password']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="default_password" name="default_password" value="<?=$records['default_password']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="core_system">
								<input class="btn btn-warning width120" type="submit" id="update_core_system" name="update_core_system" value="<?=TXT_CONFIGCORE_BTN_SUBMIT?>">
							</div>
						</div>
					
					</form>
				</div>
			</div>
			
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="configcoreHeading panel-title"><?=TXT_CONFIGCORE_LBL_AUTHORITY?></h3>
				</div>
				<div id="panel_core_authority" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- edit_controll -->
						<div class="form-group">
							<label class="control-label col-md-4" for="edit_controll"><?=TXT_CONFIGCORE_LBL_EDITCONTROLL?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_EDITCONTROLL?>" data-content="<?=$popover['edit_controll']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($edit_controll_list as $key => $value):?>
									<label class="radio-inline" for="edit_controll_<?=$key?>"><input type="radio" id="edit_controll_<?=$key?>" name="edit_controll" value="<?=$key?>" <?=($key==$records['edit_controll']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- publish_role -->
						<div class="form-group">
							<label class="control-label col-md-4" for="publish_role"><?=TXT_CONFIGCORE_LBL_PUBLISHROLE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_PUBLISHROLE?>" data-content="<?=$popover['publish_role']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="publish_role" name="publish_role" style="width: 100%">
									<?php foreach ($editable_role_list as $key => $value):?>
										<option value="<?=$key?>"<?=($records['publish_role']['value']==$key)?' selected="selected"':''?>><?=TXT_CONFIGCORE_LBL_MORETHAN($value)?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- editable_role_category_post -->
						<div class="form-group">
							<label class="control-label col-md-4" for="editable_role_category_post"><?=TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYPOST?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYPOST?>" data-content="<?=$popover['editable_role_category_post']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="editable_role_category_post" name="editable_role_category_post" style="width: 100%">
									<?php foreach ($editable_role_list as $key => $value):?>
										<option value="<?=$key?>"<?=($records['editable_role_category_post']['value']==$key)?' selected="selected"':''?>><?=TXT_CONFIGCORE_LBL_MORETHAN($value)?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- editable_role_tag_post -->
						<div class="form-group">
							<label class="control-label col-md-4" for="editable_role_tag_post"><?=TXT_CONFIGCORE_LBL_EDITABLEROLLTAGPOST?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_EDITABLEROLLTAGPOST?>" data-content="<?=$popover['editable_role_tag_post']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="editable_role_tag_post" name="editable_role_tag_post" style="width: 100%">
									<?php foreach ($editable_role_list as $key => $value):?>
										<option value="<?=$key?>"<?=($records['editable_role_tag_post']['value']==$key)?' selected="selected"':''?>><?=TXT_CONFIGCORE_LBL_MORETHAN($value)?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- editable_role_category_contact -->
						<div class="form-group">
							<label class="control-label col-md-4" for="editable_role_category_contact"><?=TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYCONTACT?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYCONTACT?>" data-content="<?=$popover['editable_role_category_contact']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="editable_role_category_contact" name="editable_role_category_contact" style="width: 100%">
									<?php foreach ($editable_role_list as $key => $value):?>
										<option value="<?=$key?>"<?=($records['editable_role_category_contact']['value']==$key)?' selected="selected"':''?>><?=TXT_CONFIGCORE_LBL_MORETHAN($value)?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="core_authority">
								<input class="btn btn-warning width120" type="submit" id="update_core" name="update_core_authority" value="<?=TXT_CONFIGCORE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="configcoreHeading panel-title"><?=TXT_CONFIGCORE_LBL_MEDIA?></h3>
				</div>
				<div id="panel_core_media" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- upload_dir_permission -->
						<div class="form-group">
							<label class="control-label col-md-4" for="upload_dir_permission"><?=TXT_CONFIGCORE_LBL_UPLOADDIRPERMISSION?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_UPLOADDIRPERMISSION?>" data-content="<?=$popover['upload_dir_permission']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="upload_dir_permission" name="upload_dir_permission" value="<?=$records['upload_dir_permission']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- upload_imagesize_main -->
						<div class="form-group">
							<label class="control-label col-md-4" for="upload_imagesize_main_width"><?=TXT_CONFIGCORE_LBL_UPLOADIMAGESIZEMAIN?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_UPLOADIMAGESIZEMAIN?>" data-content="<?=$popover['upload_imagesize_main']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?=TXT_CONFIGCORE_LBL_MAXWIDTH?> : <input class="form-control inlineRight40 multistep10" type="text" id="upload_imagesize_main_width" name="upload_imagesize_main_width" value="<?=($records['upload_imagesize_main_width']['value'])?$records['upload_imagesize_main_width']['value']:''?>"> px<br>
								<?=TXT_CONFIGCORE_LBL_MAXHEIGHT?> : <input class="form-control inlineRight40" type="text" id="upload_imagesize_main_height" name="upload_imagesize_main_height" value="<?=($records['upload_imagesize_main_height']['value'])?$records['upload_imagesize_main_height']['value']:''?>"> px
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- media_parameter_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="media_parameter_flg"><?=TXT_CONFIGCORE_LBL_MEDIAPARAMETERFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_MEDIAPARAMETERFLG?>" data-content="<?=$popover['media_parameter_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="media_parameter_flg_<?=$key?>"><input type="radio" id="media_parameter_flg_<?=$key?>" name="media_parameter_flg" value="<?=$key?>" <?=($key==$records['media_parameter_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="core_media">
								<input class="btn btn-warning width120" type="submit" id="update_core" name="update_core_media" value="<?=TXT_CONFIGCORE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="configcoreHeading panel-title"><?=TXT_CONFIGCORE_LBL_UPDATE?></h3>
				</div>
				<div id="panel_core_update" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- update_allowed_role -->
						<div class="form-group">
							<label class="control-label col-md-4" for="update_allowed_role"><?=TXT_CONFIGCORE_LBL_UPDATEALLOWEDROLE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_UPDATEALLOWEDROLE?>" data-content="<?=$popover['update_allowed_role']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="update_allowed_role" name="update_allowed_role" style="width: 100%">
									<?php foreach ($user_role as $key => $value):?>
										<option value="<?=$key?>"<?=($records['update_allowed_role']['value']==$key)?' selected="selected"':''?>><?=$value?> (<?=TXT_CONFIGCORE_LBL_UPDATELEVELOROVER?>)</option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- allow_update_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="allow_update_flg"><?=TXT_CONFIGCORE_LBL_ALLOWUPDATEFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_ALLOWUPDATEFLG?>" data-content="<?=$popover['allow_update_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_permission as $key => $value):?>
									<label class="radio-inline" for="allow_update_flg_<?=$key?>"><input type="radio" id="allow_update_flg_<?=$key?>" name="allow_update_flg" value="<?=$key?>" <?=($key==$records['allow_update_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- auto_update_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="auto_update_flg"><?=TXT_CONFIGCORE_LBL_AUTOUPDATEFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_AUTOUPDATEFLG?>" data-content="<?=$popover['auto_update_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_permission as $key => $value):?>
									<label class="radio-inline" for="auto_update_flg_<?=$key?>"><input type="radio" id="auto_update_flg_<?=$key?>" name="auto_update_flg" value="<?=$key?>" <?=($key==$records['auto_update_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- update_level -->
						<div class="form-group">
							<label class="control-label col-md-4" for="update_level"><?=TXT_CONFIGCORE_LBL_UPDATELEVEL?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_UPDATELEVEL?>" data-content="<?=$popover['update_level']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="update_level" name="update_level" style="width: 100%">
									<?php foreach ($update_level as $key => $value):?>
										<option value="<?=$key?>"<?=($records['update_level']['value']==$key)?' selected="selected"':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="core_update">
								<input class="btn btn-warning width120" type="submit" id="update_core" name="update_core_update" value="<?=TXT_CONFIGCORE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="configcoreHeading panel-title"><?=TXT_CONFIGCORE_LBL_DATAMANIPULATION?></h3>
				</div>
				<div id="panel_core_data_manipulation" class="panel-body">
					<!-- change_database -->
					<div class="form-group">
						<label class="control-label col-md-4" for="change_database"><?=TXT_CONFIGCORE_LBL_CHANGEDATABASE?>
							<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCORE_LBL_CHANGEDATABASE?>" data-content="<?=$popover['change_database']?>">[?]</a>
						</label>
						<div class="col-md-4">
							<span id="change_database"><a href="./reset_system.php?mode=2"><i class="fa fa-exclamation-circle"></i> <?=TXT_CONFIGCORE_LNK_CHANGEDATABASE?></a></span>
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
			</div>
		
		</div>
	</div>
</main>
<script src="js/config.js"></script>