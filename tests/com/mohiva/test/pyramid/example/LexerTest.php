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
namespace com\mohiva\test\pyramid\example;

use com\mohiva\pyramid\example\Lexer;
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
class LexerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test the syntax of a mathematical calculation.
	 */
	public function testCalculationSyntax() {

		$lexer = new Lexer();
		$stream = $lexer->scan(' 12+4-1/3 * +0.4 + (-12 + 5^3) ');

		$actual = $this->buildActualTokens($stream);
		$expected = array(
			array(Lexer::T_NUMBER => '12'),
			array(Lexer::T_PLUS => '+'),
			array(Lexer::T_NUMBER => '4'),
			array(Lexer::T_MINUS => '-'),
			array(Lexer::T_NUMBER => '1'),
			array(Lexer::T_DIV => '/'),
			array(Lexer::T_NUMBER => '3'),
			array(Lexer::T_MUL => '*'),
			array(Lexer::T_PLUS => '+'),
			array(Lexer::T_NUMBER => '0.4'),
			array(Lexer::T_PLUS => '+'),
			array(Lexer::T_OPEN_PARENTHESIS => '('),
			array(Lexer::T_MINUS => '-'),
			array(Lexer::T_NUMBER => '12'),
			array(Lexer::T_PLUS => '+'),
			array(Lexer::T_NUMBER => '5'),
			array(Lexer::T_POWER => '^'),
			array(Lexer::T_NUMBER => '3'),
			array(Lexer::T_CLOSE_PARENTHESIS => ')'),
		);

		$this->assertSame($expected, $actual);
	}

	/**
	 * Test the none token.
	 */
	public function testNoneToken() {

		$lexer = new Lexer();
		$stream = $lexer->scan(' # ');

		$actual = $this->buildActualTokens($stream);
		$expected = array(
			array(Lexer::T_NONE => '#'),
		);
		$this->assertSame($expected, $actual);
	}

	/**
	 * Create an array from the token stream which contains only the tokens and the operators/values.
	 *
	 * @param TokenStream $stream The stream containing the lexer tokens.
	 * @return array The actual list with tokens and operators/values.
	 */
	private function buildActualTokens(TokenStream $stream) {

		$actual = array();
		while ($stream->valid()) {
			/* @var \com\mohiva\pyramid\Token $current */
			$current = $stream->current();
			$stream->next();
			$actual[] = array($current->getCode() => $current->getValue());
		}

		return $actual;
	}
}
