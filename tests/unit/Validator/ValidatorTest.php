<?php

    namespace Tests\Fei\Service\Mailer\Validator;

    use Codeception\Test\Unit;
    use Fei\Entity\EntityInterface;
    use Fei\Entity\Validator\AbstractValidator;

    class MailValidatorTest extends Unit
    {

        public function testErrorAddition()
        {
            $validator = new TestValidator();

            $validator->addError('attr', 'msg');

            $this->assertAttributeEquals(array('attr' => array('msg')), 'errors', $validator);

        }


        public function testErrorsToStringConversion()
        {
            $validator = new TestValidator();
            $validator->addError('attribute', 'message')
                      ->addError('otherAttribute', 'otherMessage')
                      ->addError('otherAttribute', 'anotherMessage')
            ;

            $this->assertEquals('attribute: message; otherAttribute: otherMessage, anotherMessage', $validator->getErrorsAsString());

        }
    }

    // HELPERS

    class TestValidator extends AbstractValidator
    {
        public function validate(EntityInterface $entity)
        {

        }

    }
