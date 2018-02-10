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
		
		<!-- INFO MESSAGE -->
		<?php if($nolabel_flg):?>
			<div class="alert alert-info"><?=TXT_CATEGORY_WAR_NOLABEL?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<div id="edit_panel" class="panel <?=($mode==2)?'panel-primary':'panel-default'?>">
				<?php if ($mode == 2):?>
					<div class="panel-heading clearfix" id="panel_edit">
						<i class="fa fa-pencil-square-o"></i> <?=TXT_CATEGORY_LBL_NOWEDIT($this_id)?>
						<label for="allow_delete"><input id="allow_delete" type="checkbox" data-target_name="<?=TXT_CATEGORY_LBL_CATEGORY?>"> <?=TXT_CATEGORY_LBL_ALLOWDELETE?></label>
						<a href="./"><?=TXT_CATEGORY_LBL_CANCELEDIT?></a>
					</div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_CATEGORY_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="category" role="form" action="./?mode=3" method="post">
						
						<?php if (count($_SESSION[$session_key]['common']['languages']) > 1):?>
							<div class="panelSelectLang">
								<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
									<a class="btn btn-xs btn-<?=($language_id==1)?'primary':'default'?> link="" data-target_lang="<?=$language_id?>"><?=$row_lang['name']?></a>
								<?php endforeach?>
							</div>
						<?php endif?>
						
						<div class="form-group col-md-3 formHasLang">
							<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
								<div class="formPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>">
									<label class="control-label" for="label_<?=$language_id?>"><?=TXT_CATEGORY_LBL_LABEL?> <?=(count($_SESSION[$session_key]['common']['languages'])>1)?$row_lang['name']:''?></label>
									<div><input class="form-control" type="text" id="label_<?=$language_id?>" name="label[<?=$language_id?>]" value="<?=(!empty($this_label[$language_id]))?$this_label[$language_id]:''?>" placeholder="<?=TXT_CATEGORY_PLH_LABEL?>" <?=($language_id==1)?'required':''?>></div>
								</div>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="slug"><?=TXT_CATEGORY_LBL_SLUG?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<div id="input_wrapper_slug" data-target_table="<?=$sortable_table?>" data-classification="1" data-this_id="<?=$this_id?>">
								<input class="form-control needValidation" data-valid_type="slug" type="text" id="slug" name="slug" value="<?=$this_slug?>" placeholder="<?=TXT_CATEGORY_PLH_SLUG?>" required>
							</div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="parent_id"><?=TXT_CATEGORY_LBL_PARENT?></label>
							<select class="form-control" id="parent_id" name="parent_id" >
								<option value="0">-</option>
								<?php if (count($parent_categories)):?>
									<?php foreach ($parent_categories as $key => $value):?>
										<option value="<?=$key?>" <?=($key==$this_parent_id)?'selected':''?>><?=$value?></option>
									<?php endforeach?>
								<?php endif?>
							</select>
						</div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status"><?=TXT_CATEGORY_LBL_STATUS?></label><br>
							<?php foreach ($common_status_display as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?>> <?=$value?></label><br>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" value="<?=$this_id?>"><br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_CATEGORY_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_CATEGORY_BTN_DELETE?>">
						</div>
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default registerdList">
					<div class="panel-heading">
						<?=$page_title_main?> <?=TXT_CATEGORY_LBL_LIST?> <span id="amount" class="badge"><?=$record_counter?></span>
						<span><a href="./?view_page=cover&amp;entity_code=4&amp;type=<?=$page?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?=TXT_COVER_LBL_TOCOVER?></a></span>
					</div>
					<div class="panel-body">
						
						<?php if (count($_SESSION[$session_key]['common']['languages']) > 1):?>
							<div class="tableSelectLang">
								<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
									<a class="btn btn-xs btn-<?=($language_id==1)?'primary':'default'?>" link="" data-target_lang="<?=$language_id?>"><?=$row_lang['name']?></a>
								<?php endforeach?>
							</div>
						<?php endif?>
						
						<table id="categories" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_CATEGORY_THD_ID?></th>
								<th><?=TXT_CATEGORY_THD_HIERARCHY?></th>
								<th><?=TXT_CATEGORY_THD_LABEL?></th>
								<th><?=TXT_CATEGORY_THD_SLUG?></th>
								<th><?=TXT_CATEGORY_THD_PARENT?></th>
								<th><?=TXT_CATEGORY_THD_STATUS?></th>
								<th></th>
							</tr>
							</thead>
							<tbody class="sortable" data-target_table="<?=$sortable_table?>">
							<?php foreach ($records as $key1 => $row1):?>
								<tr id="special_cat_<?=$key1?>" class="<?=($key1==$this_id)?'info':''?>">
									<td><?=$row1['id']?></td>
									<td><label class="label label-primary">1</label></td>
									<td class="tableHasLang">
										<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
											<span class="tdPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(isset($row1['label'][$language_id]))?$row1['label'][$language_id]:null?></span>
										<?php endforeach?>
									</td>
									<td><?=$row1['slug']?></td>
									<td data-parent_id="0">-</td>
									<td data-status="<?=$row1['status']?>">
										<?php if ($row1['status'] == 1):?>
											<label class="label label-primary"><?=TXT_CATEGORY_LBL_DISPLAY?></label>
										<?php else:?>
											<label class="label label-danger"><?=TXT_CATEGORY_LBL_UNDISPLAY?></label>
										<?php endif?>
									</td>
									<td>
										<?php if ($mode != 2):?>
											<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row1['id']?>"><?=TXT_CATEGORY_LBL_EDIT?></a>
										<?php else:?>
											<a class="btn btn-default btn-xs" disabled><?=TXT_CATEGORY_LBL_EDIT?></a>
										<?php endif?>
									</td>
								</tr>
								<?php if (! empty($row1['child'])):?>
									<?php foreach ($row1['child'] as $key2 => $row2):?>
										<tr id="special_cat_<?=$key2?>" class="<?=($key2==$this_id)?'info':''?>">
											<td><?=$row2['id']?></td>
											<td><label class="label label-info">2</label></td>
											<td class="tableHasLang">
												<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
													<span class="tdPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(isset($row2['label'][$language_id]))?$row2['label'][$language_id]:null?></span>
												<?php endforeach?>
											</td>
											<td><?=$row2['slug']?></td>
											<td class="tableHasLang" data-parent_id="<?=$row2['parent_id']?>">
												<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
													<span class="tdPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(isset($categories[$row2['parent_id']]['label'][$language_id]))?$categories[$row2['parent_id']]['label'][$language_id]:null?></span>
												<?php endforeach?>
											</td>
											<td data-status="<?=$row2['status']?>">
												<?php if ($row2['status'] == 1):?>
													<label class="label label-primary"><?=TXT_CATEGORY_LBL_DISPLAY?></label>
												<?php else:?>
													<label class="label label-danger"><?=TXT_CATEGORY_LBL_UNDISPLAY?></label>
												<?php endif?>
											</td>
											<td><a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row2['id']?>" <?=($mode==2)?'disabled':''?>><?=TXT_CATEGORY_LBL_EDIT?></a></td>
										</tr>
									<?php endforeach?>
								<?php endif?>
							<?php endforeach?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endif?>
		</div>
	</div>
</main>
<script src="js/taxonomy.js"></script>
<script src="js/edit_hierarchy.js"></script>
<script src="js/check_slug.js"></script>