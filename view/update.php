<!-- MAIN CONTENTS -->
<main id="content" class="col-md-10">
	
	<!-- MAIN CONTENTS -->
	<div class="slow-show">
		
		<p id="update_process_msg"><p>
		<div class="progress" id="update_progress_bar">
			<div id="progress_bar" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				<span class="sr-only">0% Complete (success)</span>
			</div>
		</div>
		
		<input type="hidden" id="update_allowed_role" value="<?=$update_allowed_role?>">
		<input type="hidden" id="update_mode" value="<?=$update_mode?>">
		<input type="hidden" id="host_activation" value="<?=$_SESSION[$session_key]['configs']['host_activation']?>">
		<input type="hidden" id="host_update" value="<?=$_SESSION[$session_key]['configs']['host_update']?>">
		<input type="hidden" id="this_postease_version" value="<?=$_SESSION[$session_key]['configs']['postease_version']?>">
		<input type="hidden" id="this_classification" value="<?=$_SESSION[$session_key]['license']['classification']?>">
		<input type="hidden" id="this_ip" value="<?=$_SERVER["REMOTE_ADDR"]?>">
		<input type="hidden" id="language" value="<?=$_SESSION[$session_key]['configs']['language']?>">
		<input type="hidden" id="allow_update_flg" value="<?=$_SESSION[$session_key]['configs']['allow_update_flg']?>">
		<input type="hidden" id="auto_update_flg" value="<?=$auto_update_flg?>">
		<input type="hidden" id="check_update_level" value="<?=$check_update_level?>">
	
	</div>
</main>