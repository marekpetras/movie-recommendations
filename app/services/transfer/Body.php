<?php

namespace app\services\transfer;

use app\services\transfer\interfaces\BodyInterface;
use app\services\transfer\interfaces\PayloadInterface;

/**
 * Class Body
 * represents a body of a http request
 * is able to handle any number of payloads
 * keep feeding them in, write and then out again
 * for batching requests/payloads
 */
class Body implements BodyInterface
{
    private $_payloads = [];

    /**
     * Constructor
     * @param PayloadInterface[] $payloads
     */
    public function __construct( array $payloads = null )
    {
        if ( $payloads ) $this->setPayloads($payloads);
    }

    /**
     * Overwrite current payloads
     * @param PayloadInterface[] $payloads new payloads
     * @return BodyInterface
     */
    public function setPayloads( array $payloads ): BodyInterface
    {
        $this->clearPayloads();
        $this->addPayloads($payloads);
        return $this;
    }

    /**
     * add payload to current load
     * @param PayloadInterface $payload
     * @return BodyInterface
     */
    public function addPayload( PayloadInterface $payload ): BodyInterface
    {
        $this->_payloads[] = $payload;
        return $this;
    }

    /**
     * add payloads to current load
     * @param PayloadInterface[] $payload
     * @return BodyInterface
     */
    public function addPayloads( array $payloads ): BodyInterface
    {
        foreach ( $payloads as $payload ) {
            $this->addPayload($payload);
        }
        return $this;
    }

    /**
     * payloads getter
     * @return PayloadInterface[]
     */
    public function getPayloads(): array
    {
        return $this->_payloads;
    }

    /**
     * count how many payloads we currently hold
     * @return int payload count
     */
    public function countPayloads(): int
    {
        return count($this->_payloads);
    }

    /**
     * if we have any payloads
     * @return bool if at least one payload present
     */
    public function hasPayloads(): bool
    {
        return count($this->_payloads) > 0;
    }

    /**
     * drop all payloads
     * @return BodyInterface
     */
    public function clearPayloads(): BodyInterface
    {
        $this->_payloads = [];
        return $this;
    }

    /**
     * transcribe all the payloads into a string
     * @return string stringified payloads
     */
    public function __toString(): string
    {
        $body = [];
        foreach ( $this->_payloads as $payload ) {
            $body[] = (string) $payload;
        }

        return implode("\r\n", $body);
    }
}