

# 🧭 FleXTML Roadmap: Next Evolutions

This roadmap outlines potential directions to evolve FleXTML into a powerful, flexible, and interoperable templating and UI framework.

---

## 🔁 2. DOM Diff + Patch Engine

- Implement `domDiff.js` and `patchFlextml.js` to compute changes between virtual FleXTML trees and apply updates to the real DOM.
- Enable minimal re-renders for state-driven UIs.
- Basis for future reactive behavior.

---

## 🌍 3. HTMX Integration & Response Contracts

- Create a standard JSON response schema for PHP endpoints.
- Allow responses like:
  ```json
  {
    "replace": "#some-id",
    "with": { "tag": "div", "content": "New content" }
  }
  ```
- JS interpreter will apply updates to the DOM accordingly.

---

## 📐 4. Schema & Validation Tools

- Support optional schema definitions for valid FleXTML structures.
- Implement a PHP validator (`Validator.php`) and JS equivalent.
- Enable static checks for component props and allowed structures.

---

## 🧠 5. AI/LLM-Facing Enhancements

- Build a Markdown → FleXTML converter.
- Allow LLMs to generate FleXTML JSON with minimal prompt engineering.
- Create helpers to explain or summarize JSON blocks for assistive tools.

---

## 🔄 6. CLI and Playground Tools

- `flextml.php`: a CLI to transform files and test round-trips.
- Web playground with:
  - Live JSON editing
  - XHTML rendering
  - DOM inspection and validation

---

## 🧪 7. Test Case DSL

- Create a JSON-based test case format to capture round-trip examples.
- Used by test runners to assert JSON → XHTML → JSON stability.
- Store in `TestCases.json` for reuse in PHP and JS test suites.

---

## 🧬 8. Inheritance + Macro Support

- Allow structures like:
  ```json
  { "extends": "BaseCard", "attrs": { "title": "Hello" } }
  ```
- Implement macro expansion system for shared templates.
- Optional JS and PHP registry for macros.

---

## ✅ Status Tracking

| Feature | Status |
|--------|--------|
| DOM Diff & Patch | 🔜 |
| HTMX Response Contracts | 🔜 |
| Schema Validation | 🔜 |
| AI/Markdown Integration | 🔜 |
| CLI & Playground | 🔜 |
| Test DSL | 🔜 |
| Macros/Inheritance | 🔜 |