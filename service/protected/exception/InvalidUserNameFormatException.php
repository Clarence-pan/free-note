<?php
/**
 * Created by PhpStorm.
 * User: clarence
 * Date: 14-12-31
 * Time: 上午1:23
 */

namespace exception;


class InvalidUserNameFormatException extends \Exception{

    public function __construct($user){
        parent::__construct("Invalid user name format: ".$user);
    }
} 