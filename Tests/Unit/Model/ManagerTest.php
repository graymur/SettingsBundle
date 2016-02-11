<?php
/**
 * Created by Graymur
 * Date: 09.01.2015
 * Time: 19:52
 */

namespace Graymur\SettingsBundle\Tests\Unit\Model;

use Graymur\SettingsBundle\Model\Manager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManagerTest extends KernelTestCase
{
    public function testLoad()
    {
        $manager = new Manager();

        self::$kernel->boot();
        $manager->setContainer(self::$kernel->getContainer());

        $this->assertEquals($manager->getValue('admin_panel_title'), 'Test site');
        $this->assertEquals($manager->getValue('another_group_setting', 'group_another'), 'Another group setting value');
    }
}