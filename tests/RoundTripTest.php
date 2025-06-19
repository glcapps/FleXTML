<?php

use PHPUnit\Framework\TestCase;
use Flextml\Core\Element;
use Flextml\Utils\HtmlParser;

class RoundTripTest extends TestCase
{
    public function testJsonToHtmlToJsonPreservesStructure()
    {
        $input = [
            'tag' => 'div',
            'attrs' => ['class' => 'test', 'data-role' => 'card'],
            'children' => [
                ['tag' => 'h1', 'content' => 'Title'],
                ['tag' => 'p', 'content' => 'Paragraph here']
            ]
        ];

        $el = Element::fromArray($input);
        $xhtml = $el->toXhtml();
        $parsed = HtmlParser::fromHtml($xhtml);
        $roundTrip = $parsed->toArray();

        $this->assertEquals($input, $roundTrip);
    }

    public function testVoidElementRoundTrip()
    {
        $input = [
            'tag' => 'img',
            'attrs' => ['src' => 'logo.png', 'alt' => 'Logo']
        ];

        $el = Element::fromArray($input);
        $xhtml = $el->toXhtml();
        $parsed = HtmlParser::fromHtml($xhtml);
        $roundTrip = $parsed->toArray();

        $this->assertEquals($input, $roundTrip);
    }

    public function testContentOnlySpan()
    {
        $input = [
            'tag' => 'span',
            'content' => 'Just text here'
        ];

        $el = Element::fromArray($input);
        $xhtml = $el->toXhtml();
        $parsed = HtmlParser::fromHtml($xhtml);
        $roundTrip = $parsed->toArray();

        $this->assertEquals($input, $roundTrip);
    }

    public function testDeeplyNestedStructure()
    {
        $input = [
            'tag' => 'ul',
            'children' => [
                [
                    'tag' => 'li',
                    'children' => [
                        ['tag' => 'span', 'content' => 'Item 1']
                    ]
                ],
                [
                    'tag' => 'li',
                    'children' => [
                        ['tag' => 'span', 'content' => 'Item 2']
                    ]
                ]
            ]
        ];

        $el = Element::fromArray($input);
        $xhtml = $el->toXhtml();
        $parsed = HtmlParser::fromHtml($xhtml);
        $roundTrip = $parsed->toArray();

        $this->assertEquals($input, $roundTrip);
    }
}
