<?php

use PHPUnit\Framework\TestCase;

use app\models\data\Data;
use app\models\data\DataMovies;
use app\models\data\DataCollection;
use app\models\ModelInterface;
use app\models\ModelException;
use app\models\ModelCollectionInterface;

/**
 * @covers app\services\data\Data
 * @covers app\services\data\DataMovies
 * @covers app\services\data\DataCollection
 */
class DataTest extends TestCase
{
    public function testCreateValidCollection(): void
    {
        $data = DataCollection::create($this->getValidData(), DataMovies::class);

        $this->assertInstanceOf(
            ModelCollectionInterface::class,
            $data
        );

        $this->assertContainsOnlyInstancesOf(
            Data::class,
            $data->getModels()
        );

        $this->assertGreaterThan(
            0,
            $data->count()
        );
    }

    public function testCreateInvalidCollection(): void
    {
        $this->expectException(
            ModelException::class
        );

        $data = DataCollection::create($this->getInvalidData(), DataMovies::class);
    }

    private function getValidData(): array
    {
        return array (
          0 =>
          array (
            'name' => 'Moonlight',
            'rating' => 98,
            'genres' =>
            array (
              0 => 'Drama',
            ),
            'showings' =>
            array (
              0 => '18:30:00+11:00',
              1 => '20:30:00+11:00',
            ),
          ),
          1 =>
          array (
            'name' => 'Zootopia',
            'rating' => 92,
            'genres' =>
            array (
              0 => 'Action & Adventure',
              1 => 'Animation',
              2 => 'Comedy',
            ),
            'showings' =>
            array (
              0 => '19:00:00+11:00',
              1 => '21:00:00+11:00',
            ),
          ),
          2 =>
          array (
            'name' => 'The Martian',
            'rating' => 92,
            'genres' =>
            array (
              0 => 'Science Fiction & Fantasy',
            ),
            'showings' =>
            array (
              0 => '17:30:00+11:00',
              1 => '19:30:00+11:00',
            ),
          ),
          3 =>
          array (
            'name' => 'Shaun The Sheep',
            'rating' => 80,
            'genres' =>
            array (
              0 => 'Animation',
              1 => 'Comedy',
            ),
            'showings' =>
            array (
              0 => '19:00:00+11:00',
            ),
          ),
        );
    }

    private function getInvalidData(): array
    {
        return [[]];
    }
}