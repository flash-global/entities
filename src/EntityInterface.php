<?php

namespace Fei\Entity;

/**
 * Interface EntityInterface
 *
 * @package Fei\Entity
 */
interface EntityInterface
{
    /**
     * @param $data array|\ArrayObject|\Traversable
     * @return $this
     */
    public function hydrate($data);

    /**
     * @return array
     */
    public function toArray();
}
