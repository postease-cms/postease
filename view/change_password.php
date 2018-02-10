
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
					<div><input class="form-control" type="password" id="password_current" name="password_current" value="" placeholder="<?=TXT_CHANGEPASSWORD_PLH_CURRENT?>" required></div>
				</div>
				<div class="form-group">
					<label class="control-label" for="password_new">
						<i class="fa fa-key"></i>
						<?=TXT_CHANGEPASSWORD_LBL_NEW?>
						<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
						<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
					</label>
					<div><input oncontextmenu="return false;" oncopy="return false;" class="form-control needValidation" data-valid_type="password" type="password" id="password_new" name="password_new" value="" placeholder="<?=TXT_CHANGEPASSWORD_PLH_NEW?>" required></div>
				</div>
				<div class="form-group">
					<label class="control-label" for="password_confirm">
						<i class="fa fa-key"></i>
						<?=TXT_CHANGEPASSWORD_LBL_CONFIRM?>
						<span class="invalidIcon hidden"><i class="fa fa-times"></i></span>
						<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
					</label>
					<div><input oncontextmenu="return false;" onpaste="return false;"class="form-control" data-valid_type="password" type="password" id="password_confirm" name="password_confirm" value="" placeholder="<?=TXT_CHANGEPASSWORD_PLH_CONFIRM?>" required></div>
				</div>
				<div class="form-group">
					<label class="control-label" for="nickname"><?=TXT_CHANGEPASSWORD_LBL_NICKNAME?></label>
					<div><input class="form-control" type="text" id="nickname" name="nickname" value="<?=$_SESSION[$session_key]['user']['nickname']?>" placeholder="<?=TXT_CHANGEPASSWORD_PLH_NICKNAME?>"></div>
				</div>
				<div class="form-group">
					<input class="btn btn-primary" type="submit" id="do_submit" name="do_submit" value="<?=TXT_CHANGEPASSWORD_BTN_SUBMIT?>">
				</div>
			</form>
		</div>
	</div>
</main>