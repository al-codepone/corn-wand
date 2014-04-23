<?php

/**
 * @author Ry Ferguson
 * @license MIT
 */

namespace c;

/**
 * Alias for htmlspecialchars()
 *
 * @param string $string string to escape
 *
 * @return string escaped string
 */
function esc($string) {
    return htmlspecialchars($string);
}

/**
 * Convert an array into a string of HTML
 * attributes. The array key is the attribute
 * name and the array value is the attribute
 * value. If the array key is an integer then
 * only the value will show. Empty string values
 * with an integer key are ignored. The attribute
 * value is escaped. The attribute name is not
 * escaped. Attribute values with a name are
 * wrapped in double quotes. The return value
 * always has a leading space if there's at
 * least one attribute.
 *
 * @param array $attrs an array of attributes
 *
 * @return string attributes as a string
 */
function attrs(array $attrs) {
    ob_start();

    foreach($attrs as $i => $v) {
        $v = esc($v);

        if(is_int($i) && $v !== '') {
            print " $v";
        }
        else if(!is_int($i)) {
            print " $i=\"$v\"";
        }
    }

    return ob_get_clean();
}

/**
 * Get any HTML tag with attributes and
 * content inside. If the second argument
 * is an array then it will be used
 * as the tag attributes. Otherwise all
 * arguments besides the first are
 * concatenated together to form the tag
 * content. If there are no content arguments
 * then the tag will self close.
 *
 * @param string $name tag name
 * @param mixed $args,... unlimited optional
 *     arguments for the tag attributes and
 *     content
 *
 * @return string complete tag
 */
function tag($name) {
    $args = func_get_args();
    $attrs = (count($args) > 1 && is_array($args[1]))
        ? attrs($args[1])
        : '';

    $content = null;

    if(count($args) > 1 && !is_array($args[1])) {
        $content = implode(array_slice($args, 1));
    }
    else if(count($args) > 2) {
        $content = implode(array_slice($args, 2));
    }

    return (!is_null($content))
        ? "<$name$attrs>$content</$name>"
        : "<$name$attrs/>";
}

/**
 * Same as c\tag() but the unlimited
 * optional arguments after the name
 * argument are in an array.
 *
 * @param string $name tag name
 * @param array $array the tag
 *     attributes and content
 *
 * @return string complete tag
 */
function unpack_tag($name, array $array) {
    array_unshift($array, $name);
    return call_user_func_array('c\tag', $array);
}

/**
 * Get an <html> tag. Same as c\tag()
 * but with name already set to 'html'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <html> tag
 */
function html() {
    return unpack_tag('html', func_get_args());
}

/**
 * Get a <head> tag. Same as c\tag()
 * but with name already set to 'head'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <head> tag
 */
function head() {
    return unpack_tag('head', func_get_args());
}

/**
 * Get a <title> tag. Same as c\tag()
 * but with name already set to 'title'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <title> tag
 */
function title() {
    return unpack_tag('title', func_get_args());
}

/**
 * Get a <base> tag. Same as c\tag()
 * but with name already set to 'base'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <base> tag
 */
function base() {
    return unpack_tag('base', func_get_args());
}

/**
 * Get a <link> tag. Same as c\tag()
 * but with name already set to 'link'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <link> tag
 */
function link() {
    return unpack_tag('link', func_get_args());
}

/**
 * Get a <meta> tag. Same as c\tag()
 * but with name already set to 'meta'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <meta> tag
 */
function meta() {
    return unpack_tag('meta', func_get_args());
}

/**
 * Get a <body> tag. Same as c\tag()
 * but with name already set to 'body'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <body> tag
 */
function body() {
    return unpack_tag('body', func_get_args());
}

/**
 * Get a <p> tag. Same as c\tag()
 * but with name already set to 'p'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <p> tag
 */
function p() {
    return unpack_tag('p', func_get_args());
}

/**
 * Get a <div> tag. Same as c\tag()
 * but with name already set to 'div'.
 *
 * @param mixed $args,... unlimited optional
 *
 * @return string <div> tag
 */
function div() {
    return unpack_tag('div', func_get_args());
}

function html5() {
    return '<!doctype html>' . unpack_tag('html', func_get_args());
}

function css($url) {
    return link(array(
        'rel' => 'stylesheet',
        'href' => $url));
}
