<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 5:17 PM
 */

namespace Tien\ThinkTools;

use think\Db;
use Tien\ThinkTools\exceptions\Exception;

trait Model
{

    /**
     * :一次删除多条数据
     *
     * @param array $where
     * @return int
     */
    public function deleteMore(array $where)
    {
        $ids = self::where($where)->field('id')->select();
        if ($ids->isEmpty()) {
            return 0;
        }

        return self::where(['id' => array_column($ids->toArray(), 'id')])->delete();
    }

    /**
     * :
     *
     * @param array $value
     * @param array $caseWhere
     * @param array $int
     * @param array $appendWhere
     * @return string
     * @throws Exception
     */
    public function updateMore(array $value, array $caseWhere, array $int = [], array $appendWhere = [])
    {
        $table = $this->getTable();

        //start
        $sql = ' UPDATE `'. $table . '` SET ';

        //数据验证
        //1、caseWhere 只能是一个元素的数组
        if (count($caseWhere) != 1) {
            throw new Exception('caseWhere 只能是一个元素的数组');
        }

        //2、value 每个元素的值的个数必须和 caseWhere 的第一个元素的值个数一致
        $caseValue = current($caseWhere);
        $caseKey   = key($caseWhere);
        $caseCount = count($caseValue);

        $caseInt   = in_array($caseKey, $int) ? true : false;

        $when = [];
        foreach ($value as $key => $item) {
            if (count($item) != $caseCount) {
                throw new Exception('value 每个元素的值的个数必须和 caseWhere 的第一个元素的值个数一致');
            }

            $itemInt = in_array($key, $int);

            $str = " `{$key}` = CASE `{$caseKey}` ";

            foreach ($item as $secKey => $secValue) {
                $str .= ' WHEN ';
                // id
                $str .= $caseInt ? $caseValue[$secKey] : "'{$caseValue[$secKey]}'";
                $str .= ' THEN ';
                $str .= $itemInt ? $secValue : "'{$secValue}'";
            }
            //end
            $str .= ' END ';
            $when[] = $str;
        }

        $sql .= implode(',', $when);

        //where
        $sql .= " WHERE `{$caseKey}` IN (" . implode(',', $caseValue) . ')';

        if (!empty($appendWhere)) {
            $sql .= ' AND ';
            $info = [];
            foreach ($appendWhere as $where) {
                if (!is_array($where) || count($where) != 3) {
                    throw new Exception('追加条件格式错误');
                }
                $info[] = " `{$where[0]}` {$where[1]} '{$where[2]}' ";
            }
            $sql .= implode(' AND ', $info);
        }

        //return $sql;
        Db::execute($sql);
    }




}