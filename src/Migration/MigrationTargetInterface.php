<?php

namespace Daikon\Dbal\Migration;

interface MigrationTargetInterface
{
    public function getName(): string;

    public function isEnabled(): bool;

    public function getMigrationList(): MigrationList;

    public function migrate(string $direction, int $version = null): MigrationList;
}
