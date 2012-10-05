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

use com\mohiva\common\parser\TokenStream;

/**
 * Represents an operand.
 *
 * An operand is the left or right part of an operator. In this implementations an expressions
 * between parentheses is also an operand. Please look at the example operands on how these are
 * implemented.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
interface Operand {

	/**
	 * Returns the identifiers for an operand.
	 *
	 * Identifiers are token codes which are defined by the lexer. And they where needed to
	 * recognize if a token is a part of an operand. An operand can consists of many identifiers.
	 * But it isn't allowed to use one identifier for multiple operands. Instead create one operand
	 * and let it decide how the input should be parsed.
	 *
	 * @return array The identifiers for an operand.
	 */
	public function getIdentifiers();

	/**
	 * Parse the operand.
	 *
	 * @param Grammar $grammar The grammar of the parser. This is passed to create a new `Parser` to parse
	 * sub expressions.
	 *
	 * @param TokenStream $stream The token stream to parse.
	 * @return Node The parsed operand node.
	 */
	public function parse(Grammar $grammar, TokenStream $stream);
}
