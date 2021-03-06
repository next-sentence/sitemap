<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Builder;

use LWC\SitemapBundle\Factory\SitemapIndexFactoryInterface;
use LWC\SitemapBundle\Model\SitemapInterface;
use LWC\SitemapBundle\Provider\IndexUrlProviderInterface;
use LWC\SitemapBundle\Provider\UrlProviderInterface;

final class SitemapIndexBuilder implements SitemapIndexBuilderInterface
{
    /** @var SitemapIndexFactoryInterface */
    private $sitemapIndexFactory;

    /** @var array */
    private $providers = [];

    /** @var array */
    private $indexProviders = [];

    public function __construct(SitemapIndexFactoryInterface $sitemapIndexFactory)
    {
        $this->sitemapIndexFactory = $sitemapIndexFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function addProvider(UrlProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function addIndexProvider(IndexUrlProviderInterface $provider): void
    {
        $this->indexProviders[] = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): SitemapInterface
    {
        $sitemap = $this->sitemapIndexFactory->createNew();
        $urls = [];

        /** @var IndexUrlProviderInterface $indexProvider */
        foreach ($this->indexProviders as $indexProvider) {
            /** @var UrlProviderInterface $provider */
            foreach ($this->providers as $provider) {
                $indexProvider->addProvider($provider);
            }

            $urls[] = $indexProvider->generate();
        }

        $sitemap->setUrls(\array_merge(...$urls));

        return $sitemap;
    }
}
