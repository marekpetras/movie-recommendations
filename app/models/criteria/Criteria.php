<?php

namespace app\models\criteria;

use app\models\Model;
use app\models\ModelInterface;
use app\models\ModelException;

/**
 * Class Critera
 */
class Criteria extends Model implements CriteriaInterface
{
    /**
     * @var string $_value value placeholder
     */
    protected $_value;
    /**
     * @var string $_type criteria type
     */
    protected $_type = null;

    /**
     * FactoryOverride to change model class from $data['type']
     * @param array $data
     * @return ModelInterface child implementation
     */
    public static function create( array $data ): ModelInterface
    {
        $class = static::class.ucfirst($data['type']);
        if ( !class_exists($class) ) {
            throw new ModelException(
                sprintf('"%s" is invalid criteria type',$data['type'])
            );
        }
        return new $class($data);
    }

    /**
     * get type
     * @return string type
     * @throws ModelException on unset type
     */
    public function getType(): string
    {
        if ( !$this->_type ) {
            throw new ModelException('You have to specify type in order to use it.');
        }

        return $this->_type;
    }

    /**
     * get value (only string values supported)
     * @return string
     */
    public function getValue(): string
    {
        return $this->_data['value'];
    }
}