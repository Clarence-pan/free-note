<?php

define('APP_ROOT', __DIR__);
define('EXTERNAL_ROOT', APP_ROOT . '/protected/external');
require_once(APP_ROOT.'/protected/autoloader.php');
require_once(EXTERNAL_ROOT . '/Slim/Slim.php');
\Slim\Slim::registerAutoloader();


class App extends \Slim\Slim
{
    /**
     * return JSON to client
     * @param $obj
     * @return mixed
     */
    public function returnJson($obj){
        return $this->response->setBody(json_encode($obj));
    }
    ############################# static ##########################
    private static $_instance;
    public static function instance(){
        return self::$_instance;
    }
    public static function start(){
        $logFile = fopen(APP_ROOT . '/protected/log/service.log', 'a');
        try {

            session_start();

            $config = array(
                'log.writer' => new \Slim\LogWriter($logFile),
                'log.level' => \Slim\Log::DEBUG,
                'debug' => true,
            );

            $app = self::$_instance = new self($config);

            $app->log->debug('URL: '.$_SESSION['REQUEST_URI']);
            // always return JSON
            $app->contentType("application/json");

            $setupRoute = require(APP_ROOT . '/protected/config/route.php');
            call_user_func($setupRoute, $app);

            $app->run();

            fclose($logFile);
        } catch (Exception $e) {
            fclose($logFile);
            echo "Something is wrong...".PHP_EOL;
            echo "<!--".PHP_EOL;
            var_dump($e);
            echo "-->".PHP_EOL;
        }
    }
}

App::start();
