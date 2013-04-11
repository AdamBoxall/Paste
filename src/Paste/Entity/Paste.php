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

    public function getSyntaxId()
    {
        return $this->syntax_id;
    }

    public function setSyntaxId($syntax_id)
    {
        $this->syntax_id = $syntax_id;
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

    public function getCreatedFormatted()
    {
        return (new \DateTime($this->created))->format('d/m/Y h:i:s');
    }

    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    public function getExpires()
    {
        return $this->expires;
    }

    public function getExpiresFormatted()
    {
        return (new \DateTime($this->created))->format('d/m/Y h:i:s');
    }

    public function setExpires($expires)
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

        if (isset($row['syntax_id'])) {
            $paste->setSyntaxId($row['syntax_id']);
        }

        if (isset($row['body'])) {
            $paste->setBody($row['body']);
        }

        if (isset($row['created'])) {
            $paste->setCreated($row['created']);
        }

        if (!empty($row['expires'])) {
            $paste->setExpires($row['expires']);
        }

        return $paste;
    }
}