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
 * A binary operator has a left and a right child node.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
abstract class BinaryOperatorNode implements Node {

	/**
	 * The left child node.
	 *
	 * @var \com\mohiva\pyramid\Node
	 */
	protected $left = null;

	/**
	 * The right child node.
	 *
	 * @var \com\mohiva\pyramid\Node
	 */
	protected $right = null;

	/**
	 * The class constructor.
	 *
	 * @param \com\mohiva\pyramid\Node $left The left child node.
	 * @param \com\mohiva\pyramid\Node $right The right child node.
	 */
	public function __construct(Node $left, Node $right) {

		$this->left = $left;
		$this->right = $right;
	}
}
