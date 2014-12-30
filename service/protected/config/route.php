<?php

require APP_ROOT.'/protected/config/db.php';

class HTTP_STATUS{
    const OK = 200;
    const NOT_FOUND = 400;
}

return function(\Slim\Slim $app){
    /**
     * REST scheme
     * GET to retrieve and search data
     * POST to add data
     * PUT to update data
     * DELETE to delete data
     */
    $request = $app->request;
    $response = $app->response;

    $app->get('/user/is-available/:user', function($user) use ($app, $request, $response){
        if (\controller\Authenticater::isAvailableUser($user)){
            $response->setStatus(HTTP_STATUS::OK);
        }else{
            $response->setStatus(HTTP_STATUS::NOT_FOUND);
        }
    });

};