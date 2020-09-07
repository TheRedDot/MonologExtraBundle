<?php

namespace TheRedDot\MonologExtraBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\KernelEvents;
use TheRedDot\MonologExtraBundle\EventListener\ConsoleCommandListener;
use TheRedDot\MonologExtraBundle\EventListener\ConsoleExceptionListener;
use TheRedDot\MonologExtraBundle\EventListener\RequestIdResponseListener;
use TheRedDot\MonologExtraBundle\EventListener\RequestResponseListener;
use TheRedDot\MonologExtraBundle\Processor\AdditionsProcessor;
use TheRedDot\MonologExtraBundle\Processor\RequestIdProcessor;
use TheRedDot\MonologExtraBundle\Processor\UserProcessor;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use TheRedDot\MonologExtraBundle\Provider\User\UserProviderInterface;

class TheRedDotMonologExtraExtension extends Extension
{
    /**
     * @param array<mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setAlias(RequestIdProviderInterface::class, $config['provider']['request_id']);
        $container->setAlias(UserProviderInterface::class, $config['provider']['user']);

        $this->addAdditions($config, $container);
        $this->addProcessors($config, $container);
        $this->addConsoleExceptionListener($config, $container);
        $this->addRequestResponseListener($config, $container);
        $this->addCommandListener($config, $container);
        $this->addRequestIdToResponseListener($config, $container);
    }

    /**
     * @param array<mixed> $config
     */
    private function addAdditions(array $config, ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(AdditionsProcessor::class);

        $definition
            ->addTag('monolog.processor', ['method' => 'processRecord'])
            ->addArgument($config['processor']['additions']);
    }

    /**
     * @param array<mixed> $config
     */
    private function addProcessors(array $config, ContainerBuilder $container): void
    {
        if ($config['processor']['user']) {
            $definition = $container->getDefinition(UserProcessor::class);
            $definition->addTag('monolog.processor', ['method' => 'processRecord']);
        } else {
            $container->removeDefinition(UserProcessor::class);
        }

        if ($config['processor']['request_id']) {
            $definition = $container->getDefinition(RequestIdProcessor::class);
            $definition->addTag('monolog.processor', ['method' => 'processRecord']);
        } else {
            $container->removeDefinition(RequestIdProcessor::class);
        }
    }

    /**
     * @param array<mixed> $config
     */
    private function addConsoleExceptionListener(array $config, ContainerBuilder $container): void
    {
        if (!$config['logger']['on_console_exception']) {
            $container->removeDefinition(ConsoleExceptionListener::class);

            return;
        }

        $definition = $container->getDefinition(ConsoleExceptionListener::class);
        $definition->addTag('kernel.event_listener', ['event' => ConsoleEvents::ERROR, 'method' => 'onConsoleError']);
    }

    /**
     * @param array<mixed> $config
     */
    private function addRequestResponseListener(array $config, ContainerBuilder $container): void
    {
        if (!$config['logger']['on_request'] && !$config['logger']['on_response']) {
            $container->removeDefinition(RequestResponseListener::class);

            return;
        }

        $definition = $container->getDefinition(RequestResponseListener::class);

        if ($config['logger']['on_request']) {
            $definition->addTag('kernel.event_listener', ['event' => KernelEvents::REQUEST, 'method' => 'onRequest']);
        }

        if ($config['logger']['on_response']) {
            $definition->addTag('kernel.event_listener', ['event' => KernelEvents::RESPONSE, 'method' => 'onResponse']);
        }
    }

    /**
     * @param array<mixed> $config
     */
    private function addCommandListener(array $config, ContainerBuilder $container): void
    {
        if (!$config['logger']['on_command']) {
            $container->removeDefinition(ConsoleCommandListener::class);

            return;
        }

        $definition = $container->getDefinition(ConsoleCommandListener::class);
        $definition->addTag('kernel.event_listener', ['event' => ConsoleEvents::COMMAND, 'method' => 'onConsoleCommand']);
    }

    /**
     * @param array<mixed> $config
     */
    private function addRequestIdToResponseListener(array $config, ContainerBuilder $container): void
    {
        if (!$config['logger']['add_request_id_to_response']) {
            $container->removeDefinition(RequestIdResponseListener::class);

            return;
        }

        $definition = $container->getDefinition(RequestIdResponseListener::class);
        $definition->addTag('kernel.event_listener', ['event' => KernelEvents::RESPONSE, 'method' => 'onKernelResponse']);
    }
}
