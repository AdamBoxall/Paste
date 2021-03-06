<?php

namespace Paste\Entity;

use Paste\Entity\Syntax;
use Paste\GeSHi\Proxy;

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
            return 'Mysterious';
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

    public function getBodyFormatted()
    {
        return (new Proxy)->parse($this->body, $this->syntax->getName());
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
        return $this->getRelativeDateTime($this->created);
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

    public function hasExpired()
    {
        if ($this->expires === null
         || $this->expires > time()) {
            return false;
        }

        return true;
    }

    public function getExpiresFormatted()
    {
        return $this->getRelativeDateTime($this->expires);
    }

    public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }

    protected function getRelativeDateTime($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1) {
            return '0 seconds ago';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
                    );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }

    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'title'     => $this->getTitle(),
            'syntax_id' => $this->getSyntaxId(),
            'body'      => $this->getBody(),
            'created'   => $this->getCreated(),
            'expires'   => $this->getExpires()
        ];
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