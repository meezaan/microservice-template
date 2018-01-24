<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Meezaan\MicroServiceHelper\Response as ApiResponse;

$app->get('/v1/books', function (Request $request, Response $response) {
    $this->helper->logger->info('v1/books');
    // get books here
    $books = '';
    return $response->withJson(ApiResponse::build($books, 200, 'OK'), 200);

});

$app->get('/v1/books/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $this->helper->logger->info('v1/books/' . $id);

    if ($id == null) {
        return $response->withJson(ApiResponse::build('Please specify a name', 400), 400);
    }

    // get book here
    $book = '';
    return $response->withJson(ApiResponse::build($books, 200), 200);

});


$app->post('/v1/books', function (Request $request, Response $response) {
    $json = (string)$request->getBody();    
    $object = json_decode($json);
    print_r($object);exit;

});
