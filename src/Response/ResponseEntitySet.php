<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 04/07/2016
 * Time: 14:18
 */

namespace Response;


use Fei\Entity\EntitySet;

class ResponseEntitySet extends EntitySet
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
     * @return ResponseEntitySet
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }
    
}