<?php

namespace Flextml\Api\Rest;

use Flextml\Core\Element;

class ResponseFormatter
{
    public static function toJson(Element $element): array
    {
        return $element->toArray();
    }

    public static function toXhtml(Element $element): string
    {
        $renderer = new \Flextml\Renderer\PhpRenderer();
        return $renderer->render($element);
    }
}