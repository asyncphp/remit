<?php

namespace AsyncPHP\Remit\Event;

use AsyncPHP\Remit\Event;
use InvalidArgumentException;

class InMemoryEvent implements Event
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @param string $name
     * @param array  $parameters
     */
    public function __construct($name, array $parameters = array())
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            "name"       => $this->name,
            "parameters" => $this->parameters,
        ));
    }

    /**
     * @inheritdoc
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        if (!isset($data["name"])) {
            throw new InvalidArgumentException("malformed event");
        }

        if (!isset($data["parameters"])) {
            throw new InvalidArgumentException("malformed event");
        }

        $this->name = $data["name"];
        $this->parameters = $data["parameters"];
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
