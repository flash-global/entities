<?php
/**
 * Created by PhpStorm.
 * User: gauthier
 * Date: 09/08/2017
 * Time: 10:12
 */

namespace Fei\Entities;


use Fei\Entities\Exception\ContextException;

trait ContextAwareTrait
{
    protected $context;
    
    /**
     * @param mixed $context
     *
     * @return $this
     */
    public function setContext($context, $value = null)
    {
        if(is_null($value) && is_array($context))
        {
            foreach($context as $key => $value)
            {
                if (is_int($key)) {
                    throw new ContextException(sprintf('Context key must be a string, not an integer (key: "%s").', $key));
                }
                
                if(!is_scalar($value))
                {
                    throw new ContextException(sprintf('Context value must be scalar (key: "%s").', $key));
                }
                
                $this->context[$key] = $value;
            }
        }
        else {
            $key = $context;
            if (is_int($key)) {
                throw new ContextException(sprintf('Context key must be a string, not an integer (key: "%s").', $key));
            }
    
            if (!is_scalar($value)) {
                throw new ContextException(sprintf('Context value must be scalar (key: "%s").', $key));
            }
    
            $this->context[$key] = $value;
        }
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getContext($context = null, $default = null)
    {
        return $context ? $this->context[$context] ?? $default : $this->context;
    }
}
