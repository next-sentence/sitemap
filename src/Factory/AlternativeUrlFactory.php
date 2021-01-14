<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\AlternativeUrl;
use LWC\SitemapBundle\Model\AlternativeUrlInterface;

final class AlternativeUrlFactory implements AlternativeUrlFactoryInterface
{
    public function createNew(string $location, string $locale): AlternativeUrlInterface
    {
        return new AlternativeUrl($location, $locale);
    }
}
