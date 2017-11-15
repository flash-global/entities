<?php

namespace Response;

use Fei\Entity\PaginatedEntitySet;

/**
 * Class ResponsePaginatedEntitySet
 *
 * @package Response
 */
class ResponsePaginatedEntitySet extends PaginatedEntitySet
{
    /** @var  array */
    protected $links;

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
     * @return ResponsePaginatedEntitySet
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     *
     * @return ResponsePaginatedEntitySet
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }
}
