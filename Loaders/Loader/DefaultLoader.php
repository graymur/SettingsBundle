<?php
/**
 * Created by Graymur
 * Date: 10.01.2015
 * Time: 14:48
 */

namespace Graymur\SettingsBundle\Loaders\Loader;

use Graymur\SettingsBundle\Loaders\LoaderException;
use Graymur\SettingsBundle\Loaders\AbstractLoader;
use Graymur\SettingsBundle\Model\SettingsGroup;
use Graymur\SettingsBundle\Model\SettingsEntry;
use Doctrine\Common\Collections\ArrayCollection;

class DefaultLoader extends AbstractLoader
{
    protected $files = [];

    /**
     * Stores raw arrays from config files
     */
    protected $configs;

    /**
     * Flag indicating that files were loaded and processed to prevent loading them again
     */
    protected $loaded = false;

    public function __construct(array $configs)
    {
        if (!array_key_exists(0, $configs))
        {
            throw new LoaderException('Key 0 does not exist in settings array');
        }

        if (!is_array($configs[0]))
        {
            throw new LoaderException('Key 0 should be an array');
        }

        $this->configs = $configs;
    }

    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    public function doLoad()
    {
        if (!$this->loaded)
        {
            $this->settings = new ArrayCollection();

            $this->settings['default'] = new SettingsGroup('default');

            foreach ($this->configs as $config)
            {
                $this->processSettingsBatch($config, $this->settings['default']);
            }

            $this->loaded = true;
        }

        return $this->settings;
    }

    protected function processSettingsBatch($batch, SettingsGroup $group)
    {
        foreach ($batch as $k => $v)
        {
            if (strpos($k, 'group_') === 0)
            {
                // check if group contains any settings
                if (empty($v['settings']))
                {
                    throw new LoaderException('Settings group should have "settings" key');
                }

                // check if group name is unique
                if (!empty($this->settings[$k]))
                {
                    throw new LoaderException("Group $k already exists, consider changing the name");
                }

                $this->settings[$k] = new SettingsGroup($k, empty($v['label']) ? $k : $v['label']);
                $this->processSettingsBatch($v['settings'], $this->settings[$k]);
            }
            else
            {
                $data = $this->processSettingsItem($k, $v);
                $group->addEntry($data);
            }
        }

        return $this->settings;
    }

    /**
     * TODO: add values validation according to type
     * @param $key
     * @param $data
     * @return array
     */
    protected function processSettingsItem($key, $data)
    {
        if (!is_array($data))
        {
            $data = array('value' => $data);
        }

        if (empty($data['type']))
        {
            $data['type'] = 'text';
        }

        if (empty($data['label']))
        {
            $data['label'] = $key;
        }

        return new SettingsEntry($key, $data['label'], $data['value'], $data['type']);
    }
}