<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Renderer;

use LWC\SitemapBundle\Model\SitemapInterface;

interface SitemapRendererInterface
{
    public function render(SitemapInterface $sitemap): string;
}
