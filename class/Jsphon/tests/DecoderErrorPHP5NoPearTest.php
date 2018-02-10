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

class Jsphon_DecoderErrorPHP5NoPearTest extends UnitTestCase
{
    var $dec;
    
    function setup()
    {
        $this->dec = new Jsphon_Decoder();
    }

    function testDecode_token_error()
    {
        try {
            $this->dec->decode(' unknown token ');
        }
        catch(Jsphon_Exception $e) {
            $this->fail('Jsphon_Exception was thrown.');
        }
        catch(Exception $e) {
            $this->assertWantedPattern('/Illegal Token/i', $e->getMessage());
            return;
        }
        $this->fail('No Exceptions');
    }

    function testDecode_syntax_error()
    {
        try {
            $this->dec->decode(' } ');
        }
        catch(Jsphon_Exception $e) {
            $this->fail('Jsphon_Exception was thrown.');
        }
        catch(Exception $e) {
            $this->assertWantedPattern('/Syntax Error/i', $e->getMessage());
            return;
        }
        $this->fail('No Exceptions');
    }
}

$reporter = TextReporter::inCli() ? 'TextReporter' : 'HtmlReporter';
$test = new Jsphon_DecoderErrorPHP5NoPearTest();
$test->run(new $reporter);

?>
