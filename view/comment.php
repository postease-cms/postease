
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3> <?=$back_link?></div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="comment_wrap" class="col-md-12">
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
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
					</div>
				</div>
			<?php endif?>
			
			<?php if (! empty($target_comment)):?>
				<!-- TARGET COMMENT -->
				<div class="targetContent clearfix">
					<div class="col-md-12">
						<label class="control-label" for="title"><?=TXT_COMMENTS_LBL_TARGETCOMMENT?></label>
					</div>
					<div class="targetContent-eyecatch col-md-2">
						<?php if (! empty($target_comment['eyecatch'])):?>
							<?php if (strstr($target_comment['eyecatch'], '.pdf')):?>
								<img class="thumbnail" src="img/pdf_small.png" alt="">
							<?php else:?>
								<img src="<?=$target_comment['eyecatch']?>" alt="">
							<?php endif?>
						<?php else:?>
							<img src="img/noimage.png" alt="noImage">
						<?php endif?>
					</div>
					<div class="col-md-10">
						<h4 class="targetContent-title"><a href="./?view_page=comment&id=<?=$row['id']?>&amp;process=12"><?=$target_comment['title']?> <?=($target_comment['nickname'])?'('.$target_comment['nickname'].')':null?></a></h4>
						<p><?=$target_comment['content']?></p>
					</div>
				</div>
			<?php endif?>
			
			<!-- FORM -->
			<form id="comment" role="form" action="./_execute.php" method="post">
				
				<!-- Left// -->
				<div class="col-md-9">
					
					<?php if ($type == 2):?>
						<!-- score -->
						<div class="form-group">
							<label class="control-label" for="title"><?=TXT_COMMENT_LBL_SCORE?></label>
							<div>
							<span class="score detail">
								<?php for ($i=1; $i<=$score; $i++):?>
									<i class="fa fa-star"></i>
								<?php endfor?>
								<?php for ($i=1; $i<=($config_posttype['review_max_score']-$score); $i++):?>
									<i class="fa fa-star-o"></i>
								<?php endfor?>
							</span><br>
							</div>
						</div>
					<?php endif?>
					
					<!-- title -->
					<div class="form-group">
						<label class="control-label" for="title"><?=TXT_COMMENT_LBL_TITLE?></label>
						<div><input class="form-control" type="text" id="title" name="title" value="<?=$title?>" disabled></div>
					</div>
					
					<!-- content -->
					<div class="form-group post_item_container">
						<label class="control-label" for="content"><?=TXT_COMMENT_LBL_CONTENT?></label>
						<textarea class="form-control" id="content" name="content" disabled><?=$content?></textarea>
					</div>
					
					<!-- nickname -->
					<div class="form-group <?=($type==3)?'hidden':''?>">
						<label class="control-label" for="nickname"><?=TXT_COMMENT_LBL_AUTHORNAME?></label>
						<div><input class="form-control" type="text" id="nickname" name="nickname" value="<?=$nickname?>" disabled></div>
					</div>
					
					<!-- email -->
					<div class="form-group <?=($process==21)?'post_item_container':''?> <?=($type==3)?'hidden':''?>">
						<label class="control-label" for="email"><?=TXT_COMMENT_LBL_AUTHOREMAIL?></label>
						<div><input class="form-control" type="text" id="email" name="email" value="<?=$email?>" disabled></div>
					</div>
					
					<?php if ($process != 21 && ! $posted_by):?>
						<!-- ip address -->
						<div class="form-group">
							<label class="control-label" for="ip_address"><?=TXT_COMMENT_LBL_AUTHORIP?></label>
							<div><input class="form-control" type="text" id="ip_address" name="ip_address" value="<?=$ip_address?>" disabled></div>
						</div>
					<?php elseif ($process != 21 && $posted_by):?>
						<div class="form-group <?=($type==3)?'hidden':''?>">
							<p class="text-primary"><?=TXT_COMMENT_MSG_NOCOMMENT($page_title_main, $posted_by)?></p>
						</div>
					<?php endif?>
					
					<!-- note -->
					<div class="form-group post_item_container <?=($type==3)?'hidden':''?>">
						<label class="control-label" for="note"><i class="fa fa-pencil-square-o"></i> <?=TXT_COMMENT_LBL_MEMO?></label>
						<textarea class="form-control" id="note" name="note"><?=$note?></textarea>
					</div>
				
				</div>
				<!-- //Left -->
				
				<!-- Right// -->
				<idv class="col-md-3">
					<div class="form-group post_item_container">
						<label class="control-label" for="publish_date"><i class="fa fa-calendar"></i> <?=$page_title_main?><?=TXT_COMMENT_LBL_POSTEDAT?></label>
						<div>
							<input class="form-control" type="text" id="posted_at" name="posted_at" value="<?=$posted_at?>" placeholder="<?=TXT_COMMENT_PLH_POSTEDAT?>" required disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label" for="status"><i class="fa fa-check-square-o"></i> <?=TXT_COMMENT_LBL_STATUS?></label>
						<div>
							<?php foreach ($comment_status as $key => $value):?>
								<label class="radio-inline" for="status_<?=$key?>"><input type="radio" id="status_<?=$key?>" name="status" value="<?=$key?>" <?=($key==$status||$process==21&&$key==1)?'checked':''?>> <?=$value?></label>
								<small><a class="changeStatusClose" data-status="<?=$key?>">(<?=TXT_COMMENT_LBL_CHANGESTATUS_SAVE($value)?>)</a></small>
								<br>
							<?php endforeach?>
						</div>
					</div>
					
					<?php if ($_SESSION[$session_key]['user']['role'] != 8 && $process != 21):?>
						<div class="form-group">
							<?php if ($type != 3):?>
								<div><label class="control-label" for="edit_check"><input type="checkbox" id="edit_check" name="edit_check"> <?=TXT_COMMENT_LBL_EDIT($page_title_main)?></label></div>
							<?php endif?>
							<div><label class="control-label" for="delete_check"><input type="checkbox" id="delete_check" name="delete_check"> <?=TXT_COMMENT_LBL_DELETE($page_title_main)?></label></div>
						</div>
					<?php endif?>
					
					<!-- buttons -->
					<input type="hidden" name="target_id" id="target_id" value="<?=$id?>">
					<input type="hidden" name="post_id" id="post_id" value="<?=$post_id?>">
					<input type="hidden" name="comment_id" id="comment_id" value="<?=$comment_id?>">
					<input type="hidden" name="parent_id" id="parent_id" value="<?=$parent_id?>">
					<input type="hidden" name="type" id="type" value="<?=$type?>">
					<input type="hidden" name="score" id="score" data-review_max_score="<?=$config_posttype['review_max_score']?>" value="<?=$score?>">
					<input type="hidden" name="process" id="process" value="<?=$process?>">
					<div class="form-group post_item_container">
						<input class="btn btn-primary" type="submit" id="update_comment" name="update_comment" value="<?=$submit_value?>">
						<input class="btn btn-danger" type="submit" id="delete_comment" name="delete_comment" value="<?=TXT_COMMENT_BTN_DELETE?>">
					</div>
					
					<?php if (count($_SESSION[$session_key]['common']['sites']) > 1):?>
						<div class="form-group hidden">
							<label class="control-label" for="site_id"><?=TXT_COMMENT_LBL_SITEID?></label>
							<select class="form-control" id="site_id" name="site_id" disabled>
								<?php foreach ($_SESSION[$session_key]['common']['sites'] as $key => $value):?>
									<option value="<?=$key?>" <?=($_SESSION[$session_key]['common']['this_site']==$key)?'selected="selected"':''?>><?=$value?></option>
								<?php endforeach?>
							</select>
						</div>
					<?php endif?>
					
					<?php if (count($_SESSION[$session_key]['common']['posttypes']) > 1):?>
						<div class="form-group hidden">
							<label class="control-label" for="posttype_id"><?=TXT_COMMENT_LBL_POSTTYPE?></label>
							<select class="form-control" id="posttype_id" name="posttype_id" disabled>
								<?php foreach ($_SESSION[$session_key]['common']['posttypes'] as $key => $values):?>
									<option value="<?=$key?>" <?=($_SESSION[$session_key]['common']['this_posttype']==$key)?'selected="selected"':''?>><?=$values['name']?></option>
								<?php endforeach?>
							</select>
						</div>
					<?php endif?>
					
					<?php if ($type == 3):?>
						<!-- eyecatch -->
						<div class="form-group post_item_container">
							<label class="control-label" for="eyecatch"><i class="fa fa-eye"></i> <?=TXT_POST_LBL_EYECATCH?></label>
							<div id="eyecatch_wrap">
								<input type="hidden" id="eyecatch_target" name="eyecatch_target" value="<?=$eyecatch_target?>">
								<input type="hidden" id="eyecatch" name="eyecatch" value="<?=$eyecatch?>">
							</div>
							<a href="filemanager/dialog.php?type=2&field_id=eyecatch" type="button" id="set_eyecatch" class="btn btn-success openFilemanager notLink"><?=TXT_POST_BTN_IMG_SET?></a>
							<button type="button" id="remove_eyecatch" class="btn btn-warning hidden"><?=TXT_POST_BTN_IMG_DELETE?></button>
						</div>
					<?php endif?>
					
					<?php if ($posted_atby):?>
						<div class="form-group post_item_container">
							<label class="control-label" for="created_atby"><i class="fa fa-check-circle-o"></i> <?=TXT_COMMENT_LBL_CREATEDATBY?></label>
							<div id="created_atby"><?=$posted_atby?></div>
						</div>
					<?php endif?>
					
					<?php if ($updated_atby):?>
						<div class="form-group post_item_container">
							<label class="control-label" for="updated_atby"><i class="fa fa-check-circle-o"></i> <?=TXT_COMMENT_LBL_UPDATEDATBY?></label>
							<div id="updated_atby"><?=$updated_atby?></div>
						</div>
					<?php endif?>
					
					<?php if ($type != 2):?>
						<?php if ($process != 21):?>
							<div class="form-group post_item_container">
								<div>
									<i class="fa fa-comments"></i> <?=TXT_COMMENT_LBL_CHILDREN($page_title_main)?> <a href="./?view_page=comment&process=21&post_id=<?=$post_id?>&comment_id=<?=$comment_id?>&parent_id=<?=$id?>&type=<?=$type?>"> <?=$count_children?> <?=TXT_GLOBAL_UNT_COUNT?> &raquo; <?=TXT_COMMENT_LBL_NEWCOMMENT?></a>&nbsp;
								</div>
							</div>
						<?php endif?>
					<?php endif?>
		
		</div>
		<!-- //Right -->
		</form>
	</div>
	</div>
</main>
<link rel="stylesheet" href="plugin/datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
<script src="plugin/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<?php if ($_SESSION[$session_key]['user']['lang'] != 'en'):?>
	<script src="plugin/datetimepicker/locales/bootstrap-datetimepicker.<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<?php endif?>