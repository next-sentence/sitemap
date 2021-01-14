<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\Url;
use LWC\SitemapBundle\Model\UrlInterface;

final class UrlFactory implements UrlFactoryInterface
{
    public function createNew(string $location): UrlInterface
    {
        return new Url($location);
    }
}
