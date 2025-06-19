<?php

namespace Flextml\Renderer;

use Flextml\Core\Element;

class PhpRenderer
{
    /**
     * Render a Flextml\Core\Element to XHTML string.
     *
     * @param Element $element
     * @return string
     */
    public function render(Element $element): string
    {
        $xhtml = '<' . htmlspecialchars($element->tag);

        // Render attributes
        foreach ($element->attrs as $key => $value) {
            $xhtml .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }

        if (empty($element->content) && empty($element->children)) {
            $xhtml .= " />";
            return $xhtml;
        }

        $xhtml .= '>';

        // Render content
        if (!empty($element->content)) {
            $xhtml .= htmlspecialchars($element->content);
        }

        // Render children
        foreach ($element->children as $child) {
            if ($child instanceof Element) {
                $xhtml .= $this->render($child);
            }
        }

        $xhtml .= '</' . htmlspecialchars($element->tag) . '>';
        return $xhtml;
    }
}
