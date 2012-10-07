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
 * @package   Mohiva/Pyramid/Example/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\example\nodes;

use com\mohiva\pyramid\nodes\TernaryOperatorNode;

/**
 * Represents a ternary if operation.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Example/Nodes
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class TernaryIfNode extends TernaryOperatorNode {

	/**
	 * Evaluates the node.
	 *
	 * @return number The result of the evaluation.
	 */
	public function evaluate() {

		$condition = $this->conditionNode->evaluate();
		if ($condition && $this->ifNode === null) {
			return $condition;
		} else if ($condition) {
			return $this->ifNode->evaluate();
		} else {
			return $this->elseNode->evaluate();
		}
	}
}
