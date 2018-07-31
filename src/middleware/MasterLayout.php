<?php
/**
 * Master layout middleware
 *
 * @author Ian.H <ian@giffgaff.co.uk>
 */

namespace Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tightenco\Collect\Support\Collection;

class MasterLayout
{
    /** @var ContainerInterface Container */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $iphoneAppId = false;

        $detect = new \stdClass();
        $detect->displayApp = false;
        $detect->isAndroid = false;
        $detect->isAndroidtablet = false;

        $layout = $this->layout('master', true, true);

        $promo = new \stdClass();
        $promo->isBlackFridayPromoOn = true;

        $request = $request->withAttribute('app', new Collection([
            'layout' => $layout,
            'iphoneAppId' => $iphoneAppId,
            'detect' => $detect,
            'userLoggedIn' => false,
            'displayApp' => false,
            'promo' => $promo,
            'flags' => new Collection($this->container['flags']),
        ]));

        return $next($request, $response);
    }

    /**
     * @param string $container
     * @param bool $staticTopNav
     * @param bool $showNavigation
     *
     * @return \stdClass
     */
    protected function layout(
        string $container,
        bool $staticTopNav = true,
        bool $showNavigation = true
    ): \stdClass {
        $layout = new \stdClass();
        $layout->container = $container;
        $layout->staticTopNav = $staticTopNav;
        $layout->showNavigation = $showNavigation;

        return $layout;
    }
}