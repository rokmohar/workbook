<?php

namespace AppBundle\Util;

interface CalculatorInterface
{
    /**
     * @param integer $a
     * @param integer $b
     *
     * @return integer
     */
    public function add($a, $b);
}
