<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 1:00 PM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\ArrayTool;
use Tien\ThinkTools\StringTool;

class TestArrayTool extends TestCase
{

    public function testFormatKey()
    {
        $arr = [
            'userId'    => '1',
            'userName'  => '2',
            'pId'       => '3',
            'createdOn' => '4',
        ];
        $next = function ($key) {
            return StringTool::upperToLower($key);
        };

        $except = [
            'user_id'       => '1',
            'user_name'     => '2',
            'p_id'          => '3',
            'created_on'    => '4',
        ];
        $actual = ArrayTool::formatKey($arr, $next);

        $this->assertSame($except, $actual);
    }


    public function testRemoveKey()
    {
        $arr = [
            'userId'    => '1',
            'userName'  => '2',
            'pId'       => '3',
            'createdOn' => '4',
        ];
        $keys = ['pId', 'createdOn'];

        $except = [
            'userId'    => '1',
            'userName'  => '2',
        ];
        $actual = ArrayTool::removeKey($arr, $keys);

        $this->assertSame($except, $actual);
    }


    public function testGetValueUnset()
    {
        $arr = [
            'userId'    => '1',
            'userName'  => '2',
            'pId'       => '3',
            'createdOn' => '4',
        ];
        $keys = ['pId', 'createdOn'];

        $except_2 = [
            'userId'    => '1',
            'userName'  => '2',
        ];

        $except_1 = [
            'pId'       => '3',
            'createdOn' => '4',
        ];

        $actual = ArrayTool::getValueUnset($arr, $keys);

        $this->assertSame($except_1, $actual);
        $this->assertSame($except_2, $arr);
    }

}