<?php

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedMapTrait;

final class MigrationLoaderMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(iterable $migrationLoaders = [])
    {
        $this->init($migrationLoaders, MigrationLoaderInterface::class);
    }
}
