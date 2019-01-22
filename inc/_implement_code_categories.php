<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 2) ? ':' : '=>';

$comment_remote_php_01    = TXT_CODE_COM_IMPLEMENT_REMOTEPHP01;
$comment_remote_php_02    = TXT_CODE_COM_IMPLEMENT_REMOTEPHP02;
$comment_jquery           = TXT_CODE_COM_IMPLEMENT_JQUERY;
$comment_category_config  = TXT_CODE_COM_IMPLEMENT_CATEGORIESCONFIG;
$comment_get_categories   = TXT_CODE_COM_IMPLEMENT_GETCATEGORIES;
$comment_category_title   = TXT_CODE_COM_IMPLEMENT_CATEGORYTITLE;

$conditions = null;
if ($_SESSION[$session_key]['configs']['use_multisite_flg'])
{
	if (! empty($conditions)) $conditions .= "\n";
	$conditions  .= "\t" . "'site' {$delimiter} '{$_SESSION[$session_key]['common']['sites'][$_SESSION[$session_key]['common']['this_site']]['slug']}',";
}
if ($_SESSION[$session_key]['configs']['use_posttype_flg'])
{
	if (! empty($conditions)) $conditions .= "\n";
	$conditions  .= "\t" . "'posttype' {$delimiter} '{$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug']}',";
}

$html_class = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug'];
$html_code_php = htmlspecialchars("
<html>
<head>
<meta charset=\"utf-8\">
</head>
<body>
<h3>{$comment_category_title}</h3>
<ul class=\"{$html_class}Categories\">
  <?php foreach (\$categories as \$row ):?>
  <li><a href=\"?category=<?=\$row->slug?>\"><?=\$row->label?></a></li>
  <?php endforeach ?>
</ul>
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
<h3>{$comment_category_title}</h3>
<ul class=\"{$html_class}Categories\">

</ul>
</body>
</html>

");

?>
<div id="code" class="col-md-12">
<h4>
	<?=TXT_POST_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?>
	<small>（<a href="?view_page=config_general&target=implement_code"><?=TXT_CODE_LNK_CHANGE_LANGUAGE?></a>）</small>
</h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "&lt;?php

// {$comment_remote_php_02}
require_once '[your-postease-path]/api/v3/Pec/PecHttp.php';

// {$comment_remote_php_01}
\$endpoint = '{$remote_url}/api/v3/endpoint.php';
\$pec = new PecHttp (\$endpoint);

// {$comment_category_config}
\$params = array (
{$conditions}
);

// {$comment_get_categories}
\$categories = \$pec -> set_params (\$params) -> get_categories ();

?&gt;
";
				?>
</code></pre>
<pre><code class="language-html"><?php echo $html_code_php?></code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 2):?>

<pre><code class="language-html"><?php echo $html_code_jquery?></code></pre>
<pre><code class="language-javascript"><?php echo htmlspecialchars("
<script>
$(function()
{
  // {$comment_category_config}
  var params = {
  {$conditions}
  };
  
  // {$comment_get_categories}
  $.ajax(
  {
    url : '{$remote_url}/api/v3/endpoint.php',
    type : 'GET',
    data : {
    	action: 'get_categories',
    	params: params,
    },
    dataType : 'json',
    ifModified: true,
  })
  .done(function(data)
  {
    $.each(data, function(key, row)
    {
      var html = '<li><a href=\"?category=' + row.slug + '\">' + row.label + '</li>';
      $('.{$html_class}Categories').append(html);
    });
  });
});
</script>
");
				?>
</code></pre>
	
<?php endif?>
</div>
