<?php

namespace AsyncPHP\Remit;

use Closure;
use Serializable;

interface Server extends Serializable
{
    /**
     * @param string  $name
     * @param Closure $closure
     */
    public function removeListener($name, Closure $closure);

    /**
     * @param string  $name
     * @param Closure $closure
     */
    public function addListener($name, Closure $closure);

    /**
     * @param string $name
     * @param array  $parameters
     */
    public function emit($name, array $parameters = array());

    public function tick();
}
