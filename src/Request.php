<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 1:37 PM
 */

namespace Tien\ThinkTools;


use Tien\ThinkTools\exceptions\TypeArrException;

trait Request
{
    /**
     * :获取整个追加的值
     *
     * @param $request
     * @return array
     */
    public function getTienAppend($request)
    {
        return isset($request->tienAppend) ? $request->tienAppend : [];
    }


    /**
     * :追加值
     *
     * @param $request
     * @param array $append
     * @return array
     * @throws TypeArrException
     */
    public function setAppend($request, array $append)
    {
        $tienAppend = $this->getTienAppend($request);
        if (!is_array($tienAppend)) {
            throw new TypeArrException('tienAppend');
        }
        return array_merge($tienAppend, $append);
    }

    /**
     * :获取追加的值
     *
     * @param $request
     * @param $name
     * @return array|mixed
     */
    public function getAppend($request, $name)
    {
        if (is_array($request)) {
            $tienAppend = isset($request['tienAppend']) ? $request['tienAppend'] : [];
        } else {
            $tienAppend = $this->getTienAppend($request);
        }
        return isset($tienAppend[$name]) ? $tienAppend[$name] : [];
    }







}