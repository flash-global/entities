<?php

namespace Fei\Entities;


interface ContextAwareEntityInterface
{
    /**
     * @param      $context
     * @param null $value
     *
     * @return $this
     */
    public function setContext($context, $value = null);
    
    /**
     * @return mixed
     */
    public function getContext($context = null, $default = null);
    
}
