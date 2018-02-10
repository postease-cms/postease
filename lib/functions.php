<?php


/**
 * Get Remoto file-size
 * @param string $uri
 * @param string $unit ('K':kilobyte, 'M':megabyte)
 * @return number | boolean false
 */
function getFileSize($uri, $unit = null)
{
	$headers = get_headers($uri, 1);
	if ((!array_key_exists("Content-Length", $headers)))
	{
		return false;
	}
	$raw_size = $headers["Content-Length"];
	if (empty($unit))
	{
		$raw_size = number_format($raw_size);
	}
	if (! empty($unit) && mb_strtolower($unit) == 'k')
	{
		$raw_size = number_format($raw_size / 1000, 1);
	}
	if (! empty($unit) && mb_strtolower($unit) == 'm')
	{
		$raw_size = number_format($raw_size / 1000000, 1);
	}
	return $raw_size;
}


/**
 * Get first key of array
 * @param  array $array
 * @return string | boolean false
 */
function firstKey($array)
{
	if (! empty($array))
	{
		reset($array);
		return key($array);
	}
	return false;
}


/**
 * Cut string for headline
 * @param  string  $string
 * @param  integer $number
 * @return string  $string | boolean false
 */
function substructString($string, $number, $continue_string = '...')
{
	(float)$number;
	if (! empty($string) && $number > 0)
	{
		$string = preg_replace('/\r\n|\r|\n/', '', html_entity_decode(strip_tags($string)));
		$strlen = mb_strlen($string, 'UTF-8');
		for($i = 0; $i < strlen($string); $i++)
		{
			if (preg_match("/[a-zA-Z0-9]/", $string[$i]))
			{
				$number += 0.32;
			}
			if (preg_match("/\./", $string[$i]))
			{
				$number += 0.8;
			}
		}
		if ($strlen > round($number))
		{
			$subtracted_string = mb_substr($string, 0, round($number), 'UTF-8') . $continue_string;
			return $subtracted_string;
		}
	}
	return $string;
}


/**
 * Exec 'preg_grep' For Key
 * @param  string $pattern
 * @param  array $haystack
 * @param  number $flags
 * @return array
 */
function pregGrepKeys($pattern, $haystack, $flags = 0)
{
	$keys = preg_grep($pattern, array_keys($haystack), $flags);
	$mutches = array();
	if (count($keys))
	{
		foreach ($keys as $key)
		{
			$mutches[$key] = $haystack[$key];
		}
	}
	return $mutches;
}


/**
 * Make Rondom key
 * @param number $length
 * @return string $random_string
 */
function makeRandomKey($length)
{
	$random_string = null;
	$alpha_head = array_merge(range('a', 'z'), array('_'));
	for ($i = 0; $i < 1; $i++)
	{
		$random_string .= $alpha_head[rand(0, count($alpha_head) - 1)];
	}
	$alpha_body = array_merge(range('a', 'z'), range('0', '9'), array('_'));
	for ($i = 0; $i < ($length - 1); $i++)
	{
		$random_string .= $alpha_body[rand(0, count($alpha_body) - 1)];
	}
	return $random_string;
}


/**
 * Make blowfish hash
 * @param  string $raw
 * @param  int    $cost
 * @return string $blowfish_hash | boolean false
 */
function blowfish($raw, $cost = 4)
{
	$chars = array_merge(range('a', 'z'), range('A', 'Z'), array('.', '/'));
	$salt = '';
	for ($i = 0; $i < 22; $i++)
	{
		$salt .= $chars[mt_rand(0, count($chars) - 1)];
	}

	$costInt = intval($cost);
	if ($costInt < 4)
	{
		$costInt = 4;
	}
	elseif ($costInt > 31)
	{
		$costInt = 31;
	}

	if ($blowfish_hash = crypt($raw, '$2a$' . sprintf('%02d', $costInt) . '$' . $salt))
	{
		return $blowfish_hash;
	}
	return false;
}


/**
 * Get Pagenation
 * @param int $this_page
 * @param int $amount_page
 * @return array $pages:
 */
function getPagenation($this_page, $amount_page, $parts_num)
{
	$omit_left_flg  = 0;
	$omit_right_flg = 0;
	$pages          = array();
	$pages_left     = array();
	$pages_right    = array();

	if ($amount_page > $parts_num)
	{
		$parts_num_left  = ceil($parts_num / 2);
		$parts_num_right = floor($parts_num / 2);
		$parts_num_half  = ceil($parts_num_left / 2);

		if ($this_page > $parts_num_left)
		{
			$omit_left_flg = 1;
			for ($i = ($this_page - $parts_num_half); $i < $this_page; $i ++)
			{
				array_push($pages_left, $i);
			}
		}
		elseif ($this_page <= $parts_num_left)
		{
			for ($i = 2; $i < $this_page; $i ++)
			{
				array_push($pages_left, $i);
			}
		}
		if ($this_page > $amount_page - $parts_num_right)
		{
			for ($i = ($this_page + 1); $i < $amount_page; $i ++)
			{
				array_push($pages_right, $i);
			}
		}
		elseif ($this_page <= $amount_page - $parts_num_right)
		{
			$omit_right_flg = 1;
			for ($i = ($this_page + 1); $i <= ($this_page + $parts_num_half); $i ++)
			{
				array_push($pages_right, $i);
			}
		}
		$pagenum_count = count($pages_left) + count($pages_right) + $omit_left_flg + $omit_right_flg;
		$shortage = ($parts_num_right + $parts_num_half) - $pagenum_count;
		if ($shortage)
		{
			if ($omit_right_flg)
			{
				$last_num = end($pages_right);
				for ($i = $last_num + 1; $i < $last_num + 1 + $shortage; $i ++)
				{
					array_push($pages_right, $i);
				}
			}
			if ($omit_left_flg)
			{
				$first_num = current($pages_left);
				for ($i = $first_num - 1; $i > $first_num  -1 - $shortage; $i --)
				{
					array_unshift($pages_left, $i);
				}
			}
		}
		if ($this_page == 1)
		{
			$last_num = end($pages_right);
			array_push($pages_right, $last_num + 1);
		}
		if ($this_page == $amount_page)
		{
			$first_num = current($pages_left);
			array_unshift($pages_left, $first_num - 1);
		}
		array_push($pages, 1);

		if ($omit_left_flg == 1) array_push($pages, 0);
		foreach ($pages_left as $value)
		{
			array_push($pages, $value);
		}
		if ($this_page != 1 && $this_page != $amount_page)array_push($pages, $this_page);
		foreach ($pages_right as $value)
		{
			array_push($pages, $value);
		}
		if ($omit_right_flg) array_push($pages, 0);
		array_push($pages, $amount_page);
	}
	else {
		for($i = 1; $i <= $amount_page; $i ++)
		{
			array_push($pages, $i);
		}
	}
	return $pages;
}


/**
 * Shape String from Multi-byte to Single-byte
 * @param string $string
 * @param string $type ['slug' / 'account']
 * @return string $return string | boolean (false)
 */
function shapeSingleByte($string, $type)
{
	$shaped_string     = null;
	$processing_string = null;
	$type_regex = array('slug' => '/^[a-z0-9_]+$/', 'account' => '/^[a-z0-9]+$/');
	if ($string)
	{
		$processing_string = str_replace(' ', '_', strtolower(mb_convert_kana($string, 'rns', 'UTF-8')));
		for ($i = 0; $i <= mb_strlen($processing_string); $i ++)
		{
			if (strlen(mb_substr($processing_string, $i, 1, 'UTF-8')) == mb_strlen(mb_substr($processing_string, $i, 1, 'UTF-8')))
			{
				if (preg_match($type_regex[$type], mb_substr($processing_string, $i, 1, 'UTF-8')))
				{
					$shaped_string .= mb_substr($processing_string, $i, 1, 'UTF-8');
				}
			}
		}
		$shaped_string = str_replace(' ', '_', $shaped_string);
	}
	if (! empty($shaped_string))
	{
		return $shaped_string;
	}
	return false;
}


/**
 * Exec 'strstr' by needle in array
 * @param string $haystack
 * @param array $array_needle
 * @return boolean
 */
function strstrArray($haystack, $array_needle)
{
	foreach($array_needle as $needle)
	{
		if(strstr($haystack, $needle)) return true;
	}
	return false;
}


/**
 * Check Datetime
 * @param string $datetime(yyyy-mm-dd hh:ii:ss)
 * @return boolean
 */
function checkDatetime($datetime)
{
	if ($datetime)
	{
		$date_time_arr = explode(' ', $datetime);
		$date = (isset($date_time_arr[0])) ? $date_time_arr[0] : null;
		$time = (isset($date_time_arr[1])) ? $date_time_arr[1] : null;
		if ($date && $time)
		{
			$date_arr = explode('-', $date);
			$year  = (isset($date_arr[0])) ? intval($date_arr[0]) : null;
			$month = (isset($date_arr[1])) ? intval($date_arr[1]) : null;
			$day   = (isset($date_arr[2])) ? intval($date_arr[2]) : null;

			if (checkdate($month, $day, $year))
			{
				$time_arr = explode(':', $time);
				$hour   = (isset($time_arr[0])) ? intval($time_arr[0]) : null;
				$minute = (isset($time_arr[1])) ? intval($time_arr[1]) : null;
				$second = (isset($time_arr[2])) ? intval($time_arr[2]) : null;

				if ($hour !== null && $hour >= 0 && $hour < 24)
				{
					if ($minute !== null && $minute >= 0 && $minute < 60)
					{
						if ($second !== null && $second >= 0 && $second < 60)
						{
							return true;
						}
					}
				}
			}
		}
	}
	return false;
}


/**
 * check live or dead remote host
 * @param string $host
 * @param number $port
 * @param number $timeout
 * @return boolean
 */
function checkLiveHost($host, $port = 80, $timeout = 4)
{
	$host = preg_replace('(https?://)', '', $host);
	if ($fsock = fsockopen($host, $port, $errno, $errstr, $timeout))
	{
		return true;
	}
	return false;
}


/**
 * Get Filelist
 * @param string $dir
 * @param string $target ['file' / 'dir' / 'both'] (default is 'file')
 * @return array $list
 */
function getFileList($dir, $target = 'file')
{
	$list = array();
	if ($dir)
	{
		$files = glob(rtrim($dir, '/') . '/*');
		foreach ($files as $file) {
			if (is_file($file)) {
				if ($target == 'file' || $target == 'both') {
					$list[] = $file;
				}
			}
			if (is_dir($file)) {
				if ($target == 'dir' || $target == 'both') {
					$list[] = $file;
				}
				$list = array_merge($list, getFileList($file, $target));
			}
		}
	}
	return $list;
}

