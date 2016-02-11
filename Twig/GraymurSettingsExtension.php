<?php
/**
 * Created by Graymur
 * Date: 09.01.2015
 * Time: 19:35
 */

namespace Graymur\SettingsBundle\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Allows to use settings in twig template with {{ settings(key) }} function
 *
 * Class GraymurSettingsExtension
 * @package Graymur\SettingsBundle\Twig
 */
class GraymurSettingsExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('settings', array($this, 'getValue')),
        );
    }

    public function getValue($key, $group = 'default')
    {
        try
        {
            $retval = $this->container->get('gr_settings')->getValue($key, $group);
        }
        catch (\Exception $e)
        {
            $retval = $key;
        }

        return $retval;
    }

    public function getName()
    {
        return 'gr_settings_extension';
    }
}