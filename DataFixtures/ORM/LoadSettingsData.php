<?php
/**
 * Created by Graymur
 * Date: 13.01.2015
 * Time: 15:42
 */

namespace Graymur\SettingsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Graymur\SettingsBundle\Entity\SettingsItem;

class LoadSettingsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $item1 = new SettingsItem();
        $item1->setSettingsGroup('default');
        $item1->setSettingsKey('test_1_key');
        $item1->setSettingsLabel('Test 1 label');
        $item1->setSettingsValue('Test 1 value');
        $item1->setSettingsType('text');

        $manager->persist($item1);

        $item2 = new SettingsItem();
        $item2->setSettingsGroup('default');
        $item2->setSettingsKey('test_2_key');
        $item2->setSettingsLabel('Test 2 label');
        $item2->setSettingsValue('Test 2 value');
        $item2->setSettingsType('text');

        $manager->persist($item2);

        $item3 = new SettingsItem();
        $item3->setSettingsGroup('group_other');
        $item3->setSettingsKey('group_other_2_key');
        $item3->setSettingsLabel('Test group_other 1 label');
        $item3->setSettingsValue('Test group_other 2 value');
        $item3->setSettingsType('text');

        $manager->persist($item3);

        $manager->flush();
    }
}