<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Builder;

use LWC\SitemapBundle\Model\SitemapInterface;
use LWC\SitemapBundle\Provider\IndexUrlProviderInterface;

interface SitemapIndexBuilderInterface extends BuilderInterface
{
    public function addIndexProvider(IndexUrlProviderInterface $provider): void;

    public function build(): SitemapInterface;
}
