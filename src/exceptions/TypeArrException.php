<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/27
 * Time: 1:46 PM
 */

namespace Tien\ThinkTools\exceptions;


use Throwable;

class TypeArrException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message .= ': 应该是数组';
        parent::__construct($message, $code, $previous);
    }
}