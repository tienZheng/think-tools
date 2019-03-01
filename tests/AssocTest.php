<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/3/1
 * Time: 10:10 AM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\Assoc;
use Tien\ThinkTools\exceptions\Exception;

class AssocTest extends TestCase
{


    public function getAssocObj()
    {
        return $this->getObjectForTrait(Assoc::class);
    }


    public function testMerge()
    {
        $assocObj = $this->getAssocObj();
        $data = ['key1' => 'value1', 'key2' => 'value2', 'assoc' => ['key3' => 'value3']];
        $key  = 'assoc';

        $except = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'];

        $actual = $assocObj->merge($data, $key);
        $this->assertSame($except, $actual);
    }


    public function testThrow()
    {
        $getAssocObj = $this->getAssocObj();
        $data = ['key1' => 'value1', 'key2' => 'value2', 'assoc' => ['key3' => 'value3']];
        $key  = 'assoc_2';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('$key 不存在数组 $data 中');
        $getAssocObj->getDataByKey($data, $key);
    }

    public function testColumn()
    {
        $assocObj = $this->getAssocObj();
        $data = ['key1' => 'value1', 'key2' => 'value2', 'assoc' => [['key' => 'key3', 'value' => 'value3'], ['key' => 'key5', 'value' => 'value5']]];
        $key  = 'assoc';

        $except = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3', 'key5' => 'value5'];
        $actual = $assocObj->column($data, $key);
        $this->assertEquals($except, $actual);
    }


    public function testColumnWithIndex()
    {
        $assocObj = $this->getAssocObj();
        $data = ['key1' => 'value1', 'key2' => 'value2', 'assoc' => [['key1' => 'key3', 'value' => 'value3'], ['key1' => 'key5', 'value' => 'value5']]];
        $key  = 'assoc';

        $except = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3', 'key5' => 'value5'];
        $actual = $assocObj->column($data, $key, 'key1');
        $this->assertEquals($except, $actual);
    }

    public function testColumnWithIndexColumn()
    {
        $assocObj = $this->getAssocObj();
        $data = ['key1' => 'value1', 'key2' => 'value2', 'assoc' => [['key1' => 'key3', 'value1' => 'value3'], ['key1' => 'key5', 'value1' => 'value5']]];
        $key  = 'assoc';

        $except = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3', 'key5' => 'value5'];
        $actual = $assocObj->column($data, $key, 'key1', 'value1');
        $this->assertEquals($except, $actual);
    }

}