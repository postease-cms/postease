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

if (isset($_POST['path']))
{
   if (!is_string($_POST['path']) || strpos($_POST['path'], $current_path) !== 0) { response('wrong path', 400)->send(); exit; }
   $storeRelative = substr($_POST['path'], strlen($current_path));
}
else
{
   $storeRelative = isset($_POST['fldr']) && is_string($_POST['fldr']) ? $_POST['fldr'] : null; // IE compatibility mode
}

$storeFolder = rf_resolve_path($current_path, $storeRelative, false, true);
$storeThumbRelative = $storeRelative;
$storeFolderThumb = rf_resolve_path($thumbs_base_path, $storeThumbRelative, true, true);
if ($storeFolder === false || !is_dir($storeFolder) || $storeFolderThumb === false) { response('wrong path', 400)->send(); exit; }
$storeFolder = rtrim($current_path . $storeRelative, '/') . '/';
$storeFolderThumb = rtrim($thumbs_base_path . $storeRelative, '/') . '/';

// Per-folder PHP configuration is not loaded from writable upload directories.


if (!$upload_files) { http_response_code(403); exit('Upload disabled'); }

if ( ! empty($_FILES))
{
	if (!isset($_FILES['file']['name'], $_FILES['file']['tmp_name'], $_FILES['file']['error']) || !is_string($_FILES['file']['name'])
		|| $_FILES['file']['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES['file']['tmp_name']))
	{
		response('Invalid upload', 400)->send();
		exit;
	}
	$original_name = $_FILES['file']['name'];
	if (strpos($original_name, '/') !== false || strpos($original_name, '\\') !== false || strpos($original_name, "\0") !== false)
	{
		response('wrong filename', 400)->send();
		exit;
	}

	// The stored name keeps exactly one extension. The browser-declared MIME type is never consulted.
	$name_parts = rf_split_name($original_name);
	$extension = fix_strtolower($name_parts[1]);
	$ext_upload_denied = isset($ext_upload_denied) && is_array($ext_upload_denied) ? $ext_upload_denied : array();

	if ($extension !== '' && in_array($extension, $ext, true) && !in_array($extension, $ext_upload_denied, true))
	{
		$tempFile = $_FILES['file']['tmp_name'];
		$targetPath = $storeFolder;
		$targetPathThumb = $storeFolderThumb;

		// Content is verified against the extension before anything reaches the public folder.
		if (!rf_upload_content_valid($tempFile, $extension, $ext_img))
		{
			// The reason is sent as the body so the upload dialog can show it instead of a generic server error.
			header('HTTP/1.1 406 file content not permitted', TRUE, 406);
			header('Content-Type: text/plain; charset=UTF-8');
			echo rf_upload_reject_text();
			exit();
		}

		$stem = rf_stored_stem($name_parts[0], $extension, $convert_spaces, $replace_with);

		// Reserve the stored name exclusively so an existing or concurrent file is never replaced.
		$stored_name = rf_claim_upload_name($targetPath, $stem, $extension);
		if ($stored_name === false)
		{
			header('HTTP/1.1 409 file name unavailable', TRUE, 409);
			exit();
		}
		$_FILES['file']['name'] = $stored_name;
		$info = array('filename' => $stem, 'extension' => $extension, 'basename' => $stored_name);

		$targetRelative = ($storeRelative === '' ? '' : rtrim($storeRelative, '/') . '/') . $stored_name;
		$targetFile = rf_resolve_path($current_path, $targetRelative, true, false);
		$targetFileThumb = rf_resolve_path($thumbs_base_path, $targetRelative, true, false);
		if ($targetFile === false || $targetFileThumb === false) { @unlink($targetPath . $stored_name); response('wrong path', 400)->send(); exit; }

		// check if image (and supported)
		$is_img = in_array($extension, $ext_img, true);

        // Browsing is read-only; prepare missing preview directories on the validated POST.
        if ($is_img && !is_dir($targetPathThumb)) {
            if (!@mkdir($targetPathThumb, $permission, true) && !is_dir($targetPathThumb)) {
                @unlink($targetFile);
                http_response_code(500);
                exit('Cannot prepare image directory');
            }
        }

		// upload
		if (!move_uploaded_file($tempFile, $targetFile) || !is_file($targetFile))
		{
			@unlink($targetFile);
			header('HTTP/1.1 500 upload failed', TRUE, 500);
			exit();
		}
		chmod($targetFile, 0755);

		if ($is_img && $extension === 'svg')
		{
			// SVG previews and derivatives are byte copies; raster derivative sizing does not apply.
			try {
				create_img($targetFile, $targetFileThumb, 122, 91);
				new_thumbnails_creation($targetPath,$targetFile,$_FILES['file']['name'],$current_path,$relative_image_creation,$relative_path_from_current_pos,$relative_image_creation_name_to_prepend,$relative_image_creation_name_to_append,$relative_image_creation_width,$relative_image_creation_height,$relative_image_creation_option,$fixed_image_creation,$fixed_path_from_filemanager,$fixed_image_creation_name_to_prepend,$fixed_image_creation_to_append,$fixed_image_creation_width,$fixed_image_creation_height,$fixed_image_creation_option);
			} catch (Throwable $preview_failure) {}
		}
		elseif ($is_img)
		{
			$memory_error = FALSE;
			// Content was verified before the move; a preview failure (for example a tiny image) keeps the original without derivatives.
			try {
				$preview_created = create_img($targetFile, $targetFileThumb, 122, 91);
			} catch (Throwable $preview_failure) {
				$preview_created = false;
			}
			if ( ! $preview_created)
			{
				$memory_error = FALSE;
			}
			else
			{
				// get image size
				$imginfo   = getimagesize($targetFile);
				$srcWidth  = $srcWidthOrigin = $imginfo[0];
				$srcHeight = $srcHeightOrigin = $imginfo[1];

				foreach ($fixed_image_creation_width as $key => $value)
				{
					// Fix auto image
					if ($fixed_image_creation_option[$key] == 'auto')
					{
						// add height
						if (empty($fixed_image_creation_height[$key]))
						{
							$fixed_image_creation_height[$key] = ceil($fixed_image_creation_width[$key] * ($srcHeightOrigin/$srcWidthOrigin));
						}
						// add width
						if (empty($fixed_image_creation_width[$key]))
						{
							$fixed_image_creation_width[$key] = ceil($fixed_image_creation_height[$key] * ($srcWidthOrigin/$srcHeightOrigin));
						}

						// fix size
						if (($fixed_image_creation_width[$key] < $srcWidthOrigin || $fixed_image_creation_height[$key] < $srcHeightOrigin))
						{
							// when landscape
							if ($srcWidth >= $srcHeight)
							{
								$src_image_ratio = $srcWidth / $srcHeight;
								$fix_image_ratio = $fixed_image_creation_width[$key] / $fixed_image_creation_height[$key];
								if ($fix_image_ratio >= $src_image_ratio){
									$fixed_image_creation_width[$key] = ceil($srcWidthOrigin * ($fixed_image_creation_height[$key] / $srcHeightOrigin));
								}
								if ($fix_image_ratio < $src_image_ratio){
									$fixed_image_creation_height[$key] = ceil($srcHeightOrigin * ($fixed_image_creation_width[$key] / $srcWidthOrigin));
								}
							}

							// when portlait
							if ($srcWidth < $srcHeight)
							{
								$src_image_ratio = $srcHeight / $srcWidth;
								$fix_image_ratio = $fixed_image_creation_height[$key] / $fixed_image_creation_width[$key];
								if ($fix_image_ratio >= $src_image_ratio){
									$fixed_image_creation_height[$key] = ceil($srcHeightOrigin * ($fixed_image_creation_width[$key] / $srcWidthOrigin));
								}
								if ($fix_image_ratio < $src_image_ratio){
									$fixed_image_creation_width[$key] = ceil($srcWidthOrigin * ($fixed_image_creation_height[$key] / $srcHeightOrigin));
								}
							}
						}
						else {
							$fixed_image_creation_width[$key] = $srcWidthOrigin;
							$fixed_image_creation_height[$key] = $srcHeightOrigin;
						}
					}
				}

// 				print '<pre>';
// 				print_r($fixed_image_creation_width);
// 				print '<pre>';
// 				exit;

				// TODO something with this long function baaaah...
				if( ! new_thumbnails_creation($targetPath,$targetFile,$_FILES['file']['name'],$current_path,$relative_image_creation,$relative_path_from_current_pos,$relative_image_creation_name_to_prepend,$relative_image_creation_name_to_append,$relative_image_creation_width,$relative_image_creation_height,$relative_image_creation_option,$fixed_image_creation,$fixed_path_from_filemanager,$fixed_image_creation_name_to_prepend,$fixed_image_creation_to_append,$fixed_image_creation_width,$fixed_image_creation_height,$fixed_image_creation_option))
				{
					$memory_error = FALSE;
				}
				else
				{
					// resize images if set
					if ($image_resizing)
					{
						if ($image_resizing_width == 0) // if width not set
						{
							if ($image_resizing_height == 0)
							{
								$image_resizing_width = $srcWidth;
								$image_resizing_height = $srcHeight;
							}
							else
							{
								$image_resizing_width = ceil($image_resizing_height * $srcWidth / $srcHeight);
							}
						}
						elseif ($image_resizing_height == 0) // if height not set
						{
							$image_resizing_height = ceil($image_resizing_width * $srcHeight / $srcWidth);
						}

						// new dims and create
						$srcWidth = $image_resizing_width;
						$srcHeight = $image_resizing_height;
						create_img($targetFile, $targetFile, $image_resizing_width, $image_resizing_height, $image_resizing_mode);
					}

					//max resizing limit control
					$resize = FALSE;
					if (! empty($image_max_width) && $srcWidth > $image_max_width && $image_resizing_override === FALSE)
					{
						$resize = TRUE;
						$srcWidth = $image_max_width;
						$srcHeight = ceil($image_max_width * ($srcHeightOrigin/$srcWidthOrigin));
						if (! empty($image_max_height) && $srcHeight > $image_max_height)
						{
							$srcHeight = $image_max_height;
							$srcWidth = ceil($image_max_height * ($srcWidthOrigin/$srcHeightOrigin));
						}
					}

					elseif (! empty($image_max_height) && $srcHeight > $image_max_height && $image_resizing_override === FALSE)
					{
						$resize = TRUE;
						$srcHeight = $image_max_height;
						$srcWidth = ceil($image_max_height * ($srcWidthOrigin/$srcHeightOrigin));
						if (! empty($image_max_width) && $srcWidth > $image_max_width)
						{
							$srcWidth = $image_max_width;
							$srcHeight = ceil($image_max_width * ($srcHeightOrigin/$srcWidthOrigin));
						}
					}
					if ($resize) create_img($targetFile, $targetFile, $srcWidth, $srcHeight, $image_max_mode);
				}
			}

			// not enough memory
			if ($memory_error)
			{
				unlink($targetFile);
				if (is_file($targetFileThumb)) unlink($targetFileThumb);
				header('HTTP/1.1 406 Not enought Memory',TRUE,406);
				exit();
			}
		}
		$_FILES['file']['name'];
	}
	else // file ext. is not in the allowed list
	{
		header('HTTP/1.1 406 file not permitted',TRUE,406);
		header('Content-Type: text/plain; charset=UTF-8');
		echo trans('Error_extension');
		exit();
	}
}
else // no files to upload
{
	header('HTTP/1.1 405 Bad Request', TRUE, 405);
	exit();
}

// redirect
if (isset($_POST['submit']))
{
	$query = http_build_query(array(
		'type'	  	=> $_POST['type'],
		'lang'	  	=> $_POST['lang'],
		'popup'	 	=> $_POST['popup'],
		'field_id'  => $_POST['field_id'],
		'fldr'	  	=> $_POST['fldr'],
	));

	header("location: dialog.php?" . $query);
}
