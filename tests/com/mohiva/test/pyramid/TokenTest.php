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
namespace com\mohiva\test\pyramid;

use com\mohiva\pyramid\Token;

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
class TokenTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Test all getters for the values set with the constructor.
	 */
	public function testConstructorAccessors() {
		
		$code = mt_rand(1, 30);
		$value = sha1(microtime(true));
		$offset = mt_rand(1, 100);
		
		$token = new Token($code, $value, $offset);
		
		$this->assertSame($code, $token->getCode());
		$this->assertSame($value, $token->getValue());
		$this->assertSame($offset, $token->getOffset());
	}
}
