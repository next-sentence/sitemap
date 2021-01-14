<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Provider;

use LWC\SitemapBundle\Factory\AlternativeUrlFactoryInterface;
use LWC\SitemapBundle\Factory\UrlFactoryInterface;
use LWC\SitemapBundle\Model\ChangeFrequency;
use Symfony\Component\Routing\RouterInterface;

final class StaticUrlProvider implements UrlProviderInterface
{
    /** @var RouterInterface */
    private $router;

    /** @var UrlFactoryInterface */
    private $sitemapUrlFactory;

    /** @var AlternativeUrlFactoryInterface */
    private $urlAlternativeFactory;

    /** @var array */
    private $urls = [];

    /** @var array */
    private $routes;

    public function __construct(
        RouterInterface $router,
        UrlFactoryInterface $sitemapUrlFactory,
        AlternativeUrlFactoryInterface $urlAlternativeFactory,
        array $routes
    ) {
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->urlAlternativeFactory = $urlAlternativeFactory;
        $this->routes = $routes;
    }

    public function getName(): string
    {
        return 'static';
    }

    public function generate(): iterable
    {
        $this->urls = [];

        if (empty($this->routes)) {
            return $this->urls;
        }

        foreach ($this->transformAndYieldRoutes() as $route) {
            $location = $this->router->generate($route['route'], $route['parameters']);

            $staticUrl = $this->sitemapUrlFactory->createNew($location);
            $staticUrl->setChangeFrequency(ChangeFrequency::weekly());
            $staticUrl->setPriority(0.3);

            foreach ($route['locales'] as $alternativeLocaleCode) {
                $route['parameters']['_locale'] = $alternativeLocaleCode;
                $alternativeLocation = $this->router->generate($route['route'], $route['parameters']);
                $staticUrl->addAlternative($this->urlAlternativeFactory->createNew($alternativeLocation, $alternativeLocaleCode));
            }

            $this->urls[] = $staticUrl;
        }

        return $this->urls;
    }

    private function transformAndYieldRoutes(): \Generator
    {
        foreach ($this->routes as $route) {
            yield $this->transformRoute($route);
        }
    }

    private function transformRoute(array $route): array
    {
        // Add default locale to route if not set
//        $route = $this->addDefaultRoute($route);

        if (!isset($route['locales']) || empty($route['locales'])) {
            $route['locales'] = $this->getAlternativeLocales();
        }

        // Remove the locale that is on the main route from the alternatives to prevent duplicates
        $route = $this->excludeMainRouteLocaleFromAlternativeLocales($route);

        return $route;
    }

    private function addDefaultRoute(array $route): array
    {
        if (isset($route['parameters']['_locale'])) {
            return $route;
        }

        $defaultLocale = 'en';

        if ($defaultLocale) {
            $route['parameters']['_locale'] = $defaultLocale->getCode();
        }

        return $route;
    }

    private function excludeMainRouteLocaleFromAlternativeLocales(array $route): array
    {
        $locales = $route['locales'];
        $locale = $route['parameters']['_locale'];

        $key = \array_search($locale, $locales);

        if ($key !== false) {
            unset($route['locales'][$key]);
        }

        return $route;
    }

    /**
     * @return array<int, string|null>
     */
    private function getAlternativeLocales(): array
    {
        $locales = [];

        return $locales;
    }
}
