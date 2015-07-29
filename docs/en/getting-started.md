# Getting Started

The easiest way to install is by using [Composer](https://getcomposer.org):

```sh
$ composer require asyncphp/remit
```

## Listening For Events

```php
use AsyncPHP\Remit\Client\ZeroMqServer;
use AsyncPHP\Remit\Location\InMemoryLocation;

$server = new ZeroMqServer(new InMemoryLocation("127.0.0.1", 5555));

$server->addListener("greet", function($thing) {
    print "hello {$thing}";
});

while(true) {
    $server->tick();
    usleep(250);
}
```

The `tick()` method needs to be run often. It checks the event store for new events, and dispatches them to all relevant listeners.

## Emitting Events

```php
use AsyncPHP\Remit\Client\ZeroMqClient;
use AsyncPHP\Remit\Location\InMemoryLocation;

$client = new ZeroMqClient(new InMemoryLocation("127.0.0.1", 5555));

$this->client->emit("greet", array("world"));
```
