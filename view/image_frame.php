
<!-- OUTER WRAP -->
<main id="content" class="col-md-10" data-target_table="<?=$sortable_table?>">
	
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
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<div id="edit_panel" class="panel <?=($mode==2)?'panel-primary':'panel-default'?>">
				<?php if ($mode == 2):?>
					<div class="panel-heading clearfix" id="panel_edit">
						<i class="fa fa-pencil-square-o"></i> <?=TXT_IMAGEFRAME_LBL_NOWEDIT($this_parent_dir.'/'.$this_child_dir)?>
						<?php if ($this_parent_dir == 'fr_admin'):?>
							<label for="allow_delete">
								<input id="allow_delete" type="checkbox" data-target_name="<?=TXT_IMAGEFRAME_LBL_IMAGEFRAME?>" disabled>
								<?=TXT_IMAGEFRAME_LBL_DISALLOWDELETE?></label>
						<?php else:?>
							<label for="allow_delete">
								<input id="allow_delete" type="checkbox" data-target_name="<?=TXT_IMAGEFRAME_LBL_IMAGEFRAME?>">
								<?=TXT_IMAGEFRAME_LBL_ALLOWDELETE?></label>
						<?php endif?>
						<a href="./"><?=TXT_IMAGEFRAME_LBL_CANCELEDIT?></a>
					</div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_IMAGEFRAME_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="image_frame" role="form" action="./?mode=3" method="post">
						<div class="form-group col-md-2">
							<label class="control-label" for="name"><?=TXT_IMAGEFRAME_LBL_TYPE?></label>
							<div class="multistep10">
								<select class="form-control" tabindex="3" type="text" id="type" name="type" <?=($process>1)?'disabled':''?>>
									<?php foreach ($image_frame_type as $key => $value):?>
										<option value="<?=$key?>" <?=($this_type==$key)?'selected':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
							<?php if ($process > 1):?>
								<input type="hidden" name="type" value="<?=$this_type?>">
							<?php endif?>
						</div>
						<div class="form-group col-md-2">
							<label class="control-label" id="label_width" for="width"><?=TXT_IMAGEFRAME_LBL_WIDTH?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<input class="form-control inlineRight70 needValidation" data-valid_type="imagesize" tabindex="1" type="text" id="width" name="width" value="<?=$this_width?>">px
						</div>
						<div class="form-group col-md-2">
							<label class="control-label" id="label_height" for="height"><?=TXT_IMAGEFRAME_LBL_HEIGHT?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<input class="form-control inlineRight70 needValidation" data-valid_type="imagesize" tabindex="1" type="text" id="height" name="height" value="<?=$this_height?>">px
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="comment"><?=TXT_IMAGEFRAME_LBL_COMMENT?></label>
							<input class="form-control" tabindex="2" type="text" id="comment" name="comment" value="<?=$this_comment?>">
						</div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status_01"><?=TXT_IMAGEFRAME_LBL_STATUS?></label><br>
							<?php foreach ($common_status_use as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?> <?=($this_parent_dir=='fr_admin'&&$key==8)?'disabled':''?>> <?=$value?></label><br>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_parent_dir.'/'.$this_child_dir?>"><br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_IMAGEFRAME_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_IMAGEFRAME_BTN_DELETE?>">
						</div>
					
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default registerdList">
					<div class="panel-heading"><?=$page_title_sub?> <?=TXT_IMAGEFRAME_LBL_LIST?> <span id="amount" class="badge"><?=$record_counter?></span></div>
					<div class="panel-body">
						<table id="image_frames" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_IMAGEFRAME_THD_PARENT_DIR?></th>
								<th><?=TXT_IMAGEFRAME_THD_TYPE?></th>
								<th><?=TXT_IMAGEFRAME_THD_WIDTH?></th>
								<th><?=TXT_IMAGEFRAME_THD_HEIGHT?></th>
								<th><?=TXT_IMAGEFRAME_THD_COMMENT?></th>
								<th><?=TXT_IMAGEFRAME_THD_STATUS?></th>
								<th></th>
							</tr>
							</thead>
							<tbody data-target_table="{$table_prefix}image_frames">
							<?php foreach ($records as $key => $row):?>
								<tr id="special_cat_<?=$key?>" class="<?=($row['parent_dir']==$this_parent_dir&&$row['child_dir']==$this_child_dir)?'info':''?>">
									<td class="<?=($row['parent_dir']=='admin')?'text-primary':''?>"><?=$row['parent_dir'].'/'.$row['child_dir']?></td>
									<td><?=$image_frame_type[$row['type']]?></td>
									<td>
										<?php if ($row['width']):?>
											<?=($row['type']=='auto')?TXT_IMAGEFRAME_LBL_SIZEMAX:null?> <?=$row['width']?>px
										<?php endif?>
									</td>
									<td>
										<?php if ($row['height']):?>
											<?=($row['type']=='auto')?TXT_IMAGEFRAME_LBL_SIZEMAX:null?> <?=$row['height']?>px
										<?php endif?>
									</td>
									<td><?=$row['comment']?></td>
									<td data-status="<?=$row['status']?>">
										<?php if ($row['status'] == 1):?>
											<label class="label label-primary"><?=TXT_IMAGEFRAME_LBL_USE?></label>
										<?php else:?>
											<label class="label label-danger"><?=TXT_IMAGEFRAME_LBL_UNUSE?></label>
										<?php endif?>
									</td>
									<td>
										<?php if ($mode != 2):?>
											<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['parent_dir']?>/<?=$row['child_dir']?>"><?=TXT_IMAGEFRAME_LBL_EDIT?></a>
										<?php else:?>
											<a class="btn btn-default btn-xs" disabled><?=TXT_IMAGEFRAME_LBL_EDIT?></a>
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