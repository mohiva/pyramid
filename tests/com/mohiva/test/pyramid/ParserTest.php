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

use com\mohiva\pyramid\Parser;
use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\operators\BinaryOperator;
use com\mohiva\pyramid\operators\UnaryOperator;
use com\mohiva\pyramid\example\Lexer;
use com\mohiva\pyramid\example\nodes\UnaryPosNode;
use com\mohiva\pyramid\example\nodes\UnaryNegNode;
use com\mohiva\pyramid\example\nodes\BinaryPlusNode;
use com\mohiva\pyramid\example\nodes\BinaryMinusNode;
use com\mohiva\pyramid\example\nodes\BinaryMulNode;
use com\mohiva\pyramid\example\nodes\BinaryDivNode;
use com\mohiva\pyramid\example\nodes\BinaryModNode;
use com\mohiva\pyramid\example\nodes\BinaryPowerNode;
use com\mohiva\pyramid\example\operands\NumberOperand;
use com\mohiva\pyramid\example\operands\ParenthesesOperand;
use com\mohiva\common\parser\TokenStream;

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
class ParserTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Test a binary operation.
	 */
	public function testBinaryOperation() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('1.1 + 1.5');
		
		$parser = new Parser($this->getGrammar());
		$node = $parser->parse($stream);
		
		$this->assertSame(1.1 + 1.5, $node->evaluate());
	}
	
	/**
	 * Test an unary operation.
	 */
	public function testUnaryOperation() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('-1.2 + 1 * 5');
		
		$parser = new Parser($this->getGrammar());
		$node = $parser->parse($stream);
		
		$this->assertSame(-1.2 + 1 * 5, $node->evaluate());
	}
	
	/**
	 * Test an unary between binary operations.
	 */
	public function testUnaryBetweenBinaryOperation() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('4 / -1 * 5');
		
		$parser = new Parser($this->getGrammar());
		$node = $parser->parse($stream);
		
		$this->assertSame(4 / -1 * 5, $node->evaluate());
	}
	
	/**
	 * Test an unary power operations.
	 */
	public function testUnaryPowerOperation() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('5^-1 + -1^5');
		
		$parser = new Parser($this->getGrammar());
		$node = $parser->parse($stream);
		
		$this->assertSame(pow(5, -1) + pow(-1, 5), $node->evaluate());
	}
	
	/**
	 * Test an operation with parentheses.
	 */
	public function testParenthesesOperation() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('-(-1.2) + 1 + (( -2 + 5) * 6 * (5 + 5))');
		
		$parser = new Parser($this->getGrammar());
		$node = $parser->parse($stream);
		
		$this->assertSame(-(-1.2) + 1 + (( -2 + 5) * 6 * (5 + 5)), $node->evaluate());
	}
	
	/**
	 * Test a complex operation.
	 */
	public function testComplexOperation() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('-(-1.1 + 1) * 5^6^3 / (4 / +5.568 * (2 - 8))');
		
		$parser = new Parser($this->getGrammar());
		$node = $parser->parse($stream);
		
		$this->assertSame(-(-1.1 + 1) * pow(5, pow(6, 3)) / (4 / +5.568 * (2 - 8)), $node->evaluate());
	}
	
	/**
	 * Test if the `parsePrimary` method throws an exception if no operand or unary operator can be found.
	 * 
	 * @expectedException \com\mohiva\common\parser\exceptions\SyntaxErrorException
	 */
	public function testParsePrimaryThrowsException() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('1 + 1 +');
		
		$parser = new Parser($this->getGrammar());
		$parser->parse($stream);
	}
	
	/**
	 * Test if the `parseOperand` method throws an exception if an operand parser cannot 
	 * be found for an token.
	 * 
	 * @expectedException \com\mohiva\common\parser\exceptions\SyntaxErrorException
	 */
	public function testParseOperandThrowsException() {
		
		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('1 + test');
		
		$parser = new Parser($this->getGrammar());
		$parser->parse($stream);
	}
	
	/**
	 * Get the grammar for the parser.
	 * 
	 * @return \com\mohiva\pyramid\Grammar The grammar for the parser.
	 */
	private function getGrammar() {
		
		// Note: unary +/- operators must have higher precedence as all binary operators
		// http://www.antlr.org/pipermail/antlr-dev/2009-April/002255.html
		$grammar = new Grammar();
		$grammar->addOperator(new UnaryOperator(Lexer::T_PLUS, 4, function($left) {
			return new UnaryPosNode($left);
		}));
		$grammar->addOperator(new UnaryOperator(Lexer::T_MINUS, 4, function($left) {
			return new UnaryNegNode($left);
		}));
		$grammar->addOperator(new BinaryOperator(Lexer::T_PLUS, 0, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryPlusNode($left, $right);
		}));
		$grammar->addOperator(new BinaryOperator(Lexer::T_MINUS, 0, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryMinusNode($left, $right);
		}));
		$grammar->addOperator(new BinaryOperator(Lexer::T_MUL, 1, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryMulNode($left, $right);
		}));
		$grammar->addOperator(new BinaryOperator(Lexer::T_DIV, 1, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryDivNode($left, $right);
		}));
		$grammar->addOperator(new BinaryOperator(Lexer::T_MOD, 1, BinaryOperator::LEFT, function($left, $right) {
			return new BinaryModNode($left, $right);
		}));
		$grammar->addOperator(new BinaryOperator(Lexer::T_POWER, 3, BinaryOperator::RIGHT, function($left, $right) {
			return new BinaryPowerNode($left, $right);
		}));
		
		$grammar->addOperand(new NumberOperand(array(Lexer::T_NUMBER)));
		$grammar->addOperand(new ParenthesesOperand(array(Lexer::T_OPEN_PARENTHESIS)));
		
		return $grammar;
	}
}
