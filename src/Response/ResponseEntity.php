<?php

namespace Response;

use Fei\Entity\AbstractEntity;

/**
 * Class ResponseEntity
 *
 * @package Response
 */
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