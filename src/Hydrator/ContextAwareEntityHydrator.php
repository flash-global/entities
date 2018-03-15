<?php

namespace Fei\Entities\Hydrator;

use Fei\Entities\ContextAwareEntityInterface;
use ObjectivePHP\Gateway\Entity\EntityInterface;
use ObjectivePHP\Gateway\Hydrator\DenormalizedDataExtractorInterface;
use Zend\Hydrator\ClassMethods;

/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 09/08/2017
 * Time: 10:02
 */
class ContextAwareEntityHydrator extends ClassMethods implements DenormalizedDataExtractorInterface
{
    public function __construct($underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);
        
        $this->removeFilter('is');
    }
    
    
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof ContextAwareEntityInterface) {
            return $object;
        }
        
        // process denormalized context
        $processedData = ['context' => []];
        foreach ($data as $key => $value) {
            if (strpos($key, 'context_') === 0) {
                $processedData['context'][substr($key, 8)] = $value;
            } else {
                $processedData[$key] = $value;
            }
        }
        unset($data);
        
        return parent::hydrate($processedData, $object);
    }
    
    public function extractDenormalized($entity)
    {
        $data = $this->extract($entity);
        
        if($entity instanceof EntityInterface)
        {
            // remove Entity specific fields
            $fields = $entity->getEntityFields();
            foreach($data as $key => $value)
            {
                if(!in_array($key, $fields)) unset($data[$key]);
            }
        }
        
        
        return $this->denormalizeData($data);
    }
    
    public function denormalizeData(array $data) : array
    {
        if (!isset($data['context'])) {
            return $data;
        }
        
        foreach ($data['context'] as $key => $value) {
            $data['context_' . $key] = $value;
        }
        
        unset($data['context']);
        
        return $data;
    }
    
}
