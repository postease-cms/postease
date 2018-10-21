
<!-- OUTER WRAP -->
<main id="content" class="col-md-10" data-target_table="<?=$sortable_table?>">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3></div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="post_wrap" class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<div id="edit_panel" class="panel <?=($mode==2)?'panel-primary':'panel-default'?>">
				<?php if ($mode == 2):?>
					<div class="panel-heading clearfix" id="panel_edit"><i class="fa fa-pencil-square-o"></i> <?=TXT_USER_LBL_NOWEDIT($this_account)?><input id="allow_delete" type="checkbox" type="checkbox" data-target_name="<?=$page_title_main?>"> <label for="allow_delete"><?=TXT_USER_LBL_ALLOWDELETE?></label><a href="./"><?=TXT_USER_LBL_CANCELEDIT?></a></div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_USER_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="user" role="form" action="./?mode=3" method="post">
						<div class="form-group col-md-3">
							<label class="control-label" for="account"><?=TXT_USER_LBL_ACCOUNT?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<div class="multistep10" id="input_wrapper_account" data-this_id="<?=$this_id?>">
								<input class="form-control needValidation" data-valid_type="account" tabindex="1" type="text" id="account" name="account" value="<?=$this_account?>" placeholder="<?=TXT_USER_PLH_ACCOUNT?>" <?=($mode==2)?'readonly':''?> required>
							</div>
							<?php if ($_SESSION[$session_key]['configs']['use_group_flg']):?>
								<label class="control-label" for="group_id"><?=TXT_USER_LBL_GROUPID?></label><br>
								<div class="multistep10">
									<select class="form-control" id="group_id" name="group_id" tabindex="4" >
										<?php if (empty($_SESSION[$session_key]['user']['group_id'])):?>
											<option value=""><?=TXT_USER_SEL_NOGROUP?></option>
										<?php endif?>
										<?php foreach ($groups as $key => $group):?>
											<option value="<?=$key?>" <?=($key==$this_group_id)?'selected':''?>><?=$group['name']?></option>
										<?php endforeach?>
									</select>
								</div>
							<?php endif?>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label" for="nickname"><?=TXT_USER_LBL_NICKNAME?></label>
							<div class="multistep10">
								<input class="form-control" type="text" id="nickname" name="nickname" tabindex="2" value="<?=$this_nickname?>" placeholder="<?=TXT_USER_PLH_NICKNAME?>">
							</div>
							<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg'] || $_SESSION[$session_key]['configs']['use_posttype_flg'] || $_SESSION[$session_key]['configs']['use_contact_flg'] || $_SESSION[$session_key]['configs']['use_group_flg']):?>
								<label class="control-label" for="role"><?=TXT_USER_LBL_STATUS?></label><br>
								<div class="multistep10">
									<select class="form-control" id="role" name="role" tabindex="4">
										<?php foreach ($user_role as $key => $value):?>
											<?php if ($key > $_SESSION[$session_key]['user']['role']):?>
												<option value="<?=$key?>" <?=($key==$this_role)?'selected':''?>><?=$value?></option>
											<?php endif?>
										<?php endforeach?>
									</select>
								</div>
							<?php endif?>
						</div>
						
						<?php if ($_SESSION[$session_key]['user']['role'] <= 2 && ($_SESSION[$session_key]['configs']['use_multisite_flg'] || $_SESSION[$session_key]['configs']['use_posttype_flg'] || $_SESSION[$session_key]['configs']['use_contact_flg'])):?>
							<div class="form-group col-md-5">
								<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg']):?>
									<label class="control-label" for="site_id"><?=TXT_USER_LBL_SITEID?></label><br>
									<div class="multistep20">
										<?php foreach ($selectabel_sites as $key => $value):?>
											<label class="checkbox-inline" for="site_id<?=$key?>"><input type="checkbox" id="site_id<?=$key?>" name="site_id[]" value="<?=$key?>" <?=(in_array(intval($key),$this_site_id_arr)||($process==1&&empty($_GET['site_id'])))?'checked="checked"':''?>> <?=$value?></label>
										<?php endforeach?>
									</div>
								<?php endif?>
								<?php if ($_SESSION[$session_key]['user']['role'] <= 2 && ($_SESSION[$session_key]['configs']['use_posttype_flg'] || ! empty($posttype_id_arr))):?>
									<div class="<?=(! $_SESSION[$session_key]['configs']['use_posttype_flg'])?'hidden':null?>">
										<label class="control-label" for="posttype_id"><?=TXT_USER_LBL_POSTTYPEID?></label><br>
										<div class="multistep20">
											<?php foreach ($selectabel_posttypes as $key => $value):?>
												<label class="checkbox-inline" for="posttype_id<?=$key?>"><input type="checkbox" id="posttype_id<?=$key?>" name="posttype_id[]" value="<?=$key?>" <?=(in_array(intval($key),$this_posttype_id_arr)||($process==1&&empty($_GET['posttype_id'])))?'checked="checked"':''?>> <?=$value['name']?></label>
											<?php endforeach?>
										</div>
									</div>
								<?php endif?>
								<?php if ($_SESSION[$session_key]['configs']['use_contact_flg'] || ! empty($posttype_extra_id_arr)):?>
									<div class="<?=(! $_SESSION[$session_key]['configs']['use_contact_flg'])?'hidden':null?>">
										<label class="control-label" for="posttype_extra_id">
											<?php if ($_SESSION[$session_key]['configs']['use_posttype_flg']):?>
												<?=TXT_USER_LBL_POSTTYPEEXTRAID?>
											<?php else:?>
												<?=TXT_USER_LBL_CONTACTACCESS?>
											<?php endif?>
										</label><br>
										<div class="multistep20">
											<?php foreach ($selectabel_contacts as $key => $value):?>
												<label class="checkbox-inline" for="posttype_extra_id<?=$key?>"><input type="checkbox" id="posttype_extra_id<?=$key?>" name="posttype_extra_id[]" value="<?=$key?>" <?=(in_array(intval($key),$this_posttype_extra_id_arr)||($process==1&&empty($_GET['posttype_extra_id'])))?'checked="checked"':''?>> <?=$value['name']?></label>
											<?php endforeach?>
										</div>
									</div>
								<?php endif?>
							</div>
						<?php elseif (! $_SESSION[$session_key]['configs']['use_group_flg']):?>
							<div class="form-group col-md-3 col-md-offset-2">
								<label class="control-label" for="role"><?=TXT_USER_LBL_STATUS?></label><br>
								<div class="multistep10">
									<select class="form-control" id="role" name="role">
										<?php foreach ($user_role as $key => $value):?>
											<?php if ($key > $_SESSION[$session_key]['user']['role']):?>
												<option value="<?=$key?>" <?=($key==$this_role)?'selected':''?>><?=$value?></option>
											<?php endif?>
										<?php endforeach?>
									</select>
								</div>
							</div>
						<?php else:?>
							<div class="form-group col-md-5"></div>
						<?php endif?>
						
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_id?>"><br>
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_USER_BTN_UPDATE?>">
							<input class="btn btn-danger" type="submit" id="do_delete" name="do_delete" value="<?=TXT_USER_BTN_DELETE?>">
						</div>
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default registerdList">
					<div class="panel-heading"><?=$page_title_main?> <?=TXT_USER_LBL_LIST?> <span id="amount" class="badge"><?=$record_counter?></span></div>
					<div class="panel-body">
						<table id="users" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_USER_THD_ID?></th>
								<th><?=TXT_USER_THD_ACCOUNT?></th>
								<th><?=TXT_USER_THD_NICKNAME?></th>
								<th><?=($_SESSION[$session_key]['configs']['use_group_flg'])?TXT_USER_THD_GROUPNAME:''?></th>
								<th>
									<?php if ($num_column05 > 1):?>
										<a href="./?multi_column05=<?=$next_num?>"><?=$content_column05[$multi_column05]['title']?></a>
									<?php elseif ($num_column05 == 1):?>
										<?=$content_column05[$multi_column05]['title']?>
									<?php endif?>
								</th>
								<th><?=TXT_USER_THD_ROLE?></th>
								<th></th>
							</tr>
							</thead>
							<tbody data-target_table="users">
							<?php foreach ($records as $key => $row):?>
								<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'active':''?>">
									<td><?=$row['id']?></td>
									<td><?=$row['account']?></td>
									<td><?=$row['nickname']?></td>
									<td><?=($_SESSION[$session_key]['configs']['use_group_flg'])?$row['group_name']:''?></td>
									<td>
										<?php if ($num_column05):?>
											<?=$row[$content_column05[$multi_column05]['key']]?>
										<?php endif?>
									</td>
									<td><?=$user_role[$row['role']]?></td>
									<td><a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>" <?=($mode==2)?'disabled':''?>><?=TXT_USER_LBL_EDIT?></a></td>
								</tr>
							<?php endforeach?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endif?>
		</div>
	</div>
</main>
<script src="js/edit_hierarchy.js"></script>