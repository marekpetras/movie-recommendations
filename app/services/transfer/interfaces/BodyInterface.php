<?php

namespace app\services\transfer\interfaces;

/**
 * Interface BodyInterface
 */
interface BodyInterface
{
    /**
     * transcribe all the payloads into a string
     * @return string stringified payloads
     */
    public function __toString(): string;
}