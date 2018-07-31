<?php
/**
 * Web routes
 *
 * @author Ian.H <ian@giffgaff.co.uk>
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tightenco\Collect\Support\Collection;

$app->group('', function() use ($app) {
    $app->get('/', function(ServerRequestInterface $request, ResponseInterface $response) use ($app) {
        $detectOs = new \Model\DetectOs();
        $device = new \stdClass();
        $device->isApple = $detectOs->is('MacOS');

        $heroGoodybag = new \stdClass();
        $heroGoodybag->sku = 'BD031';

        return $this->view->render($response, 'home/index.twig', [
            'app' => $request->getAttribute('app'),
            'title' => 'SIM Only Deals and Mobile Phones',
            'flags' => new Collection($app->getContainer()['flags']),
            'device' => $device,
            'heroGoodybag' => $heroGoodybag,
        ]);
    })->setName('homepage');
})->add(new \middleware\MasterLayout($app->getContainer()));
