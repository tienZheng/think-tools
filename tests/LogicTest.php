<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 3:50 PM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\Logic;
use Tien\ThinkTools\StringTool;

class LogicTest extends TestCase
{

    public function getLogicObj()
    {
        return  $this->getObjectForTrait(Logic::class);
    }


    public function testGetWhereWithNext()
    {
        $logic = $this->getLogicObj();
        $param = [
            'id'        => 1,
            'userId'    => '123',
            'type'      => '1',
            'status'    => 0,
        ];
        $whereKeys = ['user_id', 'type', 'status'];
        $next = function ($key) {
            return StringTool::lowerToUpper($key);
        };

        $except = [
            ['user_id', '=', '123'],
            ['type', '=', '1'],
            ['status', '=', 0],
        ];
        $actual = $logic->getWhere($param, $whereKeys, $next);

        $this->assertSame($except, $actual);
    }


    public function testGetWhereWithCompare()
    {
        $logic = $this->getLogicObj();
        $param = [
            'id'        => 1,
            'userId'    => '123',
            'type'      => '1',
            'status'    => 0,
        ];
        $whereKeys = ['userId', 'type', 'status'];
        $compare   = '<';

        $except = [
            ['userId', '<', '123'],
            ['type', '<', '1'],
            ['status', '<', 0],
        ];
        $actual = $logic->getWhere($param, $whereKeys, null, $compare);

        $this->assertSame($except, $actual);
    }


    public function testGetPage()
    {
        $logic = $this->getLogicObj();

        $param = [
            'page'      => 1,
            'page_size' => 12,
            'id'        => 1,
        ];
        $except = [
            1, 12
        ];

        $actual = $logic->getPage($param);

        $this->assertSame($except, $actual);
    }

    public function testGetPageWithKeys()
    {
        $logic = $this->getLogicObj();
        $param = [
            'page'      => 1,
            'page_size' => 12,
            'id'        => 1,
            'pageSize'  => 13,
        ];
        $pageKeys = ['page', 'pageSize'];

        $except = [
            1, 13
        ];

        $actual = $logic->getPage($param, $pageKeys);

        $this->assertSame($except, $actual);
    }



    public function testGetPageWithUnExistsKey()
    {
        $logic = $this->getLogicObj();
        $param = [
            'page'      => 1,
            'page_size' => 12,
            'id'        => 1,
            'pageSize'  => 13,
        ];
        $pageKeys = ['page1', 'pageSize1'];

        $except = [
            0, 0
        ];

        $actual = $logic->getPage($param, $pageKeys);

        $this->assertSame($except, $actual);
    }


    public function testGetOrderWithNoRule()
    {
        $logic = $this->getLogicObj();

        $param = ['id' => 1];

        $except = [];

        $actual = $logic->getOrder($param);

        $this->assertSame($except, $actual);
    }


    public function testGetOrderWithWhere()
    {
        $logic = $this->getLogicObj();

        $param = [
            'id' => 1,
            'order' => 'create_time,desc|update_time'
        ];

        $except = [
            'create_time' => 'desc',
            'update_time' => 'asc',
        ];

        $actual = $logic->getOrder($param);

        $this->assertSame($except, $actual);
    }

    public function testGetOrder()
    {
        $logic = $this->getLogicObj();

        $param = [
            'id' => 1,
            'order' => 'create_time|update_time'
        ];

        $except = [
            'create_time' => 'asc',
            'update_time' => 'asc',
        ];

        $actual = $logic->getOrder($param);

        $this->assertSame($except, $actual);

    }


    public function testGetOrderWithNext()
    {
        $logic = $this->getLogicObj();

        $param = [
            'id' => 1,
            'order' => 'create_time|update_time'
        ];

        $next = function ($key) {
            return StringTool::lowerToUpper($key);
        };

        $except = [
            'createTime' => 'asc',
            'updateTime' => 'asc',
        ];

        $actual = $logic->getOrder($param, $next);

        $this->assertSame($except, $actual);
    }


}