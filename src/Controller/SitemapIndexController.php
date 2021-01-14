<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Controller;

use LWC\SitemapBundle\Filesystem\Reader;
use Symfony\Component\HttpFoundation\Response;

final class SitemapIndexController extends AbstractController
{

    public function __construct(
        Reader $reader
    ) {
        parent::__construct($reader);
    }

    public function showAction(): Response
    {
        $path = \sprintf('%s', 'sitemap_index.xml');

        return $this->createResponse($path);
    }
}
