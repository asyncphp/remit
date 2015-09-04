<?php

namespace AsyncPHP\Remit\Tests;

use AsyncPHP\Remit\Client\ZeroMqClient;
use AsyncPHP\Remit\Location\InMemoryLocation;
use AsyncPHP\Remit\Server\ZeroMqServer;

/**
 * @covers AsyncPHP\Remit\Client\ZeroMqClient
 * @covers AsyncPHP\Remit\Server\ZeroMqServer
 */
class ZeroMqTest extends Test
{
    /**
     * @var ZeroMqServer
     */
    protected $server;
    /**
     * @var ZeroMqClient
     */
    protected $client;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $location = new InMemoryLocation("127.0.0.1", 5555);

        $this->server = new ZeroMqServer($location);
        $this->client = new ZeroMqClient($location);
    }

    /**
     * @test
     */
    public function emitsToListeners()
    {
        $store = 0;

        $listener = function ($add) use (&$store) {
            $store += $add;
        };

        $this->server->addListener("foo", $listener);

        $this->client->emit("foo", array(1));

        $ticks = 0;

        while (true) {
            $this->server->tick();

            // the listener should have incremented this

            if ($store === 1) {
                break;
            }

            if (++$ticks >= 3) {
                $this->fail();
            }

            sleep(1);
        }

        $this->server->removeListener("foo", $listener);

        $this->client->emit("foo", array(1));

        $ticks = 0;

        while (true) {
            $this->server->tick();

            // the listener should not have incremented this, because it's gone!

            if ($store === 1) {
                break;
            }

            if (++$ticks >= 3) {
                $this->fail();
            }

            sleep(1);
        }
    }

    /**
     * @test
     */
    public function canBeSerialized()
    {
        $this->assertEquals($this->server, unserialize(serialize($this->server)));
        $this->assertEquals($this->client, unserialize(serialize($this->client)));
    }
}
