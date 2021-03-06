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
 * @package   Mohiva/Pyramid/Example
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
namespace com\mohiva\pyramid\example;

use com\mohiva\common\parser\TokenStream;
use com\mohiva\pyramid\Token;

/**
 * Tokenize an expression.
 *
 * @category  Mohiva/Pyramid
 * @package   Mohiva/Pyramid/Example
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/pyramid/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/pyramid
 */
class Lexer {

	/**
	 * Expression tokens.
	 *
	 * @var int
	 */
	const T_NONE              = 0;
	const T_OPEN_PARENTHESIS  = 1;  // (
	const T_CLOSE_PARENTHESIS = 2;  // )
	const T_NUMBER            = 3;  // 1,0.1
	const T_PLUS              = 4;  // +
	const T_MINUS             = 5;  // -
	const T_MUL               = 6;  // *
	const T_DIV               = 7;  // /
	const T_MOD               = 8;  // %
	const T_POWER             = 9;  // ^
	const T_QUESTION_MARK     = 10; // ?
	const T_COLON             = 11; // :

	/**
	 * The lexemes to find the tokens.
	 *
	 * @var array
	 */
	private $lexemes = array(
		'([0-9]+\.?[0-9]*)',
		'(.)'
	);

	/**
	 * Map the constant values with its token type.
	 *
	 * @var int[]
	 */
	private $constTokenMap = array(
		'(' => self::T_OPEN_PARENTHESIS,
		')' => self::T_CLOSE_PARENTHESIS,
		'+' => self::T_PLUS ,
		'-' => self::T_MINUS,
		'*' => self::T_MUL,
		'/' => self::T_DIV,
		'%' => self::T_MOD,
		'^' => self::T_POWER,
		'?' => self::T_QUESTION_MARK,
		':' => self::T_COLON
	);

	/**
	 * Tokenize the given input string and return the resulting token stream.
	 *
	 * @param string $input The string input to scan.
	 * @return TokenStream The resulting token stream.
	 */
	public function scan($input) {

		$stream = $this->tokenize($input);
		$stream->rewind();

		return $stream;
	}

	/**
	 * Transform the input string into a token stream.
	 *
	 * @param string $input The string input to tokenize.
	 * @return TokenStream The resulting token stream.
	 */
	private function tokenize($input) {

		$stream = new TokenStream();
		$stream->setSource($input);

		$pattern = '/' . implode('|', $this->lexemes) . '/';
		$flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
		$matches = preg_split($pattern, $input, -1, $flags);
		foreach ($matches as $match) {

			$value = strtolower($match[0]);
			if (is_numeric($value)) {
				$code = self::T_NUMBER;
			} else if (isset($this->constTokenMap[$value])) {
				$code = $this->constTokenMap[$value];
			} else if (ctype_space($value)) {
				continue;
			} else {
				$code = self::T_NONE;
			}

			$stream->push(new Token(
				$code,
				$match[0],
				$match[1]
			));
		}

		return $stream;
	}
}
