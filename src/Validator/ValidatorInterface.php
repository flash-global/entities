<?php
    
    namespace Fei\Entity\Validator;
    
    
    use Fei\Entity\AbstractEntity;

    interface ValidatorInterface
    {
    
        /**
         * @param AbstractEntity $entity
         *
         * @return bool
         */
        public function validate(AbstractEntity $entity);
    
        /**
         * @return array
         */
        public function getErrors();
    
        /**
         * @return string
         */
        public function getErrorsAsString();
    
        /**
         * @param $attribute
         * @param $message
         *
         * @return $this
         */
        public function addError($attribute, $message);
        
    }
