<?php
/**
 * Created by PhpStorm.
 * User: clarence
 * Date: 14-12-31
 * Time: 上午1:24
 */

namespace exception;


class UnauthenticatedException extends \Exception {

    public function __construct($user){
        parent::__construct("Unauthenticated: ".$user);
    }
} 