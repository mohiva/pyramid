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
use com\mohiva\pyramid\OperatorTable;
use com\mohiva\pyramid\operators\BinaryOperator;
use com\mohiva\pyramid\operators\UnaryOperator;
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
class OperatorTableTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test the `addOperator` and `getBinaryOperator` accessors.
	 */
	public function testBinaryOperatorAccessors() {

		$operator = new BinaryOperator(1, 10, BinaryOperator::LEFT, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertSame($operator, $table->getBinaryOperator($token));
	}

	/**
	 * Test the `addOperator` and `getUnaryOperator` accessors.
	 */
	public function testUnaryOperatorAccessors() {

		$operator = new UnaryOperator(1, 10, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertSame($operator, $table->getUnaryOperator($token));
	}

	/**
	 * Test the `addOperator` and `getTernaryOperator` accessors for the `if` token.
	 */
	public function testTernaryOperatorAccessorsForIfToken() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::RIGHT, true, function() {});
		$token = new Token($operator->getIfCode(), '?', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertSame($operator, $table->getTernaryOperator($token));
	}

	/**
	 * Test the `addOperator` and `getTernaryOperator` accessors for the `else` token.
	 */
	public function testTernaryOperatorAccessorsForElseToken() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::RIGHT, true, function() {});
		$token = new Token($operator->getElseCode(), ':', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertSame($operator, $table->getTernaryOperator($token));
	}

	/**
	 * Test if the `addOperator` method throws an exception if an unsupported operator was given.
	 *
	 * @expectedException \com\mohiva\pyramid\exceptions\UnsupportedOperatorException
	 */
	public function testAddOperatorThrowsException() {

		/* @var \com\mohiva\pyramid\Operator $operator */
		$operator = $this->getMock('\com\mohiva\pyramid\Operator');

		$table = new OperatorTable();
		$table->addOperator($operator);
	}

	/**
	 * Test if the `isBinary` method returns true if the given token is a binary operator.
	 */
	public function testIsBinaryReturnsTrue() {

		$operator = new BinaryOperator(1, 10, BinaryOperator::LEFT, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertTrue($table->isBinary($token));
	}

	/**
	 * Test if the `isBinary` method returns false if the given token isn't a binary operator.
	 */
	public function testIsBinaryReturnsFalse() {

		$operator = new UnaryOperator(1, 10, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertFalse($table->isBinary($token));
	}

	/**
	 * Test if the `isUnary` method returns true if the given token is an unary operator.
	 */
	public function testIsUnaryReturnsTrue() {

		$operator = new UnaryOperator(1, 10, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertTrue($table->isUnary($token));
	}

	/**
	 * Test if the `isUnary` method returns false if the given token isn't an unary operator.
	 */
	public function testIsUnaryReturnsFalse() {

		$operator = new BinaryOperator(1, 10, BinaryOperator::LEFT, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertFalse($table->isUnary($token));
	}

	/**
	 * Test if the `isTernary` method returns true if the given token is the `if` token of a ternary operator.
	 */
	public function testIsTernaryReturnsTrueForIfToken() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::RIGHT, true, function() {});
		$token = new Token($operator->getIfCode(), '?', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertTrue($table->isTernary($token));
	}

	/**
	 * Test if the `isTernary` method returns true if the given token is the `else` token of a ternary operator.
	 */
	public function testIsTernaryReturnsTrueForElseToken() {

		$operator = new TernaryOperator(1, 2, 10, TernaryOperator::RIGHT, true, function() {});
		$token = new Token($operator->getIfCode(), ':', 2);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertTrue($table->isTernary($token));
	}

	/**
	 * Test if the `isTernary` method returns false if the given token is not the `if` or an `else` token
	 * of a ternary operator.
	 */
	public function testIsTernaryReturnsFalse() {

		$operator = new BinaryOperator(1, 10, BinaryOperator::LEFT, function() {});
		$token = new Token($operator->getCode(), '+', 1);

		$table = new OperatorTable();
		$table->addOperator($operator);

		$this->assertFalse($table->isTernary($token));
	}

	/**
	 * Test if the `getBinaryOperator` method throws an exception if the requested operator doesn't exists.
	 *
	 * @expectedException \com\mohiva\pyramid\exceptions\UnsupportedOperatorException
	 */
	public function testGetBinaryOperatorThrowsException() {

		$token = new Token(1, '+', 1);

		$table = new OperatorTable();
		$table->getBinaryOperator($token);
	}

	/**
	 * Test if the `getUnaryOperator` method throws an exception if the requested operator doesn't exists.
	 *
	 * @expectedException \com\mohiva\pyramid\exceptions\UnsupportedOperatorException
	 */
	public function testGetUnaryOperatorThrowsException() {

		$token = new Token(1, '+', 1);

		$table = new OperatorTable();
		$table->getUnaryOperator($token);
	}

	/**
	 * Test if the `getTernaryOperator` method throws an exception if the requested operator doesn't exists.
	 *
	 * @expectedException \com\mohiva\pyramid\exceptions\UnsupportedOperatorException
	 */
	public function testGetTernaryOperatorThrowsException() {

		$token = new Token(1, '?', 1);

		$table = new OperatorTable();
		$table->getTernaryOperator($token);
	}
}
