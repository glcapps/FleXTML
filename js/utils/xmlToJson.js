export function xmlToJson(xmlString) {
  const parser = new DOMParser();
  const doc = parser.parseFromString(xmlString, 'application/xml');

  const root = doc.documentElement;
  return elementToJson(root);
}

function elementToJson(el) {
  const obj = {
    tag: el.tagName.toLowerCase()
  };

  if (el.attributes.length > 0) {
    obj.attrs = {};
    for (const attr of el.attributes) {
      obj.attrs[attr.name] = attr.value;
    }
  }

  const children = [];
  for (const node of el.childNodes) {
    if (node.nodeType === Node.TEXT_NODE) {
      const text = node.nodeValue.trim();
      if (text) children.push(text);
    } else if (node.nodeType === Node.ELEMENT_NODE) {
      children.push(elementToJson(node));
    }
  }

  if (children.length > 0) {
    obj.children = children;
  }

  return obj;
}
