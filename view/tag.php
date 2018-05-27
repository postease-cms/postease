
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
		
		<!-- ALERT MESSAGE -->
		<?php if($nolabel_flg):?>
			<div class="alert alert-info"><?=TXT_TAG_WAR_NOLABEL?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<div id="edit_panel" class="panel <?=($mode==2)?'panel-primary':'panel-default'?>">
				<?php if ($mode == 2):?>
					<div class="panel-heading clearfix" id="panel_edit"><i class="fa fa-pencil-square-o"></i> <?=TXT_TAG_LBL_NOWEDIT($this_id)?><input id="allow_delete" type="checkbox" data-target_name="<?=TXT_TAG_LBL_TAG?>"> <label for="allow_delete"><?=TXT_TAG_LBL_ALLOWDELETE?></label><a href="./"><?=TXT_TAG_LBL_CANCELEDIT?></a></div>
				<?php else:?>
					<div class="panel-heading" id="panel_new"><i class="fa fa-plus-circle"></i> <?=TXT_TAG_LBL_NEW?></div>
				<?php endif?>
				<div class="panel-body">
					<form id="tag" role="form" action="./?mode=3" method="post">
						
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
									<label class="control-label" for="label_<?=$language_id?>"><?=TXT_TAG_LBL_LABEL?> <?=(count($_SESSION[$session_key]['common']['languages'])>1)?$row_lang['name']:''?></label>
									<div><input class="form-control" type="text" id="label_<?=$language_id?>" name="label[<?=$language_id?>]" value="<?=(!empty($this_label[$language_id]))?$this_label[$language_id]:''?>" placeholder="<?=TXT_TAG_PLH_NAME?>"></div>
								</div>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-3">
							<label class="control-label" for="slug"><?=TXT_TAG_LBL_SLUG?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
							<div id="input_wrapper_slug" data-target_table="<?=$sortable_table?>" data-classification="2" data-this_id="<?=$this_id?>">
								<input class="form-control needValidation" data-valid_type="slug" type="text" id="slug" name="slug" value="<?=$this_slug?>" placeholder="<?=TXT_TAG_PLH_SLUG?>" required>
							</div>
						</div>
						
						<div class="form-group col-md-3"></div>
						
						<div class="form-group col-md-2">
							<label class="control-label" for="status_01"><?=TXT_TAG_LBL_STATUS?></label><br>
							<?php foreach ($common_status_display as $key => $value):?>
								<label class="control-label" for="status_<?=$key?>"><input type="radio" name="status" id="status_<?=$key?>" value="<?=$key?>" <?=($this_status==$key)?'checked':''?>> <?=$value?></label><br>
							<?php endforeach?>
						</div>
						
						<div class="form-group col-md-1">
							<input type="hidden" id="process" name="process" value="<?=$process?>">
							<input type="hidden" id="update_id" name="update_id" data-page="tag" value="<?=$this_id?>"><br>
							<input class="btn btn-primary" type="submit" id="do_update" name="<?=$submit_name?>" value="<?=TXT_TAG_BTN_UPDATE?>">
							<span class="spinner hidden"><i class="fa fa-spinner fa-pulse"></i></span>
							<input class="btn btn-danger" type="button" id="do_delete" name="do_delete" value="<?=TXT_TAG_BTN_DELETE?>">
						</div>
					</form>
				</div>
			</div>
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default tags">
					<div class="panel-heading">
						<?=$page_title_main?> <?=TXT_TAG_LBL_LIST?> <span id="amount" class="badge"><?=$record_counter?></span>
						<span><a href="./?view_page=cover&amp;entity_code=5"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?=TXT_COVER_LBL_TOCOVER?></a></span>
					</div>
					<div class="panel-body">
						
						<?php if (count($_SESSION[$session_key]['common']['languages']) > 1):?>
							<div class="tableSelectLang">
								<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
									<a class="btn btn-xs btn-<?=($language_id==1)?'primary':'default'?>" link="" data-target_lang="<?=$language_id?>"><?=$row_lang['name']?></a>
								<?php endforeach?>
							</div>
						<?php endif?>
						
						<table id="tags" class="table table-hover">
							<thead>
							<tr>
								<th><?=TXT_TAG_THD_ID?></th>
								<th><?=TXT_TAG_THD_LABEL?></th>
								<th><?=TXT_TAG_THD_SLUG?></th>
								<th><?=TXT_TAG_THD_STATUS?></th>
								<th></th>
							</tr>
							</thead>
							<tbody class="sortable" data-target_table="<?=$sortable_table?>">
							<?php foreach ($records as $key => $row):?>
								<tr id="special_cat_<?=$key?>" class="<?=($key==$this_id)?'active':''?>">
									<td><?=$row['id']?></td>
									<td class="tableHasLang">
										<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
											<span class="tdPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(isset($row['label'][$language_id]))?$row['label'][$language_id]:null?></span>
										<?php endforeach?>
									</td>
									<td><?=$row['slug']?></td>
									<td data-status="<?=$row['status']?>">
										<?php if ($row['status'] == 1):?>
											<label class="label label-primary"><?=TXT_TAG_LBL_DISPLAY?></label>
										<?php else:?>
											<label class="label label-danger"><?=TXT_TAG_LBL_UNDISPLAY?></label>
										<?php endif?>
									</td>
									<td>
										<?php if ($mode != 2):?>
											<a class="btn btn-default btn-xs" href="./?mode=2&amp;id=<?=$row['id']?>"><?=TXT_TAG_LBL_EDIT?></a>
										<?php else:?>
											<a class="btn btn-default btn-xs" disabled><?=TXT_TAG_LBL_EDIT?></a>
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
	
  <?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
  <?php if ($_SESSION[$session_key]['configs']['display_implement_code']):?>
  <?php require_once 'inc/_implement_code_tags.php'?>
  <?php endif?>
	<?php endif?>
 
</main>
<script src="js/taxonomy.js"></script>
<script src="js/edit_hierarchy.js"></script>
<script src="js/check_slug.js"></script>