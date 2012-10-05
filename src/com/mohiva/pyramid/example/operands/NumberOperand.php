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

use com\mohiva\pyramid\example\nodes\OperandNode;
use com\mohiva\pyramid\example\Lexer;
use com\mohiva\common\parser\TokenStream;
use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\Operand;

/**
 * Operand which parses integer and floating-point values.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Example/Operands
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class NumberOperand implements Operand {

	/**
	 * Returns the identifiers for this operand.
	 *
	 * @return array The identifiers for this operand.
	 */
	public function getIdentifiers() {

		return array(Lexer::T_NUMBER);
	}

	/**
	 * Parse the operand.
	 *
	 * @param Grammar $grammar The grammar of the parser.
	 * @param TokenStream $stream The token stream to parse.
	 * @return OperandNode The operand node.
	 */
	public function parse(Grammar $grammar, TokenStream $stream) {

		/* @var \com\mohiva\pyramid\Token $token */
		$token = $stream->current();
		$node = new OperandNode($token->getValue());

		return $node;
	}
}
