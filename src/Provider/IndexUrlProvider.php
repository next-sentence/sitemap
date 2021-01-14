<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Provider;

use LWC\SitemapBundle\Factory\IndexUrlFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

final class IndexUrlProvider implements IndexUrlProviderInterface
{
    /** @var UrlProviderInterface[] */
    private $providers = [];

    /** @var RouterInterface */
    private $router;

    /** @var IndexUrlFactoryInterface */
    private $sitemapIndexUrlFactory;

    /** @var array */
    private $urls = [];

    public function __construct(
        RouterInterface $router,
        IndexUrlFactoryInterface $sitemapIndexUrlFactory
    ) {
        $this->router = $router;
        $this->sitemapIndexUrlFactory = $sitemapIndexUrlFactory;
    }

    public function addProvider(UrlProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    public function generate(): iterable
    {
        foreach ($this->providers as $provider) {
            $location = $this->router->generate('app_sitemap_' . $provider->getName());

            $this->urls[] = $this->sitemapIndexUrlFactory->createNew($location);
        }

        return $this->urls;
    }
}
