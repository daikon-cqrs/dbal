<?php

namespace Daikon\Dbal\Storage;

use Daikon\DataStructures\TypedMapTrait;

final class StorageAdapterMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $storageAdapters = [])
    {
        $this->init($storageAdapters, StorageAdapterInterface::class);
    }
}
