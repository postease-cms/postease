<?php

// print '<pre>';
// print_r($_POST);
// print '</pre>';
// exit;

/*
 * Page Config
 * ------------------------------------------------------------------------------------------------ */
// Default
$page_main       = $PageNum -> getMain('user');
$page_sub        = $PageNum -> getSubUser('password');
$page_title_main = TXT_CHANGEPASSWORD_PAGETITLEMAIN;
$page_title_sub  = TXT_CHANGEPASSWORD_PAGETITLESUB;
$page_icon       = 'fa-user';

// Parameters
$process = (isset($_GET['process'])) ? $_GET['process'] : null;

// Parameters of process message
$process_msg       = null;
$process_msg_style = null;
$process_msg_type  = null;

/*
 * Execute Verification
 * ------------------------------------------------------------------------------------------------ */
if (isset($_POST['do_submit']))
{
  $this_id = $_SESSION[$session_key]['user']['id'];
	try
	{
		$sql = "SELECT * FROM {$table_prefix}users WHERE id = {$this_id} AND delete_flg = 0";
		$read_user = $pdo -> prepare($sql);
		$read_user -> execute();
		$user = $read_user -> fetch(PDO::FETCH_ASSOC);
		unset($read_user);
	}
	catch(PDOException $e)
	{
		$read_error = 1;
		header("Location: ./?view_page=error&page={$page}&read_error={$read_error}");
		//var_dump($e->getMessage());
		exit;
	}

	// Verification Process
	if (! empty($_POST['password_current']) && ! empty($_POST['password_new']) && ! empty($_POST['password_confirm']))
	{
		if ($_POST['password_new'] == $_POST['password_confirm'])
		{
			if ($_POST['password_new'] != $_POST['password_current'])
			{
				if (crypt($_POST['password_current'], $user['password']) === $user['password'])
				{
					// Set new nickname
          $new_account  = (! empty($_POST['account']))  ? $_POST['account']  : $_SESSION[$session_key]['user']['account'];
					$new_nickname = (! empty($_POST['nickname'])) ? $_POST['nickname'] : $_SESSION[$session_key]['user']['nickname'];

					try {
						$pdo -> beginTransaction();
						$sql = "
							UPDATE {$table_prefix}users SET
								account    = :ACCOUNT,
								nickname   = :NICKNAME,
								password   = :PASSWORD,
								updated_at = :UPDATED_AT
							WHERE id = :ID
						";
						$update_user = $pdo -> prepare($sql);
            $update_user -> bindValue('ACCOUNT',    $new_account);
						$update_user -> bindValue('NICKNAME',   $new_nickname);
						$update_user -> bindValue('PASSWORD',   blowfish($_POST['password_new']));
						$update_user -> bindValue('UPDATED_AT', date('Y-m-d H:i:s'));
						$update_user -> bindValue('ID',         $this_id);
						$update_user -> execute();
						unset($update_user);
						$pdo -> commit();
					}
					catch(PDOException $e)
					{
						$pdo -> rollBack();
						$process_msg = $errormsg_list['55'];
						$process_msg_style = 'danger';
						$process_msg_type  = 'Error';
						//var_dump($e->getMessage());
					}

          $_SESSION[$session_key]['user']['account']  = $new_account;
					$_SESSION[$session_key]['user']['nickname'] = $new_nickname;
					$process_msg = TXT_CHANGEPASSWORD_MSG_CHANGED;
					$process_msg_style = 'success';
					$process_msg_type  = '';
				}
				else {
					$process_msg = $errormsg_list['54'];
					$process_msg_style = 'danger';
					$process_msg_type  = 'Error';
				}
			}
			else {
				$process_msg = $errormsg_list['53'];
				$process_msg_style = 'danger';
				$process_msg_type  = 'Error';
			}
		}
		else {
			$process_msg = $errormsg_list['52'];
			$process_msg_style = 'danger';
			$process_msg_type  = 'Error';
		}
	}
	elseif ((! empty($_POST['account']) && $_POST['account'] != $_SESSION[$session_key]['user']['account']) || (! empty($_POST['nickname']) && $_POST['nickname'] != $_SESSION[$session_key]['user']['nickname']))
  {
    // Set new nickname
    $new_account  = $_SESSION[$session_key]['user']['account']  = (! empty($_POST['account']))  ? $_POST['account']  : $_SESSION[$session_key]['user']['account'];
    $new_nickname = $_SESSION[$session_key]['user']['nickname'] = (! empty($_POST['nickname'])) ? $_POST['nickname'] : $_SESSION[$session_key]['user']['nickname'];

    try {
      $pdo -> beginTransaction();
      $sql = "
							UPDATE {$table_prefix}users SET
								account    = :ACCOUNT,
								nickname   = :NICKNAME,
								updated_at = :UPDATED_AT
							WHERE id = :ID
						";
      $update_user = $pdo -> prepare($sql);
      $update_user -> bindValue('ACCOUNT',    $new_account);
      $update_user -> bindValue('NICKNAME',   $new_nickname);
      $update_user -> bindValue('UPDATED_AT', date('Y-m-d H:i:s'));
      $update_user -> bindValue('ID',         $this_id);
      $update_user -> execute();
      unset($update_user);
      $pdo -> commit();
    }
    catch(PDOException $e)
    {
      $pdo -> rollBack();
      $process_msg = $errormsg_list['56'];
      $process_msg_style = 'danger';
      $process_msg_type  = 'Error';
      //var_dump($e->getMessage());
    }

    $_SESSION[$session_key]['user']['account']  = $new_account;
    $_SESSION[$session_key]['user']['nickname'] = $new_nickname;
    $process_msg = TXT_CHANGEPASSWORD_MSG_CHANGED;
    $process_msg_style = 'success';
    $process_msg_type  = '';
  }
	else {
		$process_msg = $errormsg_list['51'];
		$process_msg_style = 'warning';
		$process_msg_type  = 'Error';
	}
}

//print '<pre>';
//print_r($_COOKIE);
//print '</pre>';