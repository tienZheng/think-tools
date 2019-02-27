<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/26
 * Time: 11:50 AM
 */

namespace Tien\ThinkTools\exceptions;


use Throwable;

class TypeStrException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message .= ': 应该是字符串';
        parent::__construct($message, $code, $previous);
    }
}