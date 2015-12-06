<?php

namespace AsyncPHP\Remit;

use Serializable;

interface Client extends Serializable
{
    /**
     * @return Location
     */
    public function getLocation();

    /**
     * Emits an event.
     *
     * @param string $name
     * @param array $parameters
     */
    public function emit($name, array $parameters = []);

    /**
     * Closes the connection to a server.
     */
    public function disconnect();
}
