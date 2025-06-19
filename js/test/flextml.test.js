import { toFlextmlJson } from '../utils/toFlextmlJson.js';
import { hydrateFlextml } from '../utils/hydrateFlextml.js';
import { xmlToJson } from '../utils/xmlToJson.js';
import { jsonToXml } from '../utils/jsonToXml.js';

describe('FleXTML core utilities', () => {
  const basicHtml = `<div class="box">Hello <span>World</span></div>`;
  const expectedJson = {
    tag: "div",
    attrs: { class: "box" },
    children: [
      "Hello ",
      {
        tag: "span",
        children: ["World"]
      }
    ]
  };

  test('hydrateFlextml + toFlextmlJson roundtrip', () => {
    const root = document.createElement('div');
    root.innerHTML = basicHtml;
    const result = toFlextmlJson(hydrateFlextml(root.firstChild));
    expect(result).toEqual(expectedJson);
  });

  test('xmlToJson parses XHTML correctly', () => {
    const result = xmlToJson(basicHtml);
    expect(result).toEqual(expectedJson);
  });

  test('jsonToXml renders expected XHTML', () => {
    const result = jsonToXml(expectedJson);
    expect(result).toBe(`<div class="box">Hello <span>World</span></div>`);
  });

  test('xmlToJson(jsonToXml(x)) is stable', () => {
    const xml = jsonToXml(expectedJson);
    const roundtrip = xmlToJson(xml);
    expect(roundtrip).toEqual(expectedJson);
  });
});
