
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?></h3></div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="config_wrap">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show config">
			
			<!-- Config Posttype -->
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGPOSTTYPE_LBL_TITLEBASE?></h3></div>
				<div id="panel_posttype_base" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- menu_icon -->
						<div class="form-group">
							<label class="control-label col-md-4" for="menu_icon"><?=TXT_CONFIGPOSTTYPE_LBL_MENUICON?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_MENUICON?>" data-content="<?=$popover['menu_icon']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<?php foreach ($icon_list as $subtitle => $row):?>
									<h4 class="iconSubtitle"><?=$subtitle?></h4>
									<?php foreach ($row as $key => $value):?>
										<label class="radio-inline" for="menu_icon_<?=$key?>"><input type="radio" id="menu_icon_<?=$key?>" name="menu_icon" value="<?=$key?>" <?=($key==$records['menu_icon']['value'])?'checked':''?>> <?=$value?> <?=$key?></label>
									<?php endforeach?>
								<?php endforeach?>
							</div>
							<div class="col-md-1"></div>
						</div>
						<!-- auto_save_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="auto_save_flg"><?=TXT_CONFIGPOSTTYPE_LBL_POSTAUTOSAVEFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_POSTAUTOSAVEFLG?>" data-content="<?=$popover['auto_save_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_valid as $key => $value):?>
									<label class="radio-inline" for="auto_save_flg_<?=$key?>"><input type="radio" id="auto_save_flg_<?=$key?>" name="auto_save_flg" value="<?=$key?>" <?=($key==$records['auto_save_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_wisiwyg_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_wisiwyg_flg"><?=TXT_CONFIGPOSTTYPE_LBL_USEWISIWYGFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_USEWISIWYGFLG?>" data-content="<?=$popover['use_wisiwyg_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_wisiwyg_flg_<?=$key?>"><input type="radio" id="use_wisiwyg_flg_<?=$key?>" name="use_wisiwyg_flg" value="<?=$key?>" <?=($key==$records['use_wisiwyg_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_addition_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_addition_flg"><?=TXT_CONFIGPOSTTYPE_LBL_USEADDITIONFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_USEADDITIONFLG?>" data-content="<?=$popover['use_addition_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_addition_flg_<?=$key?>"><input type="radio" id="use_addition_flg_<?=$key?>" name="use_addition_flg" value="<?=$key?>" <?=($key==$records['use_addition_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_content_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_content_flg"><?=TXT_CONFIGPOSTTYPE_LBL_USECONTENTFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_USECONTENTFLG?>" data-content="<?=$popover['use_content_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_content_flg_<?=$key?>"><input type="radio" id="use_content_flg_<?=$key?>" name="use_content_flg" value="<?=$key?>" <?=($key==$records['use_content_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_slug_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_slug_flg"><?=TXT_CONFIGPOSTTYPE_LBL_USESLUGFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_USESLUGFLG?>" data-content="<?=$popover['use_slug_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_slug_flg_<?=$key?>"><input type="radio" id="use_slug_flg_<?=$key?>" name="use_slug_flg" value="<?=$key?>" <?=($key==$records['use_slug_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- preview_url -->
						<div class="form-group">
							<label class="control-label col-md-4" for="preview_url"><?=TXT_CONFIGPOSTTYPE_LBL_PREVIEWURL?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_PREVIEWURL?>" data-content="<?=$popover['preview_url']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="preview_url" name="preview_url" value="<?=$records['preview_url']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- parameter_key -->
						<div class="form-group">
							<label class="control-label col-md-4" for="parameter_key"><?=TXT_CONFIGPOSTTYPE_LBL_PARAMETERKEY?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_PARAMETERKEY?>" data-content="<?=$popover['parameter_key']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="parameter_key" name="parameter_key" value="<?=$records['parameter_key']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- permalink_style -->
						<div class="form-group">
							<label class="control-label col-md-4" for="permalink_style"><?=TXT_CONFIGPOSTTYPE_LBL_PERMALINKSTYLE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_PERMALINKSTYLE?>" data-content="<?=$popover['permalink_style']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($permalink_style_list as $key => $value):?>
									<label class="radio-inline" for="permalink_style_<?=$key?>"><input type="radio" id="permalink_style_<?=$key?>" name="permalink_style" value="<?=$key?>" <?=($key==$records['permalink_style']['value'])?'checked':''?>> <?=str_replace('xx', $records['parameter_key']['value'], $value)?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="posttype_base">
								<input class="btn btn-primary width120" type="submit" id="submit_record_01" name="submit_record" value="<?=TXT_CONFIGPOSTTYPE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGPOSTTYPE_LBL_TITLEOPTION?></h3></div>
				<div id="panel_posttype_option" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- use_customitem_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_customitem_flg"><?=TXT_CONFIGPOSTTYPE_LBL_USECUSTOMITEMFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_USECUSTOMITEMFLG?>" data-content="<?=$popover['use_customitem_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_customitem_flg_<?=$key?>"><input type="radio" id="use_customitem_flg_<?=$key?>" name="use_customitem_flg" value="<?=$key?>" <?=($key==$records['use_customitem_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- use_multipage_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_multipage_flg"><?=TXT_CONFIGPOSTTYPE_LBL_USEMULTIPAGEFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_USEMULTIPAGEFLG?>" data-content="<?=$popover['use_multipage_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_multipage_flg_<?=$key?>"><input type="radio" id="use_multipage_flg_<?=$key?>" name="use_multipage_flg" value="<?=$key?>" <?=($key==$records['use_multipage_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- comment_type -->
						<div class="form-group">
							<label class="control-label col-md-4" for="comment_type"><?=TXT_CONFIGPOSTTYPE_LBL_COMMNETTYPE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_COMMNETTYPE?>" data-content="<?=$popover['comment_type']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($posttype_comment_type as $key => $value):?>
									<label class="checkbox-inline" for="comment_type<?=$key?>"><input type="checkbox" id="comment_type<?=$key?>" name="comment_type[<?=$key?>]" value="<?=$key?>" <?=(strstr($records['comment_type']['value'], (string)$key))?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="posttype_option">
								<input class="btn btn-primary width120" type="submit" id="submit_record_01" name="submit_record" value="<?=TXT_CONFIGPOSTTYPE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGPOSTTYPE_LBL_TITLEPOSTDETAIL?></h3></div>
				<div id="panel_posttype_detail" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- label_title -->
						<div class="form-group">
							<label class="control-label col-md-4" for="label_title"><?=TXT_CONFIGPOSTTYPE_LBL_LABELTITLE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_LABELTITLE?>" data-content="<?=$popover['label_title']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="label_title" name="label_title" value="<?=$records['label_title']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- label_addition -->
						<div class="form-group">
							<label class="control-label col-md-4" for="label_addition"><?=TXT_CONFIGPOSTTYPE_LBL_LABELADDITION?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_LABELADDITION?>" data-content="<?=$popover['label_addition']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="label_addition" name="label_addition" value="<?=$records['label_addition']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- label_content -->
						<div class="form-group">
							<label class="control-label col-md-4" for="label_content"><?=TXT_CONFIGPOSTTYPE_LBL_LABELCONTENT?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_LABELCONTENT?>" data-content="<?=$popover['label_content']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="label_content" name="label_content" value="<?=$records['label_content']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- customitem_position -->
						<div class="form-group">
							<label class="control-label col-md-4" for="customitem_position"><?=TXT_CONFIGPOSTTYPE_LBL_CUSTOMITEMPOSITION?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_CUSTOMITEMPOSITION?>" data-content="<?=$popover['customitem_position']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($post_customitem_position_list as $key => $value):?>
									<label class="radio-inline" for="customitem_position_<?=$key?>"><input type="radio" id="customitem_position_<?=$key?>" name="customitem_position" value="<?=$key?>" <?=($key==$records['customitem_position']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="posttype_detail">
								<input class="btn btn-primary width120" type="submit" id="submit_record_01" name="submit_record" value="<?=TXT_CONFIGPOSTTYPE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGPOSTTYPE_LBL_TITLEPOSTLIST?></h3></div>
				<div id="panel_posttype_list" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- posts_list_num -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_list_num"><?=TXT_CONFIGPOSTTYPE_LBL_LISTNUM?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_LISTNUM?>" data-content="<?=$popover['posts_list_num']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="posts_list_num" name="posts_list_num" >
									<?php for ($i=1; $i<=100 ;$i++):?>
										<option value="<?=$i?>" <?=($records['posts_list_num']['value']==$i)?'selected':''?>><?=$i?></option>
									<?php endfor?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_sort_order -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_sort_order"><?=TXT_CONFIGPOSTTYPE_LBL_SORTORDER?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_SORTORDER?>" data-content="<?=$popover['posts_sort_order']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($posts_sort_order_list as $key => $value):?>
									<label class="radio-inline" for="posts_sort_order_<?=$key?>"><input type="radio" id="posts_sort_order_<?=$key?>" name="posts_sort_order" value="<?=$key?>" <?=($key==$records['posts_sort_order']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_column01 -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_column01"><?=TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN01?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN01?>" data-content="<?=$popover['posts_column01']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($posts_column01_list as $key => $value):?>
									<label class="radio-inline" for="posts_column01_<?=$key?>"><input type="radio" id="posts_column01_<?=$key?>" name="posts_column01" value="<?=$key?>" <?=($key==$records['posts_column01']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_column02 -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_column02"><?=TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN02?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN02?>" data-content="<?=$popover['posts_column02']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($posts_column02_list as $key => $value):?>
									<label class="radio-inline" for="posts_column02_<?=$key?>"><input type="radio" id="posts_column02_<?=$key?>" name="posts_column02" value="<?=$key?>" <?=($key==$records['posts_column02']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_column03 -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_column03"><?=TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN03?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN03?>" data-content="<?=$popover['posts_column03']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($posts_column03_list as $key => $value):?>
									<label class="radio-inline" for="posts_column03_<?=$key?>"><input type="radio" id="posts_column03_<?=$key?>" name="posts_column03" value="<?=$key?>" <?=($key==$records['posts_column03']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_title_length -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_title_length"><?=TXT_CONFIGPOSTTYPE_LBL_TITLELENGTH?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_TITLELENGTH?>" data-content="<?=$popover['posts_title_length']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="posts_title_length" name="posts_title_length" >
									<?php for ($i=7; $i<=50 ;$i++):?>
										<option value="<?=$i?>" <?=($records['posts_title_length']['value']===(string)$i)?'selected="selected"':''?>><?=$i?></option>
									<?php endfor?>
									<option value="0" <?=($records['posts_title_length']['value']==='0')?'selected="selected"':''?>><?=TXT_CONFIGPOSTTYPE_LBL_UNLIMITED?></option>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_category_num -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_category_num"><?=TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMCATEGORY?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMCATEGORY?>" data-content="<?=$popover['posts_category_num']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="posts_category_num" name="posts_category_num" >
									<?php for ($i=1; $i<=10 ;$i++):?>
										<option value="<?=$i?>" <?=($records['posts_category_num']['value']===(string)$i)?'selected="selected"':''?>><?=$i?></option>
									<?php endfor?>
									<option value="" <?=($records['posts_category_num']['value']==='')?'selected="selected"':''?>><?=TXT_CONFIGPOSTTYPE_LBL_UNLIMITED?></option>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- posts_tag_num -->
						<div class="form-group">
							<label class="control-label col-md-4" for="posts_tag_num"><?=TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMTAG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMTAG?>" data-content="<?=$popover['posts_tag_num']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="posts_tag_num" name="posts_tag_num" >
									<?php for ($i=1; $i<=10 ;$i++):?>
										<option value="<?=$i?>" <?=($records['posts_tag_num']['value']===(string)$i)?'selected="selected"':''?>><?=$i?></option>
									<?php endfor?>
									<option value="" <?=($records['posts_tag_num']['value']==='')?'selected="selected"':''?>><?=TXT_CONFIGPOSTTYPE_LBL_UNLIMITED?></option>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="posttype_list">
								<input class="btn btn-primary width120" type="submit" id="submit_record_02" name="submit_record" value="<?=TXT_CONFIGPOSTTYPE_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<?php if ($records['comment_type']['value']):?>
				<div class="panel panel-info">
					<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGPOSTTYPE_LBL_TITLECOMMENTLIST?></h3></div>
					<div id="panel_posttype_comment" class="panel-body">
						<form class="form-horizontal" role="form" action="./?mode=3" method="post">
							
							<!-- comments_list_num -->
							<div class="form-group">
								<label class="control-label col-md-4" for="comments_list_num"><?=TXT_CONFIGPOSTTYPE_LBL_LISTNUM?>
									<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_LISTNUM?>" data-content="<?=$popover['comments_list_num']?>">[?]</a>
								</label>
								<div class="col-md-4">
									<select class="form-control" id="comments_list_num" name="comments_list_num" >
										<?php for ($i=1; $i<=20 ;$i++):?>
											<option value="<?=$i?>" <?=($records['comments_list_num']['value']==$i)?'selected':''?>><?=$i?></option>
										<?php endfor?>
									</select>
								</div>
								<div class="col-md-4"></div>
							</div>
							
							<!-- comments_title_length -->
							<div class="form-group">
								<label class="control-label col-md-4" for="comments_title_length"><?=TXT_CONFIGPOSTTYPE_LBL_TITLELENGTH?>
									<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_TITLELENGTH?>" data-content="<?=$popover['comments_title_length']?>">[?]</a>
								</label>
								<div class="col-md-4">
									<select class="form-control" id="comments_title_length" name="comments_title_length" >
										<?php for ($i=1; $i<=50 ;$i++):?>
											<option value="<?=$i?>" <?=($records['comments_title_length']['value']===(string)$i)?'selected="selected"':''?>><?=$i?></option>
										<?php endfor?>
										<option value="0" <?=($records['comments_title_length']['value']==='0')?'selected="selected"':''?>><?=TXT_CONFIGPOSTTYPE_LBL_UNLIMITED?></option>
									</select>
								</div>
								<div class="col-md-4"></div>
							</div>
							
							<!-- review_max_score -->
							<div class="form-group">
								<label class="control-label col-md-4" for="review_max_score"><?=TXT_CONFIGPOSTTYPE_LBL_REVIEWMAXSCORE?>
									<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGPOSTTYPE_LBL_REVIEWMAXSCORE?>" data-content="<?=$popover['review_max_score']?>">[?]</a>
								</label>
								<div class="col-md-4">
									<select class="form-control" id="review_max_score" name="review_max_score" >
										<?php for ($i=2; $i<=10 ;$i++):?>
											<option value="<?=$i?>" <?=($records['review_max_score']['value']==$i)?'selected="selected"':''?>><?=$i?></option>
										<?php endfor?>
									</select>
								</div>
								<div class="col-md-4"></div>
							</div>
							<hr>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-4">
									<input type="hidden" name="target" value="posttype_comment">
									<input class="btn btn-primary width120" type="submit" id="submit_record_05" name="submit_record" value="<?=TXT_CONFIGPOSTTYPE_BTN_SUBMIT?>">
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php endif?>
		
		</div>
	</div>
</main>
<script src="js/config.js"></script>