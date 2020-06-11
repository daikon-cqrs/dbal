<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Storage;

use Daikon\DataStructure\TypedMap;
use Daikon\ReadModel\Storage\StorageAdapterInterface as ReadModelStorageAdapterInterface;
use Daikon\EventSourcing\EventStore\Storage\StorageAdapterInterface as EventStoreStorageAdapterInterface;

final class StorageAdapterMap extends TypedMap
{
    public function __construct(iterable $storageAdapters = [])
    {
        $this->init(
            $storageAdapters,
            [ReadModelStorageAdapterInterface::class, EventStoreStorageAdapterInterface::class]
        );
    }
}
