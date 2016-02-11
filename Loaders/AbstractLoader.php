<?php
/**
 * Created by Graymur
 * Date: 10.01.2015
 * Time: 18:14
 */

namespace Graymur\SettingsBundle\Loaders;

use Doctrine\Common\Collections\ArrayCollection;
use Graymur\SettingsBundle\Model\SettingsEntry;
use Graymur\SettingsBundle\Model\SettingsGroup;

abstract class AbstractLoader implements LoaderInterface
{
    protected $settings;

    final function load()
    {
        return $this->validate($this->doLoad());
    }

    final function validate($settings)
    {
        if (!$settings instanceof ArrayCollection)
        {
            throw new LoaderException("Settings should be instanse of Doctrine\\Common\\Collections\\ArrayCollection");
        }

        foreach ($settings as $groupKey => $group)
        {
            if (!$group instanceof SettingsGroup)
            {
                throw new LoaderException("Value for group $groupKey should be instance of SettingsGroup");
            }

            foreach ($group->getEntries() as $k => $entry)
            {
                if (!$entry instanceof SettingsEntry)
                {
                    throw new LoaderException("Value for key $k in group $groupKey should be instance of SettingsEntry");
                }
            }
        }

        return $settings;
    }
}
