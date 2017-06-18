<?php

namespace app\models;

/**
 * Interface ModelCollectionInterface
 *
 * // 2 models in collection of type ChildModel
 * $modelCollection = ModelCollection::create([['id'=>1],['id'=>2]],ChildModel::class);
 */
interface ModelCollectionInterface
{
    /**
     * ModelCollectionFactory create model collection
     * @param array $data data for the models
     * @param string $class optional if you want to override model classes inside the collection
     * @return ModelCollectionInterface
     */
    public static function create( array $data, string $class = null ): ModelCollectionInterface;

    /**
     * get all the models from collection
     * @return iterable ModelInterface[]
     */
    public function getModels(): iterable;

    /**
     * add a model to current collection
     * @param ModelInterface $model valid model
     * @return ModelCollectionInterface
     */
    public function addModel( ModelInterface $model ): ModelCollectionInterface;

    /**
     * count data in array
     * @return int how many entries
     */
    public function count(): int;

    /**
     * sort data entries by a field
     * @return void
     */
    public function sort(): void;

    /**
     * verbose the collection for printing
     * @return string
     */
    public function __toString(): string;
}