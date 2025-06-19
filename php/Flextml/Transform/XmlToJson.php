<?php

namespace Flextml\Transform;

class XmlToJson
{
    /**
     * Converts an XML string to FleXTML-style JSON.
     *
     * @param string $xml
     * @return array|null
     */
    public static function convert(string $xml): ?array
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);

        if (!$dom->loadXML($xml)) {
            return null;
        }

        $root = $dom->documentElement;
        return self::parseElement($root);
    }

    /**
     * Recursively converts a DOMElement into FleXTML JSON.
     *
     * @param \DOMElement $element
     * @return array
     */
    private static function parseElement(\DOMElement $element): array
    {
        $node = [
            'tag' => $element->tagName
        ];

        if ($element->hasAttributes()) {
            $node['attrs'] = [];
            foreach ($element->attributes as $attr) {
                $node['attrs'][$attr->nodeName] = $attr->nodeValue;
            }
        }

        $hasChildElements = false;
        $children = [];
        foreach ($element->childNodes as $child) {
            if ($child instanceof \DOMElement) {
                $hasChildElements = true;
                $children[] = self::parseElement($child);
            } elseif ($child instanceof \DOMText) {
                $text = trim($child->wholeText);
                if ($text !== '') {
                    $children[] = $text;
                }
            }
        }

        if ($hasChildElements) {
            $node['children'] = array_map(function ($item) {
                return is_string($item) ? ['tag' => 'text', 'content' => $item] : $item;
            }, $children);
        } elseif (count($children) === 1 && is_string($children[0])) {
            $node['content'] = $children[0];
        }

        return $node;
    }
}