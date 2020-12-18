<?php

declare(strict_types=1);

namespace JzIT\Application;

use JzIT\Kernel\KernelInterface;

class Http
{
    /**
     * @var \JzIT\Kernel\KernelInterface
     */
    protected $kernel;

    /**
     * Http constructor.
     * @param \JzIT\Kernel\KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = $this->kernel->getContainer()->get('request');
        /** @var \League\Route\Router $router */
        $router = $this->kernel->getContainer()->get('router');
        /** @var \Zend\HttpHandlerRunner\Emitter\EmitterInterface $emitter */
        $emitter = $this->kernel->getContainer()->get('emitter');

        $response = $router->dispatch($request);

        $emitter->emit($response);
    }
}
