
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="fa <?=$page_icon?>"></i>
				<?=$page_title_main?>
				<?php if ($layer > 1):?>
					<span class="label label-primary"><?=TXT_COMMENTS_LBL_SUBSTRATUM?><?=$layer-1?></span>
				<?php endif?>
				<?=$page_title_sub?>
				<span id="amount" class="badge"> <?=$amount_post?> </span>
			</h3>
		</div>
	</div>
	
	<!-- SEARCH -->
	<div class="operation clearfix">
		<nav class="navbar navbar-default" role="navigation">
			<form class="navbar-form navbar-left form-inline" id="search_box" role="search" method="post" onsubmit="javascript:return false;" action="">
				<div class="form-group">
					<select class="form-control defaultOption" name="sc_status" id="sc_status">
						<option value=""><?=TXT_COMMENTS_SEL_DEFAULT_STATUS?></option>
						<?php foreach ($comment_status as $key => $value):?>
							<option value="<?=$key?>" <?=($sc_status===(string)$key)?'selected':''?>><?=$value?></option>
						<?php endforeach?>
					</select>
				</div>
				<?php if ($type == 2):?>
					<div class="form-group">
						<select class="form-control defaultOption" id="sc_score" name="sc_score">
							<option value=""><?=TXT_COMMENTS_SEL_DEFAULT_SCORE?></option>
							<?php for ($score = $config_posttype['review_max_score']; $score > 0; $score -- ):?>
								<option value="<?=$score?>" <?=($score==$sc_score)?'selected':''?>><?=$score?></option>
							<?php endfor?>
						</select>
					</div>
				<?php endif?>
				<?php if (! empty($target_post)):?>
					<div class="form-group">
					<span id="search-target_post" class="label label-primary label-narrowdown">
						<a href="./?clear_post_id=1"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
						<?=TXT_COMMENTS_NARROWDOWN_POSTID($config_posttype['name'])?>
					</span>
					</div>
				<?php endif?>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" name="sc_text" id="sc_text" value="<?=$sc_text?>" placeholder="<?=TXT_COMMENTS_PLH_SEARCH_TEXT?>" <?=($layer>1)?'disabled':''?>>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="sc_posted_at_start" id="sc_posted_at_start" value="<?=$sc_posted_at_start?>" placeholder="<?=TXT_COMMENTS_PLH_SEARCH_STARTDATE?>" <?=($layer>1)?'disabled':''?>>
				</div>
				<div class="form-group input150">
					<input type="text" class="form-control" name="sc_posted_at_end" id="sc_posted_at_end" value="<?=$sc_posted_at_end?>" placeholder="<?=TXT_COMMENTS_PLH_SEARCH_ENDDATE?>" <?=($layer>1)?'disabled':''?>>
				</div>
				<input type="hidden" id="type" name="type" value="<?=$type?>">
				<div class="form-group">
					<a class="btn btn-<?=($set_condition_flg)?'primary':'default'?>" name="resetup" href="./?clear=1<?=($layer==1)?'&clear_post_id=1':null?>&amp;type=<?=$type?>"><?=TXT_COMMENTS_LBL_SEARCH_CLEAR?></a>
				</div>
			</form>
		</nav>
	</div>
	
	<!-- TARGET POST -->
	<?php if (! empty($target_post)):?>
		<div class="targetContent clearfix">
			<div class="col-md-12">
				<label class="control-label" for="title"><?=TXT_COMMENTS_LBL_TARGET($config_posttype['name'])?></label>
			</div>
			<div class="targetContent-eyecatch col-md-2">
				<?php if (! empty($target_post['eyecatch'])):?>
					<?php if (strstr($target_post['eyecatch'], '.pdf')):?>
						<img class="thumbnail" src="img/pdf_small.png" alt="">
					<?php else:?>
						<img src="<?=$target_post['eyecatch']?>" alt="">
					<?php endif?>
				<?php else:?>
					<img src="img/noimage.png" alt="noImage">
				<?php endif?>
			</div>
			<div class="col-md-10">
				<h4 class="targetContent-title"><a href="./?view_page=post&id=<?=$sc_post_id?>&amp;process=12"><?=$target_post['title']?></a></h4>
				<p><?=$target_post['content']?></p>
				<a href="./?view_page=comment&process=21&amp;post_id=<?=$sc_post_id?>&amp;type=<?=$type?>"><i class="fa fa-pencil"></i> <?=TXT_COMMENTS_LNK_CREATE($page_title_main)?></a>
			</div>
		</div>
	<?php endif?>
	
	<?php if (! empty($target_comment)):?>
		<!-- TARGET COMMENT -->
		<div class="targetContent clearfix">
			<div class="col-md-12">
				<label class="control-label" for="title"><?=TXT_COMMENTS_LBL_TARGET($page_title_main)?></label>
			</div>
			<div class="targetContent-eyecatch col-md-2">
				<?php if (! empty($target_comment['eyecatch'])):?>
					<img src="<?=$target_comment['eyecatch']?>" alt="">
				<?php else:?>
					<img src="img/noimage.png" alt="noImage">
				<?php endif?>
			</div>
			<div class="col-md-10">
				<h4 class="targetContent-title"><a href="./?view_page=comment&id=<?=$row['id']?>&amp;process=12"><?=$target_comment['title']?> <?=($target_comment['nickname'])?'('.$target_comment['nickname'].')':null?></a></h4>
				<p><?=$target_comment['content']?></p>
				<a href="./?view_page=comment&process=21&amp;post_id=<?=$sc_post_id?>&amp;comment_id=<?=$target_comment['link_comment_id']?>&amp;parent_id=<?=$target_comment['id']?>&amp;type=<?=$type?>"><i class="fa fa-pencil"></i> <?=TXT_COMMENTS_LNK_REPLY($page_title_main)?></a>
			</div>
		</div>
	<?php endif?>
	
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
					<?php if ($config_posttype['comments_list_num'] > $prev_value && $config_posttype['comments_list_num'] < $value):?>
						<li><a href="./?limit=<?=$config_posttype['comments_list_num']?>&amp;page=1" class="<?=($config_posttype['comments_list_num']==$limit)?'textDecorationUnderline':''?>"><?=$config_posttype['comments_list_num']?></a></li> |
					<?php endif?>
					<li><a href="./?limit=<?=$value?>&amp;page=1" class="<?=($value==$limit)?'textDecorationUnderline':''?>"><?=$value?></a></li> |
					<?php $prev_value = $value?>
				<?php endforeach?>
			</ul>
		<?php endif?>
	</div>
	
	<!-- INNER WRAP -->
	<div id="comment_wrap" class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<?php if (count($records)):?>
		<div class="slow-show">
			<table id="comment_list" class="table table-hover">
				<thead>
				<tr>
					<th>
							<span class="<?=($multi_column01!=1)?'hidden':''?>">
								<?php if (strlen($_SESSION[$session_key]['comments']['sc_status']) == 1):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
								<a href="./?multi_column01=2">
								<?=TXT_COMMENTS_THD_STATUS?> /
									<?php if ($_SESSION[$session_key]['comments']['sc_text']):?>
										<i class="fa fa-filter text-primary"></i>
									<?php endif?>
									<?=TXT_COMMENTS_THD_TITLECONTENT?>
								</a>
							</span>
						<span class="<?=($multi_column01!=2)?'hidden':''?>">
								<?php if (strlen($_SESSION[$session_key]['comments']['sc_status']) == 1):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
							<a href="./?multi_column01=1">
								ID /
								<?php if ($_SESSION[$session_key]['comments']['sc_text']):?>
									<i class="fa fa-filter text-primary"></i>
								<?php endif?>
								<?=TXT_COMMENTS_THD_TITLECONTENT?>
								</a>
							</span>
					</th>
					<th>
						<?php if ($_SESSION[$session_key]['comments']['sc_post_id']):?>
							<i class="fa fa-filter text-primary"></i>
						<?php endif?>
						<?=TXT_COMMENTS_LBL_TARGET($config_posttype['name'])?>
					</th>
					<th>
							<span class="<?=($multi_column03!=1)?'hidden':''?>">
							<?php if ($type == 2):?>
								<a href="./?multi_column03=2"><?=TXT_COMMENTS_THD_AUTHOR?></a>
							<?php else:?>
								<?=TXT_COMMENTS_THD_AUTHOR?>
							<?php endif?>
							</span>
						<?php if ($type == 2):?>
							<span class="<?=($multi_column03!=2)?'hidden':''?>">
							<a href="./?multi_column03=1">
								<?=TXT_COMMENTS_THD_SCORE?>
								<?php if ($type == 2):?>
									(<?=$score_average?>)
								<?php endif?>
							</a>
							</span>
						<?php endif?>
					</th>
					<th>
						<?php if ($type != 2):?>
							<?php if ($parent_id > 0):?>
								<a href="./?clear=1&sc_status=<?=$sc_status?>&related_parent_id=<?=$parent_id?>&sc_comment_id=<?=($parent_parent_id)?$sc_comment_id:0?>&sc_parent_id=<?=$parent_parent_id?>&layer=<?=$layer-1?>&page=<?=$page_layer[$layer-1]?>">
									<i class="fa fa-arrow-left" aria-hidden="true"></i>
								</a>
							<?php endif?>
							<?=TXT_COMMENTS_THD_RELATEDCOMMENT($page_title_main)?> <span class="badge"> <?=$count_children?> </span>
						<?php endif?>
					</th>
					<th>
						<a href="./?page=<?=$this_page?>&sort=<?=$sort_reverse?>">
							<i class="fa fa-sort-numeric-<?=($sort=='DESC')?'desc':'asc'?>"></i>
							<?=TXT_COMMENTS_THD_POSTDATETIME?></a>
					</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($records as $row):?>
					<tr class="<?=($row['id']==$new_id)?'info':''?><?=($row['id']==$updated_id)?'success':''?><?=($row['id']==$prev_id)?'active':''?><?=($row['id']==$related_parent_id)?'warning':''?>">
						<td>
							<span class="batchCheck"><input type="checkbox" name="change_status[]" value="<?=$row['id']?>"></span>
							<span class="<?=($multi_column01!=1)?'hidden':''?>">
								<?php if($row['status']==1):?>
									<?php if (strtotime($row['posted_at']) > strtotime(date('Y-m-d H:i:s'))):?>
										<span class="label label-status label-info"><?=TXT_COMMENTS_LBL_FUTURE?></span>
									<?php else:?>
										<span class="label label-status label-primary"><?=TXT_COMMENTS_LBL_PUBLISHED?></span>
									<?php endif?>
								<?php elseif($row['status']==2):?>
									<span class="label label-status label-warning"><?=TXT_COMMENTS_LBL_RESERVATION?></span>
								<?php else:?>
									<span class="label label-status label-default"><?=TXT_COMMENTS_LBL_PRIVATE?></span>
								<?php endif?>
							</span>
							<span class="<?=($multi_column01!=2)?'hidden':''?>">
								<?php if($row['status']==1):?>
									<?php if (strtotime($row['posted_at']) > strtotime(date('Y-m-d H:i:s'))):?>
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
							<?php if(!empty($row['comment_title'])):?>
								<a href="./?view_page=comment&id=<?=$row['id']?>&amp;process=22&amp;type=<?=$type?>"><?=$row['comment_title']?></a>
							<?php elseif(!empty($row['comment_content'])):?>
								<a href="./?view_page=comment&id=<?=$row['id']?>&amp;process=22&amp;type=<?=$type?>">[<?=$row['comment_content']?>]</a>
							<?php else:?>
								<a href="./?view_page=comment&id=<?=$row['id']?>&amp;process=22"><i><?=TXT_COMMENTS_LBL_NOTITLE?></i></a>
							<?php endif?>
						</td>
						<td>
							<?php if(!empty($row['post_title'])):?>
								<a href="./?view_page=comments&sc_post_id=<?=$row['post_id']?>&amp;type=<?=$type?>&amp;page=1"><?=$row['post_title']?></a>
							<?php else:?>
								<a href="./?view_page=comments&sc_post_id=<?=$row['post_id']?>&amp;type=<?=$type?>&amp;page=1"><i><?=TXT_COMMENTS_LBL_NOTITLE?></i></a>
							<?php endif?>
						</td>
						<td>
							<span class="<?=($multi_column03!=1)?'hidden':''?>">
								<?php if ($type == 3):?>
									<?=substructString($row['user_nickname'], 8)?>
								<?php else:?>
									<?=substructString($row['nickname'], 8)?>
								<?php endif?>
							</span>
							<span class="<?=($multi_column03!=2)?'hidden':''?>">
								<span class="label label-primary"><?=$row['score']?></span>
								<span class="score list">
									<?php for ($i=1; $i<=$row['score']; $i++):?>
										<i class="fa fa-star"></i>
									<?php endfor?>
									<?php for ($i=1; $i<=($config_posttype['review_max_score']-$row['score']); $i++):?>
										<i class="fa fa-star-o"></i>
									<?php endfor?>
								</span>
							</span>
						</td>
						<td>
							<?php if ($type != 2):?>
								<span class="newRelatedComment"><a href="./?view_page=comment&process=21&post_id=<?=$row['post_id']?>&comment_id=<?=($row['comment_id'])?$row['comment_id']:$row['id']?>&parent_id=<?=$row['id']?>&type=<?=$type?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?=TXT_COMMENTS_LINK_NEW?></a></span>
								<?php if (! empty($row['children']['total'])):?>
									<?php $lable_status = (empty($row['children'][2])) ? (empty($row['children'][1])) ? 'default' : 'primary' : 'warning'?>
									<span class="label label-extra label-<?=$lable_status?>"><i class="fa fa-share-alt" aria-hidden="true"></i> <?=$row['children']['total']?></span>
									<a href="./?clear=1&sc_status=<?=$sc_status?>&sc_post_id=<?=$row['post_id']?>&sc_comment_id=<?=($row['comment_id'])?$row['comment_id']:$row['id']?>&sc_parent_id=<?=$row['id']?>&layer=<?=$layer+1?>&page_layer=<?=$this_page?>&page=1"> <i class="fa fa-arrow-right"></i></a>
								<?php endif?>
							<?php endif?>
						</td>
						<td><?=date('Y-m-d H:i', strtotime($row['posted_at']))?></td>
					</tr>
				<?php endforeach?>
				</tbody>
			</table>
			<div id="operation" class="panel panel-default">
				<div id="checkall" class="panel-heading">
					<i class="fa fa-arrow-circle-up"></i> <span id="checkall_title"><?=TXT_COMMENTS_LBL_CHECKALL?></span>
					<label class="checkbox-inline" for="allow_delete"><input type="checkbox" id="allow_delete" name="allow_delete"> <?=TXT_COMMENTS_LBL_ALLOWDELETE?></label>
				</div>
				<div class="panel-body">
					<?=TXT_COMMENTS_LBL_ACTION_TO($page_title_main)?>
					<div id="operationButton" data-target="<?=$page_title_main?>">
						<button type="button" id="to_status_1" class="btn btn-sm btn-default" data-hover_class="btn-primary" data-status_txt="<?=TXT_COMMENTS_LBL_PUBLISHED?>" data-process="22"><?=TXT_COMMENTS_BTN_TO_PUBLISH?></button>
						<button type="button" id="to_status_2" class="btn btn-sm btn-default" data-hover_class="btn-warning" data-status_txt="<?=TXT_COMMENTS_LBL_RESERVATION?>" data-process="22"><?=TXT_COMMENTS_BTN_TO_RESERVATION?></button>
						<button type="button" id="to_status_8" class="btn btn-sm btn-default" data-hover_class="btn-default" data-status_txt="<?=TXT_COMMENTS_LBL_PRIVATE?>" data-process="22"><?=TXT_COMMENTS_BTN_TO_PRIVATE?></button>
						<button type="button" id="to_delete" class="btn btn-sm btn-danger" data-status_txt="<?=TXT_COMMENTS_LBL_DELETE?>" data-process="29"><?=TXT_COMMENTS_BTN_DELETE?></button>
					</div>
				</div>
			</div>
			<?php else:?>
				<div class="alert alert-warning"><?=TXT_COMMENTS_WAR_NOCOMMENT($page_title_main)?></div>
			<?php endif?>
		</div>
	</div>
</main>
<link rel="stylesheet" href="plugin/datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
<script src="plugin/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<?php if ($_SESSION[$session_key]['user']['lang'] != 'en'):?>
	<script src="plugin/datetimepicker/locales/bootstrap-datetimepicker.<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<?php endif?>