<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 5:32 PM
 */

namespace Tien\ThinkTools\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkTools\exceptions\Exception;
use Tien\ThinkTools\Model;

class ModelTest extends TestCase
{

    public function getModelObj()
    {
        return $this->getObjectForTrait(Model::class);
    }


    public function testUpdateMore()
    {
        $object = $this->getModelObj();

        $caseWhere = ['fbId' => [10501, 10502, 10503]];
        $value = [
            'userName' => ['tien_1', 'tien_2', 'tien_3'],
            'proName'  => ['test_1', 'test_2', 'test_3'],
            'remark'   => array_fill(0, 3, '`remark` + 1'),
        ];
        $int = ['fbId', 'remark'];

        $actual = $object->updateMore($value, $caseWhere, $int);

        $except = " UPDATE `swsfeedback` SET  `userName` = CASE `fbId`  WHEN 10501 THEN 'tien_1' WHEN 10502 THEN 'tien_2' WHEN 10503 THEN 'tien_3' END , `proName` = CASE `fbId`  WHEN 10501 THEN 'test_1' WHEN 10502 THEN 'test_2' WHEN 10503 THEN 'test_3' END , `remark` = CASE `fbId`  WHEN 10501 THEN `remark` + 1 WHEN 10502 THEN `remark` + 1 WHEN 10503 THEN `remark` + 1 END  WHERE `fbId` IN (10501,10502,10503)";
        $this->assertSame($except, $actual);
    }


    public function testUpdateMoreWithWhere()
    {
        $object = $this->getModelObj();

        $caseWhere = ['fbId' => [10501, 10502, 10503]];
        $value = [
            'userName' => ['tien_1', 'tien_2', 'tien_3'],
            'proName'  => ['test_1', 'test_2', 'test_3'],
            'remark'   => array_fill(0, 3, '`remark` + 1'),
        ];
        $int = ['fbId', 'remark'];

        $appendWhere = [['userBirthday', '=', 'test'], ['userMobile', '>', '18909876543']];

        $actual = $object->updateMore($value, $caseWhere, $int, $appendWhere);

        $except = " UPDATE `swsfeedback` SET  `userName` = CASE `fbId`  WHEN 10501 THEN 'tien_1' WHEN 10502 THEN 'tien_2' WHEN 10503 THEN 'tien_3' END , `proName` = CASE `fbId`  WHEN 10501 THEN 'test_1' WHEN 10502 THEN 'test_2' WHEN 10503 THEN 'test_3' END , `remark` = CASE `fbId`  WHEN 10501 THEN `remark` + 1 WHEN 10502 THEN `remark` + 1 WHEN 10503 THEN `remark` + 1 END  WHERE `fbId` IN (10501,10502,10503) AND  `userBirthday` = 'test'  AND  `userMobile` > '18909876543' ";
        $this->assertSame($except, $actual);
    }

    public function testUpdateMoreWithCaseMore()
    {
        $caseWhere = ['fbId' => [10501, 10502, 10503], 'more' => 2];
        $value = [
            'userName' => ['tien_1', 'tien_2', 'tien_3'],
            'proName'  => ['test_1', 'test_2', 'test_3'],
            'remark'   => array_fill(0, 3, '`remark` + 1'),
        ];
        $this->expectException(Exception::class);

        $this->expectExceptionMessage('caseWhere 只能是一个元素的数组');

        $object = $this->getModelObj();
        $object->updateMore($value, $caseWhere);
    }



    public function testUpdateMoreWithValueError()
    {
        $caseWhere = ['fbId' => [10501, 10502, 10503]];
        $value = [
            'userName' => ['tien_1', 'tien_2', 'tien_3'],
            'proName'  => ['test_1', 'test_2'],
            'remark'   => array_fill(0, 3, '`remark` + 1'),
        ];
        $this->expectException(Exception::class);

        $this->expectExceptionMessage('value 每个元素的值的个数必须和 caseWhere 的第一个元素的值个数一致');

        $object = $this->getModelObj();
        $object->updateMore($value, $caseWhere);
    }


    public function testUpdateMoreWithAppendWhere()
    {
        $caseWhere = ['fbId' => [10501, 10502, 10503]];
        $value = [
            'userName' => ['tien_1', 'tien_2', 'tien_3'],
            'proName'  => ['test_1', 'test_2', 'sss'],
            'remark'   => array_fill(0, 3, '`remark` + 1'),
        ];
        $appendWhere = ['userId' => 2];
        $this->expectException(Exception::class);

        $this->expectExceptionMessage('追加条件格式错误');

        $object = $this->getModelObj();
        $object->updateMore($value, $caseWhere, [], $appendWhere);
    }
}