<?php
if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
    http_response_code(403);
    exit('Authentication required');
}

// Resolve the installation from its local configuration, never from the cookie.
$rf_root = dirname(__DIR__, 2);
try {
    if (!is_file($rf_root . '/core/db/config.php')) throw new RuntimeException('Database unavailable');
    require_once $rf_root . '/core/db/config.php';
    if (!defined('TABLE_PREFIX') || !preg_match('/^[A-Za-z0-9_]+$/D', TABLE_PREFIX)) {
        throw new RuntimeException('Invalid database configuration');
    }
    if (defined('CURRENT_DATABASE') && CURRENT_DATABASE == 1) {
        if (!is_file($rf_root . '/core/db/pdo_sqlite.php')) throw new RuntimeException('Database unavailable');
        require_once $rf_root . '/core/db/pdo_sqlite.php';
        // Do not create a database or repair configuration during a file request.
        if (!defined('SQLITE_PATH') || !is_file(SQLITE_PATH)) {
            throw new RuntimeException('Database unavailable');
        }
        $rf_pdo = new PDO('sqlite:' . SQLITE_PATH);
    } elseif (defined('CURRENT_DATABASE') && CURRENT_DATABASE == 2) {
        if (!is_file($rf_root . '/core/db/pdo_mysql.php')) throw new RuntimeException('Database unavailable');
        require_once $rf_root . '/core/db/pdo_mysql.php';
        $rf_pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
            DB_USER, DB_PASS, array(PDO::ATTR_TIMEOUT => 3));
    } else {
        throw new RuntimeException('Invalid database configuration');
    }
    $rf_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $rf_pdo->setAttribute(PDO::ATTR_TIMEOUT, 3);
    $rf_query = $rf_pdo->prepare('SELECT value FROM ' . TABLE_PREFIX . 'configs WHERE item = :item');
    $rf_query->execute(array(':item' => 'session_key'));
    $session_key = $rf_query->fetchColumn();
    if (!is_string($session_key) || $session_key === ''
        || !isset($_COOKIE['session_key']) || !is_string($_COOKIE['session_key'])
        || !hash_equals($session_key, $_COOKIE['session_key'])) {
        http_response_code(403);
        exit('Invalid installation session');
    }
    $postease_auth_api = true;
    require $rf_root . '/_auth.php';
    $rf_user = $_SESSION[$session_key]['user'];
    $rf_query = $rf_pdo->prepare('SELECT u.account, u.role, u.group_id, g.slug AS group_slug FROM '
        . TABLE_PREFIX . 'users u LEFT JOIN ' . TABLE_PREFIX
        . 'groups g ON u.group_id = g.id AND g.delete_flg = 0 WHERE u.id = :id AND u.delete_flg = 0');
    $rf_query->execute(array(':id' => $rf_user['id']));
    $rf_current_user = $rf_query->fetch(PDO::FETCH_ASSOC);
    $rf_changed = !$rf_current_user;
    foreach (array('account', 'role', 'group_id', 'group_slug') as $rf_field) {
        $rf_value = isset($rf_user[$rf_field]) && is_scalar($rf_user[$rf_field]) ? (string)$rf_user[$rf_field] : '';
        if (!$rf_current_user || $rf_value !== (string)$rf_current_user[$rf_field]) {
            $rf_changed = true;
        }
    }
    if ($rf_changed || (!empty($rf_current_user['group_id']) && empty($rf_current_user['group_slug']))) {
        unset($_SESSION['RF'], $_SESSION['RF_context'], $_SESSION['RF_csrf_token']);
        unset($_SESSION[$session_key]['image_frames'], $_SESSION[$session_key]['filemanager']);
        http_response_code(403);
        exit('Login or membership changed; reload the application');
    }
    $rf_identity = array((string)$rf_user['id'], (string)$rf_user['role'],
        (string)$rf_current_user['group_id'], (string)$rf_current_user['group_slug'], (string)$rf_user['login_time']);
    if (!isset($_SESSION[$session_key]['filemanager_identity'])
        || $_SESSION[$session_key]['filemanager_identity'] !== $rf_identity
        || !isset($_SESSION[$session_key]['filemanager'])) {
        unset($_SESSION['RF'], $_SESSION['RF_context'], $_SESSION['RF_csrf_token']);
        http_response_code(403);
        exit('Reload the application to initialize file access');
    }
    unset($rf_query, $rf_pdo);
} catch (Exception $rf_error) {
    http_response_code(503);
    exit('Authentication service unavailable');
}

$rf_context = array($rf_root, $session_key, (string)$rf_user['id'], (string)$rf_user['role'],
    (string)$rf_current_user['group_id'], (string)$rf_current_user['group_slug'], (string)$rf_user['login_time']);
$rf_context_changed = !isset($_SESSION['RF_context']) || $_SESSION['RF_context'] !== $rf_context;
if ($rf_context_changed) {
    unset($_SESSION['RF'], $_SESSION['RF_csrf_token']);
    $_SESSION['RF_context'] = $rf_context;
}
if (!isset($_SESSION['RF_csrf_token']) || !is_string($_SESSION['RF_csrf_token'])
    || strlen($_SESSION['RF_csrf_token']) !== 64) {
    try {
        $_SESSION['RF_csrf_token'] = bin2hex(random_bytes(32));
    } catch (Exception $rf_error) {
        http_response_code(503);
        exit('Secure token generation unavailable');
    }
}
$csrf_token = $_SESSION['RF_csrf_token'];
$_SESSION['RF']['verify'] = 'RESPONSIVEfilemanager';

$rf_script = isset($_SERVER['SCRIPT_FILENAME']) ? realpath($_SERVER['SCRIPT_FILENAME']) : false;
$rf_endpoint = $rf_script ? substr($rf_script, strlen(dirname(__DIR__)) + 1) : '';
$rf_action = isset($_GET['action']) && is_string($_GET['action']) ? $_GET['action'] : '';
$rf_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
$rf_read_actions = array('media_preview', 'get_lang', 'image_size', 'chmod', 'get_file');
$rf_write_actions = array('view', 'filter', 'sort', 'save_img', 'extract', 'copy_cut', 'clear_clipboard', 'change_lang');
if (!$rf_script || strpos($rf_script, dirname(__DIR__) . '/') !== 0
    || !in_array($rf_endpoint, array('dialog.php', 'upload.php', 'execute.php', 'ajax_calls.php', 'force_download.php', 'uploader/index.php', 'uploader/success.php'), true)) {
    http_response_code(403);
    exit('Invalid entry point');
}
if ($rf_endpoint === 'ajax_calls.php' && !in_array($rf_action, array_merge($rf_read_actions, $rf_write_actions), true)) {
    http_response_code(400);
    exit('Unknown action');
}
$rf_mutating = in_array($rf_endpoint, array('upload.php', 'execute.php', 'force_download.php'), true)
    || (in_array($rf_endpoint, array('dialog.php', 'uploader/index.php'), true) && $rf_method === 'POST')
    || ($rf_endpoint === 'ajax_calls.php' && in_array($rf_action, $rf_write_actions, true));
if ($rf_mutating) {
    if ($rf_method !== 'POST') {
        header('Allow: POST', true, 405);
        exit('POST required');
    }
    $rf_body_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null;
    $rf_header_token = isset($_SERVER['HTTP_X_CSRF_TOKEN']) ? $_SERVER['HTTP_X_CSRF_TOKEN'] : null;
    $rf_token = $rf_body_token !== null ? $rf_body_token : $rf_header_token;
    if (!is_string($rf_token) || strlen($rf_token) !== 64 || !hash_equals($csrf_token, $rf_token)
        || ($rf_body_token !== null && $rf_header_token !== null
            && (!is_string($rf_header_token) || !hash_equals($rf_body_token, $rf_header_token)))) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
} elseif (!in_array($rf_method, array('GET', 'HEAD', 'POST'), true)) {
    header('Allow: GET, HEAD, POST', true, 405);
    exit('Method not allowed');
}
header('Cache-Control: no-store');
$rf_can_maintain = $rf_endpoint === 'dialog.php' && $rf_method === 'POST' && isset($_POST['refresh_previews']);
if (!isset($_SESSION[$session_key]['configs']['timezone'])
    || !is_string($_SESSION[$session_key]['configs']['timezone'])
    || !@date_default_timezone_set($_SESSION[$session_key]['configs']['timezone'])) {
    http_response_code(403);
    exit('Invalid installation session');
}
mb_internal_encoding('UTF-8');

// Uoload Directory
$group_dir        = (! empty($_SESSION[$session_key]['user']['group_slug']))  ? 'gd_' . $_SESSION[$session_key]['user']['group_slug'] : null; // prefix 'gd_' (group_dir) is required
$upload_dir       = (! empty($_SESSION[$session_key]['configs']['dir_name'])) ? "/{$_SESSION[$session_key]['configs']['dir_name']}/upload/fr_main" : "/upload/fr_main";
$upload_dir      .= (! empty($group_dir)) ? "/{$group_dir}/1x/" : "/1x/";

// Current Path
$current_path     = (! empty($group_dir)) ? "../upload/fr_main/{$group_dir}/1x/" : "../upload/fr_main/1x/";

// Thumbnail Path
$thumbs_base_path = (! empty($group_dir)) ? "../upload/fr_thumb/{$group_dir}/" : "../upload/fr_thumb/";


/*
|--------------------------------------------------------------------------
| Optional security
|--------------------------------------------------------------------------
|
| if set to true only those will access RF whose url contains the access key(akey) like:
| <input type="button" href="../filemanager/dialog.php?field_id=imgField&lang=en_EN&akey=myPrivateKey" value="Files">
| in tinymce a new parameter added: filemanager_access_key:"myPrivateKey"
| example tinymce config:
|
| tiny init ...
| external_filemanager_path:"../filemanager/",
| filemanager_title:"Filemanager" ,
| filemanager_access_key:"myPrivateKey" ,
| ...
|
*/

define('USE_ACCESS_KEYS', false); // TRUE or FALSE

/*
|--------------------------------------------------------------------------
| DON'T COPY THIS VARIABLES IN FOLDERS config.php FILES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Path configuration
|--------------------------------------------------------------------------
| In this configuration the folder tree is
| root
|    |- source <- upload folder
|    |- thumbs <- thumbnail folder [must have write permission (755)]
|    |- filemanager
|    |- js
|    |   |- tinymce
|    |   |   |- plugins
|    |   |   |   |- responsivefilemanager
|    |   |   |   |   |- plugin.min.js
*/

$config = array(

	/*
	|--------------------------------------------------------------------------
	| DON'T TOUCH (base url (only domain) of site).
	|--------------------------------------------------------------------------
	|
	| without final /
	|
	*/

	'base_url' => $_SESSION[$session_key]['configs']['domain'],

	/*
	|--------------------------------------------------------------------------
	| path from base_url to base of upload folder
	|--------------------------------------------------------------------------
	|
	| with start and final /
	|
	*/
	'upload_dir' => $upload_dir,

	/*
	|--------------------------------------------------------------------------
	| relative path from filemanager folder to upload folder
	|--------------------------------------------------------------------------
	|
	| with final /
	|
	*/
	'current_path' => $current_path,

	/*
	|--------------------------------------------------------------------------
	| relative path from filemanager folder to thumbs folder
	|--------------------------------------------------------------------------
	|
	| with final /
	| DO NOT put inside upload folder
	|
	*/
	'thumbs_base_path' => $thumbs_base_path,

	/*
	|--------------------------------------------------------------------------
	| Access keys
	|--------------------------------------------------------------------------
	|
	| add access keys eg: array('myPrivateKey', 'someoneElseKey');
	| keys should only containt (a-z A-Z 0-9 \ . _ -) characters
	| if you are integrating lets say to a cms for admins, i recommend making keys randomized something like this:
	| $username = 'Admin';
	| $salt = 'dsflFWR9u2xQa' (a hard coded string)
	| $akey = md5($username.$salt);
	| DO NOT use 'key' as access key!
	| Keys are CASE SENSITIVE!
	|
	*/

	'access_keys' => array(),

	//--------------------------------------------------------------------------------------------------------
	// YOU CAN COPY AND CHANGE THESE VARIABLES INTO FOLDERS config.php FILES TO CUSTOMIZE EACH FOLDER OPTIONS
	//--------------------------------------------------------------------------------------------------------

	/*
	|--------------------------------------------------------------------------
	| Maximum upload size
	|--------------------------------------------------------------------------
	|
	| in Megabytes
	|
	*/
	'MaxSizeUpload' => 100,


	/*
	|--------------------------------------------------------------------------
	| default language file name
	|--------------------------------------------------------------------------
	*/
	'default_language' => $_SESSION[$session_key]['user']['lang'],

	/*
	|--------------------------------------------------------------------------
	| Icon theme
	|--------------------------------------------------------------------------
	|
	| Default available: ico and ico_dark
	| Can be set to custom icon inside filemanager/img
	|
	*/
	'icon_theme' => "ico",


	//Show or not show folder size in list view feature in filemanager (is possible, if there is a large folder, to greatly increase the calculations)
	'show_folder_size'                        => true,
	//Show or not show sorting feature in filemanager
	'show_sorting_bar'                        => true,
	//active or deactive the transliteration (mean convert all strange characters in A..Za..z0..9 characters)
	'transliteration'                         => false,
	//convert all spaces on files name and folders name with $replace_with variable
	'convert_spaces'                          => true,
	//convert all spaces on files name and folders name this value
	'replace_with'                            => "_",

	// -1: There is no lazy loading at all, 0: Always lazy-load images, 0+: The minimum number of the files in a directory
	// when lazy loading should be turned on.
	'lazy_loading_file_number_threshold'      => 0,


	//*******************************************
	//Images limit and resizing configuration
	//*******************************************

	// set maximum pixel width and/or maximum pixel height for all images
	// If you set a maximum width or height, oversized images are converted to those limits. Images smaller than the limit(s) are unaffected
	// if you don't need a limit set both to 0
	'image_max_width'                         => $_SESSION[$session_key]['configs']['upload_imagesize_main_width'],
	'image_max_height'                        => $_SESSION[$session_key]['configs']['upload_imagesize_main_height'],
	'image_max_mode'                          => 'auto',
	// Raster images above this pixel count are refused before decoding. The server's memory_limit is never raised.
	'image_max_pixels'                        => 50000000,
	/*
	#  $option:  0 / exact = defined size;
	#            1 / portrait = keep aspect set height;
	#            2 / landscape = keep aspect set width;
	#            3 / auto = auto;
	#            4 / crop= resize and crop;
	 */

	//Automatic resizing //
	// If you set $image_resizing to TRUE the script converts all uploaded images exactly to image_resizing_width x image_resizing_height dimension
	// If you set width or height to 0 the script automatically calculates the other dimension
	// Is possible that if you upload very big images the script not work to overcome this increase the php configuration of memory and time limit
	'image_resizing'                          => false,
	'image_resizing_width'                    => 0,
	'image_resizing_height'                   => 0,
	'image_resizing_mode'                     => 'auto', // same as $image_max_mode
	'image_resizing_override'                 => false,
	// If set to TRUE then you can specify bigger images than $image_max_width & height otherwise if image_resizing is
	// bigger than $image_max_width or height then it will be converted to those values

	//******************
	// Default layout setting
	//
	// 0 => boxes
	// 1 => detailed list (1 column)
	// 2 => columns list (multiple columns depending on the width of the page)
	// YOU CAN ALSO PASS THIS PARAMETERS USING SESSION VAR => $_SESSION['RF']["VIEW"]=
	//
	//******************
	'default_view'                            => 0,

	//set if the filename is truncated when overflow first row
	'ellipsis_title_after_first_row'          => true,

	//*************************
	//Permissions configuration
	//******************
	'delete_files'                            => true,
	'create_folders'                          => true,
	'delete_folders'                          => true,
	'upload_files'                            => true,
	'rename_files'                            => true,
	'rename_folders'                          => true,
	'duplicate_files'                         => false,
	'copy_cut_files'                          => false, // for copy/cut files
	'copy_cut_dirs'                           => false, // for copy/cut directories
	'chmod_files'                             => false, // change file permissions
	'chmod_dirs'                              => true, // change folder permissions
	'preview_text_files'                      => false, // eg.: txt, log etc.
	'edit_text_files'                         => false, // eg.: txt, log etc.
	'create_text_files'                       => false, // only create files with exts. defined in $editable_text_file_exts

	// you can preview these type of files if $preview_text_files is true
	'previewable_text_file_exts'              => array( 'txt', 'log', 'xml', 'html', 'css', 'htm', 'js' ),
	'previewable_text_file_exts_no_prettify'  => array( 'txt', 'log' ),

	// you can edit these type of files if $edit_text_files is true (only text based files)
	// you can create these type of files if $create_text_files is true (only text based files)
	// if you want you can add html,css etc.
	// but for security reasons it's NOT RECOMMENDED!
	'editable_text_file_exts'                 => array( 'txt', 'log', 'xml', 'html', 'css', 'htm', 'js' ),

	// Preview with Google Documents
	'googledoc_enabled'                       => true,
	'googledoc_file_exts'                     => array( 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx' ),

	// Preview with Viewer.js
	'viewerjs_enabled'                        => true,
	'viewerjs_file_exts'                      => array( 'pdf', 'odt', 'odp', 'ods' ),

	// defines size limit for paste in MB / operation
	// set 'FALSE' for no limit
	'copy_cut_max_size'                       => 100,
	// defines file count limit for paste / operation
	// set 'FALSE' for no limit
	'copy_cut_max_count'                      => 200,
	//IF any of these limits reached, operation won't start and generate warning

	//**********************
	//Allowed extensions (lowercase insert)
	//**********************
	'ext_img'                                 => array( 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg' ), //Images
	'ext_file'                                => array( 'doc', 'docx', 'rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv', 'html', 'xhtml', 'psd', 'sql', 'log', 'fla', 'xml', 'ade', 'adp', 'mdb', 'accdb', 'ppt', 'pptx', 'odt', 'ots', 'ott', 'odb', 'odg', 'otp', 'otg', 'odf', 'ods', 'odp', 'css', 'ai' ), //Files
	'ext_video'                               => array( 'mov', 'mpeg', 'm4v', 'mp4', 'avi', 'mpg', 'wma', "flv", "webm" ), //Video
	'ext_music'                               => array( 'mp3', 'm4a', 'ac3', 'aiff', 'mid', 'ogg', 'wav' ), //Audio
	'ext_misc'                                => array( 'zip', 'rar', 'gz', 'tar', 'iso', 'dmg' ), //Archives
	// Still listed and downloadable, but refused for new uploads because they are active content.
	'ext_upload_denied'                       => array( 'html', 'htm', 'xhtml' ),


	//The filter and sorter are managed through both javascript and php scripts because if you have a lot of
	//file in a folder the javascript script can't sort all or filter all, so the filemanager switch to php script.
	//The plugin automatic swich javascript to php when the current folder exceeds the below limit of files number
	'file_number_limit_js'                    => 500,

	//**********************
	// Hidden files and folders
	//**********************
	// set the names of any folders you want hidden (eg "hidden_folder1", "hidden_folder2" ) Remember all folders with these names will be hidden (you can set any exceptions in config.php files on folders)
	'hidden_folders'                          => array(),
	// set the names of any files you want hidden. Remember these names will be hidden in all folders (eg "this_document.pdf", "that_image.jpg" )
	'hidden_files'                            => array( 'config.php' ),

	/*******************
	 * JAVA upload
	 *******************/
	'java_upload'                             => false,
	'JAVAMaxSizeUpload'                       => 200, //Gb


	//************************************
	//Thumbnail for external use creation
	//************************************


	// New image resized creation with fixed path from filemanager folder after uploading (thumbnails in fixed mode)
	// If you want create images resized out of upload folder for use with external script you can choose this method,
	// You can create also more than one image at a time just simply add a value in the array
	// Remember than the image creation respect the folder hierarchy so if you are inside source/test/test1/ the new image will create at
	// path_from_filemanager/test/test1/
	// PS if there isn't write permission in your destination folder you must set it
	//
	'fixed_image_creation'                    => true, //activate or not the creation of one or more image resized with fixed path from filemanager folder
	'fixed_path_from_filemanager'             => $_SESSION[$session_key]['filemanager']['fixed_path_from_filemanager'], //fixed path of the image folder from the current position on upload folder
	'fixed_image_creation_name_to_prepend'    => array( '', '' ), //name to prepend on filename
	'fixed_image_creation_to_append'          => array( '', '' ), //name to appendon filename
	'fixed_image_creation_width'              => $_SESSION[$session_key]['filemanager']['fixed_image_creation_width'], //width of image (you can leave empty if you set height)
	'fixed_image_creation_height'             => $_SESSION[$session_key]['filemanager']['fixed_image_creation_height'], //height of image (you can leave empty if you set width)
	/*
	#             $option:     0 / exact = defined size;
	#                          1 / portrait = keep aspect set height;
	#                          2 / landscape = keep aspect set width;
	#                          3 / auto = auto;
	#                          4 / crop= resize and crop;
	 */
	'fixed_image_creation_option'             => $_SESSION[$session_key]['filemanager']['fixed_image_creation_option'], //set the type of the crop


	// New image resized creation with relative path inside to upload folder after uploading (thumbnails in relative mode)
	// With Responsive filemanager you can create automatically resized image inside the upload folder, also more than one at a time
	// just simply add a value in the array
	// The image creation path is always relative so if i'm inside source/test/test1 and I upload an image, the path start from here
	//
	'relative_image_creation'                 => false, //activate or not the creation of one or more image resized with relative path from upload folder
	'relative_path_from_current_pos'          => array( 'thumb/', 'thumb/' ), //relative path of the image folder from the current position on upload folder
	'relative_image_creation_name_to_prepend' => array( '', 'test_' ), //name to prepend on filename
	'relative_image_creation_name_to_append'  => array( '_test', '' ), //name to append on filename
	'relative_image_creation_width'           => array( 300, 400 ), //width of image (you can leave empty if you set height)
	'relative_image_creation_height'          => array( 200, '' ), //height of image (you can leave empty if you set width)
	/*
	#             $option:     0 / exact = defined size;
	#                          1 / portrait = keep aspect set height;
	#                          2 / landscape = keep aspect set width;
	#                          3 / auto = auto;
	#                          4 / crop= resize and crop;
	 */
	'relative_image_creation_option'          => array( 'crop', 'crop' ), //set the type of the crop


	// Remember text filter after close filemanager for future session
	'remember_text_filter'                    => false,

);

return array_merge(
	$config,
	array(
		'MaxSizeUpload' => ((int)(ini_get('post_max_size')) < $config['MaxSizeUpload'])
			? (int)(ini_get('post_max_size')) : $config['MaxSizeUpload'],
		'ext'=> array_merge(
			$config['ext_img'],
			$config['ext_file'],
			$config['ext_misc'],
			$config['ext_video'],
			$config['ext_music']
		),
	)
);
