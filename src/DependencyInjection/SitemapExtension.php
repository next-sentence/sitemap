<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SitemapExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration([], $container);
        if (!$configuration) {
            throw new \Exception('Configuration did not provide proper object');
        }
        $config = $this->processConfiguration($configuration, $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('app.sitemap_template', $config['template']);
        $container->setParameter('app.sitemap_index_template', $config['index_template']);
        $container->setParameter('app.sitemap_hreflang', $config['hreflang']);
        $container->setParameter('app.sitemap_static', $config['static_routes']);
        $container->setParameter('app.sitemap_images', $config['images']);

        foreach ($config['providers'] as $provider => $setting) {
            $parameter = \sprintf('app.provider.%s', $provider);
            $container->setParameter($parameter, $setting);

            if ($setting === true) {
                $loader->load(\sprintf('services/providers/%s.xml', $provider));
            }
        }
    }
}
