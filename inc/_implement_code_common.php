<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 3) ? ':' : '=>';
$comment_local_php     = TXT_CODE_COM_IMPLEMENT_LOCALPHP;
$comment_remote_php_01 = TXT_CODE_COM_IMPLEMENT_REMOTEPHP01;
$comment_remote_php_02 = TXT_CODE_COM_IMPLEMENT_REMOTEPHP02;
$comment_jquery        = TXT_CODE_COM_IMPLEMENT_JQUERY;
?>
<div id="code" class="col-md-12">
<h4><?=TXT_INDEX_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?></h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "
/*
 * {$comment_local_php}
 */
require_once '[your-postease-path]/api/local.php';

";
?>
</code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 2):?>
<?=TXT_POSTS_LNK_GETSDKPHP('https://github.com/postease-classic/sdk-php-rpc')?>

<pre><code class="language-php"><?php echo "
/*
 * {$comment_remote_php_01}
 * {$comment_remote_php_02}
 */
require_once '[your-path]/PecRpc/Pec.php';

\$pe = new Pec();

\$pe->connect('{$remote_url}/api/remote.php');

";
?>
</code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 3):?>

<pre><code class="language-php"><?php echo "
// {$comment_jquery}

";
				?>
</code></pre>
	
	<?php endif?>
</div>