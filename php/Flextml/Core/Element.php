<?php

namespace Flextml\Core;

class Element
{
    public string $tag;
    public array $attrs = [];
    public string $content = '';
    public array $children = [];

    public function __construct(string $tag, array $attrs = [], $contentOrChildren = [])
    {
        $this->tag = $tag;
        $this->attrs = $attrs;

        if (is_string($contentOrChildren)) {
            $this->content = $contentOrChildren;
        } elseif (is_array($contentOrChildren)) {
            $this->children = $contentOrChildren;
        }
    }

    public function toArray(): array
    {
        $output = [
            'tag' => $this->tag,
            'attrs' => $this->attrs,
        ];

        if ($this->content !== '') {
            $output['content'] = $this->content;
        }

        if (!empty($this->children)) {
            $output['children'] = array_map(function ($child) {
                return $child instanceof Element ? $child->toArray() : $child;
            }, $this->children);
        }

        return $output;
    }

    public static function fromArray(array $data): self
    {
        $element = new self(
            $data['tag'] ?? 'div',
            $data['attrs'] ?? [],
            $data['children'] ?? []
        );

        if (isset($data['content'])) {
            $element->content = $data['content'];
        }

        return $element;
    }

    public function toXhtml(): string
    {
        $attrs = '';
        foreach ($this->attrs as $key => $value) {
            $attrs .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }

        $content = htmlspecialchars($this->content);

        foreach ($this->children as $child) {
            if ($child instanceof self) {
                $content .= $child->toXhtml();
            } else {
                $content .= htmlspecialchars((string)$child);
            }
        }

        return "<{$this->tag}{$attrs}>{$content}</{$this->tag}>";
    }
}
