<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 1:55 PM
 */

namespace Tien\ThinkTools;



trait Validate
{

    /**
     * :
     *
     * @param $value    time,desc|money,asc
     * @param $rule     time,money
     * @return bool|string
     */
    public function order($value, $rule)
    {
        $valueArr = explode('|', $value);
        $ruleArr  = explode(',', $rule);

        //默认错误
        $error = '排序字段规则错误，';

        foreach ($valueArr as $item) {
            $unit = explode(',', $item);

            if (empty($unit)) {
                continue;
            }

            //如果数量大于 2
            if (count($unit) > 2) {
                return $error . '排序条件错误';
            }

            //若不在允许的排序字段中
            if (!in_array($unit[0], $ruleArr)) {
                return "{$error}{$unit[0]}不在{$rule}范围之中";
            }

            //排序添加 是否在 'desc' 'asc' 中
            if (isset($unit[1]) && !in_array($unit[1], ['desc', 'asc'])) {
                return "{$error}{$unit[1]}应是 asc 或 desc";
            }
        }
        return true;
    }



    /**
     * :禁止某些字段
     *
     * @param string $value
     * @param string $rule
     * @param array $data
     * @param $name
     * @return string
     */
    public function forbidden($value, $rule, array $data, $name)
    {
        return $name. ':该字段是禁止存在的';
    }








}