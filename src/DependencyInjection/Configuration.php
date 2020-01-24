<?php

namespace TheRedDot\MonologExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use TheRedDot\MonologExtraBundle\Provider\RequestId\UniqidProvider;
use TheRedDot\MonologExtraBundle\Provider\Session\SymfonySessionIdProvider;
use TheRedDot\MonologExtraBundle\Provider\User\SymfonyUserProvider;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('the_red_dot_monolog_extra');
        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('the_red_dot_monolog_extra');
        }

        $rootNode
            ->children()
                ->booleanNode('session_start')
                    ->defaultFalse()
                    ->info('If the session should be started, so the session_id will always be available.')
                ->end()
                ->arrayNode('processor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('user')->defaultFalse()->end()
                        ->scalarNode('session_id')
                            ->info('Adds session id into records')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('request_id')
                            ->info('Adds request ID into records')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('additions')
                            ->info('A list of "key: value" entries that will be set in the [extra] section of each log message (Overwrites existing keys!).')
                            ->useAttributeAsKey('key')
                            ->normalizeKeys(false)
                            ->prototype('scalar')
                                ->info('Value for the key.')
                                ->isRequired()
                                ->example('value')
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('session_id')
                            ->info('Provider for session id')
                            ->defaultValue(SymfonySessionIdProvider::class)
                        ->end()
                        ->scalarNode('request_id')
                            ->info('Provider for uid')
                            ->defaultValue(UniqidProvider::class)
                        ->end()
                        ->scalarNode('user')
                            ->info('Provider for user')
                            ->defaultValue(SymfonyUserProvider::class)
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('logger')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('on_request')->defaultFalse()->end()
                        ->scalarNode('on_response')->defaultFalse()->end()
                        ->scalarNode('on_command')->defaultFalse()->end()
                        ->scalarNode('on_console_exception')->defaultTrue()->end()
                        ->scalarNode('add_request_id_to_response')->defaultFalse()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
