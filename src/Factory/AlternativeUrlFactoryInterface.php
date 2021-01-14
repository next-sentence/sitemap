<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\AlternativeUrlInterface;

interface AlternativeUrlFactoryInterface
{
    public function createNew(string $location, string $locale): AlternativeUrlInterface;
}
