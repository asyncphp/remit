<?php

namespace AsyncPHP\Remit\Client;

use AsyncPHP\Remit\Client;
use AsyncPHP\Remit\Event;
use AsyncPHP\Remit\Event\InMemoryEvent;
use AsyncPHP\Remit\Location;
use Exception;
use ZMQ;
use ZMQContext;
use ZMQSocket;

final class ZeroMqClient implements Client
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @var ZMQSocket
     */
    private $socket;

    /**
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @param string $name
     * @param array $parameters
     */
    public function emit($name, array $parameters = [])
    {
        $socket = $this->getSocket();

        $event = $this->newEvent($name, $parameters);

        $socket->send(serialize($event), ZMQ::MODE_DONTWAIT);
    }

    /**
     * @param string $name
     * @param array $parameters
     *
     * @return Event
     */
    private function newEvent($name, array $parameters = [])
    {
        return new InMemoryEvent($name, $parameters);
    }

    /**
     * @return ZMQSocket
     */
    private function getSocket()
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

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function serialize()
    {
        return serialize($this->location);
    }

    /**
     * @inheritdoc
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->location = unserialize($serialized);
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @inheritdoc
     */
    public function disconnect()
    {
        if ($this->socket) {
            try {
                $host = $this->location->getHost();
                $port = $this->location->getPort();

                $this->socket->disconnect("tcp://{$host}:{$port}");
            } catch (Exception $exception) {
                // TODO: find an elegant way to deal with this
            }
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}
