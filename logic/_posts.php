<?php

/*
 * Page Config
 * ------------------------------------------------------------------------------------------------ */
// Set posttype and type
$posttype_label    = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name'];
$comment_type      = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['comment_type'];
$judge_flg_comment = ($comment_type) ? 1 : 0;

// Default
$page_main        = $PageNum -> getMain('post');
$page_sub         = $PageNum -> getSubPost('posts');
$page_title_main  = ($_SESSION[$session_key]['configs']['use_multisite_flg']) ? $_SESSION[$session_key]['common']['sites'][$_SESSION[$session_key]['common']['this_site']]['name'].' ' : '';
$page_title_main .= $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name'];
$page_title_sub   = TXT_POSTS_PAGETITLE_SUB;
$page_icon        = 'fa-bars';

// Parameters
$id      = (isset($_GET['id']))      ? $_GET['id']      : null;
$process = (isset($_GET['process'])) ? $_GET['process'] : null;
$number  = (isset($_GET['number']))  ? $_GET['number']  : 0;

// Parameters of process message
$process_msg       = null;
$process_msg_style = null;
$process_msg_type  = null;


/*
 * Read Custom configs
 * ------------------------------------------------------------------------------------------------ */
if (file_exists(dirname(__FILE__).'/../custom/posts/posts_'.sprintf('%04d', $_SESSION[$session_key]['common']['this_posttype']).'.php'))
{
	include_once dirname(__FILE__).'/../custom/posts/posts_'.sprintf('%04d', $_SESSION[$session_key]['common']['this_posttype']).'.php';
}


/*
 * Reset Conditions except multi-column
 * ------------------------------------------------------------------------------------------------ */
if (! empty($_GET['clear']))
{
	foreach ($_SESSION[$session_key]['posts'] as $key => $value)
	{
		if (strpos($key, 'multi_column') === false && strpos($key, 'limit') === false)
		{
			unset($_SESSION[$session_key]['posts'][$key]);
		}
	}
}
unset($_SESSION[$session_key]['comments']);


/*
 * Set Process Message
 * ------------------------------------------------------------------------------------------------ */
// create
$new_id = 0;
if (! empty($process) && $process == 11)
{
	$process_msg = TXT_POSTS_MSG_NEWPOST;
	$process_msg_style = 'info';
	$process_msg_type  = 'Done';
	$new_id = getNewId($table_prefix.'posts_base', $_SESSION[$session_key]['common']['this_site'], $_SESSION[$session_key]['common']['this_posttype']);

	// unset condition
	unset($_SESSION[$session_key]['posts']['sc_text']);
	unset($_SESSION[$session_key]['posts']['sort']);
	unset($_SESSION[$session_key]['posts']['page']);
}

// update
$updated_id = 0;
if (! empty($process) && ! empty($number) && $process == 12)
{
	$process_msg = TXT_POSTS_MSG_UPDATE($number, $posttype_label);
	$process_msg_style = 'success';
	$process_msg_type  = 'Done';
	$updated_id = (! empty($id)) ? $id : 0;
}

// clone
if (! empty($process) && ! empty($number) && $process == 13)
{
	$process_msg = TXT_POSTS_MSG_CLONE($number, $posttype_label);
	$process_msg_style = 'info';
	$process_msg_type  = 'Done';
}

// delete
if (! empty($process) && ! empty($number) && $process == 19)
{
	$process_msg = TXT_POSTS_MSG_DELETE($number, $posttype_label);
	$process_msg_style = 'danger';
	$process_msg_type  = 'Done';
}
// back
$prev_id = (isset($_GET['prev_id'])) ? $_GET['prev_id'] : 0;


/*
 * Set Search Condition (status, category, tag, title), Sort And (this)Page
 * ------------------------------------------------------------------------------------------------ */
// Search & Narrow-down config
$_SESSION[$session_key]['posts']['sc_status']             = (! isset($_GET['sc_status']))      ? (! isset($_SESSION[$session_key]['posts']['sc_status']))      ? ''  : $_SESSION[$session_key]['posts']['sc_status']      : $_GET['sc_status'];
$_SESSION[$session_key]['posts']['sc_anchor']             = (! isset($_GET['sc_anchor']))      ? (! isset($_SESSION[$session_key]['posts']['sc_anchor']))      ? ''  : $_SESSION[$session_key]['posts']['sc_anchor']      : $_GET['sc_anchor'];
$_SESSION[$session_key]['posts']['sc_created_by']         = (! isset($_GET['sc_created_by']))  ? (! isset($_SESSION[$session_key]['posts']['sc_created_by']))  ? ''  : $_SESSION[$session_key]['posts']['sc_created_by']  : $_GET['sc_created_by'];
$_SESSION[$session_key]['posts']['sc_category_id']        = (! isset($_GET['sc_category_id'])) ? (! isset($_SESSION[$session_key]['posts']['sc_category_id'])) ? '0' : $_SESSION[$session_key]['posts']['sc_category_id'] : $_GET['sc_category_id'];
$_SESSION[$session_key]['posts']['sc_tag_id']             = (! isset($_GET['sc_tag_id']))      ? (! isset($_SESSION[$session_key]['posts']['sc_tag_id']))      ? '0' : $_SESSION[$session_key]['posts']['sc_tag_id']      : $_GET['sc_tag_id'];
$_SESSION[$session_key]['posts']['sc_text']               = (! isset($_GET['sc_text']))        ? (! isset($_SESSION[$session_key]['posts']['sc_text']))        ? ''  : $_SESSION[$session_key]['posts']['sc_text']        : $_GET['sc_text'];
$_SESSION[$session_key]['posts']['sc_publish_date_start'] = (! isset($_GET['sc_publish_date_start'])) ? (! isset($_SESSION[$session_key]['posts']['sc_publish_date_start'])) ? '' : $_SESSION[$session_key]['posts']['sc_publish_date_start'] : $_GET['sc_publish_date_start'];
$_SESSION[$session_key]['posts']['sc_publish_date_end']   = (! isset($_GET['sc_publish_date_end']))   ? (! isset($_SESSION[$session_key]['posts']['sc_publish_date_end']))   ? '' : $_SESSION[$session_key]['posts']['sc_publish_date_end']   : $_GET['sc_publish_date_end'];
$_SESSION[$session_key]['posts']['page']                  = (! isset($_GET['page']))           ? (! isset($_SESSION[$session_key]['posts']['page']))           ? '1'     : $_SESSION[$session_key]['posts']['page']        : $_GET['page'];
$_SESSION[$session_key]['posts']['language']              = (! isset($_GET['language']))       ? (! isset($_SESSION[$session_key]['posts']['language']))       ? '1'     : $_SESSION[$session_key]['posts']['language']    : $_GET['language'];

// Display config
$config_posttype = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']];
$_SESSION[$session_key]['posts']['limit']          = (! isset($_GET['limit']))          ? (! isset($_SESSION[$session_key]['posts']['limit']))          ? $config_posttype['posts_list_num']   : $_SESSION[$session_key]['posts']['limit']          : $_GET['limit'];
$_SESSION[$session_key]['posts']['sort']           = (! isset($_GET['sort']))           ? (! isset($_SESSION[$session_key]['posts']['sort']))           ? $config_posttype['posts_sort_order'] : $_SESSION[$session_key]['posts']['sort']           : $_GET['sort'];
$_SESSION[$session_key]['posts']['multi_column01'] = (! isset($_GET['multi_column01'])) ? (! isset($_SESSION[$session_key]['posts']['multi_column01'])) ? $config_posttype['posts_column01']   : $_SESSION[$session_key]['posts']['multi_column01'] : $_GET['multi_column01'];
$_SESSION[$session_key]['posts']['multi_column02'] = (! isset($_GET['multi_column02'])) ? (! isset($_SESSION[$session_key]['posts']['multi_column02'])) ? $config_posttype['posts_column02']   : $_SESSION[$session_key]['posts']['multi_column02'] : $_GET['multi_column02'];
$_SESSION[$session_key]['posts']['multi_column03'] = (! isset($_GET['multi_column03'])) ? (! isset($_SESSION[$session_key]['posts']['multi_column03'])) ? ($judge_flg_comment) ? 3 : $config_posttype['posts_column03'] : $_SESSION[$session_key]['posts']['multi_column03'] : $_GET['multi_column03'];

// Shape & Reset configs
$sc_status               = $_SESSION[$session_key]['posts']['sc_status'];
$sc_anchor               = $_SESSION[$session_key]['posts']['sc_anchor'];
$sc_created_by           = $_SESSION[$session_key]['posts']['sc_created_by'];
$sc_category_id          = ($_SESSION[$session_key]['posts']['sc_category_id']) ? sprintf('%04d', $_SESSION[$session_key]['posts']['sc_category_id']) : $_SESSION[$session_key]['posts']['sc_category_id'];
$sc_tag_id               = ($_SESSION[$session_key]['posts']['sc_tag_id'])      ? sprintf('%04d', $_SESSION[$session_key]['posts']['sc_tag_id'])      : $_SESSION[$session_key]['posts']['sc_tag_id'];
$sc_text                 = $_SESSION[$session_key]['posts']['sc_text'];
$sc_publish_date_start   = $_SESSION[$session_key]['posts']['sc_publish_date_start'];
$sc_publish_date_end     = $_SESSION[$session_key]['posts']['sc_publish_date_end'];
$sc_publish_date_end_fix = date('Y-m-d', strtotime($sc_publish_date_end) + 86400);
$sort                    = $_SESSION[$session_key]['posts']['sort'];
$sort_reverse            = ($sort == 'DESC') ? 'ASC' : 'DESC';
$label_title             = $config_posttype['label_title'];
$multi_column01          = $_SESSION[$session_key]['posts']['multi_column01'];
$multi_column02          = $_SESSION[$session_key]['posts']['multi_column02'];
$multi_column03          = $_SESSION[$session_key]['posts']['multi_column03'];
$use_category_flg        = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_category_flg'];
$use_tag_flg             = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_tag_flg'];
$use_list_eyecatch_flg   = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_list_eyecatch_flg'];
$config_list_num         = $_SESSION[$session_key]['posts']['limit'];
$config_category_num     = $config_posttype['posts_category_num'];
$config_tag_num          = $config_posttype['posts_tag_num'];
$this_page               = $_SESSION[$session_key]['posts']['page'];
$language                = $_SESSION[$session_key]['posts']['language'];

// Check setting condition
$set_condition_flg = 0;
$sc_def_blank = array('sc_status', 'sc_anchor', 'sc_created_by', 'sc_text', 'sc_publish_date_start', 'sc_publish_date_end');
$sc_def_zero  = array('sc_category_id', 'sc_tag_id');
foreach ($_SESSION[$session_key]['posts'] as $key => $value)
{
	if ((in_array($key, $sc_def_blank) && $value != '') || (in_array($key, $sc_def_zero) && intVal($value) !== 0))
	{
		$set_condition_flg = 1;
		break;
	}
}


/*
 * Make Search Condition Others
 * ------------------------------------------------------------------------------------------------ */
$qsc_text                 = (! empty($sc_text)) ? " AND (tx.title LIKE '%{$sc_text}%' OR tx.addition LIKE '%{$sc_text}%' OR tx.content LIKE '%{$sc_text}%')" : null;
$qsc_publish_date_start   = (! empty($sc_publish_date_start)) ? " AND bs.publish_datetime >= '{$sc_publish_date_start}'"  : null;
$qsc_publish_date_end     = (! empty($sc_publish_date_end))   ? " AND bs.publish_datetime < '{$sc_publish_date_end_fix}'" : null;
$qsc_anchor               = ($sc_anchor != '')      ? " AND bs.anchor IN({$sc_anchor})" : null;
$qsc_created_by           = ($sc_created_by != '')  ? " AND bs.created_by = {$sc_created_by}" : null;


/*
 * Make Search Condition Access-controll
 * ------------------------------------------------------------------------------------------------ */
$qsc_limited_created_by = null;
if (! empty($_SESSION[$session_key]['common']['accessible_post']))
{
	$qsc_limited_created_by = " AND bs.created_by IN ({$_SESSION[$session_key]['common']['accessible_post']})";
}


/*
 * Make Search Condition Status
 * ------------------------------------------------------------------------------------------------ */
$qsc_status               = null;
$qsc_status_publish       = null;
$qsc_status_child_draft   = null;
$qsc_status_child_private = null;

if ($config_posttype['use_multipage_flg'])
{
	if ($sc_status == '1') $qsc_status_publish       = " AND bs.status = 1";
	if ($sc_status == '2') $qsc_status_child_draft   = " AND (bs.status = 2 OR count_child_draft > 0)";
	if ($sc_status == '8') $qsc_status_child_private = " AND (bs.status = 8 OR count_child_private > 0)";
}
else {
	if ($sc_status != '') $qsc_status = " AND bs.status IN({$sc_status})";
}


/*
 * Paging
 * ------------------------------------------------------------------------------------------------ */
try {
	$sql = "
			SELECT COUNT(bs.id) AS id
			FROM {$table_prefix}posts_base AS bs
				LEFT OUTER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = {$language}) AS tx
					ON bs.id = tx.base_id AND bs.version = tx.base_version
				LEFT OUTER JOIN (SELECT DISTINCT(parent_id) AS 'parent_id', COUNT(id) AS count_child_draft FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND parent_id <> 0 AND status = 2 GROUP BY parent_id) AS bscd
					ON bs.id = bscd.parent_id
				LEFT OUTER JOIN (SELECT DISTINCT(parent_id) AS 'parent_id', COUNT(id) AS count_child_private FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND parent_id <> 0 AND status = 8 GROUP BY parent_id) AS bscp
					ON bs.id = bscp.parent_id
			WHERE
				bs.site_id = {$_SESSION[$session_key]['common']['this_site']}
				AND bs.posttype_id = {$_SESSION[$session_key]['common']['this_posttype']}
				AND bs.category_id LIKE '%{$sc_category_id}%'
				AND bs.tag_id LIKE '%{$sc_tag_id}%'
				{$qsc_text}
				{$qsc_publish_date_start}
				{$qsc_publish_date_end}
				{$qsc_status}
				{$qsc_status_publish}
				{$qsc_status_child_draft}
				{$qsc_status_child_private}
				{$qsc_anchor}
				{$qsc_created_by}
				{$qsc_limited_created_by}
				AND bs.current_flg = 1
				AND bs.delete_flg = 0
				AND bs.parent_id = 0
	";
	$count_posts = $pdo -> prepare($sql);
	$count_posts -> execute();
	$count = $count_posts -> fetch(PDO::FETCH_ASSOC);
	unset($count_posts);
}
catch(PDOException $e)
{
	$read_error = 1;
	header("Location: ./error.php?page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}
$amount_post = $count['id'];
$limit       = $_SESSION[$session_key]['posts']['limit'];
$amount_page = ceil($amount_post / $limit);
$this_page   = (isset($_SESSION[$session_key]['posts']['page'])) ? (isset($_GET['page'])) ? $_GET['page'] : $_SESSION[$session_key]['posts']['page'] : 1;
$offset      = ($this_page - 1) * $limit;
$pagenation  = getPagenation($this_page, $amount_page, 13);

// Edit controll variables
$edit_controll    = $_SESSION[$session_key]['configs']['edit_controll'];
$access_user_id   = $_SESSION[$session_key]['user']['id'];
$access_user_role = $_SESSION[$session_key]['user']['role'];
$publish_flg = 0;
if ($_SESSION[$session_key]['user']['role'] <= $_SESSION[$session_key]['configs']['publish_role'])
{
	$publish_flg = 1;
}


/*
 * Fetch Data
 * ------------------------------------------------------------------------------------------------ */
$records = array();
try {
	// Posts
	$sql = "
			SELECT
				bs.id AS id,
				bs.version AS version,
				tx.title AS title,
				bs.category_id AS category_id,
				bs.tag_id AS tag_id,
				bs.anchor AS anchor,
				CASE WHEN bsc.count_children IS NOT NULL THEN bsc.count_children ELSE 0 END AS post_pages,
				CASE WHEN cm1a.count_post > 0 THEN cm1a.count_post ELSE 0 END AS count_post_cm1a,
				CASE WHEN cm1d.count_post > 0 THEN cm1d.count_post ELSE 0 END AS count_post_cm1d,
				CASE WHEN cm2.count_post > 0 THEN cm2.count_post ELSE 0 END AS count_post_cm2,
				cm2.score_average AS score_average_cm2,
				CASE WHEN cm3a.count_post > 0 THEN cm3a.count_post ELSE 0 END AS count_post_cm3a,
				CASE WHEN cm3d.count_post > 0 THEN cm3d.count_post ELSE 0 END AS count_post_cm3d,
				bs.status AS status,
				CASE WHEN bscd.count_child_draft IS NOT NULL THEN bscd.count_child_draft ELSE 0 END AS count_child_draft,
				CASE WHEN bscp.count_child_private IS NOT NULL THEN bscp.count_child_private ELSE 0 END AS count_child_private,
				bs.publish_datetime AS publish_datetime,
				bs.publish_end_at AS publish_end_at,
				bs.eyecatch AS eyecatch,
				usc.id AS created_by_id,
				usc.nickname AS created_by,
				usc.name AS created_group,
				usu.nickname AS updated_by,
				usu.name AS updated_group,
				CASE WHEN bs.updated_at is null THEN bs.created_at ELSE bs.updated_at END AS last_update
			FROM {$table_prefix}posts_base AS bs
				LEFT OUTER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = {$language}) AS tx
					ON bs.id = tx.base_id AND bs.version = tx.base_version
				LEFT OUTER JOIN (SELECT DISTINCT(parent_id) AS 'parent_id', COUNT(id) AS count_children FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND parent_id <> 0 GROUP BY parent_id) AS bsc
					ON bs.id = bsc.parent_id
				LEFT OUTER JOIN (SELECT DISTINCT(parent_id) AS 'parent_id', COUNT(id) AS count_child_draft FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND parent_id <> 0 AND status = 2 GROUP BY parent_id) AS bscd
					ON bs.id = bscd.parent_id
				LEFT OUTER JOIN (SELECT DISTINCT(parent_id) AS 'parent_id', COUNT(id) AS count_child_private FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND parent_id <> 0 AND status = 8 GROUP BY parent_id) AS bscp
					ON bs.id = bscp.parent_id
				LEFT OUTER JOIN (SELECT COUNT(post_id) AS count_post, post_id AS post_id FROM {$table_prefix}comments WHERE delete_flg = 0 AND parent_id = 0 AND type = 1 GROUP BY post_id) AS cm1a
					ON bs.id = cm1a.post_id
				LEFT OUTER JOIN (SELECT COUNT(post_id) AS count_post, post_id AS post_id FROM {$table_prefix}comments WHERE delete_flg = 0 AND parent_id > 0 AND type = 1 GROUP BY post_id) AS cm1d
					ON bs.id = cm1d.post_id
				LEFT OUTER JOIN (SELECT COUNT(post_id) AS count_post, AVG(score) AS score_average, post_id AS post_id FROM {$table_prefix}comments WHERE delete_flg = 0 AND comment_id = 0 AND type = 2 GROUP BY post_id) AS cm2
					ON bs.id = cm2.post_id
				LEFT OUTER JOIN (SELECT COUNT(post_id) AS count_post, post_id AS post_id FROM {$table_prefix}comments WHERE delete_flg = 0 AND parent_id = 0 AND type = 3 GROUP BY post_id) AS cm3a
					ON bs.id = cm3a.post_id
				LEFT OUTER JOIN (SELECT COUNT(post_id) AS count_post, post_id AS post_id FROM {$table_prefix}comments WHERE delete_flg = 0 AND parent_id > 0 AND type = 3 GROUP BY post_id) AS cm3d
					ON bs.id = cm3d.post_id
				INNER JOIN (SELECT us.id AS id, us.nickname AS nickname, gr.name AS name FROM {$table_prefix}users AS us LEFT OUTER JOIN {$table_prefix}groups AS gr ON us.group_id = gr.id) AS usc
					ON bs.created_by = usc.id
				LEFT OUTER JOIN (SELECT us.id AS id, us.nickname AS nickname, gr.name AS name FROM {$table_prefix}users AS us LEFT OUTER JOIN {$table_prefix}groups AS gr ON us.group_id = gr.id) AS usu
					ON bs.updated_by = usu.id
			WHERE
				bs.site_id = {$_SESSION[$session_key]['common']['this_site']}
				AND bs.posttype_id = {$_SESSION[$session_key]['common']['this_posttype']}
				AND bs.category_id LIKE '%{$sc_category_id}%'
				AND bs.tag_id LIKE '%{$sc_tag_id}%'
				{$qsc_text}
				{$qsc_publish_date_start}
				{$qsc_publish_date_end}
				{$qsc_status}
				{$qsc_status_publish}
				{$qsc_status_child_draft}
				{$qsc_status_child_private}
				{$qsc_anchor}
				{$qsc_created_by}
				{$qsc_limited_created_by}
				AND bs.current_flg = 1
				AND bs.delete_flg = 0
				AND bs.parent_id = 0
			ORDER BY bs.publish_datetime IS NULL DESC, bs.anchor DESC, bs.publish_datetime {$sort}, bs.id {$sort}
			LIMIT {$offset}, {$limit}
	";
	$read_records = $pdo -> prepare($sql);
	$read_records -> execute();
	while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
	{
		// Make list eyecatch
		if (! empty($record['eyecatch']))
		{
      $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
      finfo_close($finfo);

			$my_url_base = $_SESSION[$session_key]['configs']['domain'] . ((! empty($_SESSION[$session_key]['configs']['dir_name'])) ? '/' . $_SESSION[$session_key]['configs']['dir_name'] . '/' : null);
			$old_path = str_replace('fr_admin/eyecatch/1x', 'fr_thumb', $record['eyecatch']);
			$new_path = str_replace('fr_admin/eyecatch/1x', 'fr_admin/list', $record['eyecatch']);
			$check_path = dirname(__FILE__) . '/../' . preg_replace('/\?v=.*/', '', str_replace($my_url_base, '', $new_path));

      $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
      $record['eyecatch_mimetype'] = finfo_file($finfo, $check_path);
      finfo_close($finfo);

      if ($record['eyecatch_mimetype'] == 'application/pdf')
      {
        $record['eyecatch'] = 'img/pdf_small.png';
        $record['noimage'] = 1;
      }
      else {
        if (file_exists($check_path))
        {
          $record['eyecatch'] = $new_path;
        }
        else {
          $record['eyecatch'] = $old_path;
        }
      }
		}
		else {
			$record['eyecatch'] = 'img/no_image_list.png';
			$record['noimage'] = 1;
		}
		
		// Make category text
		$categories = array();
		if (! empty($_SESSION[$session_key]['common']['categories']))
		{
			if ($record['category_id'] != '0000')
			{
				foreach (explode(',', $record['category_id']) as $category)
				{
					if (isset($_SESSION[$session_key]['common']['categories'][intval($category)]['label'][$language]))
					{
						array_push($categories, $_SESSION[$session_key]['common']['categories'][intval($category)]['label'][$language]);
					}
					else {
						array_push($categories, '..');
					}
				}
			}
		}
		$record['categories'] = $categories;

		// Make tag text
		$tags = array();
		if (! empty($_SESSION[$session_key]['common']['tags']))
		{
			if ($record['tag_id'] != '0000')
			{
				foreach (explode(',', $record['tag_id']) as $tag)
				{
					if (isset($_SESSION[$session_key]['common']['tags'][intval($tag)]['label'][$language]))
					{
						array_push($tags, $_SESSION[$session_key]['common']['tags'][intval($tag)]['label'][$language]);
					}
					else {
						array_push($tags, '..');
					}
				}
			}
		}
		$record['tags'] = $tags;

		// Judge Editable
		$editable_flg = 1;
		if ($edit_controll == 1)
		{
			if ($access_user_role != 1 && $record['created_by_id'] != $access_user_id)
			{
				$editable_flg = 0;
			}
		}
		if ($edit_controll == 2)
		{
			$target_role = $_SESSION[$session_key]['common']['users'][$record['created_by_id']]['role'];
			if ($record['created_by_id'] != $access_user_id && $access_user_role > $target_role)
			{
				$editable_flg = 0;
			}
		}
		$record['editable_flg'] = $editable_flg;

		// Add All
		$records[] = $record;
	}
	unset($read_records);
}
catch(PDOException $e)
{
	$read_error = 2;
	header("Location: ./error.php?page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}


/*
 * Format categories
 * ------------------------------------------------------------------------------------------------ */
$formated_categories = array();
foreach ($_SESSION[$session_key]['common']['categories'] as $key => $values)
{
	if ($values['parent_id'] == 0){
		$formated_categories[$key] = $values;
	}
	else {
		$formated_categories[$values['parent_id']]['children'][$key] = $values;
	}
}


/*
 * Make Selecter for Anchor
 * ------------------------------------------------------------------------------------------------ */
$selectable_anchors = array();
try {
	$sql = "SELECT DISTINCT(anchor) AS anchor FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND anchor <> 0 AND posttype_id = {$_SESSION[$session_key]['common']['this_posttype']} ORDER BY anchor DESC";
	$read_records = $pdo -> prepare($sql);
	$read_records -> execute();
	while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
	{
		$selectable_anchors[] = $record['anchor'];
	}
}
catch (PDOException $e)
{
	$read_error = 3;
	header("Location: ./error.php?page={$page}&read_error={$read_error}");
	//var_dump($e->getMessage());
	exit;
}


/*
 * Make Selecter for Cretaed_at
 * ------------------------------------------------------------------------------------------------ */
$selectable_users = array();
try {
	$sql = "
			SELECT id, nickname
			FROM {$table_prefix}users AS usr
			WHERE EXISTS(SELECT * FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND posttype_id = {$_SESSION[$session_key]['common']['this_posttype']} AND created_by = usr.id)
			ORDER BY usr.role ASC, usr.id ASC
	";
	$read_records = $pdo -> prepare($sql);
	$read_records -> execute();
	while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
	{
		$selectable_users[$record['id']] = $record['nickname'];
	}
}
catch (PDOException $e)
{
	$read_error = 4;
	//header("Location: ./error.php?page={$page}&read_error={$read_error}");
	var_dump($e->getMessage());
	exit;
}


/*
 * Back to page 1 When empty-data after delete
 * ------------------------------------------------------------------------------------------------ */
if ($process == 19 && $_SESSION[$session_key]['posts']['page'] > 1 && empty($records))
{
	header("Location: ./posts.php?page=1&process={$process}&id={$target_id}&number=1");
}


// print '<pre>';
// print_r($formated_categories);
// print '</pre>';
// exit;
