
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
      
      <!-- Admin auto reply setting -->
      <div class="panel panel-info">
        <div id="panel_contact_option" class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGCONTACT_LBL_ADMINAUTOREPLYSETTING?></h3></div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="./?mode=3" method="post">
            
            <!-- use_auto_reply_admin -->
            <div class="form-group">
              <label class="control-label col-md-4" for="use_auto_reply_admin"><?=TXT_CONFIGCONTACT_LBL_USEAUTOREPLYADMIN?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USEAUTOREPLYADMIN?>" data-content="<?=$popover['use_auto_reply_admin']?>">[?]</a>
              </label>
              <div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
                  <label class="radio-inline" for="use_auto_reply_admin<?=$key?>"><input type="radio" id="use_auto_reply_admin<?=$key?>" name="use_auto_reply_admin" value="<?=$key?>" <?=($key==$records['use_auto_reply_admin']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
              </div>
              <div class="col-md-4"></div>
            </div>
  
            <!-- admin_language -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_language"><?=TXT_CONFIGCONTACT_LBL_ADMINLANGUAGE?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINLANGUAGE?>" data-content="<?=$popover['admin_language']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="admin_language" name="admin_language" value="<?=$records['admin_language']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- admin_to -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_to"><?=TXT_CONFIGCONTACT_LBL_ADMINTO?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINTO?>" data-content="<?=$popover['admin_to']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="admin_to" name="admin_to" value="<?=$records['admin_to']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- admin_from -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_from"><?=TXT_CONFIGCONTACT_LBL_ADMINFROM?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINFROM?>" data-content="<?=$popover['admin_from']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="admin_from" name="admin_from" value="<?=$records['admin_from']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- admin_from_name -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_from_name"><?=TXT_CONFIGCONTACT_LBL_ADMINFROMNAME?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINFROMNAME?>" data-content="<?=$popover['admin_from_name']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="admin_from_name" name="admin_from_name" value="<?=$records['admin_from_name']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- admin_subject -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_subject"><?=TXT_CONFIGCONTACT_LBL_ADMINSUBJECT?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINSUBJECT?>" data-content="<?=$popover['admin_subject']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <input class="form-control" type="text" id="admin_subject" name="admin_subject" value="<?=$records['admin_subject']['value']?>">
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- admin_body_head -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_body_head"><?=TXT_CONFIGCONTACT_LBL_ADMINBODYHEAD?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINBODYHEAD?>" data-content="<?=$popover['admin_body_head']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="admin_body_head" name="admin_body_head"><?=$records['admin_body_head']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- admin_body_main -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_body_main"><?=TXT_CONFIGCONTACT_LBL_ADMINBODYMAIN?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINBODYMAIN?>" data-content="<?=$popover['admin_body_main']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="admin_body_main" name="admin_body_main"><?=$records['admin_body_main']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
            </div>
  
            <!-- use_input_values_admin -->
            <div class="form-group">
              <label class="control-label col-md-4" for="use_input_values_admin"><?=TXT_CONFIGCONTACT_LBL_USEINPUTVALUESCUSTOMER?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USEINPUTVALUESCUSTOMER?>" data-content="<?=$popover['use_input_values_admin']?>">[?]</a>
              </label>
              <div class="col-md-4">
			          <?php foreach ($common_flg_use as $key => $value):?>
                  <label class="radio-inline" for="use_input_values_admin<?=$key?>"><input type="radio" id="use_input_values_admin<?=$key?>" name="use_input_values_admin" value="<?=$key?>" <?=($key==$records['use_input_values_admin']['value'])?'checked':''?>> <?=$value?></label>
			          <?php endforeach?>
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- admin_body_bottom -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_body_bottom"><?=TXT_CONFIGCONTACT_LBL_ADMINBODYBOTTOM?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINBODYBOTTOM?>" data-content="<?=$popover['admin_body_bottom']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="admin_body_bottom" name="admin_body_bottom"><?=$records['admin_body_bottom']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- admin_signature -->
            <div class="form-group">
              <label class="control-label col-md-4" for="admin_signature"><?=TXT_CONFIGCONTACT_LBL_ADMINSIGNATURE?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_ADMINSIGNATURE?>" data-content="<?=$popover['admin_signature']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="admin_signature" name="admin_signature"><?=$records['admin_signature']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
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
      
			<!-- Customer auto reply setting -->
			<div class="panel panel-info">
				<div id="panel_contact_option" class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERAUTOREPLYSETTING?></h3></div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- use_auto_reply_customer -->
						<div class="form-group">
							<label class="control-label col-md-4" for="use_auto_reply_customer"><?=TXT_CONFIGCONTACT_LBL_USEAUTOREPLYCUSTOMER?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USEAUTOREPLYCUSTOMER?>" data-content="<?=$popover['use_auto_reply_customer']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
									<label class="radio-inline" for="use_auto_reply_customer<?=$key?>"><input type="radio" id="use_auto_reply_customer<?=$key?>" name="use_auto_reply_customer" value="<?=$key?>" <?=($key==$records['use_auto_reply_customer']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
							</div>
							<div class="col-md-4"></div>
						</div>
            
            <!-- customer_language -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_language"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERLANGUAGE?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERLANGUAGE?>" data-content="<?=$popover['customer_language']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="customer_language" name="customer_language" value="<?=$records['customer_language']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- customer_from -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_from"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERFROM?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERFROM?>" data-content="<?=$popover['customer_from']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="customer_from" name="customer_from" value="<?=$records['customer_from']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- customer_from_name -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_from_name"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERFROMNAME?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERFROMNAME?>" data-content="<?=$popover['customer_from_name']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="customer_from_name" name="customer_from_name" value="<?=$records['customer_from_name']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- customer_subject -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_subject"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERSUBJECT?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERSUBJECT?>" data-content="<?=$popover['customer_subject']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <input class="form-control" type="text" id="customer_subject" name="customer_subject" value="<?=$records['customer_subject']['value']?>">
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- customer_body_head -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_body_head"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERBODYHEAD?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERBODYHEAD?>" data-content="<?=$popover['customer_body_head']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="customer_body_head" name="customer_body_head"><?=$records['customer_body_head']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- customer_body_main -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_body_main"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERBODYMAIN?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERBODYMAIN?>" data-content="<?=$popover['customer_body_main']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="customer_body_main" name="customer_body_main"><?=$records['customer_body_main']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- use_input_values_customer -->
            <div class="form-group">
              <label class="control-label col-md-4" for="use_input_values_customer"><?=TXT_CONFIGCONTACT_LBL_USEINPUTVALUESCUSTOMER?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USEINPUTVALUESCUSTOMER?>" data-content="<?=$popover['use_input_values_customer']?>">[?]</a>
              </label>
              <div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
                  <label class="radio-inline" for="use_input_values_customer<?=$key?>"><input type="radio" id="use_input_values_customer<?=$key?>" name="use_input_values_customer" value="<?=$key?>" <?=($key==$records['use_input_values_customer']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- customer_body_bottom -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_body_bottom"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERBODYBOTTOM?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERBODYBOTTOM?>" data-content="<?=$popover['customer_body_bottom']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="customer_body_bottom" name="customer_body_bottom"><?=$records['customer_body_bottom']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
            </div>
            
            <!-- customer_signature -->
            <div class="form-group">
              <label class="control-label col-md-4" for="customer_signature"><?=TXT_CONFIGCONTACT_LBL_CUSTOMERSIGNATURE?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_CUSTOMERSIGNATURE?>" data-content="<?=$popover['customer_signature']?>">[?]</a>
              </label>
              <div class="col-md-7">
                <textarea class="form-control" type="text" id="customer_signature" name="customer_signature"><?=$records['customer_signature']['value']?></textarea>
              </div>
              <div class="col-md-1"></div>
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
      
      <!-- SMTP setting -->
      <div class="panel panel-info">
        <div id="panel_contact_option" class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGCONTACT_LBL_SMTP?></h3></div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="./?mode=3" method="post">
            
            <!-- use_smtp -->
            <div class="form-group">
              <label class="control-label col-md-4" for="use_smtp"><?=TXT_CONFIGCONTACT_LBL_USE_SMTP?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USE_SMTP?>" data-content="<?=$popover['use_smtp']?>">[?]</a>
              </label>
              <div class="col-md-4">
								<?php foreach ($common_flg_use as $key => $value):?>
                  <label class="radio-inline" for="use_smtp<?=$key?>"><input type="radio" id="use_smtp<?=$key?>" name="use_smtp" value="<?=$key?>" <?=($key==$records['use_smtp']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- host -->
            <div class="form-group">
              <label class="control-label col-md-4" for="host"><?=TXT_CONFIGCONTACT_LBL_HOST?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_HOST?>" data-content="<?=$popover['host']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="host" name="host" value="<?=$records['host']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- user_name -->
            <div class="form-group">
              <label class="control-label col-md-4" for="user_name"><?=TXT_CONFIGCONTACT_LBL_USER_NAME?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_USER_NAME?>" data-content="<?=$popover['user_name']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="user_name" name="user_name" value="<?=$records['user_name']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- password -->
            <div class="form-group">
              <label class="control-label col-md-4" for="password"><?=TXT_CONFIGCONTACT_LBL_PASSWORD?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_PASSWORD?>" data-content="<?=$popover['password']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="password" id="password" name="password" value="<?=$records['password']['value']?>">
              </div>
              <div class="col-md-4"></div>
            </div>
            
            <!-- port -->
            <div class="form-group">
              <label class="control-label col-md-4" for="port"><?=TXT_CONFIGCONTACT_LBL_PORT?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGCONTACT_LBL_PORT?>" data-content="<?=$popover['port']?>">[?]</a>
              </label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="port" name="port" value="<?=$records['port']['value']?>">
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
                  <label class="radio-inline" for="use_customitem_flg<?=$key?>"><input type="radio" id="use_customitem_flg<?=$key?>" name="use_customitem_flg" value="<?=$key?>" <?=($key==$records['use_customitem_flg']['value'])?'checked':''?>> <?=$value?></label>
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