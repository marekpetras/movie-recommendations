<?php

namespace app\models\data;

use app\models\ModelCollection;
use app\models\ModelCollectionInterface;
use app\models\criteria\CriteriaInterface;
use app\models\interfaces\FilterableCollectionInterface;
use DateTime;

/**
 * Class DataCollection
 */
class DataCollection extends ModelCollection implements FilterableCollectionInterface
{
    /**
     * @var default class for models in the collection
     */
    protected static $modelClass = 'app\models\data\Data';

    /**
     * @var default sort field for models in the collection
     */
    protected $sort = 'rating';

    /**
     * apply criteria collection to list and retrieve only matching
     * @param CriteriaCollectionInterface $criterias
     * @return DataInterface
     */
    public function applyCriteriaCollection(
        ModelCollectionInterface $criterias
    ): ModelCollectionInterface
    {
        $data = clone $this;

        foreach ( $criterias->getModels() as $criteria ) {
            $data->applyCriteria($criteria);
        }

        $data->sort();

        return $data;
    }

    /**
     * apply specific criteria
     * @param CriteriaInterface $criteria
     * @return void
     * @todo validate config
     * @todo implement criteria match for other types in the switch stmt
     */
    public function applyCriteria( CriteriaInterface $criteria ): void
    {
        foreach ( $this->_models as $key => &$model ) {
            if ( !in_array($criteria->getType(), $model->getAcceptableCriteria()) ) {
                continue;
            }

            // gather config and data
            $data       = $model->getData();
            $config     = $model->getConfig()[$criteria->getType()];

            $path       = $config['dataPath'];
            $type       = $config['dataType'];
            $match      = $config['dataMatch'];

            switch ($match) {
                // simple 'is in' match
                case 'contains':
                        if ( !in_array($criteria->getValue(), $data[$path]) ) {
                            unset($this->_models[$key]);
                        }
                    break;

                // check for value in range within any element of the datapath
                // remove out of range elements and if none left, remove the whole model
                case 'interval':
                        $cValue = $criteria->getValue();
                        $min    = (int)$cValue;
                        $max    = $cValue + $config['matchRange'];
                        $all    = count($data[$path]);
                        $valid  = [];

                        foreach ( $data[$path] as $pathKey => $dValue ) {
                            if ($dValue >= $min && $dValue <= $max) {
                                $valid[] = $dValue;
                            }
                            else {
                                --$all;
                            }
                        }

                        $data[$path] = $valid;
                        $model->setData($data);

                        if ( $all <= 0 ) {
                            unset($this->_models[$key]);
                        }
                    break;

                default:
                        throw new ModelException(sprintf('%s dataMatch not supported', $match));
                    break;
            }
        }
    }

    /**
     * verbose the collection for printing
     * @return string
     */
    public function __toString(): string
    {
        if ( !$this->count() ) {
            return 'no movie recommendations';
        }
        else {
            $str = '';
            foreach ( $this->getModels() as $model ) {
                $str .= (string) $model;
            }
        }
        return $str;
    }
}