<main>
<div class="container">
	<div class="login">
		<div id="login_title">
			<h1 class="loginTitle">
				<?php if (! empty($_SESSION[$session_key]['configs']['site_name'])):?>
					<?=$_SESSION[$session_key]['configs']['site_name']?>
				<?php else:?>
					PostEase
				<?php endif?>
			</h1>
		</div>
		<div id="select_lang">
			<?php if (! empty($language_list) && count($language_list) > 1):?>
				<?php foreach ($language_list as $key => $value):?>
					<a href="./?lang=<?=$key?>"><?=$value?></a>
				<?php endforeach?>
			<?php endif?>
		</div>
		<?php if (isset($_GET['error_code'])):?>
			<div class="col-md-offset-1 col-md-10 alert alert-danger"><?=$errormsg_list[$_GET['error_code']]?></div>
		<?php endif?>
		
		<?php if (isset($_GET['error_code']) && $_GET['error_code'] == 99):?>
			<div class="nodb col-md-offset-1 col-md-10">
				<p><?=TXT_LOGIN_VAL_DISABLELOGIN?></p>
				<p><a href="./"><?=TXT_LOGIN_LNK_CONFIRMSETTING?></a></p>
				<h5>PostEase</h5>
			</div>
		<?php else:?>
			<form class="form-horizontal" autocomplete="off" role="form" action="" method="post">
				<div class="form-group">
					<label class="control-label col-md-offset-2 col-md-2" for="account"><?=TXT_LOGIN_LBL_ACCOUNT?></label>
					<div class="col-md-6"><input type="text" autocomplete="off" id="account" name="account" class="form-control" placeholder="<?=TXT_LOGIN_PLH_ACCOUNT?>" value="<?=$_SESSION[$session_key]['user']['account']?>"></div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-offset-2 col-md-2" for="password"><?=TXT_LOGIN_LBL_PASSWORD?></label>
					<div class="col-md-6"><input type="password" autocomplete="off" id="password" name="password" class="form-control" placeholder="<?=TXT_LOGIN_PLH_PASSWORD?>" value="<?=$disp_password?>"></div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-6">
						<label class="control-label" for="remember_me"><input type="checkbox" id="remember_me" name="remember_me" value="1" <?=($disp_remember_me)?'checked="checked"':''?>> <?=TXT_LOGIN_LBL_REMEMBER?></label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-6">
						<input id="submit_login" type="submit" value="<?=TXT_LOGIN_VAL_SUBMIT?>" class="btn btn-primary">
					</div>
				</div>
			</form>
		<?php endif?>
		<span class="errorMsg"><?=$msg?></span>
		<p class="loginLogo-text">PostEase Classic</p>
	</div>
</div>
</main>