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
 * @package   Mohiva/Pyramid/Example
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\example;

use com\mohiva\pyramid\Grammar as ParserGrammar;
use com\mohiva\pyramid\operators\TernaryOperator;
use com\mohiva\pyramid\operators\BinaryOperator;
use com\mohiva\pyramid\operators\UnaryOperator;
use com\mohiva\pyramid\example\nodes\TernaryIfNode;
use com\mohiva\pyramid\example\nodes\UnaryPosNode;
use com\mohiva\pyramid\example\nodes\UnaryNegNode;
use com\mohiva\pyramid\example\nodes\BinaryAddNode;
use com\mohiva\pyramid\example\nodes\BinarySubNode;
use com\mohiva\pyramid\example\nodes\BinaryMulNode;
use com\mohiva\pyramid\example\nodes\BinaryDivNode;
use com\mohiva\pyramid\example\nodes\BinaryModNode;
use com\mohiva\pyramid\example\nodes\BinaryPowerNode;
use com\mohiva\pyramid\example\operands\NumberOperand;
use com\mohiva\pyramid\example\operands\ParenthesesOperand;

/**
 * The parser grammar for the Pyramid example.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Example
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class Grammar extends ParserGrammar {

	/**
	 * Creates the grammar.
	 */
	public function __construct() {

		parent::__construct();

		// Note: unary +/- operators must have higher precedence as all binary operators
		// http://www.antlr.org/pipermail/antlr-dev/2009-April/002255.html
		$this->addOperator(new UnaryOperator(Lexer::T_PLUS, 4, function($node) {
			return new UnaryPosNode($node);
		}));
		$this->addOperator(new UnaryOperator(Lexer::T_MINUS, 4, function($node) {
			return new UnaryNegNode($node);
		}));
		$this->addOperator(new TernaryOperator(Lexer::T_QUESTION_MARK, Lexer::T_COLON, 0, TernaryOperator::RIGHT,
			function($condition, $if, $else) { return new TernaryIfNode($condition, $if, $else); }
		));
		$this->addOperator(new BinaryOperator(Lexer::T_PLUS, 1, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryAddNode($left, $right);
		}));
		$this->addOperator(new BinaryOperator(Lexer::T_MINUS, 1, BinaryOperator::LEFT, function($left, $right) {
			return new BinarySubNode($left, $right);
		}));
		$this->addOperator(new BinaryOperator(Lexer::T_MUL, 2, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryMulNode($left, $right);
		}));
		$this->addOperator(new BinaryOperator(Lexer::T_DIV, 2, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryDivNode($left, $right);
		}));
		$this->addOperator(new BinaryOperator(Lexer::T_MOD, 2, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryModNode($left, $right);
		}));
		$this->addOperator(new BinaryOperator(Lexer::T_POWER, 3, BinaryOperator::RIGHT, function($left, $right) {
			return new BinaryPowerNode($left, $right);
		}));

		$this->addOperand(new NumberOperand());
		$this->addOperand(new ParenthesesOperand());
	}
}
