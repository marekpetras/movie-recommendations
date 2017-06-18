<?php

namespace app\models\data;

use DateTime;
use DateInterval;
use DateTimeZone;

class DataMovies extends Data implements DataInterface
{
    protected $_acceptableCriteria = ['CriteriaGenre','CriteriaTime'];
    protected $sort = 'rating';
    protected $_config = [
            'CriteriaGenre' => [
                'dataPath' => 'genres',
                'dataType' => 'list',
                'dataMatch' => 'contains',
            ],
            'CriteriaTime' => [
                'dataPath' => 'showings',
                'dataType' => 'list',
                'dataMatch' => 'interval',
                'matchRange' => 30*60,
            ],
        ];

    /**
     * Constructor
     * translates show times to seconds in local timezone
     * @param array $data object data
     */
    public function __construct(array $data)
    {
        if ( isset($data['showings']) && is_array($data['showings']) ) {
            foreach ($data['showings'] as &$showing) {
                $dt = new DateTime($showing);
                $dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
                $seconds = ($dt->format('H') * 3600) + ($dt->format('i') * 60) + $dt->format('s');
                $showing = $seconds;
            }
        }

        parent::__construct($data);
    }

    /**
     * validate data according to requirements
     * @param array $data input data
     * @return void
     * @throws ModelException on invalid
     */
    protected function validateData( array $data ): void
    {
        parent::validateData($data);

        if ( !isset($data['showings']) || !is_array($data['showings']) ) {
            throw new ModelException('Missing showings');
        }

        if ( !isset($data['genres']) || !is_array($data['genres']) ) {
            throw new ModelException('Missing genres');
        }
    }

    /**
     * verbose the collection for printing
     * @return string
     */
    public function __toString(): string
    {
        $data = $this->getData();
        $str = '';
        foreach ( $data['showings'] as $showing ) {
            $dt = (new DateTime)->setTime(0,0,$showing);
            $str .= $data['name'].', showing at ' . $dt->format('ga T') . PHP_EOL;
        }
        return $str;
    }
}