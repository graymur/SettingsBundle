<?php
/**
 * Created by Graymur
 * Date: 10.01.2015
 * Time: 14:48
 */

namespace Graymur\SettingsBundle\Loaders\Loader;

use Doctrine\Common\Collections\ArrayCollection;
use Graymur\SettingsBundle\Loaders\LoaderException;
use Graymur\SettingsBundle\Loaders\AbstractLoader;
use Graymur\SettingsBundle\Model\SettingsEntry;
use Graymur\SettingsBundle\Model\SettingsGroup;

class DoctrineLoader extends AbstractLoader
{
    /**
     * Flag indicating that files were loaded and processed to prevent loading them again
     */
    protected $loaded = false;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function doLoad()
    {
        if (!$this->loaded)
        {
            if (!$this->settings)
            {
                $this->settings = new ArrayCollection();
            }

            foreach ($this->loadFromDB() as $item)
            {
                /* @var $item \Graymur\SettingsBundle\Entity\SettingsItem */
                $group = $item->getSettingsGroup();

                if (!$this->settings->containsKey($group))
                {
                    $this->settings[$group] = new SettingsGroup($group);
                }

                $this->settings[$group]->addEntry(new SettingsEntry(
                    $item->getSettingsKey(),
                    $item->getSettingsLabel(),
                    $item->getSettingsValue(),
                    $item->getSettingsType(),
                    $item->getSettingsGroup()
                ));
            }
        }

        return $this->settings;
    }

    protected function loadFromDB()
    {
        return $list = $this->repository->findAll();
    }
}