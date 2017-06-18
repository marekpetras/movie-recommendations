<?php

date_default_timezone_set('Australia/Sydney');

require_once __DIR__.'/vendor/autoload.php';

use app\services\transfer\Socket;
use app\services\transfer\requests\GetRequest;
use app\services\transfer\responsedecoders\ResponseDecoder;
use app\services\transfer\Transfer;
use app\services\source\Pastebin;
use app\models\data\DataMovies;
use app\models\data\DataCollection;
use app\models\criteria\CriteriaCollection;

try {
    // load criteria
    $arguments = getopt('',['genre:','time:']);
    $criteria = [];
    foreach ( $arguments as $type => $value ) {
        $criteria[] = ['type'=>$type,'value'=>$value];
    }
    $criteriaCollection = CriteriaCollection::create($criteria);

    // get movie list
    $source  = new Pastebin();
    $decoder = new ResponseDecoder;
    $socket  = new Socket();
    $socket->setResponseDecoder($decoder);


    $transfer   = new Transfer($socket,$source);
    $body       = $transfer->getResponse(new GetRequest())
                    ->getBody();

    $list       = json_decode($body,true);

    if ( !$list || json_last_error() ) {
        throw new Exception(sprintf('Failed to json decode response; error "%s"',json_last_error_msg()));
    }

    // run recommendations
    $data = DataCollection::create($list, DataMovies::class);
    $data = $data->applyCriteriaCollection($criteriaCollection);

    echo $data;
}
catch (Exception $e) {
    die((string)$e);
}

