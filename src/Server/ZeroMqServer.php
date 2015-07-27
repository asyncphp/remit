<?php

namespace AsyncPHP\Remit\Server;

use AsyncPHP\Remit\Event;
use AsyncPHP\Remit\Location;
use AsyncPHP\Remit\Server;
use Closure;
use ZMQ;
use ZMQContext;
use ZMQSocket;

class ZeroMqServer implements Server
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
     * @var array
     */
    protected $listeners = array();

    /**
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @inheritdoc
     *
     * @param string  $name
     * @param Closure $closure
     *
     * @return $this
     */
    public function addListener($name, Closure $closure)
    {
        if (empty($this->listeners[$name])) {
            $hash = spl_object_hash($closure);

            $this->listeners[$name][$hash] = $closure;
        }

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param string  $name
     * @param Closure $closure
     */
    public function removeListener($name, Closure $closure)
    {
        $hash = spl_object_hash($closure);

        if (isset($this->listeners[$name]) && isset($this->listeners[$name][$hash])) {
            unset($this->listeners[$name][$hash]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function tick()
    {
        $socket = $this->getSocket();

        if (!($event = $socket->recv(ZMQ::MODE_DONTWAIT))) {
            return;
        }

        $event = @unserialize($event);

        if ($event instanceof Event) {
            $this->dispatchEvent($event);
        }
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

            $this->socket = new ZMQSocket($context, ZMQ::SOCKET_PULL, spl_object_hash($this));
            $this->socket->bind("tcp://{$host}:$port");
        }

        return $this->socket;
    }

    /**
     * @param Event $event
     */
    protected function dispatchEvent(Event $event)
    {
        $name = $event->getName();

        if (isset($this->listeners[$name])) {
            foreach ($this->listeners[$name] as $closure) {
                call_user_func_array($closure, $event->getParameters());
            }
        }
    }
}
