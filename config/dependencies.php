<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Yaml\Yaml;

$container = $app->getContainer();

$container['config'] = function() {
    $environment = in_array(getenv('PROVISION_CONTEXT'), ['development', 'production', 'staging']) ? getenv('PROVISION_CONTEXT') : 'development';
    return Yaml::parse(file_get_contents(realpath(__DIR__) . '/config.' . $environment . '.yml'));
};

$container['helper'] = function($c) {
    $config = $c->config; 
    $helper = new \stdClass();
    $helper->logger = new Logger('MicroService');
    $helper->logger->pushHandler(new StreamHandler(realpath(realpath(__DIR__) . '/../logs') . '/microservice.log', Logger::WARNING));
$helper->config= $config;
    return $helper;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $r = [
        'code' => 404,
        'status' => 'Not Found',
        'data' => 'Invalid endpoint or resource.'
        ];
        $resp = json_encode($r);

        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write($resp);
    };
};

/*$container['errorHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $r = [
        'code' => 500,
        'status' => 'Internal Server Error',
        'data' => 'Something went wrong when the server tried to process this request. Sorry!'
        ];

        $resp = json_encode($r);

        return $c['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write($resp);
    };
};*/

// Register Twig component on container
$container['view_twig'] = function($container) {
    $view = new \Slim\Views\Twig(realpath(__DIR__) . '/../src/views', [
//        'cache' => '/cache',
        'cache' => false,
    ]);

    $basePath = rtrim(str_ireplace(
        'index.php',
        '',
        $container->get('request')->getUri()->getBasePath()
    ), '/');

    $view->addExtension(new \Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

// Register PHP view component
$container['view_php'] = function($container) {
    return new \Slim\Views\PhpRenderer(realpath(__DIR__) . '/../src/views/');
};

// Use selected template engine
if ('twig' === $container['config']['slim']['settings']['template_engine']) {
    $container['view'] = $container['view_twig'];
} else {
    $container['view'] = $container['view_php'];
}