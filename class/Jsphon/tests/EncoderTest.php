<?php

/**
 * compatible with Service_JSON 
 * 
 * 
 */
class Jsphon_EncoderTest extends Jsphon_UnitTestCase
{
    var $json;
    
    function setUp()
    {
        $this->json = new Jsphon_Encoder();
    }
    
    function testEncode()
    {
        $obj = new stdClass();
        $obj->a_string = '"he":llo}:{world';
        $obj->an_array = array(1, 2, 3);
        $obj->obj = new stdClass();
        $obj->obj->a_number = 123;
        
        $obj_j = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"obj":{"a_number":123}}';
        $obj_d = 'object with properties, nested object and arrays';
        
        $arr = array(null, true, array(1, 2, 3), "hello\"],[world!");
        $arr_j = '[null,true,[1,2,3],"hello\"],[world!"]';
        $arr_d = 'array with elements and nested arrays';

        $str1 = 'hello world';
        $str1_j = '"hello world"';
        $str1_j_ = "'hello world'";
        $str1_d = 'hello world';
        $str1_d_ = 'hello world, double quotes';

        $str2 = "hello\t\"world\"";
        $str2_j = '"hello\\t\\"world\\""';
        $str2_d = 'hello world, with tab, double-quotes';

        $str3 = "\\\r\n\t\"/";
        $str3_j = '"\\\\\\r\\n\\t\\"\\/"';
        $str3_d = 'backslash, return, newline, tab, double-quote';

        $str4 = 'héllö wørłd';
        $str4_j = '"h\u00e9ll\u00f6 w\u00f8r\u0142d"';
        $str4_j_ = '"héllö wørłd"';
        $str4_d = 'hello world, with unicode';
        
        $str5 = 'こんにちは世界';
        $str5_j = '"\u3053\u3093\u306b\u3061\u306f\u4e16\u754c"';
        $str5_d = 'こんにちは世界、日本語で';

        $json =& $this->json;

        $this->assertEqual('null', $json->encode(null), 'type case: null');
        $this->assertEqual('true', $json->encode(true), 'type case: boolean true');
        $this->assertEqual('false', $json->encode(false), 'type case: boolean false');

        $this->assertEqual('1', $json->encode(1), 'numeric case: 1');
        $this->assertEqual('-1', $json->encode(-1), 'numeric case: -1');
        $this->assertEqual('1.000000', $json->encode(1.0), 'numeric case: 1.0');
        $this->assertEqual('1.100000', $json->encode(1.1), 'numeric case: 1.1');

        $this->assertEqual($str1_j, $json->encode($str1), "string case: {$str1_d}");
        $this->assertEqual($str2_j, $json->encode($str2), "string case: {$str2_d}");
        $this->assertEqual($str3_j, $json->encode($str3), "string case: {$str3_d}");
        $this->assertEqual($str4_j, $json->encode($str4), "string case: {$str4_d}");
        $this->assertEqual($str5_j, $json->encode($str5), "string case: {$str5_d}");
        $this->assertEqual($arr_j, $json->encode($arr), "array case: {$arr_d}");
        $this->assertEqual($obj_j, $json->encode($obj), "object case: {$obj_d}");
    }

    function testEncode_Empty()
    {
        $json =& $this->json;

        $this->assertEqual('[]', $json->encode(array()));
        $this->assertEqual('{}', $json->encode(new stdClass));
    }
    
    function testEncode_AssocArray()
    {
        $arr = array('car1'=> array('color'=> 'tan', 'model' => 'sedan'), 
            'car2' => array('color' => 'red', 'model' => 'sports')); 
        $arr_jo = '{"car1":{"color":"tan","model":"sedan"},"car2":{"color":"red","model":"sports"}}';
        $arr_d = 'associative array with nested associative arrays';

        $arn = array(0=> array(0=> 'tan\\', 'model\\' => 'sedan'), 1 => array(0 => 'red', 'model' => 'sports')); 
        $arn_ja = '[{"0":"tan\\\\","model\\\\":"sedan"},{"0":"red","model":"sports"}]';
        $arn_d = 'associative array with nested associative arrays, and some numeric keys thrown in';
        
        $arrs = array (1 => 'one', 2 => 'two', 5 => 'five');
        $arrs_jo = '{"1":"one","2":"two","5":"five"}';
        $arrs_d = 'associative array numeric keys which are not fully populated in a range of 0 to length-1';            

        $json =& $this->json;
        $this->assertEqual($arr_jo, $json->encode($arr), "array case: {$arr_d}");
        $this->assertEqual($arn_ja, $json->encode($arn), "array case: {$arn_d}");
        $this->assertEqual($arrs_jo, $json->encode($arrs), "sparse numeric assoc array: {$arrs_d}");
    }
    
    function testEncode_Object() 
    {
        $obj_j = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"obj":{"a_number":123}}';
        
        $obj1->car1->color = 'tan';
        $obj1->car1->model = 'sedan';
        $obj1->car2->color = 'red';
        $obj1->car2->model = 'sports';
        $obj1_j = '{"car1":{"color":"tan","model":"sedan"},"car2":{"color":"red","model":"sports"}}';
        $obj1_d = 'Object with nested objects';
        
        $json =& $this->json;
        $this->assertEqual($obj1_j, $json->encode($obj1), "object: {$obj1_d}");
    }

    function testEncode_Error()
    {
        $res = tmpfile();
        $res_j_ = 'null';
        $res_d = 'naked resource';
        
        $arr = array('a', 1, tmpfile());
        $arr_j_ = '["a",1,null]';
        $arr_d = 'array with string, number and resource';
    
        $obj = new stdClass();
        $obj->a_string = '"he":llo}:{world';
        $obj->an_array = array(1, 2, 3);
        $obj->resource = tmpfile();
        
        $obj = $obj;
        $obj_j_ = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"resource":null}';
        $obj_d = 'object with properties, array, and nested resource';

        $json =& $this->json;
        $this->assertEqual($res_j_, $json->encode($res), "resource case: {$res_d}");
        $this->assertEqual($arr_j_, $json->encode($arr), "array case: {$arr_d}");
        $this->assertEqual($obj_j_, $json->encode($obj), "object case: {$obj_d}");
    }
}

class Jsphon_EncoderTest_UnicodeEscapeSequence extends Jsphon_UnitTestCase
{
    var $json;
    var $json_noMb;
    var $json_full;
    var $json_off;
    
    function setup()
    {
        $this->json =& new Jsphon_Encoder();
        $this->json_noMb =& new Jsphon_Encoder();
        $this->json_noMb->_mbstring = false; //cheat
        $this->json_full =& new Jsphon_Encoder(true, true);
        $this->json_off  =& new Jsphon_Encoder(false);
    }
    
    function testEncode()
    {
        $str_UCS2 = "Hello 世界!";
        
        //0x0001D160 は Musical Symbols の中の♪
        $str_UCS4 = "Hello 世界". mb_convert_encoding(pack('N', hexdec('1D160')), 'UTF-8', 'UCS-4');
        
        $str_UCS2_UES = '"Hello \u4e16\u754c!"';
        $str_UCS4_UES = '"Hello \u4e16\u754c\ud834\udd60"';
        $str_UCS4_limited_UES = '"Hello \u4e16\u754c"';
        
        $this->assertEqual($str_UCS2_UES, $this->json->encode($str_UCS2));
        $this->assertEqual($str_UCS4_limited_UES, $this->json->encode($str_UCS4));

        $this->assertEqual($str_UCS2_UES, $this->json_noMb->encode($str_UCS2));
        $this->assertEqual($str_UCS4_limited_UES, $this->json_noMb->encode($str_UCS4));

        $this->assertEqual($str_UCS2_UES, $this->json_full->encode($str_UCS2));
        $this->assertEqual($str_UCS4_UES, $this->json_full->encode($str_UCS4));
        
        $this->assertEqual('"'. $str_UCS2 .'"', $this->json_off->encode($str_UCS2));
        $this->assertEqual('"'. $str_UCS4 .'"', $this->json_off->encode($str_UCS4));

    }
}

?>
