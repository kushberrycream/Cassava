<?php

namespace _JchOptimizeVendor\Illuminate\Support;

use _JchOptimizeVendor\Illuminate\Contracts\Support\Arrayable;
use _JchOptimizeVendor\Illuminate\Contracts\Support\Htmlable;
use _JchOptimizeVendor\Illuminate\Contracts\Support\Jsonable;

class Js implements Htmlable
{
    /**
     * Flags that should be used when encoding to JSON.
     *
     * @var int
     */
    protected const REQUIRED_FLAGS = \JSON_HEX_TAG | \JSON_HEX_APOS | \JSON_HEX_AMP | \JSON_HEX_QUOT | \JSON_THROW_ON_ERROR;

    /**
     * The JavaScript string.
     *
     * @var string
     */
    protected $js;

    /**
     * Create a new class instance.
     *
     * @param mixed    $data
     * @param null|int $flags
     * @param int      $depth
     *
     * @throws \JsonException
     */
    public function __construct($data, $flags = 0, $depth = 512)
    {
        $this->js = $this->convertDataToJavaScriptExpression($data, $flags, $depth);
    }

    /**
     * Get the string representation of the data for use in HTML.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * Create a new JavaScript string from the given data.
     *
     * @param mixed $data
     * @param int   $flags
     * @param int   $depth
     *
     * @return static
     *
     * @throws \JsonException
     */
    public static function from($data, $flags = 0, $depth = 512)
    {
        return new static($data, $flags, $depth);
    }

    /**
     * Get the string representation of the data for use in HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->js;
    }

    /**
     * Convert the given data to a JavaScript expression.
     *
     * @param mixed $data
     * @param int   $flags
     * @param int   $depth
     *
     * @return string
     *
     * @throws \JsonException
     */
    protected function convertDataToJavaScriptExpression($data, $flags = 0, $depth = 512)
    {
        if ($data instanceof self) {
            return $data->toHtml();
        }
        $json = $this->jsonEncode($data, $flags, $depth);
        if (\is_string($data)) {
            return "'".\substr($json, 1, -1)."'";
        }

        return $this->convertJsonToJavaScriptExpression($json, $flags);
    }

    /**
     * Encode the given data as JSON.
     *
     * @param mixed $data
     * @param int   $flags
     * @param int   $depth
     *
     * @return string
     *
     * @throws \JsonException
     */
    protected function jsonEncode($data, $flags = 0, $depth = 512)
    {
        if ($data instanceof Jsonable) {
            return $data->toJson($flags | static::REQUIRED_FLAGS);
        }
        if ($data instanceof Arrayable && !$data instanceof \JsonSerializable) {
            $data = $data->toArray();
        }

        return \json_encode($data, $flags | static::REQUIRED_FLAGS, $depth);
    }

    /**
     * Convert the given JSON to a JavaScript expression.
     *
     * @param string $json
     * @param int    $flags
     *
     * @return string
     *
     * @throws \JsonException
     */
    protected function convertJsonToJavaScriptExpression($json, $flags = 0)
    {
        if ('[]' === $json || '{}' === $json) {
            return $json;
        }
        if (Str::startsWith($json, ['"', '{', '['])) {
            return "JSON.parse('".\substr(\json_encode($json, $flags | static::REQUIRED_FLAGS), 1, -1)."')";
        }

        return $json;
    }
}
