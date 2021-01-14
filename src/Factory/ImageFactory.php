<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\Image;
use LWC\SitemapBundle\Model\ImageInterface;

final class ImageFactory implements ImageFactoryInterface
{
    public function createNew(string $location): ImageInterface
    {
        return new Image($location);
    }
}
