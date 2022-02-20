<?php

declare(strict_types=1);

namespace DeFixIT\Anonlytics\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('anonlytics');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('client_token')->end()
            ->scalarNode('site_token')->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}