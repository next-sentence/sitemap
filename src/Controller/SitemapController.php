<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Controller;

use LWC\SitemapBundle\Filesystem\Reader;
use Symfony\Component\HttpFoundation\Response;

final class SitemapController extends AbstractController
{
    public function __construct(
        Reader $reader
    ) {
        parent::__construct($reader);
    }

    public function showAction(string $name): Response
    {
        $path = \sprintf('%s', \sprintf('%s.xml', $name));

        return $this->createResponse($path);
    }
}
