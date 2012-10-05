<?php
/**
 * Mohiva Pyramid
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.textile.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/mohiva/pyramid/blob/master/LICENSE.textile
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\test\pyramid;

use com\mohiva\pyramid\OperandTable;
use com\mohiva\pyramid\Token;

/**
 * Unit test case for the Mohiva Pyramid project.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class OperandTableTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test the `addOperand` and `getOperand` accessors.
	 */
	public function testOperandAccessors() {

		/* @var \PHPUnit_Framework_MockObject_MockObject $operand */
		$operand = $this->getMock('com\mohiva\pyramid\Operand');
		$operand->expects($this->any())
			->method('getIdentifiers')
			->will($this->returnValue(array(1)));

		/* @var \com\mohiva\pyramid\Operand $operand */
		$token = new Token(1, 1, 1);
		$table = new OperandTable();
		$table->addOperand($operand);

		$this->assertSame($operand, $table->getOperand($token));
	}

	/**
	 * Test if the `addOperand` method throws an exception if an identifier is used for two operands.
	 *
	 * @expectedException \com\mohiva\pyramid\exceptions\DoubleIdentifierUsageException
	 */
	public function testAddOperandThrowsException() {

		/* @var \PHPUnit_Framework_MockObject_MockObject $operand1 */
		$operand1 = $this->getMock('com\mohiva\pyramid\Operand');
		$operand1->expects($this->any())
			->method('getIdentifiers')
			->will($this->returnValue(array(1)));

		/* @var \PHPUnit_Framework_MockObject_MockObject $operand2 */
		$operand2 = $this->getMock('com\mohiva\pyramid\Operand');
		$operand2->expects($this->any())
			->method('getIdentifiers')
			->will($this->returnValue(array(1)));

		/* @var \com\mohiva\pyramid\Operand $operand1 */
		/* @var \com\mohiva\pyramid\Operand $operand2 */
		$table = new OperandTable();
		$table->addOperand($operand1);
		$table->addOperand($operand2);
	}

	/**
	 * Test if the `isRegistered` method returns true if an operand is registered for the given identifier.
	 */
	public function testIsRegisteredReturnsTrue() {

		/* @var \PHPUnit_Framework_MockObject_MockObject $operand */
		$operand = $this->getMock('com\mohiva\pyramid\Operand');
		$operand->expects($this->any())
			->method('getIdentifiers')
			->will($this->returnValue(array(1)));

		/* @var \com\mohiva\pyramid\Operand $operand */
		$token = new Token(1, 1, 1);
		$table = new OperandTable();
		$table->addOperand($operand);

		$this->assertTrue($table->isRegistered($token));
	}

	/**
	 * Test if the `isRegistered` method returns false if an operand isn't registered for the given identifier.
	 */
	public function testIsRegisteredReturnsFalse() {

		$token = new Token(1, 1, 1);
		$table = new OperandTable();

		$this->assertFalse($table->isRegistered($token));
	}

	/**
	 * Test if the `getOperand` method throws an exception if no operand for the given identifier exists.
	 *
	 * @expectedException \com\mohiva\pyramid\exceptions\InvalidIdentifierException
	 */
	public function testGetOperandThrowsException() {

		$token = new Token(1, 1, 1);
		$table = new OperandTable();
		$table->getOperand($token);
	}
}
