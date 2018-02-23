<?php 
//PHP array转object
function arrayToObject($e) {
    if (gettype($e) != 'array')
        return;
    foreach ($e as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object')
            $e[$k] = (object) arrayToObject($v);
    }
    return (object) $e;
}

//PHP stdClass Object转array
function objectToArray($array) {
    if (is_object($array)) {
        $array = (array) $array;
    } if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = objectToArray($value);
        }
    }
    return $array;
}


