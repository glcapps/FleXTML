/**
 * Hydrates an existing DOM element with updated FleXTML JSON data.
 * It modifies attributes, text content, and children where necessary.
 *
 * @param {HTMLElement} element - The root DOM node to update
 * @param {object} json - The FleXTML JSON representation to apply
 */
export function hydrateFlextml(element, json) {
  if (!json || typeof json !== 'object' || !json.tag || element.tagName.toLowerCase() !== json.tag.toLowerCase()) {
    throw new Error('hydrateFlextml: tag mismatch or invalid input');
  }

  // Update attributes
  const newAttrs = json.attrs || {};
  const oldAttrs = element.attributes;
  const oldAttrNames = new Set();

  // Remove or update existing attributes
  for (const attr of oldAttrs) {
    oldAttrNames.add(attr.name);
    if (!(attr.name in newAttrs)) {
      element.removeAttribute(attr.name);
    } else if (element.getAttribute(attr.name) !== String(newAttrs[attr.name])) {
      element.setAttribute(attr.name, String(newAttrs[attr.name]));
    }
  }

  // Add new attributes
  for (const [key, value] of Object.entries(newAttrs)) {
    if (!oldAttrNames.has(key)) {
      element.setAttribute(key, String(value));
    }
  }

  // Update content if applicable (no children)
  if (json.content && (!json.children || json.children.length === 0)) {
    element.textContent = json.content;
  }

  // Recursively hydrate children
  if (Array.isArray(json.children)) {
    while (element.firstChild) {
      element.removeChild(element.firstChild);
    }
    for (const childJson of json.children) {
      const childEl = document.createElement(childJson.tag);
      hydrateFlextml(childEl, childJson);
      element.appendChild(childEl);
    }
  }
}
