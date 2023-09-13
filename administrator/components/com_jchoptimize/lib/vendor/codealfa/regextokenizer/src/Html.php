<?php

/**
 * @author    Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2020 Samuel Marshall
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

namespace CodeAlfa\RegexTokenizer;

trait Html
{
    use \CodeAlfa\RegexTokenizer\Base;

    /**
     * Regex token for a string.
     */
    // language=RegExp
    public static function htmlCommentToken(): string
    {
        return '<!--(?>-?[^-]*+)*?--!?>';
        // return '(?:(?:<!--|(?<=[\s/^])-->)[^\r\n]*+)';
    }

    /**
     * Regex token for an array of HTML elements.
     *
     * @param string[] $elements Array of names of HTML elements
     */
    // language=RegExp
    public static function htmlElementsToken(array $elements): string
    {
        $result = [];
        foreach ($elements as $element) {
            $result[] = self::htmlElementToken($element);
        }

        return '(?:'.\implode('|', $result).')';
    }

    /**
     * Regex token for an HTML element.
     *
     * @param string $element       Name of HTML element
     * @param bool   $isSelfClosing Whether element is self-closing
     */
    // language=RegExp
    public static function htmlElementToken(string $element = '', bool $isSelfClosing = \false): string
    {
        $name = '' != $element ? $element : self::htmlGenericElementToken();
        $tag = '<'.$name.'\\b(?:\\s++'.self::parseAttributesStatic().')?\\s*+>';
        if (!$isSelfClosing) {
            $tag .= '(?><?[^<]*+)*?</'.$name.'\\s*+>';
        }

        return $tag;
    }

    /**
     * Regex token for any valid HTML element name.
     */
    // language=RegExp
    public static function htmlGenericElementToken(): string
    {
        return '[a-z0-9]++';
    }

    /**
     * Regex token for an HTML attribute, optionally capturing the value in a capture group.
     */
    // language=RegExp
    public static function htmlAttributeWithCaptureValueToken(string $attrName = '', bool $captureValue = \false, bool $captureDelimiter = \false, string $matchedValue = ''): string
    {
        $name = '' != $attrName ? $attrName : '[^\\s/"\'=<>]++';
        $delimiter = $captureDelimiter ? '([\'"]?)' : '[\'"]?';
        // If we don't need to match a value then the value of attribute is optional
        if ('' == $matchedValue) {
            $attribute = $name.'(?:\\s*+=\\s*+(?>'.$delimiter.')<<'.self::htmlAttributeValueToken().'>>[\'"]?)?';
        } else {
            $attribute = $name.'\\s*+=\\s*+(?>'.$delimiter.')'.$matchedValue.'<<'.self::htmlAttributeValueToken().'>>[\'"]?';
        }

        return self::prepare($attribute, $captureValue);
    }

    /**
     * Regex token for an HTML attribute value.
     */
    // language=RegExp
    public static function htmlAttributeValueToken(): string
    {
        return '(?:'.self::stringValueToken().'|'.self::htmlUnquotedAttributeValueToken().')';
    }

    /**
     * Regex token for an unquoted HTML attribute value.
     */
    // language=RegExp
    public static function htmlUnquotedAttributeValueToken(): string
    {
        return '(?<==)[^\\s*+>]++';
    }

    /**
     * Regex token for a self closing HTML element.
     *
     * @param string $element Name of element
     */
    public static function htmlSelfClosingElementToken(string $element = ''): string
    {
        return self::htmlElementToken($element, \true);
    }

    /**
     * Regex for parsing an HTML attribute.
     */
    // language=RegExp
    protected static function parseAttributesStatic(): string
    {
        return '(?>'.self::htmlAttributeWithCaptureValueToken().'\\s*+)*?';
    }
}
