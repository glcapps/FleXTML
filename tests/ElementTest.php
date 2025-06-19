<?php

use PHPUnit\Framework\TestCase;
use Flextml\Core\Element;

class ElementTest extends TestCase
{
    public function testElementCreationWithContent()
    {
        $el = new Element('p', ['class' => 'note'], 'Hello, world!');
        $this->assertSame('p', $el->tag);
        $this->assertSame(['class' => 'note'], $el->attrs);
        $this->assertSame('Hello, world!', $el->content);
        $this->assertEmpty($el->children);
    }

    public function testElementCreationWithChildren()
    {
        $child = new Element('span', [], 'Child');
        $el = new Element('div', ['id' => 'container'], [$child]);

        $this->assertSame('div', $el->tag);
        $this->assertSame(['id' => 'container'], $el->attrs);
        $this->assertEmpty($el->content);
        $this->assertCount(1, $el->children);
        $this->assertInstanceOf(Element::class, $el->children[0]);
        $this->assertSame('span', $el->children[0]->tag);
    }

    public function testToArray()
    {
        $child = new Element('li', [], 'Item 1');
        $el = new Element('ul', ['class' => 'list'], [$child]);
        $array = $el->toArray();

        $this->assertSame('ul', $array['tag']);
        $this->assertSame(['class' => 'list'], $array['attrs']);
        $this->assertArrayHasKey('children', $array);
        $this->assertSame('li', $array['children'][0]['tag']);
        $this->assertSame('Item 1', $array['children'][0]['content']);
    }

    public function testFromArray()
    {
        $data = [
            'tag' => 'section',
            'attrs' => ['data-role' => 'main'],
            'content' => 'Main content'
        ];

        $el = Element::fromArray($data);
        $this->assertSame('section', $el->tag);
        $this->assertSame(['data-role' => 'main'], $el->attrs);
        $this->assertSame('Main content', $el->content);
    }
}
