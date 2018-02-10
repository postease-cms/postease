
<!-- OUTER WRAP -->
<main id="content" class="col-md-10" data-target_table="<?=$sortable_table?>">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3>
			<span id="to_custom_list">
				<a href="./?view_page=custom_item"><i class="fa fa-arrow-left"></i> <?=TXT_CUSTOMLIST_LNK_CUSTOMITEM?></a>
			</span>
		</div>
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
					<div class="panel-heading clearfix" id="panel_edit"><i class="fa fa-pencil-square-o"></i> <?=TXT_CUSTOMLIST_LBL_NOWEDIT($this_id)?><input id="allow_delete" type="checkbox" data-target_name="<?=TXT_CUSTOMLIST_LBL_CUSTOMLIST?>"> <label for="allow_delete"><?=TXT_CUSTOMLIST_LBL_ALLOWDELETE?></label><a href="./"><?=TXT_CUSTOMLIST_LBL_CANCELEDIT?></a></div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_CUSTOMLIST_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="custom_item" role="form" action="./?mode=3" method="post">
						
						<div class="form-group col-md-3">
							<label class="control-label" for="name"><?=TXT_CUSTOMLIST_LBL_NAME?></label>
							<div><input class="form-control" type="text" id="name" name="name" value="<?=$this_name?>" placeholder="<?=TXT_CUSTOMLIST_PLH_NAME?>" required></div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="slug"><?=TXT_CUSTOMLIST_LBL_SLUG?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<div id="input_wrapper_slug" data-target_table="<?=$sortable_table?>" data-this_id="<?=$this_id?>">
								<input class="form-control needValidation" data-valid_type="slug" type="text" id="slug" name="slug" value="<?=$this_slug?>" placeholder="<?=TXT_CUSTOMLIST_PLH_SLUG?>" required>
							</div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="posttype_id"><?=TXT_CUSTOMLIST_LBL_BELONGTO?></label>
							<div class="multistep10">
								<select class="form-control" tabindex="4" type="text" id="posttype_id" name="posttype_id">
									<?php if ($_SESSION[$session_key]['common']['this_posttype'] < 1000):?>
										<option value="0" <?=($this_posttype_id==0)?'selected':''?>><?=TXT_CUSTOMLIST_LBL_MULTIUSE?></option>
										<option value="<?=$_SESSION[$session_key]['common']['this_posttype']?>" <?=($_SESSION[$session_key]['common']['this_posttype']==$this_posttype_id)?'selected':''?>><?=$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name']?></option>
									<?php else:?>
										<option value="<?=$_SESSION[$session_key]['common']['this_posttype']?>" <?=($_SESSION[$session_key]['common']['this_posttype']==$this_posttype_id)?'selected':''?>><?=$_SESSION[$session_key]['common']['posttypes_extra'][$_SESSION[$session_key]['common']['this_posttype']]['name']?></option>
									<?php endif?>
								</select>
							</div>
						</div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status_01"><?=TXT_CUSTOMLIST_LBL_STATUS?></label><br>
							<?php foreach ($common_status_display as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?>> <?=$value?></label><br>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_id?>"><br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_CUSTOMLIST_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_CUSTOMLIST_BTN_DELETE?>">
						</div>
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default tags">
					<div class="panel-heading"><?=$page_title_main?> <?=TXT_CUSTOMLIST_LBL_LIST?> <span id="amount" class="badge"><?=$record_counter?></span></div>
					<div class="panel-body">
						<table id="custom_lists" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_CUSTOMLIST_THD_ID?></th>
								<th><?=TXT_CUSTOMLIST_THD_NAME?></th>
								<th><?=TXT_CUSTOMLIST_THD_SLUG?></th>
								<th><?=TXT_CUSTOMLIST_THD_BELONGTO?></th>
								<th></th>
								<th><?=TXT_CUSTOMLIST_THD_STATUS?></th>
								<th></th>
							</tr>
							</thead>
							<tbody class="sortable" data-target_table="<?=$sortable_table?>">
							<?php foreach ($records as $key => $row):?>
								<?php $list_name = urlencode($row['name'])?>
								<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'active':''?>">
									<td><?=$row['id']?></td>
									<td><?=$row['name']?></td>
									<td><?=$row['slug']?></td>
									<td><?=$row['posttype']?></td>
									<td><a href="./?view_page=custom_value&list_id=<?=$row['id']?>&amp;list_name=<?=$list_name?>&amp;posttype_id=<?=$row['posttype_id']?>" <?=($mode==2)?'disabled':''?>><?=TXT_CUSTOMLIST_LNK_CUSTOMVALUE?> <i class="fa fa-arrow-right"></i></a></td>
									<td data-status="<?=$row['status']?>">
										<?php if ($row['status'] == 1):?>
											<label class="label label-primary"><?=TXT_CUSTOMLIST_LBL_DISPLAY?></label>
										<?php else:?>
											<label class="label label-danger"><?=TXT_CUSTOMLIST_LBL_UNDISPLAY?></label>
										<?php endif?>
									</td>
									<td>
										<?php if ($mode != 2):?>
											<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>"><?=TXT_CUSTOMLIST_LBL_EDIT?></a>
										<?php else:?>
											<a class="btn btn-default btn-xs" disabled><?=TXT_CUSTOMLIST_LBL_EDIT?></a>
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