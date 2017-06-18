<?php

namespace app\models\interfaces;

use app\models\ModelCollectionInterface;
use app\models\criteria\CriteriaInterface;

/**
 * Interface FilterableCollectionInterface
 *
 * $criteriaCollection = CriteriaCollection::create([['type'=>'genre','value'=>'comedy']]);
 * $collection = ModelCollection::create([['name'=>'movie','genre'=>['comedy']]]);
 * $collection->applyCriteria($criteria); // filter matches, so movie stays
 */
interface FilterableCollectionInterface
{
    /**
     * apply criteria collection to list and retrieve only matching
     * @param CriteriaCollectionInterface $criterias
     * @return DataInterface
     */
    public function applyCriteriaCollection(
        ModelCollectionInterface $criterias
    ): ModelCollectionInterface;
    /**
     * apply specific criteria
     * @param CriteriaInterface $criteria
     * @return void
     * @todo validate config
     * @todo implement criteria match for other types in the switch stmt
     */
    public function applyCriteria( CriteriaInterface $criteria ): void;
}