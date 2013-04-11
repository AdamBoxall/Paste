<?php

namespace Paste\Entity\Repository;

use Paste\Entity\Repository\AbstractRepository;
use Paste\Entity\Syntax;

class Syntaxes extends AbstractRepository
{
    protected $fields = "
        id as s_id,
        name as s_name,
        display_name as s_display_name
    ";

    public function findAll()
    {
        $syntaxes = $this->adapter->fetchAll("
            select {$this->fields}
            from syntaxes s
            order by s.name asc
        ");

        if (!empty($syntaxes)) {
            return $this->createModels($syntaxes);
        }
    }

    protected function createModel(array &$row)
    {
        $syntax = Syntax::fromArray([
            'id'           => $row['s_id'],
            'name'         => $row['s_name'],
            'display_name' => $row['s_display_name']
        ]);

        return $syntax;
    }
}