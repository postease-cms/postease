<?php

require_once '../../_system_header.php';

// Parameters
$target_table        = (isset($_GET['target_table']))       ? $_GET['target_table'] : null;
$this_site_id        = (isset($_GET['this_site_id']))       ? $_GET['this_site_id'] : null;
$this_posttype_id    = (isset($_GET['this_posttype_id']))   ? $_GET['this_posttype_id'] : null;
$this_id             = (isset($_GET['this_id']))            ? $_GET['this_id']            : null;
$this_permalink_uri  = (isset($_GET['this_permalink_uri'])) ? $_GET['this_permalink_uri'] : null;


// Response Variable
$response = array();
$response['result'] = 0;


/*
 * Procss Check overlap account
 * ------------------------------------------------------------------------------------------------ */
$count = 0;
if ($target_table && $this_site_id && $this_posttype_id && $this_id && $this_permalink_uri)
{
  try {
    $sql = "
				SELECT COUNT(*) AS count
				FROM {$target_table}
				WHERE
					delete_flg = 0
					AND permalink_uri = '{$this_permalink_uri}'
					AND id <> {$this_id}
					AND site_id = {$this_site_id}
					AND posttype_id = {$this_posttype_id}
		";
    $read_count = $pdo -> prepare($sql);
    $read_count -> execute();
    if ($record = $read_count -> fetch(PDO::FETCH_ASSOC))
    {
      $count = $record['count'];
    }
  }
  catch(PDOException $e)
  {
    var_dump($e -> getMessage());
    exit;
  }
  if (! $count)
  {
    $response['result'] = 1;
  }
  else {
    $response['result'] = 8;
  }
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
