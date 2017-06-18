<?php

namespace app\services\transfer\interfaces;

/**
 * Interface PayloadInterface
 */
interface PayloadInterface
{
    /**
     * stringify the data into a http query
     * @return string key value query data
     */
    public function __toString(): string;
}