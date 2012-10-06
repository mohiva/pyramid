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
namespace com\mohiva\test\pyramid\example\nodes;

use com\mohiva\pyramid\example\nodes\OperandNode;
use com\mohiva\pyramid\example\nodes\TernaryNode;

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
class TernaryNodeTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test if the `evaluate` method returns the correct value for the operation, if the condition
	 * evaluates to true.
	 */
	public function testEvaluateIf() {

		$condition = 1;
		$if = 1;
		$else = 2;
		$node = new TernaryNode(new OperandNode($condition), new OperandNode($if), new OperandNode($else));

		$this->assertSame($if, $node->evaluate());
	}

	/**
	 * Test if the `evaluate` method returns the correct value for the operation, if the condition
	 * evaluates to false.
	 */
	public function testEvaluateElse() {

		$condition = 0;
		$if = 1;
		$else = 2;
		$node = new TernaryNode(new OperandNode($condition), new OperandNode($if), new OperandNode($else));

		$this->assertSame($else, $node->evaluate());
	}
}
