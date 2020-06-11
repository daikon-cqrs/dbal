<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedList;
use Daikon\Interop\ToNativeInterface;

final class MigrationList extends TypedList implements ToNativeInterface
{
    public function __construct(iterable $migrations = [])
    {
        $this->init($migrations, [MigrationInterface::class]);
    }

    public function exclude(self $migrationList): self
    {
        return $this->filter(
            fn(MigrationInterface $migration): bool => !$migrationList->contains($migration)
        );
    }

    public function getPendingMigrations(): self
    {
        return $this->filter(
            fn(MigrationInterface $migration): bool => !$migration->hasExecuted()
        );
    }

    public function getExecutedMigrations(): self
    {
        return $this->filter(
            fn(MigrationInterface $migration): bool => $migration->hasExecuted()
        );
    }

    public function contains(MigrationInterface $migration): bool
    {
        return $this->reduce(
            function (bool $carry, MigrationInterface $item) use ($migration): bool {
                return $carry
                    || $item->getName() === $migration->getName()
                    && $item->getVersion() === $migration->getVersion();
            },
            false
        );
    }

    public function sortByVersion(): self
    {
        return $this->sort(
            fn(MigrationInterface $a, MigrationInterface $b): int => $a->getVersion() - $b->getVersion()
        );
    }

    public function findBeforeVersion(int $version = null): self
    {
        return $this->filter(
            fn(MigrationInterface $migration): bool => !$version || $migration->getVersion() <= $version
        );
    }

    public function findAfterVersion(int $version = null): self
    {
        return $this->filter(
            fn(MigrationInterface $migration): bool => !$version || $migration->getVersion() > $version
        );
    }

    public function toNative()
    {
        $migrations = [];
        foreach ($this as $migration) {
            $migrations[] = $migration->toNative();
        }
        return $migrations;
    }
}
