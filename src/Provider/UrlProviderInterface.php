<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Provider;

interface UrlProviderInterface
{
    public function generate(): iterable;

    public function getName(): string;
}
