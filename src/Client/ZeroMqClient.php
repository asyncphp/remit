<?php

namespace AsyncPHP\Remit\Client;

use AsyncPHP\Remit\Client;
use AsyncPHP\Remit\Event;
use AsyncPHP\Remit\Event\InMemoryEvent;
use AsyncPHP\Remit\Location;
use ZMQ;
use ZMQContext;
use ZMQSocket;

class ZeroMqClient implements Client
{
    /**
     * @var Location
     */
    protected $location;

    /**
     * @var ZMQSocket
     */
    protected $socket;

    /**
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @param string $name
     * @param array  $parameters
     */
    public function emit($name, array $parameters = array())
    {
        $socket = $this->getSocket();

        $event = $this->newEvent($name, $parameters);

        $socket->send(serialize($event), ZMQ::MODE_DONTWAIT);
    }

    /**
     * @param string $name
     * @param array  $parameters
     *
     * @return Event
     */
    protected function newEvent($name, array $parameters)
    {
        return new InMemoryEvent($name, $parameters);
    }

    /**
     * @return ZMQSocket
     */
    protected function getSocket()
    {
        if ($this->socket === null) {
            $context = new ZMQContext();

            $host = $this->location->getHost();
            $port = $this->location->getPort();

            $this->socket = new ZMQSocket($context, ZMQ::SOCKET_PUSH, spl_object_hash($this));
            $this->socket->connect("tcp://{$host}:$port");
        }

        return $this->socket;
    }
}
