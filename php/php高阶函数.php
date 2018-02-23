<?php

/*
 * 匿名函数
 * 闭包
 * 高阶函数
 */

$i = 10;
$func = function ($x) use ($i) {
    return $x * $x * $i;
};
var_dump($func(10));


function b($x, $y, $f)
{
    return $f($x) + $f($y);
}
var_dump(b(2, 4, $func));
