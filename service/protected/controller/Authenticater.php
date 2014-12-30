<?php


namespace controller;


use exception\InvalidUserException;

class Authenticater {

    /**
     * 判断是否是一个可用（可以注册）的用户
     * @param $user
     * @return bool
     */
    public static function isAvailableUser($user){
        if (!self::isValidFormat($user)){
            return false;
        }
        $result = \DB::queryScalar('SELECT COUNT(0) AS count FROM user WHERE is_del = 0 AND name = :name',
                                    array(':name' => $user));
        return !!$result;
    }

    public static function register($user, $passwordHash){
        if (!self::isValidFormat($user)){
            throw new InvalidUserException($user);
        }

    }

    /**
     * 判断是否是一个有效的格式
     * @param $user
     * @return int
     */
    private static function isValidFormat($user){
        return preg_match("/[^0-9a-z_]/i", $user);
    }
} 