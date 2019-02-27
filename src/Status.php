<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/26
 * Time: 10:41 AM
 */

namespace Tien\ThinkTools;

use Tien\ThinkTools\exceptions\Exception;
use Tien\ThinkTools\exceptions\TypeStrException;

class Status
{
    /**
     * success
     */
    const SUCCESS                   = '0';

    //请求成功
    const SUCCESS_TWO               = '20001';

    //新建成功
    const CREATE_SUCCESS            = '20101';

    //上传成功
    const UPLOAD_SUCCESS            = '20102';

    //已接收，正在处理
    const RECEIVED_DOING            = '20201';

    //删除成功
    const DELETE_SUCCESS            = '20401';

    //更新成功
    const UPDATE_SUCCESS            = '20402';

    //参数格式错误
    const PARAM_FORMAT_ERROR        = '40001';

    //会话已过期
    const SESSION_EXPIRED           = '40101';

    //非法会话
    const SESSION_ILLEGAL           = '40102';

    //禁止访问
    const NO_ACCESS                 = '40301';

    //权限不够
    const INSUFFICIENT_RANGE        = '40302';

    //请求资源不存在
    const URL_RESOURCE_UN_EXISTED   = '40401';

    //资源标识符不存在
    const ID_RESOURCE_UN_EXISTED    = '40402';

    //非法用户
    const ILLEGAL_USER              = '40403';

    //错误用户名或密码
    const ERROR_USER_OR_PASS        = '40405';

    //客户端请求超时
    const CLIENT_REQUEST_TIMEOUT    = '40801';

    //资源标识符已存在
    const ID_RESOURCE_EXISTED       = '40901';

    //已更新
    const UPDATED                   = '40902';

    //文件过大
    const FILE_IS_TOO_LARGE         = '41301';

    //不是有效的文件格式
    const FILE_FORMAT_NO_VALID      = '41501';

    //不是有效的图片格式
    const IMG_FORMAT_NO_VALID       = '41502';

    //不要频繁操作
    const DO_NOT_FREQUENTLY         = '42901';

    //请求失败
    const REQUEST_FAILED            = '50001';

    //系统繁忙
    const SYSTEM_BUSY               = '50002';

    //未知错误
    const UN_KNOW_ERROR              = '50101';

    //请稍后再试
    const TRY_AGAIN_LATER            = '50102';

    //创建失败
    const CREATE_FAILED             = '50003';

    //更新失败
    const UPDATE_FAILED             = '50004';

    //删除失败
    const DELETE_FAILED             = '50005';

    /**
     * 状态信息
     *
     * @var array
     */
    protected $statusMsg = [

        '0'     => 'success',

        //请求成功
        '20001' => 'success',

        //创建数据成功时
        '20101' => '新建成功',
        '20102' => '上传成功',

        //接受到了来自客户端的请求，但还未开始处理
        '20201' => '已接收，正在处理',

        //表示响应实体不包含任何数据
        '20401' => '删除成功',
        '20402' => '更新成功',

        //明显的客户端错误
        '40001' => '参数格式不符合要求',

        //当前请求需要身份认证
        '40101' => '会话已过期',
        '40102' => '非法会话信息',

        //没有权限访问该请求
        '40301' => '禁止访问',
        '40302' => '权限不够',

        //请求的资源不存在
        '40401' => '访问路由资源不存在',
        '40402' => '资源标识符不存在',
        '40403' => '非法用户名',
        '40405' => '账号或密码错误',

        //客户端请求超时时
        '40801' => '客户端请求超时',

        //请求存在冲突无法处理
        '40901' => '资源标识符已存在',
        '40902' => '已更新',

        //提交的数据大小超过了服务器意愿
        '41301' => '文件过大',

        //不支持客户端请求格式
        '41501' => '不是有效的文件格式',
        '41502' => '不是有效的图片格式',

        //请求次数超过允许范围
        '42901' => '请勿频繁操作',

        //系统错误
        '50001' => '请求失败',
        '50002' => '系统繁忙',

        '50003' => '创建失败',
        '50004' => '更新失败',
        '50005' => '删除失败',

        '50101' => '未知错误',
        '50102' => '系统开了小差，请稍后再试',

    ];


    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $response;


    /**
     * 额外的信息
     *
     * @var string
     */
    protected $injectedInfo = '';

    /**
     * 额外信息的类型
     *
     * @var int
     */
    protected $injectedType = 0;

    /**
     * 当前数据的请求方法
     * @var string
     */
    protected $method = '';


    /**
     * 第一个是状态码的键名
     * 第二个是提示信息
     * 第三个是额外返回的信息
     * @var array
     */
    protected $format = [
        'status', 'msg', 'info'
    ];

    /**
     * 状态码
     *
     * @var int
     */
    protected $code = 200;

    /**
     * 严格模式
     *
     * @var bool
     */
    protected $strict = true;

    /**
     * 转换 success 的返回码，如 20001 变成 0
     *
     * @var bool
     */
    protected $switchSuccess = true;


    public function __construct($response, $method = '')
    {
        $this->response = $response;
        if (!is_string($method)) {
            throw new TypeStrException('$method');
        }
        $this->method   = $method;
    }

    /**
     * :
     *
     * @param $strict
     */
    public function setStrict($strict)
    {
        $this->strict = $strict;
    }

    /**
     * :增加状态信息
     *
     * @param array $msg
     * @param bool $isCover 是否覆盖
     */
    public function addStatusMsg(array $msg, $isCover = false)
    {
        if ($isCover) {
            $this->statusMsg = $msg;
        } else {
            $this->statusMsg = array_merge($this->statusMsg, $msg);
        }
    }


    /**
     * :插入左方的信息
     *
     * @param string $info
     * @throws TypeStrException
     */
    public function injectLeftMsg($info = '')
    {
        if (!is_string($info)) {
            throw new TypeStrException('$info');
        }
        $this->injectedInfo = $info . ',';
        $this->injectedType = -1;
    }

    /**
     * :插入右方的信息
     *
     * @param string $info
     * @throws TypeStrException
     */
    public function injectRightMsg($info = '')
    {
        if (!is_string($info)) {
            throw new TypeStrException('$info');
        }
        $this->injectedInfo = ',' . $info;
        $this->injectedType = 1;
    }

    /**
     * :插入覆盖信息
     *
     * @param string $info
     * @throws TypeStrException
     */
    public function injectCoverMsg($info = '')
    {
        if (!is_string($info)) {
            throw new TypeStrException('$info');
        }
        $this->injectedInfo = $info;
        $this->injectedType = 0;
    }


    /**
     * :设置返回格式
     *
     * @param array $format
     */
    public function setFormat(array $format)
    {
        $this->format = $format;
    }


    /**
     * :
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * :处理
     *
     * @return array
     * @throws Exception
     */
    public function run()
    {
        //获取返回数据的类型
        $type = $this->getResponseType();

        //如果 type 是 json 数据，不操作
        if ('json' === $type) {
            return json_decode($this->response, true);
        }

        //加工信息
        $result = $this->processInfo($type);

        //处理 code
        $this->setUpCode($result);

        //附加 key
        $result = $this->fillKeys($result);

        //处理 status
        return $this->handleSuccessCode($result);
    }

    /**
     * :配置 code
     *
     * @param array $result
     */
    protected function setUpCode(array $result)
    {
        $code = current($result);
        if (0 === $code) {
            $this->code = 200;
        } else {
            $this->code = intval(substr($code, 0, 3));
        }
    }

    /**
     * :处理 success 的返回码
     *
     * @param $result
     * @return mixed
     */
    protected function handleSuccessCode($result)
    {
        if (!$this->switchSuccess) {
            return $result;
        }
        if (strpos(current($result), '2') === 0) {
            $result[key($result)] = 0;
        }
        return $result;
    }

    /**
     * :填充 key
     *
     * @param $result
     * @return array
     * @throws Exception
     */
    protected function fillKeys($result)
    {
        $resultCount = count($result);
        $formatCount = count($this->format);
        if ($resultCount == $formatCount) {
            return array_combine($this->format, $result);
        }
        if ($resultCount > $formatCount) {
            throw new Exception('返回格式要求错误，key 的数量小于值的数量');
        }
        return array_combine(array_slice($this->format, 0, $resultCount), $result);
    }

    /**
     * :
     *
     * @param $switchSuccess
     */
    public function setSwitchSuccess($switchSuccess)
    {
        $this->switchSuccess = $switchSuccess;
    }


    /**
     * :获取返回数据类型
     *
     * @return string
     * @throws Exception
     */
    public function getResponseType()
    {
        $res = $this->response;

        $allowType = [
            'boolean', 'integer', 'string', 'array'
        ];

        $type = gettype($res);

        //判断是否是支持的数据类型
        if (!in_array($type, $allowType)) {
            throw new Exception('返回值是不支持的数据类型:' . $type);
        }

        //判断是否是 json 格式的数据
        if ('string' === $type && !is_null($json = json_decode($res))) {
            if (!is_int($json)) {
                return 'json';
            }
        }

        return $type;
    }


    /**
     * :处理信息
     *
     * @param $type
     * @return array
     * @throws Exception
     */
    protected function processInfo($type)
    {
        $res = $this->response;

        //整形
        if ('integer' === $type ) {
            $res = strval($res);
            $type = 'string';
        }

        //字符串
        if ('string' === $type) {
            $msg = $this->getMsgByStatus($res);
            return [intval($res), $msg];
        }

        //数组
        if ('array' === $type) {
            $status = $this->getArrayStatus();
            $msg    = $this->getMsgByStatus($status);
            return [intval($status), $msg, $res];
        }

        //is true
        if ($res && 'boolean' === $type) {
            $status = $this->getTrueStatus();
        } else {
            //is false
            $status = $this->getFalseStatus();
        }
        $msg    = $this->getMsgByStatus($status);
        return [intval($status), $msg];
     }


    /**
     * :根据状态码获取信息
     *
     * @param $status
     * @return mixed|string
     * @throws Exception
     */
     protected function getMsgByStatus($status)
     {
         $msg =  isset($this->statusMsg[$status]) ? $this->statusMsg[$status] : '';
         if (!$msg) {
             throw new Exception('非法状态码');
         }

         //不存在注入信息
         $injectedInfo = $this->injectedInfo;
         if (!$injectedInfo) {
             return $msg;
         }

         $type = $this->injectedType;
         switch ($type) {
             case -1:
                 $msg = $injectedInfo . $msg;
                 break;
             case 1:
                 $msg .= $injectedInfo;
                 break;
             default:
                 $msg = $injectedInfo;
                 break;
         }
         return $msg;
     }

    /**
     * :获取数组的状态值
     *
     * @return string
     */
     protected function getArrayStatus()
     {
         if (true === $this->strict && 'post' === $this->method) {
             return self::CREATE_SUCCESS;
         }
         return self::SUCCESS_TWO;
     }

    /**
     * :获取 true 的状态值
     *
     * @return string
     */
     protected function getTrueStatus()
     {
         if (true !== $this->strict) {
             return self::SUCCESS_TWO;
         }
         if ('delete' === $this->method) {
             return self::DELETE_SUCCESS;
         }
         return self::UPDATE_SUCCESS;
     }

    /**
     * :获取 false 的状态值
     *
     * @return string
     */
     protected function getFalseStatus()
     {
         if (true !== $this->strict) {
             return self::REQUEST_FAILED;
         }

         //严格请求模式下

         if ('delete' === $this->method) {
             return self::DELETE_FAILED;
         }

         if ('put' === $this->method) {
             return self::UPDATE_FAILED;
         }

         if ('post' === $this->method) {
             return self::CREATE_FAILED;
         }
         return self::REQUEST_FAILED;
     }


}