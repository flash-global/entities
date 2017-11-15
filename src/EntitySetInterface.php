<?php

namespace Fei\Entity;

/**
 * Interface EntitySetInterface
 *
 * @package Fei\Entity
 */
interface EntitySetInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @return bool
     */
    public function isEmpty();
}
