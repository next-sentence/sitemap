<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Command;

use LWC\SitemapBundle\Builder\SitemapBuilderInterface;
use LWC\SitemapBundle\Builder\SitemapIndexBuilderInterface;
use LWC\SitemapBundle\Filesystem\Writer;
use LWC\SitemapBundle\Renderer\SitemapRendererInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateSitemapCommand extends Command
{
    /** @var \LWC\SitemapBundle\Builder\SitemapBuilderInterface */
    private $sitemapBuilder;

    /** @var SitemapIndexBuilderInterface */
    private $sitemapIndexBuilder;

    /** @var SitemapRendererInterface */
    private $sitemapRenderer;

    /** @var SitemapRendererInterface */
    private $sitemapIndexRenderer;

    /** @var Writer */
    private $writer;

    public function __construct(
        SitemapRendererInterface $sitemapRenderer,
        SitemapRendererInterface $sitemapIndexRenderer,
        SitemapBuilderInterface $sitemapBuilder,
        SitemapIndexBuilderInterface $sitemapIndexBuilder,
        Writer $writer
    ) {
        $this->sitemapRenderer = $sitemapRenderer;
        $this->sitemapIndexRenderer = $sitemapIndexRenderer;
        $this->sitemapBuilder = $sitemapBuilder;
        $this->sitemapIndexBuilder = $sitemapIndexBuilder;
        $this->writer = $writer;

        parent::__construct('app:sitemap:generate');
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO make sure providers are every time emptied (reset call or smth?)
        foreach ($this->sitemapBuilder->getProviders() as $provider) {
            $output->writeln(\sprintf('Start generating sitemap "%s"', $provider->getName()));

            $sitemap = $this->sitemapBuilder->build($provider); // TODO use provider instance, not the name
            $xml = $this->sitemapRenderer->render($sitemap);
            $path = \sprintf('%s.xml', $provider->getName());

            $this->writer->write(
                $path,
                $xml
            );

            $output->writeln(\sprintf('Finished generating sitemap "%s"  at path "%s"', $provider->getName(), $path));
        }

        $output->writeln(\sprintf('Start generating sitemap index'));

        $sitemap = $this->sitemapIndexBuilder->build();
        $xml = $this->sitemapIndexRenderer->render($sitemap);
        $path = \sprintf('%s', 'sitemap_index.xml');

        $this->writer->write(
            $path,
            $xml
        );

        $output->writeln(\sprintf('Finished generating sitemap index at path "%s"', $path));
    }

    private function path(string $path): string
    {
        return \sprintf('%s', $path);
    }
}
