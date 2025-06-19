<?php

namespace Flextml\Transform;

class JsonToXml
{
    /**
     * Converts a FleXTML JSON array to an XML string.
     *
     * @param array $node
     * @param bool $pretty
     * @return string
     */
    public static function convert(array $node, bool $pretty = false): string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        if ($pretty) {
            $dom->formatOutput = true;
        }

        $root = self::buildElement($dom, $node);
        $dom->appendChild($root);

        return $dom->saveXML($dom->documentElement);
    }

    /**
     * Recursively builds a DOM element from JSON.
     *
     * @param \DOMDocument $dom
     * @param array $node
     * @return \DOMElement
     */
    private static function buildElement(\DOMDocument $dom, array $node): \DOMElement
    {
        $tag = $node['tag'] ?? 'div';
        $el = $dom->createElement($tag);

        if (!empty($node['attrs'])) {
            foreach ($node['attrs'] as $k => $v) {
                $el->setAttribute($k, $v);
            }
        }

        if (isset($node['content'])) {
            $text = $dom->createTextNode($node['content']);
            $el->appendChild($text);
        } elseif (!empty($node['children'])) {
            foreach ($node['children'] as $child) {
                if (is_array($child)) {
                    $el->appendChild(self::buildElement($dom, $child));
                }
            }
        }

        return $el;
    }
}