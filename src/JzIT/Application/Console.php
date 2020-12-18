<?php

declare(strict_types=1);

namespace JzIT\Application;

use DI\NotFoundException;
use JzIT\Kernel\KernelInterface;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;

class Console extends BaseApplication
{
    /**
     * @var \JzIT\Kernel\KernelInterface
     */
    protected $kernel;

    /**
     * Console constructor.
     * @param \JzIT\Kernel\KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        parent::__construct('JzIT', '1.0.0');

        $this->kernel = $kernel;
    }

    /**
     * @return \Symfony\Component\Console\Command\Command[]
     * @throws \DI\DependencyException
     */
    protected function getDefaultCommands(): array
    {
        $defaultCommands = parent::getDefaultCommands();

        try {
            $commands = $this->kernel->getContainer()->get('commands');
        } catch (NotFoundException $notFoundException) {
            return $defaultCommands;
        }

        if (!\is_array($commands) || \count($commands) === 0) {
            return $defaultCommands;
        }

        foreach ($commands as $command) {
            if (!$command instanceof Command) {
                continue;
            }

            $defaultCommands[] = $command;
        }

        return $defaultCommands;
    }
}
