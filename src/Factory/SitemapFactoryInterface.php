<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\SitemapInterface;

interface SitemapFactoryInterface
{
    public function createNew(): SitemapInterface;
}
