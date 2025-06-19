# FleXTML
FleXTML is a dual-format UI structure that bridges JSON and XHTML. It provides a unified way to describe, render, and transmit UI components as both structured data and HTML fragments — ideal for APIs, HTMX responses, and server-rendered PHP components. FleXTML makes declarative rendering portable, introspectable, and framework-agnostic.

---

## 🚀 Features

- Define UI using a flexible JSON structure (`FleXTML JSON`)
- Render XHTML fragments from JSON for HTMX or SSR
- Emit structured JSON from DOM-like PHP/JS components
- Seamlessly integrates into APIs, HTMX responses, and component systems
- Portable across PHP and JavaScript environments

---

## 🧩 Format Example

```json
{
  "tag": "div",
  "attrs": {
    "class": "user-card",
    "data-user-id": "42"
  },
  "children": [
    { "tag": "h2", "content": "Alice" },
    { "tag": "p", "content": "Loves programming." }
  ]
}
```

---

## 🔧 PHP Usage (WIP)

```php
use Flextml\FlextmlElement;

$element = new FlextmlElement('div', ['class' => 'user-card'], [
    new FlextmlElement('h2', [], 'Alice'),
    new FlextmlElement('p', [], 'Loves programming.')
]);

echo $element->toXhtml(); // or ->toJson()
```

---

## 🌐 JavaScript Usage (Planned)

```js
import { renderFlextml } from 'flextml-js';

const json = {
  tag: 'div',
  attrs: { class: 'user-card' },
  children: [
    { tag: 'h2', content: 'Alice' },
    { tag: 'p', content: 'Loves programming.' }
  ]
};

const domElement = renderFlextml(json);
document.body.appendChild(domElement);
```

---

## 📦 Project Goals

- Create a shared XHTML/JSON schema for portable UI fragments
- Build renderers in PHP and JavaScript
- Support round-trip conversion (JSON ↔ HTML ↔ JSON)
- Integrate smoothly with HTMX and REST APIs

---

## 🛠️ Status

**Core features complete.** FleXTML now supports dual-format UI representation, round-trip conversion, HTMX responses, and JSON↔XML transformation in both PHP and JavaScript.

What’s implemented:
- ✅ JSON-to-XHTML rendering
- ✅ XHTML/HTML-to-JSON parsing
- ✅ HTMX-compatible PHP responses
- ✅ JS DOM hydration and patching
- ✅ Round-trip test coverage

What’s skipped for now:
- ❌ Laravel integration

What’s complete (continued):
- ✅ REST endpoint scaffolding

Contributions, ideas, and discussion welcome!
