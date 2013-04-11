<?php

namespace Paste\Entity;

class Syntax
{
    protected $id;
    protected $name;
    protected $display_name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->display_name;
    }

    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
        return $this;
    }

    public static function fromArray($row)
    {
        $syntax = new static;

        if (isset($row['id'])) {
            $syntax->setId($row['id']);
        }

        if (isset($row['name'])) {
            $syntax->setName($row['name']);
        }

        if (isset($row['display_name'])) {
            $syntax->setDisplayName($row['display_name']);
        }

        return $syntax;
    }
}