<?php
/**
 * Created by Graymur
 * Date: 09.01.2015
 * Time: 19:52
 */

namespace Graymur\SettingsBundle\Tests\Unit\Loaders\Loader;

use Graymur\SettingsBundle\Loaders\Loader\DefaultLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Yaml\Parser;

class DefaultLoaderTest extends KernelTestCase
{
    protected function loadYmlFixtures()
    {
        $config = [];

        $list = glob(__DIR__ . '/../../../../DataFixtures/yml/*.yml');

        $parser = new Parser();

        foreach ($list as $file)
        {
            $config[] = $parser->parse(file_get_contents($file))['graymur_settings'];
        }

        return $config;
    }

    public function testWrongConfigFormat()
    {
        try
        {
            new DefaultLoader(10);

            $this->assertTrue(false, 'Wrong settings format treated as right');
        }
        catch (\Exception $e)
        {
            $this->assertTrue(true);
        }

        $this->setExpectedException(
            '\\Graymur\\SettingsBundle\\Loaders\\LoaderException', 'Key 0 does not exist in settings array'
        );

        new DefaultLoader(array('key' => 'settings'));

        $this->setExpectedException(
            '\\Graymur\\SettingsBundle\\Loaders\\LoaderException', 'Key 0 should be an array'
        );

        new DefaultLoader(array('settings'));
    }

    public function testProcessSettingsItem()
    {
        $loader = new DefaultLoader($this->loadYmlFixtures());

        // test protected method
        $class = new \ReflectionClass('\\Graymur\\SettingsBundle\\Loaders\\Loader\\DefaultLoader');
        $method = $class->getMethod('processSettingsItem');
        $method->setAccessible(true);

        $processedItem = $method->invokeArgs($loader, ['test', 10]);

        $this->assertEquals($processedItem->getValue(), 10);
        $this->assertEquals($processedItem->getLabel(), 'test');
        $this->assertEquals($processedItem->getType(), 'text');

        $processedItem = $method->invokeArgs($loader, array('test', [
            'value' => 'Some value',
            'label' => 'Item label'
        ]));

        $this->assertEquals($processedItem->getValue(), 'Some value');
        $this->assertEquals($processedItem->getLabel(), 'Item label');
        $this->assertEquals($processedItem->getType(), 'text');
    }

    public function testDoLoad()
    {
        $loader = new DefaultLoader($this->loadYmlFixtures());

        $config = $loader->load();

        $this->assertEquals($config['group_user']->getLabel(), 'User settings');
        $this->assertEquals($config['group_another']->getLabel(), 'group_another');
        $this->assertEquals(count($config['default']->getEntries()), 5);
    }
}