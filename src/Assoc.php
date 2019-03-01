<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/3/1
 * Time: 9:47 AM
 */

namespace Tien\ThinkTools;


use Tien\ThinkTools\exceptions\Exception;

trait Assoc
{

    /**
     * :关联数组合并成一个数组，如下：格式
     * $data = ['key1' => 'value1', 'key2' => 'value2', 'assoc' => ['key3' => 'value3']]
     *
     * @param array $data
     * @param $key string 'assoc'
     * @return array  ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3']
     * @throws Exception
     */
    public function merge(array $data, $key)
    {
        $value = $this->getDataByKey($data, $key);

        return array_merge($data, $value);
    }



    public function column(array $data, $key, $index = 'key',  $column= 'value')
    {
        //取出 key 在 data 中的值
        $value = $this->getDataByKey($data, $key);

        $column = array_column($value, $column, $index);

        return array_merge($data, $column);
    }


    /**
     * :
     *
     * @param array &$data
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function getDataByKey(array &$data, $key)
    {
        if (!isset($data[$key])) {
            throw new Exception('$key 不存在数组 $data 中');
        }

        //取出 key 在 data 中的值
        return ArrayTool::getValueUnset($data, [$key])[$key];
    }




}