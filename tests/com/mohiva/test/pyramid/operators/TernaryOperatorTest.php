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
namespace com\mohiva\test\pyramid\operators;

use com\mohiva\pyramid\operators\TernaryOperator;

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
class TernaryOperatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test all getters for the values set with the constructor.
	 */
	public function testConstructorAccessors() {

		$ifCode = mt_rand(1, 100);
		$elseCode = mt_rand(1, 100);
		$precedence = mt_rand(1, 100);
		$closure = function() {};
		$operator = new TernaryOperator(
			$ifCode,
			$elseCode,
			$precedence,
			TernaryOperator::LEFT,
			$closure
		);

		$this->assertSame($ifCode, $operator->getIfCode());
		$this->assertSame($elseCode, $operator->getElseCode());
		$this->assertSame($precedence, $operator->getPrecedence());
		$this->assertSame($closure, $operator->getNode());
	}

	/**
	 * Test if the method `isLeftAssociative` returns true if the operator is left associative.
	 */
	public function testIsLeftAssociativeReturnsTrue() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::LEFT, function() {});

		$this->assertTrue($operator->isLeftAssociative());
	}

	/**
	 * Test if the method `isLeftAssociative` returns false if the operator isn't left associative.
	 */
	public function testIsLeftAssociativeReturnsFalse() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::RIGHT, function() {});

		$this->assertFalse($operator->isLeftAssociative());
	}

	/**
	 * Test if the method `isRightAssociative` returns true if the operator is right associative.
	 */
	public function testIsRightAssociativeReturnsTrue() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::RIGHT, function() {});

		$this->assertTrue($operator->isRightAssociative());
	}

	/**
	 * Test if the method `isRightAssociative` returns false if the operator isn't right associative.
	 */
	public function testIsRightAssociativeReturnsFalse() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::LEFT, function() {});

		$this->assertFalse($operator->isRightAssociative());
	}
}
