<?php
/**
 * Created by Graymur
 * Date: 09.01.2015
 * Time: 19:52
 */

namespace Graymur\SettingsBundle\Tests\Unit\Loaders\Loader;

use Graymur\SettingsBundle\Loaders\Loader\DoctrineLoader;
use Graymur\SettingsBundle\DataFixtures\ORM\LoadSettingsData;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Config\Definition\Exception\Exception;

class DoctrineLoaderTest extends KernelTestCase
{
    protected function setUp()
    {
        self::$kernel->boot();

        $fixture = new LoadSettingsData();
        $fixture->load($this->getDoctrine()->getManager());
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrine()
    {
        return self::$kernel->getContainer()->get('doctrine');
    }

    /**
     * @return DoctrineLoader
     */
    protected function getLoader()
    {
        return new DoctrineLoader($this->getDoctrine()->getRepository('GraymurSettingsBundle:SettingsItem'));
    }

    public function testLoadFromDB()
    {
        $loader = $this->getLoader();
        $config = $loader->load();

        $this->assertEquals(count($config['default']->getEntries()), 2);
        $this->assertEquals($config['group_other']->getLabel(), 'group_other');
        $this->assertEquals(count($config['group_other']->getEntries()), 1);
    }

    protected function tearDown()
    {
        $purger = new ORMPurger($this->getDoctrine()->getManager());
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $purger->purge();

        parent::tearDown();
    }
}