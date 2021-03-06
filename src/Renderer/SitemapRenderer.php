<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Renderer;

use LWC\SitemapBundle\Model\SitemapInterface;

final class SitemapRenderer implements SitemapRendererInterface
{
    /** @var RendererAdapterInterface */
    private $adapter;

    public function __construct(RendererAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function render(SitemapInterface $sitemap): string
    {
        return $this->adapter->render($sitemap);
    }
}
