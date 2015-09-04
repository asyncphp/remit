<?php

namespace AsyncPHP\Remit;

use Serializable;

interface Event extends Serializable
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getParameters();
}
