<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 09/08/2017
 * Time: 10:11
 */

namespace Tests\Fei\Entities\Hydrator;


use Codeception\Test\Unit;
use Fei\Entities\ContextAwareEntityInterface;
use Fei\Entities\ContextAwareTrait;
use Fei\Entities\Hydrator\ContextAwareEntityHydrator;

/**
 * Class ContextAwareEntityHydratorTest
 *
 * @package Tests\Fei\Entities\Hydrator
 */
class ContextAwareEntityHydratorTest extends Unit
{
    public function testHydration()
    {
        
        $hydrator = new ContextAwareEntityHydrator();
        
        $entity = new SomeEntity();
        
        $hydrator->hydrate(['foo' => 'foo value', 'bar' => 'bar value', 'context' => ['x' => 'y']], $entity);
        
        $this->assertEquals('foo value', $entity->getFoo());
        $this->assertEquals('bar value', $entity->getBar());
        $this->assertEquals('y', $entity->getContext('x'));
        
    }
    
    public function testHydrationUsingDenormalizedContext()
    {
        
        $hydrator = new ContextAwareEntityHydrator();
        
        $entity = new SomeEntity();
        
        $hydrator->hydrate(['foo' => 'foo value', 'bar' => 'bar value', 'context_x' => 'y'], $entity);
        
        $this->assertEquals('foo value', $entity->getFoo());
        $this->assertEquals('bar value', $entity->getBar());
        $this->assertEquals('y', $entity->getContext('x'));
        
        return $entity;
        
    }
    
    /**
     * @depends testHydrationUsingDenormalizedContext
     */
    public function testExtraction(SomeEntity $entity)
    {
        $hydrator = new ContextAwareEntityHydrator();
        $this->assertEquals(['foo' => 'foo value', 'bar' => 'bar value', 'context' => ['x' => 'y']], $hydrator->extract($entity));
    }
    
    /**
     * @depends testHydrationUsingDenormalizedContext
     */
    public function testExtractionWithDenormalizedContext(SomeEntity $entity)
    {
        $hydrator = new ContextAwareEntityHydrator();
        $this->assertEquals(['foo' => 'foo value', 'bar' => 'bar value', 'context_x' => 'y'], $hydrator->extractDenormalized($entity));
    }
}


class SomeEntity implements ContextAwareEntityInterface
{
    
    use ContextAwareTrait;
    
    protected $foo;
    
    protected $bar;
    
    /**
     * @return mixed
     */
    public function getFoo()
    {
        return $this->foo;
    }
    
    /**
     * @param mixed $foo
     *
     * @return $this
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;
    
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getBar()
    {
        return $this->bar;
    }
    
    /**
     * @param mixed $bar
     *
     * @return $this
     */
    public function setBar($bar)
    {
        $this->bar = $bar;
    
        return $this;
    }
    
}
