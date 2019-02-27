<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 11:15 AM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\exceptions\TypeStrException;
use Tien\ThinkTools\StringTool;

class StringToolTest extends TestCase
{


    public function testVerifyIsJsonFalse()
    {
        $except = false;

        //array
        $str = [];
        $actual = StringTool::verifyIsJson($str);
        $this->assertSame($except, $actual);

        //int
        $str = 1;
        $actual = StringTool::verifyIsJson($str);
        $this->assertSame($except, $actual);

        //error
        $str = "{'str': 1}";
        $actual = StringTool::verifyIsJson($str);
        $this->assertSame($except, $actual);

    }

    public function testVerifyIsJsonTrue()
    {
        $except = true;
        $str = '{"str": 1}';
        $actual = StringTool::verifyIsJson($str);
        $this->assertSame($except, $actual);
    }


    public function testAddYearAndMon()
    {
        $except = '201902';
        $actual = StringTool::addYearAndMon();

        $this->assertSame($except, $actual);
    }

    public function testAddYearAndMonWithDay()
    {
        $except = '20190227';
        $actual = StringTool::addYearAndMon(true);

        $this->assertSame($except, $actual);
    }


    public function testLowerToUpper()
    {
        $str = 'abc_def_g';
        $except = 'abcDefG';

        $actual = StringTool::lowerToUpper($str);
        $this->assertSame($except, $actual);
    }


    public function testLowerToUpperWithType()
    {
        $str = 'abc_d-ef_g-h';
        $type = '-';
        $except = 'abc_dEf_gH';
        $actual = StringTool::lowerToUpper($str, $type);

        $this->assertSame($except, $actual);
    }

    public function testLowerToUpperWithThrow()
    {
        $str = [];

        $this->expectException(TypeStrException::class);

        $this->expectExceptionMessage('$str: 应该是字符串');

        StringTool::lowerToUpper($str);
    }



    public function testUpperToLower()
    {
        $str = 'ABCdef';
        $except = '_a_b_cdef';

        $actual = StringTool::upperToLower($str);
        $this->assertSame($except, $actual);
    }


    public function testUpperToLowerWithType()
    {
        $type = '-';
        $str = 'ABCdef';
        $except = '-a-b-cdef';
        $actual = StringTool::upperToLower($str, $type);
        $this->assertSame($except, $actual);
    }


    public function testUpperToLowerWithThrow()
    {
        $str = [];
        $this->expectException(TypeStrException::class);

        $this->expectExceptionMessage('$str: 应该是字符串');
        StringTool::upperToLower($str);
    }







}