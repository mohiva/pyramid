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

/**
 * Test suite for the Mohiva Pyramid project.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class AllTests extends \PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		
		$this->setName(__CLASS__);
		$this->addTest(example\AllTests::suite());
		$this->addTest(operators\AllTests::suite());
		$this->addTestSuite(__NAMESPACE__ . '\GrammarTest');
		$this->addTestSuite(__NAMESPACE__ . '\OperandTableTest');
		$this->addTestSuite(__NAMESPACE__ . '\OperatorTableTest');
		$this->addTestSuite(__NAMESPACE__ . '\ParserTest');
		$this->addTestSuite(__NAMESPACE__ . '\TokenTest');
	}
	
	/**
	 * Creates the suite.
	 * 
	 * @return AllTests The test suite.
	 */
	public static function suite() {
		
		return new self();
	}
}
