<?php

namespace Fei\Entity;


/**
 * Class EntitySet
 * @package Pricer\Entity
 */
class EntitySet extends \ArrayObject implements EntitySetInterface
{
    
    /**
     * @return array
     */
    public function toArray()
    {
        $set = array();

        foreach($this as $entity)
        {
            switch(true) {
                
                case $entity instanceof EntityInterface:
                case is_object($entity) && method_exists($entity, 'toArray'):
                    $set[] = $entity->toArray();
                    break;
                    
                case $entity instanceof \ArrayObject:
                    $set[] = $entity->getArrayCopy();
                    break;
    
                case $entity instanceof \Iterator:
                    $set[] = iterator_to_array($entity);
                    break;
                    
                default:
                    $set = $entity;
                break;
            }
            
        }

        return $set;
    }

    public function isEmpty()
    {
        return !(bool) count($this);
    }

}
