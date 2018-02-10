<?php

class Jsphon_Decoder_TokenizerTest extends Jsphon_UnitTestCase
{
    function setup()
    {

    }
    function _create($str)
    {
        $tkn = new Jsphon_Decoder_Tokenizer($str);
        return $tkn;
    }

    function testNextToken()
    {
        $tkn = $this->_create(' { [ true } false ] 125 , "data" : null ');
        $this->assertEqual(JSPHON_TOKEN_LBRACE,   $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_LBRACKET, $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertTrue($tkn->getTokenValue());

        $this->assertEqual(JSPHON_TOKEN_RBRACE,   $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertFalse($tkn->getTokenValue());
        
        $this->assertEqual(JSPHON_TOKEN_RBRACKET, $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual(125, $tkn->getTokenValue());

        $this->assertEqual(JSPHON_TOKEN_COMMA, $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual("data", $tkn->getTokenValue());
        
        $this->assertEqual(JSPHON_TOKEN_COLON, $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertNull($tkn->getTokenValue());

        $this->assertEqual(JSPHON_TOKEN_EOF, $tkn->nextToken());
        $this->assertEqual(JSPHON_TOKEN_EOF, $tkn->nextToken());
    }

    function testNextToken_IllegalToken()
    {
        $tkn = $this->_create(' illegal true false ');
        $this->assertFalse($tkn->nextToken());
        $this->assertFalse($tkn->nextToken());
        $this->assertFalse($tkn->nextToken());

        $e = $this->getErrorsFromStack(3);
        $this->assertWantedPattern('/Illegal Token/i', $e[0]['message']);
    }

    function testNextToken_String()
    {
        $tkn = $this->_create('" "      "\\""    ""    "\\\\"    "'. "\r\n" .'"');

        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual(" ", $tkn->getTokenValue());

        //not decoded yet
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual('\\"', $tkn->getTokenValue());

        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual("", $tkn->getTokenValue());

        //not decoded yet
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual('\\\\', $tkn->getTokenValue());

        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual("\r\n", $tkn->getTokenValue());

        $tkn = $this->_create(' "\\g\\g hoge"  "日本語とか\u0020"');
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual('\\g\\g hoge', $tkn->getTokenValue());

        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertEqual('日本語とか\u0020', $tkn->getTokenValue());

    }

    function testNextToken_StringError()
    {
        $tkn = $this->_create('"  fdafdf');
        $this->assertFalse($tkn->nextToken());
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $tkn = $this->_create(' "  fdafdf \\" ');
        $this->assertFalse($tkn->nextToken());
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $tkn = $this->_create(' \\"  fdafdf " ');
        $this->assertFalse($tkn->nextToken());
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $tkn = $this->_create(" 'fdafdf' ");
        $this->assertFalse($tkn->nextToken());
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);
    }

    function testNextToken_Number()
    {
        $nums = array('999', '1.0', '0.15', '-48', '-0.3988');
        $vals = array( 999,   1.0,   0.15,   -48,   -0.3988);
        $tkn = $this->_create(join(' ', $nums));

        foreach($nums as $i => $s) {
            $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
            $this->assertEqual($vals[$i], $tkn->getTokenValue());
        }

        $nums = array('5e3', '-2e+4', '17e-5', '1.687E6', '-12.32E+4', '8.097E-9');
        $vals = array( 5e3,   -2e+4,   17e-5,   1.687E6,   -12.32E+4,   8.097E-9);
        $tkn = $this->_create(join(' ', $nums));

        foreach($nums as $i => $s) {
            $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
            $this->assertEqual($vals[$i], $tkn->getTokenValue());
        }
    }

    function testNextToken_Number2()
    {
        $big = '2'.str_repeat('0', 100) .' '. '2e+1'.str_repeat('0', 100);
        $tkn = $this->_create($big);
        
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertTrue(is_float($tkn->getTokenValue()));

        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertTrue(is_float($tkn->getTokenValue()));

        $small = '0.'. str_repeat('0', 100) .'1   3E-1'. str_repeat('0', 700);
        $tkn = $this->_create($small);
        
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertTrue(is_float($tkn->getTokenValue()));

        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertTrue(is_float($tkn->getTokenValue()));
    }

    function testNextToken_NumberError()
    {
        $tkn = $this->_create(' 4. ');
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertNotIdentical(4. , $tkn->getTokenValue());

        $this->assertFalse($tkn->nextToken());
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        
        $tkn = $this->_create(' .1236 ');
        $this->assertFalse($tkn->nextToken());
        $e = $this->getErrorsFromStack();
        $this->assertWantedPattern('/Illegal Token/i', $e['message']);

        $tkn = $this->_create(' 004329 ');
        $this->assertEqual(JSPHON_TOKEN_DATUM, $tkn->nextToken());
        $this->assertNotEqual(004329, $tkn->getTokenValue());
        $this->assertEqual(0, $tkn->getTokenValue());


    }

}

?>
