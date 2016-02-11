<?php
/**
 * Created by Graymur
 * Date: 10.01.2015
 * Time: 13:44
 */

namespace Graymur\SettingsBundle\Model;

class SettingsEntry
{
    protected $key;
    protected $label;
    protected $value;
    protected $type;
    protected $group;

    public function __construct($key, $label, $value, $type, $group = null)
    {
        $this->key = (string) $key;
        $this->label = (string) $label;
        $this->value = (string) $value;
        $this->type = (string) $type;
        $this->group = (string) $group;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getGroup()
    {
        return $this->group;
    }
}