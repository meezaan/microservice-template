<?php
require_once 'doctrineBootstrap.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

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
    'port' => ,$config['connections']['database']['doctrine']['port']
];

$entityManager = EntityManager::create($params, $config);

return ConsoleRunner::createHelperSet($entityManager);
