<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        if (\method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('lwc_sitemap');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('lwc_sitemap');
        }

        $this->addSitemapSection($rootNode);

        return $treeBuilder;
    }

    private function addSitemapSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('providers')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('static')->defaultTrue()->end()
                    ->end()
                ->end()
                ->scalarNode('template')
                    ->defaultValue('@LWC\SitemapBundle/show.xml.twig')
                ->end()
                ->scalarNode('index_template')
                    ->defaultValue('@LWC\SitemapBundle/index.xml.twig')
                ->end()
                ->scalarNode('hreflang')
                    ->info('Whether to generate alternative URL versions for each locale. Defaults to true. Background: https://support.google.com/webmasters/answer/189077?hl=en.')
                    ->defaultTrue()
                ->end()
                ->scalarNode('images')
                    ->info('Add images to URL output in case the provider adds them. Defaults to true. Background: https://support.google.com/webmasters/answer/178636?hl=en')
                    ->defaultTrue()
                ->end()
                ->arrayNode('static_routes')
                    ->beforeNormalization()->castToArray()->end()
                    ->info('In case you want to add static routes to your sitemap (e.g. homepage), configure them here. Defaults to homepage & contact page.')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route')
                                ->info('Name of route')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('parameters')
                                ->prototype('variable')->end()
                                ->info('Add optional parameters to the route.')
                            ->end()
                            ->arrayNode('locales')
                                ->prototype('scalar')
                                ->info('Define which locales to add. If empty, it uses the default locales for channel context supplied')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
