<?php

/*
 * Confirmation Survival of Activation-Host
 * ------------------------------------------------------------------------------------------------ */
if (! $check_live_host = checkLiveHost($_SESSION[$session_key]['configs']['host_activation']))
{
	header('Location: ./?view_page=index&activation=9');
	exit;
}


/*
 * Make charged functions
 * ------------------------------------------------------------------------------------------------ */
$charged_functions = (string)$_SESSION[$session_key]['configs']['use_multisite_flg'] . (string)$_SESSION[$session_key]['configs']['use_posttype_flg']
					. (string)$_SESSION[$session_key]['configs']['use_multilingual_flg'] . (string)$_SESSION[$session_key]['configs']['use_group_flg'] . (string)$_SESSION[$session_key]['configs']['use_version_flg'];


/*
 * Check License
 * ------------------------------------------------------------------------------------------------ */
// Use RPC-functions
require_once dirname(__FILE__).'/../class/phprpc/phprpc_client.php';
$client = new PHPRPC_Client();
$client -> useService($_SESSION[$session_key]['configs']['host_activation'].'/inc/get_license.php');

// Check Validity
if (! $validity = $client -> checkValidity($_SESSION[$session_key]['configs']['activation_key'], $_SESSION[$session_key]['configs']['verification_key']))
{
	setcookie('tmp_login', 1, time() + 60);
	$_SESSION[$session_key] = array();
	setcookie('validity', '', time() - 1);
	header('Location: ./?view_page=login&error_code=91');
	exit;
}
else {
	setcookie('validity', 1, time() + 2592000);
	$_SESSION[$session_key]['license']['validity'] = 1;

	// Check Purchase
	$license_id = $validity;
	for ($i = 0; $i <= 100; $i ++) if ($purchase = $client -> getPurchase($license_id)) break;
	if (empty($purchase))
	{
		header('Location: ./?view_page=login&error_code=92');
		exit;
	}
	$_SESSION[$session_key]['license']['classification']     = (empty($purchase['classification']))    ? null : $purchase['classification'];
	$_SESSION[$session_key]['license']['extra_license_code'] = $purchase['extra_license_code'];
	$_SESSION[$session_key]['license']['type']               = (empty($purchase['type']))              ? 0    : $purchase['type'];
	$_SESSION[$session_key]['license']['purchase_price']     = (! isset($purchase['purchase_price']))  ? null : $purchase['purchase_price'];
	$_SESSION[$session_key]['license']['currency']           = (empty($purchase['currency']))          ? null : $purchase['currency'];
	$_SESSION[$session_key]['license']['label']              = (empty($purchase['label']))             ? null : $purchase['label'];
	$_SESSION[$session_key]['license']['valid_to']           = ($purchase['valid_to'] == '0000-00-00') ? null : $purchase['valid_to'];

	// Reset Activation-date and Charged-functions
	if (! $activation = $client -> setActivatedAt($_SESSION[$session_key]['configs']['activation_key'], $charged_functions))
	{
		header('Location: ./?view_page=login&error_code=93');
		exit;
	}

	// Check Access-domain
	$last_access = $client -> getLastAccess($_SESSION[$session_key]['configs']['activation_key']);
	$current_access = (! empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : null;
	if ($last_access != $current_access)
	{
		setcookie('tmp_login', 1, time() + 60);
		header('Location: ./?view_page=login&error_code=94');
		exit;
	}

	// Make Api License File
  $core_api_path = dirname(__FILE__) . '/../core/api';
  $core_api_license_file_name = 'license.php';
	if (false === file_exists($core_api_path)) mkdir($core_api_path);
	$license_type = $_SESSION[$session_key]['license']['type'];
  $license_params = "<?php\n\ndefine('LICENSE_TYPE', '{$license_type}');\n";
  file_put_contents($core_api_path . '/' . $core_api_license_file_name, $license_params);
}
setcookie('tmp_login', '', time() - 1);


/*
 * Reset site-options by license
 * ------------------------------------------------------------------------------------------------ */
if ($_SESSION[$session_key]['license']['extra_license_code'] == 0 &&(
		$_SESSION[$session_key]['configs']['use_multisite_flg'] == 1
		|| $_SESSION[$session_key]['configs']['use_posttype_flg'] == 1
		|| $_SESSION[$session_key]['configs']['use_multilingual_flg'] == 1
		|| $_SESSION[$session_key]['configs']['use_group_flg'] == 1
		|| $_SESSION[$session_key]['configs']['use_version_flg'] == 1
))
{
	try {
		$pdo -> beginTransaction();
		$sql = "
				UPDATE {$table_prefix}configs SET
					value = 0
				WHERE
					item IN('use_multisite_flg', 'use_posttype_flg', 'use_multilingual_flg', 'use_group_flg', 'use_version_flg')
		";
		$update_record = $pdo -> prepare($sql);
		$update_record -> execute();
		unset($update_record);
		$pdo -> commit();
	}
	catch(PDOException $e)
	{
		$pdo -> rollBack();
		header("Location: ./?view_page=index&error_code=09");
		//var_dump($e->getMessage());
		exit;
	}
	$_SESSION[$session_key]['configs']['use_multisite_flg']    = 0;
	$_SESSION[$session_key]['configs']['use_posttype_flg']     = 0;
	$_SESSION[$session_key]['configs']['use_multilingual_flg'] = 0;
	$_SESSION[$session_key]['configs']['use_group_flg']        = 0;
	$_SESSION[$session_key]['configs']['use_version_flg']      = 0;
}


/*
 * Confirmation Survival of Update-Host
 * ------------------------------------------------------------------------------------------------ */
if (! $check_live_host = checkLiveHost($_SESSION[$session_key]['configs']['host_update']))
{
	header('Location: ./?view_page=index&update=9');
	exit;
}


/*
 * For update ajax
 * ------------------------------------------------------------------------------------------------ */
$update_allowed_role = ($_SESSION[$session_key]['user']['role'] <= $_SESSION[$session_key]['configs']['update_allowed_role']) ? 1 : 0;
$update_mode         = (isset($_GET['update_mode'])) ? $_GET['update_mode'] : 0;
$client_domain       = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && ! in_array(strtolower($_SERVER['HTTPS']), array( 'off', 'no' ))) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'];
$auto_update_flg     = (! empty($_GET['update_level'])) ? 1 : $_SESSION[$session_key]['configs']['auto_update_flg'];
$check_update_level  = (empty($_GET['update_level'])) ? ($_SESSION[$session_key]['configs']['update_level'] == 3) ? 2 : $_SESSION[$session_key]['configs']['update_level'] : $_GET['update_level'];
