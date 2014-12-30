<?php


namespace controller;

use exception\InvalidUserException;
use exception\InvalidUserNameFormatException;

class Authenticator {

    /**
     * 判断是否是一个可用（可以注册）的用户
     * @param $user
     * @return bool
     */
    public static function isAvailableUser($user){
        if (!self::isValidFormat($user)){
            return false;
        }
        return self::isUniqueUser($user);
    }

    /**
     * register an user
     * @param $user
     * @param $passwordHash
     * @throws InvalidUserException
     */
    public static function register($user, $passwordHash){
        if (!self::isValidFormat($user)){
            throw new InvalidUserNameFormatException('Invalid format: '.$user);
        }

        if (!self::isUniqueUser($user)){
            throw new InvalidUserException($user);
        }

        \DB::execute('INSERT INTO user (`name`, `password_hash`) VALUES (?, ?)', array($user, $passwordHash));

        return \DB::getLastInsertID();
    }

    /**
     * @param $user
     * @param $passwordHash
     */
    public static function login($user, $passwordHash){
        $result = \DB::queryScalar('SELECT password_hash, `id` FROM user WHERE `name` = ?', array($user));
        if (!$result){
            throw new \exception\InvalidUserException('User not found: '.$user);
        }
        $dbPasswordHash = $result[0]['password_hash'];
        $uid = $result[0]['id'];
        $theHash = md5($dbPasswordHash.\util\Session::get('salt'));
        if ($theHash != $passwordHash){
            throw new \exception\InvalidUserException('Authentication failed: '.$user);
        }
        \util\Session::set('authenticated', true);
        \util\Session::set('uid', $uid);
    }

    /**
     * @return string session id
     */
    public static function createSession(){
        return session_id();
    }

    /**
     * destroy session
     */
    public static function destroySession(){
        \util\Session::clear();
    }

    /**
     * @throws InvalidUserException
     */
    public static function ensureAuthenticated($user){
        if (! \util\Session::get('authenticated')){
            throw new \exception\InvalidUserException('Not authenticated: '.$user);
        }
        if (\util\Session::get('userName') != $user){
            throw new \exception\InvalidUserException('Not the same user: '.$user);
        }
        if (!\util\Session::get('uid')){
            throw new \exception\InvalidUserException('Uid not found: '.$user);
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

    /**
     * @param $user
     * @return bool
     */
    public static function isUniqueUser($user)
    {
        $result = \DB::queryScalar('SELECT COUNT(0) FROM user WHERE is_del = 0 AND name = ?', array($user));
        return !!$result;
    }
}