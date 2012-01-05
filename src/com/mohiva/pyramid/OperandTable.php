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

use com\mohiva\pyramid\exceptions\DoubleIdentifierUsageException;
use com\mohiva\pyramid\exceptions\InvalidIdentifierException;

/**
 * Contains a list of operands.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class OperandTable {
	
	/**
	 * The list with registered operands.
	 * 
	 * The key is the identifier of the operand and the value 
	 * is the operand object itself.
	 * 
	 * If as example an operand has two identifiers than this array 
	 * contains also two entries for this operand. All objects are
	 * stored as reference, so this should not be problem.
	 * 
	 * @var Operand[]
	 */
	private $operands = array();
	
	/**
	 * Adds a new operand to the table.
	 * 
	 * @param Operand $operand The operand to add.
	 * @throws DoubleIdentifierUsageException if an identifier of the given operand is registered for an other operand.
	 */
	public function addOperand(Operand $operand) {
		
		foreach ($operand->getIdentifiers() as $identifier) {
			if (isset($this->operands[$identifier])) {
				$operand = get_class($this->operands[$identifier]);
				$message = "The identifier `{$identifier}` is already in use for operand `{$operand}`";
				throw new DoubleIdentifierUsageException($message);
			}
			
			$this->operands[$identifier] = $operand;
		}
	}
	
	/**
	 * Check if an operand is registered for the given token.
	 * 
	 * @param Token $token The token to check for.
	 * @return boolean True if a operand for the given token exists, false otherwise.
	 */
	public function isRegistered(Token $token) {
		
		if (isset($this->operands[$token->getCode()])) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Get the operand for the given token.
	 * 
	 * @param Token $token The token which must be defined(as identifier) for the operand.
	 * @return Operand The operand for the given token.
	 * @throws InvalidIdentifierException if no operand for the given token exists.
	 */
	public function getOperand(Token $token) {
		
		if ($this->isRegistered($token)) {
			return $this->operands[$token->getCode()];
		}
		
		throw new InvalidIdentifierException("No operand for identifier `{$token->getCode()}` exists in table");
	}
}
