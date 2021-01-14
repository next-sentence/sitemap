<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Builder;

use LWC\SitemapBundle\Model\SitemapInterface;
use LWC\SitemapBundle\Provider\UrlProviderInterface;

interface SitemapBuilderInterface extends BuilderInterface
{
    public function build(UrlProviderInterface $provider): SitemapInterface;

    /**
     * @return UrlProviderInterface[]
     */
    public function getProviders(): iterable;
}
