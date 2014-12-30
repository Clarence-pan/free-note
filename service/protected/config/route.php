<?php

require APP_ROOT.'/protected/config/db.php';

class HTTP_STATUS{
    const OK = 200;
    const NOT_FOUND = 400;
}

/**
 * 尝试去xx
 * @param $func
 * @return callable
 */
function tryIt($func){
    return function() use ($func) {
        try{
            call_user_func_array($func, func_get_args());
        } catch (Exception $e){
            \App::instance()->log->info($e);
            \App::instance()->response->setStatus(500);
        }
    };
}

return function(\App $app){
    /**
     * REST scheme
     * GET to retrieve and search data
     * POST to add data
     * PUT to update data
     * DELETE to delete data
     */
    $request = $app->request;
    $response = $app->response;

    // session开始
    $app->post('/session', tryIt(function() use ($app, $request, $response){
        $app->returnJson(array('sid' => \controller\Authenticator::createSession()));
    }));

    // session终止 -- 登出
    $app->delete('/session', tryIt(function() use ($app){
        \util\Session::clear();
        $app->returnJson(array());
    }));

    // 注册前校验用户名是否可用
    $app->get('/user/is-available/:user', tryIt(function($user) use ($app, $request, $response){
        if (\controller\Authenticator::isAvailableUser($user)){
            $response->setStatus(HTTP_STATUS::OK);
        }else{
            $response->setStatus(HTTP_STATUS::NOT_FOUND);
        }
    }));

    // 注册
    $app->post('/user/:user', tryIt(function($user) use ($app, $request, $response){
        $passwordHash = $request->params('password_hash');
        $app->returnJson(array('uid' => \controller\Authenticator::register($user, $passwordHash)));
    }));

    // 登录
    $app->post('/user/:user/session', tryIt(function($user) use ($app, $request, $response){
        $passwordHash = $request->params('password_hash');
        $app->returnJson(array('success' => \controller\Authenticator::login($user, $passwordHash)));
    }));


    // 登出
    $app->delete('/user/:user/session', tryIt(function($user) use ($app, $request, $response){
        \util\Session::clear();
        $app->returnJson(array());
    }));

    // 列出所有的文件夹
    $app->get('/user/:user/folder/:parent', tryIt(function($user, $parent) use ($app, $request, $response){
        \controller\Authenticator::ensureAuthenticated($user);
        $app->returnJson(array('success' => \controller\Folder::queryList($parent)));
    }));

};