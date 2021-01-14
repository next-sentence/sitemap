<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Builder;

use LWC\SitemapBundle\Factory\SitemapFactoryInterface;
use LWC\SitemapBundle\Model\SitemapInterface;
use LWC\SitemapBundle\Provider\UrlProviderInterface;

final class SitemapBuilder implements SitemapBuilderInterface
{
    /** @var SitemapFactoryInterface */
    private $sitemapFactory;

    /** @var array */
    private $providers = [];

    public function __construct(SitemapFactoryInterface $sitemapFactory)
    {
        $this->sitemapFactory = $sitemapFactory;
    }

    public function addProvider(UrlProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    public function getProviders(): iterable
    {
        return $this->providers;
    }

    public function build(UrlProviderInterface $provider): SitemapInterface
    {
        $sitemap = $this->sitemapFactory->createNew();
        $urls[] = $provider->generate();

        $sitemap->setUrls(\array_merge(...$urls));

        return $sitemap;
    }
}
