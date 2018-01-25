<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Meezaan\MicroServiceHelper\Response as ApiResponse;
use Book\Model\Book;

$app->group('/v1', function() {
    $this->get('/books', function (Request $request, Response $response) {
        $this->helper->logger->info('v1/books');
        // get books here
        $books = '';

        return $response->withJson(ApiResponse::build($books, 200, 'OK'), 200);

    });

    $this->get('/books/{id}', function (Request $request, Response $response) {
        $id = $request->getAttribute('id');
        $this->helper->logger->info('v1/books/' . $id);

        if ($id == 0  || $id == null || $id == '' || !is_numeric($id)) {
            return $response->withJson(ApiResponse::build('Please specify a valid resource', 400), 400);
        }

        $book = new Book($this->doctrine->entityManager);
        $result = $book->get($id);
        if ($result) {
            return $response->withJson(ApiResponse::build($result, 200), 200);
        }

        return $response->withJson(ApiResponse::build('Sorry, this book does not exist', 404), 404);
    
    });


    $this->post('/books', function (Request $request, Response $response) {
        $json = (string)$request->getBody();    
        $postedBodyArray = json_decode($json, true);
        $book = new Book($this->doctrine->entityManager);
        $bookId = $book->post($postedBodyArray);

        if ($bookId) {
            $response = $response->withHeader('Location', '/v1/books/' . $bookId);
            return $response->withJson(ApiResponse::build('/v1/books/' . $bookId, 201), 201);
        }

        return $response->withJson(ApiResponse::build($book->getErrors(), 400), 400);
    });
    
    $this->put('/books/{id}', function (Request $request, Response $response) {
        $id = $request->getAttribute('id');
        if ($id == 0  || $id == null || $id == '' || !is_numeric($id)) {
            return $response->withJson(ApiResponse::build('Please specify a valid resource', 400), 400);
        }

        $json = (string)$request->getBody();    
        $postedBodyArray = json_decode($json, true);
        $book = new Book($this->doctrine->entityManager);
        $bookId = $book->put($postedBodyArray, $id);

        if ($bookId) {
            $response = $response->withHeader('Location', '/v1/books/' . $bookId);
            return $response->withJson(ApiResponse::build('/v1/books/' . $bookId, 200), 200);
        }

        return $response->withJson(ApiResponse::build($book->getErrors(), 400), 400);
    });

});
