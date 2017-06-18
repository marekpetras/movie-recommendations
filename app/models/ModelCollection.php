<?php

namespace app\models;

/**
 * Class ModelCollection
 * @todo implement iterable
 */
class ModelCollection implements ModelCollectionInterface
{
    protected $_models = [];

    /**
     * @var string $modelClass child class models
     */
    protected static $modelClass;

    /**
     * ModelCollectionFactory create model collection
     * @param array $data data for the models
     * @param string $class optional if you want to override model classes inside the collection
     * @return ModelCollectionInterface
     */
    public static function create( array $data, string $class = null ): ModelCollectionInterface
    {
        if ( !$class ) {
            $class = static::$modelClass;
        }

        if ( !class_exists($class) ) {
            throw new ModelCollectionException(sprintf('%s is not a valid model class',$class));
        }

        $collectionClass = get_called_class();
        $collection = new $collectionClass;
        foreach ( $data as $model ) {
            $collection->addModel($class::create($model));
        }
        return $collection;
    }

    /**
     * get all the models from collection
     * @return iterable ModelInterface[]
     */
    public function getModels(): iterable
    {
        return $this->_models;
    }

    /**
     * add a model to current collection
     * @param ModelInterface $model valid model
     * @return ModelCollectionInterface
     */
    public function addModel( ModelInterface $model ): ModelCollectionInterface
    {
        $this->_models[] = $model;
        return $this;
    }

    /**
     * count data in array
     * @return int how many entries
     */
    public function count(): int
    {
        return count($this->_models);
    }

    /**
     * sort data entries by a field
     * @return void
     */
    public function sort(): void
    {
        if ( !$this->sort ) {
            return;
        }

        uasort($this->_models, function($a,$b){
            return $a->getData()[$this->sort] < $b->getData()[$this->sort];
        });
    }

    /**
     * verbose the collection for printing
     * @return string
     */
    public function __toString(): string
    {
        $str = '';
        foreach ( $this->getModels() as $model ) {
            $str .= (string) $model;
        }
        return $str;
    }
}