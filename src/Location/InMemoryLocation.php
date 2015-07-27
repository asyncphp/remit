<?php

namespace AsyncPHP\Remit\Location;

use AsyncPHP\Remit\Location;

class InMemoryLocation implements Location
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @param string $host
     * @param int    $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
}
