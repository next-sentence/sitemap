<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Builder;

use LWC\SitemapBundle\Provider\UrlProviderInterface;

interface BuilderInterface
{
    public function addProvider(UrlProviderInterface $provider): void;
}
