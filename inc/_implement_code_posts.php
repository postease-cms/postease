<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 3) ? ':' : '=>';

$conditions  = "\t" . "'posttype' {$delimiter} '{$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug']}',";
$conditions .= "\n" . "\t" . "'limit' {$delimiter} {$_SESSION[$session_key]['posts']['limit']},";
$conditions .= "\n" . "\t" . "'page' {$delimiter} {$_SESSION[$session_key]['posts']['page']},";
$conditions .= "\n" . "\t" . "'orderby' {$delimiter} '{$_SESSION[$session_key]['posts']['sort']}',";
if ($_SESSION[$session_key]['posts']['sc_category_id']) $conditions .= "\n" . "\t" . "'category' {$delimiter} '{$_SESSION[$session_key]['common']['categories'][$_SESSION[$session_key]['posts']['sc_category_id']]['slug']}',";
if ($_SESSION[$session_key]['posts']['sc_tag_id']) $conditions .= "\n" . "\t" . "'category' {$delimiter} '{$_SESSION[$session_key]['common']['tags'][$_SESSION[$session_key]['posts']['sc_tag_id']]['slug']}',";
if ($_SESSION[$session_key]['posts']['sc_publish_date_start']) $conditions .= "\n" . "\t" . "'date_from' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_publish_date_start']}',";
if ($_SESSION[$session_key]['posts']['sc_publish_date_end']) $conditions .= "\n" . "\t" . "'date_to' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_publish_date_end']}',";
if ($_SESSION[$session_key]['posts']['sc_text']) $conditions .= "\n" . "\t" . "'text' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_text']}',";
if ($_SESSION[$session_key]['posts']['sc_anchor']) $conditions .= "\n" . "\t" . "'anchor_equal' {$delimiter} '{$_SESSION[$session_key]['posts']['sc_anchor']}',";
if ($_SESSION[$session_key]['posts']['sc_created_by']) $conditions .= "\n" . "\t" . "'created_by' {$delimiter} {$_SESSION[$session_key]['posts']['sc_created_by']},";
?>
<div id="code" class="col-md-12">
<h4><?=TXT_POSTS_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?></h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "
\$config = [
{$conditions}
];

\$posts = get_posts(\$config);

";
				?>
</code></pre>

<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 2):?>

<pre><code class="language-php"><?php echo "
\$config = [
{$conditions}
];

\$posts = \$pe->get_posts(\$config);

";
				?>
</code></pre>

<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 3):?>

<pre><code class="language-php"><?php echo "
$(function()
{
  var config = {
  {$conditions}
  };
  
  $.ajax(
  {
    url : '{$remote_url}/api/json.php?get_posts',
    type : 'POST',
    data : config,
    dataType : 'json',
  })
  .done(data)
  {
    ...
  });
});
";
				?>
</code></pre>

<?php endif?>
</div>