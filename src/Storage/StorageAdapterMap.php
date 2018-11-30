<?php
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\Dbal\Storage;

use Daikon\DataStructure\TypedMapTrait;
use Daikon\ReadModel\Storage\StorageAdapterInterface as ReadModelStorageAdapterInterface;
use Daikon\EventSourcing\EventStore\Storage\StorageAdapterInterface as EventStoreStorageAdapterInterface;

final class StorageAdapterMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $storageAdapters = [])
    {
        $this->init(
            $storageAdapters,
            [ReadModelStorageAdapterInterface::class, EventStoreStorageAdapterInterface::class]
        );
    }
}
