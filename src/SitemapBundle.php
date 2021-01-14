<?php

declare(strict_types=1);

namespace LWC\SitemapBundle;

use LWC\SitemapBundle\DependencyInjection\Compiler\SitemapProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SitemapBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SitemapProviderPass());
    }
}
