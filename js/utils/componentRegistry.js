const componentRegistry = new Map();

/**
 * Registers a custom render hook for a specific FleXTML tag.
 * @param {string} tag - The tag name to register.
 * @param {(json: object) => HTMLElement} renderFn - The custom render function.
 */
export function registerComponent(tag, renderFn) {
  componentRegistry.set(tag.toLowerCase(), renderFn);
}

/**
 * Retrieves the custom render function for a given tag, if any.
 * @param {string} tag - The tag name to look up.
 * @returns {(json: object) => HTMLElement | undefined}
 */
export function getComponent(tag) {
  return componentRegistry.get(tag.toLowerCase());
}

/**
 * Checks if a custom component is registered for the tag.
 * @param {string} tag
 * @returns {boolean}
 */
export function isComponentRegistered(tag) {
  return componentRegistry.has(tag.toLowerCase());
}