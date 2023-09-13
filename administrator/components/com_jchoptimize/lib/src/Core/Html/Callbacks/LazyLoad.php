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

namespace JchOptimize\Core\Html\Callbacks;

use _JchOptimizeVendor\Joomla\DI\Container;
use _JchOptimizeVendor\Psr\Http\Message\UriInterface;
use JchOptimize\Core\Css\Processor;
use JchOptimize\Core\Exception\PregErrorException;
use JchOptimize\Core\FeatureHelpers\LazyLoadExtended;
use JchOptimize\Core\FeatureHelpers\Webp;
use JchOptimize\Core\Helper;
use JchOptimize\Core\Html\ElementObject;
use JchOptimize\Core\Html\Parser;
use JchOptimize\Core\Http2Preload;
use JchOptimize\Core\Uri\Utils;
use Joomla\Registry\Registry;

\defined('_JCH_EXEC') or exit('Restricted access');
class LazyLoad extends \JchOptimize\Core\Html\Callbacks\AbstractCallback
{
    /**
     * @var bool Used to indicate when the child of a parent element is excluded so the whole element
     *           can be excluded
     */
    public bool $isExcluded = \false;

    public Http2Preload $http2Preload;

    /**
     * @var int Width of <img> element inside <picture>
     */
    public int $width = 1;

    /**
     * @var int Height of <img> element inside picture
     */
    public int $height = 1;

    protected array $excludes;

    protected array $args;

    public function __construct(Container $container, Registry $params, Http2Preload $http2Preload)
    {
        parent::__construct($container, $params);
        $this->http2Preload = $http2Preload;
        $this->getLazyLoadExcludes();
    }

    public function processMatches(array $matches): string
    {
        if (empty($matches[0])) {
            return $matches[0];
        }
        // If we're lazyloading background images in a style that wasn't combined
        if ('style' == $matches[1] && \JCH_PRO && ($this->params->get('pro_lazyload_bgimages', '0') || $this->params->get('pro_load_webp_images', '0'))) {
            /** @var Processor $cssProcessor */
            $cssProcessor = $this->getContainer()->get(Processor::class);
            $cssProcessor->setCss($matches[2]);
            $cssProcessor->processUrls();
            $processedCss = $cssProcessor->getCss();

            return \str_replace($matches[2], $processedCss, $matches[0]);
        }
        // Let's assign more readily recognizable names to the matches
        $matches['fullMatch'] = $matches[0];
        $matches['elementName'] = !empty($matches[1]) ? $matches[1] : \false;
        $matches['classAttribute'] = !empty($matches[2]) ? $matches[2] : \false;
        $matches['classDelimiter'] = !empty($matches[3]) ? $matches[3] : '"';
        $matches['classValue'] = !empty($matches[4]) ? $matches[4] : \false;
        $matches['srcAttribute'] = $matches['innerContent'] = $matches['styleAttribute'] = !empty($matches[5]) ? $matches[5] : \false;
        $matches['srcDelimiter'] = $matches['styleDelimiter'] = !empty($matches[6]) ? $matches[6] : '"';
        $matches['srcValue'] = $matches['bgDeclaration'] = !empty($matches[7]) ? $matches[7] : \false;
        $matches['srcsetAttribute'] = $matches['posterAttribute'] = $matches['cssUrl'] = !empty($matches[8]) ? $matches[8] : \false;
        $matches['srcsetDelimiter'] = $matches['posterDelimiter'] = $matches['cssUrlValue'] = !empty($matches[9]) ? $matches[9] : \false;
        $matches['srcsetValue'] = $matches['posterValue'] = !empty($matches[10]) ? $matches[10] : \false;
        $matches['autoloadAttribute'] = $matches['preloadAttribute'] = $matches['widthAttribute'] = !empty($matches[11]) ? $matches[11] : \false;
        $matches['widthDelimiter'] = $matches['preloadDelimiter'] = !empty($matches[12]) ? $matches[12] : \false;
        $matches['widthValue'] = $matches['preloadValue'] = !empty($matches[13]) ? (int) $matches[13] : 1;
        $matches['heightAttribute'] = $matches['autoplayAttribute'] = !empty($matches[14]) ? $matches[14] : \false;
        $matches['heightDelimiter'] = $matches['autoplayDelimiter'] = !empty($matches[15]) ? $matches[15] : \false;
        $matches['heightValue'] = $matches['autoplayValue'] = !empty($matches[16]) ? (int) $matches[16] : 1;
        // if source, assign the width and height value of related img element
        if ('source' == $matches['elementName']) {
            if ($matches['widthValue'] <= 1) {
                $matches['widthValue'] = $this->width;
            }
            if ($matches['heightValue'] <= 1) {
                $matches['heightValue'] = $this->height;
            }
        }
        $isLazyLoaded = \false;
        // Return match if it isn't an HTML element
        if (\false === $matches['elementName']) {
            return $matches['fullMatch'];
        }

        switch ($matches['elementName']) {
            case 'img':
            case 'input':
            case 'iframe':
            case 'source':
                $imgType = 'embed';

                break;

            case 'picture':
                $imgType = 'picture';

                break;

            case 'video':
            case 'audio':
                $imgType = 'audiovideo';

                break;

            default:
                $imgType = 'background';

                break;
        }
        if ('embed' == $imgType && \false !== $matches['srcValue']) {
            $matches['srcValue'] = Utils::uriFor(\trim($matches['srcValue']));
        }
        if ('background' == $imgType && \false !== $matches['cssUrlValue']) {
            $matches['cssUrlValue'] = Utils::uriFor(\trim($matches['cssUrlValue']));
        }
        if ('audiovideo' == $imgType && \false !== $matches['posterValue']) {
            $matches['posterValue'] = Utils::uriFor(\trim($matches['posterValue']));
        }
        if (\JCH_PRO && $this->params->get('pro_load_webp_images', '0') && 'picture' != $matches['elementName']) {
            /** @see Webp::convert() */
            $matches = $this->getContainer()->get(Webp::class)->convert($matches);
        }
        if ($this->args['lazyload']) {
            if (\false !== $matches['srcValue'] && ('img' == $matches['elementName'] || 'input' == $matches['elementName'])) {
                $this->http2Preload->add($matches['srcValue'], 'image', \true);
            }
            // Start modifying the element to return
            $return = $matches['fullMatch'];
            // Exclude based on class
            if (\false !== $matches['classValue']) {
                if ($matches['elementName'] && Helper::findExcludes($this->excludes['class'], $matches['classValue'])) {
                    // If element child of a parent element set excluded flag
                    if ('' != $this->args['parent']) {
                        $this->isExcluded = \true;
                    }
                    // Remove any lazy loading from excluded images
                    $matches['fullMatch'] = $this->removeLoadingAttribute($matches['fullMatch']);

                    return $matches['fullMatch'];
                }
            }
            if ('picture' != $matches['elementName']) {
                // If a src attribute is found
                if (\false !== $matches['srcAttribute']) {
                    $sImgName = 'background' == $imgType ? $matches['cssUrlValue'] : $matches['srcValue'];
                    // Abort if this file is excluded
                    if (Helper::findExcludes($this->excludes['url'], $sImgName)) {
                        // If element child of a parent element set excluded flag
                        if ('' != $this->args['parent']) {
                            $this->isExcluded = \true;
                        }
                        $matches['fullMatch'] = $this->removeLoadingAttribute($matches['fullMatch']);

                        return $matches['fullMatch'];
                    }
                    // If no srcset attribute was found, modify the src attribute and add a data-src attribute
                    if (\false === $matches['srcsetAttribute'] && 'embed' == $imgType) {
                        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$matches['widthValue'].'" height="'.$matches['heightValue'].'"></svg>';
                        $sNewSrcValue = 'iframe' == $matches['elementName'] ? 'about:blank' : 'data:image/svg+xml;base64,'.\base64_encode($svg);
                        $sNewSrcAttribute = 'src='.$matches['srcDelimiter'].$sNewSrcValue.$matches['srcDelimiter'].' data-'.$matches['srcAttribute'];
                        $return = \str_replace($matches['srcAttribute'], $sNewSrcAttribute, $return);
                        $isLazyLoaded = \true;
                    }
                }
                // If poster attribute was found we can also exclude using poster value
                if (\false !== $matches['posterAttribute']) {
                    if (Helper::findExcludes($this->excludes['url'], $matches['posterValue'])) {
                        return $matches['fullMatch'];
                    }
                }
                // Modern browsers will lazy-load without loading the src attribute
                if (\false !== $matches['srcsetAttribute'] && \false !== $matches['srcsetValue'] && 'embed' == $imgType) {
                    $sSvgSrcset = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$matches['widthValue'].'" height="'.$matches['heightValue'].'"></svg>';
                    $matches['srcsetDelimiter'] = $matches['srcsetDelimiter'] ?: '"';
                    $sNewSrcsetAttribute = 'srcset='.$matches['srcsetDelimiter'].'data:image/svg+xml;base64,'.\base64_encode($sSvgSrcset).$matches['srcsetDelimiter'].' data-'.$matches['srcsetAttribute'];
                    $return = \str_replace($matches['srcsetAttribute'], $sNewSrcsetAttribute, $return);
                    $isLazyLoaded = \true;
                }
                if (\JCH_PRO && 'audiovideo' == $imgType) {
                    /** @see LazyLoadExtended::lazyLoadAudioVideo() */
                    $return = $this->getContainer()->get(LazyLoadExtended::class)->lazyLoadAudioVideo($matches, $return);
                    $isLazyLoaded = \true;
                }
            }
            // Process and add content of element if not self-closing
            if ('picture' == $matches['elementName'] && \false !== $matches['innerContent']) {
                $args = ['lazyload' => \true, 'deferred' => \true, 'parent' => 'picture'];
                $sInnerContentLazyLoaded = $this->lazyLoadInnerContent($matches, $args);
                // If any child element were lazyloaded this function will return false
                if (\false === $sInnerContentLazyLoaded) {
                    // Remove any lazyloading attributes
                    return $this->removeLoadingAttribute($matches['fullMatch']);
                }

                return \str_replace($matches['innerContent'], $sInnerContentLazyLoaded, $matches['fullMatch']);
            }
            if (\JCH_PRO && 'background' == $imgType && $this->params->get('pro_lazyload_bgimages', '0')) {
                /** @see LazyLoadExtended::lazyLoadBgImages() */
                $return = $this->getContainer()->get(LazyLoadExtended::class)->lazyLoadBgImages($matches, $return);
                $isLazyLoaded = \true;
            }
            if ($isLazyLoaded) {
                // If class attribute not on the appropriate element add it
                if ('source' != $matches['elementName'] && \false === $matches['classAttribute']) {
                    $return = \str_replace('<'.$matches['elementName'], '<'.$matches['elementName'].' class="jch-lazyload"', $return);
                }
                // If class already on element add the lazy-load class
                if ('source' != $matches['elementName'] && \false !== $matches['classAttribute']) {
                    $sNewClassAttribute = 'class='.$matches['classDelimiter'].$matches['classValue'].' jch-lazyload'.$matches['classDelimiter'];
                    $return = \str_replace($matches['classAttribute'], $sNewClassAttribute, $return);
                }
            }
            if ('picture' != $this->args['parent'] && $isLazyLoaded) {
                // Wrap and add img elements in noscript
                if ('img' == $matches['elementName'] || 'iframe' == $matches['elementName']) {
                    $return .= '<noscript>'.$matches['fullMatch'].'</noscript>';
                }
            }

            return $return;
        }
        if ($matches['srcValue'] instanceof UriInterface && ('img' == $matches['elementName'] || 'input' == $matches['elementName'])) {
            $this->http2Preload->add($matches['srcValue'], 'image', $this->args['deferred']);
        }
        if ('background' == $imgType && $matches['cssUrlValue'] instanceof UriInterface) {
            $this->http2Preload->add($matches['cssUrlValue'], 'image', $this->args['deferred']);
        }
        // If lazy-load enabled, remove loading="lazy" attributes from above the fold
        if ($this->params->get('lazyload_enable', '0') && !$this->args['deferred'] && 'img' == $matches['elementName']) {
            // Remove any lazy loading
            $matches['fullMatch'] = $this->removeLoadingAttribute($matches['fullMatch']);
        }
        // We may need to convert images to WEBP in picture elements
        if ('picture' == $matches['elementName'] && \false !== $matches['innerContent']) {
            $args = ['lazyload' => \false, 'deferred' => $this->args['deferred'], 'parent' => 'picture'];
            $innerContentWebp = $this->lazyLoadInnerContent($matches, $args);
            if (\false !== $innerContentWebp) {
                $matches['fullMatch'] = \str_replace($matches['innerContent'], $innerContentWebp, $matches['fullMatch']);
            }
        }

        return $matches['fullMatch'];
    }

    public function setLazyLoadArgs(array $args): void
    {
        $this->args = $args;
    }

    protected function getLazyLoadExcludes(): void
    {
        $aExcludesFiles = Helper::getArray($this->params->get('excludeLazyLoad', []));
        $aExcludesFolders = Helper::getArray($this->params->get('pro_excludeLazyLoadFolders', []));
        $aExcludesUrl = \array_merge(['data:image'], $aExcludesFiles, $aExcludesFolders);
        $aExcludeClass = Helper::getArray($this->params->get('pro_excludeLazyLoadClass', []));
        $this->excludes = ['url' => $aExcludesUrl, 'class' => $aExcludeClass];
    }

    /**
     * @psalm-return array<mixed|string>|false|null|string
     *
     * @param mixed $matches
     *
     * @return null|(mixed|string)[]|false|string
     *
     * @throws PregErrorException
     */
    protected function lazyLoadInnerContent($matches, array $args)
    {
        // Let's first get the width and height from the img element, we'll need it to provide proper aspect
        // ratio to any source elements
        try {
            $parser = new Parser();
            $element = new ElementObject();
            $element->bSelfClosing = \true;
            $element->setNamesArray(['img']);
            $element->setCaptureAttributesArray(['(?:data-)?width', '(?:data-)?height']);
            $parser->addElementObject($element);
            $dimensions = $parser->findMatches($matches['innerContent']);
            $width = $dimensions[4][0];
            $height = $dimensions[7][0];
            if ($width > 1) {
                $this->width = $width;
            }
            if ($height > 1) {
                $this->height = $height;
            }
        } catch (PregErrorException $e) {
        }
        $oParser = new Parser();
        $oImgElement = new ElementObject();
        $oImgElement->bSelfClosing = \true;
        $oImgElement->setNamesArray(['img', 'source']);
        // language=RegExp
        $oImgElement->addNegAttrCriteriaRegex('(?:data-(?:src|original))');
        $oImgElement->setCaptureAttributesArray(['class', 'src', 'srcset', '(?:data-)?width', '(?:data-)?height']);
        $oParser->addElementObject($oImgElement);

        /** @var LazyLoad $lazyLoadCallback */
        $lazyLoadCallback = $this->getContainer()->get(\JchOptimize\Core\Html\Callbacks\LazyLoad::class);
        $lazyLoadCallback->setLazyLoadArgs($args);
        $lazyLoadCallback->width = $this->width;
        $lazyLoadCallback->height = $this->height;
        $result = $oParser->processMatchesWithCallback($matches['innerContent'], $lazyLoadCallback);
        // if any child element were excluded return false
        if ($lazyLoadCallback->isExcluded) {
            return \false;
        }

        return $result;
    }

    protected function removeLoadingAttribute(string $htmlElement): ?string
    {
        return \preg_replace('#loading\\s*+=\\s*+["\']?lazy["\']?#i', '', $htmlElement);
    }
}
