<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Meezaan\MicroServiceHelper\Response as ApiResponse;

$app->get('/v1/books', function (Request $request, Response $response) {
    $this->helper->logger->write();;

    // get books here
    $books = '';
    return $response->withJson(ApiResponse::build($books, 200, 'OK'), 200);

});

$app->get('/v1/hello/{id}', function (Request $request, Response $response) {
    $this->helper->logger->write();
    $id = $request->getAttribute('id');

    if ($id == null) {
        return $response->withJson(ApiResponse::build('Please specify a name', 400), 400);
    }

    // get book here
    $book = '';
    return $response->withJson(ApiResponse::build($books, 200), 200);

});
