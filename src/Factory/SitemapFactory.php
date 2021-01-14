<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\Sitemap;
use LWC\SitemapBundle\Model\SitemapInterface;

final class SitemapFactory implements SitemapFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(): SitemapInterface
    {
        return new Sitemap();
    }
}
