<?php

class DB
{
    #######################

    private static  $_instance;

    public static function instance(){
        if (!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function createCommand($sql){
        $ins = self::instance();
        $st = $ins->getPdo()->prepare($sql);
        if (!$st){
            die('Query is not fine: '.$sql);
        }
        return $st;
    }

    public static function execute($sql, $param=null){
        $st = self::createCommand($sql);
        $r = $st->execute($param);
        if (!$r){
            die('Execute query failed: '.$sql);
        }
        return $st;
    }

    public static function queryAll($sql, $param=null){
        return self::execute($sql, $param)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function queryScalar($sql, $param=null){
        $results = self::execute($sql, $param)->fetchAll(PDO::FETCH_ASSOC);
        return array_shift($results[0]);
    }

    public static function getLastInsertID(){
        return self::instance()->getPdo()->lastInsertId();
    }

    #############################
    private $_pdo;

    private function __construct(){
        $this->_pdo = $this->createPdo();
    }

    private function getPdo(){
        return $this->_pdo;
    }

    private function createPdo(){
        //mysql
        $dbUserName = "freenote";
        $dbPassword = "a63b5d79a25c3";
        $dbServer = "127.0.0.1:3306";
        $dbName = "freenote";
        return new PDO(sprintf("mysql:host=%s;dbname=%s", $dbServer, $dbName), $dbUserName, $dbPassword);
    }
}