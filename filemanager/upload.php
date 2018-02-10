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
   $storeFolder = $_POST['path'];
   $storeFolderThumb = $_POST['path_thumb'];
}
else
{
   $storeFolder = $current_path.$_POST["fldr"]; // correct for when IE is in Compatibility mode
   $storeFolderThumb = $thumbs_base_path.$_POST["fldr"];
}

$path_pos  = strpos($storeFolder,$current_path);
$thumb_pos = strpos($storeFolderThumb,$thumbs_base_path);

if ($path_pos!==0
	|| $thumb_pos !==0
	|| strpos($storeFolderThumb,'../',strlen($thumbs_base_path)) !== FALSE
	|| strpos($storeFolderThumb,'./',strlen($thumbs_base_path)) !== FALSE
	|| strpos($storeFolder,'../',strlen($current_path)) !== FALSE
	|| strpos($storeFolder,'./',strlen($current_path)) !== FALSE )
		die('wrong path');


$path = $storeFolder;
$cycle = TRUE;
$max_cycles = 50;
$i = 0;
while ($cycle && $i < $max_cycles)
{
	$i++;
	if ($path == $current_path) $cycle = FALSE;
	if (file_exists($path."config.php"))
	{
		require_once $path."config.php";
		$cycle = FALSE;
	}
	$path = fix_dirname($path).'/';
}


if ( ! empty($_FILES))
{
	$info = pathinfo($_FILES['file']['name']);

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

	if (in_array(fix_strtolower($info['extension']), $ext))
	{
		$tempFile = $_FILES['file']['tmp_name'];
		$targetPath = $storeFolder;
		$targetPathThumb = $storeFolderThumb;
		$_FILES['file']['name'] = fix_filename($_FILES['file']['name'],$transliteration,$convert_spaces, $replace_with);

	 	// Gen. new file name if exists
		if (file_exists($targetPath.$_FILES['file']['name']))
		{
			$i = 1;
			$info = pathinfo($_FILES['file']['name']);

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

			// append number
			while(file_exists($targetPath.$info['filename']."_".$i.".".$info['extension'])) {
				$i++;
			}
			$_FILES['file']['name'] = $info['filename']."_".$i.".".$info['extension'];
		}

		$targetFile =  $targetPath. $_FILES['file']['name'];
		$targetFileThumb =  $targetPathThumb. $_FILES['file']['name'];

		// check if image (and supported)
		if (in_array(fix_strtolower($info['extension']),$ext_img)) $is_img=TRUE;
		else $is_img=FALSE;

		// upload
		move_uploaded_file($tempFile,$targetFile);
		chmod($targetFile, 0755);

		if ($is_img)
		{
			$memory_error = FALSE;
			if ( ! create_img($targetFile, $targetFileThumb, 122, 91))
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
				header('HTTP/1.1 406 Not enought Memory',TRUE,406);
				exit();
			}
		}
		$_FILES['file']['name'];
	}
	else // file ext. is not in the allowed list
	{
		header('HTTP/1.1 406 file not permitted',TRUE,406);
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
