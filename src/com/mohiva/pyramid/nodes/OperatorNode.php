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
 * Represents an operator node.
 * 
 * A operator node can be the root node or a node which can contain a left and 
 * a right node. This nodes can be either a operator node or a leaf node.
 * 
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
abstract class OperatorNode implements Node {
	
	/**
	 * The left node.
	 * 
	 * @var \com\mohiva\pyramid\Node
	 */
	protected $left = null;
	
	/**
	 * The right node.
	 * 
	 * @var \com\mohiva\pyramid\Node
	 */
	protected $right = null;
	
	/**
	 * The class constructor.
	 * 
	 * @param \com\mohiva\pyramid\Node|null $left The left node.
	 * @param \com\mohiva\pyramid\Node|null $right The right node.
	 */
	public function __construct(Node $left = null, Node $right = null) {
		
		$this->left = $left;
		$this->right = $right;
	}
}
