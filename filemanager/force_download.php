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

include 'include/mime_type_lib.php';

if (!isset($_POST['name'], $_POST['path']) || !is_string($_POST['name']) || !is_string($_POST['path'])
	|| strpos($_POST['name'], '/') !== false || strpos($_POST['name'], '\\') !== false)
{
	response('wrong path', 400)->send();
	exit;
}

$name = $_POST['name'];
$download_relative = rtrim($_POST['path'], '/');
$download_relative = ($download_relative === '' ? '' : $download_relative . '/') . $name;
$download_path = rf_resolve_path($current_path, $download_relative, false, false);
if ($download_path === false || !is_file($download_path)) { response('File not found', 404)->send(); exit; }

$info = pathinfo($name);

if ( ! in_array(fix_strtolower($info['extension']), $ext))
{
	response('wrong extension', 400)->send();
	exit;
}

$img_size = (string) (filesize($download_path)); // Get the image size as string

$mime_type = get_file_mime_type($download_path); // Get the correct MIME type depending on the file.

response(file_get_contents($download_path), 200, array(
	'Pragma'              => 'private',
	'Cache-control'       => 'private, must-revalidate',
	'Content-Type'        => $mime_type,
	'Content-Length'      => $img_size,
	'Content-Disposition' => 'attachment; filename="' . ($name) . '"'
))->send();

exit;
