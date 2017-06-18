<?php

namespace app\models;

/**
 * Interface ModelInterface
 */
interface ModelInterface
{
    /**
     * ModelFactory create model and fill it with data
     * @param array $data input data
     * @return ModelInterface
     */
    public static function create( array $data ): ModelInterface;

    /**
     * Data getter
     * @return array data
     */
    public function getData(): array;

    /**
     * Data setter
     * @param array $data
     * @return ModelInterface
     */
    public function setData( array $data ): ModelInterface;

    /**
     * verbose the collection for printing
     * @return string
     */
    public function __toString(): string;
}