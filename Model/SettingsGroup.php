<?php
/**
 * Created by Graymur
 * Date: 10.01.2015
 * Time: 13:44
 */

namespace Graymur\SettingsBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class SettingsGroup
{
    protected $group;
    protected $label;
    protected $settings;

    public function __construct($group, $label = null)
    {
        $this->group = $group;
        $this->label = empty($label) ? $group : $label;
        $this->settings = new ArrayCollection();
    }

    public function addEntry(SettingsEntry $item)
    {
        $this->settings[$item->getKey()] = $item;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getEntries()
    {
        return $this->settings;
    }

    public function hasEntryWithKey($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * @param $key
     * @return \Graymur\SettingsBundle\Model\SettingsEntry
     * @throws \Exception
     */
    public function getEntryWithKey($key)
    {
        if (!$this->hasEntryWithKey($key))
        {
            throw new \Exception("Entry with key $key does not exist in group {$this->getLabel()}");
        }

        return $this->settings[$key];
    }
}