<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 4:58 PM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\Validate;

class ValidateTest extends TestCase
{


    public function getValidateObj()
    {
        return $this->getObjectForTrait(Validate::class);
    }


    public function testOrderWithCount()
    {
        $value = 'create_time,desc,asc';
        $rule  = 'create_time,update_time';

        $object = $this->getValidateObj();

        $actual = $object->order($value, $rule);

        $except = '排序字段规则错误，排序条件错误';

        $this->assertSame($except, $actual);

    }


    public function testOrderWithNotAllow()
    {
        $value = 'create_time,desc|id';
        $rule  = 'create_time,update_time';

        $object = $this->getValidateObj();

        $actual = $object->order($value, $rule);

        $except = '排序字段规则错误，id不在create_time,update_time范围之中';

        $this->assertSame($except, $actual);
    }


    public function testOrderWithErrorWhere()
    {
        $value = 'create_time,desc|update_time,test';
        $rule  = 'create_time,update_time';

        $object = $this->getValidateObj();

        $actual = $object->order($value, $rule);

        $except = '排序字段规则错误，test应是 asc 或 desc';

        $this->assertSame($except, $actual);
    }


    public function testForbidden()
    {
        $object = $this->getValidateObj();

        $data = ['id' => 1];
        $value = 1;
        $rule = 1;
        $name = 'name';
        $actual = $object->forbidden($value, $rule, $data, $name);

        $except = 'name:该字段是禁止存在的';

        $this->assertSame($except, $actual);
    }

}