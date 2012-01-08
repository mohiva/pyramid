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
 * @package   Mohiva/Pyramid/Example/Operands
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\example\operands;

use com\mohiva\common\parser\exceptions\SyntaxErrorException;
use com\mohiva\common\parser\TokenStream;
use com\mohiva\pyramid\example\Lexer;
use com\mohiva\pyramid\Token;
use com\mohiva\pyramid\Parser;
use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\Operand;

/**
 * Operand which parses expressions between parentheses.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Example/Operands
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class ParenthesesOperand implements Operand {
	
	/**
	 * Returns the identifiers for this operand.
	 *
	 * @return array The identifiers for this operand.
	 */
	public function getIdentifiers() {
		
		return array(Lexer::T_OPEN_PARENTHESIS);
	}
	
	/**
	 * Parse the operand.
	 * 
	 * This example shows how you should parse sub expressions. You must only create a 
	 * new parser with the passed grammar and token stream.
	 *
	 * @param \com\mohiva\pyramid\Grammar $grammar The grammar of the parser.
	 * @param \com\mohiva\common\parser\TokenStream $stream The token stream to parse.
	 * @return \com\mohiva\pyramid\Node The node between the parentheses.
	 */
	public function parse(Grammar $grammar, TokenStream $stream) {
		
		$stream->next();
		
		$parser = new Parser($grammar);
		$node = $parser->parse($stream);
		
		$stream->expect(array(Lexer::T_CLOSE_PARENTHESIS), function(Token $current = null) {
			if ($current) {
				$message = "Expected `)`; got `{$current->getValue()}`";
			} else {
				$message = "Expected `)` but end of stream reached";
			}
			
			throw new SyntaxErrorException($message);
		});
		
		return $node;
	}
}
