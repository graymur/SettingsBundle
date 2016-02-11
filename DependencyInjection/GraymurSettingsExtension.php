<?php
/**
 * Created by Graymur
 * Date: 13.01.2015
 * Time: 14:16
 */

namespace Graymur\SettingsBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class GraymurSettingsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // expose 'graymur_settings' to global config
        $container->setParameter('graymur_settings', $configs);

        // load services configuration
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'graymur_settings';
    }
}