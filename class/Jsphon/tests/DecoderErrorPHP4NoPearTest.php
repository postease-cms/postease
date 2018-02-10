<?php

error_reporting(E_ALL);

require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('simpletest/mock_objects.php');

//
set_include_path('.');
//

$_jsphon_root_cd = dirname(__FILE__) .'/../';
define('_JSPHON_ROOT',
       file_exists($_jsphon_root_cd . 'Jsphon.php') ? $_jsphon_root_cd : "");
require_once(_JSPHON_ROOT .'Jsphon.php');

class Jsphon_DecoderErrorPHP4NoPearTest extends UnitTestCase
{
    var $dec;
    
    function setup()
    {
        $this->dec = new Jsphon_Decoder();
    }

    function testDecode_token_error()
    {
        $this->assertNull($this->dec->decode(' unknown token '));
    }

    function testDecode_syntax_error()
    {
        $this->assertNull($this->dec->decode(' } '));
        
        //not error but...
        $this->assertNull($this->dec->decode(' null '));
    }
}

$reporter = TextReporter::inCli() ? 'TextReporter' : 'HtmlReporter';
$test = new Jsphon_DecoderErrorPHP4NoPearTest();
$test->run(new $reporter);

?>
