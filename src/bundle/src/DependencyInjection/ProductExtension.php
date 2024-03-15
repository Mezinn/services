<?php

declare(strict_types=1);

namespace Product\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

class ProductExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );
        $loader->load('services.yaml');
        $locator = new FileLocator();

        $configPath = __DIR__.'/../../config/messenger.yaml';
        $config = Yaml::parse(file_get_contents($configPath));

        if (isset($config['framework'])) {
            $container->prependExtensionConfig('framework', $config['framework']);
        }

        $configPath = __DIR__.'/../../config/doctrine.yaml';
        $config = Yaml::parse(file_get_contents($configPath));

        if (isset($config['orm'])) {
            $container->prependExtensionConfig('orm', $config['orm']);
        }
    }
}
