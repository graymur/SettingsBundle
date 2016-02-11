<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 03.07.14
 * Time: 16:27
 */

namespace Graymur\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="settings", uniqueConstraints={@ORM\UniqueConstraint(name="settings_unique", columns={"settings_key", "settings_group"})})
 */
class SettingsItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $settings_key;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $settings_value;

    /**
     * @ORM\Column(type="string")
     */
    protected $settings_label;

    /**
     * @ORM\Column(type="string", length=255, options={"default" = "default"})
     */
    protected $settings_group;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $settings_type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set settings_key
     *
     * @param string $settingsKey
     * @return SettingsItem
     */
    public function setSettingsKey($settingsKey)
    {
        $this->settings_key = $settingsKey;

        return $this;
    }

    /**
     * Get settings_key
     *
     * @return string 
     */
    public function getSettingsKey()
    {
        return $this->settings_key;
    }

    /**
     * Set settings_value
     *
     * @param string $settingsValue
     * @return SettingsItem
     */
    public function setSettingsValue($settingsValue)
    {
        $this->settings_value = $settingsValue;

        return $this;
    }

    /**
     * Get settings_value
     *
     * @return string 
     */
    public function getSettingsValue()
    {
        return $this->settings_value;
    }

    /**
     * Set settings_label
     *
     * @param string $settingsLabel
     * @return SettingsItem
     */
    public function setSettingsLabel($settingsLabel)
    {
        $this->settings_label = $settingsLabel;

        return $this;
    }

    /**
     * Get settings_label
     *
     * @return string 
     */
    public function getSettingsLabel()
    {
        return $this->settings_label;
    }

    /**
     * Set settings_group
     *
     * @param string $settingsGroup
     * @return SettingsItem
     */
    public function setSettingsGroup($settingsGroup)
    {
        $this->settings_group = $settingsGroup;

        return $this;
    }

    /**
     * Get settings_group
     *
     * @return string 
     */
    public function getSettingsGroup()
    {
        return $this->settings_group;
    }

    /**
     * Set settings_type
     *
     * @param string $settingsType
     * @return SettingsItem
     */
    public function setSettingsType($settingsType)
    {
        $this->settings_type = $settingsType;

        return $this;
    }

    /**
     * Get settings_type
     *
     * @return string 
     */
    public function getSettingsType()
    {
        return $this->settings_type;
    }
}
