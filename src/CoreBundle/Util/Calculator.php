<?php

namespace AppBundle\Util;

class Calculator implements CalculatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function add($a, $b)
    {
        return $a + $b;
    }
}
