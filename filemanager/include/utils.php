<?php
// Set Configured permission by decimal number
if (!isset($session_key, $rf_context) || !is_string($session_key)) {
    http_response_code(403);
    exit('Authentication required');
}
$permission  = (! empty($_SESSION[$session_key]['configs']['upload_dir_permission'])) ? $_SESSION[$session_key]['configs']['upload_dir_permission'] : '777';
$permission  = octdec(sprintf('%04d', $permission));

if ($_SESSION['RF']["verify"] != "RESPONSIVEfilemanager")
{
	die('forbiden');
}

require dirname(__FILE__) . '/Response.php';

/** Return the fixed language id to server-side language file mapping. */
function rf_language_files()
{
	$ids = array('az_AZ', 'bg_BG', 'ca', 'cs', 'da', 'de', 'el_GR', 'en', 'en_EN', 'es', 'fa',
		'fr_FR', 'he_IL', 'hr', 'hu_HU', 'id', 'it', 'ja', 'lt', 'mn_MN', 'nb_NO', 'nl',
		'pl', 'pt_BR', 'pt_PT', 'ru', 'sk', 'sl', 'sv_SE', 'tr_TR', 'uk_UA', 'zh_CN');
	$files = array();
	foreach ($ids as $id) {
		$files[$id] = dirname(__DIR__) . '/lang/' . $id . '.php';
	}
	$files['he'] = dirname(__DIR__) . '/lang/he_IL.php';
	return $files;
}

/** Validate a decoded-once relative path and resolve it under an approved root. */
function rf_resolve_path($root, $relative, $allow_missing, $allow_root)
{
	if (!is_string($relative) || strpos($relative, "\0") !== false || strpos($relative, '\\') !== false
		|| preg_match('/^[\\\\\/]|^[A-Za-z][A-Za-z0-9+.-]*:/', $relative)
		|| preg_match('/%(?:2e|2f|5c|00)/i', $relative)) {
		return false;
	}
    // A configured root may itself have been replaced with a link in writable storage.
    $root_absolute = substr($root, 0, 1) === '/' ? $root : getcwd() . '/' . $root;
    $root_parts = array();
    foreach (explode('/', $root_absolute) as $part) {
        if ($part === '' || $part === '.') continue;
        if ($part === '..') array_pop($root_parts); else $root_parts[] = $part;
    }
    $root_absolute = '/' . implode('/', $root_parts);
    $upload_root = dirname(dirname(__DIR__)) . '/upload';
    if ($root_absolute === $upload_root || strpos($root_absolute, $upload_root . '/') === 0) {
        $cursor = $upload_root;
        if (is_link($cursor)) return false;
        $under_upload = substr($root_absolute, strlen($upload_root));
        foreach (explode('/', trim($under_upload, '/')) as $part) {
            if ($part === '') continue;
            $cursor .= '/' . $part;
            if (is_link($cursor)) return false;
        }
    }
	$root_real = realpath($root);
	if ($root_real === false || !is_dir($root_real)) return false;
	$trimmed = rtrim($relative, '/');
	if ($trimmed === '') return $allow_root ? $root_real : false;
	$parts = explode('/', $trimmed);
	foreach ($parts as $part) {
		if ($part === '' || $part === '.' || $part === '..') return false;
	}
	$cursor = $root_real;
	$missing_parent = false;
	foreach ($parts as $index => $part) {
		$cursor .= DIRECTORY_SEPARATOR . $part;
		if ($missing_parent) continue;
		if (is_link($cursor)) return false;
		if (file_exists($cursor)) {
			if ($index < count($parts) - 1 && !is_dir($cursor)) return false;
			$real = realpath($cursor);
			if ($real === false || ($real !== $root_real && strpos($real, $root_real . DIRECTORY_SEPARATOR) !== 0)) return false;
			$cursor = $real;
		} elseif (!$allow_missing) {
			return false;
		} else {
			$missing_parent = true;
		}
	}
	return $cursor;
}

/** Resolve configured upload/derivative paths without following writable links. */
function rf_safe_upload_target($path)
{
    $upload_root = dirname(dirname(__DIR__)) . '/upload';
    $absolute_prefix = $upload_root . '/';
    if (strpos($path, '../upload/') === 0) {
        $relative = substr($path, strlen('../upload/'));
    } elseif (strpos($path, $absolute_prefix) === 0) {
        $relative = substr($path, strlen($absolute_prefix));
    } else {
        return false;
    }
    return rf_resolve_path($upload_root, $relative, true, false);
}

/** Escape a value for HTML text and quoted attributes. */
function rf_h($value)
{
	return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Encode a value as a JavaScript literal that is safe inside inline script blocks. */
function rf_js($value)
{
	$encoded = json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
	return $encoded === false ? 'null' : $encoded;
}

/** Split a client file name into its stem and its single final extension. */
function rf_split_name($name)
{
	$name = (string) $name;
	$dot = strrpos($name, '.');
	if ($dot === false || $dot === strlen($name) - 1) return array($name, '');
	return array(substr($name, 0, $dot), substr($name, $dot + 1));
}

/**
 * Normalize a server-stored file stem. Dots are replaced so the stored name keeps exactly one
 * extension, and characters that are unsafe in HTML, URLs or shells are removed.
 */
function rf_clean_name_stem($stem, $convert_spaces = false, $replace_with = '_')
{
	$stem = (string) $stem;
	$stem = preg_replace('/[\x00-\x1F\x7F]/', '', $stem);
	$stem = str_replace(array('.', '/', '\\'), '_', $stem);
	$stem = str_replace(array('<', '>', '"', "'", '&', ';', '`', '$', ':', '*', '?', '|', '%', '#'), '', $stem);
	if ($convert_spaces) $stem = str_replace(' ', $replace_with, $stem);
	$stem = trim($stem, " \t_");
	if ($stem === '' || !preg_match('/[^\s_-]/u', $stem)) $stem = 'file';
	return $stem;
}

/** Return the first bytes of a file for signature checks. */
function rf_file_head($path, $length = 512)
{
	$handle = @fopen($path, 'rb');
	if ($handle === false) return false;
	$head = fread($handle, $length);
	fclose($handle);
	return $head === false ? '' : $head;
}

/** Scan a file for embedded PHP open tags without loading it into memory at once. */
function rf_file_contains_php($path)
{
	$handle = @fopen($path, 'rb');
	if ($handle === false) return true;
	$carry = '';
	$found = false;
	while (!feof($handle)) {
		$chunk = fread($handle, 65536);
		if ($chunk === false) { $found = true; break; }
		$window = $carry . $chunk;
		if (stripos($window, '<?php') !== false || strpos($window, '<?=') !== false || stripos($window, '<script') !== false) { $found = true; break; }
		$carry = substr($window, -8);
	}
	fclose($handle);
	return $found;
}

/** Parse XML without network access or entity expansion. Returns DOMDocument or false. */
function rf_load_xml($data)
{
	$previous_errors = libxml_use_internal_errors(true);
	$previous_loader = PHP_VERSION_ID < 80000 ? libxml_disable_entity_loader(true) : null;
	$dom = new DOMDocument();
	$loaded = $dom->loadXML($data, LIBXML_NONET | LIBXML_NOCDATA);
	libxml_clear_errors();
	libxml_use_internal_errors($previous_errors);
	if ($previous_loader !== null) libxml_disable_entity_loader($previous_loader);
	return $loaded ? $dom : false;
}

/** True when the parsed document has no DOCTYPE, no processing instruction and no active element or attribute. */
function rf_dom_is_inactive($dom)
{
	if ($dom->doctype !== null) return false;
	$blocked_elements = array('script', 'foreignobject', 'iframe', 'embed', 'object', 'handler', 'audio', 'video', 'base', 'meta', 'link', 'form', 'input', 'button');
	$url_attributes = array('href', 'xlink:href', 'src', 'from', 'to', 'values', 'by', 'formaction', 'data', 'action', 'poster', 'srcset', 'xml:base', 'base');
	$stack = array($dom);
	while ($stack) {
		$node = array_pop($stack);
		foreach ($node->childNodes as $child) {
			if ($child->nodeType === XML_PI_NODE || $child->nodeType === XML_DOCUMENT_TYPE_NODE || $child->nodeType === XML_ENTITY_REF_NODE) return false;
			if ($child->nodeType !== XML_ELEMENT_NODE) continue;
			$local = strtolower($child->localName);
			if (in_array($local, $blocked_elements, true)) return false;
			if ($child->namespaceURI === 'http://www.w3.org/1999/xhtml') return false;
			if ($local === 'style' && !rf_svg_style_is_safe($child->textContent)) return false;
			foreach ($child->attributes as $attribute) {
				$attribute_name = strtolower($attribute->nodeName);
				$attribute_local = strtolower($attribute->localName);
				if (strpos($attribute_local, 'on') === 0) return false;
				if ($attribute_local === 'style' && !rf_svg_style_is_safe($attribute->value)) return false;
				if (in_array($attribute_name, $url_attributes, true) || in_array($attribute_local, $url_attributes, true)) {
					if (!rf_svg_url_is_safe($attribute->value)) return false;
				}
				if ($attribute_local === 'attributename' && in_array(strtolower(trim($attribute->value)), array('href', 'xlink:href', 'src', 'style'), true)) return false;
			}
			$stack[] = $child;
		}
	}
	return true;
}

/** Reject SVG documents that carry active content, external references or XML entities. */
function rf_svg_is_safe($path)
{
	if (!is_file($path) || filesize($path) > 10 * 1024 * 1024) return false;
	$data = file_get_contents($path);
	if ($data === false || trim($data) === '') return false;
	// Illustrator and icon-font exports carry the external W3C SVG DTD reference. It declares no entities and the
	// loader never fetches it, so this single declaration is dropped before parsing. Any other DOCTYPE is refused.
	$data = rf_svg_strip_standard_doctype($data);
	if (preg_match('/<!DOCTYPE|<!ENTITY|<\?(?!xml[\s?])/i', $data)) return false;
	if (stripos($data, '<?php') !== false || strpos($data, '<?=') !== false) return false;
	$dom = rf_load_xml($data);
	if ($dom === false || !$dom->documentElement || strtolower($dom->documentElement->localName) !== 'svg') return false;
	return rf_dom_is_inactive($dom);
}

/**
 * Remove one external-only W3C SVG DOCTYPE that sits in the prolog (after the XML declaration and comments only).
 * Public and system identifiers must form a known W3C pair, whitespace is limited to the XML set, and the
 * declaration may not carry an internal subset. The declaration is replaced by one space; otherwise the data is returned unchanged.
 */
function rf_svg_strip_standard_doctype($data)
{
	$ws = '[\x20\x09\x0D\x0A]';
	$pairs = array(
		'-//W3C//DTD SVG 1.0//EN' => 'http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd',
		'-//W3C//DTD SVG 20010904//EN' => 'http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd',
		'-//W3C//DTD SVG 1.1//EN' => 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd',
		'-//W3C//DTD SVG 1.1 Tiny//EN' => 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-tiny.dtd',
		'-//W3C//DTD SVG 1.1 Basic//EN' => 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-basic.dtd',
	);
	$pos = strncmp($data, "\xEF\xBB\xBF", 3) === 0 ? 3 : 0;
	$length = strlen($data);
	// The XML declaration may appear only once, at the very start, and ends at its first closing delimiter.
	if (substr($data, $pos, 5) === '<?xml' && preg_match('/^' . $ws . '/', (string) substr($data, $pos + 5, 1))) {
		$close = strpos($data, '?>', $pos);
		if ($close === false) return $data;
		$pos = $close + 2;
	}
	// Comments and whitespace are consumed token by token; the first "-->" always closes a comment.
	while ($pos < $length) {
		if (preg_match('/\G' . $ws . '+/', $data, $m, 0, $pos)) { $pos += strlen($m[0]); continue; }
		if (substr($data, $pos, 4) === '<!--') {
			$close = strpos($data, '-->', $pos + 4);
			if ($close === false) return $data;
			$pos = $close + 3;
			continue;
		}
		break;
	}
	$pattern = '/\G<!DOCTYPE' . $ws . '+svg' . $ws . '+PUBLIC' . $ws . '+"([^"]*)"' . $ws . '+"([^"]*)"' . $ws . '*>/';
	if (!preg_match($pattern, $data, $m, 0, $pos)) return $data;
	if (!isset($pairs[$m[1]]) || $pairs[$m[1]] !== $m[2]) return $data;
	// Replace with one XML space instead of deleting: a BOM or XML declaration that followed the declaration stays
	// out of the document start, so data that did not parse before still does not parse.
	return substr($data, 0, $pos) . ' ' . substr($data, $pos + strlen($m[0]));
}

/** Generic XML uploads must parse and must not smuggle XHTML, scripts or processing instructions. */
function rf_xml_is_safe($path)
{
	if (!is_file($path) || filesize($path) > 10 * 1024 * 1024) return false;
	$data = file_get_contents($path);
	if ($data === false || trim($data) === '') return false;
	if (stripos($data, '<?php') !== false || strpos($data, '<?=') !== false) return false;
	$dom = rf_load_xml($data);
	if ($dom === false) return false;
	return rf_dom_is_inactive($dom);
}

/** References inside SVG may only use same-document fragments, raster data URLs or http(s). */
function rf_svg_url_is_safe($value)
{
	$value = strtolower(preg_replace('/[\s\x00-\x1F\x7F]+/', '', (string) $value));
	if (preg_match('#^data:image/(png|jpe?g|gif|webp);base64,[a-z0-9+/=]*$#', $value)) return true;
	foreach (explode(';', $value) as $candidate) {
		if ($candidate === '' || $candidate[0] === '#') continue;
		if (preg_match('/^[a-z][a-z0-9+.-]*:/', $candidate, $scheme) && !in_array(rtrim($scheme[0], ':'), array('http', 'https'), true)) return false;
		if (strpos($candidate, '&#') !== false || strpos($candidate, '\\') !== false) return false;
	}
	return true;
}

/** Encode a code point as UTF-8 without relying on mbstring. */
function rf_utf8_chr($code)
{
	if ($code < 0x80) return chr($code);
	if ($code < 0x800) return chr(0xC0 | ($code >> 6)) . chr(0x80 | ($code & 0x3F));
	if ($code < 0x10000) return chr(0xE0 | ($code >> 12)) . chr(0x80 | (($code >> 6) & 0x3F)) . chr(0x80 | ($code & 0x3F));
	return chr(0xF0 | ($code >> 18)) . chr(0x80 | (($code >> 12) & 0x3F)) . chr(0x80 | (($code >> 6) & 0x3F)) . chr(0x80 | ($code & 0x3F));
}

/** Resolve CSS escapes (\69 -> i, \: -> :) so keyword checks see the effective text. */
function rf_css_unescape($css)
{
	$css = preg_replace_callback('/\\\\([0-9a-fA-F]{1,6})\s?/', function ($m) {
		$code = hexdec($m[1]);
		return $code > 0 && $code < 0x110000 ? rf_utf8_chr($code) : '';
	}, (string) $css);
	return preg_replace('/\\\\(.)/su', '$1', $css);
}

/** Inline CSS inside an SVG must not import, bind or load external resources. */
function rf_svg_style_is_safe($css)
{
	$css = rf_css_unescape((string) $css);
	$css = strtolower(preg_replace('/[\s\x00-\x1F\x7F]+/', '', $css));
	if (strpos($css, '\\') !== false) return false;
	if (preg_match('/expression\(|javascript:|vbscript:|@import|behavior:|-moz-binding|<\/?script/', $css)) return false;
	if (preg_match_all('/url\((["\']?)(.*?)\1\)/', $css, $urls)) {
		foreach ($urls[2] as $url) {
			if (!rf_svg_url_is_safe($url)) return false;
		}
	}
	return true;
}

/** Shared acceptance rule for every path that creates files in the upload area (upload, archive extraction). */
function rf_upload_accepts($path, $extension, $ext, $ext_upload_denied, $ext_img)
{
	$extension = strtolower((string) $extension);
	if ($extension === '' || !in_array($extension, $ext, true)) return false;
	if (is_array($ext_upload_denied) && in_array($extension, $ext_upload_denied, true)) return false;
	return rf_upload_content_valid($path, $extension, $ext_img);
}

/** Extensions whose original (cleaned) name is kept; other uploads receive a generated name. */
function rf_name_keeping_extensions()
{
	return array('pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'rtf',
		'odt', 'ods', 'odp', 'ott', 'ots', 'otp', 'odg', 'otg', 'odf', 'odb',
		'mp4', 'm4v', 'webm', 'mov', 'flv', 'avi', 'mpeg', 'mpg', 'wma');
}

/** Stored stem shared by uploads and archive extraction: images get generated names, approved documents keep a cleaned name. */
function rf_stored_stem($original_stem, $extension, $convert_spaces, $replace_with)
{
	if (in_array(strtolower((string) $extension), rf_name_keeping_extensions(), true)) {
		return rf_clean_name_stem($original_stem, $convert_spaces, $replace_with);
	}
	return dechex(time()) . '-' . hash('crc32', uniqid(rand()));
}

/**
 * Atomically reserve a free file name in $dir by creating it exclusively, so two concurrent
 * uploads can never select the same name. Returns the reserved base name or false.
 */
function rf_claim_upload_name($dir, $stem, $extension)
{
	$dir = rtrim($dir, '/') . '/';
	for ($i = 0; $i <= 1000; $i++) {
		$candidate = $stem . ($i === 0 ? '' : '_' . $i) . '.' . $extension;
		if (file_exists($dir . $candidate) || is_link($dir . $candidate)) continue;
		$handle = @fopen($dir . $candidate, 'xb');
		if ($handle !== false) {
			fclose($handle);
			return $candidate;
		}
	}
	return false;
}

/**
 * Verify that the uploaded content matches the claimed extension. The browser-declared MIME type
 * is never consulted. Extensions without a binary signature are scanned for embedded PHP tags.
 */
function rf_upload_content_valid($path, $extension, $ext_img)
{
	$extension = strtolower((string) $extension);
	if (!is_file($path)) return false;
	$head = rf_file_head($path, 512);
	if ($head === false) return false;
	$raster = array('jpg' => array(IMAGETYPE_JPEG), 'jpeg' => array(IMAGETYPE_JPEG), 'png' => array(IMAGETYPE_PNG),
		'gif' => array(IMAGETYPE_GIF), 'bmp' => array(IMAGETYPE_BMP), 'tiff' => array(IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM),
		'tif' => array(IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM), 'webp' => array(IMAGETYPE_WEBP));
	if ($extension === 'svg') return rf_svg_is_safe($path);
	if ($extension === 'xml') return rf_xml_is_safe($path);
	if (isset($raster[$extension])) {
		$size = @getimagesize($path);
		if (!is_array($size) || !isset($size[2]) || !in_array($size[2], $raster[$extension], true) || $size[0] <= 0 || $size[1] <= 0) return false;
		// Damaged raster data with a valid header is refused before it is moved; TIFF has no GD decoder.
		if (function_exists('imagecreatefromstring') && !in_array($extension, array('tiff', 'tif'), true)) {
			try {
				$decoded = @imagecreatefromstring(file_get_contents($path));
			} catch (Throwable $decode_failure) {
				$decoded = false;
			}
			if ($decoded === false) return false;
			if (is_resource($decoded) || is_object($decoded)) imagedestroy($decoded);
		}
		return true;
	}
	if (in_array($extension, $ext_img, true)) return false;
	$signatures = array(
		'pdf' => array('%PDF-'), 'ai' => array('%PDF-', '%!PS'),
		'zip' => array("PK\x03\x04", "PK\x05\x06"), 'docx' => array("PK\x03\x04"), 'xlsx' => array("PK\x03\x04"), 'pptx' => array("PK\x03\x04"),
		'odt' => array("PK\x03\x04"), 'ods' => array("PK\x03\x04"), 'odp' => array("PK\x03\x04"), 'ott' => array("PK\x03\x04"), 'ots' => array("PK\x03\x04"),
		'otp' => array("PK\x03\x04"), 'odg' => array("PK\x03\x04"), 'otg' => array("PK\x03\x04"), 'odf' => array("PK\x03\x04"), 'odb' => array("PK\x03\x04"),
		'doc' => array("\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1"), 'xls' => array("\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1"), 'ppt' => array("\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1"),
		'mdb' => array("\x00\x01\x00\x00Standard Jet DB"), 'accdb' => array("\x00\x01\x00\x00Standard ACE DB"),
		'rtf' => array('{\\rtf'), 'psd' => array('8BPS'), 'fla' => array("\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1", 'PK'),
		'rar' => array("Rar!\x1A\x07"), 'gz' => array("\x1F\x8B"), 'webm' => array("\x1A\x45\xDF\xA3"), 'flv' => array('FLV'),
		'mpeg' => array("\x00\x00\x01\xBA", "\x00\x00\x01\xB3"), 'mpg' => array("\x00\x00\x01\xBA", "\x00\x00\x01\xB3"),
		'wma' => array("\x30\x26\xB2\x75"), 'mp3' => array('ID3', "\xFF\xFB", "\xFF\xF3", "\xFF\xF2", "\xFF\xFA"),
		'ogg' => array('OggS'), 'mid' => array('MThd'), 'aiff' => array('FORM'), 'ac3' => array("\x0B\x77"),
	);
	if (isset($signatures[$extension])) {
		foreach ($signatures[$extension] as $signature) {
			if (strpos($head, $signature) === 0) return true;
		}
		return false;
	}
	if (in_array($extension, array('mp4', 'm4v', 'mov', 'm4a'), true)) {
		return strlen($head) >= 12 && in_array(substr($head, 4, 4), array('ftyp', 'moov', 'mdat', 'wide', 'free', 'skip', 'pnot'), true);
	}
	if (in_array($extension, array('avi', 'wav'), true)) {
		return strpos($head, 'RIFF') === 0 && substr($head, 8, 4) === ($extension === 'avi' ? 'AVI ' : 'WAVE');
	}
	if ($extension === 'tar') {
		$block = rf_file_head($path, 512);
		return strlen($block) === 512 && substr($block, 257, 5) === 'ustar';
	}
	// Text-like and unrecognized binary formats: refuse embedded PHP or script markup.
	return !rf_file_contains_php($path);
}

function rf_relative_from_root($path, $root)
{
	$root_real = realpath($root);
	$path_real = realpath($path);
	if ($root_real === false || $path_real === false
		|| strpos($path_real, $root_real . DIRECTORY_SEPARATOR) !== 0) return false;
	return substr($path_real, strlen($root_real) + 1);
}

function rf_tree_has_no_links($path)
{
	if (is_link($path)) return false;
	if (!file_exists($path)) return true;
	if (!is_dir($path)) return is_file($path);
	$items = scandir($path);
	if ($items === false) return false;
	foreach ($items as $item) {
		if ($item !== '.' && $item !== '..' && !rf_tree_has_no_links($path . DIRECTORY_SEPARATOR . $item)) return false;
	}
	return true;
}

function rf_tree_can_copy($source, $destination)
{
	if (!file_exists($source) && !is_link($source)) return true;
	if (!rf_tree_has_no_links($source)) return false;
	if (is_dir($source)) {
		$target = rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($source);
		if (file_exists($target) || is_link($target)) return false;
		$items = scandir($source);
		if ($items === false) return false;
		foreach ($items as $item) {
			if ($item !== '.' && $item !== '..' && !rf_tree_can_copy($source . DIRECTORY_SEPARATOR . $item, $target)) return false;
		}
		return true;
	}
	$target = is_dir($destination) ? rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($source) : $destination;
	return !file_exists($target) && !is_link($target);
}

function rf_validate_zip_entries($zip, $destination_root)
{
	$entries = array();
	$seen = array();
	for ($i = 0; $i < $zip->numFiles; $i++) {
		$stat = $zip->statIndex($i);
		$name = isset($stat['name']) ? $stat['name'] : '';
		$is_dir = substr($name, -1) === '/';
		$relative = $is_dir ? rtrim($name, '/') : $name;
		$opsys = 0; $attributes = 0;
		if ($name === '' || strpos($name, '\\') !== false || strpos($name, "\0") !== false
			|| rf_resolve_path($destination_root, $relative, true, false) === false
			|| isset($seen[$relative])
			|| !$zip->getExternalAttributesIndex($i, $opsys, $attributes)) return false;
		$mode = ($attributes >> 16) & 0170000;
		if ($mode !== 0 && $mode !== 0100000 && $mode !== 0040000) return false;
		if (!$is_dir && $mode === 0040000) return false;
		$parts = explode('/', $relative);
		$prefix = '';
		foreach ($parts as $part) {
			$prefix = ($prefix === '' ? $part : $prefix . '/' . $part);
			if ($prefix !== $relative && isset($seen[$prefix]) && $seen[$prefix] === 'file') return false;
		}
		if (!$is_dir) {
			foreach ($seen as $seen_path => $type) {
				if (strpos($seen_path, $relative . '/') === 0) return false;
			}
		}
		$target = rf_resolve_path($destination_root, $relative, true, false);
		if ($target === false || file_exists($target) || is_link($target)) return false;
		$seen[$relative] = $is_dir ? 'dir' : 'file';
		$entries[] = array('name' => $name, 'relative' => $relative, 'dir' => $is_dir);
	}
	return $entries;
}

if ( ! function_exists('response'))
{
	/**
	 * Response construction helper
	 *
	 * @param string $content
	 * @param int    $statusCode
	 * @param array  $headers
	 *
	 * @return \Response|\Illuminate\Http\Response
	 */
	function response($content = '', $statusCode = 200, $headers = array())
	{
		$responseClass = class_exists('Illuminate\Http\Response') ? '\Illuminate\Http\Response' : 'Response';

		return new $responseClass($content, $statusCode, $headers);
	}
}

if ( ! function_exists('trans'))
{
	// language
	$language_files = rf_language_files();
	if (!isset($_SESSION['RF']['language']) || !is_string($_SESSION['RF']['language'])
		|| !isset($language_files[$_SESSION['RF']['language']])
		|| !isset($_SESSION['RF']['language_file'])
		|| $_SESSION['RF']['language_file'] !== $language_files[$_SESSION['RF']['language']]
		|| !is_readable($language_files[$_SESSION['RF']['language']]))
	{
		$lang = $default_language;

		if ($rf_can_maintain && isset($_GET['lang']) && is_string($_GET['lang']) && $_GET['lang'] != 'undefined' && $_GET['lang'] != '')
		{
			$candidate = trim(fix_get_params($_GET['lang']));
			if (isset($language_files[$candidate])) $lang = $candidate;
		}
		if (!isset($language_files[$lang])) $lang = isset($language_files[$default_language]) ? $default_language : 'en';
		$language_file = $language_files[$lang];

		// add lang file to session for easy include
		$_SESSION['RF']['language'] = $lang;
		$_SESSION['RF']['language_file'] = $language_file;
	}
	else
	{
		$lang = $_SESSION['RF']['language'];
		$language_file = $language_files[$lang];
	}

	$lang_vars = include $language_file;

	if ( ! is_array($lang_vars))
	{
		$lang_vars = array();
	}
	/**
	 * Translate language variable
	 *
	 * @param $var string name
	 *
	 * @return string translated variable
	 */
	function trans($var)
	{
		global $lang_vars;

		return (array_key_exists($var, $lang_vars)) ? $lang_vars[ $var ] : $var;
	}
}

/**
 * Delete directory
 *
 * @param  string  $dir
 *
 * @return  bool
 */
function deleteDir($dir)
{
	if (is_link($dir)) return unlink($dir);
	if ( ! file_exists($dir))
	{
		return true;
	}
	if ( ! is_dir($dir))
	{
		return unlink($dir);
	}
	foreach (scandir($dir) as $item)
	{
		if ($item == '.' || $item == '..')
		{
			continue;
		}
		$child = $dir . DIRECTORY_SEPARATOR . $item;
		if (is_link($child) ? !unlink($child) : !deleteDir($child))
		{
			return false;
		}
	}

	return rmdir($dir);
}

/**
 * Make a file copy
 *
 * @param  string  $old_path
 * @param  string  $name      New file name without extension
 *
 * @return  bool
 */
function duplicate_file($old_path, $name)
{
	if (file_exists($old_path))
	{
		$info = pathinfo($old_path);

		// fix code for php 5.1
		if (empty($info['filename']))
		{
			if (! empty($info['extension']))
			{
				$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
			}
			else {
				$info['filename'] = $info['basename'];
			}
		}

		$new_path = $info['dirname'] . "/" . $name . "." . $info['extension'];
		if (rf_safe_upload_target($old_path) === false || rf_safe_upload_target($new_path) === false
            || file_exists($new_path) || is_link($new_path))
		{
			return false;
		}

		return copy($old_path, $new_path);
	}
}

/**
 * Rename file
 *
 * @param  string  $old_path         File to rename
 * @param  string  $name             New file name without extension
 * @param  bool    $transliteration
 *
 * @return bool
 */
function rename_file($old_path, $name, $transliteration)
{
	$name = fix_filename($name, $transliteration);
	if (file_exists($old_path))
	{
		$info = pathinfo($old_path);

		// fix code for php 5.1
		if (empty($info['filename']))
		{
			if (! empty($info['extension']))
			{
				$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
			}
			else {
				$info['filename'] = $info['basename'];
			}
		}

		$new_path = $info['dirname'] . "/" . $name . "." . $info['extension'];
		if (rf_safe_upload_target($old_path) === false || rf_safe_upload_target($new_path) === false
            || file_exists($new_path) || is_link($new_path))
		{
			return false;
		}

		return rename($old_path, $new_path);
	}
}

/**
 * Rename directory
 *
 * @param  string  $old_path         Directory to rename
 * @param  string  $name             New directory name
 * @param  bool    $transliteration
 *
 * @return bool
 */
function rename_folder($old_path, $name, $transliteration)
{
	$name = fix_filename($name, $transliteration, false, '_', true);
	if (file_exists($old_path))
	{
		$new_path = fix_dirname($old_path) . "/" . $name;
		if (rf_safe_upload_target($old_path) === false || rf_safe_upload_target($new_path) === false
            || file_exists($new_path) || is_link($new_path))
		{
			return false;
		}

		return rename($old_path, $new_path);
	}
}

/**
 * Create new image from existing file
 *
 * @param  string  $imgfile    Source image file name
 * @param  string  $imgthumb   Thumbnail file name
 * @param  int     $newwidth   Thumbnail width
 * @param  int     $newheight  Optional thumbnail height
 * @param  string  $option     Type of resize
 *
 * @return bool
 * @throws \Exception
 */
function create_img($imgfile, $imgthumb, $newwidth, $newheight = null, $option = "crop")
{
    if (rf_safe_upload_target($imgfile) === false || rf_safe_upload_target($imgthumb) === false) return false;
	$timeLimit = ini_get('max_execution_time');
	set_time_limit(30);
	$result = false;
	
	// SVGファイルかどうかを確認
	$file_extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
	
	if ($file_extension === 'svg') {
		// SVGファイルの場合は単純にコピー
		$result = copy($imgfile, $imgthumb);
	} else {
	
		if (image_check_memory_usage($imgfile, $newwidth, $newheight))
		{
			require_once('php_image_magician.php');
			$magicianObj = new imageLib($imgfile);
			$magicianObj->resizeImage($newwidth, $newheight, $option);
			$magicianObj->saveImage($imgthumb, 80);
			$result = true;
		}
	}
	set_time_limit($timeLimit);

	return $result;
}

/**
 * Convert convert size in bytes to human readable
 *
 * @param  int  $size
 *
 * @return  string
 */
function makeSize($size)
{
	$units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
	$u = 0;
	while ((round($size / 1024) > 0) && ($u < 4))
	{
		$size = $size / 1024;
		$u++;
	}

	return (number_format($size, 0) . " " . $units[ $u ]);
}

/**
 * Determine directory size
 *
 * @param  string  $path
 *
 * @return  int
 */
function foldersize($path)
{
    if (is_link($path)) return 0;
	$total_size = 0;
	$files = scandir($path);
	$cleanPath = rtrim($path, '/') . '/';

	foreach ($files as $t)
	{
		if ($t != "." && $t != "..")
		{
			$currentFile = $cleanPath . $t;
			if (is_dir($currentFile))
			{
				$size = foldersize($currentFile);
				$total_size += $size;
			}
			else
			{
				$size = filesize($currentFile);
				$total_size += $size;
			}
		}
	}

	return $total_size;
}

/**
 * Get number of files in a directory
 *
 * @param  string  $path
 *
 * @return  int
 */
function filescount($path)
{
    if (is_link($path)) return 0;
	$total_count = 0;
	$files = scandir($path);
	$cleanPath = rtrim($path, '/') . '/';

	foreach ($files as $t)
	{
		if ($t != "." && $t != "..")
		{
			$currentFile = $cleanPath . $t;
			if (is_dir($currentFile))
			{
				$size = filescount($currentFile);
				$total_count += $size;
			}
			else
			{
				$total_count += 1;
			}
		}
	}

	return $total_count;
}

/**
 * Create directory for images and/or thumbnails
 *
 * @param  string  $path
 * @param  string  $path_thumbs
 */
function create_folder($path = null, $path_thumbs = null)
{
	global $permission;
    foreach (array($path, $path_thumbs) as $candidate) {
        if ($candidate && rf_safe_upload_target($candidate) === false) { response('wrong path', 400)->send(); exit; }
    }

	$oldumask = umask(0);
	if ($path && ! file_exists($path))
	{
		mkdir($path, $permission, true);
	} // or even 01777 so you get the sticky bit set
	if ($path_thumbs && ! file_exists($path_thumbs))
	{
		mkdir($path_thumbs, $permission, true) or die("$path_thumbs cannot be found");
	} // or even 01777 so you get the sticky bit set
	umask($oldumask);
}

/**
 * Get file extension present in directory
 *
 * @param  string  $path
 * @param  string  $ext
 */
function check_files_extensions_on_path($path, $ext)
{
	if ( ! is_dir($path))
	{
		$fileinfo = pathinfo($path);

		// fix code for php 5.1
		if (empty($fileinfo['filename']))
		{
			if (! empty($fileinfo['extension']))
			{
				$fileinfo['filename'] = str_replace('.'.$fileinfo['extension'], '', $fileinfo['basename']);
			}
			else {
				$fileinfo['filename'] = $fileinfo['basename'];
			}
		}

		if ( ! in_array(mb_strtolower($fileinfo['extension']), $ext))
		{
			unlink($path);
		}
	}
	else
	{
		$files = scandir($path);
		foreach ($files as $file)
		{
			check_files_extensions_on_path(trim($path, '/') . "/" . $file, $ext);
		}
	}
}

/**
 * Get file extension present in PHAR file
 *
 * @param  string  $phar
 * @param  array   $files
 * @param  string  $basepath
 * @param  string  $ext
 */
function check_files_extensions_on_phar($phar, &$files, $basepath, $ext)
{
	foreach ($phar as $file)
	{
		if ($file->isFile())
		{
			if (in_array(mb_strtolower($file->getExtension()), $ext))
			{
				$files[] = $basepath . $file->getFileName();
			}
		}
		else
		{
			if ($file->isDir())
			{
				$iterator = new DirectoryIterator($file);
				check_files_extensions_on_phar($iterator, $files, $basepath . $file->getFileName() . '/', $ext);
			}
		}
	}
}

/**
 * Cleanup input
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_get_params($str)
{
	return strip_tags(preg_replace("/[^a-zA-Z0-9\.\[\]_| -]/", '', $str));
}

/**
 * Cleanup filename
 *
 * @param  string  $str
 * @param  bool    $transliteration
 * @param  bool    $convert_spaces
 * @param  string  $replace_with
 * @param  bool    $is_folder
 *
 * @return string
 */
function fix_filename($str, $transliteration, $convert_spaces = false, $replace_with = "_", $is_folder = false)
{
	if ($convert_spaces)
	{
		$str = str_replace(' ', $replace_with, $str);
	}

	if ($transliteration)
	{
		if (function_exists('transliterator_transliterate'))
		{
			 $str = transliterator_transliterate('Accents-Any', utf8_encode($str));
		}
		else
		{
			$str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
		}

		$str = preg_replace("/[^a-zA-Z0-9\.\[\]_| -]/", '', $str);
	}

	$str = str_replace(array( '"', "'", "/", "\\" ), "", $str);
	$str = strip_tags($str);

	// Empty or incorrectly transliterated filename.
	// Here is a point: a good file UNKNOWN_LANGUAGE.jpg could become .jpg in previous code.
	// So we add that default 'file' name to fix that issue.
	if (strpos($str, '.') === 0 && $is_folder === false)
	{
		$str = 'file' . $str;
	}

	return trim($str);
}

/**
 * Cleanup directory name
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_dirname($str)
{
	return str_replace('~', ' ', dirname(str_replace(' ', '~', $str)));
}

/**
 * Correct strtoupper handling
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_strtoupper($str)
{
	if (function_exists('mb_strtoupper'))
	{
		return mb_strtoupper($str);
	}
	else
	{
		return strtoupper($str);
	}
}

/**
 * Correct strtolower handling
 *
 * @param  string  $str
 *
 * @return  string
 */
function fix_strtolower($str)
{
	if (function_exists('mb_strtoupper'))
	{
		return mb_strtolower($str);
	}
	else
	{
		return strtolower($str);
	}
}

function fix_path($path, $transliteration, $convert_spaces = false, $replace_with = "_")
{
	$info = pathinfo($path);

	// fix code for php 5.1
	if (empty($info['filename']))
	{
		if (! empty($info['extension']))
		{
			$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
		}
		else {
			$info['filename'] = $info['basename'];
		}
	}

	$tmp_path = $info['dirname'];
	if (empty($info['filename'])) $info['filename'] = $info['basename']; // fix code for php 5.1
	$str = fix_filename($info['filename'], $transliteration, $convert_spaces, $replace_with);
	if ($tmp_path != "")
	{
		return $tmp_path . DIRECTORY_SEPARATOR . $str;
	}
	else
	{
		return $str;
	}
}

/**
 * Get current base url
 *
 * @return  string
 */
function base_url()
{
	return sprintf(
		"%s://%s",
		isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		$_SERVER['HTTP_HOST']
	);
}

/**
 * @param  $current_path
 * @param  $fld
 *
 * @return  bool
 */
function config_loading($current_path, $fld)
{
    // Upload directories are data only; never execute per-directory PHP configuration.
    return false;
}


/**
 * Check if memory is enough to process image
 *
 * @param  string  $img
 * @param  int     $max_breedte
 * @param  int     $max_hoogte
 *
 * @return bool
 */
function image_check_memory_usage($img, $max_breedte, $max_hoogte)
{
	if (file_exists($img))
	{
		$K64 = 65536; // number of bytes in 64K
		$memory_usage = memory_get_usage();
		$memory_limit = abs(intval(str_replace('M', '', ini_get('memory_limit')) * 1024 * 1024));
		$image_properties = getimagesize($img);
		$image_width = $image_properties[0];
		$image_height = $image_properties[1];
		$image_bits = $image_properties['bits'];
		$image_memory_usage = $K64 + ($image_width * $image_height * ($image_bits) * 2);
		$thumb_memory_usage = $K64 + ($max_breedte * $max_hoogte * ($image_bits) * 2);
		$memory_needed = intval($memory_usage + $image_memory_usage + $thumb_memory_usage);

		if ($memory_needed > $memory_limit)
		{
			ini_set('memory_limit', (intval($memory_needed / 1024 / 1024) + 5) . 'M');
			if (ini_get('memory_limit') == (intval($memory_needed / 1024 / 1024) + 5) . 'M')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}

/**
 * Check is string is ended with needle
 *
 * @param  string  $haystack
 * @param  string  $needle
 *
 * @return  bool
 */
function endsWith($haystack, $needle)
{
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

/**
 * TODO REFACTOR THIS!
 *
 * @param $targetPath
 * @param $targetFile
 * @param $name
 * @param $current_path
 * @param $relative_image_creation
 * @param $relative_path_from_current_pos
 * @param $relative_image_creation_name_to_prepend
 * @param $relative_image_creation_name_to_append
 * @param $relative_image_creation_width
 * @param $relative_image_creation_height
 * @param $relative_image_creation_option
 * @param $fixed_image_creation
 * @param $fixed_path_from_filemanager
 * @param $fixed_image_creation_name_to_prepend
 * @param $fixed_image_creation_to_append
 * @param $fixed_image_creation_width
 * @param $fixed_image_creation_height
 * @param $fixed_image_creation_option
 *
 * @return bool
 */
function new_thumbnails_creation($targetPath, $targetFile, $name, $current_path, $relative_image_creation, $relative_path_from_current_pos, $relative_image_creation_name_to_prepend, $relative_image_creation_name_to_append, $relative_image_creation_width, $relative_image_creation_height, $relative_image_creation_option, $fixed_image_creation, $fixed_path_from_filemanager, $fixed_image_creation_name_to_prepend, $fixed_image_creation_to_append, $fixed_image_creation_width, $fixed_image_creation_height, $fixed_image_creation_option)
{
	//create relative thumbs
	$all_ok = true;
	if ($relative_image_creation)
	{
		foreach ($relative_path_from_current_pos as $k => $path)
		{
			if ($path != "" && $path[ strlen($path) - 1 ] != "/")
			{
				$path .= "/";
			}
			if ( ! file_exists($targetPath . $path))
			{
				create_folder($targetPath . $path, false);
			}
			$info = pathinfo($name);

			// fix code for php 5.1
			if (empty($info['filename']))
			{
				if (! empty($info['extension']))
				{
					$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
				}
				else {
					$info['filename'] = $info['basename'];
				}
			}

			if ( ! endsWith($targetPath, $path))
			{
				if ( ! create_img($targetFile, $targetPath . $path . $relative_image_creation_name_to_prepend[ $k ] . $info['filename'] . $relative_image_creation_name_to_append[ $k ] . "." . $info['extension'], $relative_image_creation_width[ $k ], $relative_image_creation_height[ $k ], $relative_image_creation_option[ $k ]))
				{
					$all_ok = false;
				}
			}
		}
	}

	//create fixed thumbs
	if ($fixed_image_creation)
	{
		foreach ($fixed_path_from_filemanager as $k => $path)
		{
			if ($path != "" && $path[ strlen($path) - 1 ] != "/")
			{
				$path .= "/";
			}
			$base_dir = $path . substr_replace($targetPath, '', 0, strlen($current_path));
			if ( ! file_exists($base_dir))
			{
				create_folder($base_dir, false);
			}
			$info = pathinfo($name);

			// fix code for php 5.1
			if (empty($info['filename']))
			{
				if (! empty($info['extension']))
				{
					$info['filename'] = str_replace('.'.$info['extension'], '', $info['basename']);
				}
				else {
					$info['filename'] = $info['basename'];
				}
			}

			if ( ! create_img($targetFile, $base_dir . $fixed_image_creation_name_to_prepend[ $k ] . $info['filename'] . $fixed_image_creation_to_append[ $k ] . "." . $info['extension'], $fixed_image_creation_width[ $k ], $fixed_image_creation_height[ $k ], $fixed_image_creation_option[ $k ]))
			{
				$all_ok = false;
			}
		}
	}

	return $all_ok;
}


/**
 * Get a remote file, using whichever mechanism is enabled
 *
 * @param  string  $url
 *
 * @return  bool|mixed|string
 */
function get_file_by_url($url)
{
	if (ini_get('allow_url_fopen'))
	{
		return file_get_contents($url);
	}
	if ( ! function_exists('curl_version'))
	{
		return false;
	}

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

/**
 * test for dir/file writability properly
 *
 * @param  string  $dir
 *
 * @return  bool
 */
function is_really_writable($dir)
{
	global $permission;

	$dir = rtrim($dir, '/');
	// linux, safe off
	if (DIRECTORY_SEPARATOR == '/' && @ini_get("safe_mode") == false)
	{
		return is_writable($dir);
	}

	// Windows, safe ON. (have to write a file :S)
	if (is_dir($dir))
	{
		$dir = $dir . '/' . md5(mt_rand(1, 1000) . mt_rand(1, 1000));

		if (($fp = @fopen($dir, 'ab')) === false)
		{
			return false;
		}

		fclose($fp);
		@chmod($dir, $permission);
		@unlink($dir);

		return true;
	}
	elseif ( ! is_file($dir) || ($fp = @fopen($dir, 'ab')) === false)
	{
		return false;
	}

	fclose($fp);

	return true;
}

/**
 * Check if a function is callable.
 * Some servers disable copy,rename etc.
 *
 * @parm  string  $name
 *
 * @return  bool
 */
function is_function_callable($name)
{
	if (function_exists($name) === false)
	{
		return false;
	}
	$disabled = explode(',', ini_get('disable_functions'));

	return ! in_array($name, $disabled);
}

/**
 * recursivly copies everything
 *
 * @param  string  $source
 * @param  string  $destination
 * @param  bool    $is_rec
 */
function rcopy($source, $destination, $is_rec = false)
{
	global $permission;

	if (is_dir($source))
	{
		if ($is_rec === false)
		{
			$pinfo = pathinfo($source);

			// fix code for php 5.1
			if (empty($pinfo['filename']))
			{
				if (! empty($pinfo['extension']))
				{
					$pinfo['filename'] = str_replace('.'.$pinfo['extension'], '', $pinfo['basename']);
				}
				else {
					$pinfo['filename'] = $pinfo['basename'];
				}
			}

			$destination = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
		}
		if (is_dir($destination) === false)
		{
			mkdir($destination, $permission, true);
		}

		$files = scandir($source);
		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
			{
				rcopy($source . DIRECTORY_SEPARATOR . $file, rtrim($destination, '/') . DIRECTORY_SEPARATOR . $file, true);
			}
		}
	}
	else
	{
		if (file_exists($source))
		{
			if (is_dir($destination) === true)
			{
				$pinfo = pathinfo($source);

				// fix code for php 5.1
				if (empty($pinfo['filename']))
				{
					if (! empty($pinfo['extension']))
					{
						$pinfo['filename'] = str_replace('.'.$pinfo['extension'], '', $pinfo['basename']);
					}
					else {
						$pinfo['filename'] = $pinfo['basename'];
					}
				}

				$dest2 = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
			}
			else
			{
				$dest2 = $destination;
			}

			copy($source, $dest2);
		}
	}
}




/**
 * recursivly renames everything
 *
 * I know copy and rename could be done with just one function
 * but i split the 2 because sometimes rename fails on windows
 * Need more feedback from users and refactor if needed
 *
 * @param  string  $source
 * @param  string  $destination
 * @param  bool    $is_rec
 */
function rrename($source, $destination, $is_rec = false)
{
	global $permission;

	if (is_dir($source))
	{
		if ($is_rec === false)
		{
			$pinfo = pathinfo($source);

			// fix code for php 5.1
			if (empty($pinfo['filename']))
			{
				if (! empty($pinfo['extension']))
				{
					$pinfo['filename'] = str_replace('.'.$pinfo['extension'], '', $pinfo['basename']);
				}
				else {
					$pinfo['filename'] = $pinfo['basename'];
				}
			}

			$destination = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
		}
		if (is_dir($destination) === false)
		{
			mkdir($destination, $permission, true);
		}

		$files = scandir($source);
		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
			{
				rrename($source . DIRECTORY_SEPARATOR . $file, rtrim($destination, '/') . DIRECTORY_SEPARATOR . $file, true);
			}
		}
	}
	else
	{
		if (file_exists($source))
		{
			if (is_dir($destination) === true)
			{
				$pinfo = pathinfo($source);

				// fix code for php 5.1
				if (empty($pinfo['filename']))
				{
					if (! empty($pinfo['extension']))
					{
						$pinfo['filename'] = str_replace('.'.$pinfo['extension'], '', $pinfo['basename']);
					}
					else {
						$pinfo['filename'] = $pinfo['basename'];
					}
				}

				$dest2 = rtrim($destination, '/') . DIRECTORY_SEPARATOR . $pinfo['basename'];
			}
			else
			{
				$dest2 = $destination;
			}

			rename($source, $dest2);
		}
	}
}

// On windows rename leaves folders sometime
// This will clear leftover folders
// After more feedback will merge it with rrename
function rrename_after_cleaner($source)
{
	$files = scandir($source);

	foreach ($files as $file)
	{
		if ($file != "." && $file != "..")
		{
			if (is_dir($source . DIRECTORY_SEPARATOR . $file))
			{
				rrename_after_cleaner($source . DIRECTORY_SEPARATOR . $file);
			}
			else
			{
				unlink($source . DIRECTORY_SEPARATOR . $file);
			}
		}
	}

	return rmdir($source);
}

/**
 * Recursive chmod
 * @param  string  $source
 * @param  int     $mode
 * @param  string  $rec_option
 * @param  bool    $is_rec
 */
function rchmod($source, $mode, $rec_option = "none", $is_rec = false)
{
	if (is_link($source)) return;
	if ($rec_option == "none")
	{
		chmod($source, $mode);
	}
	else
	{
		if ($is_rec === false)
		{
			chmod($source, $mode);
		}

		$files = scandir($source);

		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
			{
				if (is_link($source . DIRECTORY_SEPARATOR . $file)) continue;
				if (is_dir($source . DIRECTORY_SEPARATOR . $file))
				{
					if ($rec_option == "folders" || $rec_option == "both")
					{
						chmod($source . DIRECTORY_SEPARATOR . $file, $mode);
					}
					rchmod($source . DIRECTORY_SEPARATOR . $file, $mode, $rec_option, true);
				}
				else
				{
					if ($rec_option == "files" || $rec_option == "both")
					{
						chmod($source . DIRECTORY_SEPARATOR . $file, $mode);
					}
				}
			}
		}
	}
}

/**
 * Check if chmod is valid
 *
 * @param  $perm
 * @param  $val
 *
 * @return  bool
 */
function chmod_logic_helper($perm, $val)
{
	$valid = array(
		1 => array( 1, 3, 5, 7 ),
		2 => array( 2, 3, 6, 7 ),
		4 => array( 4, 5, 6, 7 )
	);

	if (in_array($perm, $valid[ $val ]))
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * @param  string  $input
 * @param  bool    $trace
 * @param  bool    $halt
 */
function debugger($input, $trace = false, $halt = false)
{
	ob_start();

	echo "<br>----- DEBUG DUMP -----";
	echo "<pre>";
	var_dump($input);
	echo "</pre>";

	if ($trace)
	{
		if (is_php('5.3.6'))
		{
			$debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		}
		else
		{
			$debug = debug_backtrace(false);
		}

		echo "<br>-----STACK TRACE-----";
		echo "<pre>";
		var_dump($debug);
		echo "</pre>";
	}

	echo "</pre>";
	echo "---------------------------<br>";

	$ret = ob_get_contents();
	ob_end_clean();

	echo $ret;

	if ($halt == true)
	{
		exit();
	}
}

/**
 * @param  string  $version
 *
 * @return  bool
 */
function is_php($version = '5.0.0')
{
	static $phpVer;
	$version = (string) $version;

	if ( ! isset($phpVer[ $version ]))
	{
		$phpVer[ $version ] = (version_compare(PHP_VERSION, $version) < 0) ? false : true;
	}

	return $phpVer[ $version ];
}
