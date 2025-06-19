


/**
 * Replaces placeholder tokens in the FleXTML JSON structure
 * with values from a given context object.
 *
 * @param {object} json - The FleXTML JSON element
 * @param {object} context - A flat key-value map for template replacements
 * @returns {object} - A deep copy of the input with injected values
 */
export function injectFlextmlData(json, context = {}) {
  const clone = JSON.parse(JSON.stringify(json)); // deep copy

  function interpolate(str) {
    return str.replace(/\{([^}]+)\}/g, (_, key) => {
      return context[key] != null ? String(context[key]) : `{${key}}`;
    });
  }

  function walk(node) {
    if (node.attrs) {
      for (const [key, value] of Object.entries(node.attrs)) {
        if (typeof value === 'string') {
          node.attrs[key] = interpolate(value);
        }
      }
    }

    if (typeof node.content === 'string') {
      node.content = interpolate(node.content);
    }

    if (Array.isArray(node.children)) {
      node.children.forEach(walk);
    }
  }

  walk(clone);
  return clone;
}