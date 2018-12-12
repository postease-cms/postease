<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 3) ? ':' : '=>';
$permalink_flg = (! empty($_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['rewrite_url'])) ? 1 : 0;

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
if (! empty($_SESSION[$session_key]['configs']['use_multilingual_flg']))
{
	if (! empty($conditions)) $conditions .= "\n";
	$conditions  .= "\t" . "'language' {$delimiter} '{$_SESSION[$session_key]['common']['languages'][$_SESSION[$session_key]['posts']['language']]['slug']}',";
}
if (! empty($conditions)) $conditions .= "\n";
$conditions .= "\t" . "'limit' {$delimiter} {$_SESSION[$session_key]['posts']['limit']},";
$conditions .= "\n" . "\t" . "'page' {$delimiter} {$_SESSION[$session_key]['posts']['page']},";
$conditions .= "\n" . "\t" . "'orderby' {$delimiter} '{$_SESSION[$session_key]['posts']['sort']}',";
if ($_SESSION[$session_key]['posts']['sc_category_id']) $conditions .= "\n" . "\t" . "'category' {$delimiter} '{$_SESSION[$session_key]['common']['categories'][$_SESSION[$session_key]['posts']['sc_category_id']]['slug']}',";
if ($_SESSION[$session_key]['posts']['sc_tag_id']) $conditions .= "\n" . "\t" . "'tag' {$delimiter} '{$_SESSION[$session_key]['common']['tags'][$_SESSION[$session_key]['posts']['sc_tag_id']]['slug']}',";
if ($_SESSION[$session_key]['posts']['sc_publish_date_start']) $conditions .= "\n" . "\t" . "'date_from' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_publish_date_start']}',";
if ($_SESSION[$session_key]['posts']['sc_publish_date_end']) $conditions .= "\n" . "\t" . "'date_to' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_publish_date_end']}',";
if ($_SESSION[$session_key]['posts']['sc_text']) $conditions .= "\n" . "\t" . "'text' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_text']}',";
if ($_SESSION[$session_key]['posts']['sc_anchor']) $conditions .= "\n" . "\t" . "'anchor_equal' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_anchor']}',";
if ($_SESSION[$session_key]['posts']['sc_created_by']) $conditions .= "\n" . "\t" . "'created_by' {$delimiter} {$_SESSION[$session_key]['posts']['sc_created_by']},";

$comment_local_php     = TXT_CODE_COM_IMPLEMENT_LOCALPHP;
$comment_remote_php_01 = TXT_CODE_COM_IMPLEMENT_REMOTEPHP01;
$comment_remote_php_02 = TXT_CODE_COM_IMPLEMENT_REMOTEPHP02;
$comment_jquery        = TXT_CODE_COM_IMPLEMENT_JQUERY;
$comment_posts_config  = TXT_CODE_COM_IMPLEMENT_POSTSCONFIG;
$comment_get_posts     = TXT_CODE_COM_IMPLEMENT_GETPOSTS;
$comment_render_posts  = TXT_CODE_COM_IMPLEMENT_RENDERPOSTS;

$html_title = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['name'];
$html_class = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug'];

$single_link = ($permalink_flg) ? '<h3><a href="<?=$row[\'permalink\']?>"><?=$row[\'title\']?></a></h3>' : '<h3><a href="?post_key=<?=$row[\'id\']?>"><?=$row[\'title\']?></a></h3>';

$html_code_php = htmlspecialchars("
<html>
<head>
<meta charset=\"utf-8\">
</head>
<body>
<div class=\"{$html_class}List\">
  <h2>{$html_title}</h2>
  <?php foreach (\$posts['list'] as \$row ):?>
  <div class=\"{$html_class}\">
    <figure><img src=\"<?=\$row['eyecatch']?>\"></figure>
    <time><?=\$row['publish_date']?></time>
    <p><?=\$row['category_text']?></p>
    {$single_link}
  </div>
  <?php endforeach ?>
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
<div class=\"{$html_class}List\">
  <h2>{$html_title}</h2>
  
</div>
</body>
</html>

");

?>
<div id="code" class="col-md-12">
<h4>
	<?=TXT_POSTS_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?>
	<small>（<a href="?view_page=config_general&target=implement_code"><?=TXT_CODE_LNK_CHANGE_LANGUAGE?></a>）</small>
</h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "&lt;?php

// {$comment_local_php}
require_once '[your-postease-path]/api/v2/local.php';

// {$comment_posts_config}
\$config = array (
{$conditions}
);

// {$comment_get_posts}
\$posts = get_posts (\$config);

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
\$pe -> connect ('{$remote_url}/api/v2/remote.php');

// {$comment_posts_config}
\$config = array (
{$conditions}
);

// {$comment_get_posts}
\$posts = \$pe -> get_posts (\$config);

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
  // {$comment_posts_config}
  var config = {
  {$conditions}
  };
  
  // {$comment_get_posts}
  $.ajax(
  {
    url : '{$remote_url}/api/v2/json.php?get_posts',
    type : 'POST',
    data : {
      config: config,
    },
    dataType : 'json',
  })
  .done(function(data)
  {
    // {$comment_render_posts}
    $.each(data.list, function(key, row)
    {
      var html = '<div class=\"{$html_class}\">';
      if (row.eyecatch) html += '<img src=\"' + row.eyecatch + '\">';
      html += '<time>' + row.publish_date + '</time>';
      if (row.category_text) html += '<p>' + row.category_text + '</p>';
      html += '<h3><a href=\"?post_id=' + row.id + '\">' + row.title + '</a></h3>';
      html += '</div>';
      $('.{$html_class}List').append(html);
    });
  });
});
</script>
");
				?>
</code></pre>

<?php endif?>
</div>