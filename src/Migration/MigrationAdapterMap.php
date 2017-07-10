<?php

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedMapTrait;

final class MigrationAdapterMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(iterable $migrationAdapters = [])
    {
        $this->init($migrationAdapters, MigrationAdapterInterface::class);
    }
}
