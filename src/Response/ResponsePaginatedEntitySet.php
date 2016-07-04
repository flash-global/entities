<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 04/07/2016
 * Time: 14:18
 */

namespace Response;


use Fei\Entity\PaginatedEntitySet;

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