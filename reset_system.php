<?php require_once dirname(__FILE__).'/logic/_reset_system.php'?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title><?=TXT_RESETSYSTEM_TITLE?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="css/style.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="plugin/jquery/jquery-ui.min.css">
<link rel="stylesheet" href="plugin/select2/css/select2.css">
<link rel="stylesheet" type="text/css" href="plugin/fancybox2/jquery.fancybox.css" media="screen" />
<script src="plugin/jquery/jquery-2.2.3.min.js"></script>
<script src="plugin/jquery/jquery-ui.min.js"></script>
<script src="plugin/select2/js/select2.min.js"></script>
<script type="text/javascript" src="plugin/fancybox2/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="lang/body_<?=$lang?>.js"></script>
</head>
<body>
<main>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modaltitle_resetsystem">
						<?=$title?>
						<?php if ($mode == 2):?>
						<span id="backto_configcore"><a href="./?view_page=config_core"><?=TXT_RESETSYSTEM_LNK_BACKCONFIG?></a></span>
						<?php else:?>
						<?php if ($mode != 1):?>
						<small id="backto_login"><a href="./_logout.php"><?=TXT_RESETSYSTEM_LNK_BACKLOGIN?></a></small>
						<?php endif?>
						<?php if (! empty($language_list) && count($language_list) > 1):?>
						<span id="select_language">
							<?php foreach ($language_list as $key => $value):?>
							<a href="?language=<?=$key?>"><?=$value?></a>
							<?php endforeach?>
						</span>
						<?php endif?>
						<?php endif?>
					</h4>
				</div>
				<form class="form-horizontal" role="form" action="./reset_system.php" method="post">
					<div class="modal-body container-fluid">
						<?php if (! empty($_GET['errormsg'])):?>
						<div class="alert alert-danger">
							<?=$reset_system_errormsg[$_GET['errormsg']]?>
							<?php if ($_GET['errormsg'] == 10):?>
							<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_HINT_ERR10?>" data-content="<?=$popover['hint10']?>">[?]</a>
							<?php endif?>
						</div>
						<?php endif?>
	
						<?php if ($mode == 2):?>
						<div class="alert alert-success"><?=TXT_RESETSYSTEM_MSG_USINGDB($database_list[$established_db])?></div>
						<?php endif?>
						<?php if ($mode == 4):?>
						<div class="alert alert-warning"><?=TXT_RESETSYSTEM_MSG_PREVIOUSACTIVATIONKEY($established_activation_key)?></div>
						<?php endif?>
	
						<?php if ($mode != 2 && $mode != 5 && $mode != 6):?>
						<div class="form-group">
							<label class="control-label col-md-4" for="activation_key">
								<span class="needValidIcon label label-<?=(!empty($_GET['errormsg'])&&$_GET['errormsg']=='01')?'danger':'primary'?>"><?=TXT_RESETSYSTEM_LBL_REQUIRED?></span>
								<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
								<?=TXT_RESETSYSTEM_LBL_ACTIVATIONKEY?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_ACTIVATIONKEY?>" data-content="<?=$popover['input_activation_key']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<input class="form-control needValidation" data-valid_type="activation_key" type="text" id="activation_key" name="activation_key" value="<?=$activation_key?>" placeholder="<?=TXT_RESETSYSTEM_PLH_ACTIVATIONKEY?>" <?=($mode==3&&!empty($configs))?'readonly':''?>>
								<small class="invalidText hidden"><?=TXT_RESETSYSTEM_ALT_ACTIVATIONKEY?></small>
							</div>
						</div>
						<?php if ((isset($_GET['errormsg']) && ($_GET['errormsg'] == 3 || $_GET['errormsg'] == 4)) || $mode == 3):?>
						<div class="form-group">
							<label class="control-label col-md-4" for="email"><?=TXT_RESETSYSTEM_LBL_EMAIL?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_EMAIL?>" data-content="<?=$popover['input_email']?>">[?]</a>
							</label>
							<div class="col-md-7"><input class="form-control" type="text" id="email" name="email" value="<?=$email?>" placeholder="<?=TXT_RESETSYSTEM_PLH_EMAIL?>"></div>
						</div>
						<div class="notice_activation_key"><div class="alert alert-warning"><?=($mode==3)?TXT_RESETSYSTEM_WAR_RESET_ACTIVATIONKEY:TXT_RESETSYSTEM_WAR_REUSE_ACTIVATIONKEY?></div></div>
						<?php endif?>
						<?php if ($mode != 4):?>
						<hr>
						<?php endif?>
	
						<?php if ($mode == 1):?>
						<div class="form-group">
							<label class="control-label col-md-4" for="site_name"><?=TXT_RESETSYSTEM_LBL_SITENAME?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_SITENAME?>" data-content="<?=$popover['input_site_name']?>">[?]</a>
							</label>
							<div class="col-md-7"><input class="form-control" type="text" id="site_name" name="site_name" value="<?=$site_name?>" placeholder="<?=TXT_RESETSYSTEM_PLH_SITENAME?>"></div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="account">
								<span class="needValidIcon label label-<?=(!empty($_GET['errormsg'])&&$_GET['errormsg']=='01')?'danger':'primary'?>"><?=TXT_RESETSYSTEM_LBL_REQUIRED?></span>
								<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
								<?=TXT_RESETSYSTEM_LBL_ACCOUNT?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_ACCOUNT?>" data-content="<?=$popover['input_account']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<input class="form-control needValidation" data-valid_type="account" type="text" id="account" name="account" value="<?=$account?>" placeholder="<?=TXT_RESETSYSTEM_PLH_ACCOUNT?>">
								<small class="invalidText hidden"><?=TXT_RESETSYSTEM_ALT_ACCOUNT?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="nickname"><?=TXT_RESETSYSTEM_LBL_NICKNAME?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_NICKNAME?>" data-content="<?=$popover['input_nickname']?>">[?]</a>
							</label>
							<div class="col-md-7"><input class="form-control" type="text" id="nickname" name="nickname" value="<?=$nickname?>" placeholder="<?=TXT_RESETSYSTEM_PLH_NICKNAME?>" ></div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="password">
								<span class="needValidIcon label label-<?=(!empty($_GET['errormsg'])&&$_GET['errormsg']=='01')?'danger':'primary'?>"><?=TXT_RESETSYSTEM_LBL_REQUIRED?></span>
								<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
								<?=TXT_RESETSYSTEM_LBL_PASSWORD?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_PASSWORD?>" data-content="<?=$popover['input_password']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<input class="form-control needValidation" data-valid_type="password" type="text" id="password" name="password" value="<?=$password?>" placeholder="<?=TXT_RESETSYSTEM_PLH_PASSWORD?>">
								<small class="invalidText hidden"><?=TXT_RESETSYSTEM_ALT_PASSWORD?></small>
							</div>
						</div>
						<hr>
	
						<div class="form-group">
							<label class="control-label col-md-4" for="timezone"><?=TXT_RESETSYSTEM_LBL_TIMEZONE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_TIMEZONE?>" data-content="<?=$popover['input_timezone']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<select class="form-control" id="timezone" name="timezone" style="width: 200px">
									<?php foreach ($timezones as $value):?>
									<option value="<?=$value?>" <?=($value==$timezone)?'selected':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
						</div>
						<?php endif?>
						<?php endif?>
	
						<?php if ($mode <= 2 || ($mode >= 3 && empty($configs))):?>
						<div class="form-group">
							<label class="control-label col-md-4" for="database"><?=$lbl_database?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_PLH_DATABASE?>" data-content="<?=$popover['input_database']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<select class="form-control" id="database" name="database" style="width: 200px" <?=(($mode==3&&!empty($configs))||$mode==5||$mode==6)?'disabled':''?>>
									<?php foreach ($database_list as $key => $value):?>
									<?php if ($mode != 2 || ($mode == 2 && ($key == 2 || ($key == 1 && $key != $established_db)))):?>
									<option value="<?=$key?>" <?=($key==$database)?'selected':''?>><?=$value?></option>
									<?php endif?>
									<?php endforeach?>
								</select>
							</div>
						</div>
	
						<?php if ($mode < 5):?>
						<div class="form-group">
							<label class="control-label col-md-4" for="table_prefix">
								<span class="needValidIcon label label-<?=(!empty($_GET['errormsg'])&&$_GET['errormsg']=='01')?'danger':'primary'?>"><?=TXT_RESETSYSTEM_LBL_REQUIRED?></span>
								<span class="validIcon hidden"><i class="fa fa-check-circle"></i></span>
								<?=TXT_RESETSYSTEM_LBL_TABLEPREFIX?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_RESETSYSTEM_LBL_TABLEPREFIX?>" data-content="<?=$popover['input_table_prefix']?>">[?]</a>
							</label>
							<div class="col-md-7">
								<div class="percent70">
									<input class="form-control needValidation" data-valid_type="prefix" type="text" id="table_prefix" name="table_prefix" value="<?=$table_prefix?>" placeholder="<?=TXT_RESETSYSTEM_PLH_TABLEPREFIX?>">
									<small class="invalidText hidden"><?=TXT_RESETSYSTEM_ALT_TABLEPREFIX?></small>
								</div>
								<div class="percent30">
									<span id="makePrefix" type="button" class="btn btn-default buttonBlock"><?=TXT_RESETSYSTEM_BTN_AUTOGENERATEPREFIX?></span>
								</div>
								<?php if ($mode == 2):?>
								<div id="shift_db_wrap">
									<label class="checkbox-inline" for="shift_db"><input type="checkbox" id="shift_db" name="shift_db" value="1" <?=($shift_db)?'checked="checked"':''?>> <?=TXT_RESETSYSTEM_LBL_CHANGEDB?></label>
								</div>
								<?php endif?>
							</div>
						</div>
						<?php endif?>
	
						<?php if ($mode != 5):?>
						<div id="info_db_connect">
							<hr>
							<div class="form-group">
								<label class="control-label col-md-4" for="db_host"><?=TXT_RESETSYSTEM_LBL_DBHOST?></label>
								<div class="col-md-7"><input class="form-control" type="text" id="db_host" name="db_host" value="<?=$db_host?>" placeholder="<?=TXT_RESETSYSTEM_PLH_DBHOST?>" disabled></div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4" for="db_name"><?=TXT_RESETSYSTEM_LBL_DBNAME?></label>
								<div class="col-md-7"><input class="form-control" type="text" id="db_name" name="db_name" value="<?=$db_name?>" placeholder="<?=TXT_RESETSYSTEM_PLH_DBNAME?>" disabled></div>
							</div>
	
							<div class="form-group">
								<label class="control-label col-md-4" for="db_user"><?=TXT_RESETSYSTEM_LBL_DBUSER?></label>
								<div class="col-md-7"><input class="form-control" type="text" id="db_user" name="db_user" value="<?=$db_user?>" placeholder="<?=TXT_RESETSYSTEM_PLH_DBUSER?>" disabled></div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4" for="db_pass"><?=TXT_RESETSYSTEM_LBL_DBPASS?></label>
								<div class="col-md-7"><input class="form-control" type="text" id="db_pass" name="db_pass" value="<?=$db_pass?>" placeholder="<?=TXT_RESETSYSTEM_PLH_DBPASS?>" disabled></div>
							</div>
						</div>
						<?php endif?>
						<?php endif?>
					</div>
					<input type="hidden" id="mode" value="<?=$mode?>">
					<input type="hidden" id="established_db" value="<?=$established_db?>">
					<input type="hidden" id="shift_db_hidden" value="<?=$shift_db?>">
					<div class="modal-footer">
						<span class="spinnerInline hidden"><i class="fa fa-spinner fa-pulse"></i></span>
						<?php if ($lbl_submit):?>
						<input type="submit" id="do_submit" class="btn btn-success" value="<?=$lbl_submit?>">
						<?php endif?>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="lib/functions.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/_reset_system.js"></script>
</main>
</body>