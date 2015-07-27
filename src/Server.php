<?php

namespace AsyncPHP\Remit;

use Closure;

interface Server
{
    /**
     * @todo description
     *
     * @param string  $name
     * @param Closure $closure
     */
    public function removeListener($name, Closure $closure);

    /**
     * @todo description
     *
     * @param string  $name
     * @param Closure $closure
     */
    public function addListener($name, Closure $closure);

    /**
     * @todo description
     */
    public function tick();
}
