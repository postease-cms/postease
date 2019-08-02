
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?> </h3></div>
	</div>
	
	<!-- INNER WRAP -->
	<div class="col-md-12">
		
		<!-- PROCESS MESSAGE -->
		<?php if(! empty($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<!-- EDIT PANEL -->
			<form id="new_post" role="form" action="" method="post">
				<div class="form-group">
					<label class="control-label" for="password_current"><i class="fa fa-unlock-alt"></i> <?=TXT_CHANGEPASSWORD_LBL_CURRENT?></label>
					<div><input class="form-control" tabindex="1" type="password" id="password_current" name="password_current" value="" placeholder="<?=TXT_CHANGEPASSWORD_PLH_CURRENT?>"></div>
				</div>
				<div class="form-group">
					<label class="control-label" for="password_new">
						<i class="fa fa-key"></i>
						<?=TXT_CHANGEPASSWORD_LBL_NEW?>
						<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
						<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
					</label>
					<div><input tabindex="2" oncontextmenu="return false;" oncopy="return false;" class="form-control needValidation" data-valid_type="password" type="text" id="password_new" name="password_new" value="" placeholder="<?=TXT_CHANGEPASSWORD_PLH_NEW?>"></div>
				</div>
				<div class="form-group post_item_container">
					<label class="control-label" for="password_confirm">
						<i class="fa fa-key"></i>
						<?=TXT_CHANGEPASSWORD_LBL_CONFIRM?>
						<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
						<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
					</label>
					<div><input tabindex="3" oncontextmenu="return false;" class="form-control" data-valid_type="password" type="text" id="password_confirm" name="password_confirm" value="" placeholder="<?=TXT_CHANGEPASSWORD_PLH_CONFIRM?>"></div>
					<div class="passwordAutoGenerate" id="password_auto_generate"><span id="password_generator" class="btn btn-primary"><?=TXT_CHANGEPASSWORD_LBL_AUTOGENERATE?></span></div>
				</div>
        <div class="form-group">
          <label class="control-label" for="account"><?=TXT_CHANGEPASSWORD_LBL_ACCOUNT?></label>
          <span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
          <span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
          <small>&nbsp;&nbsp;<a id="change_account">(<?=TXT_POST_LBL_CHANGE_SLUG?>)</a></small>
          <div class="multistep10" id="input_wrapper_account">
            <input tabindex="4" class="form-control needValidation" data-valid_type="account" tabindex="1" type="text" id="account" name="account" value="<?=$_SESSION[$session_key]['user']['account']?>" readonly placeholder="<?=TXT_CHANGEPASSWORD_PLH_ACCOUNT?>" <?=($mode==2)?'readonly':''?> required>
          </div>
        </div>
				<div class="form-group">
					<label class="control-label" for="nickname"><?=TXT_CHANGEPASSWORD_LBL_NICKNAME?></label>
					<div><input tabindex="5" class="form-control" type="text" id="nickname" name="nickname" value="<?=$_SESSION[$session_key]['user']['nickname']?>" placeholder="<?=TXT_CHANGEPASSWORD_PLH_NICKNAME?>"></div>
				</div>
				<div class="form-group">
					<input tabindex="6" class="btn btn-primary" type="submit" id="do_submit" name="do_submit" value="<?=TXT_CHANGEPASSWORD_BTN_SUBMIT?>">
					<input type="hidden" id="account" value="<?=$_SESSION[$session_key]['user']['account']?>">
				</div>
			</form>
		</div>
	</div>
</main>