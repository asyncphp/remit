<?php

namespace AsyncPHP\Remit;

interface Location
{
    /**
     * @todo description
     *
     * @return string
     */
    public function getHost();

    /**
     * @todo description
     *
     * @return int
     */
    public function getPort();
}
