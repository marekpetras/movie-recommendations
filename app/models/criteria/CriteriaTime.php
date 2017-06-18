<?php

namespace app\models\criteria;

use app\models\ModelException;
use DateTime;
use DateTimeZone;
use DateInterval;

/**
 * Class CriteriaTime
 */
class CriteriaTime extends Criteria implements CriteriaInterface
{
    /**
     * @var string $_type criteria type
     */
    protected $_type = 'CriteriaTime';

    /**
     * validate data according to requirements
     * @param array $data input data
     * @return void
     * @throws ModelException on invalid
     */
    protected function validateData( array $data ): void
    {
        try {
            new DateTime($data['value']);
        } catch (\Exception $e) {
            throw new ModelException(sprintf('"%s" Invalid datetime string', $data['value']));
        }
    }

    /**
     * get value (only string values supported)
     * @return string
     */
    public function getValue(): string
    {
        $dt = new DateTime($this->_data['value']);
        $dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
        $seconds = ($dt->format('H') * 3600) + ($dt->format('i') * 60) + $dt->format('s');

        return $seconds;
    }
}