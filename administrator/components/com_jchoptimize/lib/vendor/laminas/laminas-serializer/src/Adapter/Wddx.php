<?php

/**
 * @see https://github.com/laminas/laminas-serializer for the canonical source repository
 */
declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Serializer\Adapter;

use _JchOptimizeVendor\Laminas\Serializer\Exception;
use _JchOptimizeVendor\Laminas\Stdlib\ErrorHandler;

/**
 * @see       http://www.infoloom.com/gcaconfs/WEB/chicago98/simeonov.HTM
 * @see       http://en.wikipedia.org/wiki/WDDX
 */
class Wddx extends AbstractAdapter
{
    /** @var WddxOptions */
    protected $options;

    /**
     * Constructor.
     *
     * @param array|\Traversable|WddxOptions $options
     *
     * @throws Exception\ExtensionNotLoadedException if wddx extension not found
     */
    public function __construct($options = null)
    {
        if (!\extension_loaded('wddx')) {
            throw new Exception\ExtensionNotLoadedException('PHP extension "wddx" is required for this adapter');
        }
        parent::__construct($options);
    }

    /**
     * Set options.
     *
     * @param array|\Traversable|WddxOptions $options
     *
     * @return Wddx
     */
    public function setOptions($options)
    {
        if (!$options instanceof WddxOptions) {
            $options = new WddxOptions($options);
        }
        $this->options = $options;

        return $this;
    }

    /**
     * Get options.
     *
     * @return WddxOptions
     */
    public function getOptions()
    {
        if (null === $this->options) {
            $this->options = new WddxOptions();
        }

        return $this->options;
    }

    /**
     * Serialize PHP to WDDX.
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws Exception\RuntimeException on wddx error
     */
    public function serialize($value)
    {
        $comment = $this->getOptions()->getComment();
        ErrorHandler::start();
        if ('' !== $comment) {
            $wddx = \wddx_serialize_value($value, $comment);
        } else {
            $wddx = \wddx_serialize_value($value);
        }
        $error = ErrorHandler::stop();
        if (\false === $wddx) {
            throw new Exception\RuntimeException('Serialization failed', 0, $error);
        }

        return $wddx;
    }

    /**
     * Unserialize from WDDX to PHP.
     *
     * @param string $wddx
     *
     * @return mixed
     *
     * @throws Exception\RuntimeException         on wddx error
     * @throws Exception\InvalidArgumentException if invalid xml
     */
    public function unserialize($wddx)
    {
        $ret = \wddx_deserialize($wddx);
        if (null === $ret && \class_exists('SimpleXMLElement', \false)) {
            // check if the returned NULL is valid
            // or based on an invalid wddx string
            try {
                if (\PHP_VERSION_ID < 80000) {
                    // phpcs:ignore
                    $oldLibxmlDisableEntityLoader = \libxml_disable_entity_loader(\true);
                }
                $dom = new \DOMDocument();
                $dom->loadXML($wddx);
                foreach ($dom->childNodes as $child) {
                    if (\XML_DOCUMENT_TYPE_NODE === $child->nodeType) {
                        throw new Exception\InvalidArgumentException('Invalid XML: Detected use of illegal DOCTYPE');
                    }
                }
                $simpleXml = \simplexml_import_dom($dom);
                // $simpleXml = new \SimpleXMLElement($wddx);
                if (\PHP_VERSION_ID < 80000) {
                    // phpcs:ignore
                    \libxml_disable_entity_loader($oldLibxmlDisableEntityLoader);
                }
                if (isset($simpleXml->data[0]->null[0])) {
                    return;
                    // valid null
                }

                throw new Exception\RuntimeException('Unserialization failed: Invalid wddx packet');
            } catch (\Exception $e) {
                throw new Exception\RuntimeException('Unserialization failed: '.$e->getMessage(), 0, $e);
            }
        }

        return $ret;
    }
}
