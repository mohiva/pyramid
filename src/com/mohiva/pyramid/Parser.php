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
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid;

use com\mohiva\common\parser\TokenStream;
use com\mohiva\common\exceptions\SyntaxErrorException;
use com\mohiva\pyramid\exceptions\InvalidIdentifierException;

/**
 * Implementation of an operator precedence parser based on the "Precedence climbing" algorithm.
 *
 * @see http://www.engr.mun.ca/~theo/Misc/exp_parsing.htm#climbing
 * @see http://en.wikipedia.org/wiki/Operator-precedence_parser
 * @see http://en.wikipedia.org/wiki/Interpreter_pattern
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class Parser {

	/**
	 * The grammar used for this parser.
	 *
	 * @var Grammar
	 */
	private $grammar = null;

	/**
	 * The stream to parse.
	 *
	 * @var TokenStream
	 */
	private $stream = null;

	/**
	 * The class constructor.
	 *
	 * @param Grammar $grammar The grammar used for this parser.
	 */
	public function  __construct(Grammar $grammar) {

		$this->grammar = $grammar;
	}

	/**
	 * Parse the token stream and return the resulting parse tree.
	 *
	 * @param TokenStream $stream The stream to parse.
	 * @return Node The root of the node tree.
	 */
	public function parse(TokenStream $stream) {

		$this->stream = $stream;

		$node = $this->parseExpression(0);

		return $node;
	}

	/**
	 * Parse the expression.
	 *
	 * @param int $precedence The precedence level.
	 * @return Node The expression node.
	 */
	private function parseExpression($precedence) {

		/* @var Token $token */
		$operatorTable = $this->grammar->getOperatorTable();
		$node = $this->parsePrimary();
		$token = $this->stream->current();
		while ($token && $operatorTable->isBinary($token) &&
			$operatorTable->getBinaryOperator($token)->getPrecedence() >= $precedence) {

			$this->stream->next();

			$operator = $operatorTable->getBinaryOperator($token);
			$operatorNode = $operator->getNode();
			$node = $operatorNode($node, $this->parseExpression(
				$operator->isRightAssociative()
					? $operator->getPrecedence()
					: $operator->getPrecedence() + 1
			));

			$token = $this->stream->current();
		}

		return $node;
	}

	/**
	 * Parse primary expression.
	 *
	 * @return Node The primary node.
	 * @throws SyntaxErrorException if no operand or unary operator can be found.
	 */
	private function parsePrimary() {

		/* @var Token $token */
		$token = $this->stream->current();
		$operatorTable = $this->grammar->getOperatorTable();
		if ($token && $operatorTable->isUnary($token)) {
			$this->stream->next();
			$operator = $operatorTable->getUnaryOperator($token);
			$operatorNode = $operator->getNode();
			$node = $operatorNode($this->parseExpression($operator->getPrecedence()));
		} else if ($token) {
			$node = $this->parseOperand();
			$this->stream->next();
		} else {
			throw new SyntaxErrorException('Operand or unary operator expected; but end of stream reached');
		}

		return $node;
	}

	/**
	 * Parse the operand.
	 *
	 * @return Node The node object for the operand.
	 * @throws SyntaxErrorException if no operand parser can be found for
	 * the current token.
	 */
	private function parseOperand() {

		/* @var Token $token */
		$token = $this->stream->current();
		$operandTable = $this->grammar->getOperandTable();
		try {
			/* @var Operand $operand */
			$operand = $operandTable->getOperand($token);
		} catch (InvalidIdentifierException $e) {
			$message = "Cannot find operand parser for token `{$token->getValue()}`";
			throw new SyntaxErrorException($message, 0, $e);
		}

		return $operand->parse($this->grammar, $this->stream);
	}
}
