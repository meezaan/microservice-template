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

        // Goodybag bundle
        $heroGoodybag = new \stdClass();
        $heroGoodybag->sku = 'BD031';

        $bundle = new \stdClass();
        $bundle->hasMinutes = true;
        $bundle->hasTexts = true;
        $bundle->data = 'Always on*';
        $bundle->minutes = 'Unlimited';
        $bundle->texts = 'Unlimited';
        $bundle->name = $heroGoodybag->sku;

        // Phone model (hero) info from db
        $phoneDetails = collect([
            [
                'make' => 'apple',
                'model' => 'apple-iphone-se',
                'title' => 'iPhone SE',
                'color' => 'grey',
                'price' => '8.64',
            ],
            [
                'make' => 'apple',
                'model' => 'apple-iphone-6',
                'title' => 'iPhone 6',
                'color' => 'grey',
                'price' => '13.60',
            ],
            [
                'make' => 'apple',
                'model' => 'apple-iphone-7',
                'title' => 'iPhone 7',
                'color' => 'black',
                'price' => '23.53',
            ],
        ]);

        return $this->view->render($response, 'home/index.twig', [
            'app' => $request->getAttribute('app'),
            'title' => 'SIM Only Deals and Mobile Phones',
            'flags' => new Collection($app->getContainer()['flags']),
            'device' => $device,
            'heroGoodybag' => $heroGoodybag,
            'bundle' => $bundle,
            'phonesPricesSmallPrint' => 'Based on £25 upfront payment and 24 month payment terms.',
            'phoneDetails' => $phoneDetails,
        ]);
    })->setName('homepage');
})->add(new \middleware\MasterLayout($app->getContainer()));
