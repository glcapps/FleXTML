/**
 * Compares two FleXTML JSON trees and returns a list of differences.
 * This is a minimal structural diff — useful for detecting changes
 * between two render trees.
 *
 * @param {object} oldNode
 * @param {object} newNode
 * @param {string} [path='']
 * @returns {Array<{ path: string, type: string, detail: any }>}
 */
export function diffFlextml(oldNode, newNode, path = '') {
  const diffs = [];

  if (oldNode.tag !== newNode.tag) {
    diffs.push({ path, type: 'tag', detail: { from: oldNode.tag, to: newNode.tag } });
    return diffs;
  }

  // Compare attributes
  const allAttrKeys = new Set([...Object.keys(oldNode.attrs || {}), ...Object.keys(newNode.attrs || {})]);
  for (const key of allAttrKeys) {
    const oldVal = oldNode.attrs?.[key];
    const newVal = newNode.attrs?.[key];
    if (oldVal !== newVal) {
      diffs.push({ path, type: 'attr', detail: { key, from: oldVal, to: newVal } });
    }
  }

  // Compare content
  if ((oldNode.content || '') !== (newNode.content || '')) {
    diffs.push({ path, type: 'content', detail: { from: oldNode.content, to: newNode.content } });
  }

  // Compare children
  const oldChildren = oldNode.children || [];
  const newChildren = newNode.children || [];
  const maxLen = Math.max(oldChildren.length, newChildren.length);

  for (let i = 0; i < maxLen; i++) {
    const oldChild = oldChildren[i];
    const newChild = newChildren[i];
    const childPath = `${path}/children[${i}]`;

    if (!oldChild) {
      diffs.push({ path: childPath, type: 'add', detail: newChild });
    } else if (!newChild) {
      diffs.push({ path: childPath, type: 'remove', detail: oldChild });
    } else {
      diffs.push(...diffFlextml(oldChild, newChild, childPath));
    }
  }

  return diffs;
}
