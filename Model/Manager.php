<?php
/**
 * Created by Graymur
 * Date: 09.01.2015
 * Time: 18:42
 */

namespace Graymur\SettingsBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Graymur\SettingsBundle\Loaders\Loader\DefaultLoader;
use Graymur\SettingsBundle\Loaders\Loader\DoctrineLoader;

class Manager
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \AppKernel
     */
    protected $kernel;

    protected $loaded = false;
    protected $settings;
    protected $short = [];

    /**
     * Is called automatically when called as a service
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        $this->kernel = $container->get('kernel');
    }

    public function loadDefault()
    {
        if (!isset($this->settings['default']))
        {
            $loader = new DefaultLoader($this->container->getParameter('graymur_settings'));
            $this->settings['default'] = $loader->load();
        }

        return $this->settings['default'];
    }

    public function loadDoctrine()
    {
        if (!isset($this->settings['doctrine']))
        {
            $loader = new DoctrineLoader(
                $this->container->get('doctrine')->getRepository('GraymurSettingsBundle:SettingsItem')
            );
            $this->settings['doctrine'] = $loader->load();
        }

        return $this->settings['doctrine'];
    }

    /**
     * Load all settings and form sort array containing values from storage,
     * if they exist, or values from files
     * TODO: automate loading
     */
    public function load()
    {
        if (!$this->loaded)
        {
            $this->loadDefault();
            $this->loadDoctrine();

            foreach ($this->settings['default'] as $groupName => $group)
            {
                $this->short[$groupName] = [];

                foreach ($group->getEntries() as $k => $entry)
                {
                    // set default value from
                    $this->short[$groupName][$k] = $entry->getValue();

                    // if settings group does not exist in stored settings, continue
                    if (!array_key_exists($groupName, $this->settings['doctrine'])) continue;

                    // if entry with current key does not exist in stored settings, continue
                    if (!$this->settings['doctrine'][$groupName]->hasEntryWithKey($k)) continue;

                    $this->short[$groupName][$k] = $this->settings['doctrine'][$groupName]->getEntryWithKey($k)->getValue();
                }
            }

            $this->loaded = true;
        }

        return $this->short;
    }

    /**
     * Returns stored setting value or default. In first call, loads all settings
     *
     * @param $key
     * @param string $group
     * @return mixed
     * @throws Exception
     */
    public function getValue($key, $group = 'default')
    {
        $this->load();

        if (empty($this->short[$group][$key]))
        {
            throw new Exception("Entry with key $key does not exist in group $group");
        }

        return $this->short[$group][$key];
    }
}

class Exception extends \Exception
{

}