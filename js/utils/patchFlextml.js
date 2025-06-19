
export function patchFlextml(element, json) {
  if (!element || !json || element.tagName.toLowerCase() !== json.tag) {
    console.warn('Mismatched or missing element/tag in patchFlextml');
    return;
  }

  // Update attributes
  for (const [key, value] of Object.entries(json.attrs || {})) {
    element.setAttribute(key, value);
  }

  // Remove attributes not in json
  for (const attr of Array.from(element.attributes)) {
    if (!json.attrs || !(attr.name in json.attrs)) {
      element.removeAttribute(attr.name);
    }
  }

  // Update children
  const newChildren = json.children || [];
  const existingNodes = Array.from(element.childNodes);

  for (let i = 0; i < newChildren.length; i++) {
    const newChild = newChildren[i];
    const existing = existingNodes[i];

    if (typeof newChild === 'string') {
      if (existing && existing.nodeType === Node.TEXT_NODE) {
        existing.textContent = newChild;
      } else {
        const textNode = document.createTextNode(newChild);
        if (existing) {
          element.replaceChild(textNode, existing);
        } else {
          element.appendChild(textNode);
        }
      }
    } else if (typeof newChild === 'object') {
      if (existing && existing.nodeType === Node.ELEMENT_NODE && existing.tagName.toLowerCase() === newChild.tag) {
        patchFlextml(existing, newChild);
      } else {
        const newEl = document.createElement(newChild.tag);
        patchFlextml(newEl, newChild);
        if (existing) {
          element.replaceChild(newEl, existing);
        } else {
          element.appendChild(newEl);
        }
      }
    }
  }

  // Remove extra children
  while (element.childNodes.length > newChildren.length) {
    element.removeChild(element.lastChild);
  }
}