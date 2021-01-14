<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Factory;

use LWC\SitemapBundle\Model\IndexUrlInterface;

interface IndexUrlFactoryInterface
{
    public function createNew(string $location): IndexUrlInterface;
}
