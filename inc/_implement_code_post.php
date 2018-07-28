<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 3) ? ':' : '=>';
$target = ($_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_slug_flg']) ? "'" . $slug . "'" : $id;

$comment_local_php     = TXT_CODE_COM_IMPLEMENT_LOCALPHP;
$comment_remote_php_01 = TXT_CODE_COM_IMPLEMENT_REMOTEPHP01;
$comment_remote_php_02 = TXT_CODE_COM_IMPLEMENT_REMOTEPHP02;
$comment_jquery        = TXT_CODE_COM_IMPLEMENT_JQUERY;
$comment_get_post      = ($_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_slug_flg']) ? TXT_CODE_COM_IMPLEMENT_POSTCONFIGBYSLUG : TXT_CODE_COM_IMPLEMENT_POSTCONFIGBYID;

$html_title = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name'];
$html_class = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug'];
$html_code_php = htmlspecialchars("
<html>
<head>
<meta charset=\"utf-8\">
</head>
<body>
<div class=\"{$html_class}\">
  <h2><?=\$post['title']?></h2>
  <time><?=\$post['publish_date']?></time>
  <p><?=\$post['category_text']?></p>
  <div><?=\$post['content']?></div>
</div>
</body>
</html>

");

$html_code_jquery = htmlspecialchars("
<html>
<head>
<meta charset=\"utf-8\">
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
</head>
<body>
<div class=\"{$html_class}\">
  <h2 class=\"title\"></h2>
  <time class=\"publishDate\"></time>
  <p class=\"category\"></p>
  <div class=\"content\"></div>
</div>
</body>
</html>

");

?>
<div id="code" class="col-md-12">
<h4><?=TXT_POST_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?></h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "&lt;?php

// {$comment_local_php}
require_once '[your-postease-path]/api/local.php';

// {$comment_get_post}
\$post = get_post ($target);

?&gt;
";
?>
</code></pre>
<pre><code class="language-html"><?php echo $html_code_php?></code></pre>

<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 2):?>
<?=TXT_POSTS_LNK_GETSDKPHP('https://github.com/postease-classic/sdk-php-rpc')?>
  
<pre><code class="language-php"><?php echo "&lt;?php

// {$comment_remote_php_02}
require_once '[your-path]/PecRpc/Pec.php';

// {$comment_remote_php_01}
\$pe = new Pec ();
\$pe -> connect ('{$remote_url}/api/remote.php');

// {$comment_get_post}
\$post = \$pe->get_post ($target);

?&gt;
";
?>
</code></pre>
<pre><code class="language-html"><?php echo $html_code_php?></code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 3):?>

<pre><code class="language-html"><?php echo $html_code_jquery?></code></pre>
<pre><code class="language-javascript"><?php echo htmlspecialchars("
<script>
$(function()
{
  $.ajax(
  {
    url : '{$remote_url}/api/json.php?get_post',
    type : 'POST',
    data : {
      target: {$target}
    },
    dataType : 'json',
  })
  .done(function(data)
  {
    $('.title').text(data.title);
    $('.publishDate').text(data.publish_date);
    $('.category').text(data.categories_text);
    $('.content').html(data.content);
  });
});
</script>
");
?>
</code></pre>
	
<?php endif?>
</div>
