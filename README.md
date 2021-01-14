## Installation

  
  
  
1. Run `composer require lwc/sitemap-bundle`.
2. Add to `app/AppKernel.php`:

```
  new SitemapPlugin\SitemapPlugin(),
```

3. Add to `app/config/config.yml`: 

```
  - { resource: "@SitemapPlugin/Resources/config/config.yml" }
```

4. Add to `app/config/routing.yml`: 

```
lwc_sitemap:
     resource: "@SitemapPlugin/Resources/config/routing.yml"
```

## Usage

The plugin defines three default URI's:

* `sitemap.xml`: redirects to `sitemap_index.xml`
* `sitemap_index.xml`: renders the sitemap index file (with links to the provider xml files)
* `sitemap/all.xml`: renders all the URI's from all providers in a single response

Next to this, each provider registeres it's own URI. Take a look in the sitemap index file for the correct URI's.

## Default configuration

Get a full list of configuration: `bin/console config:dump-reference sitemap`

```yaml
sitemap:
    providers:
        static: true
    template:             '@SitemapPlugin/show.xml.twig'
    index_template:       '@SitemapPlugin/index.xml.twig'
    hreflang:             true
    images:               true
    static_routes:
        - { route: app_shop_homepage, parameters: [], locales: [] }
```

## Default storage

By default the sitemaps will be saved in `%kernel.root_dir%/var/sitemap`. You can change this setting 
by adjusting the parameter `app.sitemap.path`.

### Feature switches

* `providers`: Enable/disable certain providers to be included in the sitemap. Defaults are true.
* `hreflang`: Whether to generate alternative URL versions for each locale. Defaults to true. Background: https://support.google.com/webmasters/answer/189077?hl=en.
* `images`: Whether to add images to URL output in case the provider adds them. Defaults to true. Background: https://support.google.com/webmasters/answer/178636?hl=en.

## Default providers

* Static content (homepage)

## Add own provider

* Register & tag your provider service with `app.sitemap_provider`
* Let your provider implement `UrlProviderInterface`
* Use one of the default providers as an example to implement code
