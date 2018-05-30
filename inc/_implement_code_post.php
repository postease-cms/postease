<?php
$remote_url = $_SESSION[$session_key]['configs']['domain'];
if ($_SESSION[$session_key]['configs']['dir_name']) $remote_url .= '/' . $_SESSION[$session_key]['configs']['dir_name'];
$delimiter = ($_SESSION[$session_key]['configs']['implement_code'] == 3) ? ':' : '=>';
$target = (! empty($slug)) ? "'" . $slug . "'" : $id;

?>
<div id="code" class="col-md-12">
<h4><?=TXT_POST_LBL_IMPLEMENT_CODE?> <?=$implement_code_list[$_SESSION[$session_key]['configs']['implement_code']]?></h4>
<?php if ($_SESSION[$session_key]['configs']['implement_code'] == 1):?>

<pre><code class="language-php"><?php echo "
\$post = get_post($target);

";
?>
</code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 2):?>
		
<pre><code class="language-php"><?php echo "
\$post = \$pe->get_post($target);

";
?>
</code></pre>
	
<?php elseif ($_SESSION[$session_key]['configs']['implement_code'] == 3):?>
		
<pre><code class="language-php"><?php echo "
$(function()
{
  $.ajax(
  {
    url : '{$remote_url}/api/json.php?get_post',
    type : 'POST',
    data : {
      target: {$target}
    }
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
