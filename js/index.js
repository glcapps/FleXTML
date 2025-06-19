export function renderFlextml(json) {
  if (!json || typeof json !== 'object' || !json.tag) {
    throw new Error('Invalid FleXTML element');
  }

  const el = document.createElement(json.tag);

  if (json.attrs) {
    for (const [key, value] of Object.entries(json.attrs)) {
      el.setAttribute(key, String(value));
    }
  }

  if (json.content) {
    el.textContent = json.content;
  }

  if (Array.isArray(json.children)) {
    for (const child of json.children) {
      el.appendChild(renderFlextml(child));
    }
  }

  return el;
}