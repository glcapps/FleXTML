export function jsonToXml(node) {
  if (typeof node === 'string') {
    return escapeXml(node);
  }

  const { tag, attrs = {}, children = [] } = node;

  const attrString = Object.entries(attrs)
    .map(([key, val]) => ` ${key}="${escapeXml(val)}"`)
    .join('');

  const childrenXml = children.map(jsonToXml).join('');

  return `<${tag}${attrString}>${childrenXml}</${tag}>`;
}

function escapeXml(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}
