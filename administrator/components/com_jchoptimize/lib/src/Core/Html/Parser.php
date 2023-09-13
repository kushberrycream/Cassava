<?php

/**
 * JCH Optimize - Performs several front-end optimizations for fast downloads.
 *
 * @author    Samuel Marshall <samuel@jch-optimize.net>
 * @copyright Copyright (c) 2022 Samuel Marshall / JCH Optimize
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 *  If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

namespace JchOptimize\Core\Html;

use CodeAlfa\RegexTokenizer\Html;
use JchOptimize\Core\Exception;
use JchOptimize\Core\Html\Callbacks\AbstractCallback;

\defined('_JCH_EXEC') or exit('Restricted access');
class Parser
{
    use Html;

    /** @var string Regex criteria of search */
    protected string $sCriteria = '';

    /** @var array Array of regex of excludes in search */
    protected array $aExcludes = [];

    /** @var array Array of ElementObjects containing criteria for elements to search for */
    protected array $aElementObjects = [];

    public function __construct()
    {
    }

    // language=RegExp
    public static function htmlBodyElementToken(): string
    {
        return self::htmlHeadElementToken().'\\K.*+$';
    }

    // language=RegExp
    public static function htmlHeadElementToken(): string
    {
        $aExcludes = [self::htmlElementToken('script'), self::htmlCommentToken()];

        return '<head\\b'.self::parseHtml($aExcludes).'</head\\b\\s*+>';
    }

    // language=RegExp
    public static function htmlClosingHeadTagToken(): string
    {
        $excludes = [self::htmlElementToken('script'), self::htmlCommentToken()];

        return self::parseHtml($excludes).'\\K(?:</head\\s*+>|$)';
    }

    // language=RegExp
    public static function htmlClosingBodyTagToken(): string
    {
        return '.*\\K</body\\s*+>(?=(?>[^<]*+(?:'.self::htmlCommentToken().')?)*?</html\\s*+>)';
    }

    public function addElementObject(ElementObject $oElementObject): void
    {
        $this->aElementObjects[] = $oElementObject;
    }

    public function addExclude(string $sExclude): void
    {
        $this->aExcludes[] = $sExclude;
    }

    /**
     * @return null|array|string|string[]
     *
     * @throws Exception\PregErrorException
     */
    public function processMatchesWithCallback(string $html, AbstractCallback $callbackObject)
    {
        $regex = $this->getHtmlSearchRegex();
        $callbackObject->setRegex($regex);
        $sProcessedHtml = \preg_replace_callback('#'.$regex.'#six', [$callbackObject, 'processMatches'], $html);

        try {
            self::throwExceptionOnPregError();
        } catch (\Exception $exception) {
            throw new Exception\PregErrorException($exception->getMessage());
        }

        return $sProcessedHtml;
    }

    /**
     * @param int|mixed $iFlags
     *
     * @psalm-param 1|2|mixed $iFlags
     *
     * @return ((null|(int|string)[]|mixed|string)[]|mixed)[]
     *
     * @psalm-return array<array<list{string, int}|mixed|null|string>|mixed>
     *
     * @throws Exception\PregErrorException
     */
    public function findMatches(string $sHtml, $iFlags = \PREG_PATTERN_ORDER): array
    {
        \preg_match_all('#'.$this->getHtmlSearchRegex().'#six', $sHtml, $aMatches, $iFlags);

        try {
            self::throwExceptionOnPregError();
        } catch (\Exception $exception) {
            throw new Exception\PregErrorException($exception->getMessage());
        }
        // Last array will always be an empty string so let's remove that
        if (\PREG_PATTERN_ORDER == $iFlags) {
            return \array_map(function ($a) {
                return \array_slice($a, 0, -1);
            }, $aMatches);
        } elseif (\PREG_SET_ORDER == $iFlags) {
            \array_pop($aMatches);

            return $aMatches;
        } else {
            return $aMatches;
        }
    }

    public function getElementWithCriteria(): string
    {
        $this->setCriteria(\false);

        return $this->sCriteria;
    }

    // language=RegExp
    protected static function parseHtml(array $excludes = [], $lazy = \true): string
    {
        $excludes[] = self::htmlSelfClosingElementToken();
        $excludes[] = '<';
        $excludes = '(?:'.\implode('|', $excludes).')?';
        $lazily = $lazy ? '?' : '';

        return '(?>[^<]*+'.$excludes.')*'.$lazily.'[^<]*+';
    }

    protected function getHtmlSearchRegex(): string
    {
        $this->setCriteria();
        // language=RegExp
        return self::parseHtml($this->getExcludes()).'\\K(?:'.$this->getCriteria().'|$)';
    }

    // language=RegExp
    protected function setCriteria(bool $bBranchReset = \true): void
    {
        $aCriteria = [];

        /** @var ElementObject $oElement */
        foreach ($this->aElementObjects as $oElement) {
            $sRegex = '<';
            $aNames = \implode('|', $oElement->getNamesArray());
            $sRegex .= '('.$aNames.')\\b\\s*+';
            $sRegex .= $this->compileCriteria($oElement);
            $aCaptureAttributes = $oElement->getCaptureAttributesArray();
            if (!empty($aCaptureAttributes)) {
                $mValueCriteria = $oElement->getValueCriteriaRegex();
                if (\is_string($mValueCriteria)) {
                    $aValueCriteria = ['.' => $mValueCriteria];
                } else {
                    $aValueCriteria = $mValueCriteria;
                }
                foreach ($aCaptureAttributes as $sCaptureAttribute) {
                    foreach ($aValueCriteria as $sRegexKey => $sValueCriteria) {
                        if ('' != $sValueCriteria && \preg_match('#'.$sRegexKey.'#i', $sCaptureAttribute)) {
                            // If criteria is specified for attribute it must match
                            $sRegex .= '(?='.$this->parseAttributes().'('.self::htmlAttributeWithCaptureValueToken($sCaptureAttribute, \true, \true, $sValueCriteria).'))';
                        } else {
                            // If no criteria specified matching is optional
                            $sRegex .= '(?=(?:'.$this->parseAttributes().'('.self::htmlAttributeWithCaptureValueToken($sCaptureAttribute, \true, \true).'))?)';
                        }
                    }
                }
            }
            if (!empty($aCaptureOneOrBothAttributes = $oElement->getCaptureOneOrBothAttributesArray())) {
                // Has to be either a string for both attributes or associative array of criteria for both attributes
                $mValueCriteria = $oElement->getValueCriteriaRegex();
                if (\is_string($mValueCriteria)) {
                    $aValueCriteria = [$aCaptureOneOrBothAttributes[0] => $mValueCriteria, $aCaptureOneOrBothAttributes[1] => $mValueCriteria];
                } else {
                    $aValueCriteria = $mValueCriteria;
                }
                $sRegex .= '(?(?='.$this->parseAttributes().'('.self::htmlAttributeWithCaptureValueToken($aCaptureOneOrBothAttributes[0], \true, \true, $aValueCriteria[$aCaptureOneOrBothAttributes[0]]).'))(?='.$this->parseAttributes().'('.self::htmlAttributeWithCaptureValueToken($aCaptureOneOrBothAttributes[1], \true, \true, $aValueCriteria[$aCaptureOneOrBothAttributes[1]]).'))?|(?='.$this->parseAttributes().'('.self::htmlAttributeWithCaptureValueToken($aCaptureOneOrBothAttributes[1], \true, \true, $aValueCriteria[$aCaptureOneOrBothAttributes[1]]).')))';
            }
            $sRegex .= $this->parseAttributes();
            $sRegex .= '/?>';
            if (!$oElement->bSelfClosing) {
                if ($oElement->bCaptureContent) {
                    $sRegex .= $oElement->getValueCriteriaRegex().'('.self::parseHtml().')';
                } else {
                    $sRegex .= self::parseHtml();
                }
                $sRegex .= '</(?:'.$aNames.')\\s*+>';
            }
            $aCriteria[] = $sRegex;
        }
        $sCriteria = \implode('|', $aCriteria);
        if ($bBranchReset) {
            $this->sCriteria = '(?|'.$sCriteria.')';
        } else {
            $this->sCriteria = $sCriteria;
        }
    }

    // language=RegExp
    protected function compileCriteria(ElementObject $oElement): string
    {
        $sCriteria = '';
        $aAttrNegCriteria = $oElement->getNegAttrCriteriaArray();
        if (!empty($aAttrNegCriteria)) {
            foreach ($aAttrNegCriteria as $sAttrNegCriteria) {
                $sCriteria .= $this->processNegCriteria($sAttrNegCriteria);
            }
        }
        $aAttrPosCriteria = $oElement->getPosAttrCriteriaArray();
        if (!empty($aAttrPosCriteria)) {
            foreach ($aAttrPosCriteria as $sAttrPosCriteria) {
                $sCriteria .= $this->processPosCriteria($sAttrPosCriteria);
            }
        }
        if ($oElement->bNegateCriteria) {
            $sCriteria = '(?!'.$sCriteria.')';
        }

        return $sCriteria;
    }

    // language=RegExp
    protected function processNegCriteria($sCriteria): string
    {
        return '(?!'.$this->processCriteria($sCriteria).')';
    }

    protected function processCriteria($sCriteria): string
    {
        return $this->parseAttributes().'(?:'.\str_replace('==', '\\s*+=\\s*+', $sCriteria).')';
    }

    // language=RegExp
    protected function parseAttributes(): string
    {
        return self::parseAttributesStatic();
    }

    // language=RegExp
    protected function processPosCriteria($sCriteria): string
    {
        return '(?='.$this->processCriteria($sCriteria).')';
    }

    protected function getExcludes(): array
    {
        return $this->aExcludes;
    }

    protected function getCriteria(): string
    {
        return $this->sCriteria;
    }
}
