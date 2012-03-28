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
namespace com\mohiva\test\pyramid\operators;

use com\mohiva\pyramid\operators\UnaryOperator;

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
class UnaryOperatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test all getters for the values set with the constructor.
	 */
	public function testConstructorAccessors() {

		$code = mt_rand(1, 100);
		$precedence = mt_rand(1, 100);
		$closure = function() {};
		$operator = new UnaryOperator(
			$code,
			$precedence,
			$closure
		);

		$this->assertSame($code, $operator->getCode());
		$this->assertSame($precedence, $operator->getPrecedence());
		$this->assertSame($closure, $operator->getNode());
	}
}
