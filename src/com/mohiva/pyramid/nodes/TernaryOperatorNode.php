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
 * Represents an ternary operator node.
 *
 * An ternary operator has an expression, a if and a else node.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
abstract class TernaryOperatorNode implements Node {

	/**
	 * The condition node.
	 *
	 * @var Node
	 */
	protected $conditionNode = null;

	/**
	 * The if node.
	 *
	 * @var Node
	 */
	protected $ifNode = null;

	/**
	 * The else node.
	 *
	 * @var Node
	 */
	protected $elseNode = null;

	/**
	 * The class constructor.
	 *
	 * @param Node $conditionNode The condition node.
	 * @param Node $ifNode The if node.
	 * @param Node $elseNode The else node.
	 */
	public function __construct(Node $conditionNode, Node $ifNode, Node $elseNode) {

		$this->conditionNode = $conditionNode;
		$this->ifNode = $ifNode;
		$this->elseNode = $elseNode;
	}
}
