<?php

namespace Fei\Entity\Extractor;

use Fei\Entity\EntityInterface;
use Fei\Entity\EntitySet;
use Fei\Entity\PaginatedEntitySet;

/**
 * Class AddressJsonApiExtractor
 *
 * @package Fei\Service\Address\Extractor
 */
class JsonApiExtractor
{
    /**
     * Extract entities form an JSON API data
     *
     * @param array $json
     *
     * @return EntityInterface|EntitySet|PaginatedEntitySet|null
     */
    public function extract(array $json)
    {
        if (!$this->hasData($json)) {
            return null;
        }

        if (!$this->isCollection($json)) {
            return $this->extractOne($json, $json['data']);
        } else {
            $data = $this->extractMultiple($json);

            if ($this->isPaginated($json)) {
                return (new PaginatedEntitySet($data))
                    ->setPerPage($json['meta']['pagination']['per_page'])
                    ->setCurrentPage($json['meta']['pagination']['current_page'])
                    ->setTotal($json['meta']['pagination']['total']);
            }

            return new EntitySet($data);
        }
    }

    /**
     * Test if JSON API data provided is paginated
     *
     * @param array $json
     *
     * @return bool
     */
    protected function isPaginated(array $json)
    {
        if (!array_key_exists('links', $json) || !array_key_exists('meta', $json)) {
            return false;
        }

        if (is_array($json['links'])
            && array_key_exists('self', $json['links'])
            && array_key_exists('first', $json['links'])
            && array_key_exists('last', $json['links'])
            && isset($json['meta']['pagination'])
            && is_array($json['meta']['pagination'])
            && array_key_exists('total', $json['meta']['pagination'])
            && array_key_exists('count', $json['meta']['pagination'])
            && array_key_exists('per_page', $json['meta']['pagination'])
            && array_key_exists('current_page', $json['meta']['pagination'])
            && array_key_exists('total_pages', $json['meta']['pagination'])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Test if JSON API data provided is a collection
     *
     * @param array $json
     *
     * @return bool
     */
    protected function isCollection(array $json)
    {
        return isset($json['data']) && is_array($json['data']) && isset($json['data'][0]);
    }

    /**
     * Test if JSON API data exists
     *
     * @param array $json
     *
     * @return bool
     */
    protected function hasData(array $json)
    {
        return isset($json['data']) && !empty($json['data']);
    }

    protected function dataHasType(array $data)
    {
        return isset($data['type']) && !empty($data['type']);
    }

    protected function dataType(array $data)
    {
        return $this->dataHasType($data) ? $data['type'] : null;
    }

    protected function dataId(array $data)
    {
        return isset($data['id']) ? $data['id'] : null;
    }

    protected function dataAttributes(array $data)
    {
        return isset($data['attributes']) ? $data['attributes'] : null;
    }

    protected function dataHasRelationships(array $data)
    {
        return isset($data['relationships']) && !empty($data['relationships']);
    }

    protected function dataRelationships(array $data)
    {
        return $this->dataHasRelationships($data) ? $data['relationships'] : null;
    }

    protected function included(array $json)
    {
        return isset($json['included']) ? $json['included'] : null;
    }

    protected function findDataRelationship($json, $relation)
    {
        $included = $this->included($json);

        if (empty($included)) {
            return null;
        }

        if ($this->isCollection(['data' => $relation])) {
            $relations = [];
            foreach ($relation as $item) {
                $result = $this->scanIncluded($included, $this->dataType($item), $this->dataId($item));
                if ($result) {
                    $relations[] = $result;
                }
            }

            return $relations;
        }

        return $this->scanIncluded($included, $this->dataType($relation), $this->dataId($relation));
    }

    protected function scanIncluded($included, $type, $id)
    {
        foreach ($included as $data) {
            if ($this->dataHasType($data) && $this->dataId($data)) {
                if ($this->dataType($data) == $type && $this->dataId($data) == $id) {
                    return $data;
                }
            }
        }

        return null;
    }

    protected function createInstance($data)
    {
        if ($data) {
            $id = $this->dataId($data);
            $type = $this->dataType($data);

            $data = $this->dataAttributes($data);
            $data['id'] = $id;

            if (class_exists($type)) {
                return new $type($data);
            }

            return $data;
        }

        return null;
    }

    /**
     * Extract an entity from data
     *
     * @param array $json
     * @param array $data
     *
     * @return array|EntityInterface
     * @throws JsonApiExtractException
     */
    protected function extractOne(array $json, array $data)
    {
        if ($this->dataHasType($data)) {
            if ($this->dataHasRelationships($data)) {
                foreach ($this->dataRelationships($data) as $attribute => $relationship) {
                    $relation = $this->findDataRelationship($json, $relationship['data']);
                    if ($this->isCollection(['data' => $relation])) {
                        foreach ($relation as $item) {
                            $data['attributes'][$attribute][] = $this->createInstance($item);
                        }
                    } else {
                        $data['attributes'][$attribute] = $this->createInstance($relation);
                    }
                }
            }

            return $this->createInstance($data);
        }

        throw new JsonApiExtractException('No data type provided');
    }

    protected function extractMultiple(array $json)
    {
        $return = [];
        foreach ($json['data'] as $entry) {
            $return[] = $this->extractOne($json, $entry);
        }

        return $return;
    }
}
