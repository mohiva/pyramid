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

use com\mohiva\pyramid\Token;
use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\operators\BinaryOperator;

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
class GrammarTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test the `addOperator` and `getOperatorTable` accessors.
	 */
	public function testOperatorTableAccessors() {

		$operator = new BinaryOperator(1, 1, BinaryOperator::LEFT, function() {});
		$token = new Token($operator->getCode(), 1, 1);

		$grammar = new Grammar();
		$grammar->addOperator($operator);

		$this->assertSame($operator, $grammar->getOperatorTable()->getBinaryOperator($token));
	}

	/**
	 * Test the `addOperand` and `getOperandTable` accessors.
	 */
	public function testOperandTableAccessors() {

		/* @var \PHPUnit_Framework_MockObject_MockObject $operand */
		/* @var \com\mohiva\pyramid\Operand $operand */
		$operand = $this->getMock('com\mohiva\pyramid\Operand');
		$operand->expects($this->any())
			->method('getIdentifiers')
			->will($this->returnValue(array(1)));

		$token = new Token(1, 1, 1);
		$grammar = new Grammar();
		$grammar->addOperand($operand);

		$this->assertSame($operand, $grammar->getOperandTable()->getOperand($token));
	}
}
