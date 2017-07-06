<?php

namespace Daikon\Dbal\Repository;

use Daikon\Dbal\Projection\ProjectionInterface;
use Daikon\Dbal\Projection\ProjectionMap;

interface RepositoryInterface
{
    public function findById(string $identifier): ProjectionInterface;

    public function findByIds(array $identifiers): ProjectionMap;

    public function persist(ProjectionInterface $projection): bool;

    public function makeProjection(): ProjectionInterface;
}
