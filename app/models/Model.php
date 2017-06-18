<?php

namespace app\models;

/**
 * Class Model
 */
class Model implements ModelInterface
{
    protected $_allowEmpty = false;
    protected $_data;
    protected $_sort;

    /**
     * Constructor
     * @param array $data input data, will be validated
     */
    public function __construct( array $data )
    {
        $this->validateData($data);
        $this->_data = $data;
    }

    /**
     * ModelFactory create model and fill it with data
     * @param array $data input data
     * @return ModelInterface
     */
    public static function create( array $data ): ModelInterface
    {
        $class = get_called_class();

        if ( !class_exists($class) ) {
            throw new ModelException(
                sprintf('%s is not a valid criteria type', $type)
            );
        }

        return new $class($data);
    }

    /**
     * Data getter
     * @return array data
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * Data setter
     * @param array $data
     * @return ModelInterface
     */
    public function setData( array $data ): ModelInterface
    {
        $this->validateData($data);

        $this->_data = $data;
        return $this;
    }

    /**
     * validate data according to requirements
     * @param array $data input data
     * @return void
     * @throws ModelException on invalid
     */
    protected function validateData( array $data ): void
    {
        if ( isset($this->_allowEmpty) && $this->_allowEmpty === false ) {
            if ( !is_array($data) || empty($data) || count($data) == 0 ) {
                throw new ModelException('Data failed validation, is empty');
            }
        }
    }

    /**
     * verbose the collection for printing
     * @return string
     */
    public function __toString(): string
    {
        return print_r($this->getData(), true);
    }
}