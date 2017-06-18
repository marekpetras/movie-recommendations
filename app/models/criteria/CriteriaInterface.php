<?php

namespace app\models\criteria;

/**
 * Interface CriteriaInterface
 */
interface CriteriaInterface
{
    /**
     * get type
     * @return string type
     * @throws ModelException on unset type
     */
    public function getType(): string;

    /**
     * get value (only string values supported)
     * @return string
     */
    public function getValue(): string;
}