<?php

ini_set('display_errors', 0);
ini_set('error_reporting', -1);

$config = include 'config/config.php';
//TODO switch to array
extract($config, EXTR_OVERWRITE);

include 'include/utils.php';

if ($_SESSION['RF']["verify"] != "RESPONSIVEfilemanager")
{
	response('forbiden', 403)->send();
	exit;
}

$lang_files = rf_language_files();
if (isset($_SESSION['RF']['language']) && isset($lang_files[$_SESSION['RF']['language']])) {
	require_once $lang_files[$_SESSION['RF']['language']];
} else {
	response('Language file is missing!', 500)->send();
	exit;
}

$relative_path = isset($_POST['path']) ? $_POST['path'] : null;
$execute_action = isset($_GET['action']) && is_string($_GET['action']) ? $_GET['action'] : '';
$allow_missing_path = in_array($execute_action, array('create_folder', 'create_file'), true);
$allow_root = $execute_action === 'paste_clipboard';
$path = rf_resolve_path($current_path, $relative_path, $allow_missing_path, $allow_root);
$path_thumb = rf_resolve_path($thumbs_base_path, $relative_path, true, $allow_root);
if ($path === false || $path_thumb === false) {
	response('wrong path', 400)->send();
	exit;
}
// Preserve the configured relative roots used by derived-image mappings.
$path = $current_path . $relative_path;
$path_thumb = $thumbs_base_path . $relative_path;
if (isset($_POST['name']))
{
    if (!is_string($_POST['name'])) { response('wrong name', 400)->send(); exit; }
    $name = fix_filename($_POST['name'],$transliteration,$convert_spaces, $replace_with);
    if (in_array(isset($_GET['action']) ? $_GET['action'] : '', array('rename_file', 'duplicate_file'), true)) {
        // Stored file stems keep a single extension and no HTML-significant characters. A name that would be
        // altered is refused so the dialog never shows a name that differs from the stored file.
        if (rf_clean_name_stem($name, $convert_spaces, $replace_with) !== $_POST['name']) { response('wrong name', 400)->send(); exit; }
    }
    if (strpos($name,'../') !== FALSE)
	{
		response('wrong name', 400)->send();
		exit;
	}
}

// Validate every linked source and destination before the first filesystem change.
$operation = isset($_GET['action']) ? $_GET['action'] : '';
$linked_paths = array($path, $path_thumb);
if ($fixed_image_creation && in_array($operation, array('delete_file', 'delete_folder', 'rename_file', 'rename_folder', 'duplicate_file'), true)) {
    $relative_info = pathinfo(rtrim($relative_path, '/'));
    foreach ($fixed_path_from_filemanager as $k => $derived_root) {
        $derived_relative = $relative_path;
        if (in_array($operation, array('delete_file', 'rename_file', 'duplicate_file'), true)) {
            $parent = $relative_info['dirname'] === '.' ? '' : $relative_info['dirname'] . '/';
            $derived_relative = $parent . $fixed_image_creation_name_to_prepend[$k] . $relative_info['filename']
                . $fixed_image_creation_to_append[$k] . '.' . $relative_info['extension'];
        }
        $linked_paths[] = rtrim($derived_root, '/') . '/' . $derived_relative;
    }
}
if ($relative_image_creation && $operation === 'delete_file') {
    $relative_info = pathinfo($path);
    foreach ($relative_path_from_current_pos as $k => $relative_dir) {
        $linked_paths[] = $relative_info['dirname'] . '/' . ($relative_dir === '' ? '' : rtrim($relative_dir, '/') . '/')
            . $relative_image_creation_name_to_prepend[$k] . $relative_info['filename']
            . $relative_image_creation_name_to_append[$k] . '.' . $relative_info['extension'];
    }
}
foreach ($linked_paths as $linked_path) {
    if (rf_safe_upload_target($linked_path) === false
        || (in_array($operation, array('delete_folder', 'rename_folder', 'chmod'), true) && !rf_tree_has_no_links($linked_path))) {
        response('Unsafe file path', 400)->send(); exit;
    }
    if (isset($name) && in_array($operation, array('rename_file', 'rename_folder', 'duplicate_file'), true)) {
        $linked_info = pathinfo(rtrim($linked_path, '/'));
        $new_name = $operation === 'rename_folder' ? str_replace('.', '', $name) : $name . '.' . $linked_info['extension'];
        $new_path = $linked_info['dirname'] . '/' . $new_name;
        if (rf_safe_upload_target($new_path) === false || file_exists($new_path) || is_link($new_path)) {
            response('Unsafe or existing destination', 400)->send(); exit;
        }
    }
}

$info = pathinfo($path);

// fix code for php 5.1
if (empty($info['filename']))
{
	if (! empty($info['extension']))
	{
		$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
	}
	else {
		$info['filename'] = $info['basename'];
	}
}

if (empty($info['filename'])) $info['filename'] = $info['basename']; // fix code for php 5.1
if (isset($info['extension']) && !(isset($_GET['action']) && $_GET['action']=='delete_folder') && !in_array(strtolower($info['extension']), $ext) && $_GET['action'] != 'create_file')
{
	response('wrong extension', 400)->send();
	exit;
}

if (isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case 'delete_file':
            if ($delete_files){
                unlink($path);
                if (file_exists($path_thumb)) unlink($path_thumb);

                $info = pathinfo($path);

                // fix code for php 5.1
                if (empty($info['filename']))
                {
                	if (! empty($info['extension']))
                	{
                		$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
                	}
                	else {
                		$info['filename'] = $info['basename'];
                	}
                }

                if ($relative_image_creation){
                    foreach($relative_path_from_current_pos as $k=>$path)
                    {
                        if ($path!="" && $path[strlen($path)-1]!="/") $path.="/";

                        if (file_exists($info['dirname']."/".$path.$relative_image_creation_name_to_prepend[$k].$info['filename'].$relative_image_creation_name_to_append[$k].".".$info['extension']))
                        {
                            unlink($info['dirname']."/".$path.$relative_image_creation_name_to_prepend[$k].$info['filename'].$relative_image_creation_name_to_append[$k].".".$info['extension']);
                        }
                    }
                }

                if (! empty($fixed_image_creation))
                {
                    foreach($fixed_path_from_filemanager as $k=>$path)
                    {
                        if ($path!="" && $path[strlen($path)-1] != "/") $path.="/";

                        $base_dir=$path.substr_replace($info['dirname']."/", '', 0, strlen($current_path));
                        if (file_exists($base_dir.$fixed_image_creation_name_to_prepend[$k].$info['filename'].$fixed_image_creation_to_append[$k].".".$info['extension']))
                        {
                            unlink($base_dir.$fixed_image_creation_name_to_prepend[$k].$info['filename'].$fixed_image_creation_to_append[$k].".".$info['extension']);
                        }
                    }
                }
            }
            break;
        case 'delete_folder':
            if ($delete_folders){
                if (is_dir($path_thumb))
                {
                    deleteDir($path_thumb);
                }

                if (is_dir($path))
                {
                    deleteDir($path);
                    if ($fixed_image_creation)
                    {
                        foreach($fixed_path_from_filemanager as $k=>$paths){
                            if ($paths!="" && $paths[strlen($paths)-1] != "/") $paths.="/";

                            $base_dir=$paths.substr_replace($path, '', 0, strlen($current_path));
                            if (is_dir($base_dir)) deleteDir($base_dir);
                        }
                    }
                }
            }
            break;
        case 'create_folder':
            if ($create_folders)
            {
                create_folder(fix_path($path,$transliteration,$convert_spaces, $replace_with),fix_path($path_thumb,$transliteration,$convert_spaces, $replace_with));
            }
            break;
        case 'rename_folder':
            if ($rename_folders){
                $name=fix_filename($name,$transliteration,$convert_spaces, $replace_with);
                $name=str_replace('.','',$name);

                if (!empty($name)){
                    if (!rename_folder($path,$name,$transliteration,$convert_spaces))
					{
						response(trans('Rename_existing_folder'), 403)->send();
						exit;
					}

                    rename_folder($path_thumb,$name,$transliteration,$convert_spaces);
                    if ($fixed_image_creation){
                        foreach($fixed_path_from_filemanager as $k=>$paths){
                            if ($paths!="" && $paths[strlen($paths)-1] != "/") $paths.="/";

                            $base_dir=$paths.substr_replace($path, '', 0, strlen($current_path));
                            rename_folder($base_dir,$name,$transliteration,$convert_spaces);
                        }
                    }
                }
                else {
                    response(trans('Empty_name'), 400)->send();
					exit;
                }
            }
            break;
        case 'create_file':
            if ($create_text_files === FALSE) {
                response(sprintf(trans('File_Open_Edit_Not_Allowed'), strtolower(trans('Edit'))), 403)->send();
				exit;
            }

            if (!isset($editable_text_file_exts) || !is_array($editable_text_file_exts)){
                $editable_text_file_exts = array();
            }

            // check if user supplied extension
            if (strpos($name, '.') === FALSE){
                response(trans('No_Extension').' '.sprintf(trans('Valid_Extensions'), implode(', ', $editable_text_file_exts)), 400)->send();
				exit;
            }

            // correct name
            $old_name = $name;
            $name=fix_filename($name,$transliteration,$convert_spaces, $replace_with);
            if (empty($name))
            {
                response(trans('Empty_name'), 400)->send();
				exit;
            }

            // check extension
            $parts = explode('.', $name);
            if (!in_array(end($parts), $editable_text_file_exts)) {
                response(trans('Error_extension').' '.sprintf(trans('Valid_Extensions'), implode(', ', $editable_text_file_exts)), 400)->send();
				exit;
            }

            // correct paths
            $path = dirname($path) . '/' . $name;
            $path_thumb = dirname($path_thumb) . '/' . $name;
            if (rf_safe_upload_target($path) === false || rf_safe_upload_target($path_thumb) === false) {
                response('wrong path', 400)->send(); exit;
            }

            // file already exists
            if (file_exists($path)) {
                response(trans('Rename_existing_file'), 403)->send();
				exit;
            }

            $content = $_POST['new_content'];

            if (@file_put_contents($path, $content) === FALSE) {
                response(trans('File_Save_Error'), 500)->send();
				exit;
            }
            else {
                if (is_function_callable('chmod') !== FALSE){
                    chmod($path, 0644);
                }
                response(trans('File_Save_OK'))->send();
				exit;
            }

            break;
        case 'rename_file':
            if ($rename_files){
                $name=fix_filename($name,$transliteration,$convert_spaces, $replace_with);
                if (!empty($name))
                {
                    if (!rename_file($path,$name,$transliteration))
					{
						response(trans('Rename_existing_file'), 403)->send();
						exit;
					}

                    rename_file($path_thumb,$name,$transliteration);

                    if ($fixed_image_creation)
                    {
                        $info=pathinfo($path);

                        // fix code for php 5.1
                        if (empty($info['filename']))
                        {
                        	if (! empty($info['extension']))
                        	{
                        		$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
                        	}
                        	else {
                        		$info['filename'] = $info['basename'];
                        	}
                        }

                        foreach($fixed_path_from_filemanager as $k=>$paths)
                        {
                            if ($paths!="" && $paths[strlen($paths)-1] != "/") $paths.="/";

                            $base_dir = $paths.substr_replace($info['dirname']."/", '', 0, strlen($current_path));
                            if (file_exists($base_dir.$fixed_image_creation_name_to_prepend[$k].$info['filename'].$fixed_image_creation_to_append[$k].".".$info['extension']))
                            {
                                rename_file($base_dir.$fixed_image_creation_name_to_prepend[$k].$info['filename'].$fixed_image_creation_to_append[$k].".".$info['extension'],$fixed_image_creation_name_to_prepend[$k].$name.$fixed_image_creation_to_append[$k],$transliteration);
                            }
                        }
                    }
                }
                else {
                    response(trans('Empty_name'), 400)->send();
					exit;
                }
            }
            break;
        case 'duplicate_file':
            if ($duplicate_files)
            {
                $name=fix_filename($name,$transliteration,$convert_spaces, $replace_with);
                if (!empty($name))
                {
                    if (!duplicate_file($path,$name))
					{
						response(trans('Rename_existing_file'), 403)->send();
						exit;
					}

                    duplicate_file($path_thumb,$name);

                    if ($fixed_image_creation)
                    {
                        $info=pathinfo($path);

                        // fix code for php 5.1
                        if (empty($info['filename']))
                        {
                        	if (! empty($info['extension']))
                        	{
                        		$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
                        	}
                        	else {
                        		$info['filename'] = $info['basename'];
                        	}
                        }

                        foreach($fixed_path_from_filemanager as $k=>$paths)
                        {
                            if ($paths!="" && $paths[strlen($paths)-1] != "/") $paths.= "/";

                            $base_dir=$paths.substr_replace($info['dirname']."/", '', 0, strlen($current_path));

                            if (file_exists($base_dir.$fixed_image_creation_name_to_prepend[$k].$info['filename'].$fixed_image_creation_to_append[$k].".".$info['extension']))
                            {
                                duplicate_file($base_dir.$fixed_image_creation_name_to_prepend[$k].$info['filename'].$fixed_image_creation_to_append[$k].".".$info['extension'],$fixed_image_creation_name_to_prepend[$k].$name.$fixed_image_creation_to_append[$k]);
                            }
                        }
                    }
                }
                else
                {
                    response(trans('Empty_name'), 400)->send();
					exit;
                }
            }
            break;
        case 'paste_clipboard':
            if ( ! isset($_SESSION['RF']['clipboard_action'], $_SESSION['RF']['clipboard']['path'])
                || $_SESSION['RF']['clipboard_action'] == ''
                || $_SESSION['RF']['clipboard']['path'] == '')
            {
                response()->send();
				exit;
            }

            $action = $_SESSION['RF']['clipboard_action'];
            $data = $_SESSION['RF']['clipboard'];
            $clipboard_relative = isset($data['path']) ? $data['path'] : null;
            $data['path'] = rf_resolve_path($current_path, $clipboard_relative, false, false);
            $data['path_thumb'] = rf_resolve_path($thumbs_base_path, $clipboard_relative, true, false);
            if ($data['path'] === false || $data['path_thumb'] === false) {
                response('wrong clipboard path', 400)->send();
                exit;
            }
            if (!is_dir($path)) { response('Invalid destination folder', 400)->send(); exit; }
            $data['path'] = $current_path . $clipboard_relative;
            $data['path_thumb'] = $thumbs_base_path . $clipboard_relative;
            $pinfo = pathinfo($data['path']);

            // fix code for php 5.1
            if (empty($pinfo['filename']))
            {
            	if (! empty($pinfo['extension']))
            	{
            		$pinfo['filename'] = str_replace('.'.$pinfo['extension'], '', $pinfo['basename']);
            	}
            	else {
            		$pinfo['filename'] = $pinfo['basename'];
            	}
            }

            // user wants to paste to the same dir. nothing to do here...
            if ($pinfo['dirname'] == rtrim($path, '/')) {
                response()->send();
				exit;
            }

            // user wants to paste folder to it's own sub folder.. baaaah.
            if (is_dir($data['path']) && strpos($path, $data['path']) !== FALSE){
                response()->send();
				exit;
            }

            // something terribly gone wrong
            if ($action != 'copy' && $action != 'cut'){
                response('no action', 400)->send();
				exit;
            }

            // Recheck the current feature policy, not the policy at clipboard creation.
            if (!rf_tree_has_no_links($data['path']) || !rf_tree_has_no_links($data['path_thumb'])) {
                response('Unsafe clipboard source', 400)->send(); exit;
            }
            $clipboard_is_dir = is_dir($data['path']);
            if (!rf_tree_has_no_links($data['path']) || !rf_tree_has_no_links($data['path_thumb'])) {
                response('Symbolic links are not supported', 400)->send(); exit;
            }
            if (($clipboard_is_dir && !$copy_cut_dirs) || (!$clipboard_is_dir && !$copy_cut_files)) {
                response('Copy/cut disabled', 403)->send();
                exit;
            }
            if ($clipboard_is_dir && is_int($copy_cut_max_size)
                && foldersize($data['path']) > $copy_cut_max_size * 1024 * 1024) {
                response('Copy/cut size limit', 400)->send();
                exit;
            }
            if ($clipboard_is_dir && is_int($copy_cut_max_count)
                && filescount($data['path']) > $copy_cut_max_count) {
                response('Copy/cut count limit', 400)->send();
                exit;
            }

            if (!is_dir($path_thumb)) create_folder(false, $path_thumb);

            // check for writability
            if (is_really_writable($path) === FALSE || is_really_writable($path_thumb) === FALSE){
                response(trans('Dir_No_Write').'<br/>'.str_replace('../','',$path).'<br/>'.str_replace('../','',$path_thumb), 403)->send();
				exit;
            }

            // check if server disables copy or rename
            if (is_function_callable(($action == 'copy' ? 'copy' : 'rename')) === FALSE){
                response(sprintf(trans('Function_Disabled'), ($action == 'copy' ? lcfirst(trans('Copy')) : lcfirst(trans('Cut')))), 403)->send();
				exit;
            }

            if ($action == 'copy')
            {
                if (!rf_tree_can_copy($data['path'], $path) || !rf_tree_can_copy($data['path_thumb'], $path_thumb)) {
                    response('Unsafe source or existing destination', 400)->send(); exit;
                }
                rcopy($data['path'], $path);
                rcopy($data['path_thumb'], $path_thumb);
            }
            elseif ($action == 'cut')
            {
                if (!rf_tree_can_copy($data['path'], $path) || !rf_tree_can_copy($data['path_thumb'], $path_thumb)) {
                    response('Unsafe source or existing destination', 400)->send(); exit;
                }
                rrename($data['path'], $path);
                rrename($data['path_thumb'], $path_thumb);

                // cleanup
                if (is_dir($data['path']) === TRUE){
                    rrename_after_cleaner($data['path']);
                    if (is_dir($data['path_thumb'])) rrename_after_cleaner($data['path_thumb']);
                }
            }

            // cleanup
            $_SESSION['RF']['clipboard']['path'] = NULL;
            $_SESSION['RF']['clipboard']['path_thumb'] = NULL;
            $_SESSION['RF']['clipboard_action'] = NULL;

            break;
        case 'chmod':
            $mode = isset($_POST['new_mode']) ? $_POST['new_mode'] : null;
            $rec_option = isset($_POST['is_recursive']) ? $_POST['is_recursive'] : null;
            if (!is_string($mode) || !is_string($rec_option)) { response('wrong option', 400)->send(); exit; }
            $valid_options = array('none', 'files', 'folders', 'both');
            $chmod_perm = (is_dir($path) ? $chmod_dirs : $chmod_files);

            // check perm
            if ($chmod_perm === FALSE
                || (is_dir($path) && !$chmod_files && in_array($rec_option, array('files', 'both'), true))
                || (is_dir($path) && !$chmod_dirs && in_array($rec_option, array('folders', 'both'), true))) {
                response(sprintf(trans('File_Permission_Not_Allowed'), (is_dir($path) ? lcfirst(trans('Folders')) : lcfirst(trans('Files')) )), 403)->send();
				exit;
            }

            // check mode
            if (!preg_match("/^[0-7]{3}$/", $mode)){
                response(trans('File_Permission_Wrong_Mode'), 400)->send();
				exit;
            }

            // check recursive option
            if (!in_array($rec_option, $valid_options)){
                response("wrong option", 400)->send();
				exit;
            }

            // check if server disabled chmod
            if (is_function_callable('chmod') === FALSE){
                response(sprintf(trans('Function_Disabled'), 'chmod'), 403)->send();
				exit;
            }

            $mode = "0".$mode;
            $mode = octdec($mode);

            rchmod($path, $mode, $rec_option);

            break;
        case 'save_text_file':
            $content = $_POST['new_content'];
            // $content = htmlspecialchars($content); not needed
            // $content = stripslashes($content);

            // no file
            if (!file_exists($path)) {
                response(trans('File_Not_Found'), 404)->send();
				exit;
            }

            // not writable or edit not allowed
            if (!is_writable($path) || $edit_text_files === FALSE) {
                response(sprintf(trans('File_Open_Edit_Not_Allowed'), strtolower(trans('Edit'))), 403)->send();
				exit;
            }

            if (@file_put_contents($path, $content) === FALSE) {
                response(trans('File_Save_Error'), 500)->send();
				exit;
            }
            else {
                response(trans('File_Save_OK'))->send();
				exit;
            }

            break;
        default:
            response('wrong action', 400)->send();
			exit;
    }
}
