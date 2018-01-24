<?php
/** PHP Error handling **/
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
/** PHP Error handling Ends **/

/** Autoloader **/
require_once realpath(__DIR__) . '/../vendor/autoload.php';

/** Load Config File **/
$config = Symfony\Component\Yaml\Yaml::parse(file_get_contents(realpath(__DIR__) . '/config.yml'));

/** Settings **/
$settings = [
    'settings' => [
        'displayErrorDetails' => $config['slim']['settings']['display_error_details'], // set to false in production
        'addContentLengthHeader' => $config['slim']['settings']['add_content_length'], // Allow the web server to send the content-length header
    ],
];

// Initiate Slim App
$app = new \Slim\App($settings);
