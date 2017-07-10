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

    public function getEnabledTargets()
    {
        return new self(
            $this->compositeMap->filter(function ($migrationName, $migrationTarget) {
                return $migrationTarget->isEnabled();
            })
        );
    }
}
