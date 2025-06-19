<?php

namespace Flextml\Api\Rest;

use Flextml\Core\Element;

class RequestMapper
{
    public static function fromGlobals(): Element
    {
        $input = file_get_contents('php://input');
        $json = json_decode($input, true);

        if (!is_array($json) || !isset($json['tag'])) {
            throw new \InvalidArgumentException("Invalid FleXTML JSON");
        }

        return self::fromArray($json);
    }

    protected static function fromArray(array $data): Element
    {
        $element = new Element($data['tag'] ?? 'div');
        $element->attrs = $data['attrs'] ?? [];
        $element->content = $data['content'] ?? '';
        $element->children = [];

        if (!empty($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $child) {
                if (is_array($child)) {
                    $element->children[] = self::fromArray($child);
                } else {
                    $element->children[] = $child;
                }
            }
        }

        return $element;
    }
}