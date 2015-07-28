# Remit

[![Build Status](http://img.shields.io/travis/asyncphp/remit.svg?style=flat-square)](https://travis-ci.org/asyncphp/remit)
[![Code Quality](http://img.shields.io/scrutinizer/g/asyncphp/remit.svg?style=flat-square)](https://scrutinizer-ci.com/g/asyncphp/remit)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/asyncphp/remit.svg?style=flat-square)](https://scrutinizer-ci.com/g/asyncphp/remit)
[![Version](http://img.shields.io/packagist/v/asyncphp/remit.svg?style=flat-square)](https://packagist.org/packages/asyncphp/remit)
[![License](http://img.shields.io/packagist/l/asyncphp/remit.svg?style=flat-square)](license.md)

Distributed event emitter. Compatible from PHP `5.3` to PHP `7`.

> `2.x` supports PHP `5.5.9` and upwards. If you need PHP `5.3/4` support, use a `1.x` release.

## Usage

Listening for events:

```php
use AsyncPHP\Remit\Client\ZeroMqClient;
use AsyncPHP\Remit\Client\ZeroMqServer;
use AsyncPHP\Remit\Location\InMemoryLocation;

$server = new ZeroMqServer(new InMemoryLocation("127.0.0.1", 5555));

$server->addListener("my-event", function($param1, $param2) {
    // ...do a thing
});

$client = new ZeroMqClient(new InMemoryLocation("127.0.0.1", 5555));

$this->client->emit("my-event", array("foo", "bar"));
```

You can find more in-depth documentation in [docs/en](docs/en/introduction.md).

## Motivation

This library provides a small, simple API for allowing bi-directional communication between processes, and across multiple servers. It's an event emitter, where the listeners can be in a different process, or on a different server to the code that emits events to them.

## Versioning

This library follows [Semver](http://semver.org). According to Semver, you will be able to upgrade to any minor or patch version of this library without any breaking changes to the public API. Semver also requires that we clearly define the public API for this library.

All methods, with `public` visibility, are part of the public API. All other methods are not part of the public API. Where possible, we'll try to keep `protected` methods backwards-compatible in minor/patch versions, but if you're overriding methods then please test your work before upgrading.

## Thanks

I'd like to thank [SilverStripe](http://www.silverstripe.com) for letting me work on fun projects like this. Feel free to talk to me about using the [framework and CMS](http://www.silverstripe.org) or [working at SilverStripe](http://www.silverstripe.com/who-we-are/#careers).
