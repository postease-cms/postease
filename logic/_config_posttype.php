<?php

/*
 * Page Config
 * ------------------------------------------------------------------------------------------------ */
// Default
$target_posttype   = $_SESSION[$session_key]['config_posttype']['target_posttype'] = (empty($_GET['this_posttype'])) ? (empty($_SESSION[$session_key]['config_posttype']['target_posttype'])) ? null : $_SESSION[$session_key]['config_posttype']['target_posttype'] : $_GET['this_posttype'];
$page              = 'post';
$page_main         = $PageNum -> getMain($page);
$page_sub          = $PageNum -> getSubPost('config_posttype');
$page_title_target = ($page == 'post') ? $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name'] : TXT_CATEGORY_PAGETITLE_CONTACT;
$page_title_main   = TXT_CONFIGPOSTTYPE_PAGETITLEMAIN($page_title_target);
$page_icon         = 'fa-cog';

// Parameters
$mode    = (isset($_GET['mode']))    ? $_GET['mode']    : 1; // 1:Read 3:Execute
$process = (isset($_GET['process'])) ? $_GET['process'] : 0; // 2:Update
$target  = (isset($_POST['target'])) ? $_POST['target']  : null;

// Parameters of process message
$process_msg       = null;
$process_msg_style = null;
$process_msg_type  = null;

// print '<pre>';
// print_r($_POST);
// print '</pre>';
// exit;


/*
 * Update Data
 * ------------------------------------------------------------------------------------------------ */
if ($mode == 3)
{
	// Option Section
	if ($target == 'posttype_option')
	{
		// Shape comment_type to string
		if (! empty($_POST['comment_type']))
		{
			$_POST['comment_type'] = implode(',', $_POST['comment_type']);
		}
		else {
			$_POST['comment_type'] = '';
		}
	}

	try {
		$pdo -> beginTransaction();
		
		/*
		 * Permalink
		 * ------------------------------------------------------------------------------------------------ */
		if (isset($_POST['permalink_style']))
		{
			$permalink_type = (! empty($_POST['rewrite_url'])) ? 2 : 1;
			$permalink_base = (! empty($_POST['rewrite_url'])) ? $_POST['rewrite_url'] : $_POST['resource_url'];
			$consolidation_first  = ($permalink_type == 2) ? '/' : '?post_key=';
			$consolidation_common = ($permalink_type == 2) ? '/' : '-';
			
			$sql = "
					SELECT pb.id, pb.hash_id, pb.slug, pb.publish_datetime, pb.category_id, pt.title FROM {$table_prefix}posts_base AS pb
					LEFT JOIN {$table_prefix}posts_text AS pt ON pb.id = pt.base_id
					WHERE pb.delete_flg = 0 AND pb.posttype_id = {$_SESSION[$session_key]['common']['this_posttype']}
				";
			$read_records = $pdo->prepare($sql);
			$read_records -> execute();
			while($record = $read_records->fetch(PDO::FETCH_ASSOC))
			{
				$permalink_key = null;
				$permalink_url = null;
				$permalink_uri = null;
				$category_slug = null;
				$slug          = null;
				
				// Get slug
				if (! empty($record['slug']) || ! empty($record['title']))
				{
					$title_slug = (preg_match('/^[a-zA-Z0-9_-]+$/', preg_replace('/( |　)/', '', $record['title']))) ? preg_replace('/( |　)/', '-', $record['title']) : preg_replace('/( |　)/', '', $record['title']);
					$slug = (! empty($record['slug'])) ? $record['slug'] : $title_slug;
				}
				
				// Get category slug
				if (false !== in_array($_POST['permalink_style'], array(2, 4, 6, 7, 8)))
				{
					if ($record['category_id'] != '0000')
					{
						$category_ids = explode(',', $record['category_id']);
						$sql = "SELECT slug FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND id = {$category_ids[0]} AND posttype_id = {$_SESSION[$session_key]['common']['this_posttype']} AND classification = 1";
						$read_category = $pdo->prepare($sql);
						$read_category -> execute();
						if ($category = $read_category -> fetch(PDO::FETCH_ASSOC))
						{
							$category_slug = $category['slug'];
						}
					}
				}
				
				// Make permalink_key and permalink
				switch ($_POST['permalink_style'])
				{
					case 1:
						$permalink_key = $record['hash_id'];
						$permalink_url = $permalink_base . $consolidation_first . $record['hash_id'];
						break;
					case 2:
						$permalink_key = $record['hash_id'];
						if (! $category_slug)
						{
							break;
						}
						$permalink_url =  ($permalink_type == 2)
							? $permalink_url = $permalink_base . $consolidation_first . $category_slug . $consolidation_common . $record['hash_id']
							: $permalink_url = $permalink_base . $consolidation_first . $record['hash_id'];
						break;
					case 3:
						$permalink_key = $record['id'];
						$permalink_url = $permalink_base . $consolidation_first . $record['id'];
						break;
					case 4:
						$permalink_key = $record['id'];
						if (! $category_slug)
						{
							break;
						}
						$permalink_url =  ($permalink_type == 2)
							? $permalink_url = $permalink_base . $consolidation_first . $category_slug . $consolidation_common . $record['id']
							: $permalink_url = $permalink_base . $consolidation_first . $record['id'];
						break;
					case 5:
						if (! empty($slug))
						{
							$permalink_key = $slug;
							$permalink_url = $permalink_base . $consolidation_first . $slug;
						}
						break;
					case 6:
						if (! empty($category_slug) && ! empty($slug))
						{
							$permalink_key = $category_slug . '-' . $slug;
							$permalink_url = $permalink_base . $consolidation_first . $category_slug . $consolidation_common . $slug;
						}
						break;
					case 7:
						if (! empty($record['publish_datetime']) && ! empty($slug))
						{
							$permalink_key = substr($record['publish_datetime'],0, 10) . '-' . $slug;
							$date = ($permalink_type == 2) ? str_replace('-', '/', substr($record['publish_datetime'],0, 10)) : substr($record['publish_datetime'],0, 10);
							$permalink_url = $permalink_base . $consolidation_first . $date . $consolidation_common . $slug;
						}
						break;
					case 8:
						if (! empty($record['publish_datetime']) && ! empty($slug))
						{
							$permalink_key = substr($record['publish_datetime'],0, 7) . '-' . $slug;
							$date = ($permalink_type == 2) ? str_replace('-', '/', substr($record['publish_datetime'],0, 7)) : substr($record['publish_datetime'],0, 10);
							$permalink_url = $permalink_base . $consolidation_first . $date . $consolidation_common . $slug;
						}
						break;
				}
				$permalink_uri = fetchUriFromUrl($permalink_url, true);
				$sql = "
					UPDATE {$table_prefix}posts_base SET
						permalink_key = :PERMALINK_KEY,
						permalink_uri = :PERMALINK_URI
					WHERE id = :ID
				";
				$update_record = $pdo->prepare($sql);
				$update_record -> bindValue(':PERMALINK_KEY', $permalink_key, PDO::PARAM_STR);
				$update_record -> bindValue(':PERMALINK_URI', $permalink_uri, PDO::PARAM_STR);
				$update_record -> bindValue(':ID', $record['id'], PDO::PARAM_INT);
				$update_record -> execute();
				unset($update_record);
				
				$_POST['use_slug_flg']       = (intval($_POST['permalink_style']) >= 5) ? 1 : 0;
				$_POST['permalink_base_prd'] = fetchDomainFromUrl($permalink_base, true);
			}
		}
		
		/*
		 * Common Update
		 * ------------------------------------------------------------------------------------------------ */
		foreach ($_POST as $item => $value)
		{
			$site_id = (false !== array_key_exists($item, $posttype_mata_individual)) ? $_SESSION[$session_key]['common']['this_site'] : 0;
			$sql = "
					UPDATE {$table_prefix}configs_posttype SET
						value = :VALUE
					WHERE site_id = :SITE_ID AND posttype_id = :POSTTYPE_ID AND item = :ITEM
			";
			$update_record = $pdo->prepare($sql);
			$update_record -> bindValue(':SITE_ID',     $site_id);
			$update_record -> bindValue(':POSTTYPE_ID', $target_posttype);
			$update_record -> bindValue(':VALUE',       $value);
			$update_record -> bindValue(':ITEM',        $item);
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
		header("Location: ./?view_page=config_posttype&process=19&error_code=89");
		//var_dump($e->getMessage());
		exit;
	}
	header("Location: ./?view_page=config_posttype&process=2&target={$target}&change=1&clear=1");
	exit;
}


/*
 * Set Process Message
 * ------------------------------------------------------------------------------------------------ */
if (isset($_GET['process']) && $_GET['process'] == 2)
{
	$process_msg = TXT_CONFIGGENERAL_MSG_UPDATED;
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
$records = array();
try {
	// Config core
	$sql = "
			SELECT *
			FROM {$table_prefix}configs_posttype
			WHERE (site_id = {$_SESSION[$session_key]['common']['this_site']} OR site_id = 0) AND posttype_id = {$target_posttype}
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
	
	
	/*
   * Create lacked item
   * ------------------------------------------------------------------------------------------------ */
	foreach ($posttype_mata_individual as $item => $value)
	{
		if (false === array_key_exists($item, $records))
		{
			$records[$item]['value'] = $value;
			$sql = "
				INSERT INTO {$table_prefix}configs_posttype
					( site_id,  posttype_id,  item,  value)
				VALUES
					(:SITE_ID, :POSTTYPE_ID, :ITEM, :VALUE)
				";
			$create_record = $pdo->prepare($sql);
			$create_record -> bindValue('SITE_ID',      $_SESSION[$session_key]['common']['this_site']);
			$create_record -> bindValue('POSTTYPE_ID',  $_SESSION[$session_key]['common']['this_posttype']);
			$create_record -> bindValue('ITEM',         $item);
			$create_record -> bindValue('VALUE',        $value);
			$create_record -> execute();
			unset($create_record);
		}
	}
	
	/*
   * Get Image frames
   * ------------------------------------------------------------------------------------------------ */
	$image_frames = array();
	$sql = "
		SELECT * FROM {$table_prefix}image_frames
		WHERE status = 1 AND ((parent_dir = 'fr_admin' AND child_dir = 'eyecatch') OR (parent_dir = 'fr_auto' OR parent_dir = 'fr_crop'))
	";
	$read_records = $pdo->prepare($sql);
	$read_records -> execute();
	while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
	{
		$image_frames[] = $record;
	}
	unset($read_records);
	
}
catch(PDOException $e)
{
	$read_error = 1;
	header("Location: ./?view_page=error&page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}

// print '<pre>';
// print_r($image_frames);
// print '</pre>';
// exit;