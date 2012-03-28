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

/**
 * Represents the grammar for the parser.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class Grammar {

	/**
	 * The operator table.
	 *
	 * @var OperatorTable
	 */
	private $operatorTable = null;

	/**
	 * The operand table.
	 *
	 * @var OperandTable
	 */
	private $operandTable = null;

	/**
	 * The class constructor.
	 */
	public function __construct() {

		$this->operatorTable = new OperatorTable();
		$this->operandTable = new OperandTable();
	}

	/**
	 * Adds a new operator to the operator table.
	 *
	 * @param Operator $operator The operator to add.
	 */
	public function addOperator(Operator $operator) {

		$this->operatorTable->addOperator($operator);
	}

	/**
	 * Adds a new operand to the operand table.
	 *
	 * @param Operand $operand The operand to add.
	 */
	public function addOperand(Operand $operand) {

		$this->operandTable->addOperand($operand);
	}

	/**
	 * Returns the instance of the operator table.
	 *
	 * @return OperatorTable The instance of the operator table.
	 */
	public function getOperatorTable() {

		return $this->operatorTable;
	}

	/**
	 * Returns the instance of the operand table.
	 *
	 * @return OperandTable The instance of the operand table.
	 */
	public function getOperandTable() {

		return $this->operandTable;
	}
}
