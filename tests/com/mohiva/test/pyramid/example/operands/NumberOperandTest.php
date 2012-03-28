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
namespace com\mohiva\test\pyramid\example\operands;

use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\Token;
use com\mohiva\pyramid\example\Lexer;
use com\mohiva\pyramid\example\operands\NumberOperand;
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
class NumberOperandTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test if the parse method returns the `OperandNode` with the correct number.
	 */
	public function testParseReturnsNodeWithCorrectNumber() {

		$number = mt_rand(1, 100);

		$tokenStream = new TokenStream();
		$tokenStream->push(new Token(Lexer::T_NUMBER, $number, 1));
		$tokenStream->rewind();

		$operand = new NumberOperand();
		$node = $operand->parse(new Grammar, $tokenStream);

		$this->assertSame($number, $node->evaluate());
	}
}
