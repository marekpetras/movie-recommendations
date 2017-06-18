<?php

namespace app\models\data;

use app\models\Model;
use app\models\ModelCollectionInterface;
use app\models\criteria\CriteriaInterface;
use app\models\ModelException;

/**
 * Class Data
 * represents data
 */
class Data extends Model implements DataInterface
{
    protected $_acceptableCriteria = [];
    protected $_config;

    /**
     * return the acceptable criteria that cna be applied to this model for filtering
     * @return array
     */
    public function getAcceptableCriteria(): array
    {
        return $this->_acceptableCriteria;
    }

    /**
     * get criteria configuration for this model
     * @return array
     */
    public function getConfig(): array
    {
        return $this->_config;
    }
}