<?php

require_once dirname(__FILE__) . '/php/response.php';
require_once dirname(__FILE__) . '/../../lib/query_functions.php';

ini_set('display_errors', 1);


// Check and Read Configs
$cache_params_path = dirname(__FILE__) . '/../../core/api';
if (file_exists($cache_params_path . '/config.php')) require_once $cache_params_path . '/config.php';
if (file_exists($cache_params_path . '/params.php'))
{
	require_once $cache_params_path . '/params.php';
}
else {
	if (false === file_exists($cache_params_path)) mkdir($cache_params_path);
	resetCacheParams(0);
}


// Generate Method
$method = null;
$resource = null;
$access_control_origin_allowed = null;
$ssr = 0;
if (! empty($_GET['action']))
{
	$method = strtolower($_GET['action']);
	$resource = preg_replace('/get_/', '', strtolower($_GET['action']));
	unset($_GET['action']);
}
if (! empty($_GET['resource']))
{
	$method = 'get_' . strtolower($_GET['resource']);
	$resource = $_GET['resource'];
	unset($_GET['resource']);
}
if (! empty($_POST['action']))
{
	$method = strtolower($_POST['action']);
	unset($_POST['action']);
}
if (! empty($_POST['resource']))
{
	$resource = strtolower($_POST['resource']);
	unset($_POST['resource']);
}
if (! empty($_REQUEST['ssr']))
{
	$ssr = strtolower($_REQUEST['ssr']);
	unset($_REQUEST['ssr']);
}


// IP Check
if (! empty($remote_address_allowed) && ! empty($ssr))
{
	$remote_addr = (! empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null;
	$remote_host = (! empty($_SERVER['REMOTE_HOST'])) ? $_SERVER['REMOTE_HOST'] : null;
	if ((! empty($remote_addr) && false === strpos($remote_address_allowed, $remote_addr)) && (! empty($remote_host) && false === strpos($remote_address_allowed, $remote_host)))
	{
    http_response_code(403);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode(responseGetIp403($resource));
    exit;
	}
}


// Origin Check
if (! empty($origin_allowed) && ! empty($_SERVER['HTTP_ORIGIN']))
{
	$access_control_origin_allowed = $_SERVER['HTTP_ORIGIN'];
	if (false === strpos($origin_allowed, preg_replace('/^(https?):\/\//', '', $_SERVER['HTTP_ORIGIN'])))
	{
		http_response_code(403);
		header('Access-Control-Allow-Origin: ' . $access_control_origin_allowed);
		header('Content-type: application/json; charset=utf-8');
		echo json_encode(responseGetOrigin403($resource));
		exit;
	}
}


// Last Modified Check (use advanced cache, PHP SSL only)
if ($resource == 'advanced_cache')
{
  $advanced_cache = array(
    'allow'         => 0,
    'last_modified' => 0,
  );
  if (file_exists($cache_params_path . '/license.php'))
  {
    require_once $cache_params_path . '/license.php';
    $advanced_cache['allow'] = LICENSE_TYPE;
  }
  $advanced_cache['last_modified'] = LAST_MODIFIED;

  // Response
  $php_version = (float)phpversion();
  if ($php_version < 5.2) // for php 5.1
  {
    // Treat json function for PHP 5.1
    require_once dirname(__FILE__).'/../../../class/Jsphon/Jsphon.php';
    $json = new Jsphon();
    echo($json -> encode($advanced_cache));
  }
  else {
    echo json_encode($advanced_cache);
  }
  exit;
}


/**
 * Cache
 * ---------------------------------------
 * cache_path_file = $cache_base_dir . '/' . $cache_target_dir . '/' . $cache_file_name . '.json'
 * @global
 *   bool $cached
 *   string $cache_base_dir
 *   string $cache_target_dir
 *   string $cache_file_name
 */

$cached = false;
$cache_params_file = dirname(__FILE__) . '/../../core/api/params.php';
$cache_base_dir    = './../../cache';
$cache_target_dir  = null;
$cache_file_name   = null;
$etag = null;

// Check Cache Dir
$cache_dir_validate = dirname(__FILE__) . '/../../cache';
if (false === file_exists($cache_dir_validate)) mkdir($cache_dir_validate);

if (! empty($method) || ! empty($resource))
{
	// Set Cache Params
	$now = time();
	$cache_file_name = hash('tiger128,4', $_SERVER['REQUEST_URI']);
	$modified = (defined('MODIFIED')) ? (int)MODIFIED : 1;
	$expires = $cache_target_dir = (defined('EXPIRES')) ? EXPIRES : '9999999999';
	$last_modified = (defined('LAST_MODIFIED')) ? LAST_MODIFIED : time();
	
	if ((int)$expires < $now)
	{
		// Reset Cache Params
		require_once dirname(__FILE__).'/php/prepare.php';
		resetCacheParams();
		require_once dirname(__FILE__) . '/../../core/api/params.php';
		$modified = (defined('MODIFIED')) ? (int)MODIFIED : 1;
		$expires = $cache_target_dir = (defined('EXPIRES')) ? EXPIRES : '9999999999';
		$last_modified = (defined('LAST_MODIFIED')) ? LAST_MODIFIED : time();
	}
	
	if ($modified === 1 || false === file_exists($cache_base_dir . '/' . $cache_target_dir))
	{
		// Initialize Cache directory
		$cache_dirs = scandir($cache_base_dir);
		foreach ($cache_dirs as $cache_dir)
		{
			if (0 === preg_match('/^[\.]{1,2}$/', $cache_dir))
			{
				$cache_files = scandir($cache_base_dir . '/' . $cache_dir);
				foreach ($cache_files as $cache_file)
				{
					if (0 === preg_match('/^[\.]{1,2}$/', $cache_file))
					{
						unlink($cache_base_dir . '/' . $cache_dir . '/' . $cache_file);
					}
				}
				rmdir($cache_base_dir . '/' . $cache_dir);
			}
		}
		// Refresh Cache Params and Make Cache target directory
		$cache_params = "<?php\n\ndefine('MODIFIED', '0');\ndefine('LAST_MODIFIED', '{$last_modified}');\ndefine('EXPIRES', '{$expires}');\n";
		file_put_contents($cache_params_file, $cache_params);
		mkdir($cache_base_dir . '/' . $cache_target_dir);
	}
	else {
		if (file_exists($cache_base_dir . '/' . $cache_target_dir . '/' . $cache_file_name . '.json'))
		{
			$cached = true;
		}
	}
	$cache_path = $cache_base_dir . '/' . $cache_target_dir;
	$cache_path_full = $cache_base_dir . '/' . $cache_target_dir . '/' . $cache_file_name . '.json';
}


// Target ajax file
$file = dirname(__FILE__) . '/ajax/' . $method . '.php';

// Execute Method and Response
if (file_exists($file))
{
	require_once $file;
	
	// Response
	$php_version = (float)phpversion();
	if ($php_version < 5.2) // for php 5.1
	{
		// Treat json function for PHP 5.1
		require_once dirname(__FILE__).'/../../../class/Jsphon/Jsphon.php';
		$json = new Jsphon();
		header("Access-Control-Allow-Origin: *");
		echo($json -> encode($response));
	}
	else {
		if ($access_control_origin_allowed)
		{
			header('Access-Control-Allow-Origin: ' . $access_control_origin_allowed);
		}
		else {
			header('Access-Control-Allow-Origin: *');
		}
		header('X-POSTEASE-API: v3');
		
		// Error Response
		if (isset($response['hasError']))
		{
			http_response_code($response['http_status_code']);
		}
		// Cache Header
		else
		{
			http_response_code(200);
			header('Content-type: application/json; charset=utf-8');
			header('Date: ' . gmdate('D, d M Y H:i:s T', $last_modified));
			if (! empty($api_force_cache_time))
			{
				$expires = time() + ($api_force_cache_time * 60);
				header('Expires: ' . gmdate('D, d M Y H:i:s T', $expires));
				header('Cache-Control: private, max-age=' . $api_force_cache_time * 60);
			}
			else {
				$etag = hash('crc32', $last_modified) . '-' . $cache_file_name;
				header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s T', $last_modified));
				header('ETag: "' . $etag . '"');
			}
			header('X-Frame-Options: 1; deny');
			header('X-XSS-Protection: 1; mode=block');
			header('X-Content-Type-Options: nosniff');
		}
		echo (is_array($response)) ? json_encode($response) : $response;
	}
}
else {
	header('HTTP/1.1 404 Not Found');
	exit;
}
