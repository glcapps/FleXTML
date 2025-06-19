<?php

namespace Flextml\Api;

use Flextml\Renderer\JsonRenderer;
use Flextml\Core\Element;

class HtmxResponse
{
    /**
     * Creates a JSON response suitable for HTMX swaps.
     *
     * @param string $targetSelector The CSS selector of the element to update.
     * @param Element|array $replacement Either a FleXTML Element or array structure to insert.
     * @param string $swapType The swap strategy: 'outerHTML', 'innerHTML', etc.
     * @return array JSON-ready associative array.
     */
    public static function replace(string $targetSelector, Element|array $replacement, string $swapType = 'outerHTML'): array
    {
        $data = is_array($replacement)
            ? JsonRenderer::toXhtml($replacement)
            : JsonRenderer::toXhtml($replacement->toArray());

        return [
            'hx-target' => $targetSelector,
            'hx-swap' => $swapType,
            'hx-replace' => $data
        ];
    }

    /**
     * Emits a full JSON response for HTMX with appropriate headers.
     *
     * @param array $payload
     * @return void
     */
    public static function emit(array $payload): void
    {
        header('Content-Type: application/json');
        echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}