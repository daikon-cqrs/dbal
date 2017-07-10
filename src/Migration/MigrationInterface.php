<?php

namespace Daikon\Dbal\Migration;

use Daikon\Dbal\Connector\ConnectorInterface;

interface MigrationInterface
{
    const MIGRATE_UP = 'up';

    const MIGRATE_DOWN = 'down';

    public function getName(): string;

    public function getVersion(): int;

    public function getDescription(string $direction = self::MIGRATE_UP): string;

    public function isReversible(): bool;

    public function hasExecuted(): bool;

    public function toArray(): array;

    public function execute(ConnectorInterface $connector, string $direction = self::MIGRATE_UP): void;
}
