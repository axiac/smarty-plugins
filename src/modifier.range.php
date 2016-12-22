<?php
/**
 * Smarty plugin that replaces a list of values with a range notation: first-last.
 *
 * The input value can be a string or an array. Other types are not affected by this modifier.
 * Arguments:
 *   * $separator - (default: '-') the string to use as range bounds separator
 *   * $comma     - (default: ',') the string to use to split the values when the input is a string
 *   * $sort      - (default: true) sort the input values before getting the boundaries
 */

/**
 * Smarty modifier plugin
 *
 * @param string|array $input     input string or array
 * @param string       $separator (default: '-') the value to use as separator (e.g. '...')
 * @param string       $comma     (default: ',') the character used to split the input when it is a string
 * @param bool         $sort      (default: 0) should sort the input values before taking its limits
 * @return string
 */
function smarty_modifier_range($input, $separator = '-', $comma = ',', $sort = true)
{
    // If the input is a string (like "1,2,3,4"), convert it to an array
    if (is_string($input)) {
        $input = explode($comma, $input);
    } elseif (! is_array($input)) {
        // If it's neither string, nor array then this modifier has no effect on it
        return $input;
    }

    // A range must have at least two components
    if (count($input) < 2) {
        // It's not a range
        return implode($comma, $input);
    }

    // Sort the values in the list if requested
    if ($sort) {
        sort($input);
    }

    // Use only the first and the last item
    return reset($input).$separator.end($input);
}


// This is the end of file; no closing PHP tag
