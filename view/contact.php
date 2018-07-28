
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3> <?=$back_link?></div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="contact_wrap">
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- FORM -->
			<form id="contact" role="form" action="./_execute.php" method="post">
				
				<!-- Left// -->
				<idv class="col-md-9">
					
					<?php if ($process == 31 && $_SESSION[$session_key]['configs']['use_multilingual_flg']):?>
						<div id="set_language">
							<span class="heading"><?=TXT_CONTACT_LBL_LANGUAGE?></span>
							<?php foreach ($_SESSION[$session_key]['common']['languages'] as $key => $row):?>
								<?php if ($key == $language_id):?>
									<span class="selected"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$row['name']?></span>
								<?php else:?>
									<a href="./?language_id=<?=$key?>&amp;<?=$qs_change_language?>"><?=$row['name']?></a>
								<?php endif?>
							<?php endforeach?>
						</div>
					<?php endif?>
					
					<!-- title -->
					<div class="form-group">
						<label class="control-label" for="title"><?=TXT_CONTACT_LBL_TITLE?></label>
						<div><input class="form-control" type="text" id="title" name="title" value="<?=$title?>" disabled></div>
					</div>
					
					<!-- content -->
					<div class="form-group post_item_container">
						<label class="control-label" for="content"><?=TXT_CONTACT_LBL_CONTENT?></label>
						<textarea class="form-control" id="content" name="content" disabled><?=$content?></textarea>
					</div>
					
					<!-- name -->
					<div class="form-group">
						<label class="control-label" for="name"><?=TXT_CONTACT_LBL_NAME?></label>
						<div><input class="form-control" type="text" id="name" name="name" value="<?=$name?>" disabled></div>
					</div>
					
					<!-- email -->
					<div class="form-group">
						<label class="control-label" for="email"><?=TXT_CONTACT_LBL_EMAIL?></label>
						<div><input class="form-control" type="text" id="email" name="email" value="<?=$email?>" disabled></div>
					</div>
					
					<!-- tel -->
					<div class="form-group">
						<label class="control-label" for="tel"><?=TXT_CONTACT_LBL_TEL?></label>
						<div><input class="form-control" type="text" id="tel" name="tel" value="<?=$tel?>" disabled></div>
					</div>
					
					<!-- custom items -->
					<?php if ($contact_config['use_customitem_flg']):?>
						<?php if (count($custom_items)):?>
							<?php foreach ($custom_items as $custom_item_id => $row_cust):?>
								<?php if ($row_cust['type'] == 'text'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?></label>
										<div><input class="form-control" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" type="text" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" value="<?=$items[$custom_item_id]?>" disabled></div>
									</div>
								<?php elseif ($row_cust['type'] == 'date'):?>
                  <div class="form-group post_item_container">
                    <label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-calendar"></i> <?=$row_cust['name']?></label>
                    <div><input class="form-control customDate" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" type="text" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" value="<?=$items[$custom_item_id]?>" disabled></div>
                  </div>
								<?php elseif ($row_cust['type'] == 'textarea-s'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?></label>
										<div><textarea class="small form-control" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" disabled><?=$items[$custom_item_id]?></textarea></div>
									</div>
								<?php elseif ($row_cust['type'] == 'textarea-m'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?></label>
										<div><textarea class="medium form-control" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" disabled><?=$items[$custom_item_id]?></textarea></div>
									</div>
								<?php elseif ($row_cust['type'] == 'textarea-l'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-pencil-square-o"></i> <?=$row_cust['name']?></label>
										<div><textarea class="large form-control" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" disabled><?=$items[$custom_item_id]?></textarea></div>
									</div>
								<?php elseif ($row_cust['type'] == 'select'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-share-square-o"></i> <?=$row_cust['name']?></label>
										<div>
											<select class="form-control" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" disabled>
												<?php foreach ($row_cust['choices'] as $key_choi =>$choice):?>
													<option id="items_<?=$custom_item_id?>_<?=$key_choi?>" value="<?=$choice?>" <?=($choice==$items[$custom_item_id])?'selected':''?>><?=$choice?></option>
												<?php endforeach?>
											</select>
										</div>
									</div>
								<?php elseif ($row_cust['type'] == 'checkbox'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-check-square-o"></i> <?=$row_cust['name']?></label>
										<div>
											<?php foreach ($row_cust['choices'] as $key_choi =>$choice):?>
												<label class="checkbox-inline" for="items_<?=$custom_item_id?>_<?=$key_choi?>"><input data-group="custom" data-custom_item_id="<?=$custom_item_id?>" type="checkbox" id="items_<?=$custom_item_id?>_<?=$key_choi?>" name="items[<?=$custom_item_id?>][]" value="<?=$choice?>" <?=(is_array($items[$custom_item_id]) && in_array($choice, $items[$custom_item_id]))?'checked':''?> disabled> <?=$choice?></label>
											<?php endforeach?>
										</div>
									</div>
								<?php elseif ($row_cust['type'] == 'radio'):?>
									<div class="form-group post_item_container">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-check-square-o"></i> <?=$row_cust['name']?></label>
										<div>
											<?php foreach ($row_cust['choices'] as $key_choi =>$choice):?>
												<label class="radio-inline" for="items_<?=$custom_item_id?>_<?=$key_choi?>"><input data-group="custom" data-custom_item_id="<?=$custom_item_id?>" type="radio" id="items_<?=$custom_item_id?>_<?=$key_choi?>" name="items[<?=$custom_item_id?>]" value="<?=$choice?>" <?=($choice==$items[$custom_item_id])?'checked':''?> disabled> <?=$choice?></label>
											<?php endforeach?>
										</div>
									</div>
								<?php elseif ($row_cust['type'] == 'image'):?>
									<div class="form-group post_item_container custome_image_container" id="custome_image_container_<?=$custom_item_id?>">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-picture-o"></i> <?=$row_cust['name']?></label>
										<div id="<?=$custom_item_id?>_wrap" class="custom_image_wrap">
											<input type="hidden" class="custom_image_target" id="items_<?=$custom_item_id?>_target" name="items_<?=$custom_item_id?>_target" value="<?=$row_cust['choices']?>">
											<input type="hidden" class="custom_image" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" value="<?=$items[$custom_item_id]?>">
										</div>
										<a href="filemanager/dialog.php?type=2&field_id=items_<?=$custom_item_id?>" type="button" id="set_<?=$custom_item_id?>" class="btn btn-default openFilemanager set_custom_image"><?=TXT_CONTACT_BTN_IMG_SET?></a>
										<button type="button" id="remove_<?=$custom_item_id?>" class="btn btn-warning hidden remove_custom_image"><?=TXT_CONTACT_BTN_IMG_DELETE?></button>
									</div>
								<?php elseif ($row_cust['type'] == 'gallery'):?>
									<div class="form-group post_item_container custome_gallery_container" id="custome_gallery_container_<?=$custom_item_id?>">
										<label class="control-label" for="items_<?=$custom_item_id?>"><i class="fa fa-th"></i> <?=$row_cust['name']?></label>
										<div class="row custom_gallery_display">
											<ul class="sortable">
												<?php if (count($items[$custom_item_id])):?>
													<?php foreach ($items[$custom_item_id] as $value):?>
														<li class="col-xs-6 col-md-3 dropme"><img class="thumbnail" src="<?=$value?>" alt=""></li>
													<?php endforeach?>
												<?php endif?>
											</ul>
										</div>
										<div class="custom_gallery_trash" id="trash"><i class="fa fa-trash-o"></i></div>
										<div id="<?=$custom_item_id?>_wrap" class="custom_gallery_wrap">
											<input type="hidden" class="custom_gallery_addition" id="addition_<?=$custom_item_id?>" value="">
											<input type="hidden" class="custom_gallery_target" id="items_<?=$custom_item_id?>_target" name="items_<?=$custom_item_id?>_target" value="<?=$row_cust['choices']?>">
											<input type="hidden" class="custom_gallery" data-group="custom" data-custom_item_id="<?=$custom_item_id?>" id="items_<?=$custom_item_id?>" name="items[<?=$custom_item_id?>]" value="">
										</div>
										<a href="filemanager/dialog.php?type=2&field_id=addition_<?=$custom_item_id?>" type="button" id="set_<?=$custom_item_id?>" class="btn btn-default openFilemanager set_custom_gallery"><?=TXT_CONTACT_BTN_IMG_SET?></a>
										<button type="button" id="remove_<?=$custom_item_id?>" class="btn btn-warning hidden remove_custom_gallery"><?=TXT_CONTACT_BTN_IMG_DELETE?></button>
									</div>
								<?php endif?>
							<?php endforeach?>
						<?php endif?>
					<?php endif?>
					
					<!-- note -->
					<div class="form-group post_item_container">
						<label class="control-label" for="note"><i class="fa fa-pencil-square-o"></i> <?=TXT_CONTACT_LBL_NOTE?></label>
						<textarea class="form-control" id="note" name="note"><?=$note?></textarea>
					</div>
				
				</idv>
				<!-- //Left -->
				
				<!-- Right// -->
				<idv class="col-md-3">
					
					<!-- contacted_at -->
					<div class="form-group">
						<label class="control-label" for="contacted_at"><?=TXT_CONTACT_LBL_CONTACTEDAT?></label>
						<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
						<input class="form-control" type="text" id="contacted_at" name="contacted_at" value="<?=$contacted_at?>" disabled>
					</div>
					
					<!-- status -->
					<div class="form-group post_item_container">
						<label class="control-label" for="status"><i class="fa fa-check-square-o"></i> <?=TXT_CONTACT_LBL_STATUS?></label>
						<div>
							<?php foreach ($contact_status as $key => $value):?>
								<label class="radio-inline" for="status_<?=$key?>"><input type="radio" id="status_<?=$key?>" name="status" value="<?=$key?>" <?=($key==$status)?'checked':''?>> <?=$value?></label>
								<small><a class="changeStatusClose" data-status="<?=$key?>">(<?=TXT_CONTACT_LBL_CHANGESTATUS_SAVE($value)?>)</a></small>
								<br>
							<?php endforeach?>
						</div>
					</div>
					
					<!-- hidden -->
					<?php if ($process == 31):?>
						<input type="hidden" name="site_id" value="<?=$_SESSION[$session_key]['common']['this_site']?>">
						<input type="hidden" name="posttype_id" value="<?=$_SESSION[$session_key]['common']['this_posttype']?>">
						<input type="hidden" name="language_id" value="<?=$language_id?>">
					<?php endif?>
					
					<!-- delete_check -->
					<?php if ($_SESSION[$session_key]['user']['role'] != 8 && $process != 31):?>
						<div class="form-group">
							<div><label class="control-label" for="edit_check"><input type="checkbox" id="edit_check" name="edit_check"> <?=TXT_CONTACT_LBL_EDITCHECK?></label></div>
							<div><label class="control-label" for="delete_check"><input type="checkbox" id="delete_check" name="delete_check"> <?=TXT_CONTACT_LBL_DELETECHECK?></label></div>
						</div>
					<?php endif?>
					
					<!-- buttons -->
					<input type="hidden" name="target_id" id="target_id" value="<?=$id?>">
					<input type="hidden" name="process" id="process" value="<?=$process?>">
					<input type="hidden" name="created_by" id="created_by" value="<?=$created_by?>">
					
					<div id="button_contact" class="form-group post_operator_container">
						<?php if ($process == 31):?>
							<input class="btn btn-primary" type="submit" id="submit_contact" name="submit_contact" value="<?=TXT_CONTACT_BTN_CREATE?>">
						<?php else:?>
							<input class="btn btn-primary" type="submit" id="submit_contact" name="submit_contact" value="<?=TXT_CONTACT_BTN_UPDATE?>">
							<input class="btn btn-danger" type="submit" id="delete_contact" name="delete_contact" value="<?=TXT_CONTACT_BTN_DELETE?>">
							<?php if ($status == 8):?>
								<input class="btn btn-primary" type="submit" id="to_status_1" name="to_status_1" value="<?=TXT_CONTACT_BTN_TO_COMPLETED?>">
								<input class="btn btn-success" type="submit" id="to_status_7" name="to_status_7" value="<?=TXT_CONTACT_BTN_TO_ONGOING?>">
							<?php endif?>
							<?php if ($status == 7):?>
								<input class="btn btn-primary" type="submit" id="to_status_1" name="to_status_1" value="<?=TXT_CONTACT_BTN_TO_COMPLETED?>">
							<?php endif?>
						<?php endif?>
					</div>
					
					<!-- language_id -->
					<?php if ($process == 32 && $_SESSION[$session_key]['configs']['use_multilingual_flg']):?>
						<div class="form-group">
							<label class="control-label" for="language_id"><?=TXT_CONTACT_LBL_LANGUAGEID?></label>
							<select class="form-control" id="language_id" name="language_id" disabled>
								<?php foreach ($_SESSION[$session_key]['common']['languages'] as $key => $row):?>
									<option value="<?=$key?>" <?=($language_id==$key)?'selected="selected"':''?>><?=$row['name']?></option>
									<?php if (! array_key_exists($language_id, $_SESSION[$session_key]['common']['languages']) && array_key_exists($language_id, $languages_all)):?>
										<option value="<?=$languages_all[$language_id]['id']?>" selected="selected"><?=$languages_all[$language_id]['name']?></option>
									<?php endif?>
								<?php endforeach?>
							</select>
						</div>
					<?php endif?>
					
					<!-- categories -->
					<?php if (! empty($formated_categories) || $_SESSION[$session_key]['user']['role'] <= 7):?>
						<div class="form-group post_item_container">
							<label class="control-label"><i class="fa fa-th-large"></i> <?=TXT_POST_LBL_CATEGORY?></label><br>
							<?php if (! empty($formated_categories)):?>
								<?php foreach ($formated_categories as $key => $parent):?>
									<label class="checkbox-inline" for="categories<?=$key?>">
										<input type="checkbox" id="categories<?=$key?>" name="categories[]" value="<?=$key?>" <?=(in_array(intval($key), $categories_id))?'checked="checked"':''?> disabled>
										<span><?=(!empty($parent['label'][$language_id]))?$parent['label'][$language_id]:'<i>('.TXT_POST_LBL_NOLABEL.')</i>'?></span>
									</label><br>
									<?php if (! empty($parent['children'])):?>
										<div class="catChild formHasLang">
											<?php foreach ($parent['children'] as $key => $child):?>
												<label class="checkbox-inline" for="categories<?=$key?>">
													<input type="checkbox" id="categories<?=$key?>" name="categories[]" value="<?=$key?>" <?=(in_array(intval($key), $categories_id))?'checked="checked"':''?> disabled>
													<span><?=(!empty($child['label'][$language_id]))?$child['label'][$language_id]:'<i>('.TXT_POST_LBL_NOLABEL.')</i>'?></span>
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
					
					<!-- edit-info -->
					<?php if ($created_atby):?>
						<div class="form-group <?=(!$updated_atby)?'post_item_container':''?>">
							<label class="control-label" for="created_atby"><i class="fa fa-check-circle-o"></i> <?=TXT_CONTACT_LBL_CREATEDATBY?></label>
							<div id="updated_atby"><?=$created_atby?></div>
						</div>
					<?php endif?>
					<?php if ($updated_atby):?>
						<div class="form-group post_item_container">
							<label class="control-label" for="updated_atby"><i class="fa fa-check-circle-o"></i> <?=TXT_CONTACT_LBL_UPDATEDATBY?></label>
							<div id="updated_atby"><?=$updated_atby?></div>
						</div>
					<?php endif?>
				
				</idv>
				<!-- //Right -->
			
			</form>
		</div>
	</div>
</main>
<link rel="stylesheet" href="plugin/datetimepicker/bootstrap-datetimepicker.min.css" media="screen">
<script src="plugin/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<?php if ($_SESSION[$session_key]['user']['lang'] != 'en'):?>
<script src="plugin/datetimepicker/locales/bootstrap-datetimepicker.<?=$_SESSION[$session_key]['user']['lang']?>.js"></script>
<?php endif ?>