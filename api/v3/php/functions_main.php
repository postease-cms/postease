<?php

/*
 * Functions Main
 * -------------------------------------
 * 01. get_post
 * 02. get_posts	
 * 03. get_comment
 * 04. get_comments
 * 05. get_categories
 * 06. get_tags
 * 07. get_sites
 * 08. get_posttypes
 * 09. get_languages
 * 10. get_archives
 * 11. get_image_frames
 * 12. get_comment_items (CommentForm:01)
 * 13. get_contact_items
 * 14. [SUB] post_contact
 * 15. [SUB] get_contact
 * 16. [SUB] reset_contact
 * 17. [SUB] reset_items
 * 18. send_mail
 * 19. send_mail_extend
 * 20. post_contact_send_mail
 * 21. post_comment
 * 22. set_counter
 * -------------------------------------
 */


// Send mail preparation
require_once dirname(__FILE__).'/../../../class/PHPMailer/PHPMailerAutoload.php';
require_once dirname(__FILE__).'/../../../class/I18N_UnicodeNormalizer/UnicodeNormalizer.php';
require_once dirname(__FILE__).'/../../../class/Hashids/Hashids.php';


/**
 * [Help Function]
 * index array from '1'
 * @param  array $arr
 * @return array $arr
 */
function index_fromone($arr)
{
  if (is_array($arr))
  {
    array_unshift($arr, 0);
    unset($arr[0]);
  }
  return $arr;
}


/**
 * [Help Function]
 * index array from '1' recursively
 * @param array  $arr
 * [@param string $recursive_key]
 * @return array $arr
 */
function index_fromone_recursive($arr, $recursive_key = 'children')
{
  foreach ($arr as $key => $value)
  {
    if (is_array($value))
    {
      $arr[$key] = index_fromone_recursive($value);
    }
  }
  if (isset($arr[$recursive_key]))
  {
    $arr[$recursive_key] = index_fromone($arr[$recursive_key]);
  }
  return $arr;
}


/**
 * [Help Function]
 * substruct string
 * @param  string $string
 * @param  number $number
 * [@param string $continue_string]
 * @return string $string
 */
function substructString($string, $number, $continue_string = '...')
{
  if (! empty($string) && $number > 0)
  {
    $string = preg_replace('/\r\n|\r|\n/', '', html_entity_decode(strip_tags($string)));
    $strlen = mb_strlen($string, 'UTF-8');
    if ($strlen > $number)
    {
      $subtracted_string = mb_substr($string, 0, $number, 'UTF-8') . $continue_string;
      return $subtracted_string;
    }
  }
  return $string;
}


/**
 * Decode Hash Id
 * @param string $hash_string
 * [@param int $digits]
 * [@param string $salt]
 * @return bool false | string hash_id
 */
function decodeHashId($hash_string, $digits = 12, $salt = null)
{
  $hash_strings = '0123456789abcdef';
  $hashids = new Hashids($salt, $digits, $hash_strings);
  if ($raw_string = $hashids -> decode($hash_string))
  {
    return $raw_string;
  }
  return false;
}



/**
 * Get Post
 * @param mixed $post_key
 * [@param array  $config]
 *  + @param[item] string  'language' (slug)
 *  + @param[item] number  'language_id'
 *  + @param[item] string  'eyecatch_frame'
 *  + @param[item] string  'content_frame'
 *  + @param[item] array   'custom_frame' (slug => frame)
 *  + @param[item] boolean 'with_child_custom'
 *  + @param[item] boolean 'with_counter'
 *  + @param[item] number  'content_head_length'
 *  + @param[item] number  'version'
 *  + @param[item] boolean 'preview' (0:only release status strictly / 1:allow not release status)]
 * @param bool $recursive
 * @return array $post | boolean(false)
 */
function get_post($post_key, $config = array(), $recursive = true)
{
  global $database;
  global $pdo;
  global $table_prefix;

  $id = 0;
  if (! empty($post_key))
  {
    // Preview
    if (preg_match('/^[a-f0-9]{32}$/', $post_key))
    {
      $preview_hash_salt = null;
      $sql = "
				SELECT value FROM {$table_prefix}configs
				WHERE item = 'preview_hash_salt'
				";
      $read_config = $pdo -> prepare($sql);
      $read_config -> execute();
      while ($config = $read_config -> fetch(PDO::FETCH_ASSOC))
      {
        $preview_hash_salt = $config['value'];
      }
      unset($read_config);

      $decoded_exp     = decodeHashId(substr($post_key, 0, 20), 20, $preview_hash_salt);
      $decoded_id      = decodeHashId(substr($post_key, 20, 9), 9,  $preview_hash_salt);
      $decoded_version = decodeHashId(substr($post_key, 29, 3), 3,  $preview_hash_salt);

      $time = (int)($decoded_exp[0] . '0');
      if ($time + 86400 >= time())
      {
        $id = $decoded_id[0];
        $config['preview'] = 1;
        $config['version'] = $decoded_version[0];
      }
    }
    // Hash id
    elseif (preg_match('/^[a-f0-9]{12}$/', $post_key))
    {
      try {
        $sql = "SELECT id FROM {$table_prefix}posts_base WHERE delete_flg = 0 AND hash_id = :HASH_ID";
        $read_id = $pdo -> prepare($sql);
        $read_id -> bindValue(':HASH_ID', $post_key, PDO::PARAM_STR);
        $read_id -> execute();
        if ($record = $read_id -> fetch(PDO::FETCH_ASSOC))
        {
          $id = intval($record['id']);
        }
        unset($read_id);
      }
      catch(PDOException $e)
      {
        var_dump($e->getMessage());
      }
    }
    // Id
    elseif (is_numeric($post_key) && strlen($post_key) < 11)
    {
      $id = intval($post_key);
    }
    // Get id from slug or permalink_key
    else {
      try {
        if (preg_match('/^\/.*/', $post_key))
        {
          $sql = "SELECT id FROM {$table_prefix}posts_base WHERE delete_flg = 0 AND permalink_uri = :URI";
          $read_id = $pdo -> prepare($sql);
          $read_id -> bindValue(':URI', $post_key, PDO::PARAM_STR);
          $read_id -> execute();
          if ($record = $read_id -> fetch(PDO::FETCH_ASSOC))
          {
            $id = intval($record['id']);
          }
        }
        else {
          $sql = "SELECT id FROM {$table_prefix}posts_base WHERE delete_flg = 0 AND (slug = :SLUG OR permalink_key = :PERMALINK_KEY)";
          $read_id = $pdo -> prepare($sql);
          $read_id -> bindValue(':SLUG',          $post_key, PDO::PARAM_STR);
          $read_id -> bindValue(':PERMALINK_KEY', $post_key, PDO::PARAM_STR);
          $read_id -> execute();
          if ($record = $read_id -> fetch(PDO::FETCH_ASSOC))
          {
            $id = intval($record['id']);
          }
        }
        unset($read_id);
      }
      catch(PDOException $e)
      {
        var_dump($e->getMessage());
      }
    }
  }

  // Set parameters
  $language            = (! empty($config['language']))          ? $config['language']                    : null;
  $language_id         = (! empty($config['language_id']))       ? intval($config['language_id'])         : 1;
  $eyecatch_frame      = (! empty($config['eyecatch_frame']))    ? $config['eyecatch_frame']              : null;
  $content_frame       = (! empty($config['content_frame']))     ? $config['content_frame']               : null;
  $custom_frame        = (! empty($config['custom_frame']))      ? $config['custom_frame']                : array();
  $with_child_custom   = (isset($config['with_child_custom']))   ? intval($config['with_child_custom'])   : 0;
  $with_counter        = (isset($config['with_counter']))        ? intval($config['with_counter'])        : 1;
  $content_head_length = (isset($config['content_head_length'])) ? intval($config['content_head_length']) : 25;
  $version             = (! empty($config['version']))           ? intval($config['version'])             : 0;
  $preview             = (isset($config['preview']))             ? intval($config['preview'])             : 0;
  $permalink_base      = null;

  // make search condition
  $now = date('Y-m-d H:i:s');
  $qsc_version          = (! empty($version))  ? "AND pb.version = {$version}"         : "AND pb.current_flg = 1";
  $qsc_publish_datetime = (! $preview)         ? "AND pb.publish_datetime <= '{$now}'" : null;
  $qsc_publish_end_at   = (! $preview)         ? "AND (pb.publish_end_at > '{$now}' OR pb.publish_end_at IS NULL)" : null;
  $qsc_status           = (! $preview)         ? "AND pb.status = 1"                   : "AND pb.status <= 2";

  if (! empty($id))
  {
    // Get language_id from slug
    if ($language)
    {
      $language_id = 9999;
      $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $language_id = intval($record['id']);
      }
      unset($read_records);
    }

    $post           = array();
    $i_page         = 1;
    $post_pages     = array();
    $post_base      = array();
    $post_category  = array();
    $post_tag       = array();
    $post_text      = array();
    $post_custom    = array();
    $post_family    = array();
    $post_page_navi = array();

    // make select items
    $qsi_publish_datetime = ($database == 1) ? "SUBSTR(pb.publish_datetime, 1, 16)"  : "SUBSTRING(pb.publish_datetime, 1, 16)";
    $qsi_publish_date     = ($database == 1) ? "SUBSTR(pb.publish_datetime, 1, 10)"  : "SUBSTRING(pb.publish_datetime, 1, 10)";
    $qsi_publish_year     = ($database == 1) ? "STRFTIME('%Y', pb.publish_datetime)" : "YEAR(pb.publish_datetime)";
    $qsi_publish_month    = ($database == 1) ? "STRFTIME('%m', pb.publish_datetime)" : "MONTH(pb.publish_datetime)";
    $qsi_publish_day      = ($database == 1) ? "STRFTIME('%d', pb.publish_datetime)" : "DAY(pb.publish_datetime)";

    try {
      // base
      $sql = "
					SELECT
						pb.id AS 'id',
						pb.hash_id AS 'hash_id',
						pb.permalink_key AS 'post_key',
						null AS 'permalink',
						pb.permalink_uri AS 'permalink_uri',
						pb.version AS 'version',
						{$qsi_publish_datetime} AS 'publish_datetime',
						{$qsi_publish_date} AS 'publish_date',
						{$qsi_publish_year} AS 'publish_year',
						{$qsi_publish_month} AS 'publish_month',
						{$qsi_publish_day} AS 'publish_day',
						pb.publish_end_at AS 'publish_end_at',
						pb.site_id AS 'site_id',
						pb.posttype_id AS 'posttype_id',
						pt.language_id AS 'language_id',
						pb.parent_id AS 'parent_id',
						pb.anchor AS 'anchor',
						pb.created_at AS 'created_at',
						pb.created_by AS 'created_by',
						pb.updated_at AS 'updated_at',
						us.nickname AS 'author',
						pb.status AS 'status',
						pb.delete_flg AS 'delete_flg',
						pb.slug AS 'slug',
						pb.eyecatch AS 'eyecatch_raw',
						null AS 'eyecatch',
						pt.title AS 'title',
						pt.addition AS 'description',
						pt.addition AS 'addition',
						pt.content AS 'content',
						pb.category_id AS 'category_id',
						null AS 'category_text',
						null AS 'categories',
						pb.tag_id AS 'tag_id',
						null AS 'tag_text',
						null AS 'tags',
						cfp.value AS comment_type
					FROM {$table_prefix}posts_base AS pb
						LEFT OUTER JOIN {$table_prefix}users AS us
							ON pb.created_by = us.id
						LEFT OUTER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = :LANGUAGE_ID) AS pt
							ON pb.id = pt.base_id AND pb.version = pt.base_version
						LEFT OUTER JOIN (SELECT posttype_id, value FROM {$table_prefix}configs_posttype WHERE site_id = 0 AND item = 'comment_type') AS cfp
							ON pb.posttype_id = cfp.posttype_id
					WHERE
						pb.id = :ID
						AND pb.delete_flg = 0
						{$qsc_version}
						{$qsc_publish_datetime}
						{$qsc_publish_end_at}
						{$qsc_status}
			";
      $read_post_base = $pdo -> prepare($sql);
      $read_post_base -> bindValue(':ID',          $id,          PDO::PARAM_INT);
      $read_post_base -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
      $read_post_base -> execute();
      if ($record = $read_post_base -> fetch(PDO::FETCH_ASSOC))
      {
        // Get configs_posttype
        $configs_posttype = array();
        if ($record['site_id'] && $record['posttype_id'])
        {
          $sql = "
						SELECT item, value FROM {$table_prefix}configs_posttype
						WHERE (site_id = 0 OR site_id = {$record['site_id']}) AND posttype_id = {$record['posttype_id']}
						AND item IN ('permalink_base_prd', 'eyecatch_frame')
						";
          $read_config = $pdo -> prepare($sql);
          $read_config -> execute();
          while ($config = $read_config -> fetch(PDO::FETCH_ASSOC))
          {
            $configs_posttype[$config['item']] = $config['value'];
          }
          unset($read_config);
        }

        // Set permalink_base
        $permalink_base = $configs_posttype['permalink_base_prd'];
        if ($permalink_base && $record['permalink_uri']) $record['permalink'] = $permalink_base . $record['permalink_uri'];

        // Set eyecatch_frame
        $eyecatch_frame = (! $eyecatch_frame) ? $configs_posttype['eyecatch_frame'] : $eyecatch_frame;


        // reset image-frame
        // eyecatch
        $record['eyecatch']['src']['x1'] = $record['eyecatch_raw'];
        $record['eyecatch']['src']['x2'] = str_replace('/1x/', '/2x/', $record['eyecatch_raw']);
        $uri_arr = explode('/', $record['eyecatch_raw']);
        $record['eyecatch']['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
        if (! empty($record['eyecatch_raw']) && ! empty($eyecatch_frame))
        {
          $record['eyecatch']['src']['x1'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $record['eyecatch']['src']['x1']);
          $record['eyecatch']['src']['x2'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $record['eyecatch']['src']['x2']);
        }
        unset($record['eyecatch_raw']);

        // content
        if (! empty($record['content']) && ! empty($content_frame))
        {
          $record['content'] = str_replace('/fr_main/', '/' . $content_frame . '/', $record['content']);
        }
        $record['accept_comment'] = (strpos($record['comment_type'], '1') !== false) ? 1 : 0;
        $record['accept_review']  = (strpos($record['comment_type'], '2') !== false) ? 1 : 0;
        $post_base = $record;
      }
      unset($read_post_base);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    if (! empty($post_base))
    {
      // category
      if (! empty($post_base['category_id']))
      {
        $category_id_arr = explode(',', $post_base['category_id']);
        $post_category['categories'] = array();
        foreach($category_id_arr as $value)
        {
          try {
            $sql = "
								SELECT
									tb.id AS 'taxonomy_id',
									tb.parent_id AS 'parent_id',
									tb.slug AS 'slug',
									tl.label AS 'label'
								FROM {$table_prefix}taxonomies_base AS tb
									INNER JOIN {$table_prefix}taxonomies_label AS tl
										ON tb.id = tl.base_id
								WHERE
									tb.id = :CATEGORY_ID
									AND tl.language_id = :LANGUAGE_ID
						";
            $read_post_category = $pdo -> prepare($sql);
            $read_post_category -> bindValue(':CATEGORY_ID', $value,       PDO::PARAM_INT);
            $read_post_category -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
            $read_post_category -> execute();
            if ($record = $read_post_category -> fetch(PDO::FETCH_ASSOC))
            {
              $post_category['categories'][] = $record;
              $post_category['category_text'][] = $record['label'];
            }
            unset($read_post_category);
          }
          catch(PDOException $e)
          {
            var_dump($e->getMessage());
          }
        }
      }
      else {
        $post_category['categories'] = array();
      }
      $post_category['category_text'] = (! empty($post_category['category_text'])) ? implode(',', $post_category['category_text']) : null;

      // tag
      if (! empty($post_base['tag_id']))
      {
        $tag_id_arr = explode(',', $post_base['tag_id']);
        $post_tag['tags'] = array();
        foreach($tag_id_arr as $value)
        {
          try {
            $sql = "
								SELECT
									tb.id AS 'taxonomy_id',
									tb.slug AS 'slug',
									tl.label AS 'label'
								FROM {$table_prefix}taxonomies_base AS tb
									INNER JOIN {$table_prefix}taxonomies_label AS tl
										ON tb.id = tl.base_id
								WHERE
									tb.id = :TAG_ID
									AND tl.language_id = :LANGUAGE_ID
						";
            $read_post_tag = $pdo -> prepare($sql);
            $read_post_tag -> bindValue(':TAG_ID',      $value,       PDO::PARAM_INT);
            $read_post_tag -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
            $read_post_tag -> execute();
            if ($record = $read_post_tag -> fetch(PDO::FETCH_ASSOC))
            {
              $post_tag['tags'][] = $record;
              $post_tag['tag_text'][] = $record['label'];
            }
            unset($read_post_tag);
          }
          catch(PDOException $e)
          {
            var_dump($e->getMessage());
          }
        }
      }
      else {
        $post_tag['tags'] = array();
      }
      $post_tag['tag_text'] = (! empty($post_tag['tag_text'])) ? implode(',', $post_tag['tag_text']) : null;

      // relations
      if ($recursive)
      {
        $relation_ids = array();
        $post_relations['relations'] = array();
        try {
          $sql = "
						SELECT pc.base_id
						FROM {$table_prefix}posts_custom AS pc
				  		INNER JOIN {$table_prefix}custom_items AS ci
				  			ON pc.custom_item_id = ci.id
		        WHERE pc.value = :BASE_ID AND ci.type = 'relation'
				 ";
          $read_ids = $pdo -> prepare($sql);
          $read_ids -> bindValue(':BASE_ID', (string)$id, PDO::PARAM_STR);
          $read_ids -> execute();
          while ($record = $read_ids -> fetch(PDO::FETCH_ASSOC))
          {
            $relation_ids[] = $record['base_id'];
          }
          unset($read_ids);
          foreach ($relation_ids as $key => $post_key_id)
          {
            $post_relations['relations'][$key] = get_post($post_key_id, array(), false);
          }
        }
        catch(PDOException $e)
        {
          var_dump($e->getMessage());
        }
      }


      // custom
      try {
        $sql = "
						SELECT
							pc.language_id AS 'language_id',
							pc.custom_item_id AS 'custom_item_id',
							ci.slug AS 'column',
							ci.type AS 'type',
							ci.choices AS 'choices',
							pc.value AS 'value'
						FROM {$table_prefix}custom_items AS ci
							LEFT OUTER JOIN {$table_prefix}posts_custom AS pc
								ON  ci.id = pc.custom_item_id
						WHERE
							ci.status = 1
							AND ci.delete_flg   = 0
							AND pc.base_id      = :BASE_ID
							AND pc.base_version = :BASE_VERSION
							AND pc.language_id  = :LANGUAGE_ID
				";
        $read_post_custom = $pdo -> prepare($sql);
        $read_post_custom -> bindValue(':BASE_ID',      $id,                   PDO::PARAM_INT);
        $read_post_custom -> bindValue(':BASE_VERSION', $post_base['version'], PDO::PARAM_INT);
        $read_post_custom -> bindValue(':LANGUAGE_ID',  $language_id,          PDO::PARAM_INT);
        $read_post_custom -> execute();
        while ($record = $read_post_custom -> fetch(PDO::FETCH_ASSOC))
        {
          // reset image-frame
          if ($record['type'] == 'image')
          {
            if (isset($custom_frame[$record['column']]))
            {
              $record['value'] = preg_replace('/\/fr_(auto|crop)\/[0-9]{2,3}\//', '/' . $custom_frame[$record['column']] . '/', $record['value']);
            }
            $x1 = $record['value'];
            $x2 = preg_replace('/\/1x\//', '/2x/', $x1);
            $key = 'custom_' . $record['column'];
            $post_custom[$key]['src']['x1'] = $x1;
            $post_custom[$key]['src']['x2'] = $x2;
            $uri_arr = explode('/', $record['value']);
            $post_custom[$key]['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
          }
          elseif ($record['type'] == 'gallery')
          {
            $urls     = array();
            $captions = array();
            if (preg_match('/\n/', $record['value']))
            {
              $record_arr = explode("\n", $record['value']);
              $urls     = $record_arr[0];
              $captions = $record_arr[1];
            }
            else {
              $urls = $record['value'];
            }
            $urls = make_list_data($urls, ',', false);
            $captions = make_list_data($captions, ',', false);
            $x_arr = array();
            foreach($urls as $key => $value)
            {
              $x1 = $value;
              $x2 = preg_replace('/\/1x\//', '/2x/', $x1);
              $x2_arr[$key] = $x2;
              $x_arr[$key]['src']['x1'] = $x1;
              $x_arr[$key]['src']['x2'] = $x2;
              $uri_arr = explode('/', $value);
              $x_arr[$key]['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
              $x_arr[$key]['caption'] = $captions[$key];
            }

            $key = 'custom_' . $record['column'];
            $post_custom[$key] = $x_arr;
          }
          else {
            // Generate relation
            if ($recursive)
            {
              if ($record['type'] == 'relation' && ! empty($record['value']))
              {
                $record['value'] = get_post($record['value'], array(), false);
                unset($record['value']['post_body']['page_navi']);
                unset($record['value']['post_body']['family']);
              }
            }

            // sanitize syntax
            if ($record['type'] == 'syntax')
            {
              $record['value'] = htmlspecialchars($record['value'], ENT_QUOTES);
            }

            // Shape list
            if ($record['type'] == 'list')
            {
              $record['value'] = make_list_data($record['value']);
            }

            // Shape table
            if ($record['type'] == 'table')
            {
              $delimiter = '';
              switch ($record['choices'])
              {
                case 'comma'    : $delimiter = ','; break;
                case 'semicolon': $delimiter = ';'; break;
                case 'colon'    : $delimiter = ':'; break;
                case 'slash'    : $delimiter = '/'; break;
                case 'dot'      : $delimiter = '.'; break;
              }
              $record['value'] = make_table_data($record['value'], $delimiter);
            }

            $key = 'custom_' . $record['column'];
            $post_custom[$key] = $record['value'];
          }
        }
        unset($read_post_custom);
      }
      catch(PDOException $e)
      {
        var_dump($e->getMessage());
      }

      // make search condition for children
      $qsc_id = (! empty($post_base['parent_id'])) ? "AND (pb.id = {$post_base['parent_id']} OR pb.parent_id = {$post_base['parent_id']})" : "AND (id = {$id} OR parent_id = {$id})";

      // children
      try {
        $sql = "
						SELECT
							pb.id AS 'id',
							pb.hash_id AS 'hash_id',
							pb.permalink_key AS 'post_key',
							null AS 'permalink',
							pb.permalink_uri AS 'permalink_uri',
							pb.parent_id AS 'parent_id',
							pb.version AS 'version',
							{$qsi_publish_datetime} AS 'publish_datetime',
							pb.created_at AS 'created_at',
							pb.created_by AS 'created_by',
							pb.status AS 'status',
							pb.delete_flg AS 'delete_flg',
							pb.slug AS 'slug',
							pb.eyecatch AS 'eyecatch_raw',
							null AS 'eyecatch',
							pt.title AS 'title',
							pt.addition AS 'description',
							pt.addition AS 'addition',
							pt.content AS 'content'
						FROM {$table_prefix}posts_base AS pb
							LEFT OUTER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = :LANGUAGE_ID) AS pt
								ON pb.id = pt.base_id AND pb.version = pt.base_version
						WHERE
							pb.delete_flg = 0
							AND pb.status = 1
							AND pt.base_version = :BASE_VERSION
							{$qsc_id}
						ORDER BY pb.id ASC
				";
        $read_post_children = $pdo -> prepare($sql);
        $read_post_children -> bindValue(':LANGUAGE_ID',  $language_id,          PDO::PARAM_INT);
        $read_post_children -> bindValue(':BASE_VERSION', $post_base['version'], PDO::PARAM_INT);
        $read_post_children -> execute();
        while ($record = $read_post_children -> fetch(PDO::FETCH_ASSOC))
        {
          // eyecatch
          $record['eyecatch']['src']['x1'] = $record['eyecatch_raw'];
          $record['eyecatch']['src']['x2'] = str_replace('/1x/', '/2x/', $record['eyecatch_raw']);
          $uri_arr = explode('/', $record['eyecatch_raw']);
          $record['eyecatch']['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
          if (! empty($record['eyecatch_raw']) && ! empty($eyecatch_frame))
          {
            $record['eyecatch']['src']['x1'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $record['eyecatch']['src']['x1']);
            $record['eyecatch']['src']['x2'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $record['eyecatch']['src']['x2']);
          }
          unset($record['eyecatch_raw']);

          // permalink
          if ($permalink_base && $record['permalink_uri'])
          {
            $record['permalink'] = $permalink_base . $record['permalink_uri'];
          }

          // make outline
          if ($record['parent_id'] == 0)
          {
            $post_family['family']['outline'] = array
            (
              'parent_id'             => $record['id'],
              'parent_hash_id'        => $record['hash_id'],
              'parent_post_key'       => $record['post_key'],
              'parent_permalink'      => $record['permalink'],
              'parent_permalink_urk'  => $record['permalink_uri'],
              'parent_slug'           => $record['slug'],
              'parent_eyecatch'       => $record['eyecatch'],
              'publish_datetime'      => $record['publish_datetime'],
              'publish_end_at'        => $record['publish_end_at'],
              'title'                 => $record['title'],
            );
          }

          // make page-index
          $post_family['family']['page_index'][$i_page] = array
          (
            'id'             => $record['id'],
            'hash_id'        => $record['hash_id'],
            'post_key'       => $record['post_key'],
            'permalink'      => $record['permalink'],
            'permalink_uri'  => $record['permalink_uri'],
            'slug'           => $record['slug'],
            'description'    => $record['description'],
            'addition'       => $record['addition'],
            'eyecatch'       => $record['eyecatch'],
            'content_head'   => substructString($record['content'], $content_head_length),
          );

          // make list
          $record['content'] = substructString($record['content'], $content_head_length);
          $post_family['family']['list'][$record['id']] = $record;
          $i_page ++;
        }
        unset($read_post_children);
        $post_family['family']['outline']['pages'] = $i_page;
      }
      catch(PDOException $e)
      {
        var_dump($e->getMessage());
      }

      // set custom items
      if ($with_child_custom && count($post_family['family']['list']) > 1)
      {
        // children custom
        foreach ($post_family['family']['list'] as $family_id => $row)
        {
          $post_child_custom = array();
          try {
            $sql = "
								SELECT
									pc.language_id AS 'language_id',
									pc.custom_item_id AS 'custom_item_id',
									ci.type AS 'type',
									ci.slug AS 'column',
									pc.value AS 'value'
								FROM {$table_prefix}posts_custom AS pc
									RIGHT OUTER JOIN {$table_prefix}custom_items AS ci
										ON  pc.custom_item_id = ci.id
								WHERE
									ci.status = 1
									AND ci.delete_flg = 0
									AND pc.base_id      = :BASE_ID
									AND pc.base_version = :BASE_VERSION
									AND pc.language_id  = :LANGUAGE_ID
						";
            $read_post_child_custom = $pdo -> prepare($sql);
            $read_post_child_custom -> bindValue(':BASE_ID',      $family_id,      PDO::PARAM_INT);
            $read_post_child_custom -> bindValue(':BASE_VERSION', $row['version'], PDO::PARAM_INT);
            $read_post_child_custom -> bindValue(':LANGUAGE_ID',  $language_id,    PDO::PARAM_INT);
            $read_post_child_custom -> execute();
            while ($record = $read_post_child_custom -> fetch(PDO::FETCH_ASSOC))
            {
              $key = 'custom_' . $record['column'];
              $post_family['family']['list'][$family_id][$key] = $record['value'];
            }
            unset($read_post_child_custom);
          }
          catch(PDOException $e)
          {
            var_dump($e->getMessage());
          }
        }
      }

      // add count comments
      $post_count_comments = array();
      if (! empty($post_base))
      {
        $sql = "
						SELECT DISTINCT(type) AS type, COUNT(*) AS count
						FROM {$table_prefix}comments
						WHERE
							delete_flg = 0
							AND status = 1
							AND post_id = :ID
							AND comment_id = 0
						GROUP BY type
				";
        $read_count_comment = $pdo -> prepare($sql);
        $read_count_comment -> bindValue(':ID', $id, PDO::PARAM_INT);
        $read_count_comment -> execute();
        while ($record = $read_count_comment -> fetch(PDO::FETCH_ASSOC))
        {
          $post_count_comments['count_comments'][$record['type']] = $record['count'];
        }
        unset($read_count_comment);
      }

      // index array of family_list
      $post_family['family']['list'] = index_fromone($post_family['family']['list']);

      // make page info
      $post_page_navi['page_navi'] = array('prev_page' => array(), 'this_page' => array(), 'next_page' => array());
      if (count($post_family['family']['list']) > 1)
      {
        foreach ($post_family['family']['list'] as $key => $row_family)
        {
          if ($row_family['id'] == $id)
          {
            if ($key > 1)
            {
              $post_page_navi['page_navi']['prev_page']['page']         = $key - 1;
              $post_page_navi['page_navi']['prev_page']['id']           = $post_family['family']['list'][$key - 1]['id'];
              $post_page_navi['page_navi']['prev_page']['description']  = $post_family['family']['list'][$key - 1]['description'];
              $post_page_navi['page_navi']['prev_page']['addition']     = $post_family['family']['list'][$key - 1]['addition'];
              $post_page_navi['page_navi']['prev_page']['content_head'] = $post_family['family']['list'][$key - 1]['content'];
            }

            $post_page_navi['page_navi']['this_page']['page']         = $key;
            $post_page_navi['page_navi']['this_page']['id']           = $row_family['id'];
            $post_page_navi['page_navi']['this_page']['description']  = $row_family['description'];
            $post_page_navi['page_navi']['this_page']['addition']     = $row_family['addition'];
            $post_page_navi['page_navi']['this_page']['content_head'] = $row_family['content'];

            if ($key < count($post_family['family']['list']))
            {
              $post_page_navi['page_navi']['next_page']['page']         = $key + 1;
              $post_page_navi['page_navi']['next_page']['id']           = $post_family['family']['list'][$key + 1]['id'];
              $post_page_navi['page_navi']['next_page']['description']  = $post_family['family']['list'][$key + 1]['description'];
              $post_page_navi['page_navi']['next_page']['addition']     = $post_family['family']['list'][$key + 1]['addition'];
              $post_page_navi['page_navi']['next_page']['content_head'] = $post_family['family']['list'][$key + 1]['content'];
            }
          }
        }
      }

      // get counter
      $post_counter = array();
      if ($with_counter)
      {
        try {
          $sql = "SELECT * FROM {$table_prefix}counters WHERE post_id = {$id} ORDER BY type ASC";
          $read_records = $pdo -> prepare($sql);
          $read_records -> execute();
          while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
          {
            $post_counter['counter'][$record['type']]['count']      = $record['count'];
            $post_counter['counter'][$record['type']]['updated_at'] = $record['updated_at'];
          }
          unset($read_records);
        }
        catch(PDOException $e)
        {
          var_dump($e->getMessage());
        }
      }

      // merge all items
      if ($recursive)
      {
        $post = array_merge($post_base, $post_category, $post_tag, $post_custom, $post_count_comments, $post_relations, $post_pages, $post_page_navi, $post_family, $post_counter);
      }
      else {
        $post = array_merge($post_base, $post_category, $post_tag, $post_custom, $post_count_comments);
      }

      $post['categories'] = index_fromone($post['categories']);
      $post['tags']       = index_fromone($post['tags']);
      if (isset($post['relations'])) $post['relations'] = index_fromone($post['relations']);
    }
    return $post;
  }
  else {
    return false;
  }
}


/**
 * Get Posts
 * [@param  array $config]
 *  + @param[item] number  'limit' ('0' has meaning, so default is null)
 *  + @param[item] number  'page' (should be more than 1)
 *  + @param[item] number  'content_length'
 *  + @param[item] number  'orderby' (0:DESC 1:ASC)
 *  + @param[item] string  'site' (slug)
 *  + @param[item] number  'site_id' ('0' means abandoning to fetch)
 *  + @param[item] string  'posttype' (slug)
 *  + @param[item] mixed   'posttype_id' ('0' means abandoning to fetch, number or string like '1,2' is also available)
 *  + @param[item] string  'language(slug)'
 *  + @param[item] number  'language_id' ('0' means abandoning to fetch)
 *  + @param[item] number  'anchor_equal' ('0' has meaning, so default is null)
 *  + @param[item] number  'anchor_morethan' ('0' has meaning, so default is null)
 *  + @param[item] number  'anchor_lessthan' ('0' has meaning, so default is null)
 *  + @param[item] number  'year'
 *  + @param[item] number  'month'
 *  + @param[item] number  'day'
 *  + @param[item] mixed   'text' (string or array)
 *  + @param[item] string  'title'
 *  + @param[item] string  'addition'
 *  + @param[item] string  'content'
 *  + @param[item] mixed   'category' (for narrow down / slug, string or array)
 *  + @param[item] mixed   'category_id' (for narrow down / number or string or array)
 *  + @param[item] mixed   'tag' (for narrow down / slug, string or array)
 *  + @param[item] mixed   'tag_id' (for narrow down / number or string or array)
 *  + @param[item] mixed   'exclude_category' (for narrow down / slug, string or array)
 *  + @param[item] mixed   'exclude_category_id' (for narrow down / number or string or array)
 *  + @param[item] mixed   'exclude_tag' (for narrow down / slug, string or array)
 *  + @param[item] mixed   'exclude_tag_id' (for narrow down / number or string or array)
 *  + @param[item] number  'created_by'
 *  + @param[item] string  'date_from' (yyyy-mm-dd)
 *  + @param[item] string  'date_to' (yyyy-mm-dd)
 *  + @param[item] string  'eyecatch_frame'
 *  + @param[item] string  'content_frame'
 *  + @param[item] array   'custom_frame' (slug => frame)
 *  + @param[item] boolean 'with_list_index' (0: don't fetch list_index / 1: fetch list_index)
 *  + @param[item] boolean 'with_custom' (0: don't fetch custom_item / 1: fetch custom_item)
 *  + @param[item] boolean 'with_counter' (0: don't fetch counters / 1: fetch counters)
 *  + @param[item] boolean 'count_comment' (0: don't count comments / 1: count comments)
 *  + @param[item] boolean 'ignore_anchor' (0: sort by anchor and id / 1: sort by only id)
 * @return array $posts
 */
function get_posts($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $limit               = (isset($config['limit']))                  ? intval($config['limit'])                       : null;
  $page                = (! empty($config['page']))                 ? intval($config['page'])                        : 1;
  $content_length      = (isset($config['content_length']))         ? intval($config['content_length'])              : 0;
  $orderby             = (isset($config['orderby']))                ? $config['orderby']                             : 0; // DESC first
  $site                = (! empty($config['site']))                 ? $config['site']                                : null;
  $site_id             = (isset($config['site_id']))                ? intval($config['site_id'])                     : 1;
  $posttype            = (! empty($config['posttype']))             ? $config['posttype']                            : null;
  $posttype_id         = (isset($config['posttype_id']))            ? $config['posttype_id']                         : 1;
  $language            = (! empty($config['language']))             ? $config['language']                            : null;
  $language_id         = (isset($config['language_id']))            ? intval($config['language_id'])                 : 1;
  $anchor_equal        = (isset($config['anchor_equal']))           ? intval($config['anchor_equal'])                : null;
  $anchor_morethan     = (isset($config['anchor_morethan']))        ? intval($config['anchor_morethan'])             : null;
  $anchor_lessthan     = (isset($config['anchor_lessthan']))        ? intval($config['anchor_lessthan'])             : null;
  $year                = (! empty($config['year']))                 ? intval($config['year'])                        : 0;
  $month               = (! empty($config['month']))                ? sprintf('%02d', intval($config['month']))      : 0;
  $day                 = (! empty($config['day']))                  ? sprintf('%02d', intval($config['day']))        : 0;
  $text                = (! empty($config['text']))                 ? mb_convert_kana($config['text'], 's', 'UTF-8') : null;
  $title               = (! empty($config['title']))                ? $config['title']                               : null;
  $addition            = (! empty($config['addition']))             ? $config['addition']                            : null;
  $content             = (! empty($config['content']))              ? $config['content']                             : null;
  $category            = (! empty($config['category']))             ? $config['category']                            : null;
  $category_id         = (! empty($config['category_id']))          ? $config['category_id']                         : null;
  $tag                 = (! empty($config['tag']))                  ? $config['tag']                                 : null;
  $tag_id              = (! empty($config['tag_id']))               ? $config['tag_id']                              : null;
  $exclude_category    = (! empty($config['exclude_category']))     ? $config['exclude_category']                    : null;
  $exclude_category_id = (! empty($config['exclude_category_id']))  ? $config['exclude_category_id']                 : null;
  $exclude_tag         = (! empty($config['exclude_tag']))          ? $config['exclude_tag']                         : null;
  $exclude_tag_id      = (! empty($config['exclude_tag_id']))       ? $config['exclude_tag_id']                      : null;
  $author              = (! empty($config['author']))               ? $config['author']                              : null;
  $author_id           = (! empty($config['author_id']))            ? intval($config['author_id'])                   : 0;
  $group               = (! empty($config['group']))                ? $config['group']                               : null;
  $group_id            = (! empty($config['group_id']))             ? intval($config['group_id'])                    : 0;
  $date_from           = (! empty($config['date_from']))            ? $config['date_from']                           : null;
  $date_to             = (! empty($config['date_to']))              ? $config['date_to']                             : null;
  $eyecatch_frame      = (! empty($config['eyecatch_frame']))       ? $config['eyecatch_frame']                      : null;
  $content_frame       = (! empty($config['content_frame']))        ? $config['content_frame']                       : null;
  $custom_frame        = (! empty($config['custom_frame']))         ? $config['custom_frame']                        : array();
  $with_list_index     = (isset($config['with_list_index']))        ? intval($config['with_list_index'])             : 1;
  $with_custom         = (isset($config['with_custom']))            ? intval($config['with_custom'])                 : 1;
  $with_counter        = (isset($config['with_counter']))           ? intval($config['with_counter'])                : 1;
  $count_comments      = (isset($config['count_comments']))         ? intval($config['count_comments'])              : 0;
  $ignore_anchor       = (isset($config['ignore_anchor']))          ? intval($config['ignore_anchor'])               : 0;
  $preview             = (isset($config['preview']))                ? intval($config['preview'])                     : 0;

  // Format orderby
  if ($orderby)
  {
    if (strtoupper($orderby) === 'ASC')
    {
      $orderby = 1;
    }
    elseif (strtoupper($orderby) === 'DESC')
    {
      $orderby = 0;
    }
    elseif (intval($orderby) > 0) {
      $orderby = 1;
    }
    else {
      $orderby = 0;
    }
  }

  // Get site_id from slug
  if ($site)
  {
    $site_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get configs_posttype
  $configs_posttype = array();
  if ($site_id && $posttype_id)
  {
    $sql = "
			SELECT item, value FROM {$table_prefix}configs_posttype
			WHERE (site_id = 0 OR site_id = {$site_id}) AND posttype_id = {$posttype_id}
			AND item IN ('permalink_base_prd', 'eyecatch_frame')
			";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $configs_posttype[$record['item']] = $record['value'];
    }
    unset($permalink_base);
  }

  // Set permalink_base
  $permalink_base = $configs_posttype['permalink_base_prd'];

  // Set eyecatch_frame
  $eyecatch_frame = (! $eyecatch_frame) ? $configs_posttype['eyecatch_frame'] : $eyecatch_frame;

  // Get language_id from slug
  if ($language)
  {
    $language_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $language_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get author_id from author
  if ($author)
  {
    $sql = "SELECT id FROM {$table_prefix}users WHERE account = '{$author}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $author_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get group_id from group
  if ($group)
  {
    $sql = "SELECT id FROM {$table_prefix}groups WHERE slug = '{$group}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $group_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get assigned user_id by group
  $group_user_ids = null;
  if ($group_id)
  {
    $sql = "SELECT id FROM {$table_prefix}users WHERE group_id = $group_id";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $group_user_ids_arr[] = intval($record['id']);
    }
    unset($read_records);
    if (! empty($group_user_ids_arr)) $group_user_ids = implode(',', $group_user_ids_arr);
  }


  // Shape Category
  $category_ids = array();

  // Shape category_id to array
  if ($category_id)
  {
    if (! is_array($category_id))
    {
      $category_id_arr = array_map('intval', array_map('trim', explode(',', $category_id)));
      foreach ($category_id_arr as $category_id)
      {
        $category_ids[] = sprintf('%04d', $category_id);
      }
    }
  }

  // Get category_id from slug
  if ($category)
  {
    if (! is_array($category))
    {
      $category_arr = array_map('trim', explode(',', $category));
    }
    else {
      $category_arr = $category;
    }
    foreach ($category_arr as $category)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 1 AND posttype_id = {$posttype_id} AND slug = '{$category}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $category_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }


  // Shape Tag
  $tag_ids = array();

  // Shape tag_id to array
  if ($tag_id)
  {
    if (! is_array($tag_id))
    {
      $tag_id_arr = array_map('intval', array_map('trim', explode(',', $tag_id)));
      foreach ($tag_id_arr as $tag_id)
      {
        $tag_ids[] = sprintf('%04d', $tag_id);
      }
    }
  }

  // Get tag_id from slug
  if ($tag)
  {
    if (! is_array($tag))
    {
      $tag_arr = array_map('trim', explode(',', $tag));
    }
    else {
      $tag_arr = $tag;
    }
    foreach ($tag_arr as $tag)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 2 AND posttype_id = {$posttype_id} AND slug = '{$tag}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $tag_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }

  // Shape Exclude Category
  $exclude_category_ids = array();

  // Shape Exclude_category_id to array
  if ($exclude_category_id)
  {
    if (! is_array($exclude_category_id))
    {
      $exclude_category_id_arr = array_map('intval', array_map('trim', explode(',', $exclude_category_id)));
      foreach ($exclude_category_id_arr as $exclude_category_id)
      {
        $exclude_category_ids[] = sprintf('%04d', $exclude_category_id);
      }
    }
  }

  // Get category_id from slug
  if ($exclude_category)
  {
    if (! is_array($exclude_category))
    {
      $exclude_category_arr = array_map('trim', explode(',', $exclude_category));
    }
    else {
      $exclude_category_arr = $exclude_category;
    }
    foreach ($exclude_category_arr as $exclude_category)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 1 AND posttype_id = {$posttype_id} AND slug = '{$exclude_category}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $exclude_category_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }


  // Shape Exclude Tag
  $exclude_tag_ids = array();

  // Shape tag_id to array
  if ($exclude_tag_id)
  {
    if (! is_array($exclude_tag_id))
    {
      $exclude_tag_id_arr = array_map('intval', array_map('trim', explode(',', $exclude_tag_id)));
      foreach ($exclude_tag_id_arr as $exclude_tag_id)
      {
        $exclude_tag_ids[] = sprintf('%04d', $exclude_tag_id);
      }
    }
  }

  // Get tag_id from slug
  if ($exclude_tag)
  {
    if (! is_array($exclude_tag))
    {
      $exclude_tag_arr = array_map('trim', explode(',', $exclude_tag));
    }
    else {
      $exclude_tag_arr = $exclude_tag;
    }
    foreach ($exclude_tag_arr as $exclude_tag)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 2 AND posttype_id = {$posttype_id} AND slug = '{$exclude_tag}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $exclude_tag_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }


  // Shape Text
  $texts = array();

  // Shape text to array
  if ($text)
  {
    if (! is_array($text))
    {
      $texts = explode(' ', $text);
    }
  }


  // Fix posttype_id
  $qsc_posttype_id = null;
  if (! is_numeric($posttype_id) && strpos($posttype_id, ',') !== false)
  {
    $posttype_ids = explode(',', $posttype_id);
    foreach ($posttype_ids as $key => $value)
    {
      $posttype_ids[$key] = intval($value);
    }
    $posttype_id = implode(',', $posttype_ids);
    $qsc_posttype_id = "AND pb.posttype_id IN ({$posttype_id})";

  }
  elseif (is_numeric($posttype_id))
  {
    $posttype_id = intval($posttype_id);
    $qsc_posttype_id = "AND pb.posttype_id = {$posttype_id}";
  }

  // make values
  $offset              = ($limit > 0) ? ($page - 1) * $limit : 0;
  $orderby             = (empty($orderby))              ? 'DESC'          : 'ASC';
  $title               = ($title)                       ? "%{$title}%"    : "%%";
  $addition            = ($addition)                    ? "%{$addition}%" : "%%";
  $content             = ($content)                     ? "%{$content}%"  : "%%";
  $date_from           = (! empty($date_from))          ? date('Y-m-d H:i:s', strtotime($date_from)) : null;
  $date_to             = (! empty($date_to))            ? date('Y-m-d H:i:s', strtotime($date_to))   : null;

  // make text condition by multipe word
  $qsc_text = null;
  foreach ($texts as $key => $value)
  {
    $qsc_text .= " AND (title LIKE :TEXT{$key} OR addition LIKE :TEXT{$key} OR content LIKE :TEXT{$key})";
  }

  // make arranged item
  $qsi_publish_datetime = ($database == 1)  ? "SUBSTR(pb.publish_datetime, 1, 16)"  : "SUBSTRING(pb.publish_datetime, 1, 16)";
  $qsi_publish_date     = ($database == 1)  ? "SUBSTR(pb.publish_datetime, 1, 10)"  : "SUBSTRING(pb.publish_datetime, 1, 10)";

  // make search condition
  $now = date('Y-m-d H:i:s');
  $qsc_publish_datetime = (! $preview)                         ? "AND pb.publish_datetime <= '{$now}'"                             : null;
  $qsc_publish_end_at   = (! $preview)                         ? "AND (pb.publish_end_at > '{$now}' OR pb.publish_end_at IS NULL)" : null;
  $qsc_status           = (! $preview)                         ? "AND pb.status = 1"                                               : "AND pb.status <= 2";
  $qsc_publish_year     = (! empty($year))  ? ($database == 1) ? "AND STRFTIME('%Y', pb.publish_datetime) = '{$year}'"             : "AND YEAR(pb.publish_datetime) = '{$year}'"   : null;
  $qsc_publish_month    = (! empty($month)) ? ($database == 1) ? "AND STRFTIME('%m', pb.publish_datetime) = '{$month}'"            : "AND MONTH(pb.publish_datetime) = '{$month}'" : null;
  $qsc_publish_day      = (! empty($day))   ? ($database == 1) ? "AND STRFTIME('%d', pb.publish_datetime) = '{$day}'"              : "AND DAY(pb.publish_datetime) = '{$day}'"     : null;
  $qsc_date_from        = (! empty($date_from))                ? "AND pb.publish_datetime >= '{$date_from}'"                       : null;
  $qsc_date_to          = (! $preview) ? (! empty($date_to))   ? "AND pb.publish_datetime <= '{$date_to}'"                         : "AND pb.publish_datetime <= '{$now}'"         : null;
  $qsc_category_id = null;
  if (count($category_ids))
  {
    $qsc_category_id = 'AND (';
    foreach ($category_ids as $key => $category_id)
    {
      if ($key > 0) $qsc_category_id .= ' OR ';
      $qsc_category_id .= "pb.category_id LIKE '%{$category_id}%'";
    }
    $qsc_category_id .= ')';
  }
  $qsc_tag_id = null;
  if (count($tag_ids))
  {
    $qsc_tag_id = 'AND (';
    foreach ($tag_ids as $key => $tag_id)
    {
      if ($key > 0) $qsc_tag_id .= ' OR ';
      $qsc_tag_id .= "pb.tag_id LIKE '%{$tag_id}%'";
    }
    $qsc_tag_id .= ')';
  }
  $qsc_exclude_category_id = null;
  if (count($exclude_category_ids))
  {
    $qsc_exclude_category_id = 'AND (';
    foreach ($exclude_category_ids as $key => $exclude_category_id)
    {
      if ($key > 0) $qsc_exclude_category_id .= ' AND ';
      $qsc_exclude_category_id .= "pb.category_id NOT LIKE '%{$exclude_category_id}%'";
    }
    $qsc_exclude_category_id .= ')';
  }
  $qsc_exclude_tag_id = null;
  if (count($exclude_tag_ids))
  {
    $qsc_exclude_tag_id = 'AND (';
    foreach ($exclude_tag_ids as $key => $exclude_tag_id)
    {
      if ($key > 0) $qsc_exclude_tag_id .= ' AND ';
      $qsc_exclude_tag_id .= "pb.tag_id NOT LIKE '%{$exclude_tag_id}%'";
    }
    $qsc_exclude_tag_id .= ')';
  }
  $qsc_anchor_equal      = ($anchor_equal    !== null)  ? "AND pb.anchor =  {$anchor_equal}"     : null;
  $qsc_anchor_morethan   = ($anchor_morethan !== null)  ? "AND pb.anchor >= {$anchor_morethan}"  : null;
  $qsc_anchor_lessthan   = ($anchor_lessthan !== null)  ? "AND pb.anchor <= {$anchor_lessthan}"  : null;
  $qsc_created_by        = (! empty($author_id))        ? "AND pb.created_by = {$author_id}"     : null;
  $qsc_grouped_by  = (! empty($group_id))  ? "AND (pb.grouped_by = {$group_id} OR pb.created_by IN ($group_user_ids))"  : null;

  // make order by
  $query_orderby = ($ignore_anchor) ? "pb.publish_datetime {$orderby}, pb.id {$orderby}" : "pb.anchor DESC, pb.publish_datetime {$orderby}, pb.id {$orderby}";

  // make limit
  $query_limit = ($limit) ? "LIMIT {$limit} OFFSET {$offset}" : null;

  // return value
  $posts = array('outline' => array(), 'list_index' => array(), 'list' => array());

  // Count
  try {
    $sql = "
				SELECT COUNT(pb.id) AS 'count'
				FROM {$table_prefix}posts_base AS pb
					INNER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = :LANGUAGE_ID AND title LIKE :TITLE AND addition LIKE :ADDITION AND content LIKE :CONTENT {$qsc_text}) AS pt
						ON pb.id = pt.base_id AND pb.version = pt.base_version
				WHERE
					pb.current_flg = 1
					AND pb.delete_flg = 0
					AND pb.parent_id = 0
					AND pb.site_id = :SITE_ID
					{$qsc_status}
					{$qsc_publish_datetime}
					{$qsc_publish_end_at}
					{$qsc_posttype_id}
					{$qsc_publish_year}
					{$qsc_publish_month}
					{$qsc_publish_day}
					{$qsc_date_from}
					{$qsc_date_to}
					{$qsc_category_id}
					{$qsc_tag_id}
					{$qsc_exclude_category_id}
					{$qsc_exclude_tag_id}
					{$qsc_anchor_equal}
					{$qsc_anchor_morethan}
					{$qsc_anchor_lessthan}
					{$qsc_created_by}
					{$qsc_grouped_by}
		";
    $read_count = $pdo -> prepare($sql);
    $read_count -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
    foreach ($texts as $key => $value)
    {
      $read_count -> bindValue(":TEXT".$key , "%{$value}%", PDO::PARAM_STR);
    }
    $read_count -> bindValue(':TITLE',       $title,       PDO::PARAM_STR);
    $read_count -> bindValue(':ADDITION',    $addition,    PDO::PARAM_STR);
    $read_count -> bindValue(':CONTENT',     $content,     PDO::PARAM_STR);
    $read_count -> bindValue(':SITE_ID',     $site_id,     PDO::PARAM_INT);
    $read_count -> execute();
    if ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
    {
      $posts['outline']['count_total'] = $record['count'];
      $posts['outline']['limit'] = $limit;
      $pages = ($limit) ? ceil($record['count'] / $limit) : 1;
      $posts['outline']['pages'] = $pages;
    }
    unset($read_count);
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }

  // List Index
  $posts['list_index'] = array();
  if ($with_list_index)
  {
    try {
      $sql = "
					SELECT
						pb.id AS 'id',
						pb.hash_id AS 'hash_id',
						pb.permalink_key AS 'post_key',
						null AS 'permalink',
						pb.permalink_uri AS 'permalink_uri',
						pb.slug AS 'slug',
						pb.eyecatch AS 'eyecatch_raw',
						null AS 'eyecatch',
						pt.title AS 'title'
					FROM {$table_prefix}posts_base AS pb
						INNER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = :LANGUAGE_ID AND title LIKE :TITLE AND addition LIKE :ADDITION AND content LIKE :CONTENT {$qsc_text}) AS pt
							ON pb.id = pt.base_id AND pb.version = pt.base_version
					WHERE
						pb.current_flg = 1
						AND pb.delete_flg = 0
						AND pb.parent_id = 0
						AND pb.site_id = :SITE_ID
						{$qsc_status}
            {$qsc_publish_datetime}
            {$qsc_publish_end_at}
						{$qsc_posttype_id}
						{$qsc_publish_year}
						{$qsc_publish_month}
						{$qsc_publish_day}
						{$qsc_date_from}
						{$qsc_date_to}
						{$qsc_category_id}
						{$qsc_tag_id}
						{$qsc_exclude_category_id}
						{$qsc_exclude_tag_id}
						{$qsc_anchor_equal}
						{$qsc_anchor_morethan}
						{$qsc_anchor_lessthan}
						{$qsc_created_by}
						{$qsc_grouped_by}
					ORDER BY {$query_orderby}
			";
      $read_count = $pdo -> prepare($sql);
      $read_count -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
      foreach ($texts as $key => $value)
      {
        $read_count -> bindValue(":TEXT{$key}", "%{$value}%", PDO::PARAM_STR);
      }
      $read_count -> bindValue(':TITLE',       $title,       PDO::PARAM_STR);
      $read_count -> bindValue(':ADDITION',    $addition,    PDO::PARAM_STR);
      $read_count -> bindValue(':CONTENT',     $content,     PDO::PARAM_STR);
      $read_count -> bindValue(':SITE_ID',     $site_id,     PDO::PARAM_INT);
      $read_count -> execute();

      $list_index_i = 1;
      while ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
      {
        // eyecatch
        $record['eyecatch']['src']['x1'] = $record['eyecatch_raw'];
        $record['eyecatch']['src']['x2'] = str_replace('/1x/', '/2x/', $record['eyecatch_raw']);
        $uri_arr = explode('/', $record['eyecatch_raw']);
        $record['eyecatch']['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
        if (! empty($record['eyecatch_raw']) && ! empty($eyecatch_frame))
        {
          $record['eyecatch']['src']['x1'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $record['eyecatch']['src']['x1']);
          $record['eyecatch']['src']['x2'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $record['eyecatch']['src']['x2']);
        }
        unset($record['eyecatch_raw']);

        $record['permalink'] = $permalink_base . $record['permalink_uri'];
        $posts['list_index'][$list_index_i] = $record;
        $list_index_i ++;
      }
      unset($read_count);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }

  // Get post data
  if (! empty($posts['outline']['count_total']))
  {
    // Posts
    try {
      $sql = "
					SELECT
						pb.id AS 'id',
						pb.hash_id AS 'hash_id',
						pb.permalink_key AS 'post_key',
						pb.version AS 'version',
						null AS 'permalink',
						pb.permalink_uri AS 'permalink_uri',
						{$qsi_publish_datetime} AS 'publish_datetime',
						{$qsi_publish_date} AS 'publish_date',
						pb.publish_end_at AS 'publish_end_at',
						pb.parent_id AS 'parent_id',
						pb.anchor AS 'anchor',
						pb.created_by AS 'author_id',
						us.nickname AS 'author',
						pb.created_at AS 'created_at',
						pb.updated_at AS 'updated_at',
						pb.slug AS 'slug',
						pb.eyecatch AS 'eyecatch_raw',
						null AS 'eyecatch',
						pt.title AS 'title',
						pt.addition AS 'description',
						pt.addition AS 'addition',
						pt.content AS 'content',
						0 AS 'content_cut_flg',
						pb.category_id AS 'category_id',
						pb.tag_id AS 'tag_id',
						CASE WHEN pb2.count_children IS NOT NULL THEN pb2.count_children ELSE 0 END AS 'count_children'
					FROM {$table_prefix}posts_base AS pb
						INNER JOIN (SELECT * FROM {$table_prefix}posts_text WHERE language_id = :LANGUAGE_ID AND title LIKE :TITLE AND addition LIKE :ADDITION AND content LIKE :CONTENT {$qsc_text}) AS pt
							ON pb.id = pt.base_id AND pb.version = pt.base_version
						LEFT OUTER JOIN {$table_prefix}users AS us
							ON pb.created_by = us.id
						LEFT OUTER JOIN (SELECT DISTINCT(parent_id) AS 'parent_id', `version` AS 'version', COUNT(id) AS 'count_children' FROM {$table_prefix}posts_base WHERE current_flg = 1 AND delete_flg = 0 AND status = 1 AND parent_id <> 0 GROUP BY parent_id, version) AS pb2
							ON pb.id = pb2.parent_id AND pb.version = pb2.version
					WHERE
						pb.current_flg = 1
						AND pb.delete_flg = 0
						AND pb.parent_id = 0
						AND pb.site_id = :SITE_ID
						{$qsc_status}
            {$qsc_publish_datetime}
            {$qsc_publish_end_at}
						{$qsc_posttype_id}
						{$qsc_publish_year}
						{$qsc_publish_month}
						{$qsc_publish_day}
						{$qsc_date_from}
						{$qsc_date_to}
						{$qsc_category_id}
						{$qsc_tag_id}
						{$qsc_exclude_category_id}
						{$qsc_exclude_tag_id}
						{$qsc_anchor_equal}
						{$qsc_anchor_morethan}
						{$qsc_anchor_lessthan}
						{$qsc_created_by}
						{$qsc_grouped_by}
					ORDER BY {$query_orderby}
					{$query_limit}
			";
      $read_posts = $pdo -> prepare($sql);
      $read_posts -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
      foreach ($texts as $key => $value)
      {
        $read_posts -> bindValue(":TEXT{$key}", "%{$value}%", PDO::PARAM_STR);
      }
      $read_posts -> bindValue(':TITLE',       $title,       PDO::PARAM_STR);
      $read_posts -> bindValue(':ADDITION',    $addition,    PDO::PARAM_STR);
      $read_posts -> bindValue(':CONTENT',     $content,     PDO::PARAM_STR);
      $read_posts -> bindValue(':SITE_ID',     $site_id,     PDO::PARAM_INT);
      $read_posts -> execute();
      //return $read_posts->errorInfo();
      while ($record = $read_posts -> fetch(PDO::FETCH_ASSOC))
      {
        $posts['list'][$record['id']] = $record;
      }
      unset($read_posts);
    }
    catch(PDOException $e){
      var_dump($e->getMessage());
    }

    foreach ($posts['list'] as $post_id => $row)
    {
      // permalink
      if ($row['permalink_uri'] && $permalink_base)
      {
        $posts['list'][$post_id]['permalink'] = $permalink_base . $row['permalink_uri'];
      }

      // reset image-frame
      // eyecatch
      $posts['list'][$post_id]['eyecatch']['src']['x1'] = $row['eyecatch_raw'];
      $posts['list'][$post_id]['eyecatch']['src']['x2'] = str_replace('/1x/', '/2x/', $row['eyecatch_raw']);
      $uri_arr = explode('/', $row['eyecatch_raw']);
      $posts['list'][$post_id]['eyecatch']['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
      if (! empty($row['eyecatch_raw']) && ! empty($eyecatch_frame))
      {
        $posts['list'][$post_id]['eyecatch']['src']['x1'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $posts['list'][$post_id]['eyecatch']['src']['x1']);
        $posts['list'][$post_id]['eyecatch']['src']['x2'] = str_replace('/fr_admin/eyecatch/', '/' . $eyecatch_frame . '/', $posts['list'][$post_id]['eyecatch']['src']['x2']);
      }
      unset($posts['list'][$post_id]['eyecatch_raw']);

      // content
      if (! empty($row['content']) && ! empty($content_frame))
      {
        $posts['list'][$post_id]['content'] = str_replace('/fr_main/', '/' . $content_frame . '/', $row['content']);
      }

      // fix content
      if ($content_length > 0)
      {
        $line_feed_code = array("\r\n", "\r", "\n");
        $raw_content = preg_replace('/\s/', '', $row['content']);
        $raw_content = str_replace('&nbsp;', '', $row['content']);
        $raw_content = strip_tags($raw_content);
        $raw_content = str_replace($line_feed_code, '', $raw_content);
        $posts['list'][$post_id]['content'] = mb_substr($raw_content, 0, $content_length, 'UTF-8');
        if (mb_strlen($raw_content, 'UTF-8') > $content_length)
        {
          $posts['list'][$post_id]['content_cut_flg'] = 1;
        }
      }

      // add category detail
      $posts['list'][$post_id]['categories'] = array();
      if (! empty($row['category_id']))
      {
        $category_id_arr = explode(',', $row['category_id']);
        $categories = array();
        foreach($category_id_arr as $value)
        {
          $sql = "
							SELECT
								tb.id AS 'taxonomy_id',
								tb.parent_id AS 'parent_id',
								tb.slug AS 'slug',
								tl.label AS 'label',
								tb.line_order
							FROM {$table_prefix}taxonomies_base AS tb
								INNER JOIN {$table_prefix}taxonomies_label AS tl
									ON tb.id = tl.base_id
							WHERE tb.id = :CATEGORY_ID AND tl.language_id = :LANGUAGE_ID
					";
          $read_post_category = $pdo -> prepare($sql);
          $read_post_category -> bindValue(':CATEGORY_ID', intval($value), PDO::PARAM_INT);
          $read_post_category -> bindValue(':LANGUAGE_ID', $language_id,   PDO::PARAM_INT);
          $read_post_category -> execute();
          while ($record = $read_post_category -> fetch(PDO::FETCH_ASSOC))
          {
            $categories[$record['line_order']] = $record;
          }
        }
        unset($read_post_category);

        ksort($categories);
        $posts['list'][$post_id]['category_text'] = null;
        $i_categories = 1;
        foreach ($categories as $row_category)
        {
          $posts['list'][$post_id]['categories'][$i_categories] = $row_category;
          $posts['list'][$post_id]['category_text'] .= (empty($posts['list'][$post_id]['category_text'])) ? $row_category['label'] : ',' . $row_category['label'];
          $i_categories ++;
        }
      }

      // add tag detail
      $posts['list'][$post_id]['tags'] = array();
      if (! empty($row['tag_id']))
      {
        $tag_id_arr = explode(',', $row['tag_id']);
        $tags = array();
        foreach($tag_id_arr as $value)
        {
          $sql = "
							SELECT
								tb.id AS 'taxonomy_id',
								tb.slug AS 'slug',
								tl.label AS 'label',
								tb.line_order AS 'line_order'
							FROM {$table_prefix}taxonomies_base AS tb
								INNER JOIN {$table_prefix}taxonomies_label AS tl
									ON tb.id = tl.base_id
							WHERE tb.id = :TAG_ID AND tl.language_id = :LANGUAGE_ID
					";
          $read_post_tag = $pdo -> prepare($sql);
          $read_post_tag -> bindValue(':TAG_ID',      intval($value), PDO::PARAM_INT);
          $read_post_tag -> bindValue(':LANGUAGE_ID', $language_id,   PDO::PARAM_INT);
          $read_post_tag -> execute();
          while ($record = $read_post_tag -> fetch(PDO::FETCH_ASSOC))
          {
            $tags[$record['line_order']] = $record;
          }
        }
        unset($read_post_tag);

        ksort($tags);
        $posts['list'][$post_id]['tag_text'] = null;
        $i_tags = 1;
        foreach ($tags as $row_tag)
        {
          $posts['list'][$post_id]['tags'][$i_tags] = $row_tag;
          $posts['list'][$post_id]['tag_text'] .= (empty($posts['list'][$post_id]['tag_text'])) ? $row_tag['label'] : ',' . $row_tag['label'];
          $i_tags ++;
        }
      }
    }

    // add custom item
    if (! empty($posts) && $with_custom)
    {
      foreach ($posts['list'] as $post_id => $row)
      {
        try {
          $sql = "
							SELECT
								pc.language_id AS 'language_id',
								pc.custom_item_id AS 'custom_item_id',
								ci.slug AS 'column',
								ci.type AS 'type',
								ci.choices AS 'choices',
								pc.value AS 'value'
							FROM {$table_prefix}custom_items AS ci
								LEFT OUTER JOIN {$table_prefix}posts_custom AS pc
									ON ci.id = pc.custom_item_id
							WHERE
								ci.status = 1
								AND ci.delete_flg   = 0
								AND pc.base_id      = :BASE_ID
								AND pc.base_version = :BASE_VERSION
								AND pc.language_id  = :LANGUAGE_ID
					";
          $read_post_custom = $pdo -> prepare($sql);
          $read_post_custom -> bindValue(':BASE_ID',      $post_id,        PDO::PARAM_INT);
          $read_post_custom -> bindValue(':BASE_VERSION', $row['version'], PDO::PARAM_INT);
          $read_post_custom -> bindValue(':LANGUAGE_ID',  $language_id,    PDO::PARAM_INT);
          $read_post_custom -> execute();
          while ($record = $read_post_custom -> fetch(PDO::FETCH_ASSOC))
          {
            // reset image-frame
            // custom
            if ($record['type'] == 'image')
            {
              if (isset($custom_frame[$record['column']]))
              {
                $record['value'] = preg_replace('/\/fr_(auto|crop)\/[0-9]{2,3}\//', '/' . $custom_frame[$record['column']] . '/', $record['value']);
              }
              $x1 = $record['value'];
              $x2 = preg_replace('/\/1x\//', '/2x/', $x1);
              $key = 'custom_' . $record['column'];
              $posts['list'][$post_id][$key]['src']['x1'] = $x1;
              $posts['list'][$post_id][$key]['src']['x2'] = $x2;
              $uri_arr = explode('/', $record['value']);
              $posts['list'][$post_id][$key]['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
            }
            elseif ($record['type'] == 'gallery')
            {
              $urls     = array();
              $captions = array();
              if (preg_match('/\n/', $record['value']))
              {
                $record_arr = explode("\n", $record['value']);
                $urls     = $record_arr[0];
                $captions = $record_arr[1];
              }
              else {
                $urls = $record['value'];
              }
              $urls = make_list_data($urls, ',', false);
              $captions = make_list_data($captions, ',', false);
              $x_arr = array();
              foreach($urls as $key => $value)
              {
                $x1 = $value;
                $x2 = preg_replace('/\/1x\//', '/2x/', $x1);
                $x2_arr[$key] = $x2;
                $x_arr[$key]['src']['x1'] = $x1;
                $x_arr[$key]['src']['x2'] = $x2;
                $uri_arr = explode('/', $value);
                $x_arr[$key]['file_name'] = preg_replace('/\?v=\d*$/', '', end($uri_arr));
                $x_arr[$key]['caption'] = $captions[$key];
              }

              $key = 'custom_' . $record['column'];
              $posts['list'][$post_id][$key] = $x_arr;
            }
            else {
              // sanitize syntax
              if ($record['type'] == 'syntax')
              {
                $record['value'] = htmlspecialchars($record['value'], ENT_QUOTES);
              }

              // Shape list
              if ($record['type'] == 'list')
              {
                $record['value'] = make_list_data($record['value']);
              }

              // Shape table
              if ($record['type'] == 'table')
              {
                $delimiter = '';
                switch ($record['choices'])
                {
                  case 'comma'    : $delimiter = ','; break;
                  case 'semicolon': $delimiter = ';'; break;
                  case 'colon'    : $delimiter = ':'; break;
                  case 'slash'    : $delimiter = '/'; break;
                  case 'dot'      : $delimiter = '.'; break;
                }
                $record['value'] = make_table_data($record['value'], $delimiter);
              }

              $key = 'custom_' . $record['column'];
              $posts['list'][$post_id][$key] = $record['value'];
            }
          }
          unset($read_post_custom);
        }
        catch(PDOException $e)
        {
          var_dump($e->getMessage());
        }
      }
    }

    // add count comments
    if ($count_comments)
    {
      foreach ($posts['list'] as $post_id => $row)
      {
        $posts['list'][$post_id]['comments'] = array();
        $sql = "
						SELECT DISTINCT(type) AS type, COUNT(*) AS count
						FROM {$table_prefix}comments
						WHERE
							delete_flg = 0
							AND status = 1
							AND post_id = {$post_id}
							AND comment_id = 0
						GROUP BY type
				";
        $read_count_comment = $pdo -> prepare($sql);
        $read_count_comment -> execute();
        while ($record = $read_count_comment -> fetch(PDO::FETCH_ASSOC))
        {
          $posts['list'][$post_id]['comments'][$record['type']] = $record['count'];
        }
        unset($read_count_comment);
      }
    }

    // get counter
    if ($with_counter)
    {
      foreach ($posts['list'] as $post_id => $row)
      {
        try {
          $sql = "SELECT * FROM {$table_prefix}counters WHERE post_id = {$post_id} ORDER BY type ASC";
          $read_records = $pdo -> prepare($sql);
          $read_records -> execute();
          while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
          {
            $posts['list'][$post_id]['counter'][$record['type']]['count']      = $record['count'];
            $posts['list'][$post_id]['counter'][$record['type']]['updated_at'] = $record['updated_at'];
          }
          unset($read_records);
        }
        catch(PDOException $e)
        {
          var_dump($e->getMessage());
        }
      }
    }
  }
  // Reset key of list
  $posts['list'] = index_fromone($posts['list']);
  return $posts;
}


/**
 * Get Comment
 * @param number $id
 * @return array $comment | boolean(false)
 */
function get_comment($id)
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $id  = intval($id);

  if (! empty($id))
  {
    // make select items
    $qsi_post_datetime = ($database == 1) ? "SUBSTR(posted_at, 1, 16)" : "SUBSTRING(posted_at, 1, 16)";
    $qsi_post_date     = ($database == 1) ? "SUBSTR(posted_at, 1, 10)" : "SUBSTRING(posted_at, 1, 10)";

    $comment = array();
    try {
      // base
      $sql = "
					SELECT
						id AS 'id',
						posted_at AS 'post_datetime_original',
						{$qsi_post_datetime} AS 'post_datetime',
						{$qsi_post_date} AS 'post_date',
						post_id AS post_id,
						comment_id AS 'comment_id',
						parent_id AS 'parent_id',
						site_id AS 'site_id',
						posttype_id AS 'posttype_id',
						type AS 'type',
						score AS 'score',
						nickname AS 'nickname',
						email AS 'email',
						eyecatch AS 'eyecatch',
						title AS 'title',
						content AS 'content'
					FROM {$table_prefix}comments
					WHERE
						id = :ID
						AND delete_flg = 0
						AND status = 1
			";
      $read_comment = $pdo -> prepare($sql);
      $read_comment -> bindValue(':ID', $id, PDO::PARAM_INT);
      $read_comment -> execute();
      if ($record = $read_comment -> fetch(PDO::FETCH_ASSOC))
      {
        $comment = $record;
      }
      unset($read_post_base);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
    return $comment;
  }
  else {
    return false;
  }
}


/**
 * Get Comments
 * @param number $post_id
 * @param array  $config
 *  + @param[item] number  'type'
 *  + @param[item] number  'limit'
 *  + @param[item] number  'page'
 *  + @param[item] boolean 'orderby' (0:DESC 1:ASC)
 *  + @param[item] string  'dato_from'
 *  + @param[item] string  'date_to'
 *  + @param[item] boolean 'children' (0:no children 1:with children)
 *  + @param[item] boolean 'hierarchy' (0:no hierarchy 1:with hierarchy)
 * @return array $comments | boolean false
 */
function get_comments($post_id, $config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  if (intval($post_id))
  {
    // Set parameters
    $type      = (! empty($config['type']))      ? intval($config['type'])      : 1;
    $limit     = (! empty($config['limit']))     ? intval($config['limit'])     : 10;
    $page      = (! empty($config['page']))      ? intval($config['page'])      : 1;
    $orderby   = (isset($config['orderby']))     ? intval($config['orderby'])   : 1; // ASC first
    $date_from = (! empty($config['date_from'])) ? $config['date_from']         : null;
    $date_to   = (! empty($config['date_to']))   ? $config['date_to']           : null;
    $children  = (isset($config['children']))    ? intval($config['children'])  : 1;
    $hierarchy = (isset($config['hierarchy']))   ? intval($config['hierarchy']) : 1;

    // make values
    $date_from = (! empty($date_from)) ? date('Y-m-d', strtotime($date_from))       : null;
    $date_to   = (! empty($date_to))   ? date('Y-m-d', strtotime($date_to) + 86400) : null;
    $offset    = ($page - 1) * $limit;
    $orderby   = (empty($orderby)) ? 'DESC' : 'ASC';

    // make select items
    $qsi_post_datetime = ($database == 1) ? "SUBSTR(posted_at, 1, 16)" : "SUBSTRING(posted_at, 1, 16)";
    $qsi_post_date     = ($database == 1) ? "SUBSTR(posted_at, 1, 10)" : "SUBSTRING(posted_at, 1, 10)";

    // make additional search condition
    $qsc_date_from = ($date_from) ? "AND posted_at >= '{$date_from}'" : null;
    $qsc_date_to   = ($date_to)   ? "AND posted_at <  '{$date_to}'"   : null;

    // return value
    $comments = array('outline' => array(), 'list' => array());

    // Count Comments
    try {
      $sql = "
					SELECT COUNT(*) AS 'count'
					FROM {$table_prefix}comments
					WHERE
						post_id = {$post_id}
						AND type = {$type}
						AND delete_flg = 0
						AND status = 1
						AND comment_id = 0
						{$qsc_date_from}
						{$qsc_date_to}
			";
      $read_count = $pdo -> prepare($sql);
      $read_count -> execute();
      while ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
      {
        $comments['outline']['count_total'] = $record['count'];
        $pages = ceil($record['count'] / $limit);
        $comments['outline']['pages'] = $pages;
      }
      unset($read_count);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    // Fetch Comments
    try {
      // Parent
      $comments_parents = array();
      $parent_ids       = array();
      $sql_parents = "
					SELECT
						id AS 'id',
						posted_at AS 'post_datetime_original',
						{$qsi_post_datetime} AS 'post_datetime',
						{$qsi_post_date} AS 'post_date',
						post_id AS 'post_id',
						comment_id AS 'comment_id',
						parent_id AS 'parent_id',
						site_id AS 'site_id',
						posttype_id AS 'posttype_id',
						type AS 'type',
						score AS 'score',
						nickname AS 'nickname',
						email AS 'email',
						eyecatch AS 'eyecatch',
						title AS 'title',
						content AS 'content',
						ip_address AS 'ip_address',
						note AS 'note'
					FROM {$table_prefix}comments
					WHERE
						post_id = {$post_id}
						AND type = {$type}
						AND delete_flg = 0
						AND status = 1
						AND comment_id = 0
						{$qsc_date_from}
						{$qsc_date_to}
					ORDER BY posted_at {$orderby}, id {$orderby}
					LIMIT {$limit} OFFSET {$offset}
			";
      $read_comments = $pdo -> prepare($sql_parents);
      $read_comments -> execute();
      while ($record = $read_comments -> fetch(PDO::FETCH_ASSOC))
      {
        $comments_parents[$record['id']] = $record;
        $parent_ids[] = $record['id'];
      }
      unset($read_comments);

      // Children
      $comments_children = array();
      if ($children && ! empty($parent_ids))
      {
        $parent_ids = (! empty($parent_ids)) ? implode(',', $parent_ids) : 0;
        $sql_children = "
						SELECT
							id AS 'id',
							posted_at AS 'post_datetime_original',
							{$qsi_post_datetime} AS 'post_datetime',
							{$qsi_post_date} AS 'post_date',
							post_id AS 'post_id',
							comment_id AS 'comment_id',
							parent_id AS 'parent_id',
							site_id AS 'site_id',
							posttype_id AS 'posttype_id',
							type AS 'type',
							score AS 'score',
							nickname AS 'nickname',
							email AS 'email',
							eyecatch AS 'eyecatch',
							title AS 'title',
							content AS 'content',
							ip_address AS 'ip_address',
							note AS 'note'
							FROM {$table_prefix}comments
						WHERE
							delete_flg = 0
							AND status = 1
							AND comment_id IN({$parent_ids})
						ORDER BY parent_id DESC, posted_at {$orderby}, id {$orderby}
				";
        $read_comments = $pdo -> prepare($sql_children);
        $read_comments -> execute();
        while ($record = $read_comments -> fetch(PDO::FETCH_ASSOC))
        {
          $comments_children[$record['id']] = $record;
        }
        unset($read_comments);
      }

      $comments['list'] = $comments_children + $comments_parents;
      $comments_fixed   = $comments;
      if ($hierarchy)
      {
        foreach ($comments['list'] as $key => $row)
        {
          if (array_key_exists($row['parent_id'], $comments['list']))
          {
            $comments_fixed['list'][$row['parent_id']]['children'][$key] = $comments_fixed['list'][$key];
            unset($comments_fixed['list'][$key]);
          }
        }
      }
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
    $comments_fixed['list'] = index_fromone($comments_fixed['list']);
    $comments_fixed['list'] = index_fromone_recursive($comments_fixed['list']);
    return $comments_fixed;
  }
  return false;
}


/**
 * Get Archives(date and count)
 * [@param  array $config]
 *  + @param[item]  string 'site'
 *  + @param[item]  number 'site_id' ('0' means abandoning to fetch)
 *  + @param[item]  string 'posttype'
 *  + @param[item]  number 'posttype_id' ('0' means abandoning to fetch, string like '1,2' is also available)
 *  + @param[item]  string 'date_from'
 *  + @param[item]  string 'date_to'
 * @return array $archives
 */
function get_archives($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $site                 = (! empty($config['site']))                 ? $config['site']                 : null;
  $site_id              = (isset($config['site_id']))                ? intval($config['site_id'])      : 1;
  $posttype             = (! empty($config['posttype']))             ? $config['posttype']             : null;
  $posttype_id          = (isset($config['posttype_id']))            ? $config['posttype_id']          : 1;
  $category             = (! empty($config['category']))             ? $config['category']             : null;
  $category_id          = (! empty($config['category_id']))          ? $config['category_id']          : null;
  $tag                  = (! empty($config['tag']))                  ? $config['tag']                  : null;
  $tag_id               = (! empty($config['tag_id']))               ? $config['tag_id']               : null;
  $exclude_category     = (! empty($config['exclude_category']))     ? $config['exclude_category']     : null;
  $exclude_category_id  = (! empty($config['exclude_category_id']))  ? $config['exclude_category_id']  : null;
  $exclude_tag          = (! empty($config['exclude_tag']))          ? $config['exclude_tag']          : null;
  $exclude_tag_id       = (! empty($config['exclude_tag_id']))       ? $config['exclude_tag_id']       : null;
  $date_from            = (! empty($config['date_from']))            ? $config['date_from']            : null;
  $date_to              = (! empty($config['date_to']))              ? $config['date_to']              : null;
  $orderby              = (isset($config['orderby']))                ? $config['orderby']              : 0; // DESC first
  $unit                 = (! empty($config['unit']))                 ? $config['unit']                 : null;
  $preview              = (isset($config['preview']))                ? intval($config['preview'])      : 0;

  // Get site_id from slug
  if ($site)
  {
    $site_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Shape Category
  $category_ids = array();

  // Shape category_id to array
  if ($category_id)
  {
    if (! is_array($category_id))
    {
      $category_id_arr = array_map('intval', array_map('trim', explode(',', $category_id)));
      foreach ($category_id_arr as $category_id)
      {
        $category_ids[] = sprintf('%04d', $category_id);
      }
    }
  }

  // Get category_id from slug
  if ($category)
  {
    if (! is_array($category))
    {
      $category_arr = array_map('trim', explode(',', $category));
    }
    else {
      $category_arr = $category;
    }
    foreach ($category_arr as $category)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 1 AND posttype_id = {$posttype_id} AND slug = '{$category}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $category_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }


  // Shape Tag
  $tag_ids = array();

  // Shape tag_id to array
  if ($tag_id)
  {
    if (! is_array($tag_id))
    {
      $tag_id_arr = array_map('intval', array_map('trim', explode(',', $tag_id)));
      foreach ($tag_id_arr as $tag_id)
      {
        $tag_ids[] = sprintf('%04d', $tag_id);
      }
    }
  }

  // Get tag_id from slug
  if ($tag)
  {
    if (! is_array($tag))
    {
      $tag_arr = array_map('trim', explode(',', $tag));
    }
    else {
      $tag_arr = $tag;
    }
    foreach ($tag_arr as $tag)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 2 AND posttype_id = {$posttype_id} AND slug = '{$tag}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $tag_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }

  // Shape Exclude Category
  $exclude_category_ids = array();

  // Shape Exclude_category_id to array
  if ($exclude_category_id)
  {
    if (! is_array($exclude_category_id))
    {
      $exclude_category_id_arr = array_map('intval', array_map('trim', explode(',', $exclude_category_id)));
      foreach ($exclude_category_id_arr as $exclude_category_id)
      {
        $exclude_category_ids[] = sprintf('%04d', $exclude_category_id);
      }
    }
  }

  // Get category_id from slug
  if ($exclude_category)
  {
    if (! is_array($exclude_category))
    {
      $exclude_category_arr = array_map('trim', explode(',', $exclude_category));
    }
    else {
      $exclude_category_arr = $exclude_category;
    }
    foreach ($exclude_category_arr as $exclude_category)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 1 AND posttype_id = {$posttype_id} AND slug = '{$exclude_category}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $exclude_category_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }


  // Shape Exclude Tag
  $exclude_tag_ids = array();

  // Shape tag_id to array
  if ($exclude_tag_id)
  {
    if (! is_array($exclude_tag_id))
    {
      $exclude_tag_id_arr = array_map('intval', array_map('trim', explode(',', $exclude_tag_id)));
      foreach ($exclude_tag_id_arr as $exclude_tag_id)
      {
        $exclude_tag_ids[] = sprintf('%04d', $exclude_tag_id);
      }
    }
  }

  // Get tag_id from slug
  if ($exclude_tag)
  {
    if (! is_array($exclude_tag))
    {
      $exclude_tag_arr = array_map('trim', explode(',', $exclude_tag));
    }
    else {
      $exclude_tag_arr = $exclude_tag;
    }
    foreach ($exclude_tag_arr as $exclude_tag)
    {
      $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 2 AND posttype_id = {$posttype_id} AND slug = '{$exclude_tag}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $exclude_tag_ids[] = sprintf('%04d', $record['id']);
      }
    }
    unset($read_records);
  }

  // Format orderby
  if ($orderby)
  {
    if (strtoupper($orderby) === 'ASC')
    {
      $orderby = 1;
    }
    elseif (strtoupper($orderby) === 'DESC')
    {
      $orderby = 0;
    }
    elseif (intval($orderby) > 0) {
      $orderby = 1;
    }
    else {
      $orderby = 0;
    }
  }

  // Fix posttype_id
  $qsc_posttype_id = null;
  if (! is_numeric($posttype_id) && strpos($posttype_id, ',') !== false)
  {
    $posttype_ids = explode(',', $posttype_id);
    foreach ($posttype_ids as $key => $value)
    {
      $posttype_ids[$key] = intval($value);
    }
    $posttype_id = implode(',', $posttype_ids);
    $qsc_posttype_id = "AND posttype_id IN ({$posttype_id})";
  }
  elseif (is_numeric($posttype_id))
  {
    $posttype_id = intval($posttype_id);
    $qsc_posttype_id = "AND posttype_id = {$posttype_id}";
  }

  // make values
  $date_from = (! empty($date_from)) ? date('Y-m-d H:i:s', strtotime($date_from)) : null;
  $date_to   = (! empty($date_to))   ? date('Y-m-d H:i:s', strtotime($date_to))   : date('Y-m-d H:i:s');

  // make arranged item
  $qsi_publish_year  = ($database == 1) ? "STRFTIME('%Y', publish_datetime)" : "YEAR(publish_datetime)";
  $qsi_publish_month = ($database == 1) ? "SUBSTR('0'||STRFTIME('%m', publish_datetime), -2, 2)" : "LPAD(MONTH(publish_datetime), 2, 0)";
  $qsi_publish_day   = ($database == 1) ? "SUBSTR('0'||STRFTIME('%d', publish_datetime), -2, 2)" : "LPAD(DAY(publish_datetime), 2, 0)";

  // make search condition
  $qsc_category_id = null;
  if (count($category_ids))
  {
    $qsc_category_id = 'AND (';
    foreach ($category_ids as $key => $category_id)
    {
      if ($key > 0) $qsc_category_id .= ' OR ';
      $qsc_category_id .= "category_id LIKE '%{$category_id}%'";
    }
    $qsc_category_id .= ')';
  }
  $qsc_tag_id = null;
  if (count($tag_ids))
  {
    $qsc_tag_id = 'AND (';
    foreach ($tag_ids as $key => $tag_id)
    {
      if ($key > 0) $qsc_tag_id .= ' OR ';
      $qsc_tag_id .= "tag_id LIKE '%{$tag_id}%'";
    }
    $qsc_tag_id .= ')';
  }
  $qsc_exclude_category_id = null;
  if (count($exclude_category_ids))
  {
    $qsc_exclude_category_id = 'AND (';
    foreach ($exclude_category_ids as $key => $exclude_category_id)
    {
      if ($key > 0) $qsc_exclude_category_id .= ' AND ';
      $qsc_exclude_category_id .= "category_id NOT LIKE '%{$exclude_category_id}%'";
    }
    $qsc_exclude_category_id .= ')';
  }
  $qsc_exclude_tag_id = null;
  if (count($exclude_tag_ids))
  {
    $qsc_exclude_tag_id = 'AND (';
    foreach ($exclude_tag_ids as $key => $exclude_tag_id)
    {
      if ($key > 0) $qsc_exclude_tag_id .= ' AND ';
      $qsc_exclude_tag_id .= "tag_id NOT LIKE '%{$exclude_tag_id}%'";
    }
    $qsc_exclude_tag_id .= ')';
  }
  $qsc_date_from = (! empty($date_from)) ? "AND publish_datetime >= '{$date_from}'"  : null;
  $qsc_date_to   = (! empty($date_to))   ? "AND publish_datetime <= '{$date_to}'"    : null;
  $orderby       = (empty($orderby))     ? 'DESC' : 'ASC';

  $now = date('Y-m-d H:i:s');
  $qsc_status           = (! $preview)  ? "AND status = 1" : "AND status <= 2";
  $qsc_publish_datetime = (! $preview)  ? "AND publish_datetime <= '{$now}'" : null;
  $qsc_publish_end_at   = (! $preview)  ? "AND (publish_end_at > '{$now}' OR publish_end_at IS NULL)" : null;

  $archives = array();
  try {
    $sql = "
				SELECT
					COUNT(publish_datetime) AS 'count',
					{$qsi_publish_year} AS 'year',
					{$qsi_publish_month} AS 'month',
					{$qsi_publish_day} AS 'day',
					DATE(publish_datetime) AS 'date'
				FROM {$table_prefix}posts_base
				WHERE
					current_flg = 1
					AND delete_flg = 0
					{$qsc_status}
					{$qsc_publish_datetime}
					{$qsc_publish_end_at}
					AND parent_id = 0
					AND site_id = :SITE_ID
					{$qsc_posttype_id}
					{$qsc_category_id}
					{$qsc_tag_id}
					{$qsc_exclude_category_id}
					{$qsc_exclude_tag_id}
					{$qsc_date_from}
					{$qsc_date_to}
				GROUP BY year, month, day, date
				ORDER BY publish_datetime {$orderby}
		";
    $read_archives = $pdo -> prepare($sql);
    $read_archives -> bindValue(':SITE_ID', $site_id, PDO::PARAM_INT);
    $read_archives -> execute();
    while ($record = $read_archives -> fetch(PDO::FETCH_ASSOC))
    {
      $this_year  = sprintf('%04d', $record['year']);
      $this_month = sprintf('%02d', $record['month']);
      $this_day   = sprintf('%02d', $record['day']);
      if (! isset($archives[$this_year]['count']))
      {
        $archives[$this_year]['date_label'] = $record['year'];
        $archives[$this_year]['year']       = $record['year'];
        $archives[$this_year]['count']      = $record['count'];
      }
      else {
        $archives[$this_year]['count'] += $record['count'];
      }
      if (! isset($archives[$this_year]['months'][$this_month]['count']))
      {
        $archives[$this_year]['months'][$this_month]['date_label'] = $record['year'] . '-' . $record['month'];
        $archives[$this_year]['months'][$this_month]['year']       = $record['year'];
        $archives[$this_year]['months'][$this_month]['month']      = $record['month'];
        $archives[$this_year]['months'][$this_month]['count']      = $record['count'];
      }
      else {
        $archives[$this_year]['months'][$this_month]['count'] += $record['count'];
      }
      $archives[$this_year]['months'][$this_month]['days'][$this_day]['date_label'] = $record['date'];
      $archives[$this_year]['months'][$this_month]['days'][$this_day]['year']       = $record['year'];
      $archives[$this_year]['months'][$this_month]['days'][$this_day]['month']      = $record['month'];
      $archives[$this_year]['months'][$this_month]['days'][$this_day]['day']        = $record['day'];
      $archives[$this_year]['months'][$this_month]['days'][$this_day]['count']      = $record['count'];
    }
    unset($read_archives);
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }

  // Format
  if (! empty($archives) && ! empty($unit))
  {
    $archives_formatted = array();
    if ($unit == 'month')
    {
      foreach ($archives as $year => $years)
      {
        foreach ($years['months'] as $month => $months)
        {
          $key = $year . '-' . $month;
          $archives_formatted[$key] = $months;
        }
      }
      return $archives_formatted;
    }
    if ($unit == 'day')
    {
      foreach ($archives as $year => $years)
      {
        foreach ($years['months'] as $month => $months)
        {
          foreach ($months['days'] as $day => $days)
          {
            $key = $year . '-' . $month . '-' . $day;
            $archives_formatted[$key] = $days;
          }
        }
      }
      return $archives_formatted;
    }
  }

  return $archives;
}


/**
 * Get Categories
 * [@param  array  $config]
 *  + @param[item]  string  'site' (slug)
 *  + @param[item]  number  'site_id' ('0' means abandoning to fetch)
 *  + @param[item]  string  'posttype' (slug)
 *  + @param[item]  number  'posttype_id' ('0' means abandoning to fetch, string like '1,2' is also available)
 *  + @param[item]  string  'language' (slug)
 *  + @param[item]  number  'language_id' ('0' means abandoning to fetch)
 *  + @param[item]  number  'parent' (slug)
 *  + @param[item]  number  'parent_id' ('0' has meaning, so default is null)
 *  + @param[item]  boolean 'with_count' (0: don't fetch count / 1: fetch count)
 *  + @param[item]  boolean 'in_use' (0: every records / 1: in use only)
 * @return array $categories
 */
function get_categories($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $site         = (! empty($config['site']))      ? $config['site']                : null;
  $site_id      = (isset($config['site_id']))     ? intval($config['site_id'])     : 1;
  $posttype     = (! empty($config['posttype']))  ? $config['posttype']            : null;
  $posttype_id  = (isset($config['posttype_id'])) ? $config['posttype_id']         : 1;
  $language     = (! empty($config['language']))  ? $config['language']            : null;
  $language_id  = (isset($config['language_id'])) ? intval($config['language_id']) : 1;
  $parent       = (! empty($config['parent']))    ? $config['parent']              : null;
  $parent_id    = (isset($config['parent_id']))   ? intval($config['parent_id'])   : null;
  $with_count   = (isset($config['with_count']))  ? intval($config['with_count'])  : 1;
  $preview      = (isset($config['preview']))     ? intval($config['preview'])     : 0;
  $in_use       = (isset($config['in_use']))      ? intval($config['in_use'])      : 1;
  $key_by       = (! empty($config['key_by']))    ? $config['key_by']              : null;

  // Get site_id from slug
  if ($site)
  {
    $site_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get language_id from slug
  if ($language)
  {
    $language_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $language_id = intval($record['id']);
    }
    unset($read_records);
  }

  // get parent_id from slug
  if ($parent)
  {
    $sql = "SELECT id FROM {$table_prefix}taxonomies_base WHERE delete_flg = 0 AND status = 1 AND classification = 1 AND slug = '{$parent}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $parent_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Fix posttype_id
  $qsc_posttype_id      = null;
  $qsc_posttype_id_post = null;
  if (! is_numeric($posttype_id) && strpos($posttype_id, ',') !== false)
  {
    $posttype_ids = explode(',', $posttype_id);
    foreach ($posttype_ids as $key => $value)
    {
      $posttype_ids[$key] = intval($value);
    }
    $posttype_id = implode(',', $posttype_ids);
    $qsc_posttype_id = "AND tb.posttype_id IN ({$posttype_id})";
    $qsc_posttype_id_post = "AND posttype_id IN ({$posttype_id})";

  }
  elseif (is_numeric($posttype_id))
  {
    $posttype_id = intval($posttype_id);
    $qsc_posttype_id = "AND tb.posttype_id = {$posttype_id}";
    $qsc_posttype_id_post = "AND posttype_id = {$posttype_id}";
  }

  // make extra search condition
  $qsc_parent_id = ($parent_id !== null && is_int($parent_id)) ? "AND tb.parent_id = {$parent_id}" : null;

  $categories = array();
  try {
    $sql = "
				SELECT
					tb.id AS 'id',
					tb.parent_id AS 'parent_id',
					tb.slug AS 'slug',
					tl.label AS 'label',
					cv.cover_image
				FROM {$table_prefix}taxonomies_base AS tb
					LEFT OUTER JOIN {$table_prefix}taxonomies_label AS tl
						ON tb.id = tl.base_id
					LEFT OUTER JOIN (SELECT * FROM {$table_prefix}covers WHERE entity_code = 4) AS cv
						ON tb.id = cv.entity_id
				WHERE
					tb.delete_flg = 0
					AND tb.status = 1
					AND tb.classification = 1
					AND tl.language_id = :LANGUAGE_ID
					{$qsc_posttype_id}
					{$qsc_parent_id}
				ORDER BY tb.parent_id ASC, tb.line_order ASC
		";
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }
  $read_categories = $pdo -> prepare($sql);
  $read_categories -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
  $read_categories -> execute();
  while ($record = $read_categories -> fetch(PDO::FETCH_ASSOC))
  {
    if ($record['parent_id'] == 0 || $parent_id !== null)
    {
      $categories[$record['id']] = $record;
    }
    else {
      $categories[$record['parent_id']]['children'][$record['id']] = $record;
    }
  }

  if ($with_count || $in_use)
  {
    foreach ($categories as $parent_id => $parent)
    {
      $now = date('Y-m-d H:i:s');
      $qsc_status           = (! $preview)  ? "AND status = 1" : "AND status <= 2";
      $qsc_publish_datetime = (! $preview)  ? "AND publish_datetime <= '{$now}'" : null;
      $qsc_publish_end_at   = (! $preview)  ? "AND (publish_end_at > '{$now}' OR publish_end_at IS NULL)" : null;
      $category_id_text = sprintf('%04d', $parent_id);
      try {
        $now = date('Y-m-d H:i:s');
        $sql = "
						SELECT COUNT(*) AS count
						FROM {$table_prefix}posts_base
						WHERE
							current_flg = 1
							AND parent_id = 0
							AND delete_flg = 0
							{$qsc_status}
							{$qsc_publish_datetime}
							{$qsc_publish_end_at}
							AND site_id = {$site_id}
							AND category_id LIKE '%{$category_id_text}%'
							{$qsc_posttype_id_post}
				";
        $read_count = $pdo -> prepare($sql);
        $read_count -> execute();
        if ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
        {
          if ($with_count) $categories[$parent_id]['count'] = $record['count'];
          if ($in_use && $record['count'] == 0)
          {
            unset($categories[$parent_id]);
          }
          else {
            if (! empty($parent['children']))
            {
              foreach ($parent['children'] as $child_id => $child)
              {
                $category_id_text = sprintf('%04d', $child_id);

                $sql = "
										SELECT COUNT(*) AS count
										FROM {$table_prefix}posts_base
										WHERE
											current_flg = 1
											AND parent_id = 0
											AND delete_flg = 0
											{$qsc_status}
											{$qsc_publish_datetime}
											AND site_id = {$site_id}
											AND category_id LIKE '%{$category_id_text}%'
											{$qsc_posttype_id_post}
								";
                $read_count = $pdo -> prepare($sql);
                $read_count -> execute();
                if ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
                {
                  if ($with_count) $categories[$parent_id]['children'][$child_id]['count'] = $record['count'];
                  if ($in_use && $record['count'] == 0)
                  {
                    unset($categories[$parent_id]['children'][$child_id]);
                  }
                }
              }
            }
          }
        }
      }
      catch(PDOException $e)
      {
        var_dump($e->getMessage());
      }
    }
  }

  // Fix Array Style
  $categories_fixed = array();
  if (! empty($key_by))
  {
    if ($key_by == 'id')
    {
      foreach($categories as $row)
      {
        if (! empty($row['children']))
        {
          $children_fixed = array();
          foreach($row['children'] as $child)
          {
            $children_fixed[$child['id']] = $child;
          }
          $row['children'] = $children_fixed;
        }
        $categories_fixed[$row['id']] = $row;

      }
    }
    elseif ($key_by == 'label')
    {
      foreach($categories as $row)
      {
        if (! empty($row['children']))
        {
          $children_fixed = array();
          foreach($row['children'] as $child)
          {
            $children_fixed[$child['label']] = $child;
          }
          $row['children'] = $children_fixed;
        }
        $categories_fixed[$row['label']] = $row;
      }
    }
    elseif ($key_by == 'number')
    {
      $categories_fixed = index_fromone($categories);
      $categories_fixed = index_fromone_recursive($categories_fixed);
    }
    else {
      foreach($categories as $row)
      {
        if (! empty($row['children']))
        {
          $children_fixed = array();
          foreach($row['children'] as $child)
          {
            $children_fixed[$child['slug']] = $child;
          }
          $row['children'] = $children_fixed;
        }
        $categories_fixed[$row['slug']] = $row;
      }
    }
  }
  else {
    foreach($categories as $row)
    {
      if (! empty($row['children']))
      {
        $children_fixed = array();
        foreach($row['children'] as $child)
        {
          $children_fixed[$child['slug']] = $child;
        }
        $row['children'] = $children_fixed;
      }
      $categories_fixed[$row['slug']] = $row;
    }
  }

  return $categories_fixed;
}


/**
 * Get Tags
 * [@param  array  $config]
 *  + @param[item]  string  'site' (slug)
 *  + @param[item]  number  'site_id' ('0' means abandoning to fetch)
 *  + @param[item]  string  'posttype'
 *  + @param[item]  number  'posttype_id' ('0' means abandoning to fetch, string like '1,2' is also available)
 *  + @param[item]  string  'language'
 *  + @param[item]  number  'language_id' ('0' means abandoning to fetch)
 *  + @param[item]  boolean 'with_count' (0: don't fetch count / 1: fetch count)
 *  + @param[item]  boolean 'in_use' (0: every records / 1: in use only)
 * @return array $categories
 */
function get_tags($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $site        = (! empty($config['site']))      ? $config['site']                : null;
  $site_id     = (isset($config['site_id']))     ? intval($config['site_id'])     : 1;
  $posttype    = (! empty($config['posttype']))  ? $config['posttype']            : null;
  $posttype_id = (isset($config['posttype_id'])) ? $config['posttype_id']         : 1;
  $language    = (! empty($config['language']))  ? $config['language']            : null;
  $language_id = (isset($config['language_id'])) ? intval($config['language_id']) : 1;
  $with_count  = (isset($config['with_count']))  ? intval($config['with_count'])  : 1;
  $preview     = (isset($config['preview']))     ? intval($config['preview'])     : 0;
  $in_use      = (isset($config['in_use']))      ? intval($config['in_use'])      : 1;
  $key_by      = (! empty($config['key_by']))    ? $config['key_by']              : null;

  // Get site_id from slug
  if ($site)
  {
    $site_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get language_id from slug
  if ($language)
  {
    $language_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $language_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Fix posttype_id
  $qsc_posttype_id      = null;
  $qsc_posttype_id_post = null;
  if (! is_numeric($posttype_id) && strpos($posttype_id, ',') !== false)
  {
    $posttype_ids = explode(',', $posttype_id);
    foreach ($posttype_ids as $key => $value)
    {
      $posttype_ids[$key] = intval($value);
    }
    $posttype_id = implode(',', $posttype_ids);
    $qsc_posttype_id      = "AND tb.posttype_id IN ({$posttype_id})";
    $qsc_posttype_id_post = "AND posttype_id IN ({$posttype_id})";

  }
  elseif (is_numeric($posttype_id))
  {
    $posttype_id = intval($posttype_id);
    $qsc_posttype_id      = "AND tb.posttype_id = {$posttype_id}";
    $qsc_posttype_id_post = "AND posttype_id = {$posttype_id}";
  }

  $tags = array();
  try {
    $sql = "
				SELECT
					tb.id AS 'id',
					tb.slug AS 'slug',
					tl.label AS 'label',
					cv.cover_image
				FROM {$table_prefix}taxonomies_base AS tb
					LEFT OUTER JOIN {$table_prefix}taxonomies_label AS tl
						ON tb.id = tl.base_id
					LEFT OUTER JOIN (SELECT * FROM {$table_prefix}covers WHERE entity_code = 5) AS cv
						ON tb.id = cv.entity_id
				WHERE
					tb.delete_flg = 0
					AND tb.status = 1
					AND tb.classification = 2
					AND tl.language_id = :LANGUAGE_ID
					{$qsc_posttype_id}
				ORDER BY tb.parent_id ASC, tb.line_order ASC
		";
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }
  $read_tags = $pdo -> prepare($sql);
  $read_tags -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
  $read_tags -> execute();
  while ($record = $read_tags -> fetch(PDO::FETCH_ASSOC))
  {
    $tags[] = $record;
  }

  if ($with_count || $in_use)
  {
    foreach ($tags as $tag_id => $parent)
    {
      $now = date('Y-m-d H:i:s');
      $qsc_status           = (! $preview)  ? "AND status = 1" : "AND status <= 2";
      $qsc_publish_datetime = (! $preview)  ? "AND publish_datetime <= '{$now}'" : null;
      $qsc_publish_end_at   = (! $preview)  ? "AND (publish_end_at > '{$now}' OR publish_end_at IS NULL)" : null;
      $tag_id_text = sprintf('%04d', $tag_id);
      $sql = "
					SELECT COUNT(*) AS count
					FROM {$table_prefix}posts_base
					WHERE
						current_flg = 1
						AND parent_id = 0
						AND delete_flg = 0
						{$qsc_status}
						{$qsc_publish_datetime}
						{$qsc_publish_end_at}
						AND site_id = {$site_id}
						AND tag_id LIKE '%{$tag_id_text}%'
						{$qsc_posttype_id_post}
			";
      $read_count = $pdo -> prepare($sql);
      $read_count -> execute();
      if ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
      {
        if ($with_count) $tags[$tag_id]['count'] = $record['count'];
        if ($in_use && $record['count'] == 0)
        {
          unset($tags[$tag_id]);
        }
      }
    }
  }

  // Fix Array Style
  $tags_fixed = array();
  if (! empty($key_by))
  {
    if ($key_by == 'id')
    {
      foreach($tags as $row)
      {
        $tags_fixed[$row['id']] = $row;
      }
    }
    elseif ($key_by == 'label')
    {
      foreach($tags as $row)
      {
        $tags_fixed[$row['label']] = $row;
      }
    }
    elseif ($key_by == 'number')
    {
      $tags_fixed = index_fromone($tags);
    }
    else {
      foreach($tags as $row)
      {
        $tags_fixed[$row['slug']] = $row;
      }
    }
  }
  else {
    foreach($tags as $row)
    {
      $tags_fixed[$row['slug']] = $row;
    }
  }
  
  return $tags_fixed;
}


/**
 * Get Sites
 * @return array $sites
 */
function get_sites($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $key_by = (! empty($config['key_by'])) ? $config['key_by'] : null;

  $sites = array();
  try {
    $sql = "
				SELECT
					st.id AS 'id',
					st.name AS 'label',
					st.slug AS 'slug',
					cv.cover_image
				FROM {$table_prefix}sites AS st
					LEFT OUTER JOIN (SELECT * FROM {$table_prefix}covers WHERE entity_code = 1) AS cv
						ON st.id = cv.entity_id
				WHERE
					st.delete_flg = 0
					AND st.status = 1
				ORDER BY st.line_order ASC
		";
    $read_sites = $pdo -> prepare($sql);
    $read_sites -> execute();
    while ($record = $read_sites -> fetch(PDO::FETCH_ASSOC))
    {
      $sites[] = $record;
    }
    unset($read_sites);
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }

  // Fix Array Style
  $sites_fixed = array();
  if (! empty($key_by))
  {
    if ($key_by == 'id')
    {
      foreach($sites as $row)
      {
        $sites_fixed[$row['id']] = $row;
      }
    }
    elseif ($key_by == 'label')
    {
      foreach($sites as $row)
      {
        $sites_fixed[$row['label']] = $row;
      }
    }
    elseif ($key_by == 'number')
    {
      $sites_fixed = index_fromone($sites);
    }
    else {
      foreach($sites as $row)
      {
        $sites_fixed[$row['slug']] = $row;
      }
    }
  }
  else {
    foreach($sites as $row)
    {
      $sites_fixed[$row['slug']] = $row;
    }
  }
  
  return $sites_fixed;
}



/**
 * Get Posttypes
 * [@param  array  $config]
 *  + @param[item]  string 'site'
 *  + @param[item]  number 'site_id' ('0' means abandoning to fetch)
 * @return array $posttypes
 */
function get_posttypes($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $site    = (! empty($config['site']))   ? $config['site']            : null;
  $site_id = (isset($config['site_id']))  ? intval($config['site_id']) : 1;
  $key_by  = (! empty($config['key_by'])) ? $config['key_by']          : null;

  // Get site_id from slug
  if ($site)
  {
    $site_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id = intval($record['id']);
    }
    unset($read_records);
  }

  $posttypes = array();
  if ($site_id > 0)
  {
    // Shape parameters
    $site_id = sprintf('%04d', $site_id);

    // Fetch posttypes
    try {
      $sql = "
					SELECT
						pt.id AS 'id',
						pt.name AS 'label',
						pt.slug AS 'slug',
						cv.cover_image
					FROM {$table_prefix}posttypes AS pt
						LEFT OUTER JOIN (SELECT * FROM {$table_prefix}covers WHERE entity_code = 2) AS cv
							ON pt.id = cv.entity_id
					WHERE
						pt.delete_flg = 0
						AND pt.status = 1
						AND pt.id < 1000
						AND pt.site_id like '%{$site_id}%'
					ORDER BY pt.line_order ASC
			";
      $read_posttypes = $pdo -> prepare($sql);
      $read_posttypes -> execute();
      while ($record = $read_posttypes -> fetch(PDO::FETCH_ASSOC))
      {;
        $posttypes[$record['id']] = $record;
      }
      unset($read_posttypes);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    // Fix Array Style
    $posttypes_fixed = array();
    if (! empty($key_by))
    {
      if ($key_by == 'id')
      {
        foreach($posttypes as $row)
        {
          $posttypes_fixed[$row['id']] = $row;
        }
      }
      elseif ($key_by == 'label')
      {
        foreach($posttypes as $row)
        {
          $posttypes_fixed[$row['label']] = $row;
        }
      }
      elseif ($key_by == 'number')
      {
        $posttypes_fixed = index_fromone($posttypes);
      }
      else {
        foreach($posttypes as $row)
        {
          $posttypes_fixed[$row['slug']] = $row;
        }
      }
    }
    else {
      foreach($posttypes as $row)
      {
        $posttypes_fixed[$row['slug']] = $row;
      }
    }
  }

  return $posttypes_fixed;
}


/**
 * Get Languages
 * [@param  array $config]
 *  + @param[item]  string 'posttype'
 *  + @param[item]  number 'posttype_id' ('0' means abandoning to fetch)
 * @return array $languages | boolean (false)
 */
function get_languages($config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $posttype    = (! empty($config['posttype']))  ? $config['posttype']            : null;
  $posttype_id = (isset($config['posttype_id'])) ? intval($config['posttype_id']) : 1;
  $key_by      = (! empty($config['key_by']))    ? $config['key_by']              : null;

  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Set search condition target ID
  $qsc_target_id = null;
  if ($posttype_id > 0)
  {
    // Fetch target ID
    $language_id = null;
    try {
      $sql = "SELECT language_id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND id = :ID";
      $read_records = $pdo -> prepare($sql);
      $read_records -> bindValue(':ID', $posttype_id, PDO::PARAM_INT);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $language_id = $record['language_id'];
      }
      unset($read_records);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    // Shape target ID
    $language_id_arr = explode(',', $language_id);
    foreach ($language_id_arr as $key => $value)
    {
      $language_id_arr[$key] = intval($value);
    }
    $target_id = implode(',', $language_id_arr);
    $qsc_target_id = "AND lg.id IN ({$target_id})";
  }

  // Fetch languages
  $languages = array();
  try {
    $sql = "
				SELECT
					lg.id AS 'id',
					lg.name AS 'label',
					lg.slug AS 'slug',
					cv.cover_image
				FROM {$table_prefix}languages AS lg
					LEFT OUTER JOIN (SELECT * FROM {$table_prefix}covers WHERE entity_code = 3) AS cv
						ON lg.id = cv.entity_id
				WHERE
					lg.delete_flg = 0
					AND lg.status = 1
					{$qsc_target_id}
				ORDER BY lg.line_order ASC
		";
    $read_languages = $pdo -> prepare($sql);
    $read_languages -> execute();
    while ($record = $read_languages -> fetch(PDO::FETCH_ASSOC))
    {
      $languages[$record['id']] = $record;
    }
    unset($read_languages);
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }

  // Fix Array Style
  $languages_fixed = array();
  if (! empty($key_by))
  {
    if ($key_by == 'id')
    {
      foreach($languages as $row)
      {
        $languages_fixed[$row['id']] = $row;
      }
    }
    elseif ($key_by == 'label')
    {
      foreach($languages as $row)
      {
        $languages_fixed[$row['label']] = $row;
      }
    }
    elseif ($key_by == 'number')
    {
      $languages_fixed = index_fromone($languages);
    }
    else {
      foreach($languages as $row)
      {
        $languages_fixed[$row['slug']] = $row;
      }
    }
  }
  else {
    foreach($languages as $row)
    {
      $languages_fixed[$row['slug']] = $row;
    }
  }

  return $languages_fixed;
}


/**
 * Get Image-frames
 * [@param  string $type ( '' | auto | crop )]
 * @return array  $image_frames
 */
function get_image_frames($type = '')
{
  global $database;
  global $pdo;
  global $table_prefix;

  $image_frames = array();
  try {
    $sql = "
				SELECT
					parent_dir AS 'parent_dir',
					child_dir AS 'child_dir',
					type AS 'type',
					width AS 'width',
					height AS 'height',
					comment AS 'comment'
				FROM {$table_prefix}image_frames
				WHERE
					status = 1
					AND parent_dir <> 'fr_admin'
					AND type LIKE '%{$type}%'
				ORDER BY parent_dir, child_dir ASC
		";
    $read_image_frames = $pdo -> prepare($sql);
    $read_image_frames -> execute();
    while ($record = $read_image_frames -> fetch(PDO::FETCH_ASSOC))
    {
      $image_frames[] = $record;
    }
    unset($read_image_frames);
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }
  return $image_frames;
}


/**
 * Get Comment-items
 * @param  number $post_id (target_post)
 * [@param  array  $config]
 *  + @param[item]  number 'comment_id' (origin_target_comment)
 *  + @param[item]  number 'parent_id' (current_target_comment)
 *  + @param[item]  number 'type' (string like 'review' also available)
 *  + @param[item]  array  'excluded_items'
 * @return array $items | boolean false
 */
function get_comment_items($post_id, $config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;
  global $comment_items;
  global $comment_items_label;

  // Set parameters
  $post_id        = (is_int($post_id))                   ? intval($post_id)               : 0;
  $comment_id     = (! empty($config['comment_id']))     ? intval($config['comment_id'])  : 0;
  $parent_id      = (! empty($config['parent_id']))      ? intval($config['parent_id'])   : 0;
  $type           = (! empty($config['type']))           ? $config['type']                : 1;
  $excluded_items = (! empty($config['excluded_items'])) ? $config['excluded_items']      : array(); // Off use

  if ($post_id)
  {
    $site_id     = 0;
    $posttype_id = 0;

    // Get site_id and posttype_id from id
    $sql = "SELECT site_id, posttype_id FROM {$table_prefix}posts_base WHERE id = {$post_id}";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id     = $record['site_id'];
      $posttype_id = $record['posttype_id'];
    }
    unset($read_records);

    if ($site_id && $posttype_id)
    {
      // Shape type
      if (! empty($type) && ! is_numeric($type))
      {
        switch ($type)
        {
          case 'review':
            $type = 2;
            break;
          case 'subpost':
            $type = 3;
            break;
          default:
            $type = 1;;
            break;
        }
      }

      // Check use (pre check)
      $use_flg = 0;
      try {
        $sql = "
						SELECT COUNT(*) AS 'use'
						FROM {$table_prefix}posttypes AS pt
							INNER JOIN (SELECT posttype_id, value AS 'comment_type' FROM {$table_prefix}configs_posttype WHERE site_id = 0 AND item = 'comment_type') AS cfp
								ON pt.id = cfp.posttype_id
						WHERE
							pt.id = {$posttype_id}
							AND cfp.comment_type LIKE '%{$type}%'
							AND pt.delete_flg = 0
							AND pt.status = 1
				";
        $check_use = $pdo -> prepare($sql);
        $check_use -> execute();
        if ($record = $check_use -> fetch(PDO::FETCH_ASSOC))
        {
          $use_flg = $record['use'];
        }
        unset($check_use);
      }
      catch(PDOException $e)
      {
        var_dump($e->getMessage());
      }

      // Get Items
      $items  = array();
      if ($use_flg)
      {
        // Get default_items
        $i_item = 0;
        $temp_order_sort = array();
        foreach ($comment_items as $key_item => $row)
        {
          if ($type != 2 && $row['item'] == 'score')
          {
            continue;
          }
          if (! in_array($row['item'], $excluded_items))
          {
            // set default label
            if (isset($comment_items_label[$row['item']])) $row['label'] = $comment_items_label[$row['item']];

            // set default value
            if ($row['item'] == 'post_id')     $row['default_value'] = $post_id;
            if ($row['item'] == 'comment_id')  $row['default_value'] = $comment_id;
            if ($row['item'] == 'parent_id')   $row['default_value'] = $parent_id;
            if ($row['item'] == 'type')        $row['default_value'] = $type;
            if ($row['item'] == 'site_id')     $row['default_value'] = $site_id;
            if ($row['item'] == 'posttype_id') $row['default_value'] = $posttype_id;
            $temp_order_sort[] = $row['temp_order'];
            $items[$i_item] = $row;
            $i_item ++;
          }
        }

        // Sort by temp_order
        array_multisort($temp_order_sort, SORT_NUMERIC, $items);
        foreach ($items as $key => $row)
        {
          unset($items[$key]['id']);
          unset($items[$key]['temp_order']);
        }
      }
      $items = index_fromone($items);
      return $items;
    }
  }
  return false;
}


/**
 * Get Contact-items
 * [@param  array $config]
 *  + @param[item]  string 'site'
 *  + @param[item]  number 'site_id'
 *  + @param[item]  string 'posttype'
 *  + @param[item]  number 'posttype_id'
 *  + @param[item]  string 'language'
 *  + @param[item]  number 'language_id'
 *  + @param[item]  string 'group'
 *  + @param[item]  number 'group_id'
 *  + @param[item]  array  'excluded_items'
 * @return array $items
 */
function get_contact_items($config = array(), $with_hidden = false)
{
  global $database;
  global $pdo;
  global $table_prefix;
  global $contact_items;
  global $contact_items_label;

  // Set parameters
  $site           = (! empty($config['site']))           ? $config['site']                : null;
  $site_id        = (! empty($config['site_id']))        ? intval($config['site_id'])     : 1;
  $posttype       = (! empty($config['posttype']))       ? $config['posttype']            : null;
  $posttype_id    = (! empty($config['posttype_id']))    ? intval($config['posttype_id']) : 1001;
  $language       = (! empty($config['language']))       ? $config['language']            : null;
  $language_id    = (! empty($config['language_id']))    ? intval($config['language_id']) : 1;
  $group          = (! empty($config['group']))          ? $config['group']               : null;
  $group_id       = (! empty($config['group_id']))       ? intval($config['group_id'])    : 0;
  $excluded_items = (! empty($config['excluded_items'])) ? $config['excluded_items']      : array(); // Off use

  // Get site_id from slug
  if ($site)
  {
    $site_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $site_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get language_id from slug
  if ($language)
  {
    $language_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $language_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Get group_id from slug
  if ($group)
  {
    $sql = "SELECT id FROM {$table_prefix}groups WHERE slug = '{$group}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $group_id = intval($record['id']);
    }
    unset($read_records);
  }

  // Check exist (pre check)
  $exist_flg = 0;
  $site_id_string = sprintf('%04d', $site_id);
  try {
    $sql = "SELECT COUNT(*) AS exist FROM {$table_prefix}posttypes WHERE id = {$posttype_id} AND site_id LIKE '%{$site_id_string}%' AND delete_flg = 0 AND status = 1";
    $check_exist = $pdo -> prepare($sql);
    $check_exist -> execute();
    if ($record = $check_exist -> fetch(PDO::FETCH_ASSOC))
    {
      $exist_flg = $record['exist'];
    }
    unset($check_exist);
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }

  // Get Items
  $items  = array();
  if ($exist_flg)
  {
    // Get Categories (need first more than default-item)
    $categories = array();
    try {
      $sql = "
					SELECT
						tb.id AS id,
						tb.parent_id AS parent_id,
						tb.slug AS slug,
						tb.line_order AS line_order,
						tl.label AS label
					FROM {$table_prefix}taxonomies_base AS tb
						INNER JOIN {$table_prefix}taxonomies_label AS tl
							ON tb.id = tl.base_id
					WHERE
						tb.delete_flg = 0
						AND tb.status = 1
						AND tb.posttype_id = {$posttype_id}
						AND tl.language_id = {$language_id}
						AND (tl.label IS NOT NULL AND tl.label != '')
					ORDER BY tb.parent_id, tb.line_order, tb.id ASC
			";
      $read_categories = $pdo -> prepare($sql);
      $read_categories -> execute();
      while ($category = $read_categories -> fetch(PDO::FETCH_ASSOC))
      {
        if ($category['parent_id'] > 0)
        {
          $categories[$category['parent_id']]['children'][$category['id']] = $category;
        }
        else {
          $categories[$category['id']] = $category;
        }
      }
      unset($read_categories);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    $select_values_category = array();
    if (! empty($categories))
    {
      foreach ($categories as $row)
      {
        $select_value = array();
        $select_value['value'] = $row['id'];
        $select_value['label'] = $row['label'];
        if (isset($row['children']))
        {
          $select_value['attribute'] = 'parent';
          $select_values_category[]  = $select_value;
          $select_value = array();
          foreach ($row['children'] as $row_child)
          {
            $select_value['value']     = $row_child['id'];
            $select_value['label']     = $row_child['label'];
            $select_value['attribute'] = 'child';
            $select_value['parent']    = $row['id'];
            $select_values_category[]  = $select_value;
          }
        }
        else {
          $select_values_category[]  = $select_value;
        }
      }
    }

    // Get default_items
    $i_item = 0;
    $temp_order_sort = array();
    foreach ($contact_items as $row)
    {
      if (! in_array($row['item'], $excluded_items))
      {
        // judge established categories or not
        if ($row['item'] == 'category_id')
        {
          if (! empty($select_values_category))
          {
            $row['select_values'] = $select_values_category;
          }
          else {
            continue;
          }
        }

        // set default label
        if (isset($contact_items_label[$row['item']])) $row['label'] = $contact_items_label[$row['item']];

        // set default value
        if ($row['item'] == 'site_id')     $row['default_value'] = $site_id;
        if ($row['item'] == 'posttype_id') $row['default_value'] = $posttype_id;
        if ($row['item'] == 'language_id') $row['default_value'] = $language_id;
        if ($row['item'] == 'group_id')    $row['default_value'] = $group_id;
        $temp_order_sort[] = $row['temp_order'];
        $items[$i_item] = $row;
        $i_item ++;
      }
    }

    // Get Custom items
    $custom_items = array();
    $temp_order = 100;
    try {
      $sql = "
					SELECT
						id AS 'id',
						slug AS 'item',
						name AS 'label',
						CASE
							WHEN type = 'select' THEN 'select'
							WHEN type = 'textarea' THEN 'textarea'
							ELSE 'input'
						END AS 'htmltag',
						type AS 'type',
						null AS 'name',
						choices AS 'choices',
						null AS 'default_value',
						null AS 'select_values'
					FROM {$table_prefix}custom_items
					WHERE
						delete_flg = 0
						AND status = 1
						AND posttype_id = {$posttype_id}
					ORDER BY line_order ASC
			";
      $read_custom_items = $pdo -> prepare($sql);
      $read_custom_items -> execute();
      while ($record = $read_custom_items -> fetch(PDO::FETCH_ASSOC))
      {
        $record['name']       = 'items['.$record['id'].']';
        $record['temp_order'] = $temp_order;
        $custom_items[] = $record;
        $temp_order ++;
      }
      unset($read_custom_items);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    if (! empty($custom_items))
    {
      // Get Choices
      foreach ($custom_items as $key => $row)
      {
        try {
          if (! empty($row['choices']) && ($row['htmltag'] == 'select' || $row['type'] == 'radio' || $row['type'] == 'checkbox'))
          {
            $sql = "
								SELECT
									cv.id AS id,
									cv.label AS label,
									cv.line_order AS line_order
								FROM {$table_prefix}custom_lists AS cl
									INNER JOIN
										(
											SELECT *
											FROM {$table_prefix}custom_values_base AS cvb
												INNER JOIN {$table_prefix}custom_values_label AS cvl
													ON cvb.id = cvl.base_id
											WHERE cvb.delete_flg = 0 AND (cvl.label IS NOT NULL AND cvl.label != '') AND cvl.language_id = {$language_id}
										) AS cv
										ON cl.id = cv.list_id
								WHERE
									cl.delete_flg = 0
									AND cl.id = {$row['choices']}
									AND cl.posttype_id = {$posttype_id}
								ORDER BY line_order, id ASC
						";
            $read_custom_values = $pdo -> prepare($sql);
            $read_custom_values -> execute();
            $custom_values = array();
            while ($record = $read_custom_values -> fetch(PDO::FETCH_ASSOC))
            {
              $select_value = array();
              $select_value['value'] = $record['label'];
              $select_value['label'] = $record['label'];
              array_push($custom_values, $select_value);
            }
            unset($read_custom_values);
            $custom_items[$key]['select_values'] = $custom_values;
          }
        }
        catch(PDOException $e)
        {
          var_dump($e->getMessage());
        }
      }

      foreach ($custom_items as $row)
      {
        if (! in_array($row['item'], $excluded_items))
        {
          $temp_order_sort[] = $row['temp_order'];
          $items[$i_item] = $row;
          $i_item ++;
        }
      }
    }
    // Sort by temp_order
    array_multisort($temp_order_sort, SORT_NUMERIC, $items);
    foreach ($items as $key => $row)
    {
      unset($items[$key]['id']);
      unset($items[$key]['temp_order']);
      if (false === $with_hidden && $row['type'] == 'hidden') unset($items[$key]);
    }
  }
  $items = index_fromone($items);

  // Shape as object
  $shaped_items = array();
  foreach ($items as $key => $row)
  {
    $new_key = $row['item'];
    $item_slug = array('slug' => $new_key);
    unset($row['item']);
    unset($row['name']);

    $options = array();
    if (is_array($row['select_values']) && count($row['select_values']) > 0)
    {
      foreach ($row['select_values'] as $value)
      {
        $options[$value['value']]['value'] = $value['value'];
        $options[$value['value']]['label'] = $value['label'];
      }
    }
    else {
      $options = $row['select_values'];
    }
    $row['options'] = $options;
    unset($row['select_values']);
    $shaped_items[$new_key] = $item_slug + $row;
  }
  return $shaped_items;
}


/**
 * Create new record of contact
 * @param  array $postdata
 * @return number $new_contact_id | boolean false
 */
function post_contact($postdata)
{
  global $database;
  global $pdo;
  global $table_prefix;

  if (! empty($postdata))
  {
    // Set default value
    $site         = (! empty($postdata['site']))        ? $postdata['site']        : null;
    $site_id      = (! empty($postdata['site_id']))     ? $postdata['site_id']     : 1;
    $posttype     = (! empty($postdata['posttype']))    ? $postdata['posttype']    : null;
    $posttype_id  = (! empty($postdata['posttype_id'])) ? $postdata['posttype_id'] : 1001;
    $language     = (! empty($postdata['language']))    ? $postdata['language']    : null;
    $language_id  = (! empty($postdata['language_id'])) ? $postdata['language_id'] : 1;
    $group        = (! empty($postdata['group']))       ? $postdata['group']       : null;
    $group_id     = (! empty($postdata['group_id']))    ? $postdata['group_id']    : 0;
    $title        = (! empty($postdata['title']))       ? $postdata['title']       : null;
    $content      = (! empty($postdata['content']))     ? $postdata['content']     : null;
    $name         = (! empty($postdata['name']))        ? $postdata['name']        : null;
    $email        = (! empty($postdata['email']))       ? $postdata['email']       : null;
    $tel          = (! empty($postdata['tel']))         ? $postdata['tel']         : null;
    $contacted_at = date('Y-m-d H:i:s');
    $created_at   = date('Y-m-d H:i:s');
    $category_id  = '0000';

    // Get site_id from slug
    if ($site)
    {
      $site_id = 9999;
      $sql = "SELECT id FROM {$table_prefix}sites WHERE delete_flg = 0 AND status = 1 AND slug = '{$site}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $site_id = intval($record['id']);
      }
      unset($read_records);
    }

    // Get posttype_id from slug
    if ($posttype)
    {
      $posttype_id = 9999;
      $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $posttype_id = intval($record['id']);
      }
      unset($read_records);
    }

    // Get language_id from slug
    if ($language)
    {
      $language_id = 9999;
      $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $language_id = intval($record['id']);
      }
      unset($read_records);
    }

    // Get group_id from group
    if ($group)
    {
      $sql = "SELECT id FROM {$table_prefix}groups WHERE slug = '{$group}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $group_id = intval($record['id']);
      }
      unset($read_records);
    }

    // format category
    if (! empty($postdata['category_id']))
    {
      if (is_array($postdata['category_id']))
      {
        foreach ($postdata['category_id'] as $key => $value)
        {
          $postdata['category_id'][$key] = sprintf('%04d', $value);
        }
        $category_id = implode(',', $postdata['category_id']);
      }
      else {
        $category_id = sprintf('%04d', $postdata['category_id']);
      }
    }

    // Execute
    $new_contact_id = 0;
    try {
      $pdo -> beginTransaction();

      // contacts_base
      $sql = "
					INSERT INTO {$table_prefix}contacts_base
						( site_id,  posttype_id,  language_id,  group_id,  category_id,  title,  content,  name,  email,  tel,  contacted_at,  created_at)
					VALUES
						(:SITE_ID, :POSTTYPE_ID, :LANGUAGE_ID, :GROUP_ID, :CATEGORY_ID, :TITLE, :CONTENT, :NAME, :EMAIL, :TEL, :CONTACTED_AT, :CREATED_AT)
			";
      $create_contact_base = $pdo->prepare($sql);
      $create_contact_base -> bindValue(':SITE_ID',      $site_id,      PDO::PARAM_INT);
      $create_contact_base -> bindValue(':POSTTYPE_ID',  $posttype_id,  PDO::PARAM_INT);
      $create_contact_base -> bindValue(':LANGUAGE_ID',  $language_id,  PDO::PARAM_INT);
      $create_contact_base -> bindValue(':GROUP_ID',     $group_id,     PDO::PARAM_INT);
      $create_contact_base -> bindValue(':CATEGORY_ID',  $category_id,  PDO::PARAM_STR);
      $create_contact_base -> bindValue(':TITLE',        $title,        PDO::PARAM_STR);
      $create_contact_base -> bindValue(':CONTENT',      $content,      PDO::PARAM_STR);
      $create_contact_base -> bindValue(':NAME',         $name,         PDO::PARAM_STR);
      $create_contact_base -> bindValue(':EMAIL',        $email,        PDO::PARAM_STR);
      $create_contact_base -> bindValue(':TEL',          $tel,          PDO::PARAM_STR);
      $create_contact_base -> bindValue(':CONTACTED_AT', $contacted_at, PDO::PARAM_STR);
      $create_contact_base -> bindValue(':CREATED_AT',   $created_at,   PDO::PARAM_STR);
      $create_contact_base -> execute();
      unset($create_contact_base);

      // post_custom
      $sql = "SELECT id FROM {$table_prefix}contacts_base ORDER BY id DESC LIMIT 0, 1";
      $get_new_contact = $pdo -> prepare($sql);
      $get_new_contact -> execute();
      if ($new_contact = $get_new_contact -> fetch(PDO::FETCH_ASSOC))
      {
        $new_contact_id = $new_contact['id'];
        unset($get_new_contact);
      }
      if (! empty($new_contact_id))
      {
        foreach ($postdata as $key => $value)
        {
          if (false === in_array($key, array('title', 'name', 'email', 'tel', 'content', 'items')))
          {
            $sql = "
							SELECT id FROM {$table_prefix}custom_items
							WHERE delete_flg = 0 AND status = 1 AND posttype_id = {$posttype_id} AND slug = '{$key}'
						";
            $read_custom_item = $pdo->prepare($sql);
            $read_custom_item->execute();
            if ($custom_item = $read_custom_item->fetch(PDO::FETCH_ASSOC))
            {
              $custom_item_id = $custom_item['id'];
              $postdata['items'][$custom_item_id] = $value;
            }
            unset($read_custom_item);
          }
        }
        if (! empty($postdata['items']))
        {
          foreach ($postdata['items'] as $custom_item_id => $value)
          {
            if (is_array($value))
            {
              $value = implode(',', $value);
            }
            $sql = "
							INSERT INTO {$table_prefix}contacts_custom
								( base_id,  custom_item_id,  value)
							VALUES
								(:BASE_ID, :CUSTOM_ITEM_ID, :VALUE)
						";
            $create_contact_custom = $pdo -> prepare($sql);
            $create_contact_custom -> bindValue(':BASE_ID',        $new_contact_id, PDO::PARAM_INT);
            $create_contact_custom -> bindValue(':CUSTOM_ITEM_ID', $custom_item_id, PDO::PARAM_INT);
            $create_contact_custom -> bindValue(':VALUE',          $value,          PDO::PARAM_STR);
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
      return false;
      //var_dump($e->getMessage());
    }
    return $new_contact_id;
  }
  return false;
}


/**
 * Get Contact-data for mail
 * @param  number $contact_id
 * [@param  array  $config]
 *  + @param[item] string 'language' (slug)
 *  + @param[item] number 'language_id'
 * @return array  $contact | boolean (false)
 */
function get_contact($contact_id, $config = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  // Set parameters
  $contact_id  = intval($contact_id);
  $language    = (! empty($config['language']))    ? $config['language']    : null;
  $language_id = (! empty($config['language_id'])) ? $config['language_id'] : 1;

  if (! empty($contact_id))
  {
    // Get language_id from slug
    if ($language)
    {
      $language_id = 9999;
      $sql = "SELECT id FROM {$table_prefix}languages WHERE slug = '{$language}'";
      $read_records = $pdo -> prepare($sql);
      $read_records -> execute();
      if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
      {
        $language_id = intval($record['id']);
      }
      unset($read_records);
    }

    // contact_base
    $contact_base = array();
    try {
      $sql = "
					SELECT category_id, title, content, name, email, tel, contacted_at
					FROM {$table_prefix}contacts_base
					WHERE id = {$contact_id}
			";
      $read_contact = $pdo -> prepare($sql);
      $read_contact -> execute();
      if ($record = $read_contact -> fetch(PDO::FETCH_ASSOC))
      {
        $contact_base = $record;
      }
      unset($read_contact);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }

    // category
    $category_text = null;
    if (! empty($contact_base['category_id']))
    {
      $category_id_arr = explode(',', $contact_base['category_id']);
      foreach ($category_id_arr as $value)
      {
        $category_id = intval($value);
        $categories_arr = array();
        try {
          $sql = "
							SELECT tl.label AS label
							FROM {$table_prefix}taxonomies_base AS tb
								INNER JOIN {$table_prefix}taxonomies_label AS tl
									ON tb.id = tl.base_id
							WHERE
								tb.id = :ID
								AND tl.language_id = :LANGUAGE_ID
					";
          $read_categories = $pdo -> prepare($sql);
          $read_categories -> bindValue(':ID',          $category_id, PDO::PARAM_INT);
          $read_categories -> bindValue(':LANGUAGE_ID', $language_id, PDO::PARAM_INT);
          $read_categories -> execute();
          while ($record = $read_categories -> fetch(PDO::FETCH_ASSOC))
          {
            $categories_arr[] = $record['label'];
          }
          unset($read_categories);
        }
        catch(PDOException $e)
        {
          var_dump($e->getMessage());
        }
      }
      $category_text = implode(',', $categories_arr);
      $tmp_arr['category'] = $category_text;
      $contact_base = array_merge($tmp_arr, $contact_base);
      unset($contact_base['category_id']);
    }

    // contact_custom
    $contact_custom = array();
    try{
      $sql = "
					SELECT
						ci.slug AS slug,
						cc.value AS value
					FROM {$table_prefix}contacts_custom AS cc
						INNER JOIN {$table_prefix}custom_items AS ci
							ON  cc.custom_item_id = ci.id
					WHERE
						cc.base_id = {$contact_id}
			";
      $read_contact_custom = $pdo -> prepare($sql);
      $read_contact_custom -> execute();
      while ($record = $read_contact_custom -> fetch(PDO::FETCH_ASSOC))
      {
        $contact_custom[$record['slug']] = $record['value'];
      }
      unset($read_contact_custom);
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
    $contact = array_merge($contact_base, $contact_custom);
    return $contact;
  }
  return false;
}


/**
 * Reset Contact-data
 * @param  array $items
 * [@param  array $targets]
 * @return array $contact(reset) | boolean (false)
 */
function reset_contact($contact, $targets = array())
{
  $contact_reset  = array();
  if (! empty($contact) && ! empty($targets))
  {
    foreach ($targets as $key_target => $label)
    {
      if (array_key_exists($key_target, $contact))
      {
        if (! empty($label))
        {
          $contact_reset[$label] = $contact[$key_target];
        }
        else {
          $contact_reset[$key_target] = $contact[$key_target];
        }
      }
    }
    return $contact_reset;
  }
  elseif (! empty($contact) && empty($targets))
  {
    return $contact;
  }
  return false;
}


/**
 * Pickup, Sort and Change label contact-items
 * @param  array $items
 * [@param  array $targets (In fact optional for combo)]
 * @return array $items(reset) | boolean false
 */
function reset_items($items, $targets = array())
{
  $items_reset  = array();
  $items_hidden = array();
  if (! empty($items) && ! empty($targets))
  {
    foreach ($items as $key => $row)
    {
      if ($row['type'] != 'hidden')
      {
        $i_targets = 0;
        foreach ($targets as $key_target => $label)
        {
          if ($key_target == $row['item'] && $row['type'] != 'hidden')
          {
            $items_reset[$i_targets] = $items[$key];
            if (! empty($label)) $items_reset[$i_targets]['label'] = $label;
            break;
          }
          $i_targets ++;
        }
      }
      else {
        $items_hidden[] = $items[$key];
      }
    }
    ksort($items_reset);
    $items_return = array_merge($items_reset, $items_hidden);
    $items_return = index_fromone($items_return);
    return $items_return;
  }
  elseif (! empty($items) && empty($targets))
  {
    return $items;
  }
  return false;
}


/**
 * Send mail using local mta
 * @param  array $config
 *  + @param[item]  string 'language'
 *  + @param[item]  string 'from_name'
 *  + @param[item]  string 'to_name'
 *  * @param[item]  string 'from'
 *  * @param[item]  string 'to' (array is also available for Multiple)
 *  + @param[item]  string 'cc' (array is also available for Multiple)
 *  + @param[item]  string 'bcc' (array is also available for Multiple)
 *  + @param[item]  string 'replyto'
 *  + @param[item]  string 'subject'
 *  + @param[item]  string 'body_head'
 *  + @param[item]  string 'body_main'
 *  + @param[item]  string 'body_bottom'
 *  + @param[item]  string 'signature'
 * [@param  array $contact]
 * @return boolean
 */
function send_mail($config, $contact = array())
{
  $php_version = '';
  $php_version_arr = explode('.', phpversion());
  for ($i = 0; $i < 3; $i ++)
  {
    $version_string = (isset($php_version_arr[$i])) ? sprintf('%02d', $php_version_arr[$i]) : '00';
    $php_version .= $version_string;
  }

  if (! empty($config) && ! empty($config['from']) && ! empty($config['to']))
  {
    $from_name    = (! empty($config['from_name']))    ? $config['from_name']    : null;
    $to_name      = (! empty($config['to_name']))      ? $config['to_name']      : null;
    $from         = (! empty($config['from']))         ? $config['from']         : null;
    $to           = (! empty($config['to']))           ? $config['to']           : null;
    $cc           = (! empty($config['cc']))           ? $config['cc']           : null;
    $bcc          = (! empty($config['bcc']))          ? $config['bcc']          : null;
    $replyto      = (! empty($config['replyto']))      ? $config['replyto']      : null;
    $subject      = (! empty($config['subject']))      ? $config['subject']      : null;
    $body_head    = (! empty($config['body_head']))    ? $config['body_head']    : null;
    $body_main    = (! empty($config['body_main']))    ? $config['body_main']    : null;
    $body_bottom  = (! empty($config['body_bottom']))  ? $config['body_bottom']  : null;
    $signature    = (! empty($config['signature']))    ? $config['signature']    : null;

    // Format to/cc/bcc when multiple
    if (! empty($to)  && is_array($to))  $to  = implode(',', $to);
    if (! empty($cc)  && is_array($cc))  $cc  = implode(',', $cc);
    if (! empty($bcc) && is_array($bcc)) $bcc = implode(',', $bcc);

    // Set encodeing
    // Set encodeing
    if (! empty($config['language']))
    {
      switch (mb_strtolower($config['language']))
      {
        case 'unicode'  : $language = 'uni'; $encoding = 'UTF-8';       break;
        case 'uni'      : $language = 'uni'; $encoding = 'UTF-8';       break;
        case 'utf'      : $language = 'uni'; $encoding = 'UTF-8';       break;
        case 'english'  : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'en'       : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'en_en'    : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'german'   : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'de'       : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'de_de'    : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'french'   : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'fr'       : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'fr_fr'    : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'spanish'  : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'es'       : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'es_es'    : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'italian'  : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'it'       : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'it_it'    : $language = 'en';  $encoding = 'ISO-8859-1';  break;
        case 'japanese' : $language = 'ja';  $encoding = 'ISO-2022-JP'; break;
        case 'jp'       : $language = 'ja';  $encoding = 'ISO-2022-JP'; break;
        case 'ja_jp'    : $language = 'ja';  $encoding = 'ISO-2022-JP'; break;
        case 'ja'       : $language = 'ja';  $encoding = 'ISO-2022-JP'; break;
      }
    }
    else {
      $language = 'uni';
      $encoding = 'UTF-8';
    }

    // Extend ISO-2022-JP
    if (intval($php_version) >= 50201 && $encoding == 'ISO-2022-JP')
    {
      $encoding = 'ISO-2022-JP-MS';
    }

    mb_language($language);
    mb_internal_encoding($encoding);

    // Make body
    $body = null;
    if ($to_name)   $body .= $to_name."\r\n"."\r\n";
    if ($body_head) $body .= $body_head."\r\n"."\r\n";
    if ($body_main) $body .= $body_main."\r\n"."\r\n";
    if (! empty($contact) && is_array($contact))
    {
      $body .= '---'."\r\n";
      foreach ($contact as $key => $value)
      {
        $body .= $key.' : '.$value."\r\n";
      }
      $body .= '---'."\r\n"."\r\n";
    }
    if ($body_bottom) $body .= $body_bottom."\r\n"."\r\n"."\r\n";
    if ($signature)   $body .= $signature."\r\n"."\r\n"."\r\n";

    // Make Header
    $headers  = 'MIME-Version: 1.0 '."\r\n" ;
    $headers .= "Content-Type: text/plain;charset={$encoding} "."\r\n";
    $headers .= 'From: '.mb_encode_mimeheader(mb_convert_encoding($from_name, $encoding, 'AUTO')).' <'.$from.'> '."\r\n";
    if (! empty($cc))      $headers .= 'Cc: '.$cc."\r\n";
    if (! empty($bcc))     $headers .= 'Bcc: '.$bcc."\r\n";
    if (! empty($replyto)) $headers .= 'Reply-To: '.$replyto."\r\n";

    // Encode Subject
    $subject = mb_encode_mimeheader(mb_convert_encoding($subject, $encoding, 'AUTO'));

    // Encode Body
    $body = mb_convert_encoding($body, $encoding, 'AUTO');

    $result = mail($to, $subject, $body, $headers);
    if ($result)
    {
      return array
      (
        'result' => 1,
        'http_status_code' => 200,
        'error_point' => 'none',
      );
    }
    else {
      return array
      (
        'result' => 0,
        'http_status_code' => 400,
        'error_point' => 'send_mail',
      );
    }
  }
  return array
  (
    'result' => 0,
    'http_status_code' => 400,
    'error_point' => 'missing_params',
  );
}


/**
 * Send mail using remote mta, enable html-mail
 * @param  array $config_mail
 *  + @param[item]  string 'language'
 *  + @param[item]  number 'wordwrap' (0: unspecified / more than 1: specified)
 *  + @param[item]  string 'from_name'
 *  + @param[item]  string 'to_name'
 *  + @param[item]  string 'from'
 *  + @param[item]  string 'to' (array is also available for Multiple)
 *  + @param[item]  string 'cc' (array is also available for Multiple)
 *  + @param[item]  string 'bcc' (array is also available for Multiple)
 *  + @param[item]  string 'replyto'
 *  + @param[item]  string 'subject'
 *  + @param[item]  string 'body_head'
 *  + @param[item]  string 'body_main'
 *  + @param[item]  string 'body_bottom'
 *  + @param[item]  string 'signature'
 *  + @param[item]  string 'attachments'
 *  + @param[item]  string 'wordwrap'
 * [@param  array $config_smtp]
 * [@param  array $contact]
 * @return boolean
 */
function send_mail_extend($config_mail, $config_smtp = array(), $contact = array())
{
  $mail = new PHPMailer;
  $normalizer = new I18N_UnicodeNormalizer();
  $php_version = '';
  $php_version_arr = explode('.', phpversion());
  for ($i = 0; $i < 3; $i ++)
  {
    $version_string = (isset($php_version_arr[$i])) ? sprintf('%02d', $php_version_arr[$i]) : '00';
    $php_version .= $version_string;
  }

  if (! empty($config_mail) && ! empty($config_mail['from']) && ! empty($config_mail['to']))
  {
    $from_name    = (! empty($config_mail['from_name']))    ? $config_mail['from_name']     : null;
    $to_name      = (! empty($config_mail['to_name']))      ? $config_mail['to_name']       : null;
    $from         = (! empty($config_mail['from']))         ? $config_mail['from']          : null;
    $to           = (! empty($config_mail['to']))           ? $config_mail['to']            : null;
    $cc           = (! empty($config_mail['cc']))           ? $config_mail['cc']            : null;
    $bcc          = (! empty($config_mail['bcc']))          ? $config_mail['bcc']           : null;
    $replyto      = (! empty($config_mail['replyto']))      ? $config_mail['replyto']       : null;
    $subject      = (! empty($config_mail['subject']))      ? $config_mail['subject']       : null;
    $body_head    = (! empty($config_mail['body_head']))    ? $config_mail['body_head']     : null;
    $body_main    = (! empty($config_mail['body_main']))    ? $config_mail['body_main']     : null;
    $body_bottom  = (! empty($config_mail['body_bottom']))  ? $config_mail['body_bottom']   : null;
    $signature    = (! empty($config_mail['signature']))    ? $config_mail['signature']     : null;
    $attachments  = (! empty($config_mail['attachments']))  ? $config_mail['attachments']   : array();
    $wordwrap     = (! empty($config_mail['wordwrap']))     ? intval($config_mail['wordwrap']) : 0;
    if (! empty($to)      && ! is_array($to))      $to      = explode(',', $to);
    if (! empty($cc)      && ! is_array($cc))      $cc      = explode(',', $cc);
    if (! empty($bcc)     && ! is_array($bcc))     $to      = explode(',', $bcc);
    if (! empty($replyto) && ! is_array($replyto)) $replyto = explode(',', $replyto);

    // Set encodeing
    if (! empty($config_mail['language']))
    {
      switch (mb_strtolower($config_mail['language']))
      {
        case 'unicode'  : $language = 'uni'; $charset = 'UTF-8';       $encoding = 'base64'; break;
        case 'uni'      : $language = 'uni'; $charset = 'UTF-8';       $encoding = 'base64'; break;
        case 'utf'      : $language = 'uni'; $charset = 'UTF-8';       $encoding = 'base64'; break;
        case 'english'  : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'en'       : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'en_en'    : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'german'   : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'de'       : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'de_de'    : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'french'   : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'fr'       : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'fr_fr'    : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'spanish'  : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'es'       : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'es_es'    : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'italian'  : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'it'       : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'it_it'    : $language = 'en';  $charset = 'ISO-8859-1';  $encoding = '8bit';   break;
        case 'japanese' : $language = 'ja';  $charset = 'ISO-2022-JP'; $encoding = 'base64'; break;
        case 'jp'       : $language = 'ja';  $charset = 'ISO-2022-JP'; $encoding = 'base64'; break;
        case 'ja_jp'    : $language = 'ja';  $charset = 'ISO-2022-JP'; $encoding = 'base64'; break;
        case 'ja'       : $language = 'ja';  $charset = 'ISO-2022-JP'; $encoding = 'base64'; break;
      }
    }
    else {
      $language = 'uni';
      $charset  = 'UTF-8';
      $encoding = 'base64';
    }

    // Extend ISO-2022-JP
    if (intval($php_version) >= 50201 && $charset == 'ISO-2022-JP')
    {
      $charset = 'ISO-2022-JP-MS';
    }

    // Set Charset and Encording
    $mail -> CharSet  = $charset;
    $mail -> Encoding = $encoding;
    $mail -> WordWrap = 0;
    mb_language($language);

    // Custom SMTP config
    if (! empty($config_smtp))
    {
      // Default
      $mail -> SMTPDebug = 0;
      $mail -> IsSMTP();
      $mail -> IsHTML(false);
      $mail -> Host     = 'localhost';
      $mail -> SMTPAuth = false;
      $mail -> Port     = 25;

      if (! empty($config_smtp['host']))
      {
        if (is_array($config_smtp['host'])) $config_smtp['host'] = implode(';', $config_smtp['host']);
        $mail -> Host = $config_smtp['host'];
      }
      if (! empty($config_smtp['user_name']) && ! empty($config_smtp['password']))
      {
        $mail -> SMTPAuth = true;
        $mail -> Username = $config_smtp['user_name'];
        $mail -> Password = $config_smtp['password'];
      }
      if (! empty($config_smtp['port']))
      {
        if ($config_smtp['port'] == '465') $mail -> SMTPSecure = 'ssl';
        if ($config_smtp['port'] == '587') $mail -> SMTPSecure = 'tls';
        $mail -> Port = $config_smtp['port'];
      }
      if (! empty($wordwrap))
      {
        if ($wordwrap = intval($config_mail['wordwrap']))
        {
          $mail -> WordWrap = $wordwrap;
        }
      }
    }

    // Set From
    $mail -> setFrom($from, mb_encode_mimeheader(mb_convert_encoding($from_name, $charset, 'AUTO'), $charset, 'B', "\n"));

    // Set To
    foreach ($to as $value)
    {
      $mail -> addAddress($value);
    }

    // Set Cc
    if (! empty($cc))
    {
      foreach ($cc as $value)
      {
        $mail -> addCC($value);
      }
    }

    // Set Bcc
    if (! empty($bcc))
    {
      foreach ($bcc as $value)
      {
        $mail -> addBCC($value);
      }
    }

    // Set Reply-to
    if (! empty($replyto))
    {
      foreach ($replyto as $value)
      {
        $mail->addReplyTo($value);
      }
    }

    // Set Subject
    $mail -> Subject = mb_encode_mimeheader(mb_convert_encoding($subject, $charset, 'AUTO'), $charset, 'B', "\n");

    // Set Body
    $body = null;
    if ($to_name)   $body .= $to_name."\r\n"."\r\n";
    if ($body_head) $body .= $body_head."\r\n"."\r\n";
    if ($body_main) $body .= $body_main."\r\n"."\r\n";
    if (! empty($contact) && is_array($contact))
    {
      $body .= '---'."\r\n";
      foreach ($contact as $key => $value)
      {
        $body .= $key.' : '.$value."\r\n";
      }
      $body .= '---'."\r\n"."\r\n";
    }
    if ($body_bottom) $body .= $body_bottom."\r\n"."\r\n"."\r\n";
    if ($signature)   $body .= $signature."\r\n"."\r\n"."\r\n";
    $body = mb_convert_encoding($body, $charset, 'AUTO');
    $mail -> Body = $body;

    // Set Attachments
    if (! empty($attachments))
    {
      foreach ($attachments as $attachment)
      {
        $mail->AddAttachment
        (
          $attachment['file_path'],
          mb_encode_mimeheader(mb_convert_encoding($normalizer->normalize($attachment['file_name'], 'NFC'), $charset, 'AUTO'), $charset, 'B', "\n")
        );
      }
    }
  }
  else {
    return array
    (
      'result' => 0,
      'http_status_code' => 400,
      'error_point' => 'bad_request',
    );
  }

  if(! $mail -> send())
  {
    //echo 'Send Mail Error: ' . $mail->ErrorInfo;
    return array
    (
      'result' => 0,
      'http_status_code' => 400,
      'error_point' => 'send_mail',
      'extra_message' => $mail->ErrorInfo,
    );
  }
  else {
    return array
    (
      'result' => 1,
      'http_status_code' => 200,
      'error_point' => 'none',
    );
  }
}


/**
 * Execute 4 process with Contact Settings
 * @param array $contact_target
 * @param array $contact_data
 * [@param array $reset_items]
 * [@param array $config_mail]
 * @return bool
 */
function post_contact_send_mail ($contact_target, $contact_data, $reset_items = array(), $config_mail = array())
{
  global $database;
  global $pdo;
  global $table_prefix;

  $posttype     = (! empty($contact_target['posttype']))    ? $contact_target['posttype']    : null;
  $posttype_id  = (! empty($contact_target['posttype_id'])) ? $contact_target['posttype_id'] : 1;
  $mail_to      = (! empty($contact_data['email']))            ? $contact_data['email']            : '';
  $postdata     = $contact_target + $contact_data;


  // Get posttype_id from slug
  if ($posttype)
  {
    $posttype_id = 9999;
    $sql = "SELECT id FROM {$table_prefix}posttypes WHERE delete_flg = 0 AND status = 1 AND slug = '{$posttype}'";
    $read_records = $pdo -> prepare($sql);
    $read_records -> execute();
    if ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
    {
      $posttype_id = intval($record['id']);
    }
    unset($read_records);
  }

  /*
	 * Get SMTP
	 */
  $config_smtp = array();
  $sql = "SELECT item, value FROM {$table_prefix}configs_posttype WHERE site_id = 0 AND posttype_id = {$posttype_id} AND item IN('use_smtp', 'host', 'user_name', 'password', 'port')";
  $read_records = $pdo -> prepare($sql);
  $read_records -> execute();
  while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
  {
    $config_smtp[$record['item']] = $record['value'];
  }
  unset($read_records);

  /*
	 * Get Admin Config
	 */
  $config_admin = array();
  $sql = "SELECT item, value FROM {$table_prefix}configs_posttype WHERE site_id = 0 AND posttype_id = '{$posttype_id}' AND item LIKE '%admin%'";
  $read_records = $pdo -> prepare($sql);
  $read_records -> execute();
  while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
  {
    $item = str_replace('admin_', '', $record['item']);
    $config_admin[$item] = $record['value'];
  }
  unset($read_records);

  /*
	 * Overwrite Admin Config
	 */
  if (! empty($config_mail['admin']))
  {
    foreach ($config_mail['admin'] as $key => $value)
    {
      if (isset($config_admin[$key]) && ! empty($value))
      {
        $config_admin[$key] = $value;
      }
    }
  }

  /*
	 * Get Customer Config
	 */
  $config_customer = array();
  $sql = "SELECT item, value FROM {$table_prefix}configs_posttype WHERE site_id = 0 AND posttype_id = '{$posttype_id}' AND item LIKE '%customer%'";
  $read_records = $pdo -> prepare($sql);
  $read_records -> execute();
  while ($record = $read_records -> fetch(PDO::FETCH_ASSOC))
  {
    $item = str_replace('customer_', '', $record['item']);
    $config_customer[$item] = $record['value'];
  }
  unset($read_records);

  /*
	 * Overwrite Customer Config
	 */
  if (! empty($config_mail['customer']))
  {
    foreach ($config_mail['customer'] as $key => $value)
    {
      if (isset($config_customer[$key]) && ! empty($value))
      {
        $config_customer[$key] = $value;
      }
    }
  }

  /*
	 * Set Contact and Reset Contact
	 */
  if (empty($postdata['title']) && ! empty($config_customer['subject'])) $postdata['title'] = $config_customer['subject'];
  if (! $new_contact_id = post_contact($postdata))
  {
    return array
    (
      'result' => 0,
      'http_status_code' => 400,
      'error_point' => 'bad_request',
    );
  }
  $contact = get_contact($new_contact_id, $contact_target);
  if (empty($contact))
  {
    return array
    (
      'result' => 0,
      'http_status_code' => 400,
      'error_point' => 'bad_request',
    );
  }
  $contact = reset_contact($contact, $reset_items);


  /*
	 * Send Mail Admin
	 */
  if ($config_admin['from'] && $config_admin['to'] && $config_admin['use_auto_reply_admin'])
  {
    $contact = ($config_admin['use_input_values_admin']) ? $contact : array();
    if (! empty($config_smtp['use_smtp']))
    {
      $result = send_mail_extend($config_admin, $config_smtp, $contact);
      if ($result['result'] == 0) return $result;
    }
    else {
      $result = send_mail($config_admin, $contact);
      if ($result['result'] == 0) return $result;
    }
  }

  /*
	 * Send Mail Customer
	 */
  if ($config_customer['from'] && $config_customer['use_auto_reply_customer'])
  {
    $config_customer['to'] = $mail_to;
    $contact = ($config_customer['use_input_values_customer']) ? $contact : array();
    if (! empty($config_smtp['use_smtp']))
    {
      $result = send_mail_extend($config_customer, $config_smtp, $contact);
      if ($result['result'] == 0) return $result;
    }
    else {
      $result = send_mail($config_customer, $contact);
      if ($result['result'] == 0) return $result;
    }
  }

  return array
  (
    'result' => 1,
    'http_status_code' => 200,
    'error_point' => 'none',
  );
}


/**
 * Create new record of comment
 * @param  array $postdata
 * @return number $affected_id | boolean false
 */
function post_comment($postdata)
{
  global $database;
  global $pdo;
  global $table_prefix;

  if (! empty($postdata))
  {
    // Set default value
    $target_id   = (! empty($postdata['target_id']))   ? intval($postdata['target_id'])   : 0;
    $post_id     = (! empty($postdata['post_id']))     ? intval($postdata['post_id'])     : 0;
    $comment_id  = (! empty($postdata['comment_id']))  ? intval($postdata['comment_id'])  : 0;
    $parent_id   = (! empty($postdata['parent_id']))   ? intval($postdata['parent_id'])   : 0;
    $site_id     = (! empty($postdata['site_id']))     ? intval($postdata['site_id'])     : 1;
    $posttype_id = (! empty($postdata['posttype_id'])) ? intval($postdata['posttype_id']) : 1;
    $type        = (! empty($postdata['type']))        ? intval($postdata['type'])        : 1;
    $score       = (isset($postdata['score']))         ? intval($postdata['score'])       : 0;
    $nickname    = (! empty($postdata['nickname']))    ? $postdata['nickname']            : '';
    $email       = (! empty($postdata['email']))       ? $postdata['email']               : '';
    $eyecatch    = (! empty($postdata['eyecatch']))    ? $postdata['eyecatch']            : null;
    $title       = (! empty($postdata['title']))       ? $postdata['title']               : '';
    $content     = (! empty($postdata['content']))     ? $postdata['content']             : '';
    $ip_address  = (! empty($postdata['ip_address']))  ? $postdata['ip_address']          : null;
    $delete_flg  = (! empty($postdata['delete_flg']))  ? intval($postdata['delete_flg'])  : 0;
    $posted_at   = date('Y-m-d H:i:s');
    $updated_at  = date('Y-m-d H:i:s');

    // Execute
    $affected_id = 0;
    try {
      $pdo -> beginTransaction();

      if (! $target_id)
      {
        $sql = "
						INSERT INTO {$table_prefix}comments
							( post_id,  comment_id,  parent_id,  site_id,  posttype_id,  type,  score,  nickname,  email,  eyecatch,  title,  content,  ip_address,  posted_at)
						VALUES
							(:POST_ID, :COMMENT_ID, :PARENT_ID, :SITE_ID, :POSTTYPE_ID, :TYPE, :SCORE, :NICKNAME, :EMAIL, :EYECATCH, :TITLE, :CONTENT, :IP_ADDRESS, :POSTED_AT)
				";
        $create_comment = $pdo->prepare($sql);
        $create_comment -> bindValue(':POST_ID',     $post_id,     PDO::PARAM_INT);
        $create_comment -> bindValue(':COMMENT_ID',  $comment_id,  PDO::PARAM_INT);
        $create_comment -> bindValue(':PARENT_ID',   $parent_id,   PDO::PARAM_INT);
        $create_comment -> bindValue(':SITE_ID',     $site_id,     PDO::PARAM_INT);
        $create_comment -> bindValue(':POSTTYPE_ID', $posttype_id, PDO::PARAM_INT);
        $create_comment -> bindValue(':TYPE',        $type,        PDO::PARAM_INT);
        $create_comment -> bindValue(':SCORE',       $score,       PDO::PARAM_INT);
        $create_comment -> bindValue(':NICKNAME',    $nickname,    PDO::PARAM_STR);
        $create_comment -> bindValue(':EMAIL',       $email,       PDO::PARAM_STR);
        $create_comment -> bindValue(':EYECATCH',    $eyecatch,    PDO::PARAM_STR);
        $create_comment -> bindValue(':TITLE',       $title,       PDO::PARAM_STR);
        $create_comment -> bindValue(':CONTENT',     $content,     PDO::PARAM_STR);
        $create_comment -> bindValue(':IP_ADDRESS',  $ip_address,  PDO::PARAM_STR);
        $create_comment -> bindValue(':POSTED_AT',   $posted_at,   PDO::PARAM_STR);
        $create_comment -> execute();
        unset($create_comment);

        // post_custom
        $sql = "SELECT id FROM {$table_prefix}comments ORDER BY id DESC LIMIT 0, 1";
        $get_new_comment = $pdo -> prepare($sql);
        $get_new_comment -> execute();
        if ($new_comment = $get_new_comment -> fetch(PDO::FETCH_ASSOC))
        {
          $affected_id = $new_comment['id'];
          unset($get_new_comment);
        }
      }
      elseif ($target_id && empty($delete_flg))
      {
        $sql = "
						UPDATE {$table_prefix}comments SET
							score       = :SCORE,
							nickname    = :NICKNAME,
							email       = :EMAIL,
							eyecatch    = :EYECATCH,
							title       = :TITLE,
							content     = :CONTENT,
							ip_address  = :IP_ADDRESS,
							updated_at  = :UPDATED_AT,
							status      = :STATUS
						WHERE id = :ID
				";
        $update_comment = $pdo->prepare($sql);
        $update_comment -> bindValue(':SCORE',       $score,       PDO::PARAM_INT);
        $update_comment -> bindValue(':NICKNAME',    $nickname,    PDO::PARAM_STR);
        $update_comment -> bindValue(':EMAIL',       $email,       PDO::PARAM_STR);
        $update_comment -> bindValue(':EYECATCH',    $eyecatch,    PDO::PARAM_STR);
        $update_comment -> bindValue(':TITLE',       $title,       PDO::PARAM_STR);
        $update_comment -> bindValue(':CONTENT',     $content,     PDO::PARAM_STR);
        $update_comment -> bindValue(':IP_ADDRESS',  $ip_address,  PDO::PARAM_STR);
        $update_comment -> bindValue(':UPDATED_AT',  $updated_at,  PDO::PARAM_STR);
        $update_comment -> bindValue(':STATUS',      2,            PDO::PARAM_INT);
        $update_comment -> bindValue(':ID',          $target_id,   PDO::PARAM_INT);
        $update_comment -> execute();
        if ($update_comment -> rowCount())
        {
          $affected_id = $target_id;
        }
        unset($update_comment);
      }
      elseif ($target_id && $delete_flg == 1)
      {
        $sql = "
						UPDATE {$table_prefix}comments SET
							updated_at  = :UPDATED_AT,
							delete_flg  = :DELETE_FLG
						WHERE
							id = :ID
							AND nickname = :NICKNAME
							AND email = :EMAIL
				";
        $update_comment = $pdo->prepare($sql);
        $update_comment -> bindValue(':UPDATED_AT', $updated_at, PDO::PARAM_STR);
        $update_comment -> bindValue(':DELETE_FLG', 1,           PDO::PARAM_INT);
        $update_comment -> bindValue(':ID',         $target_id,  PDO::PARAM_INT);
        $update_comment -> bindValue(':NICKNAME',   $nickname,   PDO::PARAM_STR);
        $update_comment -> bindValue(':EMAIL',      $email,      PDO::PARAM_STR);
        $update_comment -> execute();
        if ($update_comment -> rowCount())
        {
          $affected_id = $target_id;
        }
        unset($update_comment);
      }

      $pdo -> commit();
    }
    catch(PDOException $e)
    {
      $pdo -> rollBack();
      return false;
      //var_dump($e->getMessage());
    }
    return $affected_id;
  }
  return false;
}


/**
 * Increment counter
 * @param  number  $post_id
 * @param  number  $type (1:PV 2:UU 3:LIKE 4:UNLIKE)
 * @return number  $next_count
 */
function set_counter($post_id, $type)
{
  global $pdo;
  global $table_prefix;

  $count       = 0;
  $next_count  = 0;

  if (! empty($post_id) && ! empty($type))
  {
    $sql = "SELECT count FROM {$table_prefix}counters WHERE post_id = :POST_ID AND type = :TYPE";
    $read_item = $pdo->prepare($sql);
    $read_item -> bindValue(':POST_ID',  $post_id,  PDO::PARAM_INT);
    $read_item -> bindValue(':TYPE',     $type,     PDO::PARAM_INT);
    $read_item -> execute();
    if ($item = $read_item -> fetch(PDO::FETCH_ASSOC))
    {
      $count = $item['count'];
    }
    unset($read_item);
    $next_count = $count + 1;

    if ($next_count == 1)
    {
      $sql = "
					INSERT INTO {$table_prefix}counters
						( post_id,  type,  count,  updated_at)
					VALUES
						(:POST_ID, :TYPE, :COUNT, :UPDATED_AT)
			";
    }
    elseif ($next_count > 1)
    {
      $sql = "
					UPDATE {$table_prefix}counters SET
						count       = :COUNT,
						updated_at  = :UPDATED_AT
					WHERE post_id = :POST_ID AND type = :TYPE
			";
    }
    try {
      $pdo -> beginTransaction();
      $update_record = $pdo -> prepare($sql);
      $update_record -> bindValue(':POST_ID',     $post_id,             PDO::PARAM_INT);
      $update_record -> bindValue(':TYPE',        $type,                PDO::PARAM_INT);
      $update_record -> bindValue(':COUNT',       $next_count,          PDO::PARAM_INT);
      $update_record -> bindValue(':UPDATED_AT',  date('Y-m-d H:i:s'),  PDO::PARAM_STR);
      $update_record -> execute();
      if ($update_record -> rowCount())
      {
        unset($update_record);
      }
      $pdo -> commit();
    }
    catch(PDOException $e)
    {
      $pdo -> rollBack();
      //var_dump($e->getMessage());
    }
  }
  return $next_count;
}