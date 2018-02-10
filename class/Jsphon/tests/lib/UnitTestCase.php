<?php

class Jsphon_UnitTestCase extends UnitTestCase
{
    function getErrorsFromStack($count=1)
    {
        $stack =& PEAR_ErrorStack::singleton('Jsphon');
        $errors = $stack->getErrors(true);
        $c = count($errors);

        if($count > 0) {
            if($c == 0) {
                $this->fail("There are no errors in the stack.");
                return ;
            } else {
                $this->assertEqual($c, $count,
                                   "Expected {$count} errors, but {$c} errors in the stack.");
            }
        } elseif($count == 0 && $c > 0) {
            $this->fail("There are {$c} error(s) in the stack.");
            return ;
        }

        if($count == 1) {
            return $errors[0];
        } else {
            return $errors;
        }
    }

    function teardown()
    {
        $this->getErrorsFromStack(0);
    }

}

?>
