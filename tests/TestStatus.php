<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/26
 * Time: 5:22 PM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\exceptions\Exception;
use Tien\ThinkTools\Status;

class TestStatus extends TestCase
{

    public function getStatusObj($response, $method = '')
    {
        $status = new Status($response, $method);
        return $status;
    }

    /**
     * :返回的数组
     * get 请求方式
     * 严格模式
     * 转换 success 返回码
     * 默认键值对
     *
     * @throws \Tien\ThinkTools\exceptions\Exception
     */
    public function testRunArrGetStrictSwitchDefault()
    {
        $res    = ['id' => 1];
        $method = 'get';
        $status = $this->getStatusObj($res, $method);
        $result = $status->run();
        $except = [
            'status' => 0,
            'msg'    => 'success',
            'info'   => $res,
        ];
        $this->assertSame($except, $result);

        $this->assertSame(200, $status->getCode());
    }


    public function testRunArrGetStrictSwitchFormat()
    {
        $res    = ['id' => 1];
        $method = 'get';
        $status = $this->getStatusObj($res, $method);
        $format = [
            'code', 'message', 'data',
        ];
        $status->setFormat($format);

        $result = $status->run();
        $except = [
            'code' => 0,
            'message' => 'success',
            'data' => $res,
        ];
        $this->assertSame($except, $result);

        $this->assertSame(200, $status->getCode());
    }


    public function testRunArrGetStrictSwitchFormatThrow()
    {
        $res    = ['id' => 1];
        $method = 'get';
        $status = $this->getStatusObj($res, $method);
        $format = [
            'code', 'message'
        ];
        $status->setFormat($format);

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('返回格式要求错误，key 的数量小于值的数量');

        $status->run();
    }


    public function testRunArrGetStrict()
    {
        $res    = ['id' => 1];
        $method = 'get';
        $status = $this->getStatusObj($res, $method);
        $switch = false;
        $status->setSwitchSuccess($switch);
        $actual = $status->run();
        $except = [
            'status' => 20001,
            'msg'    => 'success',
            'info'   => $res,
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());
    }


    public function testRunArrGet()
    {
        $res    = ['id' => 1];
        $method = 'get';
        $status = $this->getStatusObj($res, $method);
        $strict = false;
        $status->setStrict($strict);

        $actual = $status->run();
        $except = [
            'status' => 0,
            'msg'    => 'success',
            'info'   => $res,
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());

    }



    public function testRunStrGetStrictSwitchDefaultThrow()
    {
        $res    = '';
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('非法状态码');

        $status->run();
    }

    public function testRunStrGetStrictSwitchDefaultSuccess()
    {
        //$res = Status::SUCCESS;
        $res = Status::SUCCESS_TWO;
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => 'success',
        ];
        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());
    }

    public function testRunStrGetStrictSwitchDefaultFail()
    {
        $res = Status::ID_RESOURCE_EXISTED;
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => intval(Status::ID_RESOURCE_EXISTED),
            'msg'    => '资源标识符已存在',
        ];
        $this->assertSame($except, $actual);

        $this->assertSame(409, $status->getCode());

    }

    public function testRunStrGetStrictSwitchDefaultFailWithLeft()
    {
        $res = Status::ID_RESOURCE_EXISTED;
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $status->injectLeftMsg('测试哦');
        $actual = $status->run();

        $except = [
            'status' => intval(Status::ID_RESOURCE_EXISTED),
            'msg'    => '测试哦,资源标识符已存在',
        ];
        $this->assertSame($except, $actual);

        $this->assertSame(409, $status->getCode());
    }

    public function testRunStrGetStrictSwitchDefaultFailWithRight()
    {
        $res = Status::ID_RESOURCE_EXISTED;
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $status->injectRightMsg('测试哦');
        $actual = $status->run();

        $except = [
            'status' => intval(Status::ID_RESOURCE_EXISTED),
            'msg'    => '资源标识符已存在,测试哦',
        ];
        $this->assertSame($except, $actual);

        $this->assertSame(409, $status->getCode());
    }

    public function testRunStrGetStrictSwitchDefaultFailWithCover()
    {
        $res = Status::ID_RESOURCE_EXISTED;
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $status->injectCoverMsg('测试哦');
        $actual = $status->run();

        $except = [
            'status' => intval(Status::ID_RESOURCE_EXISTED),
            'msg'    => '测试哦',
        ];
        $this->assertSame($except, $actual);

        $this->assertSame(409, $status->getCode());
    }

    public function testRunStrGetStrictSwitchDefault()
    {
        $res = Status::ID_RESOURCE_EXISTED;
        $method = 'get';
        $status = $this->getStatusObj($res, $method);

        $format = [
            'code', 'message', 'data'
        ];

        $status->setFormat($format);

        $actual = $status->run();

        $except = [
            'code' => intval(Status::ID_RESOURCE_EXISTED),
            'message' => '资源标识符已存在',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(409, $status->getCode());
    }


    public function testRunStrGetSwitch()
    {
        $res = Status::ID_RESOURCE_EXISTED;
        $method = 'get';

        $status = $this->getStatusObj($res, $method);

        $status->setSwitchSuccess(false);

        $actual = $status->run();

        $except = [
            'status' => intval(Status::ID_RESOURCE_EXISTED),
            'msg' => '资源标识符已存在',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(409, $status->getCode());
    }


    public function testRunArrPostStrictSwitchDefault()
    {
        $res = [];
        $method = 'post';

        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => '新建成功',
            'info'   => [],
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(201, $status->getCode());
    }

    public function testRunArrPostSwitchDefault()
    {
        $res = [];
        $method = 'post';

        $status = $this->getStatusObj($res, $method);
        $status->setStrict(false);
        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => 'success',
            'info'   => [],
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());
    }

    public function testRunTrueStrictSwitchDefault()
    {
        $res = true;
        $method = 'post';

        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => '更新成功',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(204, $status->getCode());
    }

    public function testRunTrueSwitchDefault()
    {
        $res = true;
        $method = 'post';

        $status = $this->getStatusObj($res, $method);
        $status->setStrict(false);
        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => 'success',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());
    }

    public function testRunFalseStrictSwitchDefault()
    {
        $res = false;
        $method = 'post';

        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 50003,
            'msg'    => '创建失败',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(500, $status->getCode());
    }

    public function testRunFalseSwitchDefault()
    {
        $res = false;
        $method = 'post';

        $status = $this->getStatusObj($res, $method);
        $status->setStrict(false);
        $actual = $status->run();

        $except = [
            'status' => 50001,
            'msg'    => '请求失败',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(500, $status->getCode());
    }


    public function testPutRunArrSwitchDefault()
    {
        $res = [];
        $method = 'put';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status'    => 0,
            'msg'       => 'success',
            'info'      => $res,
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());
    }

    public function testPutRunTrueSwitchDefault()
    {
        $res = true;
        $method = 'put';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status'    => 0,
            'msg'       => '更新成功',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(204, $status->getCode());
    }

    public function testPutRunFalseSwitchDefault()
    {
        $res = false;
        $method = 'put';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status'    => 50004,
            'msg'       => '更新失败',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(500, $status->getCode());
    }

    public function testDelRunStrSwitchDefault()
    {
        $res = 'string';
        $method = 'delete';
        $status = $this->getStatusObj($res, $method);

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('非法状态码');

        $status->run();
    }

    public function testDelRunArrSwitchDefault()
    {
        $res = [];
        $method = 'delete';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => 'success',
            'info'   => $res,
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(200, $status->getCode());
    }


    public function testDelRunTrueSwitchDefault()
    {
        $res = true;
        $method = 'delete';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 0,
            'msg'    => '删除成功',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(204, $status->getCode());
    }

    public function testDelRunTrueDefault()
    {
        $res = true;
        $method = 'delete';
        $status = $this->getStatusObj($res, $method);
        $status->setSwitchSuccess(false);
        $actual = $status->run();

        $except = [
            'status' => 20401,
            'msg'    => '删除成功',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(204, $status->getCode());
    }

    public function testDelRunFalseSwitchDefault()
    {
        $res = false;
        $method = 'delete';
        $status = $this->getStatusObj($res, $method);

        $actual = $status->run();

        $except = [
            'status' => 50005,
            'msg'    => '删除失败',
        ];

        $this->assertSame($except, $actual);

        $this->assertSame(500, $status->getCode());
    }


}