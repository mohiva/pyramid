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
 * @package   Mohiva/Pyramid/Example/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\example\operands;

use com\mohiva\pyramid\example\nodes\OperandNode;
use com\mohiva\common\parser\TokenStream;
use com\mohiva\pyramid\Grammar;
use com\mohiva\pyramid\Operand;

/**
 * Represents an binary division.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Example/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class NumberOperand implements Operand {
	
	/**
	 * The identifiers for this operand.
	 * 
	 * @var array
	 */
	private $identifiers = array();
	
	/**
	 * The class constructor.
	 * 
	 * @param array $identifiers The identifiers for this operand.
	 */
	public function __construct(array $identifiers) {
		
		$this->identifiers = $identifiers;
	}
	
	/**
	 * Returns the identifiers for this operand.
	 *
	 * @return array The identifiers for this operand.
	 */
	public function getIdentifiers() {
		
		return $this->identifiers;
	}
	
	/**
	 * Parse the operand.
	 *
	 * @param \com\mohiva\pyramid\Grammar $grammar The grammar of the parser.
	 * @param \com\mohiva\common\parser\TokenStream $stream The token stream to parse.
	 * @return \com\mohiva\pyramid\example\nodes\OperandNode The operand node.
	 */
	public function parse(Grammar $grammar, TokenStream $stream) {
		
		/* @var \com\mohiva\pyramid\Token $token */
		$token = $stream->current();
		$node = new OperandNode($token->getValue());
		
		return $node;
	}
}
