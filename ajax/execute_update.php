<?php

ini_set('display_errors', 0);
ini_set('max_execution_time', 600);
ini_set('memory_limit', '512M');


require_once '../_system_header.php';

// Response Variable
$response = array();
$response['result'] = 0;

// Get Parameters
$temp_dir       = (! empty($_GET['temp_dir'])) ? $_GET['temp_dir'] : null;
$target_version = (! empty($_GET['target_version'])) ? $_GET['target_version'] : null;
$update_level   = (! empty($_GET['update_level'])) ? $_GET['update_level'] : null;
$update_detail  = (! empty($_GET['update_detail'])) ? $_GET['update_detail'] : null;

// Set session
$_SESSION[$session_key]['update']['target_version'] = $target_version;
$_SESSION[$session_key]['update']['update_level']   = $update_level;
$_SESSION[$session_key]['update']['update_detail']  = $update_detail;

// Make Targets
$targets = array();
$target_file_url = $_SESSION[$session_key]['configs']['host_activation']."/update_targets/{$target_version}/targets.json";
$content = file_get_contents($target_file_url);
$result  = json_decode($content, true);
if (! empty($result))
{
  foreach ($result['targets'] as $key => $row)
  {
    foreach ($row as $local_path => $remote_path)
    {
      $targets[$key]['local_path']  = $local_path;
      $targets[$key]['remote_path'] = $remote_path;
    }
  }
}
else {
  $response['result'] = 9;
  $response['action'] = 'get target';
}


// Do Update
if (! empty($targets))
{
  $response['update_num'] = 0;
  foreach ($targets as $row)
  {
    // make new directory if don't exist
    $path_arr = explode('/', $row['local_path']);
    array_shift($path_arr);
    if (count($path_arr))
    {
      $check_dir  = dirname(__FILE__).'/../';
      foreach ($path_arr as $key => $dir)
      {
        $check_dir .= $dir . '/';
        if (! file_exists($check_dir) && ! strstr($dir, '.'))
        {
          mkdir($check_dir, 0755, true);
        }
      }
    }
    // Backup original file
    $this_file   = end($path_arr);
    $this_path   = str_replace($this_file, '', $row['local_path']);
    $backup_path = $this_path.'POSTEASEBAK_'.$this_file;
    if (file_exists($row['local_path']))
    {
      if (! rename($row['local_path'], $backup_path))
      {
        $response['result'] = 9;
        $response['action'] = 'backup';
        break;
      }
    }

    // execute update (http get)
    $target_url = $_SESSION[$session_key]['configs']['host_update'] . '/public/' . str_replace($target_version, $temp_dir, str_replace('.php', '.txt', $row['remote_path']));
    if (copy($target_url, $row['local_path']))
    {
      $response['result'] = 1;
      $response['update_num'] ++;
    }
    // can't get
    else {
      $response['result'] = 9;
      $response['action'] = 'get file';
      break;
    }
  }
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
