<?php

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedMapTrait;

final class MigrationTargetMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(iterable $migrationTargets = [])
    {
        $this->init($migrationTargets, MigrationTargetInterface::class);
    }

    public function getEnabledTargets(): self
    {
        return new self(
            $this->compositeMap->filter(
                function (string $migrationName, MigrationTargetInterface $migrationTarget): bool {
                    return $migrationTarget->isEnabled();
                }
            )
        );
    }
}
