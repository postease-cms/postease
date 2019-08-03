<?php

require_once '../_system_header.php';

// Parameters
$domain  = (isset($_GET['domain']))  ? $_GET['domain']  : '';
$dir_name  = (isset($_GET['dir_name']))  ? $_GET['dir_name']  : '';

// Response Variable
$response = array();
$response['result'] = 0;


/*
 * Process Correct Domain
 * ------------------------------------------------------------------------------------------------ */
if ((! empty($domain) && $domain != $_SESSION[$session_key]['configs']['domain']) || ($dir_name != $_SESSION[$session_key]['configs']['dir_name']))
{
  // Cache
  resetCacheParams();

  $upload_uri_old = (empty($_SESSION[$session_key]['configs']['dir_name'])) ? $_SESSION[$session_key]['configs']['domain'] . '/upload/' : $_SESSION[$session_key]['configs']['domain'] . '/' . $_SESSION[$session_key]['configs']['dir_name'] . '/upload/';
  $upload_uri_new = (empty($dir_name)) ? $domain . '/upload/' : $domain . '/' . $dir_name . '/upload/';

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

    // update configs
    $sql = "
					UPDATE {$table_prefix}configs SET
						value = :VALUE
					WHERE item = 'domain' AND classification = 'core'
			";
    $update_record = $pdo -> prepare($sql);
    $update_record -> bindValue('VALUE', $domain);
    $update_record -> execute();
    unset($update_record);

    $sql = "
					UPDATE {$table_prefix}configs SET
						value = :VALUE
					WHERE item = 'dir_name' AND classification = 'core'
			";
    $update_record = $pdo -> prepare($sql);
    $update_record -> bindValue('VALUE', $dir_name);
    $update_record -> execute();
    unset($update_record);

    $pdo -> commit();
  }
  catch(PDOException $e)
  {
    $pdo -> rollBack();
    header("Location: ./?view_page=config_core&process=19&error_code=81");
    //var_dump($e->getMessage());
    exit;
  }
  $response['result']  = 1;
}
else {
  $response['result'] = 9;
}


// Response
if ($php_version < 5.2) // for php 5.1
{
  $json = new Jsphon();
  echo($json -> encode($response));
}
else {
  echo(json_encode($response));
}
