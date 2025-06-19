/**
 * Converts a DOM element to a FleXTML-compatible JSON structure.
 * @param {HTMLElement} el
 * @returns {object}
 */
export function toFlextmlJson(el) {
  if (!(el instanceof Element)) {
    throw new Error('Expected an HTML element');
  }

  const json = {
    tag: el.tagName.toLowerCase(),
    attrs: {},
  };

  for (const attr of el.attributes) {
    json.attrs[attr.name] = attr.value;
  }

  const hasElementChildren = Array.from(el.childNodes).some(n => n.nodeType === Node.ELEMENT_NODE);
  const textContent = el.textContent?.trim();

  if (hasElementChildren) {
    json.children = Array.from(el.children).map(toFlextmlJson);
  } else if (textContent) {
    json.content = textContent;
  }

  return json;
}
