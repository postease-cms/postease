<!-- MAIN CONTENTS -->
<main id="content" class="col-md-10">
	
	<!-- MAIN CONTENTS -->
	<div class="slow-show">
		
		<!-- about_system -->
		<div id="about_system" class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><?=TXT_ABOUTSYSTEM_LBL_TITLE?></h3></div>
			<div class="panel-body">
				<table class="table" id="about_postease">
					<tbody>
					<tr>
						<th><?=TXT_ABOUTSYSTEM_THD_THISVERSION?></th>
						<td><?=$_SESSION[$session_key]['configs']['postease_version']?></td>
					</tr>
					<tr>
						<th><?=TXT_ABOUTSYSTEM_THD_LICENSE?></th>
						<td>
							<?php if (isset($_SESSION[$session_key]['license']['extra_license_code'])):?>
								<?php if ($_SESSION[$session_key]['license']['type'] == 1):?>
									<?=TXT_ABOUTSYSTEM_LBL_LICENSEBUSINESS?>
								<?php else:?>
									<?=TXT_ABOUTSYSTEM_LBL_LICENSEBASIC?>
								<?php endif?>
							<?php else:?>
								<?=TXT_ABOUTSYSTEM_ALT_FAILLICENSE?>
							<?php endif?>
							<?php if ($_SESSION[$session_key]['license']['extra_license_code']):?>
								<?php if ($_SESSION[$session_key]['license']['valid_to'] == '9999-99-99'):?>
									(<?=TXT_ABOUTSYSTEM_LBL_UNLIMITED?>)
								<?php else:?>
									(<?=TXT_ABOUTSYSTEM_MSG_VALIDTO($_SESSION[$session_key]['license']['valid_to'])?>)
								<?php endif?>
							<?php endif?>
						</td>
					</tr>
					<tr>
						<th><?=TXT_ABOUTSYSTEM_THD_ACTIVATIONKEY?></th>
						<td>
							<span id="activation_key_masked"><?=substr($_SESSION[$session_key]['configs']['activation_key'],0,9)?>-XXXX-XXXX-XXXX</span>
							<span id="activation_key_full"><?=$_SESSION[$session_key]['configs']['activation_key']?></span>
							<span id="unlock_activation_key"><i class="fa fa-lock" aria-hidden="true"></i></span>
							<span id="lock_activation_key"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
						</td>
					</tr>
					<tr>
						<th><?=TXT_ABOUTSYSTEM_THD_DATABASE?></th>
						<td>
							<?=$database_list[$_SESSION[$session_key]['configs']['database']]?>
							<?php if ($_SESSION[$session_key]['configs']['database'] == 2 && defined('DB_HOST')):?>
								<?='( host : '.DB_HOST. ' / prefix : ' .$table_prefix. ' )'?>
							<?php endif?>
						</td>
					</tr>
					</tbody>
				</table>
				
				<div class="panel panel-info updateHistory">
					<div id="update_history_header" class="panel-heading">
						<h3 id="update_history_title" class="panel-title"><?=TXT_ABOUTSYSTEM_LBL_UPDATEHISTORIY?></h3>
						<small id="check_level">
							<?=TXT_ABOUTSYSTEM_LBL_APPLYLEVEL?>
							<?php foreach ($update_level_list as $key => $value):?>
								<label for="level<?=$key?>"><input name="level[]" id="level<?=$key?>" type="checkbox" value="<?=$key?>" <?=(strstr($applied_level,(string)$key))?'checked':''?>> <?=$value?></label>
							<?php endforeach?>
						</small>
					</div>
					<div class="panel-body">
						<table class="table" id="update_history">
							<tbody>
							<tr>
								<th><?=TXT_ABOUTSYSTEM_THD_APPLIEDVERSION?></th>
								<th><?=TXT_ABOUTSYSTEM_THD_APPLIEDLEVEL?></th>
								<th><?=TXT_ABOUTSYSTEM_THD_APPLIEDAT?></th>
								<th><?=TXT_ABOUTSYSTEM_THD_APPLIEDDETAIL?></th>
							</tr>
							<?php if (! empty($update_histories)):?>
								<?php foreach($update_histories as $row):?>
									<tr>
										<td><?=$row['applied_version']?></td>
										<td>
											<?php if ($row['applied_level'] != '-'):?>
												<span class="label label-<?=($row['applied_level']==3)?'info':'success'?>">
											<?=$update_level_list[$row['applied_level']]?>
										</span>
											<?php else:?>
												<?=$row['applied_level']?>
											<?php endif?>
										</td>
										<td><?=$row['applied_at']?></td>
										<td><?=$row['applied_detail']?></td>
									</tr>
								<?php endforeach?>
							<?php endif?>
							</tbody>
						</table>
					</div>
				</div>
				
				<?php if ($purchases_flg):?>
					<?php if (! empty($purchases)):?>
						<div class="panel panel-info updateHistory">
							<div id="purchase_history_header" class="panel-heading">
								<h3 id="purchase_history_title" class="panel-title"><?=TXT_ABOUTSYSTEM_LBL_PURCHASEHISTORIY?></h3>
							</div>
							<div class="panel-body">
								<?php if (! empty($purchases)):?>
									<table class="table" id="purchase_history">
										<tbody>
										<tr>
											<th><?=TXT_ABOUTSYSTEM_THD_PURCHASEDAT?></th>
											<th><?=TXT_ABOUTSYSTEM_THD_EXTRALICENSECODE?></th>
											<th><?=TXT_ABOUTSYSTEM_THD_PURCHASEPRICE?></th>
											<th><?=TXT_ABOUTSYSTEM_THD_VALID?></th>
										</tr>
										<?php foreach($purchases as $row):?>
											<tr>
												<td><?=$row['purchased_at']?></td>
												<td><?=$row['label']?></td>
												<td>
													<?php if ($row['currency'] == 'yen'):?>
														<?=number_format($row['purchase_price'])?> <?=$currency_list[$row['currency']]?>
													<?php else:?>
														<?=$currency_list[$row['currency']]?> <?=$row['purchase_price']?>
													<?php endif?>
												</td>
												<td><?=$row['valid_from']?> - <?=($row['valid_to']==null)?TXT_ABOUTSYSTEM_LBL_UNLIMITED:$row['valid_to']?></td>
											</tr>
										<?php endforeach?>
										</tbody>
									</table>
								<?php endif?>
							</div>
						</div>
					<?php endif?>
				<?php endif?>
			
			</div>
			<div class="ly_aboutSystem-logoWrapper">
				<p class="aboutSystem-text">PostEase Classic</p>
			</div>
		</div>
	
	</div>
</main>