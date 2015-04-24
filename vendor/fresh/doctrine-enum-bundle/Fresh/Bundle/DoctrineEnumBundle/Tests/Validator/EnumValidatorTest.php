<?php
/*
 * This file is part of the FreshDoctrineEnumBundle
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\Bundle\DoctrineEnumBundle\Tests\Validator;

use Fresh\Bundle\DoctrineEnumBundle\Fixtures\DBAL\Types\BasketballPositionType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints\Enum;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints\EnumValidator;
use Symfony\Component\Validator\ExecutionContext;

/**
 * EnumValidatorTest
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @coversDefaultClass \Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints\EnumValidator
 */
class EnumValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EnumValidator
     */
    private $enumValidator;

    /**
     * @var ExecutionContext|\PHPUnit_Framework_MockObject_MockObject
     */
    private $context;

    /**
     * Set up EnumValidator
     */
    public function setUp()
    {
        $this->enumValidator = new EnumValidator();
        $this->context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')
                              ->disableOriginalConstructor()
                              ->getMock();
    }

    /**
     * Test that creation of ENUM Constraint without type class throws ConstraintDefinitionException
     *
     * @test
     * @covers ::validate
     * @expectedException \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public function exceptionEntityNotSpecified()
    {
        $this->enumValidator->validate(BasketballPositionType::POINT_GUARD, new Enum());
    }

    /**
     * Test valid basketball position
     *
     * @test
     * @covers ::validate
     */
    public function validBasketballPositionType()
    {
        $constraint = new Enum([
            'entity' => 'Fresh\Bundle\DoctrineEnumBundle\Fixtures\DBAL\Types\BasketballPositionType'
        ]);

        $this->context
             ->expects($this->never())
             ->method('addViolation');

        $this->enumValidator->initialize($this->context);
        $this->enumValidator->validate(BasketballPositionType::SMALL_FORWARD, $constraint);
    }

    /**
     * Test invalid basketball position
     *
     * @test
     * @covers ::validate
     */
    public function invalidBasketballPositionType()
    {
        $constraint = new Enum([
            'entity' => 'Fresh\Bundle\DoctrineEnumBundle\Fixtures\DBAL\Types\BasketballPositionType'
        ]);

        $this->context
             ->expects($this->once())
             ->method('addViolation')
             ->with(
                 $this->equalTo('The value you selected is not a valid choice.'),
                 $this->equalTo(['{{ value }}' => 'Pitcher'])
             );

        $this->enumValidator->initialize($this->context);
        $this->enumValidator->validate('Pitcher', $constraint); // It's not a baseball =)
    }
}
