
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
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_status" id="sc_status">
						<option value=""><?=TXT_CONTACTS_SEL_DEFAULT_STATUS?></option>
						<?php foreach ($contact_status as $key => $value):?>
							<option value="<?=$key?>" <?=($sc_status===(string)$key)?'selected':''?>><?=$value?></option>
						<?php endforeach?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_category_id" id="sc_category_id">
						<option value="0"><?=TXT_CONTACTS_SEL_DEFAULT_CATEGORY?></option>
						<?php if (count($formated_categories)):?>
							<?php foreach ($formated_categories as $key => $parent):?>
								<option value="<?=$key?>" <?=(intval($sc_category_id)==$key)?'selected':''?>><?=$parent['label'][1]?></option>
								<?php if (count($parent['children'])):?>
									<div class="catChild">
										<?php foreach ($parent['children'] as $key => $child):?>
											<option class="scCatChild" value="<?=$key?>" <?=(intval($sc_category_id)==$key)?'selected':''?>><?=$child['label'][1]?></option>
										<?php endforeach?>
									</div>
								<?php endif?>
							<?php endforeach?>
						<?php endif?>
					</select>
				</div>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" name="sc_text" id="sc_text" value="<?=$sc_text?>" placeholder="<?=TXT_CONTACTS_PLH_SEARCH_KEYWORD?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="sc_contacted_at_start" id="sc_contacted_at_start" value="<?=$sc_contacted_at_start?>" placeholder="<?=TXT_CONTACTS_PLH_SEARCH_DATESTART?>">
				</div>
				<div class="form-group input150">
					<input type="text" class="form-control" name="sc_contacted_at_end" id="sc_contacted_at_end" value="<?=$sc_contacted_at_end?>" placeholder="<?=TXT_CONTACTS_PLH_SEARCH_DATEEND?>">
				</div>
				<div class="form-group input150">
					<a class="btn btn-<?=($set_condition_flg)?'primary':'default'?>" name="resetup" href="./?change=1"><?=TXT_CONTACTS_LNK_SEARCH_CLEAR?></a>
				</div>
			</form>
		</nav>
	</div>
	
	<!-- PAGENATION -->
	<div class="pagenationWrap slow-show-sub">
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
	<div id="contact_wrap" class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if (isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<?php if (count($records)):?>
		<div class="slow-show">
			<table id="contact_list" class="table table-hover">
				<thead>
				<tr>
					<th>
						<?php if ($_SESSION[$session_key]['contacts']['sc_text']):?>
							<i class="fa fa-filter text-primary"></i>
						<?php endif?>
						<span class="<?=($multi_column01!=1)?'hidden':''?>">
								<a href="./?multi_column01=2">
								<?=TXT_CONTACTS_THD_STATUS?> / <?=TXT_CONTACTS_THD_TITLE?>
								</a>
							</span>
						<span class="<?=($multi_column01!=2)?'hidden':''?>">
								<a href="./?multi_column01=1">
								<?=TXT_CONTACTS_THD_STATUS?> / <?=TXT_CONTACTS_THD_CONTENT?>
								</a>
							</span>
					</th>
					<th>
						<?php if ($_SESSION[$session_key]['contacts']['sc_category_id']):?>
							<i class="fa fa-filter text-primary"></i>
						<?php endif?>
						<?=TXT_CONTACTS_THD_CATEGORY?>
					</th>
					<th>
						<?php if ($_SESSION[$session_key]['contacts']['sc_text']):?>
							<i class="fa fa-filter text-primary"></i>
						<?php endif?>
						<span class="<?=($multi_column03!=1)?'hidden':''?>">
								<a href="./?multi_column03=2"><?=TXT_CONTACTS_THD_NAME?></a>
							</span>
						<span class="<?=($multi_column03!=2)?'hidden':''?>">
								<a href="./?multi_column03=3"><?=TXT_CONTACTS_THD_EMAIL?></a>
							</span>
						<span class="<?=($multi_column03!=3)?'hidden':''?>">
								<a href="./?multi_column03=1"><?=TXT_CONTACTS_THD_TEL?></a>
							</span>
					</th>
					<th>
						<?php if ($_SESSION[$session_key]['contacts']['sc_contacted_at_start'] || $_SESSION[$session_key]['contacts']['sc_contacted_at_end']):?>
							<i class="fa fa-filter text-primary"></i>
						<?php endif?>
						<a href="./?page=<?=$this_page?>&sort=<?=$sort_reverse?>">
							<i class="fa fa-sort-numeric-<?=($sort=='DESC')?'desc':'asc'?>"></i>
							<?=TXT_CONTACTS_THD_CONTACTEDAT?></a>
					</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($records as $row):?>
					<tr class="<?=($row['id']==$new_id)?'info':''?><?=($row['id']==$updated_id)?'success':''?><?=($row['id']==$prev_id)?'active':''?>">
						<td>
							<span class="batchCheck"><input type="checkbox" name="change_status[]" value="<?=$row['id']?>"></span>
							<?php if($row['status']==1):?>
								<span class="label label-status label-primary"><?=TXT_CONTACTS_LBL_COMPLETED?></span>
							<?php elseif($row['status']==7):?>
								<span class="label label-status label-success"><?=TXT_CONTACTS_LBL_ONGOING?></span>
							<?php else:?>
								<span class="label label-status label-warning"><?=TXT_CONTACTS_LBL_UNCONFIRMED?></span>
							<?php endif?>
							
							<a href="./?view_page=contact&id=<?=$row['id']?>&amp;language_id=<?=$row['language_id']?>&amp;process=32">
								<?php if($multi_column01 == 1):?>
									<?php if(! empty($row['title'])):?>
										<?=$row['title']?>
									<?php else:?>
										<a href="./?view_page=contact&id=<?=$row['id']?>&amp;process=32"><i><?=TXT_CONTACTS_LBL_NOTITLE?></i></a>
									<?php endif?>
								<?php endif?>
								
								<?php if ($multi_column01 == 2):?>
								<?=substructString($row['content'], $config_column01_length)?></a>
						<?php if (mb_strlen($row['content'], 'UTF-8') > $config_column01_length):?>
							<a data-toggle="tooltip" data-placement="top" title="<?=$row['content']?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
						<?php endif?>
						<?php endif?>
							</a>
						</td>
						<td>
							<?php if (count($row['categories'])):?>
								<?php foreach ($row['categories'] as $key => $category):?>
									<?php if ($key < $config_category_num):?>
										<label class="label label-cattag"><?=$category?></label>
									<?php else:?>
										<?php $other_category[] = $category?>
									<?php endif?>
								<?php endforeach?>
								<?php if (! empty($other_category)):?>
									<small><a data-toggle="tooltip" data-placement="top" title="<?=implode(', ',$other_category)?>"><i><?=TXT_CONTACTS_LBL_CATEGORY_OTHER?></i></a></small>
								<?php endif?>
							<?php else:?>
								<small><i><?=TXT_CONTACTS_LBL_CATEGORY_NOSETTING?></i></small>
							<?php endif?>
						</td>
						<td>
							<?php if ($multi_column03 == 1):?>
								<?=$row['name']?>
							<?php elseif ($multi_column03 == 2):?>
								<?=$row['email']?>
							<?php elseif ($multi_column03 == 3):?>
								<?=$row['tel']?>
							<?php endif?>
						</td>
						<td><?=date('Y-m-d H:i', strtotime($row['contacted_at']))?></td>
					</tr>
				<?php endforeach?>
				</tbody>
			</table>
			<div id="operation" class="panel panel-default">
				<div id="checkall" class="panel-heading">
					<i class="fa fa-arrow-circle-up"></i> <span id="checkall_title"><?=TXT_CONTACTS_LBL_CHECKALL?></span>
					<label class="checkbox-inline" for="allow_delete"><input type="checkbox" id="allow_delete" name="allow_delete"> <?=TXT_CONTACTS_LBL_ALLOWDELETE?></label>
				</div>
				<div class="panel-body">
					<div class="operationHead"><?=TXT_CONTACTS_LBL_ACTION_TO?></div>
					<div class="operationBody">
						<div>
							<div class="operationButton">
								<button type="button" id="to_status_1" class="btn btn-sm btn-default" data-hover_class="btn-primary" data-status_txt="<?=TXT_CONTACTS_BTN_TO_COMPLETED?>" data-process="32"><?=TXT_CONTACTS_BTN_TO_COMPLETED?></button>
								<button type="button" id="to_status_7" class="btn btn-sm btn-default" data-hover_class="btn-success" data-status_txt="<?=TXT_CONTACTS_BTN_TO_ONGOING?>" data-process="32"><?=TXT_CONTACTS_BTN_TO_ONGOING?></button>
								<button type="button" id="to_status_8" class="btn btn-sm btn-default" data-hover_class="btn-warning" data-status_txt="<?=TXT_CONTACTS_LBL_UNCONFIRMED?>" data-process="32"><?=TXT_CONTACTS_BTN_TO_UNCONFIRMED?></button>
								<button type="button" id="to_delete" class="btn btn-sm btn-danger" data-status_txt="<?=TXT_CONTACTS_LBL_DELETE?>" data-process="39"><?=TXT_CONTACTS_BTN_DELETE?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php else:?>
				<div class="alert alert-warning slow-show-sub"><?=TXT_CONTACTS_WAR_NOCONTACT($page_title_main)?></div>
			<?php endif?>
		</div>
	</div>
</main>
<link rel="stylesheet" href="plugin/datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
<script src="plugin/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<?php if ($_SESSION[$session_key]['user']['lang'] != 'en'):?>
<script src="plugin/datetimepicker/locales/bootstrap-datetimepicker.<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<?php endif ?>