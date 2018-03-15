<?php

namespace Response;

use Fei\Entity\EntitySet;

/**
 * Class ResponseEntitySet
 *
 * @package Response
 */
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
