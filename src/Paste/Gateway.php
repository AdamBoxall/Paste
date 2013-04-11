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

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    public function getPaste($id)
    {
        $paste = $this->getPasteRepository()->findById($id);

        if (!$paste) {
            throw new PasteNotFoundException(
                'Unable to find paste with ID: ' . $id
            );
        }

        return $paste;
    }

    public function getLatestPastes()
    {
        return $this->getPasteRepository()->findLatest(10);
    }

    public function getSyntaxList()
    {
        return $this->getSyntaxRepository()->findAll();
    }

    public function createPaste(Paste $paste)
    {
        return $this->getPasteRepository()->create($paste);
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
        // Lazy-lad the syntax repository
        if ($this->syntaxRepository === null) {
            $this->syntaxRepository = new Syntaxes($this->adapter);
        }

        return $this->syntaxRepository;
    }
}