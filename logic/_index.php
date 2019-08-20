<?php

/*
 * Page Config
 * ------------------------------------------------------------------------------------------------ */
// Default
$page_main = 'index';
$page_sub  = null;


/*
 * Re-check license every 12 hours
 * ------------------------------------------------------------------------------------------------ */
if (strtotime('+12 hours', strtotime($_SESSION[$session_key]['user']['checked_time'])) < strtotime('now'))
{
	$_SESSION[$session_key]['user']['checked_time'] = date('Y-m-d H:i:s');
	header('Location: ./?view_page=update&auto_update=0');
	exit;
}

// Check and Delete update_extra
$file_update_extra = dirname(__FILE__).'/../ajax/update_extra.php';
if (file_exists($file_update_extra))
{
	unlink($file_update_extra);
}

// Reset Content Settings
unset($_SESSION[$session_key]['posts']);
unset($_SESSION[$session_key]['comments']);
unset($_SESSION[$session_key]['contacts']);

// Password time-limit
$pssword_limit = date('Y-m-d H:i:s', strtotime('-3 month'));

// Check Update_allowed_role
$update_allowed_role = ($_SESSION[$session_key]['user']['role'] <= $_SESSION[$session_key]['configs']['update_allowed_role']) ? 1 : 0;

// Check Configs
$check_domain            = 0;
$check_dir_name          = 0;
$check_change_password   = 0;
$check_default_password  = 0;
$check_sqlite_permission = 0;
$this_protocol = (isset($_SERVER['HTTPS']) && (! in_array(strtolower($_SERVER['HTTPS']), array('off', 'no')) || $_SERVER['SERVER_PORT']) == 443) ? 'https' : 'http';
$this_domain   = $this_protocol . '://' . $_SERVER['HTTP_HOST'];
if ($_SESSION[$session_key]['configs']['domain'] != $this_domain) $check_domain = 1;
$this_dir_name = ltrim(rtrim(str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']), '/'), '/');
if ($_SESSION[$session_key]['configs']['dir_name'] != $this_dir_name) $check_dir_name = 1;
try {
	$sql = "
			SELECT
				account,
				password,
				CASE WHEN updated_at is null THEN created_at ELSE updated_at END AS last_update
			FROM {$table_prefix}users
			WHERE account = '{$_SESSION[$session_key]['user']['account']}' AND delete_flg = 0
	";
	$read_records = $pdo -> prepare($sql);
	$read_records -> execute();
	if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
	{
		if (crypt($_SESSION[$session_key]['configs']['default_password'], $record['password']) === $record['password'])
		{
			$check_default_password = 1;
		}
		if (strtotime($record['last_update']) < strtotime($pssword_limit))
		{
			$check_change_password = 1;
		}
	}
}
catch (PDOException $e)
{
	$read_error = 1;
	header("Location: ./?view_page=error&page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}
if ($_SESSION[$session_key]['configs']['database'] == 1)
{
	$check_sqlite_permission = 1;
	$sqlite_permission = (string)substr(sprintf('%o', fileperms(SQLITE_PATH)), -4);
	for ($i = 0; $i < strlen($sqlite_permission); $i++)
	{
		if ($sqlite_permission[$i] >= 6)
		{
			$check_sqlite_permission = 0;
			break;
		}
	}
}


/*
 * Make Search Condition Access-controll
 * ------------------------------------------------------------------------------------------------ */
$qsc_limited_created_by = null;
if (! empty($_SESSION[$session_key]['common']['accessible_post']))
{
	$qsc_limited_created_by = " AND created_by IN ({$_SESSION[$session_key]['common']['accessible_post']})";
}
$qsc_group_id = null;
if (! empty($_SESSION[$session_key]['user']['group_id']))
{
	$qsc_group_id = " AND group_id IN ({$_SESSION[$session_key]['user']['group_id']})";
}


// Get Summary
$summary_post = array();
$summary_contact = array();
try {
	foreach($_SESSION[$session_key]['common']['posttypes'] as $posttype_id => $posttype_row)
	{
		$summary_post[$posttype_id]['post']['total']['parent'] = 0;
		// Post
		foreach ($post_status as $status => $status_value)
		{
			// parent
			$sql = "
					SELECT COUNT(*) AS count
					FROM {$table_prefix}posts_base
					WHERE
						site_id = {$_SESSION[$session_key]['common']['this_site']}
						AND posttype_id = {$posttype_id}
						AND status = {$status}
						AND current_flg = 1
						AND delete_flg = 0
						AND parent_id = 0
						{$qsc_limited_created_by}
			";
			$count_posts = $pdo -> prepare($sql);
			$count_posts -> execute();
			$count = $count_posts -> fetch(PDO::FETCH_ASSOC);
			unset($count_posts);
			$summary_post[$posttype_id]['post']['total']['parent'] += $count['count'];
			$summary_post[$posttype_id]['post']['line_order'] = $_SESSION[$session_key]['common']['posttypes'][$posttype_id]['line_order'];
			$summary_post[$posttype_id]['post'][$status]['parent'] = $count['count'];

			// children
			if ($posttype_row['use_multipage_flg'])
			{
				$sql = "
						SELECT COUNT(*) AS count
						FROM {$table_prefix}posts_base
						WHERE
							site_id = {$_SESSION[$session_key]['common']['this_site']}
							AND posttype_id = {$posttype_id}
							AND status = {$status}
							AND current_flg = 1
							AND delete_flg = 0
							AND parent_id > 0
							{$qsc_limited_created_by}
				";
				$count_posts = $pdo -> prepare($sql);
				$count_posts -> execute();
				$count = $count_posts -> fetch(PDO::FETCH_ASSOC);
				unset($count_posts);

				if (! isset($summary_post[$posttype_id]['post']['total']['child'])) $summary_post[$posttype_id]['post']['total']['child'] = 0;
				if (! isset($summary_post[$posttype_id]['post'][$status]['child'])) $summary_post[$posttype_id]['post'][$status]['child'] = 0;
				$summary_post[$posttype_id]['post']['total']['child'] += $count['count'];
				$summary_post[$posttype_id]['post'][$status]['child'] = $count['count'];
				$summary_post[$posttype_id]['post']['use_multipage_flg'] = 1;
			}
			else {
				$summary_post[$posttype_id]['post']['total']['child'] = 0;
				$summary_post[$posttype_id]['post'][$status]['child'] = 0;
			}
		}

		// Comment
		if (! empty($posttype_row['comment_type']))
		{
			foreach(explode(',', $posttype_row['comment_type']) as $type)
			{
				$summary_post[$posttype_id]['comment'][$type]['total'] = 0;
				foreach ($comment_status as $status => $status_value)
				{
					$sql = "
							SELECT COUNT(*) AS count
							FROM {$table_prefix}comments AS cm
								INNER JOIN (SELECT * FROM {$table_prefix}posts_base WHERE delete_flg = 0 AND current_flg = 1 {$qsc_limited_created_by}) AS pb
									ON cm.post_id = pb.id
							WHERE
								cm.site_id = {$_SESSION[$session_key]['common']['this_site']}
								AND cm.posttype_id = {$posttype_id}
								AND cm.type = {$type}
								AND cm.status = {$status}
								AND cm.parent_id = 0
								AND cm.delete_flg = 0
					";
					$count_comments = $pdo -> prepare($sql);
					$count_comments -> execute();
					$count = $count_comments -> fetch(PDO::FETCH_ASSOC);
					unset($count_comments);

					if (! isset($summary_post[$posttype_id]['comment_parent'][$type]['total'])) $summary_post[$posttype_id]['comment_parent'][$type]['total'] = 0;
					if (! isset($summary_post[$posttype_id]['comment_parent'][$type][$status])) $summary_post[$posttype_id]['comment_parent'][$type][$status] = 0;
					$summary_post[$posttype_id]['comment_parent'][$type]['total'] += $count['count'];
					$summary_post[$posttype_id]['comment_parent'][$type][$status] = $count['count'];
				}
			}
		}

		// Comment
		if (! empty($posttype_row['comment_type']))
		{
			foreach(explode(',', $posttype_row['comment_type']) as $type)
			{
				$summary_post[$posttype_id]['comment'][$type]['total'] = 0;
				foreach ($comment_status as $status => $status_value)
				{
					$sql = "
							SELECT COUNT(*) AS count
							FROM {$table_prefix}comments AS cm
								INNER JOIN (SELECT * FROM {$table_prefix}posts_base WHERE delete_flg = 0 AND current_flg = 1 {$qsc_limited_created_by}) AS pb
									ON cm.post_id = pb.id
							WHERE
								cm.site_id = {$_SESSION[$session_key]['common']['this_site']}
								AND cm.posttype_id = {$posttype_id}
								AND cm.type = {$type}
								AND cm.status = {$status}
								AND cm.parent_id > 0
								AND cm.delete_flg = 0
				";
				$count_comments = $pdo -> prepare($sql);
				$count_comments -> execute();
				$count = $count_comments -> fetch(PDO::FETCH_ASSOC);
				unset($count_comments);
				if (! isset($summary_post[$posttype_id]['comment_children'][$type]['total'])) $summary_post[$posttype_id]['comment_children'][$type]['total'] = 0;
				if (! isset($summary_post[$posttype_id]['comment_children'][$type][$status])) $summary_post[$posttype_id]['comment_children'][$type][$status] = 0;
				$summary_post[$posttype_id]['comment_children'][$type]['total'] += $count['count'];
				$summary_post[$posttype_id]['comment_children'][$type][$status] = $count['count'];
				}
			}
		}
	}

	// Contact
	if (! empty($_SESSION[$session_key]['common']['posttypes_extra']))
	{
		foreach($_SESSION[$session_key]['common']['posttypes_extra'] as $posttype_id => $posttype_row)
		{
			$summary_contact[$posttype_id]['total'] = 0;
			krsort($contact_status);
			foreach ($contact_status as $key => $status_value)
			{
				$sql = "
						SELECT COUNT(*) AS count
						FROM {$table_prefix}contacts_base
						WHERE
							site_id = {$_SESSION[$session_key]['common']['this_site']}
							AND posttype_id = {$posttype_id}
							AND status = {$key}
							AND delete_flg = 0
							{$qsc_group_id}
				";
				$count_contacts = $pdo -> prepare($sql);
				$count_contacts -> execute();
				$count = $count_contacts -> fetch(PDO::FETCH_ASSOC);
				unset($count_contacts);
				$summary_contact[$posttype_id]['total'] += $count['count'];
				$summary_contact[$posttype_id]['line_order'] = $_SESSION[$session_key]['common']['posttypes_extra'][$posttype_id]['line_order'];
				$summary_contact[$posttype_id][$key] = $count['count'];
			}
		}
	}
}
catch(PDOException $e)
{
	$read_error = 2;
	header("Location: ./?view_page=error&page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}

// print '<pre>';
// print_r($summary_post);
// print '</pre>';
// exit;

// print '<pre>';
// print_r($summary_contact);
// print '</pre>';
