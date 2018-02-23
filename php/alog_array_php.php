<?php


/**
 * 冒泡排序法
 * @param $array
 * @return bool
 */
function bubble_sort($array)
{
    $count = count($array);

    if ($count <= 0) {
        return false;

    }

    for ($i = 0; $i < $count; $i++) {
        for ($j = $count - 1; $j > $i; $j--) {
            if ($array[$j] < $array[$j - 1]) {
                $tmp = $array[$j];
                $array[$j] = $array[$j - 1];
                $array[$j - 1] = $tmp;
            }
        }
    }

    return $array;
}

$before_array = array(2, 4, 23, 1, 54, 23, 56);


echo "冒泡排序法";
PHP_EOL;
echo "排序前";
echo var_dump($before_array);
PHP_EOL;
echo "排序后";
echo var_dump(bubble_sort($before_array));


function quick_sort($array)
{

    $length = count($array);
    if ($length <= 1) {
        return $array;
    }
    $key = $array[0];

    $left_array = array();
    $right_array = array();

    for ($i = 1; $i < $length; $i++) {
        if ($key > $array[$i]) {
            $left_array[] = $array[$i];
        } else {
            $right_array[] = $array[$i];
        }


    }
    $left_array = quick_sort($left_array);
    $right_array = quick_sort($right_array);
    return array_merge($left_array, array($key), $right_array);


}


echo "快速排序法";
PHP_EOL;
echo "排序前";
echo var_dump($before_array);
PHP_EOL;
echo "排序后";
echo var_dump(quick_sort($before_array));

