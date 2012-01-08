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

use \com\mohiva\pyramid\example\Lexer;
use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\Token;
use com\mohiva\pyramid\example\operands\ParenthesesOperand;
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
class ParenthesesOperandTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Test if the `parse` method returns a `Node` object.
	 */
	public function testParseReturnsNode() {
		
		$tokenStream = new TokenStream();
		$tokenStream->push(new Token(Lexer::T_OPEN_PARENTHESIS, '(', 1));
		$tokenStream->push(new Token(Lexer::T_NUMBER, 100, 1));
		$tokenStream->push(new Token(Lexer::T_CLOSE_PARENTHESIS, ')', 1));
		$tokenStream->rewind();
		
		$grammar = new Grammar();
		$grammar->addOperand(new NumberOperand());
		
		$operand = new ParenthesesOperand();
		$node = $operand->parse($grammar, $tokenStream);
		
		$this->assertInstanceOf('\com\mohiva\pyramid\nodes\LeafNode', $node);
	}
	
	/**
	 * Test if the `parse` method throws an exception if the closing parentheses is missing
	 * and the end of the stream isn't reached.
	 * 
	 * @expectedException \com\mohiva\common\parser\exceptions\SyntaxErrorException
	 */
	public function testParseThrowsExceptionIfEndOfStreamIsNotReached() {
		
		$tokenStream = new TokenStream();
		$tokenStream->push(new Token(Lexer::T_OPEN_PARENTHESIS, '(', 1));
		$tokenStream->push(new Token(Lexer::T_NUMBER, 100, 1));
		$tokenStream->push(new Token(Lexer::T_NUMBER, 100, 1));
		$tokenStream->rewind();
		
		$grammar = new Grammar();
		$grammar->addOperand(new NumberOperand());
		
		$operand = new ParenthesesOperand();
		$operand->parse($grammar, $tokenStream);
	}
	
	/**
	 * Test if the `parse` method throws an exception if the closing parentheses is missing 
	 * and the end of the stream is reached.
	 * 
	 * @expectedException \com\mohiva\common\parser\exceptions\SyntaxErrorException
	 */
	public function testParseThrowsExceptionIfEndOfStreamIsReached() {
		
		$tokenStream = new TokenStream();
		$tokenStream->push(new Token(Lexer::T_OPEN_PARENTHESIS, '(', 1));
		$tokenStream->push(new Token(Lexer::T_NUMBER, 100, 1));
		$tokenStream->rewind();
		
		$grammar = new Grammar();
		$grammar->addOperand(new NumberOperand());
		
		$operand = new ParenthesesOperand();
		$operand->parse($grammar, $tokenStream);
	}
}
