<?php

namespace Flextml\Utils;

use Flextml\Core\Element;
use DOMDocument;
use DOMNode;

class HtmlParser
{
    /**
     * Converts a string of HTML into a Flextml\Core\Element structure.
     *
     * @param string $html
     * @return Element|null
     */
    public static function fromHtml(string $html): ?Element
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $loaded = $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        if (!$loaded) {
            return null;
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body || !$body->firstChild) {
            return null;
        }

        return self::convertDomNode($body->firstChild);
    }

    /**
     * Recursively converts a DOMNode into a FleXTML Element.
     *
     * @param DOMNode $node
     * @return Element
     */
    protected static function convertDomNode(DOMNode $node): Element
    {
        $tag = $node->nodeName;
        $attrs = [];

        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $attrs[$attr->nodeName] = $attr->nodeValue;
            }
        }

        $children = [];
        $content = '';

        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                $content .= $child->nodeValue;
            } elseif ($child->nodeType === XML_ELEMENT_NODE) {
                $children[] = self::convertDomNode($child);
            }
        }

        return new Element($tag, $attrs, !empty($children) ? $children : trim($content));
    }
}