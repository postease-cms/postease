
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=$page_title_sub?></h3></div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="config_wrap">
		
		<!-- PROCESS MESSAGE -->
		<?php if(isset($process_msg)):?>
			<div class="alert alert-<?=$process_msg_style?> process<?=$process_msg_type?>"><?=$process_msg?></div>
		<?php endif?>
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show config">
			
			<!-- Config General -->
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title"><?=TXT_CONFIGGENERAL_LBL_TITLECOMMON?></h3></div>
				<div id="panel_general_whole" class="panel-body">
					<form class="form-horizontal" role="form" action="./?mode=3" method="post">
						
						<!-- site_name -->
						<div class="form-group">
							<label class="control-label col-md-4" for="site_name"><?=TXT_CONFIGGENERAL_LBL_SITENAME?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGGENERAL_LBL_SITENAME?>" data-content="<?=$popover['site_name']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<input class="form-control" type="text" id="site_name" name="site_name" value="<?=$records['site_name']['value']?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- language -->
						<div class="form-group">
							<label class="control-label col-md-4" for="language"><?=TXT_CONFIGGENERAL_LBL_LANGUAGE?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGGENERAL_LBL_LANGUAGE?>" data-content="<?=$popover['language']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="language" name="language" >
									<?php foreach ($language_list as $key => $value):?>
										<option value="<?=$key?>" <?=($key==$records['language']['value'])?'selected':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						
						<!-- system_font -->
						<div class="form-group">
							<label class="control-label col-md-4" for="system_font"><?=TXT_CONFIGGENERAL_LBL_SYSTEMFONT?>
								<a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGGENERAL_LBL_SYSTEMFONT?>" data-content="<?=$popover['system_font']?>">[?]</a>
							</label>
							<div class="col-md-4">
								<select class="form-control" id="system_font" name="system_font" >
									<?php foreach ($system_font_list as $key => $value):?>
										<option value="<?=$key?>" <?=($key==$records['system_font']['value'])?'selected':''?>><?=$value?></option>
									<?php endforeach?>
								</select>
							</div>
							<div class="col-md-4"></div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<input type="hidden" name="target" value="general_whole">
								<input class="btn btn-primary width120" type="submit" id="submit_record_01" name="submit_record" value="<?=TXT_CONFIGGENERAL_BTN_SUBMIT?>">
							</div>
						</div>
					</form>
				</div>
			</div>

      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="configcoreHeading panel-title"><?=TXT_CONFIGGENERAL_LBL_IMPLEMENTCODE?></h3>
        </div>
        <div id="panel_implement_code" class="panel-body">
          <form class="form-horizontal" role="form" action="./?mode=3" method="post">

            <!-- display_implement_code -->
            <div class="form-group">
              <label class="control-label col-md-4" for="display_implement_code"><?=TXT_CONFIGGENERAL_LBL_DISPLAYIMPLEMENTCODE?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGGENERAL_LBL_DISPLAYIMPLEMENTCODE?>" data-content="<?=$popover['display_implement_code']?>">[?]</a>
              </label>
              <div class="col-md-4">
								<?php foreach ($common_flg_display as $key => $value):?>
                  <label class="radio-inline" for="display_implement_code_<?=$key?>"><input type="radio" id="display_implement_code_<?=$key?>" name="display_implement_code" value="<?=$key?>" <?=($key==$records['display_implement_code']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
              </div>
              <div class="col-md-4"></div>
            </div>

            <!-- implement code -->
            <div class="form-group">
              <label class="control-label col-md-4" for="implement_code"><?=TXT_CONFIGGENERAL_LBL_IMPLEMENTCODETYPE?>
                <a data-toggle="popover" data-placement="top" title="<?=TXT_CONFIGGENERAL_LBL_IMPLEMENTCODETYPE?>" data-content="<?=$popover['implement_code']?>">[?]</a>
              </label>
              <div class="col-md-4">
								<?php foreach ($implement_code_list as $key => $value):?>
                  <label class="radio-inline" for="implement_code_<?=$key?>"><input type="radio" id="implement_code_<?=$key?>" name="implement_code" value="<?=$key?>" <?=($key==$records['implement_code']['value'])?'checked':''?>> <?=$value?></label>
								<?php endforeach?>
              </div>
              <div class="col-md-4"></div>
            </div>

            <hr>
            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <input type="hidden" name="target" value="implement_code">
	              <input class="btn btn-primary width120" type="submit" id="submit_record_02" name="submit_record" value="<?=TXT_CONFIGGENERAL_BTN_SUBMIT?>">
              </div>
            </div>
          </form>
        </div>
      </div>
		
		</div>
	</div>
</main>
<script src="js/config.js"></script>