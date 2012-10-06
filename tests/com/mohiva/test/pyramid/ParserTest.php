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
use com\mohiva\pyramid\example\Lexer;
use com\mohiva\pyramid\example\Grammar as ExampleGrammar;
use com\mohiva\pyramid\example\operands\ParenthesesOperand;
use com\mohiva\pyramid\example\operands\NumberOperand;
use com\mohiva\pyramid\example\nodes\TernaryIfNode;
use com\mohiva\pyramid\operators\TernaryOperator;
use com\mohiva\common\parser\TokenStream;
use com\mohiva\common\exceptions\SyntaxErrorException;

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

		$lexer = new Lexer();
		$stream = $lexer->scan('1.1 + 1.5');

		$parser = new Parser(new ExampleGrammar());
		$node = $parser->parse($stream);

		$this->assertSame(1.1 + 1.5, $node->evaluate());
	}

	/**
	 * Test an unary operation.
	 */
	public function testUnaryOperation() {

		$lexer = new Lexer();
		$stream = $lexer->scan('-1.2 + 1 * 5');

		$parser = new Parser(new ExampleGrammar());
		$node = $parser->parse($stream);

		$this->assertSame(-1.2 + 1 * 5, $node->evaluate());
	}

	/**
	 * Test an unary between binary operations.
	 */
	public function testUnaryBetweenBinaryOperation() {

		$lexer = new Lexer();
		$stream = $lexer->scan('4 / -1 * 5');

		$parser = new Parser(new ExampleGrammar());
		$node = $parser->parse($stream);

		$this->assertSame(4 / -1 * 5, $node->evaluate());
	}

	/**
	 * Test an unary power operations.
	 */
	public function testUnaryPowerOperation() {

		$lexer = new Lexer();
		$stream = $lexer->scan('5^-1 + -1^5');

		$parser = new Parser(new ExampleGrammar());
		$node = $parser->parse($stream);

		$this->assertSame(pow(5, -1) + pow(-1, 5), $node->evaluate());
	}

	/**
	 * Test an operation with parentheses.
	 */
	public function testParenthesesOperation() {

		$lexer = new Lexer();
		$stream = $lexer->scan('-(-1.2) + 1 + (( -2 + 5) * 6 * (5 - 5))');

		$parser = new Parser(new ExampleGrammar());
		$node = $parser->parse($stream);

		$this->assertSame(-(-1.2) + 1 + (( -2 + 5) * 6 * (5 - 5)), $node->evaluate());
	}

	/**
	 * Test a complex operation.
	 */
	public function testComplexOperation() {

		$lexer = new Lexer();
		$stream = $lexer->scan('-(-1.1 + 1) * 5^6^3 / (4 / +5.568 * (2 % 8))');

		$parser = new Parser(new ExampleGrammar());
		$node = $parser->parse($stream);

		$this->assertSame(-(-1.1 + 1) * pow(5, pow(6, 3)) / (4 / +5.568 * (2 % 8)), $node->evaluate());
	}

	/**
	 * Test the right associative ternary operator.
	 *
	 * @see http://en.wikipedia.org/wiki/%3F:#PHP
	 */
	public function testRightAssociativeTernaryOperator() {

		$lexer = new Lexer();
		$stream = $lexer->scan('(
			0 ? 1 :
			0 ? 2 :
			1 ? 3 :
			0 ? 4 :
			0 ? 5 :
				6)');

		$grammar = new Grammar();
		$grammar->addOperator(new TernaryOperator(Lexer::T_QUESTION_MARK, Lexer::T_COLON, 1, TernaryOperator::RIGHT,
			function($condition, $if, $else) { return new TernaryIfNode($condition, $if, $else); }
		));
		$grammar->addOperand(new NumberOperand());
		$grammar->addOperand(new ParenthesesOperand());

		$parser = new Parser($grammar);
		$node = $parser->parse($stream);

		$this->assertSame('3', $node->evaluate());
	}

	/**
	 * Test the left associative ternary operator.
	 *
	 * @see http://en.wikipedia.org/wiki/%3F:#PHP
	 */
	public function testLeftAssociativeTernaryOperator() {

		$lexer = new Lexer();
		$stream = $lexer->scan('(
			0 ? 1 :
			0 ? 2 :
			1 ? 3 :
			0 ? 4 :
			0 ? 5 :
				6)');

		$grammar = new Grammar();
		$grammar->addOperator(new TernaryOperator(Lexer::T_QUESTION_MARK, Lexer::T_COLON, 1, TernaryOperator::LEFT,
			function($condition, $if, $else) { return new TernaryIfNode($condition, $if, $else); }
		));
		$grammar->addOperand(new NumberOperand());
		$grammar->addOperand(new ParenthesesOperand());

		$parser = new Parser($grammar);
		$node = $parser->parse($stream);

		$this->assertSame('5', $node->evaluate());
	}

	/**
	 * Test the left associative ternary operator.
	 *
	 * @see http://en.wikipedia.org/wiki/%3F:#PHP
	 */
	public function testFixForLeftAssociativeTernaryOperator() {

		$lexer = new Lexer();
		$stream = $lexer->scan('
			0 ? 1 :
			(0 ? 2 :
			(1 ? 3 :
			(0 ? 4 :
			(0 ? 5 : 6))))');

		$grammar = new Grammar();
		$grammar->addOperator(new TernaryOperator(Lexer::T_QUESTION_MARK, Lexer::T_COLON, 0, TernaryOperator::LEFT,
			function($condition, $if, $else) { return new TernaryIfNode($condition, $if, $else); }
		));
		$grammar->addOperand(new NumberOperand());
		$grammar->addOperand(new ParenthesesOperand());

		$parser = new Parser($grammar);
		$node = $parser->parse($stream);

		$this->assertSame('3', $node->evaluate());
	}

	/**
	 * Test if the parser throws an exception if no operand or unary operator can be found.
	 *
	 * @expectedException \com\mohiva\common\exceptions\SyntaxErrorException
	 */
	public function testParsePrimaryThrowsException() {

		$lexer = new Lexer();
		$stream = $lexer->scan('1 + 1 +');

		$parser = new Parser(new ExampleGrammar());
		$parser->parse($stream);
	}

	/**
	 * Test if the parser throws an exception if an unexpected token instead of the `else` token of a
	 * ternary operator was found.
	 *
	 * @expectedException \com\mohiva\common\exceptions\SyntaxErrorException
	 */
	public function testParseTernaryThrowsExceptionForUnexpectedElseToken() {

		$lexer = new Lexer();
		$stream = $lexer->scan('1 ? 1 #');

		$parser = new Parser(new ExampleGrammar());
		$parser->parse($stream);
	}

	/**
	 * Test if the parser throws an exception if the end of the stream is reached, when expecting the `else`
	 * token of a ternary operator.
	 *
	 * @expectedException \com\mohiva\common\exceptions\SyntaxErrorException
	 */
	public function testParseTernaryThrowsExceptionIfEndOfStreamIsReached() {

		$lexer = new Lexer();
		$stream = $lexer->scan('1 ? 1');

		$parser = new Parser(new ExampleGrammar());
		$parser->parse($stream);
	}

	/**
	 * Test if the parser throws an exception if an operand parser cannot
	 * be found for an token.
	 */
	public function testParseOperandThrowsException() {

		$lexer = new Lexer();
		$stream = $lexer->scan('1 + test');

		$parser = new Parser(new ExampleGrammar());
		try {
			$parser->parse($stream);
		} catch (SyntaxErrorException $e) {
			$this->assertInstanceOf('\com\mohiva\pyramid\exceptions\InvalidIdentifierException', $e->getPrevious());
		}
	}
}
