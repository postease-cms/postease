<?php

$config = include 'config/config.php';
//TODO switch to array
extract($config, EXTR_OVERWRITE);

include 'include/utils.php';

if ($_SESSION['RF']["verify"] != "RESPONSIVEfilemanager")
{
	response('forbiden', 403)->send();
	exit;
}

 $language_files = rf_language_files();
if (isset($_SESSION['RF']['language']) && isset($language_files[$_SESSION['RF']['language']])) {
	include $language_files[$_SESSION['RF']['language']];
} else {
	response('Language file is missing!', 500)->send();
	exit;
}

if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
		case 'view':
		    if(isset($_GET['type']))
			{
				$_SESSION['RF']["view_type"] = $_GET['type'];
			}
			else
			{
				response('view type number missing', 400)->send();
				exit;
			}
			break;
		case 'filter':
			if (isset($_GET['type']))
			{
				if (isset($remember_text_filter) && $remember_text_filter)
				{
					$_SESSION['RF']["filter"] = $_GET['type'];
				}
			}
			else {
				response('view type number missing', 400);
				exit;
			}
			break;
		case 'sort':
			if (isset($_GET['sort_by']))
			{
				$_SESSION['RF']["sort_by"] = $_GET['sort_by'];
			}

			if (isset($_GET['descending']))
			{
				$_SESSION['RF']["descending"] = $_GET['descending'] === "TRUE";
			}
			break;
		case 'image_size': // not used
			$image_input = isset($_POST['path']) && is_string($_POST['path']) ? $_POST['path'] : '';
			if (strpos($image_input, $upload_dir) === 0)
			{
				$image_relative = substr($image_input, strlen($upload_dir));
				$image_path = rf_resolve_path($current_path, $image_relative, false, false);
				if ($image_path === false || !is_file($image_path)) { response('wrong path', 400)->send(); exit; }
				$info = getimagesize($image_path);
				response($info)->send();
				exit;
			}
			break;
		case 'save_img':
            if (!$upload_files) { http_response_code(403); exit('Upload disabled'); }
			if (!isset($_POST['name'], $_POST['url']) || !is_string($_POST['name']) || !is_string($_POST['url'])) { response('wrong data', 400)->send(); exit; }
			$save_dir = rf_resolve_path($current_path, isset($_POST['path']) ? $_POST['path'] : null, false, true);
			$save_thumb_dir = rf_resolve_path($thumbs_base_path, isset($_POST['path']) ? $_POST['path'] : null, true, true);
			if ($save_dir === false || $save_thumb_dir === false) { response('wrong path', 400)->send(); exit; }
			$info = pathinfo($_POST['name']);

			if (
				strpos($_POST['url'], 'http://s3.amazonaws.com/feather') !== 0
				|| $_POST['name'] != fix_filename($_POST['name'], $transliteration, $convert_spaces, $replace_with)
				|| ! in_array(strtolower($info['extension']), array( 'jpg', 'jpeg', 'png' ))
			)
			{
				response('wrong data', 400)->send();
				exit;
			}
			$save_file = rf_resolve_path($current_path, ($_POST['path'] === '' ? '' : rtrim($_POST['path'], '/') . '/') . $_POST['name'], true, false);
			$save_thumb = rf_resolve_path($thumbs_base_path, ($_POST['path'] === '' ? '' : rtrim($_POST['path'], '/') . '/') . $_POST['name'], true, false);
			if ($save_file === false || $save_thumb === false) { response('wrong path', 400)->send(); exit; }
			$image_data = file_get_contents($_POST['url']);
			if ($image_data === false)
			{
				response(trans('Aviary_No_Save'), 400)->send();
				exit;
			}
			$fp = fopen($save_file, "w");
			fwrite($fp, $image_data);
			fclose($fp);

		    create_img($save_file, $save_thumb, 122, 91);
		    // TODO something with this function cause its blowing my mind
		    new_thumbnails_creation(
				rtrim($current_path . $_POST['path'], '/') . '/',
				$save_file,
				$_POST['name'],
				$current_path,
				$relative_image_creation,
				$relative_path_from_current_pos,
				$relative_image_creation_name_to_prepend,
				$relative_image_creation_name_to_append,
				$relative_image_creation_width,
				$relative_image_creation_height,
				$relative_image_creation_option,
				$fixed_image_creation,
				$fixed_path_from_filemanager,
				$fixed_image_creation_name_to_prepend,
				$fixed_image_creation_to_append,
				$fixed_image_creation_width,
				$fixed_image_creation_height,
				$fixed_image_creation_option
			);
		    break;
		case 'extract':
            if (!$upload_files || !$create_folders) { http_response_code(403); exit('Extraction disabled'); }
			$path = rf_resolve_path($current_path, isset($_POST['path']) ? $_POST['path'] : null, false, false);
			if ($path === false || !is_file($path)) { response('wrong path', 400)->send(); exit; }
			$info = pathinfo($path);
			$archive_relative = $_POST['path'];
			$base_relative = dirname($archive_relative);
			if ($base_relative === '.') $base_relative = '';
			$base_folder = rf_resolve_path($current_path, $base_relative, false, true);
			if ($base_folder === false) { response('wrong path', 400)->send(); exit; }

			switch ($info['extension'])
			{
				case "zip":
					$zip = new ZipArchive;
					if ($zip->open($path) === true)
					{
						$entries = rf_validate_zip_entries($zip, $base_folder);
						$blocked = ($entries === false);
						if ($blocked) { $zip->close(); response('Unsafe archive entry or extraction target', 400)->send(); exit; }
						foreach ($entries as &$entry) {
							$entry['allowed'] = $entry['dir'] || in_array(strtolower(pathinfo($entry['relative'], PATHINFO_EXTENSION)), $ext, true);
						}
						unset($entry);
						if ($blocked) { $zip->close(); response('Unsafe archive entry or extraction target', 400)->send(); exit; }
						foreach ($entries as $entry)
						{
							if (!$entry['allowed']) continue;
							$target = rf_resolve_path($base_folder, $entry['relative'], true, false);
							if ($entry['dir']) { if (!is_dir($target) && !mkdir($target, $permission, true)) { $blocked = true; break; } }
							else {
								$parent = dirname($target);
								if (!is_dir($parent) && !mkdir($parent, $permission, true)) { $blocked = true; break; }
								$stream = $zip->getStream($entry['name']);
								$out = fopen($target, 'xb');
								if (!$stream || !$out) { if (is_resource($stream)) fclose($stream); $blocked = true; break; }
								while (!feof($stream)) { $chunk = fread($stream, 8192); if ($chunk === false || fwrite($out, $chunk) !== strlen($chunk)) { $blocked = true; break; } }
								fclose($stream); fclose($out); if ($blocked) break;
							}
						}
						$zip->close();
						if ($blocked) { response('Unsafe archive entry or extraction target', 400)->send(); exit; }
					}
					else
					{
						response(trans('Zip_No_Extract'), 500)->send();
						exit;
					}

					break;

				case "gz":
				case "tar":
					response('TAR and GZ extraction is disabled because entry paths cannot be validated safely.', 415)->send();
					exit;

				default:
					response(trans('Zip_Invalid'), 400)->send();
					exit;
			}
			break;
		case 'media_preview':
			$raw_file = isset($_GET['file']) ? $_GET['file'] : '';
			if (!is_string($raw_file) || strpos($raw_file, $current_path) !== 0) { response('wrong path', 400)->send(); exit; }
			$preview_relative = substr($raw_file, strlen($current_path));
			$preview_real = rf_resolve_path($current_path, $preview_relative, false, false);
			if ($preview_real === false || !is_file($preview_real)) { response('File not found', 404)->send(); exit; }
			$preview_file = $current_path . $preview_relative;
			$info = pathinfo($preview_file);
			ob_start();
			?>
			<div id="jp_container_1" class="jp-video " style="margin:0 auto;">
			    <div class="jp-type-single">
			      <div id="jquery_jplayer_1" class="jp-jplayer"></div>
			      <div class="jp-gui">
			        <div class="jp-video-play">
			          <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
			        </div>
			        <div class="jp-interface">
			          <div class="jp-progress">
			            <div class="jp-seek-bar">
			              <div class="jp-play-bar"></div>
			            </div>
			          </div>
			          <div class="jp-current-time"></div>
			          <div class="jp-duration"></div>
			          <div class="jp-controls-holder">
			            <ul class="jp-controls">
			              <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
			              <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
			              <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
			              <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
			              <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
			              <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
			            </ul>
			            <div class="jp-volume-bar">
			              <div class="jp-volume-bar-value"></div>
			            </div>
			            <ul class="jp-toggles">
			              <li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
			              <li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
			              <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
			              <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
			            </ul>
			          </div>
			          <div class="jp-title" style="display:none;">
			            <ul>
			              <li></li>
			            </ul>
			          </div>
			        </div>
			      </div>
			      <div class="jp-no-solution">
			        <span>Update Required</span>
			        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
			      </div>
			    </div>
			  </div>
			<?php if(in_array(strtolower($info['extension']), $ext_music)): ?>

				<script type="text/javascript">
				    $(document).ready(function(){

				      $("#jquery_jplayer_1").jPlayer({
				        ready: function () {
				          $(this).jPlayer("setMedia", {
					    title:"<?php $_GET['title']; ?>",
				            mp3: "<?php echo $preview_file; ?>",
				            m4a: "<?php echo $preview_file; ?>",
					    oga: "<?php echo $preview_file; ?>",
				            wav: "<?php echo $preview_file; ?>"
				          });
				        },
				        swfPath: "js",
					solution:"html,flash",
				        supplied: "mp3, m4a, midi, mid, oga,webma, ogg, wav",
					smoothPlayBar: true,
					keyEnabled: false
				      });
				    });
				  </script>

			<?php elseif(in_array(strtolower($info['extension']), $ext_video)):	?>

			    <script type="text/javascript">
			    $(document).ready(function(){

			      $("#jquery_jplayer_1").jPlayer({
			        ready: function () {
			          $(this).jPlayer("setMedia", {
				    title:"<?php $_GET['title']; ?>",
			            m4v: "<?php echo $preview_file; ?>",
			            ogv: "<?php echo $preview_file; ?>"
			          });
			        },
			        swfPath: "js",
				solution:"html,flash",
			        supplied: "mp4, m4v, ogv, flv, webmv, webm",
				smoothPlayBar: true,
				keyEnabled: false
			    });

			    });
			  </script>

			<?php endif;

			$content = ob_get_clean();

			response($content)->send();
			exit;

			break;
		case 'copy_cut':
			if ($_POST['sub_action'] != 'copy' && $_POST['sub_action'] != 'cut')
			{
				response('wrong sub-action', 400)->send();
				exit;
			}

			if (!isset($_POST['path']) || !is_string($_POST['path']) || trim($_POST['path']) == '')
			{
				response('no path', 400)->send();
				exit;
			}

			$path = rf_resolve_path($current_path, isset($_POST['path']) ? $_POST['path'] : null, false, false);
			$thumb_path = rf_resolve_path($thumbs_base_path, isset($_POST['path']) ? $_POST['path'] : null, true, false);
			if ($path === false || $thumb_path === false) { response('wrong path', 400)->send(); exit; }
			if (!rf_tree_has_no_links($path)) { response('Symbolic links are not supported', 400)->send(); exit; }

			if (is_dir($path))
			{
				// can't copy/cut dirs
				if ($copy_cut_dirs === false)
				{
					response(sprintf(trans('Copy_Cut_Not_Allowed'), ($_POST['sub_action'] == 'copy' ? lcfirst(trans('Copy')) : lcfirst(trans('Cut'))), trans('Folders')), 403)->send();
					exit;
				}

				// size over limit
				if ($copy_cut_max_size !== false && is_int($copy_cut_max_size))
				{
					if (($copy_cut_max_size * 1024 * 1024) < foldersize($path))
					{
						response(sprintf(trans('Copy_Cut_Size_Limit'), ($_POST['sub_action'] == 'copy' ? lcfirst(trans('Copy')) : lcfirst(trans('Cut'))), $copy_cut_max_size), 400)->send();
						exit;
					}
				}

				// file count over limit
				if ($copy_cut_max_count !== false && is_int($copy_cut_max_count))
				{
					if ($copy_cut_max_count < filescount($path))
					{
						response(sprintf(trans('Copy_Cut_Count_Limit'), ($_POST['sub_action'] == 'copy' ? lcfirst(trans('Copy')) : lcfirst(trans('Cut'))), $copy_cut_max_count), 400)->send();
						exit;
					}
				}
			}
			else
			{
				// can't copy/cut files
				if ($copy_cut_files === false)
				{
					response(sprintf(trans('Copy_Cut_Not_Allowed'), ($_POST['sub_action'] == 'copy' ? lcfirst(trans('Copy')) : lcfirst(trans('Cut'))), trans('Files')), 403)->send();
					exit;
				}
			}

			$_SESSION['RF']['clipboard']['path'] = $_POST['path'];
			$_SESSION['RF']['clipboard']['path_thumb'] = null;
			$_SESSION['RF']['clipboard_action'] = $_POST['sub_action'];
			break;
		case 'clear_clipboard':
			$_SESSION['RF']['clipboard'] = null;
			$_SESSION['RF']['clipboard_action'] = null;
			break;
		case 'chmod':
			$path = rf_resolve_path($current_path, isset($_POST['path']) ? $_POST['path'] : null, false, false);
			if ($path === false) { response('wrong path', 400)->send(); exit; }
			if (
				(is_dir($path) && $chmod_dirs === false)
				|| (is_file($path) && $chmod_files === false)
				|| (is_function_callable("chmod") === false) )
			{
				response(sprintf(trans('File_Permission_Not_Allowed'), (is_dir($path) ? lcfirst(trans('Folders')) : lcfirst(trans('Files'))), 403), 400)->send();
				exit;
			}
			else
			{
				$perm = decoct(fileperms($path) & 0777);
				$perm_user = substr($perm, 0, 1);
				$perm_group = substr($perm, 1, 1);
				$perm_all = substr($perm, 2, 1);

				$ret = '<div id="files_permission_start">
				<form id="chmod_form">
					<table class="file-perms-table">
						<thead>
							<tr>
								<td></td>
								<td>r&nbsp;&nbsp;</td>
								<td>w&nbsp;&nbsp;</td>
								<td>x&nbsp;&nbsp;</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>'.trans('User').'</td>
								<td><input id="u_4" type="checkbox" data-value="4" data-group="user" onChange="chmod_logic();"'.(chmod_logic_helper($perm_user, 4) ? " checked" : "").'></td>
								<td><input id="u_2" type="checkbox" data-value="2" data-group="user" onChange="chmod_logic();"'.(chmod_logic_helper($perm_user, 2) ? " checked" : "").'></td>
								<td><input id="u_1" type="checkbox" data-value="1" data-group="user" onChange="chmod_logic();"'.(chmod_logic_helper($perm_user, 1) ? " checked" : "").'></td>
							</tr>
							<tr>
								<td>'.trans('Group').'</td>
								<td><input id="g_4" type="checkbox" data-value="4" data-group="group" onChange="chmod_logic();"'.(chmod_logic_helper($perm_group, 4) ? " checked" : "").'></td>
								<td><input id="g_2" type="checkbox" data-value="2" data-group="group" onChange="chmod_logic();"'.(chmod_logic_helper($perm_group, 2) ? " checked" : "").'></td>
								<td><input id="g_1" type="checkbox" data-value="1" data-group="group" onChange="chmod_logic();"'.(chmod_logic_helper($perm_group, 1) ? " checked" : "").'></td>
							</tr>
							<tr>
								<td>'.trans('All').'</td>
								<td><input id="a_4" type="checkbox" data-value="4" data-group="all" onChange="chmod_logic();"'.(chmod_logic_helper($perm_all, 4) ? " checked" : "").'></td>
								<td><input id="a_2" type="checkbox" data-value="2" data-group="all" onChange="chmod_logic();"'.(chmod_logic_helper($perm_all, 2) ? " checked" : "").'></td>
								<td><input id="a_1" type="checkbox" data-value="1" data-group="all" onChange="chmod_logic();"'.(chmod_logic_helper($perm_all, 1) ? " checked" : "").'></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="3"><input type="text" name="chmod_value" id="chmod_value" value="'.$perm.'" data-def-value="'.$perm.'"></td>
							</tr>
						</tbody>
					</table>';

				if (is_dir($path))
				{
					$ret .= '<div>'.trans('File_Permission_Recursive').'
							<ul>
								<li><input value="none" name="apply_recursive" type="radio" checked> '.trans('No').'</li>
								<li><input value="files" name="apply_recursive" type="radio"> '.trans('Files').'</li>
								<li><input value="folders" name="apply_recursive" type="radio"> '.trans('Folders').'</li>
								<li><input value="both" name="apply_recursive" type="radio"> '.trans('Files').' & '.trans('Folders').'</li>
							</ul>
							</div>';
				}

				$ret .= '</form></div>';

				response($ret)->send();
				exit;
			}
			break;
		case 'get_lang':
				if ( ! file_exists('lang/languages.php'))
			{
				response(trans('Lang_Not_Found'), 404)->send();
				exit;
			}

			$languages = include 'lang/languages.php';
			if ( ! isset($languages) || ! is_array($languages))
			{
				response(trans('Lang_Not_Found'), 404)->send();
				exit;
			}

			$curr = $_SESSION['RF']['language'];

			$ret = '<select id="new_lang_select">';
			foreach ($languages as $code => $name)
			{
				$ret .= '<option value="' . $code . '"' . ($code == $curr ? ' selected' : '') . '>' . $name . '</option>';
			}
			$ret .= '</select>';

			response($ret)->send();
			exit;

			break;
		case 'change_lang':
			$language_files = rf_language_files();
			$choosen_lang = isset($_POST['choosen_lang']) ? $_POST['choosen_lang'] : null;

			if (!is_string($choosen_lang) || !isset($language_files[$choosen_lang]) || !is_readable($language_files[$choosen_lang]))
			{
				response(trans('Lang_Not_Found'), 404)->send();
				exit;
			}

			$_SESSION['RF']['language'] = $choosen_lang;
			$_SESSION['RF']['language_file'] = $language_files[$choosen_lang];

			break;
		case 'get_file': // preview or edit
			$sub_action = isset($_GET['sub_action']) && is_string($_GET['sub_action']) ? $_GET['sub_action'] : '';
			$preview_mode = isset($_GET['preview_mode']) && is_string($_GET['preview_mode']) ? $_GET['preview_mode'] : '';

			if ($sub_action != 'preview' && $sub_action != 'edit')
			{
				response("wrong action")->send();
				exit;
			}

			if ($sub_action == 'preview') {
				$raw_file = isset($_GET['file']) ? $_GET['file'] : '';
				if (!is_string($raw_file) || strpos($raw_file, $current_path) !== 0) { response('wrong path', 400)->send(); exit; }
				$selected_file = rf_resolve_path($current_path, substr($raw_file, strlen($current_path)), false, false);
			} else {
				$selected_file = rf_resolve_path($current_path, isset($_POST['path']) ? $_POST['path'] : null, false, false);
			}
			if ($selected_file === false || !is_file($selected_file)) { response(trans('File_Not_Found'), 404)->send(); exit; }
			$info = pathinfo($selected_file);

			if ( ! file_exists($selected_file))
			{
				response(trans('File_Not_Found'), 404)->send();
				exit;
			}

			if ($preview_mode == 'text')
			{
				$is_allowed = ($sub_action == 'preview' ? $preview_text_files : $edit_text_files);
				$allowed_file_exts = ($sub_action == 'preview' ? $previewable_text_file_exts : $editable_text_file_exts);
			}
			elseif ($preview_mode == 'viewerjs')
			{
				$is_allowed = $viewerjs_enabled;
				$allowed_file_exts = $viewerjs_file_exts;
			}
			elseif ($preview_mode == 'google')
			{
				$is_allowed = $googledoc_enabled;
				$allowed_file_exts = $googledoc_file_exts;
			}

			if ( ! isset($allowed_file_exts) || ! is_array($allowed_file_exts))
			{
				$allowed_file_exts = array();
			}

			if ( ! in_array($info['extension'], $allowed_file_exts)
				|| ! isset($is_allowed)
				|| $is_allowed === false
				|| ! is_readable($selected_file)
			)
			{
				response(sprintf(trans('File_Open_Edit_Not_Allowed'), ($sub_action == 'preview' ? strtolower(trans('Open')) : strtolower(trans('Edit')))), 403)->send();
				exit;
			}

			if ($sub_action == 'preview')
			{
				if ($preview_mode == 'text')
				{
					// get and sanities
					$data = stripslashes(htmlspecialchars(file_get_contents($selected_file)));

					$ret = '';

					if ( ! in_array($info['extension'],$previewable_text_file_exts_no_prettify))
					{
					$ret .= '<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?lang='.$info['extension'].'&skin=sunburst"></script>';
						$ret .= '<div class="text-center"><strong>'.$info['basename'].'</strong></div><pre class="prettyprint">'.$data.'</pre>';
					}
					else
					{
						$ret .= '<div class="text-center"><strong>'.$info['basename'].'</strong></div><pre class="no-prettify">'.$data.'</pre>';
					}

				}
				elseif ($preview_mode == 'viewerjs')
				{
					$ret = '<iframe id="viewer" src="js/ViewerJS/#../../'.$_GET["file"].'" allowfullscreen="" webkitallowfullscreen="" class="viewer-iframe"></iframe>';

				}
				elseif ($preview_mode == 'google')
				{
					$url_file = $base_url . $upload_dir . str_replace($current_path, '', $_GET["file"]);
					$googledoc_url = urlencode($url_file);
					$googledoc_html = "<iframe src=\"http://docs.google.com/viewer?url=" . $googledoc_url . "&embedded=true\" class=\"google-iframe\"></iframe>";
					$ret = '<div class="text-center"><strong>' . $info['basename'] . '</strong></div>' . $googledoc_html . '';
				}
			}
			else
			{
				$data = stripslashes(htmlspecialchars(file_get_contents($selected_file)));
				$ret = '<textarea id="textfile_edit_area" style="width:100%;height:300px;">'.$data.'</textarea>';
			}

			response($ret)->send();
			exit;

			break;
	    default: response('no action passed', 400)->send();
			exit;
    }
}
else
{
	response('no action passed', 400)->send();
	exit;
}
