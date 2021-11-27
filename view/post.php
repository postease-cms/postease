<?php
//print '<pre>';
//print_r($_SESSION);
//print '</pre>';
//exit;
?>
<!-- OUTER WRAP -->
<main id="content" class="col-md-10" data-site="<?=$site_slug?>" data-posttype="<?=$posttype_slug?>" data-auto_save_flg="<?=($status==1)?0:$auto_save_flg?>" data-tinymce_init="<?=$tinymce_init?>?v=<?=filemtime($tinymce_init)?>" data-tinymce_css="<?=$tinymce_css?>?v=<?=filemtime($tinymce_css)?>" data-editable_flg="<?=$editable_flg?>" data-use_permalink="<?=($resource_url||$rewrite_url)?1:0?>">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-left">
				<h3 class="panel-title">
					<i class="fa <?=$page_icon?>"></i>
					<?=$page_title_main?>
					<?php if (! empty($id)):?>
						<span class="label label-<?=$label_status?>">ID : <?=$id?></span>
					<?php endif?>
					<?php if ($_SESSION[$session_key]['configs']['use_version_flg'] && $process == 12 && $status == 1):?>
						<?php if ($post_base['current_flg']):?>
							<span class="label label-primary"><?=TXT_POST_LBL_RELEASEDVERSION?></span>
						<?php else:?>
							<span class="label label-default"><?=TXT_POST_LBL_PRIVATEVERSION?></span>
						<?php endif?>
					<?php endif?>
					<?=$page_title_sub?>
				</h3>
				<?=$back_link?>
			</div>
			<div class="panel-right">
				<?php if ($config_posttype['use_multipage_flg']):?>
					<?php if (count($post_pages) > 1 || ! empty($parent_id)):?>
						<ul id="post_pager">
							<?php foreach ($post_pages as $page_no => $page):?>
								<?php if ($page['id']==$id) $this_post_page = $page_no?>
								<li>
									<?php if ($page['id'] > 0):?>
										<a class="<?=$page['label']?> <?=($page['id']==$id)?'selected':''?>" href="./?view_page=post&amp;id=<?=$page['id']?>&amp;version=<?=$version?>&amp;process=12"><?=$page_no?></a>
									<?php else:?>
										<a class="<?=$page['label']?> <?=($page['id']==$id)?'selected':''?>"><?=$page_no?></a>
									<?php endif?>
								</li>
							<?php endforeach?>
						</ul>
					<?php endif?>
					<?php if (! empty($id) && $editable_flg):?>
						<a href="./?view_page=post&amp;this_posttype=<?=$_SESSION[$session_key]['common']['this_posttype']?>&amp;this_posttype_order=<?=$_SESSION[$session_key]['common']['this_posttype_order']?>&amp;process=11&amp;parent_id=<?=$target_parent_id?>&amp;version=<?=$version?>&amp;current_flg=<?=$current_flg?>">
							<i class="fa fa-plus-square-o" aria-hidden="true"></i>
							<?=TXT_POST_LBL_NEWPAGE?>
						</a>
					<?php endif?>
				<?php endif?>
			</div>
		</div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="post_wrap">
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<?php if (! empty($_GET['errormsg'])):?>
				<div class="alert alert-danger">
					<?=$execute_errormsg[$_GET['errormsg']]?>
				</div>
			<?php endif?>
			
			<!-- PROCESS MESSAGE -->
			<?php if(isset($process_msg)):?>
				<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
			<?php endif?>

			<!-- FORM -->
			<?php if (count($_SESSION[$session_key]['common']['languages'])):?>
				<form id="post" name="post" role="form" action="./_execute.php" method="post">
					
					<!-- Left// -->
					<div class="col-md-9">

            <!-- newer version -->
            <?php if ($editable_flg && $use_version_flg):?>
            <?php if ($newer_version > 0):?>
              <p class="alert alert-warning"><a href="?id=<?=$id?>&version=<?=$newer_version?>&process=12"><i class="fa fa-pencil" aria-hidden="true"></i> <?=TXT_POST_LBL_HAS_NEW_DRAFTVERSION?></a></p>
            <?php endif?>
            <?php endif?>

						<!-- auto save -->
						<?php if (! $editable_flg):?>
							<p class="alert alert-danger"><?=TXT_POST_MSG_UNEDITABLE?></p>
            <?php else:?>
              <?php if ($auto_save_flg):?>
                <?php if ($status == 1 && $current_flg == 1):?>
                  <p id="auto_save_mode" class="label label-success"><?=TXT_POST_LBL_AUTOSAVEMODE_CANCELED_PUBLISH?></p>
                <?php elseif ($status == 1 && $current_flg == 0):?>
                  <p id="auto_save_mode" class="label label-success"><?=TXT_POST_LBL_AUTOSAVEMODE_CANCELED_ARCHIVE?></p>
                <?php elseif ($status != 1):?>
                  <p id="auto_save_mode" class="label label-success"><?=TXT_POST_LBL_AUTOSAVEMODE?> ON</p>
                  <small><a href="javascript:turnAutoSave();"> (<?=TXT_POST_LNK_TURN_AUTOSAVE($auto_save_flg)?>)</a></small>
                <?php endif?>
              <?php else:?>
                <p id="auto_save_mode" class="label label-default"><?=TXT_POST_LBL_AUTOSAVEMODE?> OFF</p>
                <small><a href="javascript:turnAutoSave();"> (<?=TXT_POST_LNK_TURN_AUTOSAVE($auto_save_flg)?>)</a></small>
              <?php endif?>
            <?php endif?>

						<!-- permalink -->
						<?php if ($resource_url || $rewrite_url):?>
							<p id="permalink_display" data-language_id="<?=$language_id?>" data-permalink_type="<?=$permalink_type?>" data-permalink_style="<?=$permalink_style?>"
							   data-permalink_base="<?=$permalink_base?>" data-id="<?=$id?>" data-hash_id="<?=$hash_id?>">
								<i class="fa fa-link" aria-hidden="true"></i> <?=TXT_POST_LNK_PERMALINK?> :
								<label class="label label-default"></label>
							</p>
						<?php endif?>
						
						<!-- language tab -->
						<ul class="nav nav-tabs <?=(count($_SESSION[$session_key]['common']['languages'])==1)?'hidden':''?>" id="textTab">
							<?php foreach ($_SESSION[$session_key]['common']['languages'] as $key => $row):?>
								<li <?=($key==1)?'class="active"':''?> data-target_lang="<?=$key?>"><a class="notLink languageTab" id="language_tab_<?=$key?>" href="#text<?=$key?>" data-toggle="tab"><?=$row['name']?></a></li>
							<?php endforeach?>
						</ul>
						
						<!-- tab content -->
						<div class="tab-content">
							<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
								<div class="tab-panel <?=($language_id==1)?'active':''?>" id="text<?=$language_id?>">
									
									<?php if ($customitem_position > 1):?>
										
										<!-- title -->
										<div class="form-group <?=($use_slug_flg)?'':'post_item_container'?>">
											<label class="control-label" for="title_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$label_title?>&nbsp;<span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
											<div><input class="form-control" type="text" data-group="title" data-num="<?=$language_id?>" id="title_<?=$language_id?>" name="title[<?=$language_id?>]" value="<?=$text[$language_id]['title']?>" placeholder="<?=($use_slug_flg)?TXT_POST_PLH_TITLEWITHSLUG:$label_title?>" <?=($child_flg)?'disabled':''?>></div>
											<?php if ($config_posttype['use_multipage_flg'] && (count($post_pages) > 1 || ! empty($parent_id))):?>
											<span class="label label-primary">
												<i class="fa fa-clone"></i>
												<?=$this_post_page?> / <?=count($post_pages)?>
											</span>
											<?php endif?>
										</div>

										<!-- slug -->
										<div class="form-group post_item_container <?=($use_slug_flg)?'':'hidden'?>">
											<label class="control-label" for="slug"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?=TXT_POST_LBL_SLUG?>
                      <span class="strlen label label-info"></span>
                      <?php if ($slug):?>
                      <small><a id="change_slug">(<?=TXT_POST_LBL_CHANGE_SLUG?>)</a></small>
                      <?php endif?>
                      </label>
											<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
											<div id="input_wrapper_slug" data-target_table="<?=$table_prefix?>posts_base" data-classification="" data-this_id="<?=$id?>">
												<input class="form-control needValidation" data-valid_type="slug" type="text" id="slug" name="slug" value="<?=$slug?>" <?=($slug)?'readonly':''?> placeholder="<?=TXT_POST_PLH_SLUG?>">
											</div>
										</div>
									
										<!-- addition -->
										<div class="form-group post_item_container <?=($use_addition_flg)?'':'hidden'?>">
											<label class="control-label" for="addition_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$label_addition?> <span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
											<div><textarea class="extra_small form-control" data-group="addition" data-num="<?=$language_id?>" data-language_id="<?=$language_id?>" id="addition_<?=$language_id?>" name="addition[<?=$language_id?>]"><?=$text[$language_id]['addition']?></textarea></div>
                    </div>
									<?php endif?>
									
									<?php if ($customitem_position == 3):?>
										<!-- content -->
										<div class="form-group post_item_container <?=($use_content_flg)?'':'hidden'?> <?=($use_content_flg && $use_wisiwyg_flg)?'tinymceWrapper':''?>">
											<input type="hidden" id="judge_flg_wisiwyg" value="<?=$use_wisiwyg_flg?>">
											<label class="control-label" for="content_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$label_content?>&nbsp;<span class="label label-info" id="strlen_tinymce"></span> <?=($use_wisiwyg_flg)?'':'<span class="strlen label label-info"></span>'?> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
											<textarea class="content <?=($use_wisiwyg_flg)?'mce':'form-control'?>" data-group="content" data-num="<?=$language_id?>" id="content_<?=$language_id?>" name="content[<?=$language_id?>]"><?=htmlentities($text[$language_id]['content'], ENT_QUOTES, 'UTF-8')?></textarea>
										</div>
									<?php endif?>
									
									<!-- custom items -->
									<?php if ($config_posttype['use_customitem_flg']):?>
										<?php if (count($custom_items)):?>
											<?php foreach ($custom_items as $custom_item_id => $row_cust):?>
												<?php if ($row_cust['type'] == 'text'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?> <span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><input class="form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" type="text" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$items[$custom_item_id][$language_id]?>"></div>
													</div>
												<?php elseif ($row_cust['type'] == 'datetime'):?>
                          <div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
                            <label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-calendar"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
                            <div><input class="form-control customDateTime" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" type="text" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$items[$custom_item_id][$language_id]?>"></div>
                          </div>
                        <?php elseif ($row_cust['type'] == 'date'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-calendar"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><input class="form-control customDate" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" type="text" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$items[$custom_item_id][$language_id]?>"></div>
													</div>
												<?php elseif ($row_cust['type'] == 'time'):?>
                          <div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
                            <label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-calendar"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
                            <div><input class="form-control customTime" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" type="text" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$items[$custom_item_id][$language_id]?>"></div>
                          </div>
												<?php elseif ($row_cust['type'] == 'textarea-s'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?> <span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><textarea class="small form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]"><?=$items[$custom_item_id][$language_id]?></textarea></div>
													</div>
												<?php elseif ($row_cust['type'] == 'textarea-m'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?> <span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><textarea class="medium form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]"><?=$items[$custom_item_id][$language_id]?></textarea></div>
													</div>
												<?php elseif ($row_cust['type'] == 'textarea-l'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?> <span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><textarea class="large form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]"><?=$items[$custom_item_id][$language_id]?></textarea></div>
													</div>
												<?php elseif ($row_cust['type'] == 'list'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-list-ul"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><textarea class="medium form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" placeholder="<?=TXT_POST_PLH_LIST?>"><?=$items[$custom_item_id][$language_id]?></textarea></div>
													</div>
												<?php elseif ($row_cust['type'] == 'table'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-table"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div><textarea class="medium form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" placeholder="<?=TXT_POST_PLH_TABLE($column_delimiter_list[$row_cust['choices']])?>"><?=$items[$custom_item_id][$language_id]?></textarea></div>
													</div>
												<?php elseif ($row_cust['type'] == 'syntax'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div class="syntaxDisplay clearfix">
															<div class="col-md-6 col-xs-12" id="syntax_<?=$custom_item_id?>_<?=$language_id?>"></div>
															<div class="col-md-6 col-xs-12">
																<textarea wrap="off" class="syntax form-control" data-syntax_type="<?=$row_cust['choices']?>" data-target_syntax="syntax_<?=$custom_item_id?>_<?=$language_id?>" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]"><?=$items[$custom_item_id][$language_id]?></textarea>
															</div>
														</div>
													</div>
												<?php elseif ($row_cust['type'] == 'relation'):?>
                          <div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
                            <label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-link"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
                            <div>
                              <select class="form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]">
                                <option value=""><?=TXT_POST_LBL_SELECTDEFAULT?></option>
																<?php foreach ($relation_posts[$custom_item_id] as $key_choi => $choice):?>
																	<?php if (! empty($choice)):?>
                                    <option id="items_<?=$custom_item_id?>_<?=$key_choi?>" value="<?=$key_choi?>" <?=($key_choi==$items[$custom_item_id][$language_id])?'selected':''?>><?=$choice?></option>
																	<?php endif?>
																<?php endforeach?>
                              </select>
                            </div>
                          </div>
												<?php elseif ($row_cust['type'] == 'select'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-share-square-o"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div>
															<select class="form-control" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]">
																<option value=""><?=TXT_POST_LBL_SELECTDEFAULT?></option>
																<?php foreach ($row_cust['choices'][$language_id] as $key_choi => $choice):?>
																	<?php if (! empty($choice)):?>
																		<option id="items_<?=$custom_item_id?>_<?=$key_choi?>" value="<?=$choice?>" <?=($choice==$items[$custom_item_id][$language_id])?'selected':''?>><?=$choice?></option>
																	<?php endif?>
																<?php endforeach?>
															</select>
														</div>
													</div>
												<?php elseif ($row_cust['type'] == 'checkbox'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-check-square-o"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div>
															<?php foreach ($row_cust['choices'][$language_id] as $key_choi => $choice):?>
																<?php if (! empty($choice)):?>
																	<label class="checkbox-inline" for="items_<?=$custom_item_id?>_<?=$language_id?>_<?=$key_choi?>"><input data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" type="checkbox" id="items_<?=$custom_item_id?>_<?=$language_id?>_<?=$key_choi?>" name="items[<?=$custom_item_id?>][<?=$language_id?>][]" value="<?=$choice?>" <?=(is_array($items[$custom_item_id][$language_id]) && in_array($choice, $items[$custom_item_id][$language_id]))?'checked':''?>> <?=$choice?></label>
																<?php endif?>
															<?php endforeach?>
														</div>
													</div>
												<?php elseif ($row_cust['type'] == 'radio'):?>
													<div class="form-group post_item_container" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-check-square-o"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div>
															<?php foreach ($row_cust['choices'][$language_id] as $key_choi => $choice):?>
																<?php if (! empty($choice)):?>
																	<label class="radio-inline" for="items_<?=$custom_item_id?>_<?=$language_id?>_<?=$key_choi?>"><input data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" type="radio" id="items_<?=$custom_item_id?>_<?=$language_id?>_<?=$key_choi?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$choice?>" <?=($choice==$items[$custom_item_id][$language_id])?'checked':''?>> <?=$choice?></label>
																<?php endif?>
															<?php endforeach?>
														</div>
													</div>
												<?php elseif ($row_cust['type'] == 'file'):?>
													<div class="form-group post_item_container custome_image_container" id="custome_image_container_<?=$custom_item_id?>_<?=$language_id?>" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-picture-o"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div id="<?=$custom_item_id?>_<?=$language_id?>_wrap" class="custom_image_wrap">
															<input type="hidden" class="custom_image_target" id="items_<?=$custom_item_id?>_<?=$language_id?>_target" name="items_<?=$custom_item_id?>_<?=$language_id?>_target" value="<?=$row_cust['choices']?>">
															<input type="hidden" class="custom_image" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$items[$custom_item_id][$language_id]?>">
														</div>
														<a href="filemanager/dialog.php?type=2&field_id=items_<?=$custom_item_id?>_<?=$language_id?>" type="button" id="set_<?=$custom_item_id?>_<?=$language_id?>" class="btn btn-default notLink openFilemanager set_custom_image"><?=TXT_POST_BTN_IMG_SET?></a>
														<button type="button" id="remove_<?=$custom_item_id?>_<?=$language_id?>" class="btn btn-warning hidden remove_custom_image"><?=TXT_POST_BTN_IMG_DELETE?></button>
													</div>
												<?php elseif ($row_cust['type'] == 'image'):?>
													<div class="form-group post_item_container custome_image_container" id="custome_image_container_<?=$custom_item_id?>_<?=$language_id?>" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-picture-o"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div id="<?=$custom_item_id?>_<?=$language_id?>_wrap" class="custom_image_wrap">
															<input type="hidden" class="custom_image_target" id="items_<?=$custom_item_id?>_<?=$language_id?>_target" name="items_<?=$custom_item_id?>_<?=$language_id?>_target" value="<?=$row_cust['choices']?>">
															<input type="hidden" class="custom_image" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="<?=$items[$custom_item_id][$language_id]?>">
														</div>
														<a href="filemanager/dialog.php?type=2&field_id=items_<?=$custom_item_id?>_<?=$language_id?>" type="button" id="set_<?=$custom_item_id?>_<?=$language_id?>" class="btn btn-default notLink openFilemanager set_custom_image"><?=TXT_POST_BTN_IMG_SET?></a>
														<button type="button" id="remove_<?=$custom_item_id?>_<?=$language_id?>" class="btn btn-warning hidden remove_custom_image"><?=TXT_POST_BTN_IMG_DELETE?></button>
													</div>
												<?php elseif ($row_cust['type'] == 'gallery'):?>
													<?php //print '<pre>';print_r($items);print '</pre>'; ?>
													<div class="form-group post_item_container custome_gallery_container" id="custome_gallery_container_<?=$custom_item_id?>_<?=$language_id?>" data-custom_item_name="custom_<?=$row_cust['slug']?>">
														<label class="control-label" for="items_<?=$custom_item_id?>_<?=$language_id?>"><i class="fa fa-th"></i> <?=$row_cust['name']?>&nbsp;&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
														<div class="row custom_gallery_display">
															<ul class="sortable">
																<?php if (count($items[$custom_item_id][$language_id])):?>
																	<?php foreach ($items[$custom_item_id][$language_id] as $figure):?>
																		<li class="col-xs-6 col-md-3 dropme">
																			<img class="thumbnail" src="<?=$figure['url']?>" alt="*">
																			<input class="thumbnailCaption" placeholder="<?=TXT_POST_PLH_GALLERY_CAPTION?>" value="<?=$figure['caption']?>">
																		</li>
																	<?php endforeach?>
																<?php endif?>
															</ul>
														</div>
														<div class="custom_gallery_trash"><i class="fa fa-trash-o"></i></div>
														<div id="<?=$custom_item_id?>_<?=$language_id?>_wrap" class="custom_gallery_wrap">
															<input type="hidden" class="custom_gallery_addition" id="addition_<?=$custom_item_id?>_<?=$language_id?>" value="">
															<input type="hidden" class="custom_gallery_target" id="items_<?=$custom_item_id?>_<?=$language_id?>_target" name="items_<?=$custom_item_id?>_<?=$language_id?>_target" value="<?=$row_cust['choices']?>">
															<input type="hidden" class="custom_gallery" data-additional_type="gallery" data-group="custom" data-language_id="<?=$language_id?>" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>_<?=$language_id?>" name="items[<?=$custom_item_id?>][<?=$language_id?>]" value="">
														</div>
														<a href="filemanager/dialog.php?type=2&field_id=addition_<?=$custom_item_id?>_<?=$language_id?>" type="button" id="set_<?=$custom_item_id?>_<?=$language_id?>" class="btn btn-default openFilemanager set_custom_gallery notLink"><?=TXT_POST_BTN_IMG_SET?></a>
														<button type="button" id="remove_<?=$custom_item_id?>_<?=$language_id?>" class="btn btn-warning hidden remove_custom_gallery justButton"><?=TXT_POST_BTN_IMG_DELETE?></button>
													</div>
												<?php endif?>
											<?php endforeach?>
										<?php endif?>
									<?php endif?>
									
									<?php if ($customitem_position == 1):?>
										<!-- title -->
										<div class="form-group post_item_container">
											<label class="control-label" for="title_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$label_title?> <span class="strlen label label-info"></span>&nbsp;<?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
											<div><input class="form-control" type="text" data-group="title" data-num="<?=$language_id?>" id="title_<?=$language_id?>" name="title[<?=$language_id?>]" value="<?=$text[$language_id]['title']?>" placeholder="<?=$label_title?>" <?=($child_flg)?'disabled':''?>></div>
											<?php if ($config_posttype['use_multipage_flg'] && (count($post_pages) > 1 || ! empty($parent_id))):?>
                      <span class="label label-primary">
                      <i class="fa fa-clone"></i>
                      <?=$this_post_page?> / <?=count($post_pages)?>
                      </span>
											<?php endif?>
										</div>
										<!-- addition -->
										<div class="form-group post_item_container <?=($use_addition_flg)?'':'hidden'?>">
											<label class="control-label" for="addition_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$label_addition?>&nbsp;<span class="strlen label label-info"></span> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
											<div><input class="form-control" type="text" data-group="addition" data-num="<?=$language_id?>" id="addition_<?=$language_id?>" name="addition[<?=$language_id?>]" value="<?=$text[$language_id]['addition']?>" placeholder="<?=$label_addition?>"></div>
										</div>
									<?php endif?>
									
									<?php if ($customitem_position < 3):?>
										<!-- content -->
										<div class="form-group post_item_container <?=($use_content_flg)?'':'hidden'?> <?=($use_content_flg && $use_wisiwyg_flg)?'tinymceWrapper':''?>">
											<input type="hidden" id="judge_flg_wisiwyg" value="<?=$use_wisiwyg_flg?>">
											<label class="control-label" for="content_<?=$language_id?>"><i class="fa fa-pencil-square-o"></i> <?=$label_content?>&nbsp;<span class="label label-info" id="strlen_tinymce"></span> <?=($use_wisiwyg_flg)?'':'<span class="strlen label label-info"></span>'?> <?=($_SESSION[$session_key]['configs']['use_multilingual_flg']==1)?'<span class="label label-primary">'.$row_lang['name'].'</span>':''?></label>
											<textarea class="content <?=($use_wisiwyg_flg)?'mce':'form-control'?>" data-group="content" data-num="<?=$language_id?>" id="content_<?=$language_id?>" name="content[<?=$language_id?>]"><?=htmlentities($text[$language_id]['content'], ENT_QUOTES, 'UTF-8')?></textarea>
										</div>
									<?php endif?>
								
								</div>
							<?php endforeach?>
						</div>
					
					</div>
					<!-- //Left -->
					
					<!-- Right// -->
					<div class="col-md-3" id="post_side_bar">

						<div class="form-group statusTextWrapper">
							<span class="label label-<?=$label_status?> statusText" id="status_text"><?=$status_text?></span>
							<?php if ($resource_url):?>
							<span class="label label-default previewLink" id="preview_link" data-preview_base="<?=$preview_base?>">
								<?php if ($status):?>
								<a target="preview_<?=$id?>" href="<?=$preview_link?>"><?=TXT_POST_LNK_PREVIEWLINK?></a>
								<?php else:?>
								-
								<?php endif?>
							</span>
							<?php endif?>
						</div>
						
						<!-- publish_datetime -->
						<div class="form-group <?=($use_publish_end_at || $publish_end_at)?'':'post_item_container'?>">
							<label class="control-label" for="publish_datetime"><i class="fa fa-calendar"></i> <?=TXT_POST_LBL_PUBLISHDATETIME?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<input class="form-control" type="text" id="publish_datetime" name="publish_datetime" autocomplete="off" value="<?=$publish_datetime?>" placeholder="<?=TXT_POST_PLH_PUBLISHDATE?>" <?=($child_flg)?'disabled':''?>>
						</div>

						<!-- publish_end_at -->
						<?php if ($use_publish_end_at || $publish_end_at):?>
						<div class="form-group post_item_container">
							<label class="control-label" for="publish_end_at"><i class="fa fa-calendar"></i> <?=TXT_POST_LBL_PUBLISHENDAT?></label>
							<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
							<input class="form-control" type="text" id="publish_end_at" name="publish_end_at" autocomplete="off" value="<?=$publish_end_at?>" placeholder="<?=TXT_POST_LBL_PUBLISHENDAT?>" <?=($child_flg)?'disabled':''?>>
						</div>
						<?php endif?>
						
						<!-- status -->
						<div class="form-group">
							<label class="control-label" for="status"><i class="fa fa-check-square-o"></i> <?=TXT_POST_LBL_STATUS?></label>
							<div>
								<?php foreach ($post_status as $key => $value):?>
									<label class="radio-inline" for="status_<?=$key?>"><input <?=(($key==1&&!$publish_flg&&$status!=1)||($current_flg==0))?'disabled':''?> type="radio" id="status_<?=$key?>" name="status" value="<?=$key?>" <?=($key==$status||$process==11&&$key==2)?'checked':''?>> <?=$value?></label>
									<small class="<?=(($key==1&&!$publish_flg&&$status!=1)||($current_flg==0))?'inactive':''?>">
										<?php if (($key == 1&&!$publish_flg&&$status!= 1)||($current_flg==0)):?>
											(<?=TXT_POST_LBL_CHANGESTATUS_SAVE($value)?>)
										<?php else:?>
											<a class="changeStatusClose notLink" data-status="<?=$key?>">(<?=TXT_POST_LBL_CHANGESTATUS_SAVE($value)?>)</a>
										<?php endif?>
									</small>
									<br>
								<?php endforeach?>
							</div>
						</div>
						
						<!-- hidden -->
						<?php if ($process == 11):?>
							<input type="hidden" name="site_id" value="<?=$_SESSION[$session_key]['common']['this_site']?>">
							<input type="hidden" name="posttype_id" value="<?=$_SESSION[$session_key]['common']['this_posttype']?>">
						<?php endif?>
						<?php if ($child_flg):?>
							<input type="hidden" id="publish_datetime" name="publish_datetime" value="<?=$publish_datetime?>">
							<input type="hidden" id="publish_end_at" name="publish_end_at" value="<?=$publish_end_at?>">
							<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
								<input type="hidden" data-group="title" data-num="<?=$language_id?>" id="title_<?=$language_id?>" name="title[<?=$language_id?>]" value="<?=$text[$language_id]['title']?>">
							<?php endforeach?>
						<?php endif?>
						<input type="hidden" name="target_id" id="target_id" value="<?=$id?>">
            <input type="hidden" name="former_status" id="former_status" value="<?=$status?>">
						<input type="hidden" name="version" id="version" value="<?=$version?>">
						<input type="hidden" name="versioned_at" id="versioned_at" value="<?=$versioned_at?>">
						<input type="hidden" name="current_flg" id="current_flg" value="<?=$current_flg?>">
						<input type="hidden" name="parent_id" id="parent_id" value="<?=$parent_id?>">
						<input type="hidden" name="process" id="process" value="<?=$process?>">
						<input type="hidden" name="this_posttype" id="this_posttype" value="<?=$this_posttype?>">
						<input type="hidden" name="this_posttype_order" id="this_posttype_order" value="<?=$this_posttype_order?>">
						<input type="hidden" name="use_multipage_flg" id="use_multipage_flg" value="<?=$config_posttype['use_multipage_flg']?>">
						<input type="hidden" name="publish_flg" id="publish_flg" value="<?=$publish_flg?>">
						<input type="hidden" name="permalink_key" id="permalink_key" value="<?=$permalink_key?>">
						<input type="hidden" name="permalink_uri" id="permalink_uri" value="<?=$permalink_uri?>">
						
						<!-- delete_check (post) -->
						<?php if ($process == 12 && ($current_flg == 1 || $status == 2)):?>
							<div class="form-group">
								<div><label class="control-label post-allowDeleteLable" id="post_allow_delete_label" for="post_allow_delete"><input type="checkbox" id="post_allow_delete" name="post_allow_delete"> <?=$allow_delete_msg?></label></div>
							</div>
						<?php endif?>
						
						<!-- buttons -->
						<div class="form-group post_operator_container post_item_container">
              <?php if ($publish_flg):?>
              <?php if ($status == 1 && $current_flg == 1):?>
              <input type="hidden" name="submit_type" value="<?=$submit_value?>">
                <?php if ($newer_version == 0):?>
                <?php if ($use_version_flg == 1):?>
                <span class="btn btn-warning wide" id="version_post" name="version_post" onclick="createNewVersionPost(<?=$id?>,<?=$current_version?>)"><?=TXT_POST_BTN_NEW_VERSION?></span>
                <?php else:?>
                <span class="btn btn-warning wide" id="version_post" data-toggle="tooltip" data-placement="top" title="<?=TXT_POST_MSG_VERSION_OFF?>" disabled><?=TXT_POST_BTN_NEW_VERSION?></span>
                <?php endif?>
                <?php endif?>
              <button class="btn btn-success wide hidden" type="button" id="publish_post"><?=$submit_label?></button>
              <button class="btn btn-danger wide hidden" type="submit" id="delete_post" name="submit_type" onclick="return deletePost('<?=$delete_msg?>');"><?=TXT_POST_BTN_DELETE?></button>
              <?php elseif ($status == 1 && $current_flg == 0):?>
              <input type="hidden" name="submit_type" value="<?=$submit_value?>">
              <button class="btn btn-success wide hidden" type="button" id="publish_post"><?=$submit_label?></button>
              <?php elseif ($status == 2 || $process == 11):?>
              <input type="hidden" name="submit_type" value="<?=$submit_value?>">
              <span class="btn btn-default" id="save_post" name="save_post"><?=TXT_POST_BTN_SAVE?></span>
              <button class="btn btn-primary <?=(empty($hash_id))?'hidden':null?>" type="button" id="publish_post"><?=$submit_label?></button>
              <button class="btn btn-danger wide hidden" type="submit" id="delete_post" name="submit_type" onclick="return deletePost('<?=$delete_msg?>');"><?=TXT_POST_BTN_DELETE?></button>
              <?php endif?>
              <?php endif?>
						</div>
						
						<!-- version (operation) -->
						<?php if (! empty($use_version_flg) && ! $child_flg && $process > 11):?>
							<div class="form-group post_operator_container post_item_container">
								<label class="control-label" for="status"><i class="fa fa-history" aria-hidden="true"></i> <?=TXT_POST_LBL_VERSION?></label>
								<ul class="version-list">
									<?php foreach ($versions_all as $row):?>
										<li>
											<?php if ($row['version'] == $version):?>
                        <span class="version-edit"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="version-changeLink"><?=$row['label']?></span>
											<?php else:?>
                        <a class="version-changeLink" href="./?id=<?=$id?>&amp;version=<?=$row['version']?>&process=<?=$process?>"><?=$row['label']?></a>
											<?php endif?>
                      <?php if ($row['status'] == 2):?>
                        <span data-toggle="tooltip" data-placement="top" title="<?=TXT_POST_LBL_VERSION_DRAFT?>" class="version-status"><i class="fa fa-pencil" aria-hidden="true"></i></span>
											<?php elseif ($row['current_flg'] == 1):?>
                        <span data-toggle="tooltip" data-placement="top" title="<?=TXT_POST_LBL_VERSION_CURRENT?>" class="version-status"><i class="fa fa-eye" aria-hidden="true"></i></span>
											<?php else:?>
                        <span data-toggle="tooltip" data-placement="top" title="<?=TXT_POST_LBL_VERSION_ARCHIVED?>" class="version-status archive"><i class="fa fa-archive" aria-hidden="true"></i></span>
												<a data-toggle="tooltip" data-placement="top" title="<?=TXT_POST_LBL_CHANGECURRENT?>" onclick="changeCurrentPost(<?=$id?>,<?=$row['version']?>)"><i class="fa fa-history" aria-hidden="true"></i></a>
												<span class="version-delete"><a data-toggle="tooltip" data-placement="top" title="<?=TXT_POST_LBL_DELETEVERSION?>" onclick="deleteVersionPost(<?=$id?>,<?=$row['version']?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
											<?php endif?>
										</li>
									<?php endforeach?>
								</ul>
								<!-- delete_check (version) -->
								<?php if ($process == 12 && count($versions_all) > 1):?>
									<label class="control-label version-allowDeleteLabel" for="version_allow_delete"><input type="checkbox" id="version_allow_delete" name="version_allow_delete"> <?=TXT_POST_LBL_ALLOWDELETEVERSION?></label>
								<?php endif?>
								<input type="hidden" id="current_version" value="<?=$current_version?>">
							</div>
						<?php endif?>
						
						<!-- anchor -->
						<div class="form-group post_item_container <?=($child_flg)?'hidden':''?>">
							<label class="control-label" for="anchor"><i class="fa fa-anchor"></i> <?=TXT_POST_LBL_ANCHOR?></label>
							<div id="anchor_wrap">
								<button type="button" id="anchor_minus" class="btn btn-default">-</button>
								<input class="form-control" type="text" id="anchor" name="anchor" value="<?=$anchor?>" readonly>
								<button type="button" id="anchor_plus" class="btn btn-success">+</button>
							</div>
						</div>
						
						<!-- site -->
						<?php if ($_SESSION[$session_key]['configs']['use_multisite_flg']):?>
							<div class="form-group hidden">
								<label class="control-label" for="site_id"><i class="fa fa-share-square-o"></i> <?=TXT_POST_LBL_SITE?></label>
								<select class="form-control" id="site_id" name="site_id" <?=($process==11)?'disabled':''?>>
									<?php foreach ($_SESSION[$session_key]['common']['sites'] as $key => $value):?>
										<option value="<?=$key?>" <?=($_SESSION[$session_key]['common']['this_site']==$key)?'selected="selected"':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
						<?php else:?>
							<input type="hidden" id="site_id" name="site_id" value="1">
						<?php endif?>
						
						<!-- posttype -->
						<?php if ($_SESSION[$session_key]['configs']['use_posttype_flg']):?>
							<div class="form-group post_item_container hidden">
								<label class="control-label" for="posttype_id"><i class="fa fa-share-square-o"></i> <?=TXT_POST_LBL_POSTTYPE?></label>
								<select class="form-control" id="posttype_id" name="posttype_id" <?=($process==11)?'disabled':''?>>
									<?php foreach ($_SESSION[$session_key]['common']['posttypes'] as $key => $values):?>
										<option value="<?=$key?>" <?=($_SESSION[$session_key]['common']['this_posttype']==$key)?'selected="selected"':''?>><?=$values['name']?></option>
									<?php endforeach?>
								</select>
							</div>
						<?php else:?>
							<input type="hidden" id="posttype_id" name="posttype_id" value="1">
						<?php endif?>
						
						<!-- eyecatch -->
						<div class="form-group post_item_container">
							<label class="control-label" for="eyecatch"><i class="fa fa-picture-o"></i> <?=TXT_POST_LBL_EYECATCH?></label>
							<div id="eyecatch_wrap">
								<input type="hidden" id="eyecatch_target" name="eyecatch_target" value="<?=$eyecatch_target?>">
								<input type="hidden" id="eyecatch" name="eyecatch" value="<?=$eyecatch?>">
							</div>
							<a href="filemanager/dialog.php?type=2&field_id=eyecatch" type="button" id="set_eyecatch" class="btn btn-default openFilemanager notLink"><?=TXT_POST_BTN_IMG_SET?></a>
							<button type="button" id="remove_eyecatch" class="btn btn-warning hidden"><?=TXT_POST_BTN_IMG_DELETE?></button>
						</div>
						
						<!-- categories -->
						<?php if (! empty($formated_categories) || $_SESSION[$session_key]['user']['role'] <= 7):?>
						<?php if ($use_category_flg):?>
							<div class="form-group post_item_container formHasLang <?=($child_flg)?'hidden':''?>">
								<label class="control-label"><i class="fa fa-th-large"></i> <?=TXT_POST_LBL_CATEGORY?></label><br>
								<?php if (! empty($formated_categories)):?>
									<?php foreach ($formated_categories as $key => $parent):?>
										<label class="checkbox-inline" for="categories<?=$key?>">
											<input type="checkbox" id="categories<?=$key?>" name="categories[]" value="<?=$key?>" data-slug="<?=$parent['slug']?>" <?=(in_array(intval($key), $categories_id))?'checked="checked"':''?>>
											<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
												<span class="formPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(!empty($parent['label'][$language_id]))?$parent['label'][$language_id]:'<i>('.TXT_POST_LBL_NOLABEL.')</i>'?></span>
											<?php endforeach?>
										</label><br>
										<?php if (! empty($parent['children'])):?>
											<div class="catChild formHasLang">
												<?php foreach ($parent['children'] as $key => $child):?>
													<label class="checkbox-inline" for="categories<?=$key?>">
														<input type="checkbox" id="categories<?=$key?>" name="categories[]" value="<?=$key?>" data-slug="<?=$child['slug']?>" <?=(in_array(intval($key), $categories_id))?'checked="checked"':''?>>
														<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
															<span class="formPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(!empty($child['label'][$language_id]))?$child['label'][$language_id]:'<i>('.TXT_POST_LBL_NOLABEL.')</i>'?></span>
														<?php endforeach?>
													</label>
												<?php endforeach?>
											</div>
										<?php endif?>
									<?php endforeach?>
								<?php else:?>
									<?=TXT_POST_MSG_NOCATEGORY?>
								<?php endif?>
							</div>
						<?php endif?>
						<?php endif?>
						
						<!-- tags -->
						<?php if (! empty($_SESSION[$session_key]['common']['tags']) || $_SESSION[$session_key]['user']['role'] <= 7):?>
						<?php if ($use_tag_flg):?>
							<div class="form-group post_item_container formHasLang <?=($child_flg)?'hidden':''?>">
								<label class="control-label"><i class="fa fa-tag"></i> <?=TXT_POST_LBL_TAG?></label><br>
								<?php if (! empty($_SESSION[$session_key]['common']['tags'])):?>
									<?php foreach ($_SESSION[$session_key]['common']['tags'] as $key => $row):?>
										<label class="checkbox-inline" for="tags<?=$key?>">
											<input type="checkbox" id="tags<?=$key?>" name="tags[]" value="<?=$key?>" <?=(in_array(intval($key), $tags_id))?'checked="checked"':''?>>
											<?php foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $row_lang):?>
												<span class="formPartsLang_<?=$language_id?> <?=($language_id!=1)?'hidden':''?>"><?=(!empty($row['label'][$language_id]))?$row['label'][$language_id]:'<i>('.TXT_POST_LBL_NOLABEL.')</i>'?></span>
											<?php endforeach?>
										</label>
									<?php endforeach?>
								<?php else:?>
									<?=TXT_POST_MSG_NOTAG?>
								<?php endif?>
							</div>
						<?php endif?>
						<?php endif?>
						
						<!-- edit-info -->
						<?php if ($created_atby):?>
							<div class="form-group <?=(!$updated_atby)?'post_item_container':''?>">
								<label class="control-label" for="created_atby"><i class="fa fa-check-circle-o"></i> <?=TXT_POST_LBL_CREATEATBY?></label>
								<div id="updated_atby"><?=nl2br($created_atby)?></div>
							</div>
						<?php endif?>
						<?php if ($updated_atby):?>
							<div class="form-group post_item_container">
								<label class="control-label" for="updated_atby"><i class="fa fa-check-circle-o"></i> <?=TXT_POST_LBL_UPDATEATBY?></label>
								<div id="updated_atby"><?=nl2br($updated_atby)?></div>
							</div>
						<?php endif?>
						
						<!-- review-info -->
						<?php if ($process == 12 && $comment_type):?>
							<div class="form-group post_item_container">
								<?php foreach($comments as $key_comment => $row_comment):?>
									<?php if ($key_comment == 1):?>
										<div class="multistep10">
											<i class="fa fa-comment"></i> <?=$row_comment['name']?> <a class="goComments" href="./?view_page=comments&amp;sc_post_id=<?=$id?>&amp;type=1"> <?=$row_comment['count']['ancester']?><?=($row_comment['count']['descendants'])?'(+'.($row_comment['count']['descendants']).')':null?><?=TXT_GLOBAL_UNT_COUNT?> &raquo; <?=TXT_POST_LBL_NEWCOMMENT?></a>&nbsp;
										</div>
									<?php elseif ($key_comment == 2):?>
										<div class="multistep10">
											<i class="fa fa-star-half-o"></i> <?=$row_comment['name']?> <a class="goComments" href="./?view_page=comments&amp;sc_post_id=<?=$id?>&amp;type=2"> <?=$row_comment['count']?><?=TXT_GLOBAL_UNT_COUNT?>(<?=round((float)$row_comment['score_average'], 1)?><?=TXT_GLOBAL_UNT_SCORE?>) &raquo; <?=TXT_POST_LBL_NEWCOMMENT?></a>&nbsp;
										</div>
									<?php elseif ($key_comment == 3):?>
										<div class="multistep10">
											<i class="fa fa-paperclip"></i> <?=$row_comment['name']?> <a class="goComments" href="./?view_page=comments&amp;sc_post_id=<?=$id?>&amp;type=3"> <?=$row_comment['count']['ancester']?><?=($row_comment['count']['descendants'])?'(+'.($row_comment['count']['descendants']).')':null?><?=TXT_GLOBAL_UNT_COUNT?> &raquo; <?=TXT_POST_LBL_NEWCOMMENT?></a>&nbsp;
										</div>
									<?php endif?>
								<?php endforeach?>
							</div>
						<?php endif?>
					
					</div>
					<!-- //Right -->
				</form>
			<?php else:?>
				<p class="alert alert-danger"><?=TXT_POST_WAR_NOLANGUAGE?></p>
			<?php endif?>
		</div>
		
		<?php if ($_SESSION[$session_key]['user']['role'] <= 2 && $id):?>
    <?php if ($_SESSION[$session_key]['configs']['display_implement_code']):?>
    <?php require_once 'inc/_implement_code_post.php'?>
    <?php endif?>
		<?php endif?>
  
	</div>
</main>
<script src="tinymce/tinymce.min.js"></script>
<link rel="stylesheet" href="plugin/datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
<script src="plugin/datetimepicker/bootstrap-datetimepicker-custom.min.js"></script>
<?php if ($_SESSION[$session_key]['user']['lang'] != 'en'):?>
	<script src="plugin/datetimepicker/locales/bootstrap-datetimepicker.<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<?php endif?>
<?php if ($use_wisiwyg_flg):?>
	<script src="<?=$tinymce_init?>?v=<?=filemtime($tinymce_init)?>"></script>
<?php endif?>
<?php if ($permalink_type == 2 && $permalink_style >= 5):?>
<script src="js/check_post_slug.js"></script>
<?php endif?>
