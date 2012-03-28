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
use com\mohiva\pyramid\example\nodes\BinaryPowerNode;

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
class BinaryPowerNodeTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test if the `evaluate` method returns the correct value for the operation.
	 */
	public function testEvaluate() {

		$left = mt_rand(1, 100);
		$right = mt_rand(1, 100);
		$node = new BinaryPowerNode(new OperandNode($left), new OperandNode($right));

		$this->assertSame(pow($left, $right), $node->evaluate());
	}
}
