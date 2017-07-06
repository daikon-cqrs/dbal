<?php

namespace Daikon\Dbal\Repository;

use Daikon\DataStructures\TypedMapTrait;

final class RepositoryMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $repositories = [])
    {
        $this->init($repositories, RepositoryInterface::class);
    }
}
