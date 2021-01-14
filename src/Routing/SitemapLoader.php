<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Routing;

use LWC\SitemapBundle\Builder\SitemapBuilderInterface;
use LWC\SitemapBundle\Exception\RouteExistsException;
use LWC\SitemapBundle\Provider\UrlProviderInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class SitemapLoader extends Loader implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var bool */
    private $loaded = false;

    /** @var SitemapBuilderInterface */
    private $sitemapBuilder;

    public function __construct(SitemapBuilderInterface $sitemapBuilder)
    {
        $this->sitemapBuilder = $sitemapBuilder;
    }

    /**
     * @throws RouteExistsException
     */
    public function load($resource, $type = null): RouteCollection
    {
        $routes = new RouteCollection();

        if (true === $this->loaded) {
            return $routes;
        }

        foreach ($this->sitemapBuilder->getProviders() as $provider) {
            /** @var UrlProviderInterface $provider */
            $name = 'app_sitemap_' . $provider->getName();

            if ($routes->get($name)) {
                throw new RouteExistsException($name);
            }

            $routes->add(
                $name,
                new Route(
                    '/sitemap/' . $provider->getName() . '.xml',
                    [
                        '_controller' => 'app.controller.sitemap:showAction',
                        'name' => $provider->getName(),
                    ],
                    [],
                    [],
                    '',
                    [],
                    ['GET']
                )
            );
        }

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null): bool
    {
        return $type && 'sitemap' === $type;
    }
}
