<?php

namespace Tests\AppBundle\Util;

include 'src/CoreBundle/Util/CalculatorInterface.php';
include 'src/CoreBundle/Util/Calculator.php';

use AppBundle\Util\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $result = $calc->add(30, 12);

        $this->assertEquals(42, $result);
    }
}
