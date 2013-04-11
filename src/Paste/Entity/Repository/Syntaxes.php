<?php

namespace Paste\Entity\Repository;

use Paste\Entity\Repository\AbstractRepository;
use Paste\Entity\Syntax;

class Syntaxes extends AbstractRepository
{
    public function findAll()
    {
        $syntaxes = $this->adapter->fetchAll("
            select id, name, display_name
            from syntaxes s
            order by s.name asc
        ");

        if (!empty($syntaxes)) {
            return $this->createModels($syntaxes);
        }
    }

    protected function createModel(array &$row)
    {
        return Syntax::fromArray($row);
    }
}