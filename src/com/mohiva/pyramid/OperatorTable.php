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
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid;

use com\mohiva\pyramid\operators\BinaryOperator;
use com\mohiva\pyramid\operators\UnaryOperator;
use com\mohiva\pyramid\exceptions\UnsupportedOperatorException;

/**
 * Contains a list of operators.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class OperatorTable {

	/**
	 * The unary operator table.
	 *
	 * @var array
	 */
	private $unary = array();

	/**
	 * The binary operator table.
	 *
	 * @var array
	 */
	private $binary = array();

	/**
	 * Adds a new operator to the table.
	 *
	 * @param Operator $operator The operator to add.
	 * @throws UnsupportedOperatorException if an unsupported operator type was given.
	 */
	public function addOperator(Operator $operator) {

		if ($operator instanceof BinaryOperator) {
			$this->binary[$operator->getCode()] = $operator;
		} else if ($operator instanceof UnaryOperator) {
			$this->unary[$operator->getCode()] = $operator;
		} else {
			$type = get_class($operator);
			throw new UnsupportedOperatorException("The operator type `{$type}` isn't supported");
		}
	}

	/**
	 * Check if the given token is a binary operator.
	 *
	 * @param Token $token The token to check for.
	 * @return boolean True if the given token is a binary operator, false otherwise.
	 */
	public function isBinary(Token $token) {

		return isset($this->binary[$token->getCode()]);
	}

	/**
	 * Check if the given token is an unary operator.
	 *
	 * @param Token $token The token to check for.
	 * @return boolean True if the given token is a unary operator, false otherwise.
	 */
	public function isUnary(Token $token) {

		return isset($this->unary[$token->getCode()]);
	}

	/**
	 * Gets a binary operator from table.
	 *
	 * @param Token $token The token for which the operator should be returned.
	 * @return operators\BinaryOperator The operator object for the given token.
	 * @throws UnsupportedOperatorException if the operator doesn't exists in table.
	 */
	public function getBinaryOperator(Token $token) {

		if (isset($this->binary[$token->getCode()])) {
			return $this->binary[$token->getCode()];
		}

		throw new UnsupportedOperatorException("No binary operator with code `{$token->getCode()}` exists in table");
	}

	/**
	 * Gets an unary operator from table.
	 *
	 * @param Token $token The token for which the operator should be returned.
	 * @return operators\UnaryOperator The operator object for the given token.
	 * @throws UnsupportedOperatorException if the operator doesn't exists in table.
	 */
	public function getUnaryOperator(Token $token) {

		if (isset($this->unary[$token->getCode()])) {
			return $this->unary[$token->getCode()];
		}

		throw new UnsupportedOperatorException("No unary operator with code `{$token->getCode()}` exists in table");
	}
}
