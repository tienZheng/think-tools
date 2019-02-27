<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 3:10 PM
 */

namespace Tien\ThinkTools;

use Closure;

trait Set
{

    /**
     * :获取一条记录
     *
     * @param $model
     * @param Closure $next
     * @return array
     */
    public function getOne($model, Closure $next = null)
    {
        if (!$model) {
            return [];
        }
        $array = $model->toArray();

        if (!$next) {
            return $array;
        }
        return ArrayTool::formatKey($array, $next);
    }

    /**
     * :获取数据集
     *
     * @param $model
     * @param Closure|null $next
     * @return array
     */
    public function getMore($model, Closure $next = null)
    {
        if ($model->isEmpty()) {
            return [];
        }

        $array = $model->toArray();
        if (!$next) {
            return $array;
        }

        foreach ($array as &$value) {
            $value = ArrayTool::formatKey($value, $next);
        }
    }



}