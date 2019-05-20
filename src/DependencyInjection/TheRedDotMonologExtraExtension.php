<?php

namespace TheRedDot\MonologExtraBundle\DependencyInjection;

use TheRedDot\MonologExtraBundle\EventListener\CommandListener;
use TheRedDot\MonologExtraBundle\EventListener\ConsoleExceptionListener;
use TheRedDot\MonologExtraBundle\EventListener\RequestResponseListener;
use TheRedDot\MonologExtraBundle\EventListener\RequestIdResponseListener;
use TheRedDot\MonologExtraBundle\Processor\AdditionsProcessor;
use TheRedDot\MonologExtraBundle\Processor\SessionIdProcessor;
use TheRedDot\MonologExtraBundle\Processor\RequestIdProcessor;
use TheRedDot\MonologExtraBundle\Processor\UserProcessor;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use TheRedDot\MonologExtraBundle\Provider\Session\SessionIdProviderInterface;
use TheRedDot\MonologExtraBundle\Provider\User\UserProviderInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\KernelEvents;

class TheRedDotMonologExtraExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('the_red_dot_monolog_extra.session_start', $config['session_start']);

        $container->setAlias(RequestIdProviderInterface::class, $config['provider']['request_id']);
        $container->setAlias(SessionIdProviderInterface::class, $config['provider']['session_id']);
        $container->setAlias(UserProviderInterface::class, $config['provider']['user']);

        $this->addAdditions($container, $config);
        $this->addProcessors($container, $config);
        $this->addConsoleExceptionListener($container, $config);
        $this->addRequestResponseListener($container, $config);
        $this->addCommandListener($container, $config);
        $this->addRequestIdToResponseListener($container, $config);
    }

    protected function addAdditions(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition(AdditionsProcessor::class);

        $definition
            ->addTag('monolog.processor', ['method' => 'processRecord'])
            ->addArgument($config['processor']['additions']);
    }

    protected function addProcessors(ContainerBuilder $container, array $config) {
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

        if ($config['processor']['session_id']) {
            $definition = $container->getDefinition(SessionIdProcessor::class);
            $definition->addTag('monolog.processor', ['method' => 'processRecord']);
        } else {
            $container->removeDefinition(SessionIdProcessor::class);
        }
    }

    protected function addConsoleExceptionListener(ContainerBuilder $container, array $config)
    {
        if (!$config['logger']['on_console_exception']) {
            $container->removeDefinition(ConsoleExceptionListener::class);

            return;
        }

        $definition = $container->getDefinition(ConsoleExceptionListener::class);
        $definition->addTag('kernel.event_listener', ['event' => ConsoleEvents::ERROR, 'method' => 'onConsoleException']);
    }

    protected function addRequestResponseListener(ContainerBuilder $container, array $config)
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

    protected function addCommandListener(ContainerBuilder $container, array $config)
    {
        if (!$config['logger']['on_command']) {
            $container->removeDefinition(CommandListener::class);

            return;
        }

        $definition = $container->getDefinition(CommandListener::class);
        $definition->addTag('kernel.event_listener', ['event' => ConsoleEvents::COMMAND, 'method' => 'onCommandResponse']);
    }

    protected function addRequestIdToResponseListener(ContainerBuilder $container, array $config)
    {
        if (!$config['logger']['add_request_id_to_response']) {
            $container->removeDefinition(RequestIdResponseListener::class);

            return;
        }

        $definition = $container->getDefinition(RequestIdResponseListener::class);
        $definition->addTag('kernel.event_listener', ['event' => KernelEvents::RESPONSE, 'method' => 'onKernelResponse']);
    }
}
