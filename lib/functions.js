/*
 * Functions [for PostEase]
 * ------------------------------------------------------------------------------------------------ */
/**
 * Load Eyecatch
 */
function loadEyecatch()
{
	$check_eyecatch = 1;
	var $eyecatch_target = '/upload/' + $('#eyecatch_target').val() + '/';
	var $src = $('#eyecatch').val();
	if ($src != ''){
		$('#eyecatch_wrap figure').remove();
		if ($src.indexOf('.pdf') != -1)
		{
			var $this_object = $('#eyecatch_wrap');
			var $src_arr   = $src.split('/');
			var $uri       = $src_arr[$src_arr.length - 1];
			var $uri_arr   = $uri.split('?');
			var $file_name = $uri_arr[0];
			var $file_size = 0;
			$.ajax({
				url: 'ajax/get_filesize.php',
				type: 'post',
				data: {
					uri: $src,
					unit: 'k'
				},
				dataType: 'json',
				async: false,
			}).done(function ($response)
			{
				if ($response['result'] == '1')
				{
					$file_size = $response['filesize'];
					$this_object.prepend('<figure><img class="thumbnail" src="img/pdf_small.png"><figcaption>' + $file_name + ' (' + $file_size + 'KB)' + '</figcaption></figure>');
				}
			});
		}
		else {
			$src = $src.replace('/upload/fr_main/', $eyecatch_target);
			$('#eyecatch_wrap').prepend('<figure><img class="thumbnail" src="' + $src + '"></figure>');
		}
		$('#remove_eyecatch').removeClass('hidden');
		$('#eyecatch').val($src);
	}
	else {
		$('#eyecatch_wrap figure').remove();
	}
}


/*
 * Functions [common]
 * ------------------------------------------------------------------------------------------------ */
/**
 * Get URL parameter
 * @param string $key
 * @return string $result(value)
 */
function getParam($key)
{
    var $result = {};
    if(window.location.search.length > 1)
    {
        var $query = window.location.search.substring(1);
        var $parameters = $query.split('&');
        for( var i = 0; i < $parameters.length; i++ )
        {
            var $element     = $parameters[i].split('=');
            var $param_name  = decodeURIComponent($element[0]);
            var $param_value = decodeURIComponent($element[1]);
            $result[$param_name] = $param_value;
        }
    }
    return $result[$key];
}


/**
 * Get Page (view_page)
 * @return string view_page
 */
function getPage()
{
	var $view_page = false;
	var body = document.getElementsByTagName('body');
	if (body[0])
	{
		$view_page = body[0].getAttribute('data-view_page');
	}
	return $view_page;
}


/*
 * Make Prefix
 * @return string perfix
 */
function makePrefix()
{
  var $length = 4;
  var $char = "abcdefghijklmnopqrstuvwxyz";
  var $char_length = $char.length;
  var $string = "";
  for(var i = 0; i < $length; i ++){
    $string += $char[Math.floor(Math.random() * $char_length)];
  }
  return $string + '_';
}


/*
 * Make Password
 * @return string password
 */
function makePassword()
{
  var $length = 24;
  var $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/*-+.,!?#$%()~|_";
  var $char_length = $char.length;
  var $string = "";
  for(var i = 0; i < $length; i ++)
  {
    $string += $char[Math.floor(Math.random() * $char_length)];
  }
  return $string;
}


/*
 * Fetch URI from URL
 * @param string $url
 * @param bool $with_slash
 * @return string uri
 */
function fetchUriFromUrl ($url, $with_slash)
{
	if ($with_slash == 'undefined') $with_slash = true;
	$uri = null;
	if ($url)
	{
		$uri = $url.replace($url.match(/^https?:\/\/[^\/]+/i), '');
		if (false ===  $with_slash)
		{
			$uri = $uri.replace(/^\/+/, '');
		}
	}
	return $uri;
}