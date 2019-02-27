<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 4:31 PM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\Request;
use stdClass;

class RequestTest extends TestCase
{

    public function getRequestObj()
    {
        return $this->getObjectForTrait(Request::class);
    }


    public function getRequest()
    {
        return new stdClass();
    }


    public function testGetTienAppendEmpty()
    {
        $request = $this->getRequest();
        $objcet  = $this->getRequestObj();

        $except = [];

        $actual = $objcet->getTienAppend($request);

        $this->assertSame($except, $actual);
    }


    public function testGetGetTienAppend()
    {
        $request = $this->getRequest();
        $object  = $this->getRequestObj();
        $except  = ['test' => [1]];
        $request->tienAppend = $except;

        $actual  = $object->getTienAppend($request);
        $this->assertSame($except, $actual);
    }


    public function testSetAppend()
    {
        $request = $this->getRequest();
        $object  = $this->getRequestObj();
        $except  = ['test' => [1]];
        $except_2  = ['test2' => [1]];
        $request->tienAppend = $except_2;

        $actual  = $object->setAppend($request, $except);

        $this->assertSame(array_merge($except_2, $except), $actual);
    }


    public function getGetAppend()
    {
        $request = $this->getRequest();
        $object  = $this->getRequestObj();
        $except_2  = ['test2' => [1]];
        $request->tienAppend = $except_2;

        $actual  = $object->getAppend($request, 'test2');

        $this->assertSame([1], $actual);

    }





}