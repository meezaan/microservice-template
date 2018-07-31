<?php
/**
 * {description}
 *
 * @author
 */

namespace Config;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tightenco\Collect\Support\Collection;

class Env
{
    /** @var string $provisionContext */
    protected $provisionContext;

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $this->provisionContext = strtolower(getenv('PROVISION_CONTEXT'));

        if (!\in_array($this->provisionContext, ['development', 'staging', 'production'])) {
            $this->provisionContext = 'development';
        }

        return $next($request, $response);
    }

    public function __toString()
    {
        return $this->provisionContext;
    }
}