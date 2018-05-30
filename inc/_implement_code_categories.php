<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 3) ? ':' : '=>';

$conditions  = "\t" . "'posttype' {$delimiter} '{$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug']}',";
?>
<div id="code" class="col-md-12">
<h4><?=TXT_POST_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?></h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "
\$config = [
{$conditions}
];

\${$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug']}_categories = get_categories(\$config);

";
				?>
</code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 2):?>

<pre><code class="language-php"><?php echo "
\$config = [
{$conditions}
];

\${$_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['slug']}_categories = \$pe->get_categories(\$config);

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
    url : '{$remote_url}/api/json.php?get_categories',
    type : 'POST',
    data : config,
    dataType : 'json',
  })
  .done(function(data)
  {
    // your process
  });
});
";
				?>
</code></pre>
	
<?php endif?>
</div>
