<?php
// Set Configured permission by decimal number
if (!isset($session_key, $rf_context) || !is_string($session_key)) {
    http_response_code(403);
    exit('Authentication required');
}
$permission  = (! empty($_SESSION[$session_key]['configs']['upload_dir_permission'])) ? $_SESSION[$session_key]['configs']['upload_dir_permission'] : '777';
$permission  = octdec(sprintf('%04d', $permission));

if ($_SESSION['RF']["verify"] != "RESPONSIVEfilemanager")
{
	die('forbiden');
}

require dirname(__FILE__) . '/Response.php';

/** Return the fixed language id to server-side language file mapping. */
function rf_language_files()
{
	$ids = array('az_AZ', 'bg_BG', 'ca', 'cs', 'da', 'de', 'el_GR', 'en', 'en_EN', 'es', 'fa',
		'fr_FR', 'he_IL', 'hr', 'hu_HU', 'id', 'it', 'ja', 'lt', 'mn_MN', 'nb_NO', 'nl',
		'pl', 'pt_BR', 'pt_PT', 'ru', 'sk', 'sl', 'sv_SE', 'tr_TR', 'uk_UA', 'zh_CN');
	$files = array();
	foreach ($ids as $id) {
		$files[$id] = dirname(__DIR__) . '/lang/' . $id . '.php';
	}
	$files['he'] = dirname(__DIR__) . '/lang/he_IL.php';
	return $files;
}

/** Validate a decoded-once relative path and resolve it under an approved root. */
function rf_resolve_path($root, $relative, $allow_missing, $allow_root)
{
	if (!is_string($relative) || strpos($relative, "\0") !== false || strpos($relative, '\\') !== false
		|| preg_match('/^[\\\\\/]|^[A-Za-z][A-Za-z0-9+.-]*:/', $relative)
		|| preg_match('/%(?:2e|2f|5c|00)/i', $relative)) {
		return false;
	}
    // A configured root may itself have been replaced with a link in writable storage.
    $root_absolute = substr($root, 0, 1) === '/' ? $root : getcwd() . '/' . $root;
    $root_parts = array();
    foreach (explode('/', $root_absolute) as $part) {
        if ($part === '' || $part === '.') continue;
        if ($part === '..') array_pop($root_parts); else $root_parts[] = $part;
    }
    $root_absolute = '/' . implode('/', $root_parts);
    $upload_root = dirname(dirname(__DIR__)) . '/upload';
    if ($root_absolute === $upload_root || strpos($root_absolute, $upload_root . '/') === 0) {
        $cursor = $upload_root;
        if (is_link($cursor)) return false;
        $under_upload = substr($root_absolute, strlen($upload_root));
        foreach (explode('/', trim($under_upload, '/')) as $part) {
            if ($part === '') continue;
            $cursor .= '/' . $part;
            if (is_link($cursor)) return false;
        }
    }
	$root_real = realpath($root);
	if ($root_real === false || !is_dir($root_real)) return false;
	$trimmed = rtrim($relative, '/');
	if ($trimmed === '') return $allow_root ? $root_real : false;
	$parts = explode('/', $trimmed);
	foreach ($parts as $part) {
		if ($part === '' || $part === '.' || $part === '..') return false;
	}
	$cursor = $root_real;
	$missing_parent = false;
	foreach ($parts as $index => $part) {
		$cursor .= DIRECTORY_SEPARATOR . $part;
		if ($missing_parent) continue;
		if (is_link($cursor)) return false;
		if (file_exists($cursor)) {
			if ($index < count($parts) - 1 && !is_dir($cursor)) return false;
			$real = realpath($cursor);
			if ($real === false || ($real !== $root_real && strpos($real, $root_real . DIRECTORY_SEPARATOR) !== 0)) return false;
			$cursor = $real;
		} elseif (!$allow_missing) {
			return false;
		} else {
			$missing_parent = true;
		}
	}
	return $cursor;
}

/** Resolve configured upload/derivative paths without following writable links. */
function rf_safe_upload_target($path)
{
    $upload_root = dirname(dirname(__DIR__)) . '/upload';
    $absolute_prefix = $upload_root . '/';
    if (strpos($path, '../upload/') === 0) {
        $relative = substr($path, strlen('../upload/'));
    } elseif (strpos($path, $absolute_prefix) === 0) {
        $relative = substr($path, strlen($absolute_prefix));
    } else {
        return false;
    }
    return rf_resolve_path($upload_root, $relative, true, false);
}

function rf_relative_from_root($path, $root)
{
	$root_real = realpath($root);
	$path_real = realpath($path);
	if ($root_real === false || $path_real === false
		|| strpos($path_real, $root_real . DIRECTORY_SEPARATOR) !== 0) return false;
	return substr($path_real, strlen($root_real) + 1);
}

function rf_tree_has_no_links($path)
{
	if (is_link($path)) return false;
	if (!file_exists($path)) return true;
	if (!is_dir($path)) return is_file($path);
	$items = scandir($path);
	if ($items === false) return false;
	foreach ($items as $item) {
		if ($item !== '.' && $item !== '..' && !rf_tree_has_no_links($path . DIRECTORY_SEPARATOR . $item)) return false;
	}
	return true;
}

function rf_tree_can_copy($source, $destination)
{
	if (!file_exists($source) && !is_link($source)) return true;
	if (!rf_tree_has_no_links($source)) return false;
	if (is_dir($source)) {
		$target = rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($source);
		if (file_exists($target) || is_link($target)) return false;
		$items = scandir($source);
		if ($items === false) return false;
		foreach ($items as $item) {
			if ($item !== '.' && $item !== '..' && !rf_tree_can_copy($source . DIRECTORY_SEPARATOR . $item, $target)) return false;
		}
		return true;
	}
	$target = is_dir($destination) ? rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($source) : $destination;
	return !file_exists($target) && !is_link($target);
}

function rf_validate_zip_entries($zip, $destination_root)
{
	$entries = array();
	$seen = array();
	for ($i = 0; $i < $zip->numFiles; $i++) {
		$stat = $zip->statIndex($i);
		$name = isset($stat['name']) ? $stat['name'] : '';
		$is_dir = substr($name, -1) === '/';
		$relative = $is_dir ? rtrim($name, '/') : $name;
		$opsys = 0; $attributes = 0;
		if ($name === '' || strpos($name, '\\') !== false || strpos($name, "\0") !== false
			|| rf_resolve_path($destination_root, $relative, true, false) === false
			|| isset($seen[$relative])
			|| !$zip->getExternalAttributesIndex($i, $opsys, $attributes)) return false;
		$mode = ($attributes >> 16) & 0170000;
		if ($mode !== 0 && $mode !== 0100000 && $mode !== 0040000) return false;
		if (!$is_dir && $mode === 0040000) return false;
		$parts = explode('/', $relative);
		$prefix = '';
		foreach ($parts as $part) {
			$prefix = ($prefix === '' ? $part : $prefix . '/' . $part);
			if ($prefix !== $relative && isset($seen[$prefix]) && $seen[$prefix] === 'file') return false;
		}
		if (!$is_dir) {
			foreach ($seen as $seen_path => $type) {
				if (strpos($seen_path, $relative . '/') === 0) return false;
			}
		}
		$target = rf_resolve_path($destination_root, $relative, true, false);
		if ($target === false || file_exists($target) || is_link($target)) return false;
		$seen[$relative] = $is_dir ? 'dir' : 'file';
		$entries[] = array('name' => $name, 'relative' => $relative, 'dir' => $is_dir);
	}
	return $entries;
}

if ( ! function_exists('response'))
{
	/**
	 * Response construction helper
	 *
	 * @param string $content
	 * @param int    $statusCode
	 * @param array  $headers
	 *
	 * @return \Response|\Illuminate\Http\Response
	 */
	function response($content = '', $statusCode = 200, $headers = array())
	{
		$responseClass = class_exists('Illuminate\Http\Response') ? '\Illuminate\Http\Response' : 'Response';

		return new $responseClass($content, $statusCode, $headers);
	}
}

if ( ! function_exists('trans'))
{
	// language
	$language_files = rf_language_files();
	if (!isset($_SESSION['RF']['language']) || !is_string($_SESSION['RF']['language'])
		|| !isset($language_files[$_SESSION['RF']['language']])
		|| !isset($_SESSION['RF']['language_file'])
		|| $_SESSION['RF']['language_file'] !== $language_files[$_SESSION['RF']['language']]
		|| !is_readable($language_files[$_SESSION['RF']['language']]))
	{
		$lang = $default_language;

		if ($rf_can_maintain && isset($_GET['lang']) && is_string($_GET['lang']) && $_GET['lang'] != 'undefined' && $_GET['lang'] != '')
		{
			$candidate = trim(fix_get_params($_GET['lang']));
			if (isset($language_files[$candidate])) $lang = $candidate;
		}
		if (!isset($language_files[$lang])) $lang = isset($language_files[$default_language]) ? $default_language : 'en';
		$language_file = $language_files[$lang];

		// add lang file to session for easy include
		$_SESSION['RF']['language'] = $lang;
		$_SESSION['RF']['language_file'] = $language_file;
	}
	else
	{
		$lang = $_SESSION['RF']['language'];
		$language_file = $language_files[$lang];
	}

	$lang_vars = include $language_file;

	if ( ! is_array($lang_vars))
	{
		$lang_vars = array();
	}
	/**
	 * Translate language variable
	 *
	 * @param $var string name
	 *
	 * @return string translated variable
	 */
	function trans($var)
	{
		global $lang_vars;

		return (array_key_exists($var, $lang_vars)) ? $lang_vars[ $var ] : $var;
	}
}

/**
 * Delete directory
 *
 * @param  string  $dir
 *
 * @return  bool
 */
function deleteDir($dir)
{
	if (is_link($dir)) return unlink($dir);
	if ( ! file_exists($dir))
	{
		return true;
	}
	if ( ! is_dir($dir))
	{
		return unlink($dir);
	}
	foreach (scandir($dir) as $item)
	{
		if ($item == '.' || $item == '..')
		{
			continue;
		}
		$child = $dir . DIRECTORY_SEPARATOR . $item;
		if (is_link($child) ? !unlink($child) : !deleteDir($child))
		{
			return false;
		}
	}

	return rmdir($dir);
}

/**
 * Make a file copy
 *
 * @param  string  $old_path
 * @param  string  $name      New file name without extension
 *
 * @return  bool
 */
function duplicate_file($old_path, $name)
{
	if (file_exists($old_path))
	{
		$info = pathinfo($old_path);

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

		$new_path = $info['dirname'] . "/" . $name . "." . $info['extension'];
		if (rf_safe_upload_target($old_path) === false || rf_safe_upload_target($new_path) === false
            || file_exists($new_path) || is_link($new_path))
		{
			return false;
		}

		return copy($old_path, $new_path);
	}
}

/**
 * Rename file
 *
 * @param  string  $old_path         File to rename
 * @param  string  $name             New file name without extension
 * @param  bool    $transliteration
 *
 * @return bool
 */
function rename_file($old_path, $name, $transliteration)
{
	$name = fix_filename($name, $transliteration);
	if (file_exists($old_path))
	{
		$info = pathinfo($old_path);

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

		$new_path = $info['dirname'] . "/" . $name . "." . $info['extension'];
		if (rf_safe_upload_target($old_path) === false || rf_safe_upload_target($new_path) === false
            || file_exists($new_path) || is_link($new_path))
		{
			return false;
		}

		return rename($old_path, $new_path);
	}
}

/**
 * Rename directory
 *
 * @param  string  $old_path         Directory to rename
 * @param  string  $name             New directory name
 * @param  bool    $transliteration
 *
 * @return bool
 */
function rename_folder($old_path, $name, $transliteration)
{
	$name = fix_filename($name, $transliteration, false, '_', true);
	if (file_exists($old_path))
	{
		$new_path = fix_dirname($old_path) . "/" . $name;
		if (rf_safe_upload_target($old_path) === false || rf_safe_upload_target($new_path) === false
            || file_exists($new_path) || is_link($new_path))
		{
			return false;
		}

		return rename($old_path, $new_path);
	}
}

/**
 * Create new image from existing file
 *
 * @param  string  $imgfile    Source image file name
 * @param  string  $imgthumb   Thumbnail file name
 * @param  int     $newwidth   Thumbnail width
 * @param  int     $newheight  Optional thumbnail height
 * @param  string  $option     Type of resize
 *
 * @return bool
 * @throws \Exception
 */
function create_img($imgfile, $imgthumb, $newwidth, $newheight = null, $option = "crop")
{
    if (rf_safe_upload_target($imgfile) === false || rf_safe_upload_target($imgthumb) === false) return false;
	$timeLimit = ini_get('max_execution_time');
	set_time_limit(30);
	$result = false;
	
	// SVGファイルかどうかを確認
	$file_extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
	
	if ($file_extension === 'svg') {
		// SVGファイルの場合は単純にコピー
		$result = copy($imgfile, $imgthumb);
	} else {
	
		if (image_check_memory_usage($imgfile, $newwidth, $newheight))
		{
			require_once('php_image_magician.php');
			$magicianObj = new imageLib($imgfile);
			$magicianObj->resizeImage($newwidth, $newheight, $option);
			$magicianObj->saveImage($imgthumb, 80);
			$result = true;
		}
	}
	set_time_limit($timeLimit);

	return $result;
}

/**
 * Convert convert size in bytes to human readable
 *
 * @param  int  $size
 *
 * @return  string
 */
function makeSize($size)
{
	$units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
	$u = 0;
	while ((round($size / 1024) > 0) && ($u < 4))
	{
		$size = $size / 1024;
		$u++;
	}

	return (number_format($size, 0) . " " . $units[ $u ]);
}

/**
 * Determine directory size
 *
 * @param  string  $path
 *
 * @return  int
 */
function foldersize($path)
{
    if (is_link($path)) return 0;
	$total_size = 0;
	$files = scandir($path);
	$cleanPath = rtrim($path, '/') . '/';

	foreach ($files as $t)
	{
		if ($t != "." && $t != "..")
		{
			$currentFile = $cleanPath . $t;
			if (is_dir($currentFile))
			{
				$size = foldersize($currentFile);
				$total_size += $size;
			}
			else
			{
				$size = filesize($currentFile);
				$total_size += $size;
			}
		}
	}

	return $total_size;
}

/**
 * Get number of files in a directory
 *
 * @param  string  $path
 *
 * @return  int
 */
function filescount($path)
{
    if (is_link($path)) return 0;
	$total_count = 0;
	$files = scandir($path);
	$cleanPath = rtrim($path, '/') . '/';

	foreach ($files as $t)
	{
		if ($t != "." && $t != "..")
		{
			$currentFile = $cleanPath . $t;
			if (is_dir($currentFile))
			{
				$size = filescount($currentFile);
				$total_count += $size;
			}
			else
			{
				$total_count += 1;
			}
		}
	}

	return $total_count;
}

/**
 * Create directory for images and/or thumbnails
 *
 * @param  string  $path
 * @param  string  $path_thumbs
 */
function create_folder($path = null, $path_thumbs = null)
{
	global $permission;
    foreach (array($path, $path_thumbs) as $candidate) {
        if ($candidate && rf_safe_upload_target($candidate) === false) { response('wrong path', 400)->send(); exit; }
    }

	$oldumask = umask(0);
	if ($path && ! file_exists($path))
	{
		mkdir($path, $permission, true);
	} // or even 01777 so you get the sticky bit set
	if ($path_thumbs && ! file_exists($path_thumbs))
	{
		mkdir($path_thumbs, $permission, true) or die("$path_thumbs cannot be found");
	} // or even 01777 so you get the sticky bit set
	umask($oldumask);
}

/**
 * Get file extension present in directory
 *
 * @param  string  $path
 * @param  string  $ext
 */
function check_files_extensions_on_path($path, $ext)
{
	if ( ! is_dir($path))
	{
		$fileinfo = pathinfo($path);

		// fix code for php 5.1
		if (empty($fileinfo['filename']))
		{
			if (! empty($fileinfo['extension']))
			{
				$fileinfo['filename'] = str_replace('.'.$fileinfo['extension'], '', $fileinfo['basename']);
			}
			else {
				$fileinfo['filename'] = $fileinfo['basename'];
			}
		}

		if ( ! in_array(mb_strtolower($fileinfo['extension']), $ext))
		{
			unlink($path);
		}
	}
	else
	{
		$files = scandir($path);
		foreach ($files as $file)
		{
			check_files_extensions_on_path(trim($path, '/') . "/" . $file, $ext);
		}
	}
}

/**
 * Get file extension present in PHAR file
 *
 * @param  string  $phar
 * @param  array   $files
 * @param  string  $basepath
 * @param  string  $ext
 */
function check_files_extensions_on_phar($phar, &$files, $basepath, $ext)
{
	foreach ($phar as $file)
	{
		if ($file->isFile())
		{
			if (in_array(mb_strtolower($file->getExtension()), $ext))
			{
				$files[] = $basepath . $file->getFileName();
			}
		}
		else
		{
			if ($file->isDir())
			{
				$iterator = new DirectoryIterator($file);
				check_files_extensions_on_phar($iterator, $files, $basepath . $file->getFileName() . '/', $ext);
			}
		}
	}
}

/**
 * Cleanup input
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_get_params($str)
{
	return strip_tags(preg_replace("/[^a-zA-Z0-9\.\[\]_| -]/", '', $str));
}

/**
 * Cleanup filename
 *
 * @param  string  $str
 * @param  bool    $transliteration
 * @param  bool    $convert_spaces
 * @param  string  $replace_with
 * @param  bool    $is_folder
 *
 * @return string
 */
function fix_filename($str, $transliteration, $convert_spaces = false, $replace_with = "_", $is_folder = false)
{
	if ($convert_spaces)
	{
		$str = str_replace(' ', $replace_with, $str);
	}

	if ($transliteration)
	{
		if (function_exists('transliterator_transliterate'))
		{
			 $str = transliterator_transliterate('Accents-Any', utf8_encode($str));
		}
		else
		{
			$str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
		}

		$str = preg_replace("/[^a-zA-Z0-9\.\[\]_| -]/", '', $str);
	}

	$str = str_replace(array( '"', "'", "/", "\\" ), "", $str);
	$str = strip_tags($str);

	// Empty or incorrectly transliterated filename.
	// Here is a point: a good file UNKNOWN_LANGUAGE.jpg could become .jpg in previous code.
	// So we add that default 'file' name to fix that issue.
	if (strpos($str, '.') === 0 && $is_folder === false)
	{
		$str = 'file' . $str;
	}

	return trim($str);
}

/**
 * Cleanup directory name
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_dirname($str)
{
	return str_replace('~', ' ', dirname(str_replace(' ', '~', $str)));
}

/**
 * Correct strtoupper handling
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_strtoupper($str)
{
	if (function_exists('mb_strtoupper'))
	{
		return mb_strtoupper($str);
	}
	else
	{
		return strtoupper($str);
	}
}

/**
 * Correct strtolower handling
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_strtolower($str)
{
	if (function_exists('mb_strtoupper'))
	{
		return mb_strtolower($str);
	}
	else
	{
		return strtolower($str);
	}
}

function fix_path($path, $transliteration, $convert_spaces = false, $replace_with = "_")
{
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

	$tmp_path = $info['dirname'];
	if (empty($info['filename'])) $info['filename'] = $info['basename']; // fix code for php 5.1
	$str = fix_filename($info['filename'], $transliteration, $convert_spaces, $replace_with);
	if ($tmp_path != "")
	{
		return $tmp_path . DIRECTORY_SEPARATOR . $str;
	}
	else
	{
		return $str;
	}
}

/**
 * Get current base url
 *
 * @return  string
 */
function base_url()
{
	return sprintf(
		"%s://%s",
		isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		$_SERVER['HTTP_HOST']
	);
}

/**
 * @param  $current_path
 * @param  $fld
 *
 * @return  bool
 */
function config_loading($current_path, $fld)
{
    // Upload directories are data only; never execute per-directory PHP configuration.
    return false;
}


/**
 * Check if memory is enough to process image
 *
 * @param  string  $img
 * @param  int     $max_breedte
 * @param  int     $max_hoogte
 *
 * @return bool
 */
function image_check_memory_usage($img, $max_breedte, $max_hoogte)
{
	if (file_exists($img))
	{
		$K64 = 65536; // number of bytes in 64K
		$memory_usage = memory_get_usage();
		$memory_limit = abs(intval(str_replace('M', '', ini_get('memory_limit')) * 1024 * 1024));
		$image_properties = getimagesize($img);
		$image_width = $image_properties[0];
		$image_height = $image_properties[1];
		$image_bits = $image_properties['bits'];
		$image_memory_usage = $K64 + ($image_width * $image_height * ($image_bits) * 2);
		$thumb_memory_usage = $K64 + ($max_breedte * $max_hoogte * ($image_bits) * 2);
		$memory_needed = intval($memory_usage + $image_memory_usage + $thumb_memory_usage);

		if ($memory_needed > $memory_limit)
		{
			ini_set('memory_limit', (intval($memory_needed / 1024 / 1024) + 5) . 'M');
			if (ini_get('memory_limit') == (intval($memory_needed / 1024 / 1024) + 5) . 'M')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}

/**
 * Check is string is ended with needle
 *
 * @param  string  $haystack
 * @param  string  $needle
 *
 * @return  bool
 */
function endsWith($haystack, $needle)
{
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

/**
 * TODO REFACTOR THIS!
 *
 * @param $targetPath
 * @param $targetFile
 * @param $name
 * @param $current_path
 * @param $relative_image_creation
 * @param $relative_path_from_current_pos
 * @param $relative_image_creation_name_to_prepend
 * @param $relative_image_creation_name_to_append
 * @param $relative_image_creation_width
 * @param $relative_image_creation_height
 * @param $relative_image_creation_option
 * @param $fixed_image_creation
 * @param $fixed_path_from_filemanager
 * @param $fixed_image_creation_name_to_prepend
 * @param $fixed_image_creation_to_append
 * @param $fixed_image_creation_width
 * @param $fixed_image_creation_height
 * @param $fixed_image_creation_option
 *
 * @return bool
 */
function new_thumbnails_creation($targetPath, $targetFile, $name, $current_path, $relative_image_creation, $relative_path_from_current_pos, $relative_image_creation_name_to_prepend, $relative_image_creation_name_to_append, $relative_image_creation_width, $relative_image_creation_height, $relative_image_creation_option, $fixed_image_creation, $fixed_path_from_filemanager, $fixed_image_creation_name_to_prepend, $fixed_image_creation_to_append, $fixed_image_creation_width, $fixed_image_creation_height, $fixed_image_creation_option)
{
	//create relative thumbs
	$all_ok = true;
	if ($relative_image_creation)
	{
		foreach ($relative_path_from_current_pos as $k => $path)
		{
			if ($path != "" && $path[ strlen($path) - 1 ] != "/")
			{
				$path .= "/";
			}
			if ( ! file_exists($targetPath . $path))
			{
				create_folder($targetPath . $path, false);
			}
			$info = pathinfo($name);

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

			if ( ! endsWith($targetPath, $path))
			{
				if ( ! create_img($targetFile, $targetPath . $path . $relative_image_creation_name_to_prepend[ $k ] . $info['filename'] . $relative_image_creation_name_to_append[ $k ] . "." . $info['extension'], $relative_image_creation_width[ $k ], $relative_image_creation_height[ $k ], $relative_image_creation_option[ $k ]))
				{
					$all_ok = false;
				}
			}
		}
	}

	//create fixed thumbs
	if ($fixed_image_creation)
	{
		foreach ($fixed_path_from_filemanager as $k => $path)
		{
			if ($path != "" && $path[ strlen($path) - 1 ] != "/")
			{
				$path .= "/";
			}
			$base_dir = $path . substr_replace($targetPath, '', 0, strlen($current_path));
			if ( ! file_exists($base_dir))
			{
				create_folder($base_dir, false);
			}
			$info = pathinfo($name);

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

			if ( ! create_img($targetFile, $base_dir . $fixed_image_creation_name_to_prepend[ $k ] . $info['filename'] . $fixed_image_creation_to_append[ $k ] . "." . $info['extension'], $fixed_image_creation_width[ $k ], $fixed_image_creation_height[ $k ], $fixed_image_creation_option[ $k ]))
			{
				$all_ok = false;
			}
		}
	}

	return $all_ok;
}


/**
 * Get a remote file, using whichever mechanism is enabled
 *
 * @param  string  $url
 *
 * @return  bool|mixed|string
 */
function get_file_by_url($url)
{
	if (ini_get('allow_url_fopen'))
	{
		return file_get_contents($url);
	}
	if ( ! function_exists('curl_version'))
	{
		return false;
	}

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

/**
 * test for dir/file writability properly
 *
 * @param  string  $dir
 *
 * @return  bool
 */
function is_really_writable($dir)
{
	global $permission;

	$dir = rtrim($dir, '/');
	// linux, safe off
	if (DIRECTORY_SEPARATOR == '/' && @ini_get("safe_mode") == false)
	{
		return is_writable($dir);
	}

	// Windows, safe ON. (have to write a file :S)
	if (is_dir($dir))
	{
		$dir = $dir . '/' . md5(mt_rand(1, 1000) . mt_rand(1, 1000));

		if (($fp = @fopen($dir, 'ab')) === false)
		{
			return false;
		}

		fclose($fp);
		@chmod($dir, $permission);
		@unlink($dir);

		return true;
	}
	elseif ( ! is_file($dir) || ($fp = @fopen($dir, 'ab')) === false)
	{
		return false;
	}

	fclose($fp);

	return true;
}

/**
 * Check if a function is callable.
 * Some servers disable copy,rename etc.
 *
 * @parm  string  $name
 *
 * @return  bool
 */
function is_function_callable($name)
{
	if (function_exists($name) === false)
	{
		return false;
	}
	$disabled = explode(',', ini_get('disable_functions'));

	return ! in_array($name, $disabled);
}

/**
 * recursivly copies everything
 *
 * @param  string  $source
 * @param  string  $destination
 * @param  bool    $is_rec
 */
function rcopy($source, $destination, $is_rec = false)
{
	global $permission;

	if (is_dir($source))
	{
		if ($is_rec === false)
		{
			$pinfo = pathinfo($source);

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

			$destination = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
		}
		if (is_dir($destination) === false)
		{
			mkdir($destination, $permission, true);
		}

		$files = scandir($source);
		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
			{
				rcopy($source . DIRECTORY_SEPARATOR . $file, rtrim($destination, '/') . DIRECTORY_SEPARATOR . $file, true);
			}
		}
	}
	else
	{
		if (file_exists($source))
		{
			if (is_dir($destination) === true)
			{
				$pinfo = pathinfo($source);

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

				$dest2 = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
			}
			else
			{
				$dest2 = $destination;
			}

			copy($source, $dest2);
		}
	}
}




/**
 * recursivly renames everything
 *
 * I know copy and rename could be done with just one function
 * but i split the 2 because sometimes rename fails on windows
 * Need more feedback from users and refactor if needed
 *
 * @param  string  $source
 * @param  string  $destination
 * @param  bool    $is_rec
 */
function rrename($source, $destination, $is_rec = false)
{
	global $permission;

	if (is_dir($source))
	{
		if ($is_rec === false)
		{
			$pinfo = pathinfo($source);

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

			$destination = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
		}
		if (is_dir($destination) === false)
		{
			mkdir($destination, $permission, true);
		}

		$files = scandir($source);
		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
			{
				rrename($source . DIRECTORY_SEPARATOR . $file, rtrim($destination, '/') . DIRECTORY_SEPARATOR . $file, true);
			}
		}
	}
	else
	{
		if (file_exists($source))
		{
			if (is_dir($destination) === true)
			{
				$pinfo = pathinfo($source);

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

				$dest2 = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
			}
			else
			{
				$dest2 = $destination;
			}

			rename($source, $dest2);
		}
	}
}

// On windows rename leaves folders sometime
// This will clear leftover folders
// After more feedback will merge it with rrename
function rrename_after_cleaner($source)
{
	$files = scandir($source);

	foreach ($files as $file)
	{
		if ($file != "." && $file != "..")
		{
			if (is_dir($source . DIRECTORY_SEPARATOR . $file))
			{
				rrename_after_cleaner($source . DIRECTORY_SEPARATOR . $file);
			}
			else
			{
				unlink($source . DIRECTORY_SEPARATOR . $file);
			}
		}
	}

	return rmdir($source);
}

/**
 * Recursive chmod
 * @param  string  $source
 * @param  int     $mode
 * @param  string  $rec_option
 * @param  bool    $is_rec
 */
function rchmod($source, $mode, $rec_option = "none", $is_rec = false)
{
	if (is_link($source)) return;
	if ($rec_option == "none")
	{
		chmod($source, $mode);
	}
	else
	{
		if ($is_rec === false)
		{
			chmod($source, $mode);
		}

		$files = scandir($source);

		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
			{
				if (is_link($source . DIRECTORY_SEPARATOR . $file)) continue;
				if (is_dir($source . DIRECTORY_SEPARATOR . $file))
				{
					if ($rec_option == "folders" || $rec_option == "both")
					{
						chmod($source . DIRECTORY_SEPARATOR . $file, $mode);
					}
					rchmod($source . DIRECTORY_SEPARATOR . $file, $mode, $rec_option, true);
				}
				else
				{
					if ($rec_option == "files" || $rec_option == "both")
					{
						chmod($source . DIRECTORY_SEPARATOR . $file, $mode);
					}
				}
			}
		}
	}
}

/**
 * Check if chmod is valid
 *
 * @param  $perm
 * @param  $val
 *
 * @return  bool
 */
function chmod_logic_helper($perm, $val)
{
	$valid = array(
		1 => array( 1, 3, 5, 7 ),
		2 => array( 2, 3, 6, 7 ),
		4 => array( 4, 5, 6, 7 )
	);

	if (in_array($perm, $valid[ $val ]))
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * @param  string  $input
 * @param  bool    $trace
 * @param  bool    $halt
 */
function debugger($input, $trace = false, $halt = false)
{
	ob_start();

	echo "<br>----- DEBUG DUMP -----";
	echo "<pre>";
	var_dump($input);
	echo "</pre>";

	if ($trace)
	{
		if (is_php('5.3.6'))
		{
			$debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		}
		else
		{
			$debug = debug_backtrace(false);
		}

		echo "<br>-----STACK TRACE-----";
		echo "<pre>";
		var_dump($debug);
		echo "</pre>";
	}

	echo "</pre>";
	echo "---------------------------<br>";

	$ret = ob_get_contents();
	ob_end_clean();

	echo $ret;

	if ($halt == true)
	{
		exit();
	}
}

/**
 * @param  string  $version
 *
 * @return  bool
 */
function is_php($version = '5.0.0')
{
	static $phpVer;
	$version = (string) $version;

	if ( ! isset($phpVer[ $version ]))
	{
		$phpVer[ $version ] = (version_compare(PHP_VERSION, $version) < 0) ? false : true;
	}

	return $phpVer[ $version ];
}
