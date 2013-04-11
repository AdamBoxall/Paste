<?php

namespace Paste\Entity;

use Paste\Entity\Syntax;

class Paste
{
    protected $id;
    protected $title;
    protected $syntax_id;
    protected $syntax;
    protected $body;
    protected $created;
    protected $expires;

    public function getId()
    {
        return $this->id;
    }

    public function getHexId()
    {
        return dechex($this->id);
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getNormalisedTitle()
    {
        if ($this->title === null) {
            return 'Untitled';
        }

        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getSyntax()
    {
        return $this->syntax;
    }

    public function setSyntax(Syntax $syntax)
    {
        $this->syntax = $syntax;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getCreatedDisplay()
    {
        return $this->created->format('d/m/Y');
    }

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    public function getExpires()
    {
        return new DateTime($this->expires);
    }

    public function setExpires(\DateTime $expires)
    {
        $this->expires = $expires;
        return $this;
    }

    public static function fromArray(array $row)
    {
        $paste = new static;

        if (isset($row['id'])) {
            $paste->setId($row['id']);
        }

        if (!empty($row['title'])) {
            $paste->setTitle($row['title']);
        }

        if (isset($row['body'])) {
            $paste->setBody($row['body']);
        }

        if (isset($row['created'])) {
            $paste->setCreated(new \DateTime($row['created']));
        }

        if (!empty($row['expires'])) {
            $paste->setExpires(new \DateTime($row['expires']));
        }

        return $paste;
    }
}