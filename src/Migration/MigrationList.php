<?php
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedListTrait;
use Daikon\Interop\ToNativeInterface;

final class MigrationList implements \IteratorAggregate, \Countable, ToNativeInterface
{
    use TypedListTrait;

    public function __construct(iterable $migrations = [])
    {
        $this->init($migrations, MigrationInterface::class);
    }

    public function diff(self $migrationList): self
    {
        return new self(
            $this->compositeVector->filter(
                function (MigrationInterface $migration) use ($migrationList): bool {
                    return !$migrationList->containsVersion($migration->getVersion());
                }
            )
        );
    }

    public function merge(self $migrationList): self
    {
        return new self($this->compositeVector->merge($migrationList));
    }

    public function getPendingMigrations(): self
    {
        return new self(
            $this->compositeVector->filter(
                function (MigrationInterface $migration): bool {
                    return !$migration->hasExecuted();
                }
            )
        );
    }

    public function getExecutedMigrations(): self
    {
        return new self(
            $this->compositeVector->filter(
                function (MigrationInterface $migration): bool {
                    return $migration->hasExecuted();
                }
            )
        );
    }

    public function toNative(): array
    {
        $migrations = [];
        foreach ($this as $migration) {
            $migrations[] = $migration->toNative();
        }
        return $migrations;
    }

    public function containsVersion(int $version): bool
    {
        return $this->compositeVector->filter(
            function (MigrationInterface $migration) use ($version): bool {
                return $migration->getVersion() === $version;
            }
        )->count() === 1;
    }

    public function sortByVersion(): self
    {
        $copy = clone $this;
        $copy->compositeVector->sort(
            function (MigrationInterface $a, MigrationInterface $b): int {
                return $a->getVersion() - $b->getVersion();
            }
        );
        return $copy;
    }
}
