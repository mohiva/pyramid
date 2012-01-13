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
 * @package   Mohiva/Pyramid/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\nodes;

use com\mohiva\pyramid\Node;

/**
 * Represents a binary operator node.
 * 
 * An unary operator can only have on child node.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
abstract class UnaryOperatorNode implements Node {
	
	/**
	 * The child node.
	 * 
	 * @var \com\mohiva\pyramid\Node
	 */
	protected $node = null;
	
	/**
	 * The class constructor.
	 * 
	 * @param \com\mohiva\pyramid\Node $node The child node.
	 */
	public function __construct(Node $node) {
		
		$this->node = $node;
	}
}
