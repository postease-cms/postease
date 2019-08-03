<?php

/*
 * Page Config
 * ------------------------------------------------------------------------------------------------ */
// Default
$page_main       = $PageNum -> getMain('config');
$page_sub        = 3;
$page_title_main = TXT_CONFIGCORE_PAGETITLEMAIN;
$page_title_sub  = TXT_CONFIGCORE_PAGETITLESUB;
$page_icon       = 'fa-cog';

// Parameters
$mode    = (isset($_GET['mode']))     ? $_GET['mode']     : 1; // 1:Read 3:Execute
$process = (isset($_POST['process'])) ? $_POST['process'] : 0; // 2:Update
$target  = (isset($_POST['target']))  ? $_POST['target']  : null;

// Parameters of process message
$process_msg       = null;
$process_msg_style = null;
$process_msg_type  = null;

// Get this domain and this dir_name
$this_protocol = (isset($_SERVER['HTTPS']) && (! in_array(strtolower($_SERVER['HTTPS']), array('off', 'no')) || $_SERVER['SERVER_PORT']) == 443) ? 'https' : 'http';
$this_domain   = $this_protocol . '://' . $_SERVER['HTTP_HOST'];
$this_dir_name = ltrim(rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/'), '/');


// print '<pre>';
// print_r($_POST);
// print '</pre>';
// exit;


/*
 * Update Data
 * ------------------------------------------------------------------------------------------------ */
if ($mode == 3 && ! empty($target))
{

	// System Section
	if ($target == 'core_system')
	{

		// Check session-key (With error retrun)
		if (! empty($_POST['session_key']))
		{
			if ($_POST['session_key'] != $_SESSION[$session_key]['configs']['session_key'])
			{
				if (! preg_match('/^[a-zA-Z0-9_-]+$/', $_POST['session_key']))
				{
					header("Location: ./?view_page=config_core&process=19&error_code=83");
					exit;
				}
			}
		}
		else {
			header("Location: ./?view_page=config_core&process=19&error_code=83");
			exit;
		}

		// Check defaul-password (With error retrun)
		if (! empty($_POST['default_password']))
		{
			if ($_POST['default_password'] != $_SESSION[$session_key]['configs']['default_password'])
			{
				if (! preg_match('/^[a-z0-9]+$/', $_POST['default_password']))
				{
					header("Location: ./?view_page=config_core&process=19&error_code=85");
					exit;
				}
			}
		}
		else {
			header("Location: ./?view_page=config_core&process=19&error_code=85");
			exit;
		}

		// Auto correct domain and dir_name
		if (isset($_POST['auto_correct']))
		{
			$_POST['domain']   = $this_domain;
			$_POST['dir_name'] = $this_dir_name;
		}

    $upload_uri_old = (empty($_SESSION[$session_key]['configs']['dir_name'])) ? $_SESSION[$session_key]['configs']['domain'] . '/upload/' : $_SESSION[$session_key]['configs']['domain'] . '/' . $_SESSION[$session_key]['configs']['dir_name'] . '/upload/';
    $upload_uri_new = (empty($this_dir_name)) ? $this_domain . '/upload/' : $this_domain . '/' . $this_dir_name . '/upload/';

		// Change Url
    if ((! empty($this_domain) && $this_domain != $_SESSION[$session_key]['configs']['domain']) || ($this_dir_name != $_SESSION[$session_key]['configs']['dir_name']))
    {
			try {
				$pdo -> beginTransaction();

				// check and rewrite path of posts-base
				$records = array();
				$sql = "SELECT id, eyecatch FROM {$table_prefix}posts_base WHERE eyecatch LIKE '%{$_SESSION[$session_key]['configs']['domain']}%'";
				$read_records = $pdo -> prepare($sql);
				$read_records -> execute();
				while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
				{
					$records[] = $record;
				}
				unset($read_records);
				if (! empty($records))
				{
					foreach ($records as $row)
					{
            $new_eyecatch = str_replace($upload_uri_old, $upload_uri_new, $row['eyecatch']);
						$sql = "
								UPDATE {$table_prefix}posts_base SET
									eyecatch = :NEW_EYECATCH
								WHERE id = :ID
						";
						$update_record = $pdo -> prepare($sql);
						$update_record -> bindValue('NEW_EYECATCH', $new_eyecatch);
						$update_record -> bindValue('ID',           $row['id']);
						$update_record -> execute();
						unset($update_record);
					}
				}

				// check and rewrite path of posts-text
				$records = array();
				$sql = "SELECT base_id, language_id, content FROM {$table_prefix}posts_text WHERE content LIKE '%{$_SESSION[$session_key]['configs']['domain']}%'";
				$read_records = $pdo -> prepare($sql);
				$read_records -> execute();
				$i = 0;
				while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
				{
					$records[$i]['base_id']     = $record['base_id'];
					$records[$i]['language_id'] = $record['language_id'];
					$records[$i]['content']     = htmlspecialchars($record['content']);
					$i ++;
				}
				unset($read_records);
				if (! empty($records))
				{
					foreach ($records as $row)
					{
						$row['content'];
            $new_content = str_replace($upload_uri_old, $upload_uri_new, $row['content']);
						$sql = "
								UPDATE {$table_prefix}posts_text SET
									content = :NEW_CONTENT
								WHERE
									base_id = :ID
									AND language_id = :LANGUAGE_ID
						";
						$update_record = $pdo -> prepare($sql);
						$update_record -> bindValue('NEW_CONTENT', htmlspecialchars_decode($new_content));
						$update_record -> bindValue('ID',          $row['base_id']);
						$update_record -> bindValue('LANGUAGE_ID', $row['language_id']);
						$update_record -> execute();
						unset($update_record);
					}
				}

				// check posts-custom
				$records = array();
				$sql = "SELECT base_id, language_id, custom_item_id, value FROM {$table_prefix}posts_custom WHERE value LIKE '%{$_SESSION[$session_key]['configs']['domain']}%'";
				$read_records = $pdo -> prepare($sql);
				$read_records -> execute();
				while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
				{
					$records[] = $record;
				}
				unset($read_records);
				if (! empty($records))
				{
					foreach ($records as $row)
					{
            $new_value = str_replace($upload_uri_old, $upload_uri_new, $row['value']);
						$sql = "
								UPDATE {$table_prefix}posts_custom SET
									value = :NEW_VALUE
								WHERE
									base_id = :ID
									AND language_id = :LANGUAGE_ID
									AND custom_item_id = :CUSTOM_ITEM_ID
						";
						$update_record = $pdo -> prepare($sql);
						$update_record -> bindValue('NEW_VALUE',      $new_value);
						$update_record -> bindValue('ID',             $row['base_id']);
						$update_record -> bindValue('LANGUAGE_ID',    $row['language_id']);
						$update_record -> bindValue('CUSTOM_ITEM_ID', $row['custom_item_id']);
						$update_record -> execute();
						unset($update_record);
					}
				}
				
				// Cache
				resetCacheParams();
				$pdo -> commit();

        if ($_SESSION[$session_key]['configs']['database'] == 1)
        {
          $sqlite_path_arr    = explode('/', SQLITE_PATH);
          $db_file_name       = end($sqlite_path_arr);
          $sqlite_path_real   = realpath(dirname(__FILE__) . '/../core/db/' . $db_file_name);
          $pdo_sqlite_content = "<?php\n\ndefine('SQLITE_PATH', '{$sqlite_path_real}');\n";
          $file = dirname(__FILE__).'/../core/db/pdo_sqlite.php';
          if (! file_put_contents($file, $pdo_sqlite_content, LOCK_EX))
          {
            header('Location: ./reset_system.php?errormsg=02');
            exit;
          }
        }
			}
			catch(PDOException $e)
			{
				$pdo -> rollBack();
				header("Location: ./?view_page=config_core&process=19&error_code=81");
				//var_dump($e->getMessage());
				exit;
			}
		}
		
		// Session Rewrite
		if ($session_key != $_POST['session_key'])
		{
			$_SESSION[$_POST['session_key']] = $_SESSION[$session_key];
			$_SESSION[$session_key] = array();
			unset($_SESSION[$session_key]);
		}
		
	}
	
	if ($target == 'core_api')
	{
		// Remote Address
		$remote_address_allowed = null;
		if (! empty($_POST['remote_address_allowed']))
		{
			$remote_address_allowed_arr = explode(',', $_POST['remote_address_allowed']);
			foreach ($remote_address_allowed_arr as $key => $value)
			{
				$remote_address_allowed_arr[$key] = mb_convert_kana(trim($value), 'arn');
			}
			$_POST['remote_address_allowed'] = $remote_address_allowed = implode(', ', $remote_address_allowed_arr);
		}
		
		// Origin
		$origin_allowed = null;
		if (! empty($_POST['origin_allowed']))
		{
			$origin_allowed_arr = explode(',', $_POST['origin_allowed']);
			foreach ($origin_allowed_arr as $key => $value)
			{
				$origin_allowed_arr[$key] = mb_convert_kana(trim($value), 'arn');
			}
			$_POST['origin_allowed'] = $origin_allowed = implode(', ', $origin_allowed_arr);
		}
		
		// Api Force Cache Time
		$api_force_cache_time = 0;
		if (isset($_POST['api_force_cache_time']))
		{
			$_POST['api_force_cache_time'] = $api_force_cache_time = intval($_POST['api_force_cache_time']);
		}
		
		// Regenerate Api Config File
		$api_config_path = dirname(__FILE__) . '/../core/api';
		$api_config_file_name = 'config.php';
		$api_config = "<?php\n\n\$origin_allowed = '{$origin_allowed}';\n\$remote_address_allowed = '{$remote_address_allowed}';\n\$api_force_cache_time = '{$api_force_cache_time}';\n";
		if (false === file_exists($api_config_path)) mkdir($api_config_path);
		file_put_contents($api_config_path . '/' . $api_config_file_name, $api_config);
	}


	// Media Section
	if ($target == 'core_media')
	{
		// Check and Change upload-dir-permission (With error retrun)
		if (! empty($_POST['upload_dir_permission']))
		{
			if ($_POST['upload_dir_permission'] != $_SESSION[$session_key]['configs']['upload_dir_permission'])
			{
				if (preg_match('/^\d{3}$/', intval($_POST['upload_dir_permission'])) && intval($_POST['upload_dir_permission']) <= 777)
				{
					$_POST['upload_dir_permission'] = intval($_POST['upload_dir_permission']);

					// Change permission
					$upload_path = dirname(__FILE__).'/../upload';
					$upload_dirs = getFileList($upload_path, 'dir');
					$upload_dirs[] = $upload_path;
					$permission  = sprintf('%04d', $_POST['upload_dir_permission']);
					foreach ($upload_dirs as $dir)
					{
						chmod($dir, octdec($permission));
					}
				}
				else {
					header("Location: ./?view_page=config_core&process=19&error_code=84");
					exit;
				}
			}
		}
		else {
			header("Location: ./?view_page=config_core&process=19&error_code=84");
			exit;
		}

		// Check upload-imagesize-main (With error retrun)
		$imagesize_default_width = 1200;
		if (empty($_POST['upload_imagesize_main_width']) && empty($_POST['upload_imagesize_main_height']))
		{
			$_POST['upload_imagesize_main_width'] = $imagesize_default_width;
		}
		else {
			if (! empty($_POST['upload_imagesize_main_width']) && $_POST['upload_imagesize_main_width'] != $_SESSION[$session_key]['configs']['upload_imagesize_main_width'])
			{
				if (! preg_match('/^[0-9]+$/', $_POST['upload_imagesize_main_width']))
				{
					header("Location: ./?view_page=config_core&process=19&error_code=86");
					exit;
				}
			}
			if (! empty($_POST['upload_imagesize_main_height']) && $_POST['upload_imagesize_main_height'] != $_SESSION[$session_key]['configs']['upload_imagesize_main_height'])
			{
				if (! preg_match('/^[0-9]+$/', $_POST['upload_imagesize_main_height']))
				{
					header("Location: ./?view_page=config_core&process=19&error_code=86");
					exit;
				}
			}
		}
	}


	// Update configs
	try {
		$pdo -> beginTransaction();

		foreach ($_POST as $item => $value)
		{
			$sql = "
					UPDATE {$table_prefix}configs SET
						value = :VALUE
					WHERE item = :ITEM
			";
			$update_record = $pdo -> prepare($sql);
			$update_record -> bindValue('VALUE', $value);
			$update_record -> bindValue('ITEM',  $item);
			$update_record -> execute();
			unset($update_record);
		}
		
		// Cache
		resetCacheParams();
		$pdo -> commit();
	}
	catch(PDOException $e)
	{
		$pdo -> rollBack();
		header("Location: ./?view_page=config_core&process=19&error_code=89");
		//var_dump($e->getMessage());
		exit;
	}
	header("Location: ./?view_page=config_core&process=2&target={$target}&change=1&clear=1");
	exit;
}


/*
 * Set Process Message
 * ------------------------------------------------------------------------------------------------ */
if (isset($_GET['process']) && $_GET['process'] == 2)
{
	$process_msg = TXT_CONFIGCORE_MSG_UPDATED;
	$process_msg_style = 'success';
	$process_msg_type  = 'Done';
}
if (isset($_GET['process']) && $_GET['process'] == 19 && isset($_GET['error_code']))
{
	$process_msg = $errormsg_list[$_GET['error_code']];
	$process_msg_style = 'danger';
	$process_msg_type  = 'Error';
}


/*
 * Fetch Data
 * ------------------------------------------------------------------------------------------------ */
$records  = array();
try {
	// Config core
	$sql = "
			SELECT *
			FROM {$table_prefix}configs
			WHERE classification = 'core'
	";
	$read_records = $pdo -> prepare($sql);
	$read_records -> execute();
	$record_counter = 0;
	while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
	{
		$records[$record['item']] = $record;
		$record_counter ++;
	}
	unset($read_records);

	// Timezone
	require_once dirname(__FILE__).'/../lib/timezone.php';
}
catch(PDOException $e)
{
	$read_error = 1;
	header("Location: ./?view_page=error&page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}

// Set invalid flg
$invalid_domain_flg   = ($records['domain']['value']   != $this_domain)   ? 1 : 0;
$invalid_dir_name_flg = ($records['dir_name']['value'] != $this_dir_name) ? 1 : 0;

// print '<pre>';
// print_r($records);
// print '</pre>';
// exit;