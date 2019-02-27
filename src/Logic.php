<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 2:22 PM
 */

namespace Tien\ThinkTools;

use Closure;

trait Logic
{

    /**
     * :获取数组条件
     *
     * @param array $param 初始数组，如上传的参数数组
     * @param array $whereKeys 查询条件 key 组成的数组
     * @param string $compare 条件链接符
     * @param Closure|null $next 作用在查询条件 key 数组的回掉函数
     * @return array
     */
    public function getWhere(array $param, array $whereKeys, Closure $next = null, $compare = '=')
    {
        $where = [];
        foreach ($whereKeys as $key) {
            $newKey = !$next ? $key : $next($key);
            $value  = isset($param[$newKey]) ? $param[$newKey] : null;

            if (is_null($value)) {
                continue;
            }

            $where[] = [$key, $compare, $value];
        }
        return $where;
    }

    /**
     * :获取分页条件
     *
     * @param array $param
     * @param array $pageKeys
     * @return array
     */
    public function getPage(array $param, array $pageKeys = [])
    {
        $page = [];
        if (empty($pageKeys)) {
            $pageKeys = ['page', 'page_size'];
        }
        foreach ($pageKeys as $key) {
            $page[] = isset($param[$key]) ? $param[$key] : 0;
        }
        return $page;
    }


    /**
     * :获取排序条件
     *
     * @param array $param
     * @param Closure|null $next
     * @return array
     */
    public function getOrder(array $param, Closure $next = null)
    {
        $order = [];

        $rule = isset($param['order']) ? $param['order'] : '';
        if (!$rule) {
            return $order;
        }

        $rules = explode('|', $rule);
        foreach ($rules as $rule) {
            $units = explode(',', $rule);
            $key = !$next ? $units[0] : $next($units[0]);

            //默认正序
            $order[$key] = isset($units[1]) ? $units[1] : 'asc';

        }
        return $order;
    }



}