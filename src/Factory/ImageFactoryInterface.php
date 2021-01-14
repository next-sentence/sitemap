<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\ImageInterface;

interface ImageFactoryInterface
{
    public function createNew(string $location): ImageInterface;
}
