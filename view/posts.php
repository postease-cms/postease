<?php
//print '<pre>';
//print_r($_SESSION);
//print '</pre>';
//exit;
?>
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?><span id="amount" class="badge"> <?=$amount_post?> </span></h3></div>
	</div>
	
	<!-- SEARCH -->
	<div class="operation clearfix">
		<nav class="navbar navbar-default" role="navigation">
			<form class="navbar-form navbar-left form-inline" id="search_box" role="search" method="post" onsubmit="javascript:return false;" action="">
				<?php if ($_SESSION[$session_key]['configs']['use_multilingual_flg']):?>
					<div class="changeMultilingual">
						<span class="changeMultilingual-label"><?=TXT_POSTS_LBL_CHANGE_LANGUAGE?></span>
						<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
							<a href="./?language=<?=$language_id?>" class="btn btn-xs btn-<?=($language_id==$language)?'primary':'default'?>"><?=$row_lang['name']?></a>
						<?php endforeach?>
					</div>
				<?php endif?>
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_status" id="sc_status">
						<option value=""><?=TXT_POSTS_SEL_DEFAULT_STATUS?></option>
						<?php foreach ($post_status as $key => $value):?>
							<option value="<?=$key?>" <?=($sc_status===(string)$key)?'selected':''?>><?=$value?></option>
						<?php endforeach?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_category_id" id="sc_category_id">
						<option value="0"><?=TXT_POSTS_SEL_DEFAULT_CATEGORY?></option>
						<?php if (count($formated_categories)):?>
							<?php foreach ($formated_categories as $key => $parent):?>
								<option value="<?=$key?>" <?=(intval($sc_category_id)==$key)?'selected':''?>><?=$parent['label'][$language]?></option>
								<?php if (count($parent['children'])):?>
									<div class="catChild">
										<?php foreach ($parent['children'] as $key => $child):?>
											<option class="scCatChild" value="<?=$key?>" <?=(intval($sc_category_id)==$key)?'selected':''?>><?=$child['label'][$language]?></option>
										<?php endforeach?>
									</div>
								<?php endif?>
							<?php endforeach?>
						<?php endif?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_tag_id" id="sc_tag_id">
						<option value=""><?=TXT_POSTS_SEL_DEFAULT_TAG?></option>
						<?php if (count($_SESSION[$session_key]['common']['tags'])):?>
							<?php foreach ($_SESSION[$session_key]['common']['tags'] as $key => $values):?>
								<option value="<?=$values['id']?>" <?=(intval($sc_tag_id)==$key)?'selected':''?>><?=$values['label'][$language]?></option>
							<?php endforeach?>
						<?php endif?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_created_by" id="sc_created_by">
						<option value=""><?=TXT_POSTS_PLH_SEARCH_CREATEDBY?></option>
						<?php foreach ($selectable_users as $key => $value):?>
							<option value="<?=$key?>" <?=($sc_created_by===(string)$key)?'selected':''?>><?=$value?></option>
						<?php endforeach?>
					</select>
				</div>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" name="sc_text" id="sc_text" value="<?=$sc_text?>" placeholder="<?=TXT_POSTS_PLH_SEARCH_TEXT?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="sc_publish_date_start" id="sc_publish_date_start" value="<?=$sc_publish_date_start?>" placeholder="<?=TXT_POSTS_PLH_SEARCH_STARTDATE?>">
				</div>
				<div class="form-group input150">
					<input type="text" class="form-control" name="sc_publish_date_end" id="sc_publish_date_end" value="<?=$sc_publish_date_end?>" placeholder="<?=TXT_POSTS_PLH_SEARCH_ENDDATE?>">
				</div>
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_anchor" id="sc_anchor">
						<option value=""><?=TXT_POSTS_SEL_DEFAULT_ANCHOR?></option>
						<?php if (count($selectable_anchors)):?>
							<?php if (count($selectable_anchors) > 1):?>
								<option value="<?=implode(',',$selectable_anchors)?>" <?=($sc_anchor==implode(',',$selectable_anchors))?'selected':''?>><?=TXT_POSTS_SEL_HAS_ANCHOR?></option>
							<?php endif?>
							<?php foreach ($selectable_anchors as $value):?>
								<option value="<?=$value?>" <?=($sc_anchor===(string)$value)?'selected':''?>><?=TXT_POSTS_LBL_ANCHOR?> <?=$value?></option>
							<?php endforeach?>
							<option value="0" <?=($sc_anchor==='0')?'selected':''?>><?=TXT_POSTS_SEL_NO_ANCHOR?></option>
						<?php endif?>
					</select>
				</div>
				<div class="form-group">
					<a class="btn btn-<?=($set_condition_flg)?'primary':'default'?>" name="resetup" href="./?clear=1"><?=TXT_POSTS_LBL_SEARCH_CLEAR?></a>
				</div>
			</form>
		</nav>
	</div>
	
	<!-- PAGENATION -->
	<div class="pagenationWrap">
		<?php if (count($records)):?>
			<ul id="pagenator" class="pagination pagination-sm">
				<?php if ($this_page==1):?>
					<li class="disabled"><a>&laquo;</a></li>
				<?php else:?>
					<li><a href="./?page=<?=($this_page-1)?>">&laquo;</a></li>
				<?php endif?>
				<?php foreach ($pagenation as $page):?>
					<?php if ($page == 0):?>
						<li><a class="pagenationPage nolink">..</a></li>
					<?php else:?>
						<li<?=($page==$this_page)?' class="active"':''?>><a a class="pagenationPage" href="./?page=<?=$page?>"><?=$page?></a></li>
					<?php endif?>
				<?php endforeach?>
				<?php if ($this_page==$amount_page):?>
					<li class="disabled"><a>&raquo;</a></li>
				<?php else:?>
					<li><a href="./?page=<?=($this_page+1)?>">&raquo;</a></li>
				<?php endif?>
			</ul>
			<ul id="change_limit">
				<li><i class="fa fa-television"></i></li>
				<?php $prev_value = 0?>
				<?php foreach ($common_display_limit as $value):?>
					<?php if ($config_list_num > $prev_value && $config_list_num < $value):?>
						<li><a href="./?limit=<?=$config_list_num?>&amp;page=1" class="<?=($config_list_num==$limit)?'textDecorationUnderline':''?>"><?=$config_list_num?></a></li> |
					<?php endif?>
					<li><a href="./?limit=<?=$value?>&amp;page=1" class="<?=($value==$limit)?'textDecorationUnderline':''?>"><?=$value?></a></li> |
					<?php $prev_value = $value?>
				<?php endforeach?>
			</ul>
		<?php endif?>
	</div>
	
	<!-- INNER WRAP -->
	<div id="posts_wrap" class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<?php if (count($records)):?>
		<div class="slow-show">
			<table id="post_list" class="table table-hover">
				<thead>
				<tr>
					<th>
							<span class="<?=($multi_column01!=1)?'hidden':''?>">
								<?php if (strlen($_SESSION[$session_key]['posts']['sc_status']) == 1):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
								<a href="./?multi_column01=2">
								<?=TXT_POSTS_THD_STATUS?> /
									<?php if ($_SESSION[$session_key]['posts']['sc_text']):?>
										<i class="fa fa-filter text-primary"></i>
									<?php endif?>
									<?=$label_title?>
								</a>
							</span>
						<span class="<?=($multi_column01!=2)?'hidden':''?>">
								<?php if (strlen($_SESSION[$session_key]['posts']['sc_status']) == 1):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
							<a href="./?multi_column01=1">
								ID /
								<?php if ($_SESSION[$session_key]['posts']['sc_text']):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
								<?=$label_title?>
								</a>
							</span>
					</th>
					<th>
							<span class="<?=($multi_column02!=1)?'hidden':''?>">
								<?php if ($_SESSION[$session_key]['posts']['sc_category_id']):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
								<a href="./?multi_column02=2">
								<?=TXT_POSTS_THD_CATEGORY?>
									/
									<?php if ($_SESSION[$session_key]['posts']['sc_tag_id']):?>
										<i class="fa fa-filter text-primary"></i>
									<?php endif?>
									<?=TXT_POSTS_THD_TAG?>
								</a>
							</span>
						<span class="<?=($multi_column02!=2)?'hidden':''?>">
								<?php if ($_SESSION[$session_key]['posts']['sc_category_id']):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
							<a href="./?multi_column02=3">
								<?=TXT_POSTS_THD_CATEGORY?>
								</a>
							</span>
						<span class="<?=($multi_column02!=3)?'hidden':''?>">
								<?php if ($_SESSION[$session_key]['posts']['sc_tag_id']):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
							<a href="./?multi_column02=1">
								<?=TXT_POSTS_THD_TAG?>
								</a>
							</span>
					</th>
					<th>
							<span class="<?=($multi_column03!=1)?'hidden':''?>">
								<?php if ($_SESSION[$session_key]['posts']['sc_created_by']):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
								<a href="./?multi_column03=2"><?=TXT_POSTS_THD_POSTEDBY?></a>
							</span>
						<span class="<?=($multi_column03!=2)?'hidden':''?>">
								<a href="./?multi_column03=<?=($judge_flg_comment)?'3':'1'?>"><?=TXT_POSTS_THD_UPDATEDBY?></a>
							</span>
						<?php if ($judge_flg_comment):?>
							<span class="<?=($multi_column03!=3)?'hidden':''?>">
								<a href="./?multi_column03=1">
								<?php foreach(explode(',', $comment_type) as $value):?>
									<?php if ($value == 1):?>
										<?=TXT_POSTS_THD_COMMENT?>
									<?php elseif ($value == 2):?>
										<?=TXT_POSTS_THD_REVIEW?>
									<?php elseif ($value == 3):?>
										<?=TXT_POSTS_THD_SUBPOST?>
									<?php endif?>
								<?php endforeach?>
								</a>
							</span>
						<?php endif?>
					</th>
					<th>
						<?php if ($_SESSION[$session_key]['posts']['sc_publish_date_start'] || $_SESSION[$session_key]['posts']['sc_publish_date_end']):?>
							<i class="fa fa-filter text-primary"></i>
						<?php endif?>
						<a href="./?page=<?=$this_page?>&sort=<?=$sort_reverse?>">
							<i class="fa fa-sort-numeric-<?=($sort=='DESC')?'desc':'asc'?>"></i>
							<?=TXT_POSTS_THD_PUBLISHDATE?>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($records as $row):?>
					<tr class="<?=($row['id']==$new_id)?'info':''?><?=($row['id']==$updated_id)?'success':''?><?=($row['id']==$prev_id)?'active':''?>">
						<td>
							<?php if ($row['editable_flg']):?>
								<span class="batchCheck"><input type="checkbox" name="change_status[]" value="<?=$row['id']?>"></span>
							<?php else:?>
								<span class="uneditable"><i class="fa fa-lock" aria-hidden="true"></i></span>
							<?php endif?>
							<span class="<?=($multi_column01!=1)?'hidden':''?>">
								<?php if($row['status']==1):?>
									<?php if (strtotime($row['publish_datetime']) > strtotime(date('Y-m-d H:i:s'))):?>
										<span class="label label-status label-info"><?=TXT_POSTS_LBL_FUTURE?></span>
									<?php else:?>
										<span class="label label-status label-primary"><?=TXT_POSTS_LBL_PUBLISHED?></span>
									<?php endif?>
								<?php elseif($row['status']==2):?>
									<span class="label label-status label-warning"><?=TXT_POSTS_LBL_DRAFT?></span>
								<?php else:?>
									<span class="label label-status label-default"><?=TXT_POSTS_LBL_PRIVATE?></span>
								<?php endif?>
							</span>
							<span class="<?=($multi_column01!=2)?'hidden':''?>">
								<?php if($row['status']==1):?>
									<?php if (strtotime($row['publish_datetime']) > strtotime(date('Y-m-d H:i:s'))):?>
										<span class="label label-status label-info"><?=$row['id']?></span>
									<?php else:?>
										<span class="label label-status label-primary"><?=$row['id']?></span>
									<?php endif?>
								<?php elseif($row['status']==2):?>
									<span class="label label-status label-warning"><?=$row['id']?></span>
								<?php else:?>
									<span class="label label-status label-default"><?=$row['id']?></span>
								<?php endif?>
							</span>
							
							<?php if ($config_posttype['use_multipage_flg']):?>
								<?php if($row['post_pages'] > 0):?>
									<?php
									$status_children = 'primary';
									if ($row['count_child_private'] > 0) $status_children = 'default';
									if ($row['count_child_draft'] > 0)   $status_children = 'warning';
									?>
									<span class="label label-extra label-<?=$status_children?>"><i class="fa fa-clone"></i> <?=$row['post_pages']?></span>
								<?php endif?>
							<?php endif?>
							<?php if(! empty($row['anchor'])):?>
								<span class="label label-extra label-success"><i class="fa fa-anchor"></i> <?=$row['anchor']?></span>
							<?php endif?>
							<?php if(! empty($row['title'])):?>
                <a href="./?view_page=post&amp;id=<?=$row['id']?>&amp;version=<?=$row['version']?>&amp;process=12"><?=$row['title']?></a>
							<?php else:?>
								<a href="./?view_page=post&amp;id=<?=$row['id']?>&amp;version=<?=$row['version']?>&amp;process=12"><i><?=TXT_POSTS_LBL_NOTITLE?></i></a>
							<?php endif?>
						</td>
						<td>
							<span class="<?=($multi_column02!=1)?'hidden':''?>">
								<?php if (count($row['categories'])):?>
									<?php $other_category = array()?>
									<?php foreach ($row['categories'] as $key => $category):?>
										<?php if ($key < $config_category_num):?>
											<label class="label label-cattag"><?=$category?></label>
										<?php else:?>
											<?php $other_category[] = $category?>
										<?php endif?>
									<?php endforeach?>
								<?php if (! empty($other_category)):?>
										<small><a data-toggle="tooltip" data-placement="top" title="<?=implode(' , ',$other_category)?>"><i><?=TXT_POSTS_LNK_OTHERS?></i></a></small>
									<?php endif?>
								<?php else:?>
									<small><i><?=TXT_POSTS_LBL_NOSETTING?></i></small>
								<?php endif?>
								/
								<?php if (count($row['tags'])):?>
									<?php $other_tag = array()?>
									<?php foreach ($row['tags'] as $key => $tag):?>
										<?php if ($key < $config_tag_num):?>
											<label class="label label-cattag"><?=$tag?></label>
										<?php else:?>
											<?php $other_tag[] = $tag?>
										<?php endif?>
									<?php endforeach?>
								<?php if (! empty($other_tag)):?>
										<small><a data-toggle="tooltip" data-placement="top" title="<?=implode(' , ',$other_tag)?>"><i><?=TXT_POSTS_LNK_OTHERS?></i></a></small>
									<?php endif?>
								<?php else:?>
									<small><i><?=TXT_POSTS_LBL_NOSETTING?></i></small>
								<?php endif?>
							</span>
							<span class="<?=($multi_column02!=2)?'hidden':''?>">
								<?php if (count($row['categories'])):?>
									<?php $other_category = array()?>
									<?php foreach ($row['categories'] as $key => $category):?>
										<?php if ($key < $config_category_num):?>
											<label class="label label-cattag"><?=$category?></label>
										<?php else:?>
											<?php $other_category[] = $category?>
										<?php endif?>
									<?php endforeach?>
								<?php if (! empty($other_category)):?>
										<small><a data-toggle="tooltip" data-placement="top" title="<?=implode(' , ',$other_category)?>"><i><?=TXT_POSTS_LNK_OTHERS?></i></a></small>
									<?php endif?>
								<?php else:?>
									<small><i><?=TXT_POSTS_LBL_NOSETTING?></i></small>
								<?php endif?>
							</span>
							<span class="<?=($multi_column02!=3)?'hidden':''?>">
								<?php if (count($row['tags'])):?>
									<?php $other_tag = array()?>
									<?php foreach ($row['tags'] as $key => $tag):?>
										<?php if ($key < $config_tag_num):?>
											<label class="label label-cattag"><?=$tag?></label>
										<?php else:?>
											<?php $other_tag[] = $tag?>
										<?php endif?>
									<?php endforeach?>
								<?php if (! empty($other_tag)):?>
										<small><a data-toggle="tooltip" data-placement="top" title="<?=implode(' , ',$other_tag)?>"><i><?=TXT_POSTS_LNK_OTHERS?></i></a></small>
									<?php endif?>
								<?php else:?>
									<small><i><?=TXT_POSTS_LBL_NOSETTING?></i></small>
								<?php endif?>
							</span>
						</td>
						
						<td>
							<span class="<?=($multi_column03!=1)?'hidden':''?>">
								<?php if (! empty($row['created_group'])):?>
									<?=$row['created_group']?>
								<?php endif?>
								<?=$row['created_by']?>
							</span>
							<span class="<?=($multi_column03!=2)?'hidden':''?>">
								<?php if (! empty($row['updated_group'])):?>
									<?=$row['updated_group']?>
								<?php endif?>
								<?=$row['updated_by']?>
							</span>
							<?php if ($judge_flg_comment):?>
								<span class="<?=($multi_column03!=3)?'hidden':''?>">
								<?php if ($comment_type):?>
									<?php foreach(explode(',', $comment_type) as $value):?>
										<?php if ($value == 1):?>
											<a href="./?view_page=comments&amp;sc_post_id=<?=$row['id']?>&amp;type=1"><i class="fa fa-comment"></i> <?=$row['count_post_cm1a']?><?=($row['count_post_cm1d'])?'(+'.$row['count_post_cm1d'].')':null?><?=TXT_GLOBAL_UNT_COUNT?></a>&nbsp;
										<?php elseif ($value == 2):?>
											<a href="./?view_page=comments&amp;sc_post_id=<?=$row['id']?>&amp;type=2"><i class="fa fa-star-half-o"></i> <?=$row['count_post_cm2']?><?=TXT_GLOBAL_UNT_COUNT?>(<?=round((float)$row['score_average_cm2'], 1)?><?=TXT_GLOBAL_UNT_SCORE?>)</a>&nbsp;
										<?php elseif ($value == 3):?>
											<a href="./?view_page=comments&amp;sc_post_id=<?=$row['id']?>&amp;type=3"><i class="fa fa-paperclip"></i> <?=$row['count_post_cm3a']?><?=($row['count_post_cm3d'])?'(+'.$row['count_post_cm3d'].')':null?><?=TXT_GLOBAL_UNT_COUNT?></a>&nbsp;
										<?php endif?>
									<?php endforeach?>
								<?php endif?>
							</span>
							<?php endif?>
						</td>
						
						<td>
							<?php $publish_datetime = ($row['publish_datetime']) ? date('Y-m-d H:i', strtotime($row['publish_datetime'])) : null?>
							<?=$publish_datetime?>
						</td>
					</tr>
				<?php endforeach?>
				</tbody>
			</table>
			<div id="operation" class="panel panel-default">
				<div id="checkall" class="panel-heading">
					<i class="fa fa-arrow-circle-up"></i> <span id="checkall_title"><?=TXT_POSTS_LBL_CHECKALL?></span>
					<label class="checkbox-inline" for="allow_delete"><input type="checkbox" id="allow_delete" name="allow_delete"> <?=TXT_POSTS_LBL_ALLOWDELETE?></label>
				</div>
				<div class="panel-body">
					<div class="operationHead"><?=TXT_POSTS_LBL_CHANGESTATU_TO($posttype_label)?></div>
					<div class="operationBody">
						<div>
							<div id="change_status" class="operationButton" data-target="<?=$posttype_label?>">
								<?php if ($publish_flg):?>
									<button type="button" id="to_status_1" class="btn btn-sm btn-default" data-hover_class="btn-primary" data-status_txt="<?=TXT_POSTS_LBL_PUBLISHED?>" data-process="12"><?=TXT_POSTS_BTN_TO_PUBLISH?></button>
								<?php endif?>
								<button type="button" id="to_status_2" class="btn btn-sm btn-default" data-hover_class="btn-warning" data-status_txt="<?=TXT_POSTS_LBL_DRAFT?>" data-process="12"><?=TXT_POSTS_BTN_TO_DRAFT?></button>
								<button type="button" id="to_status_8" class="btn btn-sm btn-default" data-hover_class="btn-default" data-status_txt="<?=TXT_POSTS_LBL_PRIVATE?>" data-process="12"><?=TXT_POSTS_BTN_TO_PRIVATE?></button>
								<button type="button" id="to_clone" class="btn btn-sm btn-success" data-status_txt="<?=TXT_POSTS_LBL_CLONE?>" data-process="13"><i class="fa fa-clone" aria-hidden="true"></i> <?=TXT_POSTS_BTN_CLONE?></button>
								<button type="button" id="to_delete" class="btn btn-sm btn-danger" data-status_txt="<?=TXT_POSTS_LBL_DELETE?>" data-process="19"><i class="fa fa-trash-o" aria-hidden="true"></i> <?=TXT_POSTS_BTN_DELETE?></button>
							</div>
						</div>
						<?php if (! empty($formated_categories) || ! empty($_SESSION[$session_key]['common']['tags'])):?>
							<hr class="operationSeparator">
							<div class="changeTaxonomy" data-target="<?=$posttype_label?>">
								<div class="form-group">
									<select class="form-control input-sm" name="change_category_id" id="change_category_id">
										<option value="0"><?=TXT_POSTS_SEL_OPERATION_CATEGORY?></option>
										<?php if (count($formated_categories)):?>
											<?php foreach ($formated_categories as $key => $parent):?>
												<option value="<?=$key?>" <?=(intval($sc_category_id)==$key)?'selected':''?>><?=$parent['label'][$language]?></option>
												<?php if (count($parent['children'])):?>
													<div class="catChild">
														<?php foreach ($parent['children'] as $key => $child):?>
															<option class="scCatChild" value="<?=$key?>" <?=(intval($sc_category_id)==$key)?'selected':''?>><?=$child['label'][$language]?></option>
														<?php endforeach?>
													</div>
												<?php endif?>
											<?php endforeach?>
										<?php endif?>
									</select>
									<button type="button" id="add_category" class="btn btn-sm btn-default" data-hover_class="btn-success" data-status_txt="<?=TXT_POSTS_LBL_PUBLISHED?>" data-process="12"><?=TXT_POSTS_LBL_ADDTAXONOMY?></button>
									<button type="button" id="remove_category" class="btn btn-sm btn-default" data-hover_class="btn-warning" data-status_txt="<?=TXT_POSTS_LBL_DRAFT?>" data-process="12"><?=TXT_POSTS_LBL_DELETETAXONOMY?></button>
								</div>
								<div class="form-group">
									<select class="form-control input-sm" name="change_tag_id" id="change_tag_id">
										<option value=""><?=TXT_POSTS_SEL_OPERATION_TAG?></option>
										<?php if (count($_SESSION[$session_key]['common']['tags'])):?>
											<?php foreach ($_SESSION[$session_key]['common']['tags'] as $key => $values):?>
												<option value="<?=$values['id']?>" <?=(intval($sc_tag_id)==$key)?'selected':''?>><?=$values['label'][$language]?></option>
											<?php endforeach?>
										<?php endif?>
									</select>
									<button type="button" id="add_tag" class="btn btn-sm btn-default" data-hover_class="btn-success" data-status_txt="<?=TXT_POSTS_LBL_PUBLISHED?>" data-process="12"><?=TXT_POSTS_LBL_ADDTAXONOMY?></button>
									<button type="button" id="remove_tag" class="btn btn-sm btn-default" data-hover_class="btn-warning" data-status_txt="<?=TXT_POSTS_LBL_DRAFT?>" data-process="12"><?=TXT_POSTS_LBL_DELETETAXONOMY?></button>
								</div>
							</div>
						<?php endif?>
					</div>
				</div>
			</div>
			<?php else:?>
				<div class="alert alert-warning"><?=TXT_POSTS_WAR_NOPOST($page_title_main)?></div>
			<?php endif?>
		</div>
	</div>

  <?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
  <?php if ($_SESSION[$session_key]['configs']['display_implement_code']):?>
  <?php require_once 'inc/_implement_code_posts.php'?>
  <?php endif?>
  <?php endif?>

</main>
<link rel="stylesheet" href="plugin/datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
<script src="plugin/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="plugin/prism-dark/prism.js"></script>
<?php if ($_SESSION[$session_key]['user']['lang'] != 'en'):?>
	<script src="plugin/datetimepicker/locales/bootstrap-datetimepicker.<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<?php endif?>