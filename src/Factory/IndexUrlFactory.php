<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\IndexUrl;
use LWC\SitemapBundle\Model\IndexUrlInterface;

final class IndexUrlFactory implements IndexUrlFactoryInterface
{
    public function createNew(string $location): IndexUrlInterface
    {
        return new IndexUrl($location);
    }
}
