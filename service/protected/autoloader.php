<?php

spl_autoload_register(function($class){
    $baseDir = __DIR__;
    // 命名空间转化为目录分隔符
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $fileMaps = array(
        function ($class){
            return $class.'.php';
        },
        function ($class){
            return $class.'.inc.php';
        }
    );
    foreach ($fileMaps as $map) {
        $file = $baseDir.DIRECTORY_SEPARATOR.$map($class);
        if (is_file($file)){
            require_once($file);
        }
    }
});
