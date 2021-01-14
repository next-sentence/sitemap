<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\UrlInterface;

interface UrlFactoryInterface
{
    public function createNew(string $location): UrlInterface;
}
