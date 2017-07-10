<?php

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedListTrait;

final class MigrationList implements \IteratorAggregate, \Countable
{
    use TypedListTrait;

    public function __construct(iterable $migrations = [])
    {
        $this->init($migrations, MigrationInterface::class);
    }

    public function diff(self $migrationList)
    {
        return new self(
            $this->compositeVector->filter(function ($migration) use ($migrationList) {
                return !$migrationList->containsVersion($migration->getVersion());
            })
        );
    }

    public function merge(self $migrationList): self
    {
        return new self($this->compositeVector->merge($migrationList));
    }

    public function getPendingMigrations()
    {
        return new self(
            $this->compositeVector->filter(function ($migration) {
                return !$migration->hasExecuted();
            })
        );
    }

    public function getExecutedMigrations()
    {
        return new self(
            $this->compositeVector->filter(function ($migration) {
                return $migration->hasExecuted();
            })
        );
    }

    public function toArray(): array
    {
        $migrations = [];
        foreach ($this as $migration) {
            $migrations[] = $migration->toArray();
        }
        return $migrations;
    }

    public function containsVersion(int $version): bool
    {
        return $this->compositeVector->filter(function ($migration) use ($version) {
            return $migration->getVersion() === $version;
        })->count() === 1;
    }
}
