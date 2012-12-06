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
	 * The operator table.
	 *
	 * @var OperatorTable
	 */
	private $operatorTable = null;

	/**
	 * The operand table.
	 *
	 * @var OperandTable
	 */
	private $operandTable = null;

	/**
	 * The class constructor.
	 *
	 * @param Grammar $grammar The grammar used for this parser.
	 */
	public function  __construct(Grammar $grammar) {

		$this->grammar = $grammar;
		$this->operatorTable = $this->grammar->getOperatorTable();
		$this->operandTable = $this->grammar->getOperandTable();
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
		$node = $this->parsePrimary();
		while (($token = $this->stream->current()) && $this->operatorTable->isBinary($token)) {
			$operator = $this->operatorTable->getBinaryOperator($token);
			if ($operator->getPrecedence() < $precedence) {
				break;
			}

			$this->stream->next();
			$operatorNode = $operator->getNode();
			$node = $operatorNode($node, $this->parseExpression(
				$operator->isRightAssociative()
					? $operator->getPrecedence()
					: $operator->getPrecedence() + 1
			));
		}

		$node = $this->parseTernary($node, $precedence);

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
		if ($token && $this->operatorTable->isUnary($token)) {
			$this->stream->next();
			$operator = $this->operatorTable->getUnaryOperator($token);
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
	 * Parse the ternary operator.
	 *
	 * @param Node $node The expression node.
	 * @param int $precedence The precedence level.
	 * @return Node The ternary operator node or the given expression node.
	 * @throws SyntaxErrorException if no ternary else can be found after a ternary if.
	 */
	private function parseTernary(Node $node, $precedence) {

		/* @var Token $token */
		while (($token = $this->stream->current()) && $this->operatorTable->isTernary($token)) {
			$operator = $this->operatorTable->getTernaryOperator($token);
			if ($operator->getIfCode() != $token->getCode() || $operator->getPrecedence() < $precedence) {
				break;
			}

			$operatorNode = $operator->getNode();
			$subPrecedence = $operator->isRightAssociative()
				? $operator->getPrecedence()
				: $operator->getPrecedence() + 1;

			// Parse the if expression
			if ($operator->isShorthandAllowed() && $this->stream->getLookaheadCode() == $operator->getElseCode()) {
				$this->stream->next();
				$if = null;
			} else {
				$this->stream->next();
				$if = $this->parseExpression($subPrecedence);
			}

			// Parse the else expression
			$this->stream->expect([$operator->getElseCode()], function(Token $current = null) {
				if ($current) {
					$near = substr($this->stream->getSource(), 0, $current->getOffset());
					$message = "Ternary else expected; got `{$current->getValue()}`; near: " . $near;
				} else {
					$near = substr($this->stream->getSource(), 0, strlen($this->stream->getSource()));
					$message = "Ternary else expected but end of stream reached; near: " . $near;
				}

				throw new SyntaxErrorException($message);
			});

			$this->stream->next();
			$else = $this->parseExpression($subPrecedence);

			// Create the ternary operator node
			$node = $operatorNode($node, $if, $else);
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
		try {
			/* @var Operand $operand */
			$operand = $this->operandTable->getOperand($token);
		} catch (InvalidIdentifierException $e) {
			$message = "Cannot find operand parser for token `{$token->getValue()}`";
			throw new SyntaxErrorException($message, 0, $e);
		}

		return $operand->parse($this->grammar, $this->stream);
	}
}
