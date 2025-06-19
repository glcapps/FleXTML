<?php

namespace Flextml\Renderer;

use Flextml\Core\Element;

class XmlStreamRenderer
{
    /**
     * Render an array of Elements as a stream of XML.
     *
     * @param Element[] $elements
     * @return string
     */
    public function render(array $elements): string
    {
        $output = '';
        foreach ($elements as $element) {
            $output .= $this->renderElement($element);
        }
        return $output;
    }

    /**
     * Recursively render a single Element to XML.
     *
     * @param Element $element
     * @return string
     */
    protected function renderElement(Element $element): string
    {
        $attrs = '';
        foreach ($element->attrs as $key => $value) {
            $attrs .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }

        $content = htmlspecialchars($element->content);

        foreach ($element->children as $child) {
            if ($child instanceof Element) {
                $content .= $this->renderElement($child);
            } else {
                $content .= htmlspecialchars((string)$child);
            }
        }

        return "<{$element->tag}{$attrs}>{$content}</{$element->tag}>";
    }
}
