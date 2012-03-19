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
use com\mohiva\pyramid\example\Lexer;
use com\mohiva\pyramid\example\Grammar;
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

		$parser = new Parser(new Grammar());
		$node = $parser->parse($stream);

		$this->assertSame(1.1 + 1.5, $node->evaluate());
	}

	/**
	 * Test an unary operation.
	 */
	public function testUnaryOperation() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('-1.2 + 1 * 5');

		$parser = new Parser(new Grammar());
		$node = $parser->parse($stream);

		$this->assertSame(-1.2 + 1 * 5, $node->evaluate());
	}

	/**
	 * Test an unary between binary operations.
	 */
	public function testUnaryBetweenBinaryOperation() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('4 / -1 * 5');

		$parser = new Parser(new Grammar());
		$node = $parser->parse($stream);

		$this->assertSame(4 / -1 * 5, $node->evaluate());
	}

	/**
	 * Test an unary power operations.
	 */
	public function testUnaryPowerOperation() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('5^-1 + -1^5');

		$parser = new Parser(new Grammar());
		$node = $parser->parse($stream);

		$this->assertSame(pow(5, -1) + pow(-1, 5), $node->evaluate());
	}

	/**
	 * Test an operation with parentheses.
	 */
	public function testParenthesesOperation() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('-(-1.2) + 1 + (( -2 + 5) * 6 * (5 + 5))');

		$parser = new Parser(new Grammar());
		$node = $parser->parse($stream);

		$this->assertSame(-(-1.2) + 1 + (( -2 + 5) * 6 * (5 + 5)), $node->evaluate());
	}

	/**
	 * Test a complex operation.
	 */
	public function testComplexOperation() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('-(-1.1 + 1) * 5^6^3 / (4 / +5.568 * (2 - 8))');

		$parser = new Parser(new Grammar());
		$node = $parser->parse($stream);

		$this->assertSame(-(-1.1 + 1) * pow(5, pow(6, 3)) / (4 / +5.568 * (2 - 8)), $node->evaluate());
	}

	/**
	 * Test if the `parsePrimary` method throws an exception if no operand or unary operator can be found.
	 *
	 * @expectedException \com\mohiva\common\exceptions\SyntaxErrorException
	 */
	public function testParsePrimaryThrowsException() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('1 + 1 +');

		$parser = new Parser(new Grammar());
		$parser->parse($stream);
	}

	/**
	 * Test if the `parseOperand` method throws an exception if an operand parser cannot
	 * be found for an token.
	 *
	 * @expectedException \com\mohiva\common\exceptions\SyntaxErrorException
	 */
	public function testParseOperandThrowsException() {

		$lexer = new Lexer(new TokenStream);
		$stream = $lexer->scan('1 + test');

		$parser = new Parser(new Grammar());
		$parser->parse($stream);
	}
}
