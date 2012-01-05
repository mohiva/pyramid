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
 * Represents a binary operator.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Operators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class BinaryOperator implements Operator {
	
	/**
	 * The associativity of the operators.
	 * 
	 * @var int
	 */
	const LEFT  = 1;
	const RIGHT = 2;
	
	/**
	 * The token code.
	 * 
	 * @var int
	 */
	private $code = null;
	
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
	 * The closure which instantiates the node object for this operator.
	 * 
	 * @var \Closure
	 */
	private $node = null;
	
	/**
	 * The class constructor.
	 * 
	 * @param int $code The token code.
	 * @param int $precedence The precedence of the operator.
	 * @param int $associativity The associativity of the operator, (LEFT or RIGHT)
	 * @param \Closure $node A closure which instantiates the node object for this operator.
	 */
	public function __construct($code, $precedence, $associativity, Closure $node) {
		
		$this->code = $code;
		$this->precedence = $precedence;
		$this->associativity = $associativity;
		$this->node = $node;
	}
	
	/**
	 * Returns the token code.
	 * 
	 * @return int The token code.
	 */
	public function getCode() {
		
		return $this->code;
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
	 * Returns the closure which instantiates the node object for this operator.
	 * 
	 * @return \Closure The closure which instantiates the node object for this operator.
	 */
	public function getNode() {
		
		return $this->node;
	}
}
