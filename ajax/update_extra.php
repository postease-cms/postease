<?php

ini_set('display_errors', 0);
ini_set('max_execution_time', 600);
ini_set('memory_limit', '512M');

require_once '../_system_header.php';

// Response Variable
$response = array();
$response['result'] = 0;


$init_source = dirname(__FILE__).'/../tinymce/tinymce_init.js';
$target_dir = dirname(__FILE__).'/../custom/tinymce/init/*';
foreach(glob($target_dir) as $init_destination)
{
  if(is_file($init_destination))
  {
    copy($init_source, $init_destination);
  }
}
$response['result'] = 1;



// Response
if ($php_version < 5.2) // for php 5.1
{
  $json = new Jsphon();
  echo($json -> encode($response));
}
else {
  echo(json_encode($response));
}
