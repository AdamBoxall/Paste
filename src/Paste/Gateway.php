<?php

namespace Paste;

use Doctrine\DBAL\Connection;
use Paste\Entity\Paste;
use Paste\Entity\Syntax;
use Paste\Entity\Repository\Pastes;
use Paste\Entity\Repository\Syntaxes;
use Paste\Exception\PasteNotFoundException;

class Gateway
{
    protected $adapter;
    protected $pasteRepository;
    protected $syntaxRepository;
    protected $cache;

    public function __construct($adapter, $cache)
    {
        $this->adapter = $adapter;
        $this->cache = $cache;
    }

    public function getPaste($id)
    {
        // Try to load paste from cache
        $paste = $this->cache->getPaste($id);

        if (!$paste) {
            // Read paste from database and store for next time
            $paste = $this->getPasteRepository()->findById($id);
            $this->cache->setPaste($paste);
        }

        if (!$paste) {
            // Throw an exception if we still don't have a paste
            throw new PasteNotFoundException(
                'Unable to find paste with ID: ' . $id
            );
        }

        return $paste;
    }

    public function getLatestPastes()
    {
        // Try to load latest from cache
        $latest = $this->cache->getLatestPastes();

        if (!$latest) {
            // Read list from database and store for next time
            $latest = $this->getPasteRepository()->findLatest(8);
            $this->cache->setLatestPastes($latest);
        }

        return $latest;
    }

    public function getSyntaxList()
    {
        // Try to load list from cache
        $syntaxList = $this->cache->getSyntaxList();

        if (!$syntaxList) {
            // Read list from database and store for next time
            $syntaxList = $this->getSyntaxRepository()->findAll();
            $this->cache->setSyntaxList($syntaxList);
        }

        return $syntaxList;
    }

    public function createPaste(Paste $paste)
    {
        return $this->getPasteRepository()->create($paste);
    }

    public function getPasteCount()
    {
        // Try to load from cache
        $count = $this->cache->getPasteCount();

        if (!$count) {
            // Read count from database and store for next time
            $count = $this->getPasteRepository()->count();
            $this->cache->setPasteCount($count);
        }

        return $count;
    }

    protected function getPasteRepository()
    {
        // Lazy-load the paste repository
        if ($this->pasteRepository === null) {
            $this->pasteRepository = new Pastes($this->adapter);
        }

        return $this->pasteRepository;
    }

    protected function getSyntaxRepository()
    {
        // Lazy-load the syntax repository
        if ($this->syntaxRepository === null) {
            $this->syntaxRepository = new Syntaxes($this->adapter);
        }

        return $this->syntaxRepository;
    }
}