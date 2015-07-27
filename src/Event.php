<?php

namespace AsyncPHP\Remit;

use Serializable;

interface Event extends Serializable
{
    /**
     * @todo description
     *
     * @return string
     */
    public function getName();

    /**
     * @todo description
     *
     * @return array
     */
    public function getParameters();
}
