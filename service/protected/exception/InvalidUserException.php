<?php


namespace exception;


class InvalidUserException extends \Exception {
    public function __construct($user){
        parent::__construct("Invalid user: ".$user);
    }
} 