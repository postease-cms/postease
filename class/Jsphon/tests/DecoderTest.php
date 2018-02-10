<?php

class Jsphon_DecoderTest extends Jsphon_UnitTestCase
{
    var $dec;
    
    function setup()
    {
        $this->dec = new Jsphon_Decoder();
    }

    function testDecode_simple()
    {
        $this->assertEqual(120,   $this->dec->decode(' 120 '));
        $this->assertEqual(-2.48, $this->dec->decode(' -2.48 '));
        $this->assertEqual(true,  $this->dec->decode(' true '));
        $this->assertIdentical(false, $this->dec->decode('false'));
        $this->assertIdentical(null,  $this->dec->decode('null '));
        $this->assertEqual("abcd efg",  $this->dec->decode(' "abcd efg" '));

    }

    function testDecode_error_simple()
    {
        $this->assertNull($this->dec->decode(' unknown token '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        //though error was occured, decoder is OK.
        $this->assertEqual(120,   $this->dec->decode(' 120 '));

        $this->assertNull($this->dec->decode(' } '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Syntax Error/i', $e['message']);

        //decoder is always OK.
        $this->assertEqual(-2.48, $this->dec->decode(' -2.48 '));

    }

    function testDecode_Array()
    {
        $this->assertEqual(array(), $this->dec->decode(' [ ] '));
        $this->assertEqual(array(1), $this->dec->decode(' [ 1 ] '));
        $this->assertEqual(array(1,2), $this->dec->decode(' [ 1, 2 ] '));

        $this->assertEqual(array(23, true, false, null , "cda"),
                           $this->dec->decode(
                               ' [ 23, true, false, null , "cda" ] '));

        $this->assertEqual(array(array()),
                           $this->dec->decode('[[]]'));

        $this->assertEqual(array(array(), array(array()), null, "fde"),
                           $this->dec->decode('[ [ ] , [[]], null, "fde" ]'));

    }

    function testDecode_Array_Error()
    {
        $this->assertNull($this->dec->decode(' [ unknown token '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);


        $this->assertNull($this->dec->decode(' [ : ]'));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Syntax Error/i', $e['message']);


        $this->assertNull($this->dec->decode(' [ true unknown-token ] '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);


        $this->assertNull($this->dec->decode(' [ true, false : null ]'));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+,/i', $e['message']);


        $this->assertNull($this->dec->decode(' [ true, false null ]'));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+,/i', $e['message']);
        

        $this->assertNull($this->dec->decode(' [ true, false '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+\]/i', $e['message']);


        $this->assertNull($this->dec->decode(' [ true, [false, ]] '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Syntax Error/i', $e['message']);

        $this->assertNull($this->dec->decode(' [ "foo", "bar", "hoge", ] '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Syntax Error/i', $e['message']);

    }

    function testDecode_Object()
    {
        $decArr = new Jsphon_Decoder();

        $str = ' { } ';
        $arr = array();
        $this->assertEqual($arr, $decArr->decode($str));

        $str = ' { "abc":124 } ';
        $arr = array("abc" => 124);
        $this->assertEqual($arr, $decArr->decode($str));

        $str = ' { "def":124, "":true } ';
        $arr = array("def" => 124, "" => true);
        $this->assertEqual($arr, $decArr->decode($str));

        $str = '{"TRUE" : true, "num":-125e-1, "FALSE":false,  "NULL":null , "STRING": "cda" }';
        $arr = array("TRUE" => true, "num"=> -125e-1, "FALSE" => false, "NULL" => null, "STRING"=> "cda");
        $this->assertEqual($arr, $decArr->decode($str));

        $str = ' { "child":{}, "child2":{ "grandChild":{} } } ';
        $arr = array("child"=>array(), "child2"=>array( "grandChild"=>array() ) );
        $this->assertEqual($arr, $decArr->decode($str));

        $str = '{ "3424":124, "    ": true }';
        $arr = array("3424" => 124, "    "=> true);
        $decodedArr =  $decArr->decode($str);
        $this->assertEqual($arr, $decodedArr);
        $this->assertEqual(124,  $decodedArr["3424"]);
        $this->assertEqual(true, $decodedArr["    "]);
    }

    function testDecode_object_error()
    {
        $this->assertNull($this->dec->decode(' { unknown-token '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $this->assertNull($this->dec->decode(' { ] '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Syntax Error/i', $e['message']);

        $this->assertNull($this->dec->decode(' { 123 '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Object.s key must be a string/i', $e['message']);
        
        $this->assertNull($this->dec->decode(' { "key" unknown-token '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $this->assertNull($this->dec->decode(' { "key" , '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+:/i', $e['message']);

        $this->assertNull($this->dec->decode(' { "key" : unknown-token'));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);
        
        $this->assertNull($this->dec->decode(' { "key" : , '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Syntax Error/i', $e['message']);

        $this->assertNull($this->dec->decode(' { "key" : "value" unknown-token'));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $this->assertNull($this->dec->decode(' { "key" : "value" "key2":"value2"}'));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+,.+or.+\}/i', $e['message']);

        $this->assertNull($this->dec->decode(' { "key" : "value", "key2":"value2" '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+,.+or.+\}/i', $e['message']);

        $this->assertNull($this->dec->decode(' { "key" : "value", "key2": {"value2"} } '));
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Missing.+:/i', $e['message']);

    }

    function testDecodeString()
    {
        $this->assertEqual("\" \\ / \n \r \t \x08 \x0C", $this->dec->decodeString('\" \ \/ \n \r \t \b \f'));

        //unknown escape sequence
        $str = '\a \j \7 \l \u99';
        $this->assertEqual($str, $this->dec->decodeString($str));
        
    }

    function testDecode_complex()
    {
        $str = '{"params":[{"options": {"old": [ ], "new": {"0": {"elements": {"old": [], "new": {"0": {"elementName": "aa", "isDefault": false, "elementRank": "0", "priceAdjust": "0", "partNumber": ""}}}, "optionName": "aa", "isRequired": false, "optionDesc": null}}}}]}';
        $arr = array (
            'params' => array (
                0 => array (
                    'options' => 
                    array (
                        'old' => array(),
                        'new' => array (
                            0 => array (
                                'elements' => array (
                                    'old' => array(),
                                    'new' => array (
                                        0 => array (
                                            'elementName' => 'aa',
                                            'isDefault' => false,
                                            'elementRank' => '0',
                                            'priceAdjust' => '0',
                                            'partNumber' => '',
                                            ),
                                        ),
                                    ),
                                'optionName' => 'aa',
                                'isRequired' => false,
                                'optionDesc' => NULL,
                                ),
                            ),
                        ),
                    ),
                ),
            );
        $this->assertEqual($arr, $this->dec->decode($str));
    }
    

}


class Jsphon_DecoderTest_UnicodeEscapeSequence extends Jsphon_UnitTestCase
{
    var $dec;
    var $dec_noMb;
    var $dec_full;
    var $dec_off;
    
    function setup()
    {
        $this->dec =& new Jsphon_Decoder();
        $this->dec_noMb =& new Jsphon_Decoder();
        $this->dec_noMb->_mbstring = false; //cheat
        
        $this->dec_full =& new Jsphon_Decoder(true);
    }

    function testDecodeString()
    {
        $helloWorld = 'héllö wørłd';
        $UES_encoded = 'h\u00e9ll\u00f6 w\u00f8r\u0142d';
        $this->assertEqual($helloWorld, $this->dec->decodeString($helloWorld));
        $this->assertEqual($helloWorld, $this->dec_noMb->decodeString($helloWorld));
        $this->assertEqual($helloWorld, $this->dec_full->decodeString($helloWorld));

        $this->assertEqual($helloWorld, $this->dec->decodeString($UES_encoded));
        $this->assertEqual($helloWorld, $this->dec_noMb->decodeString($UES_encoded));
        $this->assertEqual($helloWorld, $this->dec_full->decodeString($UES_encoded));

        $helloWorld = 'こんにちは世界';
        $UES_encoded = '\u3053\u3093\u306b\u3061\u306f\u4e16\u754c';
        $this->assertEqual($helloWorld, $this->dec->decodeString($helloWorld));
        $this->assertEqual($helloWorld, $this->dec_noMb->decodeString($helloWorld));
        $this->assertEqual($helloWorld, $this->dec_full->decodeString($helloWorld));

        $this->assertEqual($helloWorld, $this->dec->decodeString($UES_encoded));
        $this->assertEqual($helloWorld, $this->dec_noMb->decodeString($UES_encoded));
        $this->assertEqual($helloWorld, $this->dec_full->decodeString($UES_encoded));
    }

    function testDecodeString_UES()
    {
        $str_UCS2 = "Hello 世界!";
        
        //0x0001D160 は Musical Symbols の中の♪
        $str_UCS4 = "Hello 世界". mb_convert_encoding(pack('N', hexdec('1D160')), 'UTF-8', 'UCS-4');
        $str_UCS4_limited_decode = "Hello 世界";
        
        $str_UCS2_UES = 'Hello \u4e16\u754c!';
        $str_UCS4_UES = 'Hello \u4e16\u754c\ud834\udd60';
        $str_UCS4_limited_UES = 'Hello \u4e16\u754c';
        
        $this->assertEqual($str_UCS2,                $this->dec->decodeString($str_UCS2_UES));
        $this->assertEqual($str_UCS4_limited_decode, $this->dec->decodeString($str_UCS4_UES));

        $this->assertEqual($str_UCS2,                $this->dec_noMb->decodeString($str_UCS2_UES));
        $this->assertEqual($str_UCS4_limited_decode, $this->dec_noMb->decodeString($str_UCS4_UES));

        $this->assertEqual($str_UCS2, $this->dec_full->decodeString($str_UCS2_UES));
        $this->assertEqual($str_UCS4, $this->dec_full->decodeString($str_UCS4_UES));

    }

}


?>
