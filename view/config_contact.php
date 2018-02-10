
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
			
			<!-- Config Contact -->
			<div class="panel panel-info">
				<div id="panel_contact_option" class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGCONTACT_LBL_TITLEOPTION?></h3></div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- use_customitem_flg -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_customitem_flg"><?=TXT_CONFIGCONTACT_LBL_USECUSTOMITEMFLG?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USECUSTOMITEMFLG?>" data-content="<?=$popover['use_customitem_flg']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_customitem_flg_<?=$key?>"><input type="radio" id="use_customitem_flg_<?=$key?>" name="use_customitem_flg" value="<?=$key?>" <?=($key==$records['use_customitem_flg']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input class="btn btn-primary width120" type="submit" id="submit_record_01" name="submit_record" value="<?=TXT_CONFIGCONTACT_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGCONTACT_LBL_TITLELIST?></h3></div>
				<div id="panel_contact_list" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- contacts_list_num -->
						<div class="form-group">
							<label class="control-label col-md-4" for="contacts_list_num"><?=TXT_CONFIGCONTACT_LBL_LISTNUM?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_LISTNUM?>" data-content="<?=$popover['contacts_list_num']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="contacts_list_num" name="contacts_list_num" >
									<?php for ($i=1; $i<=20 ;$i++):?>
										<option value="<?=$i?>" <?=($records['contacts_list_num']['value']==$i)?'selected':''?>><?=$i?></option>
									<?php endfor?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- contacts_sort_order -->
						<div class="form-group">
							<label class="control-label col-md-4" for="contacts_sort_order"><?=TXT_CONFIGCONTACT_LBL_SORTORDER?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_SORTORDER?>" data-content="<?=$popover['contacts_sort_order']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($contacts_sort_order_list as $key => $value):?>
									<label class="radio-inline" for="contacts_sort_order_<?=$key?>"><input type="radio" id="contacts_sort_order_<?=$key?>" name="contacts_sort_order" value="<?=$key?>" <?=($key==$records['contacts_sort_order']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- contacts_column01 -->
						<div class="form-group">
							<label class="control-label col-md-4" for="contacts_column01"><?=TXT_CONFIGCONTACT_LBL_POSTSCOLUMN01?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_POSTSCOLUMN01?>" data-content="<?=$popover['contacts_column01']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($contacts_column01_list as $key => $value):?>
									<label class="radio-inline" for="contacts_column01_<?=$key?>"><input type="radio" id="contacts_column01_<?=$key?>" name="contacts_column01" value="<?=$key?>" <?=($key==$records['contacts_column01']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- contacts_column03 -->
						<div class="form-group">
							<label class="control-label col-md-4" for="contacts_column03"><?=TXT_CONFIGCONTACT_LBL_POSTSCOLUMN03?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_POSTSCOLUMN03?>" data-content="<?=$popover['contacts_column03']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($contacts_column03_list as $key => $value):?>
									<label class="radio-inline" for="contacts_column03_<?=$key?>"><input type="radio" id="contacts_column03_<?=$key?>" name="contacts_column03" value="<?=$key?>" <?=($key==$records['contacts_column03']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- contacts_column01_length -->
						<div class="form-group">
							<label class="control-label col-md-4" for="contacts_column01_length"><?=TXT_CONFIGCONTACT_LBL_COLUMN01LENGTH?>
								<a data-toggle="popover" data-placement="top" column01="<?=TXT_CONFIGCONTACT_LBL_COLUMN01LENGTH?>" data-content="<?=$popover['contacts_column01_length']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="contacts_column01_length" name="contacts_column01_length" >
									<?php for ($i=7; $i<=50 ;$i++):?>
										<option value="<?=$i?>" <?=($records['contacts_column01_length']['value']===(string)$i)?'selected="selected"':''?>><?=$i?></option>
									<?php endfor?>
									<option value="0" <?=($records['contacts_column01_length']['value']==='0')?'selected="selected"':''?>><?=TXT_CONFIGCONTACT_LBL_UNLIMITED?></option>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- contacts_category_num -->
						<div class="form-group">
							<label class="control-label col-md-4" for="contacts_category_num"><?=TXT_CONFIGCONTACT_LBL_DISPLAYNUMCATEGORY?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_DISPLAYNUMCATEGORY?>" data-content="<?=$popover['contacts_category_num']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="contacts_category_num" name="contacts_category_num" >
									<?php for ($i=1; $i<=10 ;$i++):?>
										<option value="<?=$i?>" <?=($records['contacts_category_num']['value']===(string)$i)?'selected="selected"':''?>><?=$i?></option>
									<?php endfor?>
									<option value="" <?=($records['contacts_category_num']['value']==='')?'selected="selected"':''?>><?=TXT_CONFIGCONTACT_LBL_UNLIMITED?></option>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input class="btn btn-primary width120" type="submit" id="submit_record_02" name="submit_record" value="<?=TXT_CONFIGCONTACT_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>
		
		</div>
	</div>
</main>
<script src="js/config.js"></script>