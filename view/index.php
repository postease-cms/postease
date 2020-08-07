<?php
//print '<pre>';
//print_r($_SESSION);
//print '</pre>';
//exit;
//?>
<!-- MAIN CONTENTS -->
<main id="content" class="col-md-10">
	
	<!-- MAIN CONTENTS -->
	<div class="slow-show">
		
		<div id="warnings" class="col-md-12">
			<!-- welcome -->
			<?php if (strtotime($_SESSION[$session_key]['user']['login_time']) > (time() - 10)):?>
				<?php if (isset($_SERVER['HTTP_REFERER']) && (strstr($_SERVER['HTTP_REFERER'], 'update') || strstr($_SERVER['HTTP_REFERER'], 'login') || strstr($_SERVER['HTTP_REFERER'], 'index'))):?>
					<p class="alert alert-success processDone" id="process_msg"><?=TXT_INDEX_WELCOME($_SESSION[$session_key]['user']['nickname'])?></p>
				<?php endif?>
			<?php endif?>
			
			<?php if ($check_default_password):?>
				<p class="alert alert-danger"><?=TXT_INDEX_WAR_PASSWORD_01?></p>
			<?php endif?>
			
			<?php if (empty($summary_post) && empty($summary_contact)):?>
        <p class="alert alert-warning"><?=TXT_INDEX_WAR_NO_POSTTYPE?></p>
			<?php endif?>
			
			<?php if ($check_domain):?>
        <p class="alert alert-warning"><?=TXT_INDEX_WAR_CORRECT_DOMAIN?></p>
			<?php endif?>
			
			<?php if ($check_dir_name):?>
        <p class="alert alert-warning"><?=TXT_INDEX_WAR_CORRECT_DIRNAME?></p>
			<?php endif?>
	
			<?php if ($check_sqlite_permission):?>
				<p class="alert alert-danger"><?=TXT_INDEX_WAR_SQLITEPERMISSION($sqlite_permission)?></p>
			<?php endif?>
			
			<?php if ($_SESSION[$session_key]['license']['validity'] == 1 && $_SESSION[$session_key]['license']['type'] == 1 && $_SESSION[$session_key]['license']['valid_to'] != '9999-99-99' && strtotime($_SESSION[$session_key]['license']['valid_to']) - (86400 * 30) < time()):?>
        <?php $days_left = floor((strtotime($_SESSION[$session_key]['license']['valid_to']) + 86400 - time()) / 86400) ?>
        <?php if ($days_left <= 10):?>
        <p class="alert alert-danger"><?=TXT_INDEX_WAR_BUSINESSLICENSE($days_left, $_SESSION[$session_key]['license']['valid_to'])?></p>
        <?php else:?>
        <p class="alert alert-warning"><?=TXT_INDEX_WAR_BUSINESSLICENSE($days_left, $_SESSION[$session_key]['license']['valid_to'])?></p>
        <?php endif?>
      <?php endif?>
		</div>
		
		<!-- functions -->
		<?php if ($_SESSION[$session_key]['user']['role'] <= 2):?>
    <div class="row col-md-12">
      <div class="col-md-4 col-sm-6">
        <div class="alert alert-<?=$advanced_cache_color?>">
          <p><i class="fa fa-<?=$advanced_cache_icon?>" aria-hidden="true"></i> <b><?=$advanced_cache_label?></b></p>
          <p><span><?=$advanced_cache_turn?></span><small><?=$advanced_cache_message?></small></p>
          <p><i class="fa fa-<?=$switch_icon?>" aria-hidden="true"></i><small><?=$advanced_cache_turn_link?></small></p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="alert alert-<?=$version_color?>">
          <p><i class="fa fa-<?=$version_icon?>" aria-hidden="true"></i> <b><?=$version_label?></b></p>
          <p><span><?=$version_turn?></span><small><?=$version_message?></small></p>
          <p><i class="fa fa-<?=$switch_icon?>" aria-hidden="true"></i><small><?=$version_turn_link?></small></p>
        </div>
      </div>
    </div>
		<?php endif?>

    <!-- summary -->
    <div class="row col-md-12">
		<?php if (! empty($summary_post)):?>
      <?php foreach ($summary_post as $posttype => $rows):?>
				<div class="col-md-6">
					<div class="panel panel-primary summaryMenu summaryPost">
						<div class="panel-heading" id="panel_heading_<?=$posttype?>">
							<h3 class="panel-title" id="panel_title_<?=$posttype?>">
								<a href="./?view_page=posts&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$rows['post']['line_order']?>&page=1"><?=$_SESSION[$session_key]['common']['posttypes'][$posttype]['name']?></a>
                <?=TXT_INDEX_LBL_SUMMARY?>
							</h3>
							<?php if (! empty($rows['comment_parent'])):?>
								<?php foreach($rows['comment_parent'] as $type => $comments):?>
									<?php foreach($comments as $status => $count):?>
										<?php if ($status == 2 && ($count > 0 || $rows['comment_children'][$type][$status] > 0)):?>
											<?php if ($rows['comment_children'][$type][$status] > 0) $count += $rows['comment_children'][$type][$status]?>
											<small><a href="./?view_page=comments&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$rows['post']['line_order']?>&type=<?=$type?>&page=1&sc_status=2"><?=TXT_INDEX_LBL_NOTICE_PEND($count,$posttype_comment_type[$type])?></a></small><br>
										<?php endif?>
									<?php endforeach?>
								<?php endforeach?>
							<?php endif?>
						</div>
						<div class="panel-body">
							<table class="table">
								<?php if (! empty($rows['post'])):?>
									<?php if ($rows['post']['total']['parent'] >= 0):?>
										<tr>
                      <th><?=TXT_INDEX_LBL_POST_TOTAL?> : <?=$rows['post']['total']['parent']?></th>
											<?php foreach ($rows['post'] as $status => $row):?>
												<?php if (is_numeric($status)):?>
													<td>
                            <?php if (intval($status) == 1 && $row['parent'] > 0):?>
                            <?=$post_status[$status]?> <span class="badge" id="badge_<?=$status?>"><?=$row['parent']?></span>
                            <?php elseif (intval($status) == 2 && $row['parent'] > 0):?>
                              <a href="./?view_page=posts&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$rows['post']['line_order']?>&page=1&sc_status=2"><?=$post_status_icon[$status]?> <?=$post_status[$status]?></a> <span class="badge" id="badge_<?=$status?>"><?=$row['parent']?></span>
                            <?php else:?>
														<?=$post_status[$status]?> : <?=$row['parent']?>
                            <?php endif?>
													</td>
												<?php endif?>
											<?php endforeach?>
										</tr>
									<?php endif?>
									<?php if (! empty($rows['post']['use_multipage_flg'])):?>
										<?php if ($rows['post']['total']['child'] > 0):?>
											<tr>
												<th><?=TXT_INDEX_LBL_PAGE?> <span class="badge"><?=$rows['post']['total']['child']?></span></th>
												<?php foreach ($rows['post'] as $status => $row):?>
													<?php if (is_numeric($status)):?>
														<td>
                              <?=$post_status[$status]?> : <?=$row['child']?>
                            </td>
													<?php endif?>
												<?php endforeach?>
											</tr>
											<tr>
												<th><?=TXT_INDEX_LBL_POSTPAGE?> <span class="badge"><?=$rows['post']['total']['parent']+$rows['post']['total']['child']?></span></th>
												<?php foreach ($rows['post'] as $status => $row):?>
													<?php if (is_numeric($status)):?>
														<td>
															<?=$post_status[$status]?> : <?=$row['parent']+$row['child']?>
														</td>
													<?php endif?>
												<?php endforeach?>
											</tr>
										<?php endif?>
									<?php endif?>
								<?php endif?>
								<?php if (! empty($rows['comment_parent'])):?>
									<?php foreach ($rows['comment_parent'] as $key => $row):?>
										<tr>
											<th>
												<a href="./?view_page=comments&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$rows['post']['line_order']?>&type=<?=$key?>&page=1"><?=$posttype_comment_type[$key]?></a>
												<?php if (! empty($rows['comment_children'][$key]['total'])):?>
													<span class="badge"><?=$row['total']?> + <?=$rows['comment_children'][$key]['total']?></span>
												<?php else:?>
													<span class="badge"><?=$row['total']?></span>
												<?php endif?>
											</th>
											<?php foreach ($rows['comment_parent'][$key] as $status => $row):?>
												<?php if (is_numeric($status)):?>
													<td>
														<?php if (! empty($rows['comment_children'][$key][$status])):?>
															<?=$comment_status[$status]?> : <?=$row?> + <?=$rows['comment_children'][$key][$status]?>
														<?php else:?>
															<?=$comment_status[$status]?> : <?=$row?>
														<?php endif?>
													</td>
												<?php endif?>
											<?php endforeach?>
										</tr>
									<?php endforeach?>
								<?php endif?>
							</table>
						</div>
					</div>
				</div>
			<?php endforeach?>
		<?php endif?>
		
		<?php if ($_SESSION[$session_key]['configs']['use_contact_flg']):?>
			<?php if (! empty($summary_contact)):?>
				<?php foreach ($summary_contact as $posttype => $row):?>
					<div class="col-md-6">
						<div class="panel panel-primary summaryMenu summaryContact">
							<div class="panel-heading" id="panel_heading_<?=$posttype?>">
								<h3 class="panel-title" id="panel_title_<?=$posttype?>">
									<a href="./?view_page=contacts&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$row['line_order']?>&page=1"><?=$_SESSION[$session_key]['common']['posttypes_extra'][$posttype]['name']?></a> <?=TXT_INDEX_LBL_SUMMARY?>
								</h3>
							</div>
							<div class="panel-body">
								<table class="table">
									<tr>
                    <th><?=TXT_INDEX_LBL_CONTACT_TOTAL?> : <?=$row['total']?></th>
										<?php foreach ($row as $key => $value):?>
                    <?php if (is_numeric($key)):?>
                    <td>
                    <?php if ($key == 8 && $value > 0):?>
                    <a href="./?view_page=contacts&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$row['line_order']?>&page=1&sc_status=8"><?=$contact_status_icon[$key]?> <?=$contact_status[$key]?></a> <span class="badge" id="badge_<?=$key?>"><?=$value?></span>
                    <?php elseif ($key == 7 && $value > 0):?>
                    <a href="./?view_page=contacts&amp;this_posttype=<?=$posttype?>&this_posttype_order=<?=$row['line_order']?>&page=1&sc_status=7"><?=$contact_status_icon[$key]?> <?=$contact_status[$key]?></a> <span class="badge" id="badge_<?=$key?>"><?=$value?></span>
                    <?php else:?>
                      <?=$contact_status[$key]?> : <?=$value?>
                    <?php endif?>
                    </td>
                    <?php endif?>
										<?php endforeach?>
									</tr>
								</table>
							</div>
						</div>
					</div>
				<?php endforeach?>
			<?php endif?>
		<?php endif?>
    </div>
		
		<div class="col-md-12">
			<!-- information -->
			<h5><?=TXT_INDEX_MSG_LOGIN_DATETIME($_SESSION[$session_key]['user']['login_time'])?></h5>
			<?php if ($_SESSION[$session_key]['user']['role'] == 2):?>
				<p><?=TXT_INDEX_MSG_LOGINASSITEADMIN?></p>
			<?php endif?>
			<?php if ($_SESSION[$session_key]['user']['role'] == 1):?>
				<p><?=TXT_INDEX_MSG_LOGINASSYSTEMADMIN?></p>
			<?php endif?>
			<div class="packageInfo">
				<div class="ly_packageInfo-logoWrapper">
					<a href="https://classic.postease.org" target="_blank">POSTEASE</a> ver <?=$_SESSION[$session_key]['configs']['postease_version']?> <?=$postease_license_ja[$_SESSION[$session_key]['license']['type']]?>
				</div>
				<?php if ($_SESSION[$session_key]['user']['role'] == 1):?>
					<span class="aboutSystem"><a href="./?view_page=about_system"><i class="fa fa-info-circle" aria-hidden="true"></i><?=TXT_INDEX_MSG_ABOUTSYSTEM?></a></span>
				<?php endif?>
			</div>
		</div>
		<input type="hidden" id="host_activation" value="<?=$_SESSION[$session_key]['configs']['host_activation']?>">
		<input type="hidden" id="this_postease_version" value="<?=$_SESSION[$session_key]['configs']['postease_version']?>">
		<input type="hidden" id="update_allowed_role" value="<?=$update_allowed_role?>">
    <input type="hidden" id="this_domain" value="<?=$this_domain?>">
    <input type="hidden" id="check_domain" value="<?=$check_domain?>">
    <input type="hidden" id="this_dir_name" value="<?=$this_dir_name?>">
    <input type="hidden" id="check_dir_name" value="<?=$check_dir_name?>">
    <input type="hidden" id="update_allowed_role" value="<?=$update_allowed_role?>">
		<input type="hidden" id="allow_update_flg" value="<?=$_SESSION[$session_key]['configs']['allow_update_flg']?>">
		<input type="hidden" id="language" value="<?=$_SESSION[$session_key]['configs']['language']?>">
		<input type="hidden" id="this_ip" value="<?=$_SERVER["REMOTE_ADDR"]?>">
    <input type="hidden" id="this_classification" value="<?=$_SESSION[$session_key]['license']['classification']?>">
		<input type="hidden" id="check_update_level" value="<?=$_SESSION[$session_key]['configs']['update_level']?>">
	</div>
</main>