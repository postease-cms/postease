<?php
error_reporting(E_ALL);

if (! defined('SIMPLE_TEST')) {
    define('SIMPLE_TEST', 'simpletest/');
}
require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');
require_once(SIMPLE_TEST . 'mock_objects.php');

$_jsphon_root_cd = dirname(__FILE__) .'/../';
define('_JSPHON_ROOT',
       file_exists($_jsphon_root_cd . 'Jsphon.php') ? $_jsphon_root_cd : "");

require_once(_JSPHON_ROOT .'Jsphon.php');
require_once(dirname(__FILE__) .'/lib/UnitTestCase.php');

$jsphonError =& Jsphon_Error::singleton();
$jsphonError->setThrowException(false);


$reporter = TextReporter::inCli() ? 'TextReporter' : 'HtmlReporter';
$test =& new GroupTest('All tests');
$test->addTestFile(dirname(__FILE__) .'/EncoderTest.php');
$test->addTestFile(dirname(__FILE__) .'/DecoderTest.php');
$test->addTestFile(dirname(__FILE__) .'/Decoder_TokenizerTest.php');

$test->run(new $reporter());

?>
