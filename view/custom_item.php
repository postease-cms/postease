
<!-- OUTER WRAP -->
<main id="content" class="col-md-10" data-target_table="<?=$sortable_table?>">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3>
			<span id="to_custom_list"><a href="./?view_page=custom_list"><?=TXT_CUSTOMITEM_LBL_EDITCUSTOMLIST?> <i class="fa fa-arrow-right"></i></a></span>
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
					<div class="panel-heading clearfix" id="panel_edit"><i class="fa fa-pencil-square-o"></i> <?=TXT_CUSTOMITEM_LBL_NOWEDIT($this_id)?><input id="allow_delete" type="checkbox" data-target_name="<?=TXT_CUSTOMITEM_LBL_CUSTOMITEM?>"> <label for="allow_delete"><?=TXT_CUSTOMITEM_LBL_ALLOWDELETE?></label><a href="./"><?=TXT_CUSTOMITEM_LBL_CANCELEDIT?></a></div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_CUSTOMITEM_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="custom_item" role="form" action="./?mode=3" method="post">
						
						<div class="form-group col-md-4">
							<label class="control-label" for="name"><?=TXT_CUSTOMITEM_LBL_NAME?></label>
							<div class="multistep10">
								<input tabindex="1" class="form-control" type="text" id="name" name="name" value="<?=$this_name?>" placeholder="<?=TXT_CUSTOMITEM_PLH_NAME?>" required>
							</div>
							<div class="multistep10">
								<label class="control-label" for="type"><?=TXT_CUSTOMITEM_LBL_TYPE?></label>
								<select tabindex="3" class="form-control" id="type" name="type">
									<?php foreach ($custom_item_type as $key => $value):?>
										<option value="<?=$key?>" <?=($key==$this_type)?'selected':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
						</div>
						
						<div class="form-group col-md-5">
							<div class="multistep10">
								<label class="control-label" for="slug"><?=TXT_CUSTOMITEM_LBL_SLUG?></label>
								<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
								<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
								<div id="input_wrapper_slug" data-target_table="<?=$sortable_table?>" data-this_id="<?=$this_id?>">
									<input tabindex="2" class="form-control needValidation" data-valid_type="slug" type="text" id="slug" name="slug" value="<?=$this_slug?>" placeholder="<?=TXT_CUSTOMITEM_PLH_SLUG?>" required>
								</div>
							</div>
							<div class="multistep10">
								
								<div id="choices_list" class="form-group">
									<label class="control-label" for="target_list"><?=TXT_CUSTOMITEM_LBL_TARGETLIST?></label>
									<?php if (! empty($custom_lists)):?>
										<select class="form-control" id="target_list" name="choices" disabled>
											<?php foreach ($custom_lists as $key => $value):?>
												<option value="<?=$key?>" <?=($key==$this_choices)?'selected':''?>><?=$value?></option>
											<?php endforeach?>
										</select>
									<?php else:?>
										<br><?=TXT_CUSTOMITEM_MSG_NOTARGETLIST?>
									<?php endif?>
								</div>
								
								<div id="choices_column_delimiter" class="form-group">
									<label class="control-label" for="target_delimiter"><?=TXT_CUSTOMITEM_LBL_TARGETDELIMITER?></label>
									<select class="form-control" id="target_delimiter" name="choices" disabled>
										<?php foreach ($column_delimiter_list as $key => $value):?>
											<option value="<?=$key?>" <?=($key==$this_choices)?'selected':''?>><?=$value?></option>
										<?php endforeach?>
									</select>
								</div>
								
								<div id="choices_image" class="form-group">
									<label class="control-label" for="target_image"><?=TXT_CUSTOMITEM_LBL_TARGETIMAGE?></label>
									<select class="form-control" id="target_image" name="choices" disabled>
										<?php foreach ($image_frame_list as $key => $value):?>
											<option value="<?=$key?>" <?=($key==$this_choices)?'selected':''?>><?=$value?></option>
										<?php endforeach?>
									</select>
								</div>
								
								<div id="choices_syntax" class="form-group">
									<label class="control-label" for="target_syntax"><?=TXT_CUSTOMITEM_LBL_TARGETSYNTAX?></label>
									<select class="form-control" id="target_syntax" name="choices" disabled>
										<?php foreach ($syntax_type_list as $key => $value):?>
											<option value="<?=$key?>" <?=($key==$this_choices)?'selected':''?>><?=$value?></option>
										<?php endforeach?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status"><?=TXT_CUSTOMITEM_LBL_STATUS?></label><br>
							<?php foreach ($common_status_display as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?>> <?=$value?></label><br>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_id?>"><br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_CUSTOMITEM_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_CUSTOMITEM_BTN_DELETE?>">
						</div>
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default tags">
					<div class="panel-heading"><?=$page_title_main?> <?=TXT_CUSTOMITEM_LBL_LIST?> <span id="amount" class="badge"><?=$record_counter?></span></div>
					<div class="panel-body">
						<table id="custom_items" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_CUSTOMITEM_THD_ID?></th>
								<th><?=TXT_CUSTOMITEM_THD_NAME?></th>
								<th><?=TXT_CUSTOMITEM_THD_SLUG?></th>
								<th><?=TXT_CUSTOMITEM_THD_TYPE?></th>
								<th><?=TXT_CUSTOMITEM_THD_TARGET?></th>
								<th><?=TXT_CUSTOMITEM_THD_STATUS?></th>
								<th></th>
							</tr>
							</thead>
							<tbody class="sortable" data-target_table="<?=$sortable_table?>">
							<?php foreach ($records as $key => $row):?>
								<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'info':''?>">
									<td><?=$row['id']?></td>
									<td><?=$row['name']?></td>
									<td><?=$row['slug']?></td>
									<td><?=$custom_item_type[$row['type']]?></td>
									<td>
										<?php if(! empty($row['type']) && ($row['type'] == 'image' || $row['type'] == 'gallery')):?>
											<?=(!empty($row['choices']))?$image_frame_list[$row['choices']]:null?>
										<?php elseif(! empty($row['type']) && $row['type'] == 'table'):?>
											<?=(!empty($row['choices']))?$column_delimiter_list[$row['choices']]:null?>
										<?php elseif(! empty($row['type']) && $row['type'] == 'syntax'):?>
											<?=(!empty($row['choices']))?$syntax_type_list[$row['choices']]:null?>
										<?php else:?>
											<?=(!empty($row['choices']))?$custom_lists[$row['choices']]:null?>
										<?php endif?>
									</td>
									<td data-status="<?=$row['status']?>">
										<?php if ($row['status'] == 1):?>
											<label class="label label-primary"><?=TXT_CUSTOMITEM_LBL_DISPLAY?></label>
										<?php else:?>
											<label class="label label-danger"><?=TXT_CUSTOMITEM_LBL_UNDISPLAY?></label>
										<?php endif?>
									</td>
									<td>
										<?php if ($mode != 2):?>
											<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>"><?=TXT_CUSTOMITEM_LBL_EDIT?></a>
										<?php else:?>
											<a class="btn btn-default btn-xs" disabled><?=TXT_CUSTOMITEM_LBL_EDIT?></a>
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