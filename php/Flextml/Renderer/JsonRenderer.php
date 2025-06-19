<?php

namespace Flextml\Renderer;

use Flextml\Core\Element;

class JsonRenderer
{
    /**
     * Render a Flextml\Core\Element to JSON string.
     *
     * @param Element $element
     * @return string
     */
    public function render(Element $element): string
    {
        return json_encode($element->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Render a JSON structure to XHTML string.
     *
     * @param array $json
     * @return string
     */
    public static function toXhtml(array $json): string
    {
        $element = Element::fromArray($json);
        return $element->toXhtml();
    }
}
