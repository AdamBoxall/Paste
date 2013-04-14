<?php

namespace Paste\Entity\Repository;

use Paste\Entity\Repository\AbstractRepository;
use Paste\Entity\Paste;
use Paste\Entity\Syntax;

class Pastes extends AbstractRepository
{
    protected $fields = "
        p.id as p_id,
        p.title as p_title,
        p.syntax_id as p_syntax_id,
        p.body as p_body,
        p.created as p_created,
        p.expires as p_expires,
        s.id as s_id,
        s.name as s_name,
        s.display_name as s_display_name
    ";

    public function findById($id)
    {
        $paste = $this->adapter->fetchAssoc("
            select {$this->fields}
            from pastes p
            join syntaxes s on (
                p.syntax_id = s.id
            )
            where p.id= ?
        ", array(
            $id
        ));

        if ($paste) {
            return $this->createModel($paste);
        }
    }

    public function findLatest($limit)
    {
        $pastes = $this->adapter->fetchAll("
            select {$this->fields}
            from pastes p
            join syntaxes s on (
                p.syntax_id = s.id
            )
            where (p.expires is null or p.expires > unix_timestamp())
            order by p.created desc
            limit {$limit}
        ");

        if (!empty($pastes)) {
            return $this->createModels($pastes);
        }
    }

    public function count()
    {
        return $this->adapter->fetchColumn("
            select count(id) as count from pastes
        ");
    }

    public function create(Paste $paste)
    {
        $this->adapter->insert('pastes', [
            'id'        => $paste->getId(),
            'title'     => $paste->getTitle(),
            'syntax_id' => $paste->getSyntaxId(),
            'body'      => $paste->getBody(),
            'created'   => time(),
            'expires'   => $paste->getExpires()
        ]);
    }

    protected function createModel(array &$row)
    {
        $paste = Paste::fromArray([
            'id'        => $row['p_id'],
            'title'     => $row['p_title'],
            'syntax_id' => $row['p_syntax_id'],
            'body'      => $row['p_body'],
            'created'   => $row['p_created'],
            'expires'   => $row['p_expires']
        ]);

        $syntax = Syntax::fromArray([
            'id'           => $row['s_id'],
            'name'         => $row['s_name'],
            'display_name' => $row['s_display_name']
        ]);

        return $paste->setSyntax($syntax);
    }
}