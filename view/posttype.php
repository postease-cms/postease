<!-- OUTER WRAP -->
<main id="content" class="col-md-10" data-target_table="<?=$sortable_table?>">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="fa <?=$page_icon?>"></i>
				<?=$page_title_main?>
				<?php if ($_SESSION[$session_key]['configs']['use_contact_flg']):?>
					<?php if ($post_type == 'post'):?>
						<?=TXT_POSTTYPE_LBL_POST?>
					<?php else:?>
						<?=TXT_POSTTYPE_LBL_CONTACT?>
					<?php endif?>
				<?php endif?>
				<?=$page_title_sub?>
				<?php if ($_SESSION[$session_key]['configs']['use_contact_flg']):?>
					<?php if ($post_type == 'post'):?>
						<a id="chanage_post_type" href="./?post_type=contact">
							<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
							<?=TXT_POSTTYPE_LBL_CONTACT?>
						</a>
					<?php else:?>
						<a id="chanage_post_type" href="./?post_type=post">
							<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
							<?=TXT_POSTTYPE_LBL_POST?>
						</a>
					<?php endif?>
				<?php endif?>
			</h3>
		</div>
	</div>
	
	<!-- INNER WRAP -->
	<div class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		<?php if (! empty($notice_user)):?>
			<div class="alert alert-info" id="notice_user"><?=$notice_user?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<div id="edit_panel" class="panel <?=($mode==2)?'panel-primary':'panel-default'?>">
				<?php if ($mode == 2):?>
					<div class="panel-heading clearfix" id="panel_edit">
						<i class="fa fa-pencil-square-o"></i> <?=TXT_POSTTYPE_LBL_NOWEDIT('ID'.$this_id)?>
						<?php if ($this_id == 1 || $this_id == 1001):?>
							<label for="allow_delete">
								<input id="allow_delete" type="checkbox" data-target_name="<?=TXT_POSTTYPE_LBL_MULTIPOST?>" disabled>
								<?php if ($this_id == 1):?>
									<?=TXT_POSTTYPE_LBL_DISALLOWDELETEPOST?>
								<?php elseif ($this_id == 1001):?>
									<?=TXT_POSTTYPE_LBL_DISALLOWDELETECONTACT?>
								<?php endif?>
							</label>
						<?php else:?>
							<label for="allow_delete">
								<input id="allow_delete" type="checkbox" data-target_name="<?=TXT_POSTTYPE_LBL_MULTIPOST?>">
								<?=TXT_POSTTYPE_LBL_ALLOWDELETE?></label>
						<?php endif?>
						<a href="./"><?=TXT_POSTTYPE_LBL_CANCELEDIT?></a>
					</div>
				<?php else:?>
					<div class="panel-heading" id="panel_new">
						<i class="fa fa-plus-circle"></i> <?=TXT_POSTTYPE_LBL_NEW?>
						<?php if ($post_type == 'post'):?>
							<?=TXT_POSTTYPE_LBL_POST?>
						<?php else:?>
							<?=TXT_POSTTYPE_LBL_CONTACT?>
						<?php endif?>
					</div>
				<?php endif?>
				<div class="panel-body">
					<form id="posttype" role="form" action="./?mode=3" method="post">
						<div class="form-group col-md-3">
							<label class="control-label" for="name"><?=TXT_POSTTYPE_LBL_NAME?></label>
							<div class="multistep10">
								<input class="form-control" tabindex="1" type="text" id="name" name="name" value="<?=$this_name?>" placeholder="<?=TXT_POSTTYPE_PLH_NAME?>" required>
							</div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="slug"><?=TXT_POSTTYPE_LBL_SLUG?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<div class="multistep10" id="input_wrapper_slug" data-target_table="<?=$sortable_table?>" data-this_id="<?=$this_id?>">
								<input class="form-control needValidation" data-valid_type="slug" tabindex="2" type="text" id="slug" name="slug" value="<?=$this_slug?>" placeholder="<?=TXT_POSTTYPE_PLH_SLUG?>" required>
							</div>
						</div>
						
						<div class="form-group col-md-4">
							<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg']):?>
								<div class="multistep20">
									<label class="control-label" for="site_id"><?=TXT_POSTTYPE_LBL_SITEID?></label><br>
									<?php foreach ($_SESSION[$session_key]['common']['sites'] as $key => $value):?>
										<label class="checkbox-inline" for="site_id<?=$key?>"><input type="checkbox" id="site_id<?=$key?>" name="site_id[<?=$key?>]" value="<?=$key?>" <?=(in_array(intval($key), $this_site_id_arr)||($process==1&&empty($_GET['error_code'])))?'checked="checked"':''?>> <?=$value?></label>
									<?php endforeach?>
								</div>
							<?php endif?>
							<?php if ($_SESSION[$session_key]['configs']['use_multilingual_flg']):?>
								<div class="multistep20">
									<label class="control-label" for="language_id"><?=TXT_POSTTYPE_LBL_LANGUAGEID?></label><br>
									<?php foreach ($languages_all as $key => $value):?>
										<label class="checkbox-inline" for="language_id<?=$key?>"><input type="checkbox" id="language_id<?=$key?>" name="language_id[<?=$key?>]" value="<?=$key?>" <?=(in_array(intval($key), $this_language_id_arr)||($process==1&&empty($_GET['error_code'])))?'checked="checked"':''?> <?=($key==1)?'disabled':''?>><?=$value?> <?=($key==1)?TXT_POSTTYPE_LBL_LANGUAGEDEFAULT:''?></label>
										<?php if ($key == 1):?>
											<input type="hidden" name="language_id[<?=$key?>]" value="<?=$key?>">
										<?php endif?>
									<?php endforeach?>
								</div>
							<?php endif?>
						</div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status_01"><?=TXT_POSTTYPE_LBL_STATUS?></label><br>
							<?php foreach ($common_status_display as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?> <?=(($this_id==1||$this_id==1001)&&$key==8)?'disabled':''?>> <?=$value?></label><br>
							<?php endforeach?>
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_id?>">
							<input type="hidden" id="post_type" name="post_type" value="<?=$post_type?>">
							<input type="hidden" id="host_activation" value="<?=$_SESSION[$session_key]['configs']['host_activation']?>">
							<input type="hidden" id="activation_key" value="<?=$_SESSION[$session_key]['configs']['activation_key']?>">
							<input type="hidden" id="verification_key" value="<?=$_SESSION[$session_key]['configs']['verification_key']?>">
							<?php if ($post_type >= 1001):?>
								<input type="hidden" id="wisiwyg_flg" name="wisiwyg_flg" value="0">
								<input type="hidden" id="type" name="type" value="0">
							<?php endif?>
							<br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_POSTTYPE_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_POSTTYPE_BTN_DELETE?>">
						</div>
					
					</form>
				</div>
			</div>
			
			<?php if ($post_type == 'post'):?>
				<?php if (count($records_post)):?>
					<!-- LIST -->
					<div class="panel panel-default registerdList">
						<div class="panel-heading">
							<?=TXT_POSTTYPE_LBL_LISTPOST?> <span id="amount" class="badge"><?=$record_counter_post?></span>
							<span><a href="./?view_page=cover&amp;entity_code=2&amp;type=post"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?=TXT_COVER_LBL_TOCOVER?></a></span>
						</div>
						<div class="panel-body">
							<table id="posttypes" class="table table-hover">
								<thead>
								<tr>
									<th><?=TXT_POSTTYPE_THD_ID?></th>
									<th><?=TXT_POSTTYPE_THD_NAME?></th>
									<th><?=TXT_POSTTYPE_THD_SLUG?></th>
									<th><?=($_SESSION[$session_key]['configs']['use_multisite_flg'])?TXT_POSTTYPE_THD_SITEID:''?></th>
									<th><?=($_SESSION[$session_key]['configs']['use_multilingual_flg'])?TXT_POSTTYPE_THD_LANGUAGEID:''?></th>
									<th><?=TXT_POSTTYPE_THD_STATUS?></th>
									<th></th>
								</tr>
								</thead>
								<tbody class="sortable" data-target_table="<?=$sortable_table?>">
								<?php foreach ($records_post as $key => $row):?>
									<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'info':''?>">
										<td class="<?=($row['id']==1)?'text-primary':''?>"><?=$row['id']?></td>
										<td><?=$row['name']?></td>
										<td><?=$row['slug']?></td>
										<td><?=($_SESSION[$session_key]['configs']['use_multisite_flg'])?$row['site_names']:''?></td>
										<td><?=($_SESSION[$session_key]['configs']['use_multilingual_flg'])?$row['language_names']:''?></td>
										<td data-status="<?=$row['status']?>">
											<?php if ($row['status'] == 1):?>
												<label class="label label-primary"><?=TXT_POSTTYPE_LBL_DISPLAY?></label>
											<?php else:?>
												<label class="label label-danger"><?=TXT_POSTTYPE_LBL_UNDISPLAY?></label>
											<?php endif?>
										</td>
										<td>
											<?php if ($mode != 2):?>
												<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>&amp;post_type=post"><?=TXT_POSTTYPE_LBL_EDIT?></a>
											<?php else:?>
												<a class="btn btn-default btn-xs" disabled><?=TXT_POSTTYPE_LBL_EDIT?></a>
											<?php endif?>
										</td>
									</tr>
								<?php endforeach?>
								</tbody>
							</table>
						</div>
					</div>
				<?php endif?>
			<?php endif?>
			
			<?php if ($post_type == 'contact'):?>
				<?php if (count($records_contact)):?>
					<!-- LIST -->
					<div class="panel panel-default registerdList">
						<div class="panel-heading">
							<?=TXT_POSTTYPE_LBL_LISTCONTACT?> <span id="amount" class="badge"><?=$record_counter_contact?></span>
							<span><a href="./?view_page=cover&amp;entity_code=2&amp;type=contact"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?=TXT_COVER_LBL_TOCOVER?></a></span>
						</div>
						<div class="panel-body">
							<table id="posttypes" class="table table-hover">
								<thead>
								<tr>
									<th><?=TXT_POSTTYPE_THD_ID?></th>
									<th><?=TXT_POSTTYPE_THD_NAME?></th>
									<th><?=TXT_POSTTYPE_THD_SLUG?></th>
									<th><?=($_SESSION[$session_key]['configs']['use_multisite_flg'])?TXT_POSTTYPE_THD_SITEID:''?></th>
									<th><?=($_SESSION[$session_key]['configs']['use_multilingual_flg'])?TXT_POSTTYPE_THD_LANGUAGEID:''?></th>
									<th></th>
									<th><?=TXT_POSTTYPE_THD_STATUS?></th>
									<th></th>
								</tr>
								</thead>
								<tbody class="sortable" data-target_table="<?=$sortable_table?>">
								<?php foreach ($records_contact as $key => $row):?>
									<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'active':''?>">
										<td class="<?=($row['id']==1001)?'text-primary':''?>"><?=$row['id']?></td>
										<td><?=$row['name']?></td>
										<td><?=$row['slug']?></td>
										<td><?=($_SESSION[$session_key]['configs']['use_multisite_flg'])?$row['site_names']:''?></td>
										<td><?=($_SESSION[$session_key]['configs']['use_multilingual_flg'])?$row['language_names']:''?></td>
										<td></td>
										<td data-status="<?=$row['status']?>">
											<?php if ($row['status'] == 1):?>
												<label class="label label-primary"><?=TXT_POSTTYPE_LBL_DISPLAY?></label>
											<?php else:?>
												<label class="label label-danger"><?=TXT_POSTTYPE_LBL_UNDISPLAY?></label>
											<?php endif?>
										</td>
										<td><a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>&amp;post_type=contact" <?=($mode==2)?'disabled':''?>><?=TXT_POSTTYPE_LBL_EDIT?></a></td>
									</tr>
								<?php endforeach?>
								</tbody>
							</table>
						</div>
					</div>
				<?php endif?>
			<?php endif?>
		
		</div>
	</div>
</main>
<script src="js/edit_hierarchy.js"></script>
<script src="js/check_slug.js"></script>