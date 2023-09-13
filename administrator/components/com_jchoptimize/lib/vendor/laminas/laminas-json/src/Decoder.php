<?php

namespace _JchOptimizeVendor\Laminas\Json;

use _JchOptimizeVendor\Laminas\Json\Exception\InvalidArgumentException;
use _JchOptimizeVendor\Laminas\Json\Exception\RuntimeException;
use stdClass;

use function mb_convert_encoding;

/**
 * Decode JSON encoded string to PHP variable constructs.
 */
class Decoder
{
    /**
     * Parse tokens used to decode the JSON object. These are not
     * for public consumption, they are just used internally to the
     * class.
     */
    public const EOF = 0;
    public const DATUM = 1;
    public const LBRACE = 2;
    public const LBRACKET = 3;
    public const RBRACE = 4;
    public const RBRACKET = 5;
    public const COMMA = 6;
    public const COLON = 7;

    /**
     * Use to maintain a "pointer" to the source being decoded.
     *
     * @var string
     */
    protected $source;

    /**
     * Caches the source length.
     *
     * @var int
     */
    protected $sourceLength;

    /**
     * The offset within the source being decoded.
     *
     * @var int
     */
    protected $offset;

    /**
     * The current token being considered in the parser cycle.
     *
     * @var int
     */
    protected $token;

    /**
     * Flag indicating how objects should be decoded.
     *
     * @var int
     */
    protected $decodeType;

    /** @var mixed */
    protected $tokenValue;

    /**
     * Constructor.
     *
     * @param string $source     String source to decode
     * @param int    $decodeType How objects should be decoded -- see
     *                           {@link Json::TYPE_ARRAY} and {@link Json::TYPE_OBJECT} for * valid
     *                           values
     *
     * @throws InvalidArgumentException
     */
    protected function __construct($source, $decodeType)
    {
        // Set defaults
        $this->source = self::decodeUnicodeString($source);
        $this->sourceLength = \strlen($this->source);
        $this->token = self::EOF;
        $this->offset = 0;

        switch ($decodeType) {
            case Json::TYPE_ARRAY:
            case Json::TYPE_OBJECT:
                $this->decodeType = $decodeType;

                break;

            default:
                throw new InvalidArgumentException(\sprintf('Unknown decode type "%s", please use one of the Json::TYPE_* constants', $decodeType));
        }
        // Set pointer at first token
        $this->getNextToken();
    }

    /**
     * Decode Unicode Characters from \u0000 ASCII syntax.
     *
     * This algorithm was originally developed for the
     * Solar Framework by Paul M. Jones
     *
     * @see   http://solarphp.com/
     * @see   https://github.com/solarphp/core/blob/master/Solar/Json.php
     *
     * @param string $chrs
     *
     * @return string
     */
    public static function decodeUnicodeString($chrs)
    {
        $chrs = (string) $chrs;
        $utf8 = '';
        $strlenChrs = \strlen($chrs);
        for ($i = 0; $i < $strlenChrs; ++$i) {
            $ordChrsC = \ord($chrs[$i]);

            switch (\true) {
                case \preg_match('/\\\\u[0-9A-F]{4}/i', \substr($chrs, $i, 6)):
                    // single, escaped unicode character
                    $utf16 = \chr(\hexdec(\substr($chrs, $i + 2, 2))).\chr(\hexdec(\substr($chrs, $i + 4, 2)));
                    $utf8char = self::utf162utf8($utf16);
                    $search = ['\\', "\n", "\t", "\r", \chr(0x8), \chr(0xC), '"', '\'', '/'];
                    if (\in_array($utf8char, $search)) {
                        $replace = ['\\\\', '\\n', '\\t', '\\r', '\\b', '\\f', '\\"', '\\\'', '\\/'];
                        $utf8char = \str_replace($search, $replace, $utf8char);
                    }
                    $utf8 .= $utf8char;
                    $i += 5;

                    break;

                case $ordChrsC >= 0x20 && $ordChrsC <= 0x7F:
                    $utf8 .= $chrs[$i];

                    break;

                case ($ordChrsC & 0xE0) === 0xC0:
                    // characters U-00000080 - U-000007FF, mask 110XXXXX
                    // see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                    $utf8 .= \substr($chrs, $i, 2);
                    ++$i;

                    break;

                case ($ordChrsC & 0xF0) === 0xE0:
                    // characters U-00000800 - U-0000FFFF, mask 1110XXXX
                    // see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                    $utf8 .= \substr($chrs, $i, 3);
                    $i += 2;

                    break;

                case ($ordChrsC & 0xF8) === 0xF0:
                    // characters U-00010000 - U-001FFFFF, mask 11110XXX
                    // see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                    $utf8 .= \substr($chrs, $i, 4);
                    $i += 3;

                    break;

                case ($ordChrsC & 0xFC) === 0xF8:
                    // characters U-00200000 - U-03FFFFFF, mask 111110XX
                    // see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                    $utf8 .= \substr($chrs, $i, 5);
                    $i += 4;

                    break;

                case ($ordChrsC & 0xFE) === 0xFC:
                    // characters U-04000000 - U-7FFFFFFF, mask 1111110X
                    // see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                    $utf8 .= \substr($chrs, $i, 6);
                    $i += 5;

                    break;
            }
        }

        return $utf8;
    }

    /**
     * Decode a JSON source string.
     *
     * Decodes a JSON encoded string; the value returned will be one of the
     * following:
     *
     * - integer
     * - float
     * - boolean
     * - null
     * - stdClass
     * - array
     * - array of one or more of the above types
     *
     * By default, decoded objects will be returned as a stdClass object;
     * to return associative arrays instead, pass {@link Json::TYPE_ARRAY}
     * to the $objectDecodeType parameter.
     *
     * @param string $source           string to be decoded
     * @param int    $objectDecodeType how objects should be decoded; should be
     *                                 either or {@link Json::TYPE_ARRAY} or {@link Json::TYPE_OBJECT};
     *                                 defaults to Json::TYPE_OBJECT
     *
     * @return mixed
     */
    public static function decode($source, $objectDecodeType = Json::TYPE_OBJECT)
    {
        $decoder = new static($source, $objectDecodeType);

        return $decoder->decodeValue();
    }

    /**
     * Recursive routine for supported toplevel types.
     *
     * @return mixed
     */
    protected function decodeValue()
    {
        switch ($this->token) {
            case self::DATUM:
                $result = $this->tokenValue;
                $this->getNextToken();

                return $result;

            case self::LBRACE:
                return $this->decodeObject();

            case self::LBRACKET:
                return $this->decodeArray();

            default:
                return;
        }
    }

    /**
     * Decodes an object of the form { "attribute: value, "attribute2" : value, ... }.
     *
     * If Laminas\Json\Encoder was used to encode the original object, then
     * a special attribute called __className will specify a class
     * name with which to wrap the data contained within the encoded source.
     *
     * Decodes to either an array or stdClass object, based on the value of
     * {@link $decodeType}. If invalid $decodeType present, returns as an
     * array.
     *
     * @return array|\stdClass
     *
     * @throws RuntimeException
     */
    protected function decodeObject()
    {
        $members = [];
        $tok = $this->getNextToken();
        while ($tok && self::RBRACE !== $tok) {
            if (self::DATUM !== $tok || !\is_string($this->tokenValue)) {
                throw new RuntimeException(\sprintf('Missing key in object encoding: %s', $this->source));
            }
            $key = $this->tokenValue;
            $tok = $this->getNextToken();
            if (self::COLON !== $tok) {
                throw new RuntimeException(\sprintf('Missing ":" in object encoding: %s', $this->source));
            }
            $this->getNextToken();
            $members[$key] = $this->decodeValue();
            $tok = $this->token;
            if (self::RBRACE === $tok) {
                break;
            }
            if (self::COMMA !== $tok) {
                throw new RuntimeException(\sprintf('Missing "," in object encoding: %s', $this->source));
            }
            $tok = $this->getNextToken();
        }

        switch ($this->decodeType) {
            case Json::TYPE_OBJECT:
                // Create new stdClass and populate with $members
                $result = new \stdClass();
                foreach ($members as $key => $value) {
                    if ('' === $key) {
                        $key = '_empty_';
                    }
                    $result->{$key} = $value;
                }

                break;

            case Json::TYPE_ARRAY:
                // intentionally fall-through
            default:
                $result = $members;

                break;
        }
        $this->getNextToken();

        return $result;
    }

    /**
     * Decodes the JSON array format [element, element2, ..., elementN].
     *
     * @return array
     *
     * @throws RuntimeException
     */
    protected function decodeArray()
    {
        $result = [];
        $tok = $this->getNextToken();
        // Move past the '['
        $index = 0;
        while ($tok && self::RBRACKET !== $tok) {
            $result[$index++] = $this->decodeValue();
            $tok = $this->token;
            if (self::RBRACKET === $tok || !$tok) {
                break;
            }
            if (self::COMMA !== $tok) {
                throw new RuntimeException(\sprintf('Missing "," in array encoding: %s', $this->source));
            }
            $tok = $this->getNextToken();
        }
        $this->getNextToken();

        return $result;
    }

    /**
     * Removes whitespace characters from the source input.
     */
    protected function eatWhitespace()
    {
        if (\preg_match('/([\\t\\b\\f\\n\\r ])*/s', $this->source, $matches, \PREG_OFFSET_CAPTURE, $this->offset) && $matches[0][1] === $this->offset) {
            $this->offset += \strlen($matches[0][0]);
        }
    }

    /**
     * Retrieves the next token from the source stream.
     *
     * @return int token constant value specified in class definition
     *
     * @throws RuntimeException
     */
    protected function getNextToken()
    {
        $this->token = self::EOF;
        $this->tokenValue = null;
        $this->eatWhitespace();
        if ($this->offset >= $this->sourceLength) {
            return self::EOF;
        }
        $str = $this->source;
        $strLength = $this->sourceLength;
        $i = $this->offset;
        $start = $i;

        switch ($str[$i]) {
            case '{':
                $this->token = self::LBRACE;

                break;

            case '}':
                $this->token = self::RBRACE;

                break;

            case '[':
                $this->token = self::LBRACKET;

                break;

            case ']':
                $this->token = self::RBRACKET;

                break;

            case ',':
                $this->token = self::COMMA;

                break;

            case ':':
                $this->token = self::COLON;

                break;

            case '"':
                $result = '';
                do {
                    ++$i;
                    if ($i >= $strLength) {
                        break;
                    }
                    $chr = $str[$i];
                    if ('"' === $chr) {
                        break;
                    }
                    if ('\\' !== $chr) {
                        $result .= $chr;

                        continue;
                    }
                    ++$i;
                    if ($i >= $strLength) {
                        break;
                    }
                    $chr = $str[$i];

                    switch ($chr) {
                        case '"':
                            $result .= '"';

                            break;

                        case '\\':
                            $result .= '\\';

                            break;

                        case '/':
                            $result .= '/';

                            break;

                        case 'b':
                            $result .= "\x08";

                            break;

                        case 'f':
                            $result .= "\f";

                            break;

                        case 'n':
                            $result .= "\n";

                            break;

                        case 'r':
                            $result .= "\r";

                            break;

                        case 't':
                            $result .= "\t";

                            break;

                        case '\'':
                            $result .= '\'';

                            break;

                        default:
                            throw new RuntimeException(\sprintf('Illegal escape sequence "%s"', $chr));
                    }
                } while ($i < $strLength);
                $this->token = self::DATUM;
                $this->tokenValue = $result;

                break;

            case 't':
                if ($i + 3 < $strLength && $start === \strpos($str, 'true', $start)) {
                    $this->token = self::DATUM;
                }
                $this->tokenValue = \true;
                $i += 3;

                break;

            case 'f':
                if ($i + 4 < $strLength && $start === \strpos($str, 'false', $start)) {
                    $this->token = self::DATUM;
                }
                $this->tokenValue = \false;
                $i += 4;

                break;

            case 'n':
                if ($i + 3 < $strLength && $start === \strpos($str, 'null', $start)) {
                    $this->token = self::DATUM;
                }
                $this->tokenValue = null;
                $i += 3;

                break;
        }
        if (self::EOF !== $this->token) {
            $this->offset = $i + 1;
            // Consume the last token character
            return $this->token;
        }
        $chr = $str[$i];
        if ('-' !== $chr && '.' !== $chr && ($chr < '0' || $chr > '9')) {
            throw new RuntimeException('Illegal Token');
        }
        if (\preg_match('/-?([0-9])*(\\.[0-9]*)?((e|E)((-|\\+)?)[0-9]+)?/s', $str, $matches, \PREG_OFFSET_CAPTURE, $start) && $matches[0][1] === $start) {
            $datum = $matches[0][0];
            if (!\is_numeric($datum)) {
                throw new RuntimeException(\sprintf('Illegal number format: %s', $datum));
            }
            if (\preg_match('/^0\\d+$/', $datum)) {
                throw new RuntimeException(\sprintf('Octal notation not supported by JSON (value: %o)', $datum));
            }
            $val = \intval($datum);
            $fVal = \floatval($datum);
            // phpcs:ignore SlevomatCodingStandard.Operators.DisallowEqualOperators.DisallowedEqualOperator
            $this->tokenValue = $val == $fVal ? $val : $fVal;
            $this->token = self::DATUM;
            $this->offset = $start + \strlen($datum);
        }

        return $this->token;
    }

    /**
     * Convert a string from one UTF-16 char to one UTF-8 char.
     *
     * Normally should be handled by mb_convert_encoding, but provides a slower
     * PHP-only method for installations that lack the multibyte string
     * extension.
     *
     * This method is from the Solar Framework by Paul M. Jones.
     *
     * @see   http://solarphp.com
     *
     * @param string $utf16 UTF-16 character
     *
     * @return string UTF-8 character
     */
    protected static function utf162utf8($utf16)
    {
        // Check for mb extension otherwise do by hand.
        if (\function_exists('mb_convert_encoding')) {
            return \mb_convert_encoding($utf16, 'UTF-8', 'UTF-16');
        }
        $bytes = \ord($utf16[0]) << 8 | \ord($utf16[1]);

        switch (\true) {
            case (0x7F & $bytes) === $bytes:
                // This case should never be reached, because we are in ASCII range;
                // see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                return \chr(0x7F & $bytes);

            case (0x7FF & $bytes) === $bytes:
                // Return a 2-byte UTF-8 character;
                // see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                return \chr(0xC0 | $bytes >> 6 & 0x1F).\chr(0x80 | $bytes & 0x3F);

            case (0xFFFF & $bytes) === $bytes:
                // Return a 3-byte UTF-8 character;
                // see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                return \chr(0xE0 | $bytes >> 12 & 0xF).\chr(0x80 | $bytes >> 6 & 0x3F).\chr(0x80 | $bytes & 0x3F);
        }
        // ignoring UTF-32 for now, sorry
        return '';
    }
}
