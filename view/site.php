
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
		<?php if (! empty($notice_user)):?>
			<div class="alert alert-info" id="notice_user"><?=$notice_user?></div>
		<?php endif?>
		<?php if (! empty($notice_posttype)):?>
			<div class="alert alert-info" id="notice_posttype"><?=$notice_posttype?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<div id="edit_panel" class="panel <?=($mode==2)?'panel-primary':'panel-default'?>">
				<?php if ($mode == 2):?>
					<div class="panel-heading clearfix" id="panel_edit">
						<i class="fa fa-pencil-square-o"></i> <?=TXT_TAG_LBL_NOWEDIT($this_id)?>
						<?php if ($this_id == 1):?>
							<label for="allow_delete">
								<input id="allow_delete" type="checkbox" data-target_name="<?=TXT_SITE_LBL_MULTISITE?>" disabled>
								<?=TXT_SITE_LBL_DISALLOWDELETE?></label>
						<?php else:?>
							<label for="allow_delete">
								<input id="allow_delete" type="checkbox" data-target_name="<?=TXT_SITE_LBL_MULTISITE?>">
								<?=TXT_SITE_LBL_ALLOWDELETE?></label>
						<?php endif?>
						<a href="./"><?=TXT_SITE_LBL_CANCELEDIT?></a>
					</div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_SITE_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="site" role="form" action="./?mode=3" method="post">
						
						<div class="form-group col-md-3">
							<label class="control-label" for="name"><?=TXT_SITE_LBL_NAME?></label>
							<div><input class="form-control" type="text" id="name" name="name" value="<?=$this_name?>" placeholder="<?=TXT_SITE_PLH_NAME?>" required></div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="slug"><?=TXT_SITE_LBL_SLUG?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<div id="input_wrapper_slug" data-target_table="<?=$sortable_table?>" data-this_id="<?=$this_id?>">
								<input class="form-control needValidation" data-valid_type="slug" type="text" id="slug" name="slug" value="<?=$this_slug?>" placeholder="<?=TXT_SITE_PLH_SLUG?>" required>
							</div>
						</div>
						
						<div class="form-group col-md-3"></div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status_01"><?=TXT_SITE_LBL_STATUS?></label><br>
							<?php foreach ($common_status_display as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?> <?=($this_id==1&&$key==8)?'disabled':''?>> <?=$value?></label><br>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_id?>">
							<input type="hidden" id="host_activation" value="<?=$_SESSION[$session_key]['configs']['host_activation']?>">
							<input type="hidden" id="activation_key" value="<?=$_SESSION[$session_key]['configs']['activation_key']?>">
							<input type="hidden" id="verification_key" value="<?=$_SESSION[$session_key]['configs']['verification_key']?>">
							<br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_SITE_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_SITE_BTN_DELETE?>">
						</div>
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default sites">
					<div class="panel-heading">
						<?=TXT_SITE_LBL_LISTSITE?> <span id="amount" class="badge"><?=$record_counter?></span>
						<span><a href="./?view_page=cover&amp;entity_code=1"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?=TXT_COVER_LBL_TOCOVER?></a></span>
					</div>
					<div class="panel-body">
						<table id="sites" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_SITE_THD_ID?></th>
								<th><?=TXT_SITE_THD_NAME?></th>
								<th><?=TXT_SITE_THD_SLUG?></th>
								<th><?=TXT_SITE_THD_STATUS?></th>
								<th></th>
							</tr>
							</thead>
							<tbody class="sortable" data-target_table="<?=$sortable_table?>">
							<?php foreach ($records as $key => $row):?>
								<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'active':''?>">
									<td class="<?=($row['id']==1)?'text-primary':''?>"><?=$row['id']?></td>
									<td><?=$row['name']?></td>
									<td><?=$row['slug']?></td>
									<td data-status="<?=$row['status']?>">
										<?php if ($row['status'] == 1):?>
											<label class="label label-primary"><?=TXT_SITE_LBL_DISPLAY?></label>
										<?php else:?>
											<label class="label label-danger"><?=TXT_SITE_LBL_UNDISPLAY?></label>
										<?php endif?>
									</td>
									<td>
										<?php if ($mode != 2):?>
											<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>"><?=TXT_SITE_LBL_EDIT?></a>
										<?php else:?>
											<a class="btn btn-default btn-xs" disabled><?=TXT_SITE_LBL_EDIT?></a>
										<?php endif?>
									</td>
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
<script src="js/check_slug.js"></script>