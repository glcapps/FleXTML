import { renderFlextml } from '../index.js';
import { toFlextmlJson } from '../utils/toFlextmlJson.js';

describe('FleXTML round-trip tests', () => {
  test('basic JSON -> DOM -> JSON round trip', () => {
    const input = {
      tag: 'div',
      attrs: { class: 'card', id: 'card1' },
      children: [
        { tag: 'h1', content: 'Hello' },
        { tag: 'p', content: 'This is a paragraph.' }
      ]
    };

    const dom = renderFlextml(input);
    const roundTrip = toFlextmlJson(dom);

    expect(roundTrip).toEqual(input);
  });

  test('void element: img', () => {
    const input = {
      tag: 'img',
      attrs: { src: 'logo.png', alt: 'Logo' }
    };

    const dom = renderFlextml(input);
    const roundTrip = toFlextmlJson(dom);

    expect(roundTrip).toEqual(input);
  });

  test('content-only span', () => {
    const input = {
      tag: 'span',
      content: 'Just text content'
    };

    const dom = renderFlextml(input);
    const roundTrip = toFlextmlJson(dom);

    expect(roundTrip).toEqual(input);
  });

  test('deeply nested structure', () => {
    const input = {
      tag: 'ul',
      children: [
        {
          tag: 'li',
          children: [
            {
              tag: 'span',
              content: 'Item 1'
            }
          ]
        },
        {
          tag: 'li',
          children: [
            {
              tag: 'span',
              content: 'Item 2'
            }
          ]
        }
      ]
    };

    const dom = renderFlextml(input);
    const roundTrip = toFlextmlJson(dom);

    expect(roundTrip).toEqual(input);
  });
});
