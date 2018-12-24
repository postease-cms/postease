<?php
require_once './_system_header.php';


/* PROCESS NUMBER
 -----------------

 [Post] Process
 -----------------
 11.Create Post
 12.Update Post
 19.Delete Post

 [Comment] Process
 -----------------
 21.Create comment
 22.Update comment (only memo and status)
 23.Update comment (all items)
 29.Delete comment

 [Contact] Process
 -----------------
 31.Create contact
 32.Update contact (only memo and status)
 23.Update contact (all items)
 39.Delete contact

 ----------------- */

// print '<pre>';
// print_r($_SESSION);
// print '</pre>';
// exit;


//print '<pre>';
//print_r($_POST);
//print '</pre>';
//exit;


/*
 * Common Parameters
 * ------------------------------------------------------------------------------------------------ */
$target_id   = (isset($_POST['target_id']))    ? $_POST['target_id']    : null;
$version     = (isset($_POST['version']))      ? $_POST['version']      : null;
$process     = (isset($_POST['process']))      ? $_POST['process']      : null;
$submit_type = (isset($_POST['submit_type']))  ? $_POST['submit_type']  : null;

// Media-parameter
$media_parameter = date('YmdHis');
$pattern_param   = '/\?v=\d{14}/';


/*
 * [Post] Process
 * ------------------------------------------------------------------------------------------------ */
if ($_SESSION[$session_key]['common']['view_page'] == 'post')
{
	// Make publish_datetime
	$publish_datetime = (! empty($_POST['publish_datetime'])) ? $_POST['publish_datetime'] . ':00' : null;
	if (! empty($publish_datetime) && (strtotime($publish_datetime) < strtotime('1900-01-01 00:00:00') || ! checkDatetime($publish_datetime)))
	{
		$publish_datetime = date('Y-m-d H:i') . ':00';
	}
	
	// Make publish_end_at
	$publish_end_at = (! empty($_POST['publish_end_at'])) ? $_POST['publish_end_at'] . ':00' : null;
	if (! empty($publish_end_at) && (strtotime($publish_end_at) < strtotime('1900-01-01 00:00:00') || ! checkDatetime($publish_end_at)))
	{
		$publish_end_at = date('Y-m-d H:i') . ':00';
	}

	// Make status from submit_type (execute only)
	$status = ($submit_type == 'publish') ? 1 : $_POST['status'];

	// Reset publish_datetime
	if (empty($publish_datetime) && $status == 1)
	{
		$publish_datetime = date('Y-m-d H:i') . ':00';
	}

	// Make categories
	$category_id = '0000';
	if (! empty($_POST['categories']))
	{
		foreach ($_POST['categories'] as $value)
		{
			$posted_categories[] = sprintf('%04d', $value);
		}
		$category_id = implode(',', $posted_categories);
	}

	// Make tags
	$tag_id = '0000';
	if (! empty($_POST['tags']))
	{
		foreach ($_POST['tags'] as $value)
		{
			$posted_tags[] = sprintf('%04d', $value);
		}
		$tag_id = implode(',', $posted_tags);
	}

	// Shape slug
	$slug = (! empty($_POST['slug'])) ? $_POST['slug'] : '';

	// Add Media-parameter to eyecatch
	$eyecatch = null;
	if (! empty($_POST['eyecatch']) && $_SESSION[$session_key]['configs']['media_parameter_flg'])
	{
		if (preg_match($pattern_param, $_POST['eyecatch'])) $_POST['eyecatch'] = preg_replace($pattern_param, '', $_POST['eyecatch']);
		$eyecatch = $_POST['eyecatch'].'?v='.$media_parameter;
	}

	// Convert image-src from relative path to complete path
	$replace_img = (! empty($_SESSION[$session_key]['configs']['dir_name']))
		? 'src="'.$_SESSION[$session_key]['configs']['domain'].'/'.$_SESSION[$session_key]['configs']['dir_name'].'/upload/fr_main/'
		: 'src="'.$_SESSION[$session_key]['configs']['domain'].'/upload/fr_main/';
	$replace_pdf = (! empty($_SESSION[$session_key]['configs']['dir_name']))
		? 'href="'.$_SESSION[$session_key]['configs']['domain'].'/'.$_SESSION[$session_key]['configs']['dir_name'].'/upload/fr_main/'
		: 'href="'.$_SESSION[$session_key]['configs']['domain'].'/upload/fr_main/';
	$target_img  = 'src="upload/fr_main/';
	$target_pdf  = 'href="upload/fr_main/';
	if (! empty($_POST['content']))
	{
		foreach ($_POST['content'] as $language_id => $value)
		{
			if (strstr($value, $target_img)) $_POST['content'][$language_id] = str_replace($target_img, $replace_img, $value);
			if (strstr($value, $target_pdf)) $_POST['content'][$language_id] = str_replace($target_pdf, $replace_pdf, $value);
		}

		// Add Media-parameter to content
		if ($_SESSION[$session_key]['configs']['media_parameter_flg'])
		{
			// remove media parameter
			foreach ($_POST['content'] as $language_id => $value)
			{
				if (preg_match($pattern_param, $value))
				{
					$_POST['content'][$language_id] = preg_replace($pattern_param, '', $value);
				}
			}
			// add media parameter
			foreach ($operators as $operator => $regex)
			{
				foreach ($_POST['content'] as $language_id => $value)
				{
					if (preg_match($regex, $value))
					{
						$_POST['content'][$language_id] = preg_replace($regex, $operator.'?v='.$media_parameter, $value);
					}
				}
			}
		}
	}

	// 11.Create Post
	if (! empty($process) && $process == 11)
	{
		try
		{
			$pdo -> beginTransaction();

			// Get new id
			$target_table = $table_prefix . 'posts_base';
			$new_id       = getNextId($target_table);
			$hash_id      = generateHashId($new_id);

			// Create posts_base
			$sql = "
					INSERT INTO {$table_prefix}posts_base
						( id,  version,  versioned_at,  hash_id,  permalink_key,  permalink_uri,  publish_datetime,  publish_end_at,  site_id,  posttype_id,  parent_id,  category_id,  tag_id,  slug,  eyecatch,  anchor,  created_at,  created_by,  grouped_by,  status)
					VALUES
						(:ID, :VERSION, :VERSIONED_AT, :HASH_ID, :PERMALINK_KEY, :PERMALINK_URI, :PUBLISH_DATETIME, :PUBLISH_END_AT, :SITE_ID, :POSTTYPE_ID, :PARENT_ID, :CATEGORY_ID, :TAG_ID, :SLUG, :EYECATCH, :ANCHOR, :CREATED_AT, :CREATED_BY, :GROUPED_BY, :STATUS)
			";
			$create_post_base = $pdo->prepare($sql);
			$create_post_base -> bindValue('ID',               $new_id);
			$create_post_base -> bindValue('VERSION',          $version);
			$create_post_base -> bindValue('VERSIONED_AT',     date('Y-m-d H:i:s'));
			$create_post_base -> bindValue('HASH_ID',          $hash_id);
			$create_post_base -> bindValue('PERMALINK_KEY',    $_POST['permalink_key']);
			$create_post_base -> bindValue('PERMALINK_URI',    $_POST['permalink_uri']);
			$create_post_base -> bindValue('PUBLISH_DATETIME', $publish_datetime);
			$create_post_base -> bindValue('PUBLISH_END_AT',   $publish_end_at);
			$create_post_base -> bindValue('SITE_ID',          $_POST['site_id']);
			$create_post_base -> bindValue('POSTTYPE_ID',      $_POST['posttype_id']);
			$create_post_base -> bindValue('PARENT_ID',        $_POST['parent_id']);
			$create_post_base -> bindValue('CATEGORY_ID',      $category_id);
			$create_post_base -> bindValue('TAG_ID',           $tag_id);
			$create_post_base -> bindValue('SLUG',             $slug);
			$create_post_base -> bindValue('EYECATCH',         $eyecatch);
			$create_post_base -> bindValue('ANCHOR',           $_POST['anchor']);
			$create_post_base -> bindValue('CREATED_AT',       date('Y-m-d H:i:s'));
			$create_post_base -> bindValue('CREATED_BY',       $_SESSION[$session_key]['user']['id']);
			$create_post_base -> bindValue('GROUPED_BY',       $_SESSION[$session_key]['user']['group_id']);
			$create_post_base -> bindValue('STATUS',           $status);
			$create_post_base -> execute();
			$count_insert = $create_post_base -> rowCount();
			unset($create_post_base);

			// Create posts_text
			if (! empty($count_insert))
			{
				foreach ($_POST['title'] as $language_id => $value)
				{
					$sql = "
							INSERT INTO {$table_prefix}posts_text
								(base_id,  language_id,  title,  addition,  content)
							VALUES
								(:BASE_ID, :LANGUAGE_ID, :TITLE, :ADDITION, :CONTENT)
					";
					$create_post_text = $pdo -> prepare($sql);
					$create_post_text -> bindValue('BASE_ID',     $new_id);
					$create_post_text -> bindValue('LANGUAGE_ID', $language_id);
					$create_post_text -> bindValue('TITLE',       $_POST['title'][$language_id]);
					$create_post_text -> bindValue('ADDITION',    $_POST['addition'][$language_id]);
					$create_post_text -> bindValue('CONTENT',     $_POST['content'][$language_id]);
					$create_post_text -> execute();
					unset($create_post_text);
				}
			}

			// Create post_custom
			if (! empty($count_insert) && ! empty($_POST['items']))
			{
				// Get registered custom_items
				$custom_items = array();
				$sql = "SELECT id, type FROM {$table_prefix}custom_items WHERE delete_flg = 0 AND status = 1";
				$read_custom_items = $pdo -> prepare($sql);
				$read_custom_items -> execute();
				while ($record = $read_custom_items -> fetch(PDO::FETCH_ASSOC))
				{
					$custom_items[$record['id']] = $record['type'];
				}
				unset($read_custom_items);

				foreach ($_POST['items'] as $custom_item_id => $data)
				{
					foreach ($data as $language_id => $value)
					{
						if (is_array($value))
						{
							$value = implode(',', $value);
						}

						// Add Media-parameter to image
						if ($custom_items[$custom_item_id] == 'image')
						{
							if (! empty($value) && $_SESSION[$session_key]['configs']['media_parameter_flg'])
							{
								if (preg_match($pattern_param, $value)) $value = preg_replace($pattern_param, '', $value);
								$value = $value.'?v='.$media_parameter;
							}
						}
						
						// Add Media-parameter to gallery
						if ($custom_items[$custom_item_id] == 'gallery')
						{
							if (!empty($value) && $_SESSION[$session_key]['configs']['media_parameter_flg'])
							{
								$prepared_data  = $str = str_replace(array("\r\n", "\r", "\n"), "\n", $value);
								$separated_data = explode("\n", $prepared_data);
								$urls_arr       = (!empty($separated_data[0])) ? explode(',', $separated_data[0]) : array();
								$gallery_arr    = array();
								foreach ($urls_arr as $url_key => $url)
								{
									if (preg_match($pattern_param, $url)) $url = preg_replace($pattern_param, '', $url);
									$gallery_arr[$url_key] = $url . '?v=' . $media_parameter;
								}
								$value = implode(',', $gallery_arr);
								if (!empty($separated_data[1])) $value .= ("\n" . $separated_data[1]);
							}
						}
							
						$sql = "
							INSERT INTO {$table_prefix}posts_custom
								(base_id,  language_id,  custom_item_id,  value)
							VALUES
								(:BASE_ID, :LANGUAGE_ID, :CUSTOM_ITEM_ID, :VALUE)
						";
						$create_post_custom = $pdo -> prepare($sql);
						$create_post_custom -> bindValue('BASE_ID',        $new_id);
						$create_post_custom -> bindValue('LANGUAGE_ID',    $language_id);
						$create_post_custom -> bindValue('CUSTOM_ITEM_ID', $custom_item_id);
						$create_post_custom -> bindValue('VALUE',          $value);
						$create_post_custom -> execute();
						unset($create_post_custom);
					}
				}
			}
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=post&process={$process}&id={$target_id}&errormsg=1");
			//var_dump($e -> getMessage());
			exit;
		}

		if (empty($_POST['parent_id']))
		{
			// Redirect to list When parent
			header("Location: ./?view_page=posts&process={$process}");
			exit;
		}
		else {
			// Redirect to detail of self When children
			header("Location: ./?view_page=post&id={$_POST['parent_id']}&version={$_POST['version']}&process=12&child_process={$process}");
			exit;
		}
	}

	// 12.Update Post
	if (! empty($process) && $process == 12 && ! empty($target_id) && ! empty($version))
	{
		try
		{
			$pdo -> beginTransaction();

			// Check children
			$children = array();
			$sql = "SELECT id FROM {$table_prefix}posts_base WHERE parent_id <> 0 AND parent_id = :PARENT_ID AND version = :VERSION";
			$search_children = $pdo -> prepare($sql);
			$search_children -> bindValue('PARENT_ID', $target_id);
			$search_children -> bindValue('VERSION',   $version);
			$search_children -> execute();
			while ($record = $search_children -> fetch(PDO::FETCH_ASSOC))
			{
				$children[] = $record['id'];
			}

			// Update posts_base (parent)
			$sql = "
					UPDATE {$table_prefix}posts_base SET
						permalink_key    = :PERMALINK_KEY,
						permalink_uri    = :PERMALINK_URI,
						publish_datetime = :PUBLISH_DATETIME,
						publish_end_at   = :PUBLISH_END_AT,
						site_id          = :SITE_ID,
						posttype_id      = :POSTTYPE_ID,
						category_id      = :CATEGORY_ID,
						tag_id           = :TAG_ID,
						slug             = :SLUG,
						eyecatch         = :EYECATCH,
						anchor           = :ANCHOR,
						updated_at       = :UPDATED_AT,
						updated_by       = :UPDATED_BY,
						grouped_by       = :GROUPED_BY,
						status           = :STATUS
					WHERE id = :ID AND version = :VERSION
			";
			$update_post_base = $pdo -> prepare($sql);
			$update_post_base -> bindValue('PERMALINK_KEY',    $_POST['permalink_key']);
			$update_post_base -> bindValue('PERMALINK_URI',    $_POST['permalink_uri']);
			$update_post_base -> bindValue('PUBLISH_DATETIME', $publish_datetime);
			$update_post_base -> bindValue('PUBLISH_END_AT',   $publish_end_at);
			$update_post_base -> bindValue('SITE_ID',          $_POST['site_id']);
			$update_post_base -> bindValue('POSTTYPE_ID',      $_POST['posttype_id']);
			$update_post_base -> bindValue('CATEGORY_ID',      $category_id);
			$update_post_base -> bindValue('TAG_ID',           $tag_id);
			$update_post_base -> bindValue('SLUG',             $slug);
			$update_post_base -> bindValue('EYECATCH',         $eyecatch);
			$update_post_base -> bindValue('ANCHOR',           $_POST['anchor']);
			$update_post_base -> bindValue('UPDATED_AT',       date('Y-m-d H:i:s'));
			$update_post_base -> bindValue('UPDATED_BY',       $_SESSION[$session_key]['user']['id']);
			$update_post_base -> bindValue('GROUPED_BY',       $_SESSION[$session_key]['user']['group_id']);
			$update_post_base -> bindValue('STATUS',           $status);
			$update_post_base -> bindValue('ID',               $target_id);
			$update_post_base -> bindValue('VERSION',          $version);
			$update_post_base -> execute();
			unset($update_post_base);

			// Update posts_base (children)
			// ! items to copy from parent
			if (! empty($children))
			{
				$sql = "
						UPDATE {$table_prefix}posts_base SET
							publish_datetime = :PUBLISH_DATETIME,
							publish_end_at   = :PUBLISH_END_AT,
							site_id          = :SITE_ID,
							posttype_id      = :POSTTYPE_ID,
							category_id      = :CATEGORY_ID,
							tag_id           = :TAG_ID,
							anchor           = :ANCHOR
						WHERE parent_id = :PARENT_ID AND version = :VERSION
				";
				$update_posts_base = $pdo -> prepare($sql);
				$update_posts_base -> bindValue('PUBLISH_DATETIME', $publish_datetime);
				$update_posts_base -> bindValue('PUBLISH_END_AT',   $publish_end_at);
				$update_posts_base -> bindValue('SITE_ID',          $_POST['site_id']);
				$update_posts_base -> bindValue('POSTTYPE_ID',      $_POST['posttype_id']);
				$update_posts_base -> bindValue('CATEGORY_ID',      $category_id);
				$update_posts_base -> bindValue('TAG_ID',           $tag_id);
				$update_posts_base -> bindValue('ANCHOR',           $_POST['anchor']);
				$update_posts_base -> bindValue('PARENT_ID',        $target_id);
				$update_posts_base -> bindValue('VERSION',          $version);
				$update_posts_base -> execute();
				unset($update_posts_base);
			}

			// Update or Create posts_text
			foreach ($_SESSION[$session_key]['common']['languages'] as $language_id => $value)
			{
				// check exist
				$sql = "SELECT COUNT(base_id) AS count FROM {$table_prefix}posts_text WHERE base_id = {$target_id} AND base_version = {$version} AND language_id = {$language_id}";
				$search_posts_text = $pdo -> prepare($sql);
				$search_posts_text -> execute();
				if ($posts_text = $search_posts_text -> fetch(PDO::FETCH_ASSOC))
				{
					unset($search_posts_text);
				}

				// Update
				if ($posts_text['count'])
				{
					// parent
					$sql = "
							UPDATE {$table_prefix}posts_text SET
								title    = :TITLE,
								addition = :ADDITION,
								content  = :CONTENT
							WHERE base_id = :BASE_ID AND base_version = :BASE_VERSION AND language_id = :LANGUAGE_ID
					";
					$update_post_text = $pdo -> prepare($sql);
					$update_post_text -> bindValue('TITLE',        $_POST['title'][$language_id]);
					$update_post_text -> bindValue('ADDITION',     $_POST['addition'][$language_id]);
					$update_post_text -> bindValue('CONTENT',      $_POST['content'][$language_id]);
					$update_post_text -> bindValue('BASE_ID',      $target_id);
					$update_post_text -> bindValue('BASE_VERSION', $version);
					$update_post_text -> bindValue('LANGUAGE_ID',  $language_id);
					$update_post_text -> execute();
					unset($update_post_text);

					// children
					if (! empty($children))
					{
						foreach ($children as $child_id)
						{
							$sql = "
									UPDATE {$table_prefix}posts_text SET
										title = :TITLE
									WHERE base_id = :BASE_ID AND base_version = :BASE_VERSION AND language_id = :LANGUAGE_ID
							";
							$update_post_text = $pdo -> prepare($sql);
							$update_post_text -> bindValue('TITLE',        $_POST['title'][$language_id]);
							$update_post_text -> bindValue('BASE_ID',      $child_id);
							$update_post_text -> bindValue('BASE_VERSION', $version);
							$update_post_text -> bindValue('LANGUAGE_ID',  $language_id);
							$update_post_text -> execute();
							unset($update_post_text);
						}
					}
				}

				// Create
				else {
					// parent
					$sql = "
							INSERT INTO {$table_prefix}posts_text
								( base_id,  base_version,  language_id,  title,  addition,  content)
							VALUES
								(:BASE_ID, :BASE_VERSION, :LANGUAGE_ID, :TITLE, :ADDITION, :CONTENT)
					";
					$create_post_text = $pdo -> prepare($sql);
					$create_post_text->bindValue('BASE_ID',      $target_id);
					$create_post_text->bindValue('BASE_VERSION', $version);
					$create_post_text->bindValue('LANGUAGE_ID',  $language_id);
					$create_post_text->bindValue('TITLE',        $_POST['title'][$language_id]);
					$create_post_text->bindValue('ADDITION',     $_POST['addition'][$language_id]);
					$create_post_text->bindValue('CONTENT',      $_POST['content'][$language_id]);
					$create_post_text->execute();
					unset($create_post_text);

					// children
					if (! empty($children))
					{
						foreach ($children as $child_id)
						{
							$sql = "
									INSERT INTO {$table_prefix}posts_text
										( base_id,  base_version,  language_id,  title)
									VALUES
										(:BASE_ID, :BASE_VERSION, :LANGUAGE_ID, :TITLE)
							";
							$create_post_text = $pdo -> prepare($sql);
							$create_post_text->bindValue('BASE_ID',      $child_id);
							$create_post_text->bindValue('BASE_VERSION', $version);
							$create_post_text->bindValue('LANGUAGE_ID',  $language_id);
							$create_post_text->bindValue('TITLE',        $_POST['title'][$language_id]);
							$create_post_text->execute();
							unset($create_post_text);
						}
					}
				}
			}

			// Update or Create post_custom
			if (! empty($target_id) && ! empty($_POST['items']))
			{
				// Get registered custom_items
				$custom_items = array();
				$sql = "SELECT id, type FROM {$table_prefix}custom_items WHERE delete_flg = 0 AND status = 1";
				$read_custom_items = $pdo -> prepare($sql);
				$read_custom_items -> execute();
				while ($record = $read_custom_items -> fetch(PDO::FETCH_ASSOC))
				{
					$custom_items[$record['id']] = $record['type'];
				}
				unset($read_custom_items);

				foreach ($_POST['items'] as $custom_item_id => $data)
				{
					foreach ($data as $language_id => $value)
					{
						if (is_array($value))
						{
							$value = implode(',', $value);
						}

						// Add Media-parameter to image
						if ($custom_items[$custom_item_id] == 'image')
						{
							if (! empty($value) && $_SESSION[$session_key]['configs']['media_parameter_flg'])
							{
								if (preg_match($pattern_param, $value)) $value = preg_replace($pattern_param, '', $value);
								$value = $value.'?v='.$media_parameter;
							}
						}
						
						// Add Media-parameter to gallery
						if ($custom_items[$custom_item_id] == 'gallery')
						{
							if (!empty($value) && $_SESSION[$session_key]['configs']['media_parameter_flg'])
							{
								$prepared_data  = $str = str_replace(array("\r\n", "\r", "\n"), "\n", $value);
								$separated_data = explode("\n", $prepared_data);
								$urls_arr       = (!empty($separated_data[0])) ? explode(',', $separated_data[0]) : array();
								$gallery_arr    = array();
								foreach ($urls_arr as $url_key => $url)
								{
									if (preg_match($pattern_param, $url)) $url = preg_replace($pattern_param, '', $url);
									$gallery_arr[$url_key] = $url . '?v=' . $media_parameter;
								}
								$value = implode(',', $gallery_arr);
								if (!empty($separated_data[1])) $value .= ("\n" . $separated_data[1]);
							}
						}

						// Check exist
						$sql = "
								SELECT COUNT(base_id) AS count
								FROM {$table_prefix}posts_custom
								WHERE
									base_id = {$target_id}
									AND base_version = {$version}
									AND language_id = {$language_id}
									AND custom_item_id = {$custom_item_id}
						";
						$search_posts_custom = $pdo -> prepare($sql);
						$search_posts_custom -> execute();
						if ($posts_custom = $search_posts_custom -> fetch(PDO::FETCH_ASSOC))
						{
							unset($search_posts_custom);
						}

						// Update
						if ($posts_custom['count'])
						{
							$sql = "
									UPDATE {$table_prefix}posts_custom SET
										value = :VALUE
									WHERE
										base_id = :BASE_ID
										AND language_id = :LANGUAGE_ID
										AND base_version = :BASE_VERSION
										AND custom_item_id = :CUSTOM_ITEM_ID
							";
							$update_post_custom = $pdo -> prepare($sql);
							$update_post_custom -> bindValue('VALUE',          $value);
							$update_post_custom -> bindValue('BASE_ID',        $target_id);
							$update_post_custom -> bindValue('BASE_VERSION',   $version);
							$update_post_custom -> bindValue('LANGUAGE_ID',    $language_id);
							$update_post_custom -> bindValue('CUSTOM_ITEM_ID', $custom_item_id);
							$update_post_custom -> execute();
							unset($update_post_custom);
						}

						// Create
						else {
							$sql = "
									INSERT INTO {$table_prefix}posts_custom
										( base_id,  base_version,  language_id,  custom_item_id,  value)
									VALUES
										(:BASE_ID, :BASE_VERSION, :LANGUAGE_ID, :CUSTOM_ITEM_ID, :VALUE)
							";
							$create_post_custom = $pdo -> prepare($sql);
							$create_post_custom -> bindValue('BASE_ID',        $target_id);
							$create_post_custom -> bindValue('BASE_VERSION',   $version);
							$create_post_custom -> bindValue('LANGUAGE_ID',    $language_id);
							$create_post_custom -> bindValue('CUSTOM_ITEM_ID', $custom_item_id);
							$create_post_custom -> bindValue('VALUE',          $value);
							$create_post_custom -> execute();
							unset($create_post_custom);
						}
					}
				}
			}

			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=post&process={$process}&id={$target_id}&version={$version}&errormsg=2");
			//var_dump($e -> getMessage());
			exit;
		}
		if (empty($_POST['parent_id']))
		{
			// Redirect to list When parent
			header("Location: ./?view_page=posts&process={$process}&id={$target_id}&number=1");
			exit;
		}
		else {
			// Redirect to detail of parent When children
			header("Location: ./?view_page=post&id={$_POST['parent_id']}&version={$_POST['version']}&process=12&child_process={$process}");
			exit;
		}
	}

	// 19.Delete Post
	if (! empty($process) && $process == 19 && ! empty($target_id))
	{
		try {
			$pdo -> beginTransaction();

			// When Parent
			if (empty($_POST['parent_id']))
			{
				// When Private(delete parent and children of version)
				if (empty($_POST['current_flg']))
				{
					$sql = "
							UPDATE {$table_prefix}posts_base SET
								updated_at = :UPDATED_AT,
								updated_by = :UPDATED_BY,
								delete_flg = 1
							WHERE (id = :ID OR parent_id = :ID) AND version = :VERSION
					";
				}
				// When Current(delete all)
				else {
					$sql = "
							UPDATE {$table_prefix}posts_base SET
								updated_at = :UPDATED_AT,
								updated_by = :UPDATED_BY,
								delete_flg = 1
							WHERE (id = :ID OR parent_id = :ID) AND version = :VERSION
					";
				}
			}
			// When Child (delete as one)
			else {
				$sql = "
						UPDATE {$table_prefix}posts_base SET
							updated_at = :UPDATED_AT,
							updated_by = :UPDATED_BY,
							delete_flg = 1
						WHERE id = :ID AND version = :VERSION
				";
			}
			$update_posts_base = $pdo -> prepare($sql);
			$update_posts_base -> bindValue('UPDATED_AT', date('Y-m-d H:i:s'));
			$update_posts_base -> bindValue('UPDATED_BY', $_SESSION[$session_key]['user']['id']);
			$update_posts_base -> bindValue('ID',         $target_id);
			$update_posts_base -> bindValue('VERSION',    $version);
			$update_posts_base -> execute();
			unset($update_posts_base);

			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=post&process={$process}&id={$target_id}&version={$version}&errormsg=3");
			//var_dump($e -> getMessage());
			exit;
		}

		// When parent
		if (empty($_POST['parent_id']))
		{
			if (empty($_POST['current_flg']))
			{
				// Redirect to detail of current version
				header("Location: ./?view_page=post&id={$target_id}&process=12&version_process={$process}");
				exit;
			}
			else {
				// Redirect to list
				header("Location: ./?view_page=posts&process={$process}&id={$target_id}&number=1");
				exit;
			}
		}
		// When child
		else {
			// Redirect to detail of parent
			header("Location: ./?view_page=post&id={$_POST['parent_id']}&version={$_POST['version']}&process=12&child_process={$process}");
			exit;
		}
	}
}


/*
 * [Comment] Process
 * ------------------------------------------------------------------------------------------------ */
if ($_SESSION[$session_key]['common']['view_page'] == 'comment')
{
	// Set type
	$type = (isset($_POST['type'])) ? $_POST['type'] : 1;

	// Reset process for type 3
	if (isset($_POST['type']) && $_POST['type'] == 3 && $process == 22) $process = 23;

	// Make posted_at
	$posted_at = (! empty($_POST['posted_at'])) ? $_POST['posted_at'].':00' : $posted_at = date('Y-m-d H:i:s');
	if (strtotime($posted_at) < strtotime('1900-01-01 00:00:00') || ! checkDatetime($posted_at))
	{
		$posted_at = date('Y-m-d H:i:s');
	}

	// Fix null items
	$eyecatch = (! empty($_POST['eyecatch'])) ? $_POST['eyecatch'] : null;
	$note     = (! empty($_POST['note']))     ? $_POST['note']     : null;

	// 21.Create comment
	if (! empty($process) && $process == 21)
	{
		try {
			$pdo -> beginTransaction();
			$sql = "
					INSERT INTO {$table_prefix}comments
						( post_id,  comment_id,  parent_id,  site_id,  posttype_id,  type,  score,  nickname,  email,  eyecatch,  title,  content,  note,  posted_at,  posted_by,  status)
					VALUES
						(:POST_ID, :COMMENT_ID, :PARENT_ID, :SITE_ID, :POSTTYPE_ID, :TYPE, :SCORE, :NICKNAME, :EMAIL, :EYECATCH, :TITLE, :CONTENT, :NOTE, :POSTED_AT, :POSTED_BY, :STATUS)
			";
			$create_comment = $pdo -> prepare($sql);
			$create_comment -> bindValue(':POST_ID',     $_POST['post_id']);
			$create_comment -> bindValue(':COMMENT_ID',  $_POST['comment_id']);
			$create_comment -> bindValue(':PARENT_ID',   $_POST['parent_id']);
			$create_comment -> bindValue(':SITE_ID',     $_SESSION[$session_key]['common']['this_site']);
			$create_comment -> bindValue(':POSTTYPE_ID', $_SESSION[$session_key]['common']['this_posttype']);
			$create_comment -> bindValue(':TYPE',        $type);
			$create_comment -> bindValue(':SCORE',       $_POST['score']);
			$create_comment -> bindValue(':NICKNAME',    $_POST['nickname']);
			$create_comment -> bindValue(':EMAIL',       $_POST['email']);
			$create_comment -> bindValue(':EYECATCH',    $eyecatch);
			$create_comment -> bindValue(':TITLE',       $_POST['title']);
			$create_comment -> bindValue(':CONTENT',     $_POST['content']);
			$create_comment -> bindValue(':NOTE',        $note);
			$create_comment -> bindValue(':POSTED_AT',   $posted_at);
			$create_comment -> bindValue(':POSTED_BY',   $_SESSION[$session_key]['user']['id']);
			$create_comment -> bindValue(':STATUS',      $_POST['status']);
			$create_comment -> execute();
			unset($create_comment);
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=comment&process={$process}&errormsg=1");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=comments&process={$process}&type={$type}");
		exit;
	}

	// 22.Update comment (only memo and status)
	if (! empty($process) && $process == 22 && ! empty($target_id))
	{
		// Make status
		$status = (isset($_POST['status'])) ? $_POST['status'] : 2;

		try {
			$pdo -> beginTransaction();
			$sql = "
					UPDATE {$table_prefix}comments SET
						note       = :NOTE,
						updated_at = :UPDATED_AT,
						updated_by = :UPDATED_BY,
						status     = :STATUS
					WHERE id = :ID
			";
			$update_comment = $pdo->prepare($sql);
			$update_comment -> bindValue(':NOTE',       $_POST['note']);
			$update_comment -> bindValue(':UPDATED_AT', date('Y-m-d H:i:s'));
			$update_comment -> bindValue(':UPDATED_BY', $_SESSION[$session_key]['user']['id']);
			$update_comment -> bindValue(':STATUS',     $status);
			$update_comment -> bindValue(':ID',         $target_id);
			$update_comment -> execute();
			unset($update_comment);
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=comment&process={$process}&id={$target_id}&errormsg=2");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=comments&process={$process}&id={$target_id}&type={$type}&number=1");
		exit;
	}

	// 23.Update comment (all items)
	if (! empty($process) && $process == 23 && ! empty($target_id))
	{
		try {
			$pdo -> beginTransaction();
			$sql = "
					UPDATE {$table_prefix}comments SET
						score      = :SCORE,
						nickname   = :NICKNAME,
						email      = :EMAIL,
						eyecatch   = :EYECATCH,
						title      = :TITLE,
						content    = :CONTENT,
						note       = :NOTE,
						posted_at  = :POSTED_AT,
						updated_at = :UPDATED_AT,
						updated_by = :UPDATED_BY,
						status     = :STATUS
					WHERE id = :ID
			";
			$update_comment = $pdo -> prepare($sql);
			$update_comment -> bindValue(':SCORE',      $_POST['score']);
			$update_comment -> bindValue(':NICKNAME',   $_POST['nickname']);
			$update_comment -> bindValue(':EMAIL',      $_POST['email']);
			$update_comment -> bindValue(':EYECATCH',   $eyecatch);
			$update_comment -> bindValue(':TITLE',      $_POST['title']);
			$update_comment -> bindValue(':CONTENT',    $_POST['content']);
			$update_comment -> bindValue(':NOTE',       $note);
			$update_comment -> bindValue(':POSTED_AT',  $posted_at);
			$update_comment -> bindValue(':UPDATED_AT', date('Y-m-d H:i:s'));
			$update_comment -> bindValue(':UPDATED_BY', $_SESSION[$session_key]['user']['id']);
			$update_comment -> bindValue(':STATUS',     $_POST['status']);
			$update_comment -> bindValue(':ID',         $target_id);
			$update_comment -> execute();
			unset($update_comment);
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=comment&process={$process}&id={$target_id}&errormsg=2");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=comments&process={$process}&id={$target_id}&type={$type}&number=1");
		exit;
	}

	// 29.Delete comment
	if (! empty($process) && $process == 29 && ! empty($target_id))
	{
		try {
			$pdo -> beginTransaction();
			$sql = "
					UPDATE {$table_prefix}comments SET
						updated_at = :UPDATED_AT,
						updated_by = :UPDATED_BY,
						delete_flg = 1
					WHERE id = :ID OR comment_id = :ID
				";
			$update_comment = $pdo -> prepare($sql);
			$update_comment -> bindValue(':UPDATED_AT', date('Y-m-d H:i:s'));
			$update_comment -> bindValue(':UPDATED_BY', $_SESSION[$session_key]['user']['id']);
			$update_comment -> bindValue(':ID',         $target_id);
			$update_comment -> execute();
			unset($update_comment);
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=comment&process={$process}&id={$target_id}&errormsg=3");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=comments&process={$process}&id={$target_id}&type={$type}&number=1");
		exit;
	}
}


/*
 * [Contact] Process
 * ------------------------------------------------------------------------------------------------ */
if ($_SESSION[$session_key]['common']['view_page'] == 'contact')
{
	// Make contacted_at
	$contacted_at = (! empty($_POST['contacted_at'])) ? $_POST['contacted_at'].':00' : null;
	if (strtotime($contacted_at) < strtotime('1900-01-01 00:00:00') || ! checkDatetime($contacted_at))
	{
		$contacted_at = date('Y-m-d H:i:s');
	}

	// Make status
	$status = (isset($_POST['status'])) ? $_POST['status'] : 0;
	if (isset($_POST['to_status_1'])) $status = 1;
	if (isset($_POST['to_status_7'])) $status = 7;

	// Make categories
	$category_id = '0000';
	if (! empty($_POST['categories'])){
		foreach ($_POST['categories'] as $value){
			$posted_categories[] = sprintf('%04d', $value);
		}
		$category_id = implode(',', $posted_categories);
	}

	// 31.Create contact
	if (! empty($process) && $process == 31)
	{
		try {
			$pdo -> beginTransaction();

			// contacts_base
			$sql = "
					INSERT INTO {$table_prefix}contacts_base
						( site_id,  posttype_id,  language_id,  category_id,  title,  content,  name,  email,  tel,  contacted_at,  note,  created_at,  created_by,  grouped_by,  status)
					VALUES
						(:SITE_ID, :POSTTYPE_ID, :LANGUAGE_ID, :CATEGORY_ID, :TITLE, :CONTENT, :NAME, :EMAIL, :TEL, :CONTACTED_AT, :NOTE, :CREATED_AT, :CREATED_BY, :GROUPED_BY, :STATUS)
			";
			$create_contact_base = $pdo->prepare($sql);
			$create_contact_base -> bindValue('SITE_ID',      $_POST['site_id']);
			$create_contact_base -> bindValue('POSTTYPE_ID',  $_POST['posttype_id']);
			$create_contact_base -> bindValue('LANGUAGE_ID',  $_POST['language_id']);
			$create_contact_base -> bindValue('CATEGORY_ID',  $category_id);
			$create_contact_base -> bindValue('TITLE',        $_POST['title']);
			$create_contact_base -> bindValue('CONTENT',      $_POST['content']);
			$create_contact_base -> bindValue('NAME',         $_POST['name']);
			$create_contact_base -> bindValue('EMAIL',        $_POST['email']);
			$create_contact_base -> bindValue('TEL',          $_POST['tel']);
			$create_contact_base -> bindValue('CONTACTED_AT', $contacted_at);
			$create_contact_base -> bindValue('NOTE',         $_POST['note']);
			$create_contact_base -> bindValue('CREATED_AT',   date('Y-m-d H:i:s'));
			$create_contact_base -> bindValue('CREATED_BY',   $_SESSION[$session_key]['user']['id']);
			$create_contact_base -> bindValue('GROUPED_BY',   $_SESSION[$session_key]['user']['group_id']);
			$create_contact_base -> bindValue('STATUS',       $status);
			$create_contact_base -> execute();
			unset($create_contact_base);

			// post_custom
			$sql = "SELECT id FROM {$table_prefix}contacts_base ORDER BY id DESC LIMIT 0, 1";
			$get_new_contact = $pdo -> prepare($sql);
			$get_new_contact -> execute();
			if ($new_contact = $get_new_contact -> fetch(PDO::FETCH_ASSOC))
			{
				unset($get_new_contact);
			}

			if (! empty($new_contact['id']) && ! empty($_POST['items']))
			{
				foreach ($_POST['items'] as $custom_item_id => $value)
				{
					if (is_array($value))
					{
						$value = implode(',', $value);
					}
					$sql = "
							INSERT INTO {$table_prefix}contacts_custom
								(base_id,  custom_item_id,  value)
							VALUES
								(:BASE_ID, :CUSTOM_ITEM_ID, :VALUE)
					";
					$create_contact_custom = $pdo -> prepare($sql);
					$create_contact_custom -> bindValue('BASE_ID',        $new_contact['id']);
					$create_contact_custom -> bindValue('CUSTOM_ITEM_ID', $custom_item_id);
					$create_contact_custom -> bindValue('VALUE',          $value);
					$create_contact_custom -> execute();
					unset($create_contact_custom);
				}
			}
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=contact&process={$process}&errormsg=1");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=contacts&process={$process}");
		exit;
	}

	// 32.Update contact (only memo and status)
	if (! empty($process) && $process == 32 && ! empty($target_id))
	{
		try {
			$pdo -> beginTransaction();
			$sql = "
					UPDATE {$table_prefix}contacts_base SET
						note       = :NOTE,
						updated_at = :UPDATED_AT,
						updated_by = :UPDATED_BY,
						status     = :STATUS
					WHERE id = :ID
			";
			$update_contact_base = $pdo->prepare($sql);
			$update_contact_base -> bindValue('NOTE',       $_POST['note']);
			$update_contact_base -> bindValue('UPDATED_AT', date('Y-m-d H:i:s'));
			$update_contact_base -> bindValue('UPDATED_BY', $_SESSION[$session_key]['user']['id']);
			$update_contact_base -> bindValue('STATUS',     $status);
			$update_contact_base -> bindValue('ID',         $target_id);
			$update_contact_base -> execute();
			unset($update_contact_base);
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=contact&process={$process}&errormsg=2");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=contacts&process={$process}&id={$target_id}&number=1");
		exit;
	}

	// Update (all)
	if (! empty($process) && $process == 33 && ! empty($target_id))
	{
		try {
			$pdo -> beginTransaction();
			$sql = "
					UPDATE {$table_prefix}contacts_base SET
						category_id  = :CATEGORY_ID,
						title        = :TITLE,
						content      = :CONTENT,
						name         = :NAME,
						email        = :EMAIL,
						tel          = :TEL,
						contacted_at = :CONTACTED_AT,
						note         = :NOTE,
						updated_at   = :UPDATED_AT,
						updated_by   = :UPDATED_BY,
						grouped_by   = :GROUPED_BY,
						status       = :STATUS
					WHERE id = :ID
			";
			$update_contact = $pdo->prepare($sql);
			$update_contact -> bindValue('CATEGORY_ID',  $category_id);
			$update_contact -> bindValue('TITLE',        $_POST['title']);
			$update_contact -> bindValue('CONTENT',      $_POST['content']);
			$update_contact -> bindValue('NAME',         $_POST['name']);
			$update_contact -> bindValue('EMAIL',        $_POST['email']);
			$update_contact -> bindValue('TEL',          $_POST['tel']);
			$update_contact -> bindValue('CONTACTED_AT', $contacted_at);
			$update_contact -> bindValue('NOTE',         $_POST['note']);
			$update_contact -> bindValue('UPDATED_AT',   date('Y-m-d H:i:s'));
			$update_contact -> bindValue('UPDATED_BY',   $_SESSION[$session_key]['user']['id']);
			$update_contact -> bindValue('GROUPED_BY',   $_SESSION[$session_key]['user']['group_id']);
			$update_contact -> bindValue('STATUS',       $status);
			$update_contact -> bindValue('ID',           $target_id);
			$update_contact -> execute();
			unset($update_contact);

			// post_custom
			if (! empty($target_id) && ! empty($_POST['items']))
			{
				foreach ($_POST['items'] as $custom_item_id => $value)
				{
					if (is_array($value)){
						$value = implode(',', $value);
					}

					// check exist
					$sql = "
						SELECT COUNT(base_id) AS count
						FROM {$table_prefix}contacts_custom
						WHERE
							base_id = {$target_id}
							AND custom_item_id = {$custom_item_id}
					";
					$search_contacts_custom = $pdo -> prepare($sql);
					$search_contacts_custom -> execute();
					if ($contacts_custom = $search_contacts_custom -> fetch(PDO::FETCH_ASSOC))
					{
						unset($search_contacts_custom);
					}

					// update
					if ($contacts_custom['count']){
					$sql = "
						UPDATE {$table_prefix}contacts_custom SET
							value = :VALUE
						WHERE
							base_id = :BASE_ID
							AND custom_item_id = :CUSTOM_ITEM_ID
						";
						$update_contact_custom = $pdo -> prepare($sql);
						$update_contact_custom -> bindValue('VALUE',          $value);
						$update_contact_custom -> bindValue('BASE_ID',        $target_id);
						$update_contact_custom -> bindValue('CUSTOM_ITEM_ID', $custom_item_id);
						$update_contact_custom -> execute();
						unset($update_contact_custom);
					}

					// create
					else {
						$sql = "
							INSERT INTO {$table_prefix}contacts_custom
								( base_id,  custom_item_id,  value)
							VALUES
								(:BASE_ID, :CUSTOM_ITEM_ID, :VALUE)
						";
						$create_contact_custom = $pdo -> prepare($sql);
						$create_contact_custom -> bindValue('BASE_ID',        $target_id);
						$create_contact_custom -> bindValue('CUSTOM_ITEM_ID', $custom_item_id);
						$create_contact_custom -> bindValue('VALUE',          $value);
						$create_contact_custom -> execute();
						unset($create_contact_custom);
					}
				}
			}
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=contact&process={$process}&errormsg=2");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=contacts&process={$process}&id={$target_id}&number=1");
		exit;
	}

	// 39.Delete contact
	if (! empty($process) && $process == 39 && ! empty($target_id))
	{
		try {
			$pdo -> beginTransaction();
			$sql = "
					UPDATE {$table_prefix}contacts_base SET
						updated_at = :UPDATED_AT,
						updated_by = :UPDATED_BY,
						delete_flg = 1
					WHERE id = :ID
				";
			$update_contact = $pdo -> prepare($sql);
			$update_contact -> bindValue('UPDATED_AT', date('Y-m-d H:i:s'));
			$update_contact -> bindValue('UPDATED_BY', $_SESSION[$session_key]['user']['id']);
			$update_contact -> bindValue('ID',         $target_id);
			$update_contact -> execute();
			unset($update_contact);
			$pdo -> commit();
		}
		catch(PDOException $e)
		{
			$pdo -> rollBack();
			header("Location: ./?view_page=contact&process={$process}&errormsg=3");
			//var_dump($e -> getMessage());
			exit;
		}
		header("Location: ./?view_page=contacts&process={$process}&id={$target_id}&number=1");
		exit;
	}
}
