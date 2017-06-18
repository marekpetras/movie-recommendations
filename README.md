# movie-recommendations

Simple console app to get movie recommendations

requirements: php 7.1+

usage:

```php index.php --genre=Comedy --time=12:00```

shows movies loaded from source that are comedies and have a showing time in the interval 12:00 - 12:30

time format can be any reasonable time string that can be parsed by php http://php.net/manual/en/datetime.formats.php


you can run tests with unit-bootstrap.php that also runs your built in webserver
```./vendor/bin/phpunit --bootstrap=unit-bootstrap.php tests```


# to-do
what could be done to make it more robust:

more comprehensive functional testing
implement DI container
add more decoders for responses
finish and refactor the Model dao
create another service that would take the collection and apply the filters from one to another

# few notes
i have decided not to use any preprogrammed

the codebase is a bit bigger then it is required for this specific tool, but with future in mind i decided to go for this, even though I spent a bit more time

the transfer service code base was actually done by me for another project as a PhalconPHP service, i did recode most of it, but the general implementation and idea stayed the same
we needed a way to separate reading and writing to and from endpoints in order to save time and for batching requests together via the Payloads, specifically googles measurement protocol, which doesnt actually have any response and we needed to write hundreds of thousands hits within a very strict and limited time window

would go something like this
```php
<?php
// mock example
$protocol->startBatching();
while (have hits) {
    // load next batch
    foreach (Hits::load($page) as $hit)
        $protocol->send($hit);
    $page++;
}
$protocol->send(null,true);

class MeasurementProtocol
{
    public function send( array $payload = null, bool $sendAllPayloads = false ): self
    {
        if ( $payload ) {
            $this->getBody()->addPayload($payload);
        }

        if ( !$this->getBody()->hasPayloads() && !$sendAllPayloads ) {
            self::ex('No payloads to send');
        }

        if ( $sendAllPayloads && !$this->getBody()->hasPayloads() ) {
            return $this;
        }

        if ( $this->_batch  && !$sendAllPayloads
            && $this->getBody()->countPayloads() < $this->_batchSize ) {
            return $this;
        }

        if ( $this->getBody()->countPayloads() > $this->_maxBatchSize ) {
            self::ex(
                'Have more payloads (%d) then max allowed (%d).',
                $this->getBody()->countPayloads(), $this->_maxBatchSize
            );
        }

        $this->getSocket()->write(
            $this->getRequest($this->getBody())
        );

        $this->getBody()->clearPayloads();

        return $this;
    }

    public function startBatching( int $batchSize = 20 ): self
    {
        if ( $batchSize > $this->_maxBatchSize ) {
            self::ex(
                'Max batch size is %d, you requested %d',
                $this->_maxBatchSize, $batchSize
            );
        }

        $this->_batch = true;
        $this->_batchSize = $batchSize;

        return $this;
    }
}
?>
```