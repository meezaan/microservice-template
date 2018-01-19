<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/hello', function (Request $request, Response $response) {
    $this->helper->logger->write();;

    return $response->withJson(ApiResponse::build('Hello World!', 200, 'OK'), 200);

});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $this->helper->logger->write();
    $name = $request->getAttribute('name');

    if ($names == null) {
        return $response->withJson(ApiResponse::build('Please specify a name', 400, 'Bad Request'), 400);
    }

    return $response->withJson(ApiResponse::build('Hello ' . (string) $name, 200, 'OK'), 200);

});
