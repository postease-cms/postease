/**
 * Get Post Key
 * @return string $post_key
 */
function getPostKey()
{
	if ($post_key = getParam('post_key'))
	{
		return $post_key;
	}
	else {
		var $url = location.href;
		
		// hash_id (permalink_style: 1, 2)
		if ($matched = $url.match(/\/[a-f0-9]{12}$/))
		{
			return $matched[0].replace(/\//g, '');
		}
		
		// year month day slug (permalink_style: 7)
		if ($matched = $url.match(/[0-9]{4}\/[0-9]{2}\/[0-9]{2}\/[^\/]+/))
		{
			return decodeURIComponent($matched[0].replace(/\//g, '-'));
		}
		
		// year month slug (permalink_style: 8)
		if ($matched = $url.match(/[0-9]{4}\/[0-9]{2}\/[^\/]+/))
		{
			return decodeURIComponent($matched[0].replace(/\//g, '-'));
		}
		
		// id (permalink_style: 3, 4)
		if ($matched = $url.match(/\/[1-9]{1}[0-9]+$/))
		{
			return $matched[0].replace(/\//g, '');
		}
		
		// category slug or only slug (permalink_style: 5, 6)
		if ($uri = fetchUriFromUrl($url, true))
		{
			return decodeURIComponent($uri);
		}
	}
	return false;
}


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
 * New-line to br
 * @param $string
 * @returns string $string
 */
function nl2br($string)
{
	return $string.replace(/\r\n/g, '<br />').replace(/(\n|\r)/g, '<br />');
}


/**
 * Fetch URI from URL
 * @param string $url
 * @param bool $with_slash
 * @return string $uri
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
