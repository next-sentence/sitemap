<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\SitemapIndex;
use LWC\SitemapBundle\Model\SitemapInterface;

final class SitemapIndexFactory implements SitemapIndexFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(): SitemapInterface
    {
        return new SitemapIndex();
    }
}
