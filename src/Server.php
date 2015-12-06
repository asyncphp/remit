<?php

namespace AsyncPHP\Remit;

use Closure;
use Serializable;

interface Server extends Serializable
{
    /**
     * @return Location
     */
    public function getLocation();

    /**
     * Removes an event listener.
     *
     * @param string $name
     * @param Closure $closure
     */
    public function removeListener($name, Closure $closure);

    /**
     * Adds an event listener.
     *
     * @param string $name
     * @param Closure $closure
     */
    public function addListener($name, Closure $closure);

    /**
     * Emits an event.
     *
     * @param string $name
     * @param array $parameters
     */
    public function emit($name, array $parameters = []);

    /**
     * Checks for waiting events.
     */
    public function tick();

    /**
     * Closes the connection to clients.
     */
    public function disconnect();
}
