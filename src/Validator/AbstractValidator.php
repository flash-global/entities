<?php
    
    namespace Fei\Entity\Validator;
    
    abstract class AbstractValidator implements ValidatorInterface
    {
        /**
         * @var array
         */
        protected $errors = array();
    
        /**
         * @return array
         */
        public function getErrors()
        {
            return $this->errors;
        }
    
        /**
         * @param string $attribute
         * @param string $message
         *
         * @return $this
         */
        public function addError($attribute, $message)
        {
            $this->errors[$attribute][] = $message;
        
            return $this;
        }
    
        /**
         * @return $this
         */
        protected function clearErrors()
        {
            $this->errors = array();
        
            return $this;
        }
    
        /**
         * @return string
         */
        public function getErrorsAsString()
        {
            $errors = array();
            foreach ($this->getErrors() as $attribute => $attrErrors)
            {
                $errors[] = $attribute . ': ' . implode(', ', $attrErrors);
            }
        
            return implode('; ', $errors);
        }
    }
