<?php

namespace Tests\Fei\Entity;

use Codeception\Test\Unit;
use Fei\Entity\AbstractEntity;
use Fei\Entity\Exception;

class AbstractEntityTest extends Unit
{

    public function testArrayAccessOffsetExists()
    {
        $entity = new TestEntity();

        $this->assertTrue($entity->offsetExists('field'));
        $this->assertTrue($entity->offsetExists('other_field'));
        $this->assertTrue($entity->offsetExists('otherField'));

    }

    public function testArrayAccessOffsetGet()
    {
        $entity = new TestEntity();

        $entity['field'] = 'test';
        $this->assertEquals('test', $entity['field']);

        unset($entity['field']);
        $this->assertNull($entity['field']);

        $this->assertNull($entity['non-existent-property']);


    }

    public function testArrayAccessOffsetSet()
    {
        $entity = new TestEntity();

        $entity['field'] = 'test';
        $this->assertEquals('test', $entity['field']);

        $this->expectException(Exception::class);
        $entity['non-existent-property'] = 'test';
    }

    public function testArrayAccessOffsetUnset()
    {
        $entity = new TestEntity();

        $entity['field'] = 'test';
        unset($entity['field']);
        $this->assertNull($entity['field']);


        $this->expectException(Exception::class);
        $entity['non-existent-property'] = 'test';
    }

    /**
     * @dataProvider CamelToSnakeDataProvider
     */
    public function testCamelToSnakeCaseConversion($camel, $snake)
    {
        $entity = new TestEntity();

        $this->assertEquals($snake, $entity->toSnakeCase($camel));
    }

    public function CamelToSnakeDataProvider()
    {
        return [
            ["camelCase", "camel_case"],
            ["CamelCase", "camel_case"],
            ["camel", "camel"]
        ];
    }

    /**
     * @dataProvider SnakeToCamelDataProvider
     */
    public function testSnakeToCamelCaseConversion($snake, $camel)
    {
        $entity = new TestEntity();

        $this->assertEquals($camel, $entity->toCamelCase($snake));
    }

    public function SnakeToCamelDataProvider()
    {
        return [
            ["snake_case", "SnakeCase"],
            ["snake", "Snake"]
        ];
    }

    public function testPropertiesMapping()
    {
        $entity = new TestEntity();

        $this->assertFalse($entity->offsetExists('legacy_name'));
        $this->assertTrue($entity->offsetExists('mapped_field'));

        $entity['legacy_name'] = 'test';
        $this->assertEquals('test', $entity['mapped_field']);

    }

    public function testEntityHydrationAndConversionToArray()
    {
        $entity = new TestEntity();
        $data = ['legacy_name' => 'x', 'field' => 'y', 'other_field' => 'z'];
        $entity->hydrate($data);

        $this->assertEquals('x', $entity['legacy_name']);
        $this->assertEquals('x', $entity['mapped_field']);
        $this->assertEquals('x', $entity['mappedField']);
        $this->assertEquals('y', $entity['field']);
        $this->assertEquals('z', $entity['other_field']);

        // output mapped array
        $this->assertEquals($data, $entity->toArray(true));

        // output unmapped array
        $unmappedExpectedData = $data;
        $unmappedExpectedData['mapped_field'] = $data['legacy_name'];
        unset($unmappedExpectedData['legacy_name']);
        $this->assertEquals($unmappedExpectedData, $entity->toArray());
    }

    /**
     * @depends testEntityHydrationAndConversionToArray
     */
    public function testHydrationFromArrayObject()
    {
        $entity = new TestEntity();
        $data = new \ArrayObject(['legacy_name' => 'x', 'field' => 'y', 'other_field' => 'z']);
        $entity->hydrate($data);
        $this->assertEquals($data->getArrayCopy(), $entity->toArray(true));

    }

    /**
     * @depends testEntityHydrationAndConversionToArray
     */
    public function testHydrationFromIterator()
    {
        $entity = new TestEntity();
        $data = new \ArrayIterator(['legacy_name' => 'x', 'field' => 'y', 'other_field' => 'z']);
        $entity->hydrate($data);
        $this->assertEquals(iterator_to_array($data), $entity->toArray(true));

    }

    public function testHydrationFailsIfSourceIsNotIterable()
    {
        $entity = new TestEntity();

        $this->expectException(Exception::class);
        $entity->hydrate('this string is not iterable!');
    }

    public function testDateTimeToArray()
    {
        $entity = new TestEntity();

        $date = new \DateTime();
        $entity->setField($date);

        $this->assertEquals(
            ['field' => $date->format('c'), 'other_field' => null, 'mapped_field' => null],
            $entity->toArray()
        );
    }
}


class TestEntity extends AbstractEntity
{

    protected $field;
    protected $otherField;
    protected $mappedField;

    protected $mapping = [
      'legacy_name' => 'mapped_field'
    ];

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return mixed
     */
    public function getOtherField()
    {
        return $this->otherField;
    }

    /**
     * @param mixed $otherField
     */
    public function setOtherField($otherField)
    {
        $this->otherField = $otherField;
    }


    /**
     * @return mixed
     */
    public function getMappedField()
    {
        return $this->mappedField;
    }

    /**
     * @param mixed $mappedField
     */
    public function setMappedField($mappedField)
    {
        $this->mappedField = $mappedField;
    }

}
