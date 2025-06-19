<?php

namespace Flextml\Schema;

class Validator
{
    /**
     * Validates a FleXTML structure.
     *
     * @param array $node
     * @param array &$errors
     * @param string $path
     * @return bool
     */
    public static function validate(array $node, array &$errors = [], string $path = 'root'): bool
    {
        $valid = true;

        if (!isset($node['tag']) || !is_string($node['tag'])) {
            $errors[] = "$path: Missing or invalid 'tag'";
            $valid = false;
        }

        if (isset($node['attrs']) && !is_array($node['attrs'])) {
            $errors[] = "$path: 'attrs' should be an array";
            $valid = false;
        }

        if (isset($node['content']) && isset($node['children'])) {
            $errors[] = "$path: Cannot have both 'content' and 'children'";
            $valid = false;
        }

        if (isset($node['children'])) {
            if (!is_array($node['children'])) {
                $errors[] = "$path: 'children' must be an array";
                $valid = false;
            } else {
                foreach ($node['children'] as $i => $child) {
                    if (!is_array($child)) {
                        $errors[] = "$path.children[$i]: Each child must be a FleXTML array";
                        $valid = false;
                    } else {
                        $valid = self::validate($child, $errors, "$path.children[$i]") && $valid;
                    }
                }
            }
        }

        return $valid;
    }
}
