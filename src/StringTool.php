<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 10:43 AM
 */

namespace Tien\ThinkTools;


use Tien\ThinkTools\exceptions\TypeStrException;

class StringTool
{
    /**
     * :验证字符串是否是 json 数据
     *
     * @param $str
     * @return bool
     */
    public static function verifyIsJson($str)
    {
        if (!is_string($str)) {
            return false;
        }
        return !is_null(json_decode($str));
    }



    /**
     * :年及月份
     *
     * @param bool $day 是否添加日
     * @return string
     */
    public static function addYearAndMon($day = false)
    {
        $dateInfo = getdate();
        $month    = (strlen($dateInfo['mon']) == 2) ? $dateInfo['mon'] : '0' . $dateInfo['mon'];
        if (!$day) {
            return $dateInfo['year'] . $month;
        }
        $day = (strlen($dateInfo['mday']) == 2) ? $dateInfo['mday'] : '0' . $dateInfo['mon'];
        return $dateInfo['year'] . $month . $day;
    }

    /**
     * :字符串中，把 '_' + [a-z] 两个字符转换成 [A-Z] 一个大写字母
     *
     * @param $str
     * @param $type
     * @return string
     * @throws TypeStrException
     */
    public static function lowerToUpper($str, $type = '_')
    {
        if (!is_string($str)) {
            throw new TypeStrException('$str');
        }

        $strArr = str_split($str);

        foreach ($strArr as $key => &$value) {
            //如果是'_' 且还存在下一个小写字母
            if ($type === $value && preg_match('/[a-z]/', $strArr[$key + 1])) {
                $value = strtoupper($str[$key + 1]);
                unset($strArr[$key + 1]);
            }
        }
        return implode('', $strArr);
    }

    /**
     * :把大写字母转换成 '_' + 小写字母
     *
     * @param $str
     * @param string $type
     * @return string
     * @throws TypeStrException
     */
    public static function upperToLower($str, $type = '_')
    {
        if (!is_string($str)) {
            throw new TypeStrException('$str');
        }

        $strArr = str_split($str);
        $pattern = '/[A-Z]/';
        foreach ($strArr as &$value) {
            if (preg_match($pattern, $value)) {
                $value = $type . strtolower($value);
            }
        }
        return implode('', $strArr);
    }





}