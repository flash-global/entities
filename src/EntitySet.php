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
            $set[] = $entity->toArray();
        }

        return $set;
    }

    public function isEmpty()
    {
        return !(bool) count($this);
    }

}
