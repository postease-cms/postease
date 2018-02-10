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

