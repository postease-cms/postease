<?php

/**
 * Check Overlap Slug
 * @param string $table
 * @param string $slug
 * [@param number $except_id]
 * [@param number $posttype_id]
 * [@param number $classification]
 * @return number|boolean
 */
function checkOverlapSlug($table, $slug, $except_id = 0, $posttype_id = 0, $classification = 0)
{
	global $pdo;
	global $table_prefix;

	if ($pdo)
	{
		$sql = "SELECT COUNT(*) AS count FROM {$table} WHERE delete_flg = 0 AND slug = '{$slug}' AND id <> $except_id";
		if ($posttype_id > 0)    $sql .= " AND posttype_id = {$posttype_id}";
		if ($classification > 0) $sql .= " AND classification = {$classification}";
		$read_record = $pdo -> prepare($sql);
		$read_record -> execute();
		if ($record = $read_record -> fetch(PDO::FETCH_ASSOC))
		{
			$count = $record['count'];
			unset($read_record);
			return $count;
		}
	}
	return false;
}


/**
 * Check Overlap Account
 * @param string $account
 * [@param number $except_id]
 * @return number|boolean
 */
function checkOverlapAccount($account, $except_id = 0)
{
	global $pdo;
	global $table_prefix;

	if ($pdo)
	{
		$sql = "SELECT COUNT(*) AS count FROM {$table_prefix}users WHERE delete_flg = 0 AND account = '{$account}' AND id <> $except_id";
		$read_record = $pdo -> prepare($sql);
		$read_record -> execute();
		if ($record = $read_record -> fetch(PDO::FETCH_ASSOC))
		{
			$count = $record['count'];
			unset($read_record);
			return $count;
		}
	}
	return false;
}


/**
 * Get New ID
 * @param string $table
 * [@param number $site_id]
 * [@param number $posttype_id]
 * @return number $new_id
 */
function getNewId($table, $site_id = 0, $posttype_id = 0)
{
	global $pdo;

	$new_id = 0;
	if ($pdo)
	{

		$sql = "SELECT id FROM {$table} WHERE delete_flg = 0";
		if ($site_id > 0)     $sql .= " AND site_id = {$site_id}";
		if ($posttype_id > 0) $sql .= " AND posttype_id = {$posttype_id}";
		$sql .= " ORDER BY id DESC LIMIT 0, 1";
		$read_new = $pdo -> prepare($sql);
		$read_new -> execute();
		if ($new = $read_new -> fetch(PDO::FETCH_ASSOC))
		{
			$new_id = $new['id'];
		}
		unset($read_new);
	}
	return $new_id;
}


/**
 * Get New Line-order
 * @param string $table
 * [@param [number $posttype_id]]
 * [@param number $classification]
 * [@param number $list_id]
 * [@param number $exclusion_id_under]
 * [@param number $exclusion_id_above]
 * @return number $new_line_order
 */
function getNewLineOrder($table, $posttype_id = 0, $classification = 0, $list_id = 0, $exclusion_id_under = 0, $exclusion_id_above = 0)
{
	global $pdo;

	$new_line_order = 0;
	if ($pdo)
	{
		$sql = "SELECT MAX(line_order) AS line_order FROM {$table} WHERE delete_flg = 0";
		if ($posttype_id > 0)        $sql .= " AND posttype_id = {$posttype_id}";
		if ($classification > 0)     $sql .= " AND classification = {$classification}";
		if ($list_id > 0)            $sql .= " AND list_id = {$list_id}";
		if ($exclusion_id_under > 0) $sql .= " AND id > {$exclusion_id_under}";
		if ($exclusion_id_above > 0) $sql .= " AND id < {$exclusion_id_above}";
		$read_record = $pdo -> prepare($sql);
		$read_record -> execute();
		if ($record = $read_record -> fetch(PDO::FETCH_ASSOC))
		{
			$line_order     = $record['line_order'];
			$new_line_order = $line_order + 1;
		}
		unset($read_record);
	}
	return $new_line_order;
}


/**
 * Get Next ID
 * @param string $table
 * [@param number $exclusion_id_under]
 * [@param number $exclusion_id_above]
 * @return number $next_id
 */
function getNextId($table, $exclusion_id_under = 0, $exclusion_id_above = 0)
{
	global $pdo;

	$next_id = 0;
	if ($pdo)
	{
		$qsc_exclusion_id_under = ($exclusion_id_under > 0) ? "AND id > {$exclusion_id_under}" : null;
		$qsc_exclusion_id_above = ($exclusion_id_above > 0) ? "AND id < {$exclusion_id_above}" : null;
		$sql = "SELECT id AS id FROM {$table} WHERE id <> 0 {$qsc_exclusion_id_under} {$qsc_exclusion_id_above} ORDER BY id DESC LIMIT 1 OFFSET 0";
		$read_record = $pdo -> prepare($sql);
		$read_record -> execute();
		if ($record = $read_record -> fetch(PDO::FETCH_ASSOC))
		{
			$id     = $record['id'];
			$next_id = $id + 1;
		}
		unset($read_record);
	}
	return $next_id;
}


/**
 * Get Current Version
 * @param number $target_id
 * @return number $current_version
 */
function getCurrentVerson($target_id)
{
	global $pdo;
	global $table_prefix;

	$current_version = 0;
	if ($pdo && $target_id)
	{
		$sql = "SELECT version AS version FROM {$table_prefix}posts_base WHERE id = {$target_id} AND current_flg = 1 AND delete_flg = 0";
		$read_record = $pdo -> prepare($sql);
		$read_record -> execute();
		if ($record = $read_record -> fetch(PDO::FETCH_ASSOC))
		{
			$current_version = $record['version'];
		}
		unset($read_record);
	}
	return $current_version;
}


/**
 * Get Children of Post
 * @param number $target_id
 * @return array $post_children
 */
function getPostChildren($target_id)
{
	global $pdo;
	global $table_prefix;

	$post_children = array();
	if ($pdo && $target_id)
	{
		$sql = "SELECT id AS id FROM {$table_prefix}posts_base WHERE parent_id = {$target_id} AND current_flg = 1 AND delete_flg = 0";
		$read_record = $pdo -> prepare($sql);
		$read_record -> execute();
		while ($record = $read_record -> fetch(PDO::FETCH_ASSOC))
		{
			$post_children[] = $record['id'];
		}
		unset($read_record);
	}
	return $post_children;
}



/**
 * Reset Cache Params
 * @param int $modified
 * @param int $last_modified
 * @param int $expires
 * @return bool
 */
function resetCacheParams($modified = 1, $last_modified = null, $expires = 0)
{
	global $pdo;
	global $table_prefix;
	
	$cache_params_path = dirname(__FILE__) . '/../core/api';
	$cache_params_file_name = 'params.php';
	$publish_datetime = 9999999999;
	$publish_end_at = 9999999999;
	
	if ($last_modified === null) $last_modified = time();
	if ($pdo)
	{
		$now = date('Y-m-d H:i:s');
		$sql = "
					SELECT `publish_datetime`
					FROM `{$table_prefix}posts_base`
					WHERE `delete_flg` = 0 AND `status` = 1 AND `publish_datetime` IS NOT NULL AND `publish_datetime` > '{$now}'
					ORDER BY `publish_datetime` ASC
					LIMIT 0, 1
			";
		$read_publish_datetime = $pdo->prepare($sql);
		$read_publish_datetime -> execute();
		if ($record = $read_publish_datetime->fetch(PDO::FETCH_ASSOC))
		{
			$publish_datetime = strtotime($record['publish_datetime']);
		}
		unset($read_publish_datetime);
		$sql = "
					SELECT `publish_end_at`
					FROM `{$table_prefix}posts_base`
					WHERE `delete_flg` = 0 AND `status` = 1 AND `publish_end_at` IS NOT NULL AND `publish_end_at` > '{$now}'
					ORDER BY `publish_end_at` ASC
					LIMIT 0, 1
			";
		$read_publish_end_at = $pdo->prepare($sql);
		$read_publish_end_at -> execute();
		if ($record = $read_publish_end_at->fetch(PDO::FETCH_ASSOC))
		{
			$publish_end_at = strtotime($record['publish_end_at']);
		}
		unset($read_publish_end_at);
	}
	$expires = ($publish_datetime < $publish_end_at) ? $publish_datetime : $publish_end_at;
	$cache_params = "<?php\n\ndefine('MODIFIED', '{$modified}');\ndefine('LAST_MODIFIED', '{$last_modified}');\ndefine('EXPIRES', '{$expires}');\n";
	if (false === file_exists($cache_params_path)) mkdir($cache_params_path);
	return file_put_contents($cache_params_path . '/' . $cache_params_file_name, $cache_params);
}


