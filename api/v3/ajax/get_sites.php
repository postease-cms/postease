<?php

// Params
$config = (! empty($_GET['params'])) ? $_GET['params'] : array();

// Execute function
$response = array();
if ($cached === true)
{
	// Use cache
	$response = file_get_contents($cache_path_full);
}
else {
	// DB Access
	require_once dirname(__FILE__).'/../php/prepare.php';
	$response = get_sites($config);
	
	// Make cache file
	if (false === file_exists($cache_path)) mkdir($cache_path);
	file_put_contents($cache_path_full, json_encode($response));
}