<?php

namespace AsyncPHP\Remit;

use Serializable;

interface Client extends Serializable
{
    /**
     * @param string $name
     * @param array  $parameters
     */
    public function emit($name, array $parameters = array());
}
