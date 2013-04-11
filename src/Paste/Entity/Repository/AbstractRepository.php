<?php

namespace Paste\Entity\Repository;

use Doctrine\DBAL\Connection;

abstract class AbstractRepository
{
    public function __construct(Connection $adapter)
    {
        $this->adapter = $adapter;
    }

    protected function createModels(array &$rows)
    {
        $models = [];

        foreach ($rows as &$row) {
            $models[] = $this->createModel($row);
        }

        return $models;
    }

    abstract protected function createModel(array &$row);
}