<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 04/07/2016
 * Time: 14:17
 */

namespace Response;


use Fei\Entity\AbstractEntity;

class ResponseEntity extends AbstractEntity
{
    /** @var  array */
    protected $meta;

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     *
     * @return ResponseEntity
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

}