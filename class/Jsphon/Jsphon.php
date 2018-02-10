<?php
//
// +--------------------------------------------------------------------+
// | PHP version 4 and 5                                                |
// +--------------------------------------------------------------------+
// | Copyright (c) 2006 Hawk                                            |
// +--------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,    |
// | that is available at http://www.php.net/license/3_0.txt.           |
// | If you did not receive a copy of the PHP license and are unable to |
// | obtain it through the world-wide-web, please send a note to        |
// | license@php.net so we can mail you a copy immediately.             |
// +--------------------------------------------------------------------+
// | Authors: Hawk <scholar@hawklab.jp>                                 |
// +--------------------------------------------------------------------+
//
//

define('JSPHON_ERROR_DECODE_SYNTAX', 1);

require_once(dirname(__FILE__) .'/Jsphon/Error.php');
require_once(dirname(__FILE__) .'/Jsphon/Decoder.php');
require_once(dirname(__FILE__) .'/Jsphon/Encoder.php');

Jsphon_Error::singleton();

/**
 * Jsphon - JSON in PHP
 *
 * example:
 * <code>
 * //encode
 * $value = array('foo', 'bar', array('hoge' => array(1,2)));
 * $json = Jsphon::encode($value);
 * echo $json;
 *
 * //decode
 * $var =  Jsphon::decode($json);
 * echo $var[2]['hoge'];
 *
 * </code>
 *
 * @author Hawk
 */
class Jsphon
{
    /**
     * Encodes an arbitrary variables into JSON format.
     * See Jsphon_Encoder::encode() for details.
     *
     * @param  String    $value
     * @param  boolean   $escapeNonASCII
     * @param  boolean   $escapeOverUCS2
     * @return String
     */
    function encode($value, $escapeNonASCII=true, $escapeOverUCS2=false)
    {
        $encoder = new Jsphon_Encoder($escapeNonASCII, $escapeOverUCS2);
        return $encoder->encode($value);
    }


    /**
     * Decodes JSON-formatted string into appropriate PHP variable.
     * See Jsphon_Decoder::decode() for details.
     *
     * @param  String    $json
     * @param  String    $decodeOverUCS2
     * @return mixed
     */
    function decode($json, $decodeOverUCS2=false)
    {
        $decoder = new Jsphon_Decoder($decodeOverUCS2);
        return $decoder->decode($json);
    }

}

?>
