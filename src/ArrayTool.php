<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 10:43 AM
 */

namespace Tien\ThinkTools;

use Closure;

class ArrayTool
{

    /**
     * :格式化数组中的键，若格式化之后出现重复的键，则后面的会覆盖前面的值
     *
     * @param array $arr
     * @param Closure $next
     * @return array
     */
    public static function formatKey(array $arr, Closure $next)
    {
        $newArr = [];
        foreach ($arr as $key => $value) {
            $newArr[$next($key)] = $value;
        }
        return $newArr;
    }

    /**
     * 去除数组中键指定的值,不影响原来的数组
     * @param array $arr    需要操作的数组,一位数组
     * @param array $keys
     * @return array|false
     */
    public static function removeKey(array $arr, array $keys)
    {
        return array_diff_key($arr, array_flip($keys));
    }

    /**
     * :返回某些键的值，但原来的数组的会被 unset
     *
     * @param array $arr
     * @param array $keys
     * @return array
     */
    public static function getValueUnset(array &$arr, array $keys)
    {
        $flipKeys   = array_flip($keys);
        $newArr     = array_intersect_key($arr, $flipKeys);
        $arr        = array_diff_key($arr, $flipKeys);

        return $newArr;
    }



}