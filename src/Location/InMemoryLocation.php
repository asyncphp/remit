<?php

namespace AsyncPHP\Remit\Location;

use AsyncPHP\Remit\Location;

final class InMemoryLocation implements Location
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @param string $host
     * @param int $port
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

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function serialize()
    {
        return serialize([
            "host" => $this->host,
            "port" => $this->port,
        ]);
    }

    /**
     * @inheritdoc
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);

        $this->host = $unserialized["host"];
        $this->port = $unserialized["port"];
    }
}
