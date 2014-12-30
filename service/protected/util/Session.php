<?php
/**
 * Created by PhpStorm.
 * User: clarence
 * Date: 14-12-31
 * Time: 上午12:35
 */

namespace util;


class Session {
    public static function get($key){
        return $_SESSION[$key];
    }
    public static function set($key, $value){
        return $_SESSION[$key] = $value;
    }
    public static function clear(){
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

} 