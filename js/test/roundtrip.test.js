import { xmlToJson } from '../utils/xmlToJson.js';
import { jsonToXml } from '../utils/jsonToXml.js';
import { hydrateFlextml } from '../utils/hydrateFlextml.js';
import { toFlextmlJson } from '../utils/toFlextmlJson.js';

describe('FleXTML roundtrip stability', () => {
  const samples = [
    {
      name: 'nested tags with text',
      html: `<div id="test"><p>Hello <em>World</em>!</p></div>`,
      json: {
        tag: 'div',
        attrs: { id: 'test' },
        children: [
          {
            tag: 'p',
            children: [
              'Hello ',
              { tag: 'em', children: ['World'] },
              '!'
            ]
          }
        ]
      }
    },
    {
      name: 'self-closing element and text',
      html: `<section><img src="a.jpg"/> Photo</section>`,
      json: {
        tag: 'section',
        children: [
          { tag: 'img', attrs: { src: 'a.jpg' } },
          ' Photo'
        ]
      }
    }
  ];

  for (const { name, html, json } of samples) {
    test(`HTML → JSON → HTML roundtrip: ${name}`, () => {
      const div = document.createElement('div');
      div.innerHTML = html;
      const roundtrip = jsonToXml(toFlextmlJson(hydrateFlextml(div.firstChild)));
      expect(roundtrip).toBe(html);
    });

    test(`JSON → XML → JSON roundtrip: ${name}`, () => {
      const roundtrip = xmlToJson(jsonToXml(json));
      expect(roundtrip).toEqual(json);
    });
  }
});
