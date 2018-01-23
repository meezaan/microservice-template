<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

$container = $app->getContainer();

$container['helper'] = function($c) {
    $helper = new \stdClass();
    $helper->logger = new Logger('MicroService');
    $helper->logger->pushHandler(new StreamHandler(realpath(realpath(__DIR__) . '/../logs') . '/microservice.log', Logger::WARNING));

    return $helper;
};

$container['doctrine'] = function($c) {
    $doctrine = new \stdClass();
    $paths = array(realpath(__DIR__) . '/../src');
    $config = Yaml::parse(file_get_contents(realpath(__DIR__) . '/config.php'));
    $isDevMode = $config['connections']['database']['doctrine']['mode'] == 'dev' ? true : false;
    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
    $params = [
        'driver' => $config['connections']['database']['doctrine']['driver'],
        'user' => $config['connections']['database']['doctrine']['username'],
        'password' => $config['connections']['database']['doctrine']['password'],
        'dbname' => $config['connections']['database']['doctrine']['dbname'],
        'host' => $config['connections']['database']['doctrine']['host'],
        'port' => $config['connections']['database']['doctrine']['port']
    ];

    $doctrine->entityManager = EntityManager::create($params, $config);

    return $doctrine;

};

$container['config'] = function($c) {
    return Yaml::parse(file_get_contents(realpath(__DIR__) . '/config.php'));
}

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

$container['errorHandler'] = function ($c) {
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
};
