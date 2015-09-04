<?php

namespace AsyncPHP\Remit;

use Serializable;

interface Location extends Serializable
{
    /**
     * @return string
     */
    public function getHost();

    /**
     * @return int
     */
    public function getPort();
}
