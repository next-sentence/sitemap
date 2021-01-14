<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SitemapProviderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app.sitemap_builder')) {
            return;
        }

        $builderDefinition = $container->findDefinition('app.sitemap_builder');
        $builderIndexDefinition = $container->findDefinition('app.sitemap_index_builder');
        $taggedProviders = $container->findTaggedServiceIds('app.sitemap_provider');

        foreach ($taggedProviders as $id => $tags) {
            $builderIndexDefinition->addMethodCall('addProvider', [(new Reference($id))]);
            $builderDefinition->addMethodCall('addProvider', [(new Reference($id))]);
        }

        $taggedProvidersIndex = $container->findTaggedServiceIds('app.sitemap_index_provider');
        foreach ($taggedProvidersIndex as $id => $tags) {
            $builderIndexDefinition->addMethodCall('addIndexProvider', [new Reference($id)]);
        }
    }
}
