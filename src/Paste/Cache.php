<?php

namespace Paste;

use Memcache;
use Paste\Exception\MemcacheUnavailableException;
use Paste\Entity\Paste;

class Cache
{
    protected $memcache;

    public function __construct($host, $port)
    {
        if (!class_exists('Memcache')) {
            throw new MemcacheUnavailableException(
                'Memcache class does not exist'
            );
        }

        $this->connect($host, $port);
    }

    protected function connect($host, $port)
    {
        $this->memcache = new Memcache;

        if (!$this->memcache->connect($host, $port)) {
            throw new MemcacheUnavailableException(
                'Unable to connect to host [' . $host . '] with port [' . $port . ']'
            );
        }

        return $this;
    }

    public function getPaste($pasteId)
    {
        return $this->memcache->get('paste.' . $pasteId);
    }

    public function setPaste(Paste $paste)
    {
        // Store as "paste.<id>" for five minutes
        $this->memcache->set('paste.' . $paste->getId(), $paste, false, 300);

        return $this;
    }

    public function getLatestPastes()
    {
        return $this->memcache->get('paste.latest');
    }

    public function setLatestPastes(array $latest)
    {
        // Store as "paste.latest" for one minute
        $this->memcache->set('paste.latest', $latest, false, 60);

        return $this;
    }

    public function getPasteCount()
    {
        return $this->memcache->get('paste.count');
    }

    public function setPasteCount($count)
    {
        // Store as "paste.count" for one minute
        $this->memcache->set('paste.count', $count, false, 60);
    }

    public function getSyntaxList()
    {
        return $this->memcache->get('paste.syntaxlist');
    }

    public function setSyntaxList(array $syntaxList)
    {
        // Store as "paste.syntaxlist" for ten minutes
        $this->memcache->set('paste.syntaxlist', $syntaxList, false, 600);

        return $this;
    }
}