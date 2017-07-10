<?php

namespace Daikon\Dbal\Migration;

use Daikon\Dbal\Connector\ConnectorInterface;

interface MigrationAdapterInterface
{
    public function read(string $identifier): MigrationList;

    public function write(string $identifier, MigrationList $migrationList): void;

    public function getConnector(): ConnectorInterface;
}
