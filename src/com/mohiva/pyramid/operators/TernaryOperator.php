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
 * @package   Mohiva/Pyramid/Operators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\operators;

use Closure;
use com\mohiva\pyramid\Operator;

/**
 * Represents a ternary operator.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Operators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class TernaryOperator implements Operator {

	/**
	 * The associativity of the operators.
	 *
	 * @var int
	 */
	const LEFT  = 1;
	const RIGHT = 2;

	/**
	 * The token code for the if operator.
	 *
	 * @var int
	 */
	private $ifCode = null;

	/**
	 * The token code for the else operator.
	 *
	 * @var int
	 */
	private $elseCode = null;

	/**
	 * The precedence of the operator.
	 *
	 * @var int
	 */
	private $precedence = null;

	/**
	 * The associativity of the operator, (LEFT or RIGHT)
	 *
	 * @var int
	 */
	private $associativity = null;

	/**
	 * Indicates if the shorthand ternary operator in the form 1 ?: 2  is allowed or not.
	 *
	 * @var boolean
	 */
	private $allowShorthand;

	/**
	 * The closure which instantiates the node object for this operator.
	 *
	 * @var Closure
	 */
	private $node = null;

	/**
	 * The class constructor.
	 *
	 * @param int $ifCode The token code for the if operator.
	 * @param int $elseCode The token code for the else operator.
	 * @param int $precedence The precedence of the operator.
	 * @param int $associativity The associativity of the operator, (LEFT or RIGHT)
	 * @param boolean $allowShorthand True if the shorthand form is allowed, false otherwise.
	 * @param Closure $node A closure which instantiates the node object for this operator.
	 */
	public function __construct($ifCode, $elseCode, $precedence, $associativity, $allowShorthand, Closure $node) {

		$this->ifCode = $ifCode;
		$this->elseCode = $elseCode;
		$this->precedence = $precedence;
		$this->associativity = $associativity;
		$this->allowShorthand = $allowShorthand;
		$this->node = $node;
	}

	/**
	 * Returns the token code for the if operator.
	 *
	 * @return int The token code for the if operator.
	 */
	public function getIfCode() {

		return $this->ifCode;
	}

	/**
	 * Returns the token code for the else operator.
	 *
	 * @return int The token code for the else operator.
	 */
	public function getElseCode() {

		return $this->elseCode;
	}

	/**
	 * Returns the precedence of the operator.
	 *
	 * @return int The precedence of the operator.
	 */
	public function getPrecedence() {

		return $this->precedence;
	}

	/**
	 * Indicates if the operator is left associative.
	 *
	 * @return bool True if the operator is left associative, false otherwise.
	 */
	public function isLeftAssociative() {

		return $this->associativity == self::LEFT;
	}

	/**
	 * Indicates if the operator is right associative.
	 *
	 * @return bool True if the operator is right associative, false otherwise.
	 */
	public function isRightAssociative() {

		return $this->associativity == self::RIGHT;
	}

	/**
	 * Indicates if the shorthand ternary operator in the form 1 ?: 2  is allowed or not.
	 *
	 * @return bool True if the shorthand form is allowed, false otherwise.
	 */
	public function isShorthandAllowed() {

		return $this->allowShorthand;
	}

	/**
	 * Returns the closure which instantiates the node object for this operator.
	 *
	 * @return Closure The closure which instantiates the node object for this operator.
	 */
	public function getNode() {

		return $this->node;
	}
}
