<?php

use PHPUnit\Framework\TestCase;

use app\models\criteria\Criteria;
use app\models\criteria\CriteriaCollection;
use app\models\ModelException;

/**
 * @covers app\services\criteria\Criteria
 * @covers app\services\criteria\CriteriaGenre
 * @covers app\services\criteria\CriteriaTime
 * @covers app\services\criteria\CriteriaCollection
 */
class CriteriaTest extends TestCase
{
    public function testCreate(): void
    {
        $criteriaCollection = CriteriaCollection::create(
            $this->prepArgs($this->getValidArgs())
        );

        $this->assertInstanceOf(
            CriteriaCollection::class,
            $criteriaCollection
        );

        $this->assertContainsOnlyInstancesOf(
            Criteria::class,
            $criteriaCollection->getModels()
        );
    }

    public function testCreateInvalid(): void
    {
        foreach ( $this->getInvalidArgs() as $args ) {
            $this->expectException(
                ModelException::class
            );

            $criteriaCollection = CriteriaCollection::create(
                $this->prepArgs($args)
            );
        }
    }

    private function getValidArgs(): array
    {
        return ['genre'=>'Comedy','time'=>'12:00'];
    }

    private function getInvalidArgs(): array
    {
        return [
            ['genre'=>'Comedy','wrongtype'=>'some arg'],
            ['genre'=>'Comedy','time'=>'some invalid time format'],
        ];
    }

    private function prepArgs(array $args): array
    {
        $criteria = [];
        foreach ( $args as $type => $value ) {
            $criteria[] = ['type'=>$type,'value'=>$value];
        }
        return $criteria;
    }
}