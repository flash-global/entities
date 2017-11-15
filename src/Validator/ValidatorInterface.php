<?php

namespace Fei\Entity\Validator;

use Fei\Entity\EntityInterface;

/**
 * Interface ValidatorInterface
 *
 * @package Fei\Entity\Validator
 */
interface ValidatorInterface
{

    /**
     * @param EntityInterface $entity
     *
     * @return bool
     */
    public function validate(EntityInterface $entity);

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
